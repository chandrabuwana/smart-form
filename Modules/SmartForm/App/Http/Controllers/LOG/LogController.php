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

class LogController extends Controller {
    private const TABLE_REQUEST_MASTER = "FM_LOG_002_REQUESTER_MASTER";

    public function download() {
        $pdf = Pdf::loadView('pdf');
 
        return $pdf->download();
    }

    public function RequestMasterDashboard()
    {
        return view('SmartForm::LOG/request-master');
    }

    function GetFormsRequestMaster(Request $request) {
        $TABLE_REQUEST_MASTER = "FM_LOG_002_REQUESTER_MASTER";
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
        $order = $request->query('order', 'asc'); // Default order is ascending
        $offset = $request->query('offset', 0); // Default offset
        $limit = $request->query('limit', null); // Default limit
        $filter = $request->query('filter', null); // Default limit
        try {
            // $jml = DB::table($TABLE_MASTER)->count();
            $master = DB::table($TABLE_REQUEST_MASTER)
                ->select('no_dok','part_name');
            
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

    // ***** SATRT FUEL CONTROLLER *****
    public function FuelDashboard()
    {
        return view('SmartForm::LOG/request-fuel');
    }

    function GetListRequestFuel(Request $request) {
        $TABLE_REQUEST_FUEL = "FM_LOG_022_PERMINTAAN_PENGISIAN_FUEL";
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
        $order = $request->query('order', 'asc'); // Default order is ascending
        $offset = $request->query('offset', 0); // Default offset
        $limit = $request->query('limit', null); // Default limit
        $filter = $request->query('filter', null); // Default limit
        try {
            $master = DB::table($TABLE_REQUEST_FUEL)
                ->select('id', 'no', 'nama', 'jabatan','nik', 'departemen', 'tanggal', 'no_lambung', 'jenis_kendaraan', 'jam', 'shift','hm','awal','akhir','total_liter');
            
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

    function FormFuel() {
        return view("SmartForm::log/form-request-fuel");
    }
    
    public function CreateReqFuel(Request $request)
    {
        DB::beginTransaction();
        $requestData = $request->all();

        try {
            DB::table('FM_LOG_022_PERMINTAAN_PENGISIAN_FUEL')->insert([
                'no' => $requestData['i_kupon'],
                'nama' => session("username"),
                'jabatan' => $requestData['i_jabatan'],
                'nik' => session("user_id"),
                'departemen' =>  $requestData['i_departemen'],
                'tanggal' =>  $requestData['i_tgl'],
                'no_lambung' =>  $requestData['i_no_lambung'],
                'jenis_kendaraan' =>  $requestData['i_jenis_kendaraan'],
                'jam' =>  $requestData['i_jam'],
                'shift' =>  $requestData['i_shift'],
                'hm' =>  $requestData['i_hm'],
                'km' =>  $requestData['i_km'],
                'awal' =>  $requestData['i_awal'],
                'akhir' =>  $requestData['i_akhir'],
                'total_liter' =>  $requestData['i_total_liter']

            ]);

            DB::commit();
            return response()->json([
                'message' => 'Berhasil menyimpan data form Permintaan Fuel!',
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

    public function DeleteReqFuel($id)
    {
        DB::table('FM_LOG_022_PERMINTAAN_PENGISIAN_FUEL')->where('id', $id)->delete();
        return view('SmartForm::LOG/request-fuel');
    }

    public function PdfReqFuel($id)
    {
        $data = DB::table('FM_LOG_022_PERMINTAAN_PENGISIAN_FUEL')->where('id', $id)->first();
        $pdf = PDF::loadView('SmartForm::LOG/req-fuel-pdf',  compact('data'));

        return $pdf->download('form_req_fuel.pdf');
    }
    // ***** END FUEL CONTROLLER *****
}
