<?php

namespace Modules\SmartForm\App\Http\Controllers\LOG;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Barryvdh\DomPDF\Facade\Pdf;
use Modules\SmartForm\helpers\HrdHelper;

class LogController extends Controller {


    private const TABLE_MASTER = 'FM_LOG_002_REQUESTER_MASTER';
    private const TABLE_DETAIL = 'FM_LOG_002_REQUESTER_MASTER_DETAIL';

    public function download() {
        $pdf = Pdf::loadView('pdf');
 
        return $pdf->download();
    }

    // ***** START PENGELUARAN OLI *****
    public function PengeluaranOliDashboard()
    {
        return view('SmartForm::LOG/pengeluaran-oli');
    }

    function GetListPengeluaranOli(Request $request) {
        $TABLE_PENGELUARAN_OLI = "FM_LOG_034_PENGELUARAN_OLI";
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
            $master = DB::table($TABLE_PENGELUARAN_OLI)
                ->select('id', 'no_dok', 'job_site as site', 'dilaporkan_oleh','no_lube_station as lube');
            
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

    function formPengeluaranOli() {
        return view("SmartForm::LOG/form-pengeluaran-oli");
    }

    function SubmitFormPengeluaranOli(Request $req) {
        $TABLE_MASTER = "FM_LOG_034_PENGELUARAN_OLI";
        $TABLE_DETAIL = "FM_LOG_034_PENGELUARAN_OLI_DETAIL";
        $response = array(
            'message' => "",
            'isSuccess' => false
        );
        $tgl = now()->toDateTimeString();
        $requested_by = $req->session()->get('user_id');
        $data = $req->input();
        
        $data_insert = [
            'dilaporkan_oleh' => $requested_by,
            'job_site' => $data['jobSite'],
            // 'no_dok' => $data['noDoc'],
            'no_dok' => "BSS-FRM-LOG-034",
            'revisi' => "1",
            // 'tanggal' => $data['tglDoc'],
            'tanggal' => "7 Agustus 2024",
            'halaman' => "1 dari 1",
            'no_lube_station' => $data['lube'],
            'shift' => $data['shift'],
            'diketahui_oleh' => $data['foreman']
        ];
        $spliited_no_doc = explode("/", $data_insert['no_dok']);
        $data_item = json_decode($data['item']);
        
        try {
            DB::beginTransaction();
            $id = DB::table($TABLE_MASTER)->insertGetId($data_insert);

            foreach ($data_item as $data_item_detail) {
                DB::table($TABLE_DETAIL)->insert(array(
                    'id_peng_oli' => $id,
                    'unit' => $data_item_detail->unit,
                    'time' => $data_item_detail->time,
                    'hm' => $data_item_detail->hm,
                    'jenis' => $data_item_detail->jenis,
                    'merk' => $data_item_detail->merk,
                    'awal' => $data_item_detail->awal,
                    'akhir' => $data_item_detail->akhir,
                    'qty' => $data_item_detail->qty,
                    'component' => $data_item_detail->compo,
                    'remark' => $data_item_detail->remark,
                    'pic_nama' => $data_item_detail->pic
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

    public function PdfPengeluaranOli($id)
    {
        $TABLE_MASTER = "FM_LOG_034_PENGELUARAN_OLI";
        $TABLE_DETAIL = "FM_LOG_034_PENGELUARAN_OLI_DETAIL";
        $errors = array(
            'error' => false,
            'message' => ''
        );
        try {
            $data = DB::table($TABLE_MASTER)
                    ->select('id', 'no_dok','revisi','tanggal','job_site as jobsite','no_lube_station as nolube','shift','dilaporkan_oleh as pelapor','diketahui_oleh as mengetahui')
                    ->where('id', $id)
                    ->first();
                
            $data_detail = DB::table($TABLE_DETAIL)
                ->select('id_peng_oli','unit','time','hm','jenis','merk','awal','akhir','qty','component','remark','pic_nama as pic')
                ->where('id_peng_oli', $data->id)
                ->get();
            
            $nomor = 1;
            foreach($data_detail as $detail) {
                $detail->nomor = $nomor;            
                $nomor++;
            }
        
            $data_master['id'] = $data->id;
            $data_master['no_dok'] = $data->no_dok;
            $data_master['jobsite'] = $data->jobsite;
            $data_master['tanggal'] = $data->tanggal;
            $data_master['pelapor'] = $data->pelapor;
            $data_master['mengetahui'] = $data->mengetahui;
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
        }
        Log::info("data_master : ". json_encode($data_master));
        $pdf = PDF::loadView('SmartForm::LOG/pengeluaran-oli-pdf',  ['data' => $data_master, 'data_detail' => $data_detail, 'error' => $errors])->setPaper('a4', 'landscape');
        return $pdf->download('BSS-FRM-LOG-034.pdf');
    }
    // ***** END PENGELUARAN OLI *****

}
