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

class InspeksiCateringController extends Controller {

    public function download() {
        $pdf = Pdf::loadView('pdf');
 
        return $pdf->download();
    }

    public function InspeksiCateringDashboard()
    {
        return view('SmartForm::she/inspeksi-catering/inspeksi-catering');
    }

    function GetListInspeksiCatering(Request $request) {
        $TABLE_MASTER = "FM_SHE_048_INSPEKSI_CATERING";
        $response = array(
            'message' => '',
            'isSuccess' => false
        );
        $filterTanggal = $request->query('tanggal', null);
        $filterSite = $request->query('site', null);
        $filterNik = $request->query('nama', null);
        $filterStatus = $request->query('status', null);
        $search = $request->query('search', '');
        $sort = $request->query('sort', 'id'); // Default sort by id
        $order = $request->query('order', 'desc');
        $offset = $request->query('offset', 0); // Default offset
        $limit = $request->query('limit', null); // Default limit
        $filter = $request->query('filter', null); // Default limit
        try {
            $master = DB::table($TABLE_MASTER)
                ->select('id', 'lokasi_kerja as loker');
            
            if($filterTanggal == null || $filterTanggal == 'null') {
            } else {
                $tgl = Carbon::createFromFormat('Y-m-d', $filterTanggal);
                $master->whereDate('tanggal', $tgl);
            }
            if($filterSite == null || $filterSite == 'null') {
            } else {
                $master->where('site', $filterSite);
            }
            if($filterNik == null || $filterNik == 'null') {
            } else {
                $master->where('nik', $filterNik);
            }
            if($filterStatus == null || $filterStatus == 'null') {
            } else {
                $master->where('status', $filterStatus);
            }
            $master->orderBy($sort, $order);
            // Log::debug("SQL : ".$master->toRawSql());
            $jml = $master->count();
            if($limit == null || $limit == 'null' || $limit == '') {
                $master->skip($offset);
            } else {
                $master->skip($offset)->limit($limit);
            }
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

    function FormInspeksiCatering() {
        return view("SmartForm::she/inspeksi-catering/form-inspeksi-catering");
    }
    
    public function CreateInspeksiCatering(Request $request)
    {
        DB::beginTransaction();
        $requestData = $request->all();

        // $dataKaryawan = DB::connection('sqlsrv2')->select("SELECT nik FROM TKaryawan");
        $dataKaryawan = DB::table('FM_SHE_048_INSPEKSI_CATERING');
        return view('SmartForm::she/inspeksi-catering/form-inspeksi-catering', compact('dataKaryawan'));

        try {
            DB::table('FM_SHE_048_INSPEKSI_CATERING')->insert([
                // 'no' => $number,
                // 'nama' => session("username"),
                'no_dok' => "BSS-FRM-SHE-048",
                'revisi' => "00",
                'tanggal' => "23 November 2021",
                'halaman' => "1 dari 3",
                // 'nik' => session("user_id"),
                'nama_site' =>  $requestData['tNamaSite'],
                'department' =>  $requestData['dDept'],
                'shift' =>  $requestData['dShift'],
                'lokasi_kerja' =>  $requestData['tLoker'],
                'jumlah_inspektor' =>  $requestData['tJmlIns'],

                'q_penerimaan_1' =>  $requestData['tA1'],
                'q_penerimaan_2' =>  $requestData['tA2']
            ]);

            DB::commit();
            return response()->json([
                'message' => 'Berhasil menyimpan data form Inspeksi Catering!',
                'code' => 200
            ]);

        } catch (QueryException $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Something went wrong: ' . $e->getMessage(),
                'code' => 500
            ], 500);
        }
    }

    public function EditReqFuel($id)
    {
        $editReqFuel = DB::table('FM_LOG_022_PERMINTAAN_PENGISIAN_FUEL')->find($id);
        return view('SmartForm::bss-form/log/form-fuel', [
            'formRequestFuel' => $editReqFuel
        ]);
    }

    public function DeleteInspeksiCatering($id)
    {
        DB::table('FM_SHE_048_INSPEKSI_CATERING')->where('id', $id)->delete();
        return view('SmartForm::she/inspeksi-catering/inspeksi-catering');
    }

    public function PdfInspeksiCatering($id)
    {
        $data = DB::table('FM_SHE_048_INSPEKSI_CATERING')->where('id', $id)->first();
        $pdf = PDF::loadView('SmartForm::she/inspeksi-catering/inspeksi-catering-pdf',  compact('data'));

        return $pdf->download('BSS-FRM-SHE-048.pdf');
    }
}
