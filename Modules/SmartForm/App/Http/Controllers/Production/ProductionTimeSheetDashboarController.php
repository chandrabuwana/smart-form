<?php

namespace Modules\SmartForm\App\Http\Controllers\Production;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProductionTimeSheetDashboarController extends Controller
{
    private $pengawas_produksi = [];
    private const TABLE_MASTER = "FM_PRODUKSI_TIMESHEET_MASTER";
    private const TABLE_DETAIL = "FM_PRODUKSI_TIMESHEET_DETAIL";

    function IndexDashboard(){
        return view("SmartForm::production/timesheet/dashboard-form-timesheet-prod");
    }

    function FormTimesheetProduksi() {
        // TODO = ambil dari DB atau parameterized
        $data_pengawas = [
            [
                'nik' => '1020340',
                'nama' => 'Jimmy Feriawan'
            ],
            [
                'nik' => '1020341',
                'nama' => 'Ahmad Rifai'
            ]
        ];
        $data_pengawas = $this->getListPengawas();

        return view("SmartForm::production/timesheet/form-timesheet-prod", ['data_pengawas' => $data_pengawas]);
    }

    function SubmitFormTimesheet(Request $req) {
        $isError = true;
        $tgl = now()->toDateTimeString();
        $nik_session = $req->session()->get('user_id', '');
        $TABLE_MASTER = "FM_PRODUKSI_TIMESHEET_MASTER";
        $TABLE_DETAIL = "FM_PRODUKSI_TIMESHEET_DETAIL";
        $response = array(
            'message' => "",
            'isSuccess' => false
        );

        // $requested_by = $req->session()->get('user_id');
        $data_input = $req->input();
        $data_insert = array(
            'driver' => '',
            'site' => '',
            'tanggal' => '',
            'shift' => '',
            'no_unit' => '',
            'hm_awal' => 0.0,
            'hm_akhir' => 0.0,
            'total_rit' => 0
        );
        Log::info("request body : " . json_encode(array('body' => $data_input)));

        try {
            $data_insert['driver'] = $data_input['driver'];
            $data_insert['site'] = $data_input['site'];
            $data_insert['tanggal'] = $data_input['tanggal'];
            $data_insert['shift'] = $data_input['shift'];
            $data_insert['no_unit'] = $data_input['noUnit'];
            $data_insert['hm_awal'] = $data_input['awalHM'];
            $data_insert['hm_akhir'] = $data_input['akhirHM'];
            $data_insert['total_rit'] = $data_input['totalRit'];
            $data_insert['total_rit'] = $data_input['totalRit'];
            $data_insert['created_by'] = $nik_session;
            $data_insert['nik'] = $nik_session;
            $data_insert['blok'] = $data_input['blok'];
            $data_insert['pengawas'] = $data_input['pengawas'];
            $data_insert['status'] = 1;

            DB::beginTransaction();
            $id = DB::table($TABLE_MASTER)->insertGetId($data_insert);

            foreach ($data_input['detail'] as $data_item_detail) {
                DB::table($TABLE_DETAIL)->insert(array(
                    'id_master' => $id,
                    'jam' => $data_item_detail['jam'],
                    'rit_menit_ke' => $data_item_detail['rit_menit'],
                    'problem' => $data_item_detail['problem'],
                    'material_seam' => $data_item_detail['mns'],
                    'kode_aktifitas' => $data_item_detail['kd_aktifitas'],
                    'awal' => (float) $data_item_detail['awal'],
                    'akhir' => (float) $data_item_detail['akhir'],
                    'created_by' => $nik_session,
                    'created_at' => $tgl
                ));
            }
            DB::commit();
            $response['isSuccess'] = true;
            $response['message'] = "Berhasil Submit Timesheet";
            $response['data'] = ['id' => $id];
        } catch (Exception $ex) {
            DB::rollBack();
            Log::error($ex->getMessage());
            $response['isSuccess'] = false;
            $response['message'] = $ex->getMessage();
        }

        return response()->json(data: $response);
    }

