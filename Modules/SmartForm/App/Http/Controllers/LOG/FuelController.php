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

class FuelController extends Controller {
    public function FuelDashboard(Request $req)
    {
        $nik_session = $req->session()->get('user_id', '');
        $name_session = $req->session()->get('username', '');

        return view('SmartForm::LOG/request-fuel/dashboard-request-fuel', [
            'nik_session' => $nik_session,
            'name_session' => $name_session]);
    }

    function GetListRequestFuel(Request $request) {
        $TABLE_REQUEST_FUEL = "FM_LOG_022_PERMINTAAN_PENGISIAN_FUEL";
        $response = array(
            'message' => '',
            'isSuccess' => false
        );
        $filterTanggal = $request->query('tanggal', null);
        $filterSite = $request->query('site', null);
        $filterNik = $request->query('nik', null);
        $filterStatus = $request->query('status', null);
        $search = $request->query('search', '');
        $sort = $request->query('sort', 'id'); // Default sort by id
        $order = $request->query('order', 'desc');
        $offset = $request->query('offset', 0); // Default offset
        $limit = $request->query('limit', null); // Default limit
        $filter = $request->query('filter', null); // Default limit
        try {
            $master = DB::table($TABLE_REQUEST_FUEL)
                ->select('id', 'no', 'nama', 'jabatan','dibuat_oleh', 'departemen', 'tanggal', 'no_lambung', 'jenis_kendaraan', 'jam', 'shift','hm','awal','akhir','total_liter');
            
            if($filterNik == null || $filterNik == 'null') {
            } else {
                $master->where('dibuat_oleh', $filterNik);
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
        return view('SmartForm::LOG/request-fuel/form-request-fuel', [
                    'approvalList' => HrdHelper::getApprovalList()
                ]);
    }
    
    public function CreateReqFuel(Request $request)
    {
        DB::beginTransaction();
        $requestData = $request->all();

        // START NO KUPON
	    $month = date("m");
	    $year = date("y");
        $nomor = "0001";
	    // e.g. 23 
	    // Get the last bill number from the database
        $TABLE_REQUEST_FUEL = "FM_LOG_022_PERMINTAAN_PENGISIAN_FUEL";
        
        $query = DB::table($TABLE_REQUEST_FUEL)
                // ->select('id','no')
                ->orderBy('no', 'desc')
                ->value('no');
        $no = $query;
	    // Check if the last bill number is empty or has a different month or year 
	    if(empty($no) || substr($no, 0, 2) != $year || substr($no, 2, 2) != $month) 
	    { 
	    	$number = "$year$month$nomor"; }
	    else {
	    	$idd = substr($no, 4);
	    	$id = str_pad($idd + 1, 4, 0, STR_PAD_LEFT); 
	    	$number = "$year$month$id"; } 
        // END NO KUPON

        try {
            DB::table('FM_LOG_022_PERMINTAAN_PENGISIAN_FUEL')->insert([
                'no' => $number,
                'nama' => session("username"),
                'jabatan' => $requestData['i_jabatan'],
                'dibuat_oleh' => session("user_id"),
                'departemen' =>  $requestData['i_departemen'],
                'tanggal' =>  $requestData['tglDoc'],
                'no_lambung' =>  $requestData['i_no_lambung'],
                'jenis_kendaraan' =>  $requestData['i_jenis_kendaraan'],
                'jam' =>  $requestData['iJam'],
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

    public function EditReqFuel(Request $request)
    {
        $id = $request->query('id');
        $nik_session = $request->session()->get('user_id', '');
        $data = $this->getDetail($request, $id, $nik_session);
        Log::debug("Data edit : ". json_encode($data, JSON_PRETTY_PRINT));
        if($data['data']['dibuat_oleh'] != $nik_session) {
            return abort(401, 'Unauthoried Request!');
        } else {
            $data['list_dept'] = self::LIST_DEPT;
            return view("SmartForm::bss-form/LOG/request-fuel/edit-form-request-fuel", 
                $data,
                ['approvalList' => HrdHelper::getApprovalList()] 
            );
        }
    }

    private function getDetail(Request $request, $id, $nik) {
        $TABLE_MASTER = "FM_LOG_022_PERMINTAAN_PENGISIAN_FUEL";
        $isError = true;
        $errorMessage = '';
        $this->user_sm = $this->getUserSM();
        $data_master = array(
            'id' => '',
            'no' => '',
            'nama' => '',
            'jabatan' => '',
            'nik' => '',
            'dibuat_oleh' => ''
        );
        $data_detail = array();
        try {
            $data = DB::table($TABLE_MASTER)
                ->select(
                    'id','no','nama','jabatan','nik','dibuat_oleh'
                )
                ->where('id', $id)
                ->first();
            if(!is_null($data)) {
                // Log::info("id : ". json_encode($data));

                $data_user = DB::connection('sqlsrv2')
                    ->table("TKaryawan")
                    ->select('NIK as nik', 'Nama as nama')
                    ->where("nik", $data->dibuat_oleh)
                    ->first();

                $data_master['dibuat_oleh'] = $data_user->nik;
                $data_master['no'] = $data->no;
                $data_master['nama'] = $data->nama;

                $isError = false;
            } else {
                $isError = true;
                $errorMessage = "Data tidak ditemukan...";
            }
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            $errorMessage = $ex->getMessage();
        }
        $is_user_sm = in_array($request->session()->get('user_id', ''), $this->user_sm);

        return ['error' => $isError, 'errorMessage' => $errorMessage, 'data' => $data_master, 'is_user_sm' => $is_user_sm, 'nik_session' => $nik];
    }

    function FuelDetailById(Request $request) {
        $id = $request->query('id');
        $nik_session = $request->session()->get('user_id', '');
        $data = $this->getDetail($request, $id, $nik_session);
        // $history_edit = $this->getHistory($data['data']['id']);
        // $data_approval = $this->getApprovalStatus($no_doc, $data['data']['acknowledge_by_1_nik'], $data['data']['acknowledge_by_2_nik'], $data['data']['approved_by_1_nik'], $data['data']['approved_by_2_nik']);
        // $data = array_merge($data, $history_edit, $data_approval);
        $data['list_dept'] = self::LIST_DEPT;

        return view('SmartForm::LOG/pemakaian-solar/lihat-detail-form-pemakaian-solar', $data);
    }

    public function DeleteReqFuel($id)
    {
        DB::table('FM_LOG_022_PERMINTAAN_PENGISIAN_FUEL')->where('id', $id)->delete();
        return view('SmartForm::LOG/request-fuel/dashboard-request-fuel');
    }

    public function PdfReqFuel($id)
    {
        $data = DB::table('FM_LOG_022_PERMINTAAN_PENGISIAN_FUEL')->where('id', $id)->first();
        $pdf = PDF::loadView('SmartForm::LOG/request-fuel/req-fuel-pdf',  compact('data'));

        return $pdf->download('BSS-FRM-LOG-022.pdf');
    }

}