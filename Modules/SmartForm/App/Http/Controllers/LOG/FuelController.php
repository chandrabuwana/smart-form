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
use Modules\SmartForm\helpers\SiteHelper;

class FuelController extends Controller {
    private const TABLE_SITES = 'tsite';
    private const TABLE_KARYAWAN = 'TKaryawan';
    private const TABLE_DEPARTEMENT = 'tdepartement';
    private const LIST_DEPT = [
        '' => '--- Pilih Departmen ---',
        'ENG' => 'ENGINEERING',
        'SHE' => 'SHE',
        'PRD' => 'PRODUKSI',
        'SM' => 'SM',
        'IC' => 'IC',
        'GS' => 'GS',
        'RM' => 'PLANT',
        'BDV' => 'BUSDEV',
        'FIN' => 'FINANCE',
        'ATA' => 'Accounting & Tax',
        'DTC' => 'DATA CENTER',
        'MM' => 'LOGISTIK',
        'OPR' => 'OPERATION',
        'LEG' => 'LEGAL',
        'OD' => 'ORGANIZATION DEVELOPMENT',
        'CIVIL' => 'CIVIL'
    ];
    public function FuelDashboard(Request $req)
    {
        $TABLE_REQUEST_FUEL = "FM_LOG_022_PERMINTAAN_PENGISIAN_FUEL";
        $nik_session = $req->session()->get('user_id', '');
        $name_session = $req->session()->get('username', '');
        $siteOptions = SiteHelper::renderSiteSelect('filterSite', null, false, false, 'filterSite');
        $currentMonth = now()->month;
        $currentYear = now()->year;
        $totalRecords = DB::table($TABLE_REQUEST_FUEL)->count();
        $totalThisMonth = DB::table($TABLE_REQUEST_FUEL)
            ->whereMonth('tanggal', $currentMonth)
            ->whereYear('tanggal', $currentYear)
            ->where('is_active', 1)
            ->count();

        return view('SmartForm::LOG/request-fuel/dashboard-request-fuel', [
            'nik_session' => $nik_session,
            'totalRecords' => $totalRecords,
            'totalThisMonth' => $totalThisMonth,
            'name_session' => $name_session,
            'siteOptions' => $siteOptions
        ]);
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
                ->select('id', 'no', 'nama', 'jabatan','dibuat_oleh', 'site','departemen', 'tanggal', 'no_lambung', 'jenis_kendaraan', 'jam', 'shift','hm','awal','akhir','total_liter','is_active');

            if($filterNik == null || $filterNik == 'null') {
            } else {
                $master->where('dibuat_oleh', $filterNik);
            }
            if($filterStatus == null || $filterStatus == 'null') {
            } else {
                $master->where('status', $filterStatus);
            }
            if($filterSite == null || $filterSite == 'null' || $filterSite == '') {
            } else {
                $master->where('site', $filterSite);
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

    public function FormFuel() {
        $sites = DB::connection('sqlsrv2')->table(self::TABLE_SITES)->select(columns: 'KodeST')->get();
        $dept = DB::connection('sqlsrv2')->table(self::TABLE_DEPARTEMENT)->select(columns: 'Nama')->get();

        return view('SmartForm::LOG/request-fuel/form-request-fuel', [
            'approvalList' => HrdHelper::getApprovalList(),
            'sites' => $sites,
            'dept' => $dept,
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
                'site' => $requestData['site'],
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
        $siteOptions = SiteHelper::renderSiteSelect('i_site', $data['data']['site'], false, true, 'i_site');

        if($data['data']['dibuat_oleh'] != $nik_session) {
            return abort(401, 'Unauthoried Request!');
        } else {
            $data['list_dept'] = self::LIST_DEPT;
            return view( 'SmartForm::LOG/request-fuel/edit-form-req-fuel',
                $data,
                ['siteOptions' => $siteOptions,
                'approvalList' => HrdHelper::getApprovalList()]
            );
        }
    }

    private function getDetail(Request $request, $id, $nik) {
        $TABLE_MASTER = "FM_LOG_022_PERMINTAAN_PENGISIAN_FUEL";
        $isError = true;
        $errorMessage = '';
        // $this->user_sm = $this->getUserSM();
        $data_master = array(
            'id' => '',
            'no' => '',
            'nama' => '',
            'jabatan' => '',
            'tanggal' => '',
            'no_lambung' => '',
            'dibuat_oleh' => ''
        );
        try {
            $data = DB::table($TABLE_MASTER)
                ->select(
                    'id','no','nama','jabatan','dibuat_oleh','tanggal','site', 'departemen','no_lambung','jenis_kendaraan','jam',
                    'shift','hm','km','awal','akhir','total_liter','diserahkan_oleh','diterima_oleh'
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
                $data_master['id'] = $data->id;
                $data_master['jabatan'] = $data->jabatan;
                $data_master['tanggal'] = $data->tanggal;
                $data_master['site'] = $data->site;
                $data_master['departemen'] = $data->departemen;
                $data_master['no_lambung'] = $data->no_lambung;
                $data_master['jenis_kendaraan'] = $data->jenis_kendaraan;
                $data_master['jam'] = $data->jam;
                $data_master['shift'] = $data->shift;
                $data_master['hm'] = $data->hm;
                $data_master['km'] = $data->km;
                $data_master['awal'] = $data->awal;
                $data_master['akhir'] = $data->akhir;
                $data_master['total_liter'] = $data->total_liter;
                $data_master['diserahkan_oleh'] = $data->diserahkan_oleh;
                $data_master['diterima_oleh'] = $data->diterima_oleh;

                $isError = false;
            } else {
                $isError = true;
                $errorMessage = "Data tidak ditemukan!";
            }
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            $errorMessage = $ex->getMessage();
        }
        // $is_user_sm = in_array($request->session()->get('user_id', ''), $this->user_sm);

        return ['error' => $isError, 'errorMessage' => $errorMessage, 'data' => $data_master, 'nik_session' => $nik];
    }

    function FuelDetailById(Request $request) {
        $id = $request->query('id');
        $nik_session = $request->session()->get('user_id', '');
        $data = $this->getDetail($request, $id, $nik_session);
        // $history_edit = $this->getHistory($data['data']['id']);
        // $data_approval = $this->getApprovalStatus($no_doc, $data['data']['acknowledge_by_1_nik'], $data['data']['acknowledge_by_2_nik'], $data['data']['approved_by_1_nik'], $data['data']['approved_by_2_nik']);
        // $data = array_merge($data, $history_edit, $data_approval);
        $data['list_dept'] = self::LIST_DEPT;

        return view('SmartForm::LOG/request-fuel/lihat-detail-request-fuel', 
            $data,
            ['approvalList' => HrdHelper::getApprovalList()]
        );
    }

    public function HapusReqFuel(Request $request)
    {
        $nik_session = $request->session()->get('user_id', '');
        $name_session = $request->session()->get('username', '');
        $TABLE_MASTER = "FM_LOG_022_PERMINTAAN_PENGISIAN_FUEL";
        $data = DB::table($TABLE_MASTER)
                    ->select('*')
                    ->where('id', $request->id)
                    ->update([
                            'is_active' => "0",
                            ]);
        return view('SmartForm::LOG/request-fuel/dashboard-request-fuel', [
            'nik_session' => $nik_session,
            'name_session' => $name_session]);
    }

    public function PdfReqFuel(Request $request)
    {
        $data = DB::table('FM_LOG_022_PERMINTAAN_PENGISIAN_FUEL')->where('id', $request->id)->first();
        $pdf = PDF::loadView('SmartForm::log/request-fuel/req-fuel-pdf',  compact('data'));

        return $pdf->download('BSS-FRM-LOG-022.pdf');
    }

    public function updateReqFuel(Request $request)
    {
        $nik_session = $request->session()->get('user_id', '');
        $name_session = $request->session()->get('username', '');
        $siteOptions = SiteHelper::renderSiteSelect('filterSite', null, false, false, 'filterSite');
        $TABLE_MASTER = "FM_LOG_022_PERMINTAAN_PENGISIAN_FUEL";
        $data = DB::table($TABLE_MASTER)
                    ->select('*')
                    ->where('id', $request->idDoc)
                    ->update([
                            'jabatan' => $request->i_jabatan,
                            'departemen' => $request->i_departemen,
                            'site' => $request->site,
                            'no_lambung' => $request->i_no_lambung,
                            'jenis_kendaraan' => $request->i_jenis_kendaraan,
                            'jam' => $request->iJam,
                            'shift' => $request->i_shift,
                            'hm' => $request->i_hm,
                            'km' => $request->i_km,
                            'awal' => $request->i_awal,
                            'akhir' => $request->i_akhir,
                            'total_liter' => $request->i_total_liter,
                            'diserahkan_oleh' => $request->dDiserahkan,
                            'diterima_oleh' => $request->dDiterima,
                            ]);

        // return view('SmartForm::LOG/request-fuel/dashboard-request-fuel', [
        //     'nik_session' => $nik_session,
        //     'name_session' => $name_session,
        //     'siteOptions' => $siteOptions
        // ]);
        return redirect()->route('bss-form.log.fuel.dashboard');
    }

    public function getNoBySite(Request $request) {
        $site = $request->get('site');

        $alat = DB::table('alat_angkut_data')
            ->where('site', $site)
            ->select('no_lambung')
            ->get();

        return response()->json($alat);
    }

    public function getModelByNo(Request $request) {
        // dd($request);
        $no_lambung = $request->get('no_lambung');

        $jenis_kendaraan = DB::table('alat_angkut_data')
            ->where('no_lambung', $no_lambung)
            ->select('model')
            ->get();

        return response()->json($jenis_kendaraan);
    }
}