    function GetFormsTimesheet(Request $request) {
        $TABLE_MASTER = "FM_PRODUKSI_TIMESHEET_MASTER";
        $TABLE_DETAIL = "FM_PRODUKSI_TIMESHEET_DETAIL";
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
            $master = DB::table($TABLE_MASTER)
                ->select('id', 'driver', 'tanggal', 'shift', 'no_unit', 'hm_awal', 'hm_akhir', 'total_rit', 'status', 'site', 'nik');
            
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

    function GetFormTimesheetDetail(Request $request) {
        $id = $request->query('id');
        $TABLE_MASTER = "FM_PRODUKSI_TIMESHEET_MASTER";
        $TABLE_DETAIL = "FM_PRODUKSI_TIMESHEET_DETAIL";
        $HARI_MAPPING = array("Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu");
        $errors = array(
            'error' => false,
            'message' => ''
        );
        $data_master = array(
            'id' => '',
            'driver' => '',
            'site' => '',
            'tanggal' => '',
            'shift' => '',
            'no_unit' => '',
            'hm_awal' => '',
            'hm_akhir' => '',
            'total_rit' => 0,
            'hari' => '',
            'status' => 0
        );
        try {
            $data = DB::table($TABLE_MASTER)
                ->select('id', 'driver', 'site', 'tanggal', 'shift', 'no_unit', 'hm_awal', 'hm_akhir', 'total_rit', 'nik', 'pengawas', 'status')
                ->where('id', $id)
                ->first();
            
            $data_detail = DB::table($TABLE_DETAIL)
                ->select('jam', 'rit_menit_ke as rit_menit', 'problem', 'material_seam as mns', 'blok', 'kode_aktifitas as kd_aktifitas', 'awal', 'akhir')
                ->where('id_master', $data->id)
                ->get();
            
            $nameOfDay = date('w', strtotime($data->tanggal));
            
            $data_master['id'] = $data->id;
            $data_master['driver'] = $data->driver;
            $data_master['nik'] = $data->nik;
            $data_master['site'] = $data->site;
            $data_master['hari'] = $HARI_MAPPING[$nameOfDay];

            $data_master['tanggal'] = $data->tanggal;
            $data_master['shift'] = $data->shift == "DS" ? "Day Shift (DS)" :  ($data_master['shift'] == "DS" ? "Night Shift (NS)" : "");
            $data_master['no_unit'] = $data->no_unit;
            $data_master['hm_awal'] = $data->hm_awal;
            $data_master['hm_akhir'] = $data->hm_akhir;
            $data_master['pengawas'] = $data->pengawas;
            $data_master['pengawas_nama'] = $data->pengawas == null ? "" : $this->getNamaFromListpengawas($data->pengawas, $this->getListPengawas($data->pengawas));
            $data_master['status'] = $data->status;
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
        }

        Log::info("data_master : ". json_encode($data_master));
        return view('SmartForm::production/timesheet/detail-form-timesheet', ['data' => $data_master, 'data_detail' => $data_detail, 'error' => $errors]);
    }

    function SearchKaryawan (Request $request) {
        $search = $request->query('search', '');
        $karyawan = [];
        $isError = true;
        
        $response = [
            'isError' => '',
            'message' => '',
            'errorMessage' => '',
            'data' => []
        ];

        if($search != '') {
            try {
                $query_search = DB::connection('sqlsrv2')
                    ->table('tkaryawan')
                    ->select('NIK', 'Nama')
                    ->whereAny(
                        ['nama', 'nik'], 'LIKE', "%$search%"
                    );
                
                Log::info("SQL :" . $query_search->toRawSql());
                $response['data'] = $query_search->get()->toArray();
                $response['isError'] = false;
                $response['message'] = 'Berhasil!';
            } catch (Exception $ex) {
                Log::error($ex->getMessage());
                Log::error($ex->getTraceAsString());

                $response['errorMessage'] = 'Terjadi kesalahan, coba beberapa saat lagi!';
            }
        }

        // Log::info(json_encode($response, JSON_PRETTY_PRINT));

        return response()->json($response);
    }

    private function isAuthorizedAsPengawas($nik): bool {
        $isNikPengawas = false;
        $this->pengawas_produksi = explode(',', config('app.pengawas_produksi', ''));
        
        in_array($nik, $this->pengawas_produksi) ? $isNikPengawas=true : $isNikPengawas=false;


        return $isNikPengawas;
    }

    function ActionPengawasTimesheet(Request $request) {
        $nik_session = $request->session()->get('user_id', '');
        $httpStatus = 200;
        $validator = Validator::make($request->all(), [
            'id_timesheet' => 'required',
            'action' => ['required', Rule::in(['approve', 'reject'])], 
        ],[
            'id_timesheet.required' => 'Nomor Timesheet tanggal wajib diisi.',
            'action.required' => 'Aksi wajib diisi.',
            'action.in' => 'Nilai Aksi harus salah satu dari: approve, reject'
        ]);
        $action_mapping  = [
            'approve' => [
                'value' => 2,
                'message' => 'Berhasil Aprrove Timesheet'
            ],
            'reject' => [
                'value' => 0,
                'message' => 'Berhasil Reject Timesheet'
            ]
        ];

        $response_data = [
            'isSuccess' => false,
            'message' => '',
            'errorMessage' => '',
            'data' => [
                'result' => ''
            ]
        ];

        if($this->isAuthorizedAsPengawas($nik_session)) {
            if(count($validator->errors()) > 0) {
                $response_data['errorMessage'] = implode("\n", $validator->errors()->all());
                $httpStatus = 400;
            } else {
                $action = $request->input('action');
                $id = $request->input('id_timesheet');
                try {
                    DB::beginTransaction();
                    $sql_update_validation = DB::table(self::TABLE_MASTER)
                        ->where('id', $id)
                        ->update([
                            'status' => $action_mapping[$action]['value'],
                            'updated_by' => $nik_session,
                            'updated_at' => Carbon::now()
                        ]);
                    Log::info("sql_update_validation : $sql_update_validation");
                    DB::commit();
                } catch (Exception $ex) {
                    DB::rollBack();

                    Log::error($ex->getMessage());
                    Log::error($ex->getTraceAsString());
                }

                $response_data['isSuccess'] = true;
                $response_data['message'] = $action_mapping[$action]['message'];
            }

        } else {
            $httpStatus = 401;
            $response_data['isSuccess'] = false;
            $response_data['errorMessage'] =  "Unauthorized Request";
        }

        return response()->json(data: $response_data);
    }

    private function getListPengawas(string $nikPengawas=null): array {
        $data_pengawas = [];
        try {
            $this->pengawas_produksi = explode(',', config('app.pengawas_produksi', ''));
            $data_pengawas = DB::connection('sqlsrv2')
                ->table('TKaryawan')
                ->select('nik', 'nama');

            if($nikPengawas==null) {
                $data_pengawas->whereIn('nik', $this->pengawas_produksi);
            } else {
                $data_pengawas->where('nik', $nikPengawas);
            }
            Log::debug("SQL : " . $data_pengawas->toRawSql());

            $data_pengawas = $data_pengawas->get()->toArray();
            Log::info(json_encode(array_column($data_pengawas, 'nik'), JSON_PRETTY_PRINT));
        } catch (Exception $ex) {

            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
        }

        return $data_pengawas;
    }

    private function getNamaFromListpengawas(string $nik, array $listPengawas): string {
        $nama_pengawas = "";
        
        foreach ($listPengawas as $key => $value) {
           if($listPengawas[$key]->nik == $nik) {
                $nama_pengawas = $listPengawas[$key]->nama;
           }
        }

        return $nama_pengawas;
    }
}
