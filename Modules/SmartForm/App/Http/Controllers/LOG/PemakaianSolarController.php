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
use Illuminate\Support\Facades\Storage;

class PemakaianSolarController extends Controller {

    private const TABLE_MASTER = "FM_LOG_037_PEMAKAIAN_SOLAR";
    private const TABLE_DETAIL = "FM_LOG_037_PEMAKAIAN_SOLAR_DETAIL";
    private $user_sm = ['1008491', '1008492', '1008493', '1008494', '1008526'];
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

    public function download() {
        $pdf = Pdf::loadView('pdf');
 
        return $pdf->download();
    }


    public function PemakaianSolarDashboard(Request $req)
    {
        $nik_session = $req->session()->get('user_id', '');
        $name_session = $req->session()->get('username', '');

        return view('SmartForm::LOG/pemakaian-solar/dashboard-pemakaian-solar', [
            'nik_session' => $nik_session,
            'name_session' => $name_session]);
    }


    function GetPemakaianSolarData(Request $request) {
        $TABLE_MASTER = "FM_LOG_037_PEMAKAIAN_SOLAR";
        $TABLE_DETAIL = "FM_LOG_037_PEMAKAIAN_SOLAR_DETAIL";

        $response = array(
            'message' => '',
            'isSuccess' => false
        );
        $filterNik =  $request->query('nik', null);
        $filterStatus =  $request->query('status', null);
        $search = $request->query('search', '');
        $sort = $request->query('sort', 'id'); // Default sort by id
        $order = $request->query('order', 'asc'); // Default order is ascending
        $offset = $request->query('offset', 0); // Default offset
        $limit = $request->query('limit', 10); // Default limit

        try {
            $forms_request_sql = DB::table($TABLE_MASTER)
                ->select('no_doc', 'created_date as tgldibuat','dibuat_oleh','no_fuel_station as fuel','total_pemakaian as total','disetujui_oleh as approval','status')
                ->orderBy('no_doc', 'desc');

            if($filterNik) $forms_request_sql = $forms_request_sql->where('dibuat_oleh', $filterNik);
            if($filterStatus) $forms_request_sql = $forms_request_sql->where('status', $filterStatus);

            
            $totalNotFiltered = $forms_request_sql->count();
                // if($search) {
            //     $users->where('no_doc', 'like', "%$search%")
            //       ->orWhere('department', 'like', "%$search%")
            //       ->orWhere('project', 'like', "%$search%")
            //       ->orWhere('area', 'like', "%$search%")
            //       ->orWhere('requested_by', 'like', "%$search%");
            // }
            // Apply sorting
            // $documents = $users->skip($offset)->take($limit)->get();
            if($limit == null || $limit == 'null' || $limit == '') {
                $forms_request_sql->skip($offset);
            } else {
                $forms_request_sql->skip($offset)->limit($limit);
            }
            LOG::info("SQL Forms Data Asset Request : ". $forms_request_sql->toRawSql());
            

            $response['message'] = "Ok";
            $response['isSuccess'] = true;
            $response['data'] = ['total'=> $totalNotFiltered, 'totalNotFiltered'=> $totalNotFiltered, 'rows' => $forms_request_sql->get()->toArray()];
            // $response['data'] = $documents;

        } catch (Exception $ex) {
            Log::info($ex->getTraceAsString());
            $response['message'] = $ex->getMessage();
            $response['isSuccess'] = false;
        }

        return response()->json($response);
        // return response()->json(['total'=> $totalNotFiltered, 'totalNotFiltered'=> $totalNotFiltered, 'rows' => $users]);
    }

    private function getUserSM(): array {
        $list_nik_SM = [];

        try {
            $list_nik_SM = array_map('trim', explode(',', config('app.user_sm', '')));
        } catch (Exception $ex) {
           Log::error($ex->getMessage());
           Log::error($ex->getTraceAsString());
        }
        
        return $list_nik_SM;
    }
    
