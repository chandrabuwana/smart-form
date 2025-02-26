<?php

namespace Modules\SmartForm\App\Http\Controllers\SHE;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Barryvdh\DomPDF\Facade\Pdf;

class AparController extends Controller {

    public function download() {
        $pdf = Pdf::loadView('pdf');
 
        return $pdf->download();
    }

    public function inspeksiAparDashboard()
    {
        return view('SmartForm::she/inspeksi-apar/inspeksi-apar');
    }
    function GetListInspeksiApar(Request $request) {
        $TABLE_MASTER = "FM_SHE_036_INSPEKSI_APAR";
        $response = array(
            'message' => '',
            'isSuccess' => false
        );

        $sort = $request->query('sort', 'id'); // Default sort by id
        $order = $request->query('order', 'desc'); // Default order is ascending
        $offset = $request->query('offset', 0); // Default offset
        $limit = $request->query('limit', null); // Default limit
        $filter = $request->query('filter', null); // Default limit
        try {
            $master = DB::table($TABLE_MASTER)
                ->select('id', 'no_dok', 'lokasi_inspeksi as lokasi', 'dibuat_oleh as dibuat','tanggal as tgl');
            
            $master->orderBy($sort, $order);
            $jml = $master->count();            
            $document = $master->get();

            $response['message'] = "Ok";
            $response['isSuccess'] = true;
            $response['data'] = [
                'total' => $jml,
                'totalNotFiltered' => $jml,
                'rows' => $document
            ];

        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            
            $response['message'] = $ex->getMessage();
            $response['isSuccess'] = false;
        }

        return response()->json($response);
    }

    function formInspeksiApar() {
        return view("SmartForm::she/inspeksi-apar/form-inspeksi-apar");
    }

    function SubmitFormInspeksiApar(Request $req) {
        $TABLE_MASTER = "FM_SHE_036_INSPEKSI_APAR";
        $TABLE_DETAIL = "FM_SHE_036_INSPEKSI_APAR_DETAIL";
        $response = array(
            'message' => "",
            'isSuccess' => false
        );
        $tgl = now()->toDateTimeString();
        $requested_by = $req->session()->get('user_id');
        $data = $req->input();
        
        $data_insert = [
            'dibuat_oleh' => $requested_by,
            'lokasi_inspeksi' => $data['lok1'],
            // 'no_dok' => $data['noDoc'],
            'no_dok' => "BSS-FRM-SHE-036",
            'revisi' => "01",
            'tanggal' => "26 November 2022",
            'halaman' => "1 dari 2",
            'catatan' => $data['catatan']
        ];
        $spliited_no_doc = explode("/", $data_insert['no_dok']);
        $data_item = json_decode($data['item']);
        
        try {
            DB::beginTransaction();
            $id = DB::table($TABLE_MASTER)->insertGetId($data_insert);

            foreach ($data_item as $data_item_detail) {
                DB::table($TABLE_DETAIL)->insert(array(
                    'id_inspeksi_apar' => $id,
                    'lokasi_apar' => $data_item_detail->lok2,
                    'jenis_apar' => $data_item_detail->jenis,
                    'tekanan_tabung' => $data_item_detail->tekananTab,
                    'tabung' => $data_item_detail->tabung1,
                    'handle' => $data_item_detail->handle,
                    'selang' => $data_item_detail->selang,
                    'label_tabung' => $data_item_detail->label,
                    'label_kartu' => $data_item_detail->tabung2,
                    'berlaku_sampai' => $data_item_detail->tglBerlaku,
                    'berat_apar' => $data_item_detail->berat,
                    'metode_pemenuhan' => $data_item_detail->metode,
                    'tanggal' => $data_item_detail->tanggal,
                    'pic' => $data_item_detail->pic,
                    'keterangan' => $data_item_detail->ket
                ));
            }

            $spliited_no_doc[0] = $id;
            $updated_no_doc = implode("/", $spliited_no_doc);

            $affected = DB::table($TABLE_MASTER)
              ->where('id', $id)
              ->update(['no_dok' => $updated_no_doc]);

            Db::commit();


            $response['message'] = "Ok";
            $response['isSuccess'] = true;
            $response['data'] = array(
                'no_doc' => $updated_no_doc
            );
        } catch (Exception $ex) {
            //throw $th;
            Log::error($ex->getTraceAsString());
            DB::rollBack();
            $response['message'] = $ex->getMessage();
            $response['isSuccess'] = false;
        }

        return response()->json($response);
    }

    public function PdfInspeksiApar($id)
    {
        $TABLE_MASTER = "FM_SHE_036_INSPEKSI_APAR";
        $TABLE_DETAIL = "FM_SHE_036_INSPEKSI_APAR_DETAIL";
        $errors = array(
            'error' => false,
            'message' => ''
        );
        try {
            $data = DB::table($TABLE_MASTER)
                    ->select('id','tanggal as tgl','lokasi_inspeksi as lok1','dibuat_oleh as dibuat','diketahui_oleh as mengetahui','disetujui_oleh as approval','catatan')
                    ->where('id', $id)
                    ->first();
                
            $data_detail = DB::table($TABLE_DETAIL)
                ->select('id_inspeksi_apar','lokasi_apar as lok2','jenis_apar as jenis','berat_apar as berat','tekanan_tabung as tekanan','tabung','handle','label_tabung as label','selang','label_kartu','berlaku_sampai as berlaku','metode_pemenuhan as metode','pic','tanggal','keterangan')
                ->where('id_inspeksi_apar', $data->id)
                ->get();
            
            $nomor = 1;
            foreach($data_detail as $detail) {
                $detail->nomor = $nomor;            
                $nomor++;
            }
        // DB => data variable
            $data_master['id'] = $data->id;
            $data_master['tgl'] = $data->tgl;
            $data_master['dibuat'] = $data->dibuat;
            $data_master['mengetahui'] = $data->mengetahui;
            $data_master['lok1'] = $data->lok1;
            $data_master['catatan'] = $data->catatan;
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
        }
        Log::info("data_master : ". json_encode($data_master));
        $pdf = PDF::loadView('SmartForm::she/inspeksi-apar/inspeksi-apar-pdf',  ['data' => $data_master, 'data_detail' => $data_detail, 'error' => $errors])->setPaper('a4', 'landscape');
        return $pdf->download('BSS-FRM-SHE-036.pdf');
    }
}