    function editPemakaianSolar(Request $request) {
        $no_doc = $request->query('no_doc');
        $nik_session = $request->session()->get('user_id', '');
        $data = $this->getDetail($request, $no_doc, $nik_session);
        Log::debug("Data edit : ". json_encode($data, JSON_PRETTY_PRINT));
        if($data['data']['dibuat_oleh'] != $nik_session) {
            return abort(401, 'Unauthoried Request!');
        } else {
            $data['list_dept'] = self::LIST_DEPT;
            return view("SmartForm::LOG/pemakaian-solar/edit-form-pemakaian-solar", 
                $data,
                ['approvalList' => HrdHelper::getApprovalList()] 
            );
        }
    }

    private function getDetail(Request $request, $no_doc, $nik) {
        $TABLE_MASTER = "FM_LOG_037_PEMAKAIAN_SOLAR";
        $TABLE_DETAIL = "FM_LOG_037_PEMAKAIAN_SOLAR_DETAIL";
        $isError = true;
        $errorMessage = '';
        $this->user_sm = $this->getUserSM();
        $data_master = array(
            'fuel' => '',
            'no_doc' => '',
            'tgl_dibuat' => '',
            'shift' => '',
            'disetujui_oleh' => '',
            'site' => '',
            'stok_awal' => '',
            'masuk' => '',
            'total_pakai' => '',
            'stok_akhir' => '',
            'dibuat_oleh' => ''
        );
        $data_detail = array();
        try {
            $data = DB::table($TABLE_MASTER)
                ->select(
                    'no_doc','dibuat_oleh','no_fuel_station as fuel','created_date as tgl_dibuat','shift','disetujui_oleh','job_site as site','stok_awal',
                    'stok_akhir','masuk','total_pemakaian as total_pakai','stok_akhir'
                )
                ->where('no_doc', $no_doc)
                ->first();
            if(!is_null($data)) {
                // Log::info("id : ". json_encode($data));
                $data_detail = DB::table($TABLE_DETAIL)
                    ->select('kode_unit','jam','awal','akhir','total_liter','nama_operator','km','hm','keterangan')
                    ->where('id_pemakai_solar', $data->no_doc)
                    ->get();
                $nomor = 1;
                foreach($data_detail as $detail) {
                    $detail->nomor = $nomor;
                    
                    $nomor++;
                }

                $data_user = DB::connection('sqlsrv2')
                    ->table("TKaryawan")
                    ->select('NIK as nik', 'Nama as nama')
                    ->where("nik", $data->dibuat_oleh)
                    ->first();

                $data_master['dibuat_oleh'] = $data_user->nik;
                $data_master['no_doc'] = $data->no_doc;
                $data_master['fuel'] = $data->fuel;
                $data_master['tgl_dibuat'] = $data->tgl_dibuat;
                $data_master['shift'] = $data->shift;
                $data_master['disetujui_oleh'] = $data->disetujui_oleh;
                $data_master['site'] = $data->site;
                $data_master['stok_awal'] = $data->stok_awal;
                $data_master['stok_akhir'] = $data->stok_akhir;
                $data_master['masuk'] = $data->masuk;
                $data_master['total_pakai'] = $data->total_pakai;

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

        return ['error' => $isError, 'errorMessage' => $errorMessage, 'data' => $data_master, 'detail' => $data_detail, 'is_user_sm' => $is_user_sm, 'nik_session' => $nik];
    }

    function GetListPemakaianSolar(Request $request) {
        $TABLE_PENGELUARAN_OLI = "FM_LOG_037_PEMAKAIAN_SOLAR";
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
                ->select('id', 'shift', 'job_site as site', 'dibuat_oleh','no_fuel_station as fuel','total_pemakaian','disetujui_oleh as approved','dibuat_oleh as request','status');
            
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

    function formPemakaianSolar(Request $req) {
        $nik_session = $req->session()->get('user_id', '');
        return view('SmartForm::LOG/pemakaian-solar/form-pemakaian-solar', [
                    'nik_session' => $nik_session,
                    'isShowDetail' => true,
                    'approvalList' => HrdHelper::getApprovalList()
                ]);
    }

    function SubmitFormPemakaianSolar(Request $req) {
        $TABLE_MASTER = "FM_LOG_037_PEMAKAIAN_SOLAR";
        $TABLE_DETAIL = "FM_LOG_037_PEMAKAIAN_SOLAR_DETAIL";
        $response = array(
            'message' => "",
            'isSuccess' => false
        );
        $today = Carbon::now()->isoFormat('D MMMM Y');
        $hari = Carbon::now()->isoFormat('dddd');
        $requested_by = $req->session()->get('user_id');
        $data = $req->input();
        
        $data_insert = [
            'dibuat_oleh' => $requested_by,
            'job_site' => $data['jobSite'],
            // 'no_dok' => $data['noDoc'],
            'no_dok' => "BSS-FRM-LOG-037",
            'revisi' => "02",
            'tanggal' => "16 September 2024",
            'halaman' => "1 dari 1",
            'no_fuel_station' => $data['fuel'],
            'shift' => $data['shift'],
            'total_pemakaian' => $data['total_pemakaian'],
            'created_date' => $today,
            'hari' => $hari,
            'stok_awal' => $data['stokAwal'],
            'stok_akhir' => $data['stokAkhir'],
            'masuk' => $data['masuk'],
            'status' => "Draft",
            'no_doc' => $data['noDoc'],
            'disetujui_oleh' => $data['approval']
        ];
        // $spliited_no_doc = explode("/", $data_insert['no_dok']);
        $data_item = json_decode($data['item']);
        
        try {
            DB::beginTransaction();
            $id = DB::table($TABLE_MASTER)->insertGetId($data_insert);

            foreach ($data_item as $data_item_detail) {
                DB::table($TABLE_DETAIL)->insert(array(
                    'id_pemakai_solar' => $id,
                    'kode_unit' => $data_item_detail->kodeUnit,
                    'jam' => $data_item_detail->jam,
                    'awal' => $data_item_detail->awal,
                    'akhir' => $data_item_detail->akhir,
                    'total_liter' => $data_item_detail->totalLiter,
                    'nama_operator' => $data_item_detail->namaOperator,
                    'km' => $data_item_detail->km,
                    'hm' => $data_item_detail->hm,
                    'keterangan' => $data_item_detail->ket
                ));
            }

            $spliited_no_doc[0] = $id;
            $updated_no_doc = implode($spliited_no_doc);

            $affected = DB::table($TABLE_MASTER)
              ->where('id', $id)
              ->update(['no_doc' => $updated_no_doc]);

            Db::commit();


            $response['message'] = "Ok";
            $response['isSuccess'] = true;
            $response['data'] = array(
                // 'no_doc' => $updated_no_doc
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

    public function PdfPemakaianSolar($id)
    {
        $TABLE_MASTER = "FM_LOG_037_PEMAKAIAN_SOLAR";
        $TABLE_DETAIL = "FM_LOG_037_PEMAKAIAN_SOLAR_DETAIL";
        $errors = array(
            'error' => false,
            'message' => ''
        );
        try {
            $data = DB::table($TABLE_MASTER)
                    ->select('id', 'no_dok','revisi as revisi','halaman','tanggal','job_site as jobsite','no_fuel_station as noFuel','shift','dibuat_oleh as dibuat','diketahui_oleh as mengetahui','disetujui_oleh as approval','total_pemakaian','created_date as tgldibuat','hari','stok_awal','masuk','stok_akhir')
                    ->where('id', $id)
                    ->first();
                
            $data_detail = DB::table($TABLE_DETAIL)
                ->select('id_pemakai_solar','kode_unit as unit','jam','awal','akhir','total_liter as totalLiter','nama_operator','km','hm','keterangan')
                ->where('id_pemakai_solar', $data->id)
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
            $data_master['revisi'] = $data->revisi;
            $data_master['halaman'] = $data->halaman;
            $data_master['dibuat'] = $data->dibuat;
            $data_master['noFuel'] = $data->noFuel;
            $data_master['total_pemakaian'] = $data->total_pemakaian;
            $data_master['shift'] = $data->shift;
            $data_master['approval'] = $data->approval;
            $data_master['tgldibuat'] = $data->tgldibuat;
            $data_master['hari'] = $data->hari;
            $data_master['stok_awal'] = $data->stok_awal;
            $data_master['masuk'] = $data->masuk;
            $data_master['stok_akhir'] = $data->stok_akhir;
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
        }
        Log::info("data_master : ". json_encode($data_master));
        $pdf = PDF::loadView('SmartForm::LOG/pemakaian-solar/pemakaian-solar-pdf',  ['data' => $data_master, 'data_detail' => $data_detail, 'error' => $errors]);
        return $pdf->download('BSS-FRM-LOG-037.pdf');
    }

    function SolarDetailById(Request $request) {
        $id = $request->query('id');
        $nik_session = $request->session()->get('user_id', '');
        $data = $this->getDetail($request, $id, $nik_session);
        $history_edit = $this->getHistory($data['data']['id']);
        $data_approval = $this->getApprovalStatus($no_doc, $data['data']['acknowledge_by_1_nik'], $data['data']['acknowledge_by_2_nik'], $data['data']['approved_by_1_nik'], $data['data']['approved_by_2_nik']);
        $data = array_merge($data, $history_edit, $data_approval);
        $data['list_dept'] = self::LIST_DEPT;

        return view('SmartForm::LOG/pemakaian-solar/detail-form-pemakaian-solar', $data);
    }

    private function getApprovalStatus(string $no_doc, $ack1, $ack2, $approve1, $approve2) {
        $data = null;

        try {
            // $data['approval_status'] = DB::table('PICA_BETA.dbo.FM_SM_016_MASTER as pfm')
            $sql_approval = DB::table('FM_SM_016_MASTER as pfm')
                ->leftJoin('HRD.dbo.TKaryawan as k0', 'pfm.requested_by', '=', 'k0.NIK')
                ->leftJoin('HRD.dbo.TKaryawan as k1', 'pfm.acknowledge_by_1_nik', '=', 'k1.NIK')
                ->leftJoin('HRD.dbo.TKaryawan as k1a', 'pfm.cost_control_nik', '=', 'k1a.NIK')
                ->leftJoin('HRD.dbo.TKaryawan as k2', 'pfm.acknowledge_by_2_nik', '=', 'k2.NIK')
                ->leftJoin('HRD.dbo.TKaryawan as k3', 'pfm.approved_by_1_nik', '=', 'k3.NIK')
                ->leftJoin('HRD.dbo.TKaryawan as k4', 'pfm.approved_by_2_nik', '=', 'k4.NIK')
                ->select(
                    'pfm.requested_by',
                    'pfm.acknowledge_1',
                    'pfm.cost_control',
                    'pfm.acknowledge_2',
                    'pfm.approved_1',
                    'pfm.approved_2',
                    'pfm.acknowledge_by_1_nik',
                    'pfm.cost_control_nik',
                    'pfm.acknowledge_by_2_nik',
                    'pfm.approved_by_1_nik',
                    'pfm.approved_by_2_nik',
                    'k0.Nama as requested_by_nama',
                    'k1.Nama as acknowledge_by_1_nama',
                    'k1a.Nama as cost_control_nama',
                    'k2.Nama as acknowledge_by_2_nama',
                    'k3.Nama as approved_by_1_nama',
                    'k4.Nama as approved_by_2_nama'
                )
                ->where('pfm.no_doc', $no_doc);
            Log::debug("SQL approval status : " . $sql_approval->toRawSql());

            $data['approval_status'] = $sql_approval->first();
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
        }
        Log::debug($data);
        return $data;
    }

    function SubmitEditPemakaianSolar(Request $req) {
        $TABLE_MASTER = "FM_LOG_037_PEMAKAIAN_SOLAR";
        $TABLE_DETAIL = "FM_LOG_037_PEMAKAIAN_SOLAR_DETAIL";
        $tgl = now()->toDateTimeString();
        $no_doc = $req->query('no_doc');
        $response = array(
            'message' => "",
            'isSuccess' => false
        );
        $nik_session = $req->session()->get('user_id', '');
        $data = $req->input();
        $data_insert = [
            'no_doc' => $data['no_doc'],
            'no_fuel_station' => $data['fuel'],
            'shift' => $data['shift'],
            'disetujui_oleh' => $data['approval'],
            'job_site' => $data['jobSite'],
            'stok_awal' => $data['stokAwal'],
            'stok_akhir' => $data['stokAkhir'],
            'masuk' => $data['masuk'],
            'total_pemakaian' => $data['total_pemakaian']
        ];
        $data_item = json_decode($data['item']);
        Log::info($data_item);

        try {
            DB::beginTransaction();
            $old_value_master = DB::table($TABLE_MASTER)
                ->select('id','no_doc','no_fuel_station','shift','disetujui_oleh','job_site','stok_awal',
                    'stok_akhir','masuk','total_pemakaian')
                ->where('no_doc', $no_doc)
                ->first();

            $old_value_detail = DB::table($TABLE_DETAIL)
                ->select('kode_unit','jam','awal','akhir','total_liter','nama_operator','km','hm','keterangan')
                ->where('id_pemakai_solar', $old_value_master->id)
                ->get();
            $is_item_edit_item = $this->isArrayDifferent($old_value_detail, $data_item);

            if($is_item_edit_item) {
                $deleted = DB::table($TABLE_DETAIL)->where('id_pemakai_solar', $old_value_master->id)->delete();
                foreach ($data_item as $data_item_detail) {
                    DB::table($TABLE_DETAIL)->insert(array(
                        'id_pemakai_solar' => $old_value_master->id,
                        'kode_unit' => $data_item_detail->kode_unit,
                        'jam' => $data_item_detail->jam,
                        'awal' => $data_item_detail->awal,
                        'akhir' => $data_item_detail->akhir,
                        'total_liter' => $data_item_detail->total_liter,
                        'nama_operator' => $data_item_detail->nama_operator,
                        'km' => $data_item_detail->km,
                        'hm' => $data_item_detail->hm,
                        'keterangan' => $data_item_detail->keterangan
                    ));
                }
                // $history_detail = $this->addHistory($old_value_master->no_doc, $tgl, $nik_session, 'PemakaianSolarEdit', $data_item, $old_value_detail);
            }

            Log::info($old_value_detail);
            Log::info(json_encode($this->isArrayDifferent($old_value_detail, $data_item)));
            $affected_rows = DB::table($TABLE_MASTER)
                ->where('no_doc', $no_doc)
                ->update($data_insert);
            // $history_master = $this->addHistory($old_value_master->id, $tgl, $nik_session, 'PemakaianSolarEdit', $data_insert, $old_value_master);
            DB::commit();
            $response['message'] = "Ok";
            $response['isSuccess'] = true;
            $response['data'] = array(
                'no_doc' => $no_doc
            );

        } catch (Exception $ex) {
            // DB::rollBack();

            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            $response['message'] = $ex->getMessage();
            $response['isSuccess'] = false;
        }

        return response()->json($response);
    }

    private function isArrayDifferent($array1, $array2) {
        if (count($array1) !== count($array2)) {
            return true;
        }

        foreach ($array1 as $key => $item1) {
            if (!isset($array2[$key])) {
                return true;
            }

            $item2 = $array2[$key];

            // Membandingkan masing-masing properti dalam object
            foreach ($item1 as $prop => $value1) {
                if (!property_exists($item2, $prop) || $item2->$prop !== $value1) {
                    return true;
                }
            }
        }

        return false;
    }
}