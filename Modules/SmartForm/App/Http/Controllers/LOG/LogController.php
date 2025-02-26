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


    private const TABLE_MASTER = 'FM_LOG_002_REQUESTER_MASTER';
    private const TABLE_DETAIL = 'FM_LOG_002_REQUESTER_MASTER_DETAIL';

    public function download() {
        $pdf = Pdf::loadView('pdf');
 
        return $pdf->download();
    }

    // ***** START REQ MASTER *****
    public function RequestMasterDashboard()
    {
        return view('SmartForm::LOG/request-master');
    }

    function GetListRequestMaster(Request $request) {
        $TABLE_REQUEST_MASTER = "FM_LOG_002_REQUESTER_MASTER";
        $response = array(
            'message' => '',
            'isSuccess' => false
        );

        $sort = $request->query('sort', 'id'); // Default sort by id
        $order = $request->query('order', 'asc'); // Default order is ascending
        $offset = $request->query('offset', 0); // Default offset
        $limit = $request->query('limit', null); // Default limit
        $filter = $request->query('filter', null); // Default limit
        try {
            $master = DB::table($TABLE_REQUEST_MASTER)
                ->select('id', 'no_dok', 'site', 'created_by');
            
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
    
    function formReqMaster() {
        return view("SmartForm::log/form-request-master");
    }

    function SubmitFormRequestMaster(Request $req) {
        $TABLE_MASTER = "FM_LOG_002_REQUESTER_MASTER";
        $TABLE_DETAIL = "FM_LOG_002_REQUESTER_MASTER_DETAIL";
        $response = array(
            'message' => "",
            'isSuccess' => false
        );
        $tgl = now()->toDateTimeString();
        $requested_by = $req->session()->get('user_id');
        $data = $req->input();
        
        $data_insert = [
            'created_by' => $requested_by,
            'site' => $data['site'],
            'no_dok' => $data['noDoc'],
            'created_at' => $data['tglDoc'],
            'disetujui_oleh' => $data['disetujuiOleh']
        ];
        $spliited_no_doc = explode("/", $data_insert['no_dok']);
        $data_item = json_decode($data['item']);
        
        try {
            DB::beginTransaction();
            $id = DB::table($TABLE_MASTER)->insertGetId($data_insert);

            foreach ($data_item as $data_item_detail) {
                DB::table($TABLE_DETAIL)->insert(array(
                    'id_req_master' => $id,
                    'kode_master' => $data_item_detail->kodeMaster,
                    'part_name' => $data_item_detail->kodeMaster,
                    'uom' => $data_item_detail->partName,
                    'part_number' => $data_item_detail->uom,
                    'brand' => $data_item_detail->brand,
                    'gen_itc' => $data_item_detail->gen,
                    'model' => $data_item_detail->model,
                    'compartement' => $data_item_detail->compartement,
                    'fff_class' => $data_item_detail->fffC,
                    'plan_material_status' => $data_item_detail->planMatStatus,
                    'mrp_type' => $data_item_detail->mrpType,
                    'scrap' => $data_item_detail->scrap,
                    'material_type' => $data_item_detail->matType,
                    'material_group' => $data_item_detail->matGroup,
                    'valuation_class' => $data_item_detail->valuationStatus
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

    public function PdfReqMaster($id)
    {
        $TABLE_MASTER = "FM_LOG_002_REQUESTER_MASTER";
        $TABLE_DETAIL = "FM_LOG_002_REQUESTER_MASTER_DETAIL";
        $errors = array(
            'error' => false,
            'message' => ''
        );
        try {
            $data = DB::table($TABLE_MASTER)
                    ->select('id', 'no_dok','site','created_at','created_by','disetujui_oleh')
                    ->where('id', $id)
                    ->first();
                
            $data_detail = DB::table($TABLE_DETAIL)
                ->select('kode_master as kodeMaster','part_name as partName','uom', 'part_number as partNumber','brand','gen_itc as gen','model','compartement as cmp','fff_class as fC','plan_material_status as pms','mrp_type as mrpT','scrap','material_type as matType','material_group as matGroup','valuation_class as vC')
                ->where('id_req_master', $data->id)
                ->get();
            
            $nomor = 1;
            foreach($data_detail as $detail) {
                $detail->nomor = $nomor;            
                $nomor++;
            }
        
            $data_master['id'] = $data->id;
            $data_master['no_dok'] = $data->no_dok;
            $data_master['site'] = $data->site;
            $data_master['dibuat_tgl'] = $data->created_at;
            $data_master['dibuat_oleh'] = $data->created_by;
            $data_master['disetujui_oleh'] = $data->disetujui_oleh;
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
        }
        Log::info("data_master : ". json_encode($data_master));
        $pdf = PDF::loadView('SmartForm::LOG/req-master-pdf',  ['data' => $data_master, 'data_detail' => $data_detail, 'error' => $errors])->setPaper('a4', 'landscape');
        return $pdf->download('BSS-FRM-LOG-002.pdf');
    }
    // ***** END REQ MASTER *****

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
        $order = $request->query('order', 'desc');
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
                'nik' => session("user_id"),
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

        return $pdf->download('BSS-FRM-LOG-022.pdf');
    }
    // ***** END FUEL CONTROLLER *****

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
        return view("SmartForm::log/form-pengeluaran-oli");
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

    // ***** START PEMAKAIAN SOLAR *****
    public function PemakaianSolarDashboard()
    {
        return view('SmartForm::LOG/pemakaian-solar');
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
                ->select('id', 'no_dok', 'job_site as site', 'dibuat_oleh','no_fuel_station as fuel');
            
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

    function formPemakaianSolar() {
        return view("SmartForm::log/form-pemakaian-solar");
    }

    function SubmitFormPemakaianSolar(Request $req) {
        $TABLE_MASTER = "FM_LOG_037_PEMAKAIAN_SOLAR";
        $TABLE_DETAIL = "FM_LOG_037_PEMAKAIAN_SOLAR_DETAIL";
        $response = array(
            'message' => "",
            'isSuccess' => false
        );
        $tgl = now()->toDateTimeString();
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
            'diketahui_oleh' => $data['foreman']
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
            // $updated_no_doc = implode("/", $spliited_no_doc);

            // $affected = DB::table($TABLE_MASTER)
            //   ->where('id', $id)
            //   ->update(['no_dok' => $updated_no_doc]);

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
                    ->select('id', 'no_dok','revisi as revisi','halaman','tanggal','job_site as jobsite','no_fuel_station as noFuel','shift','dibuat_oleh as dibuat','diketahui_oleh as mengetahui','disetujui_oleh as approval')
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
            $data_master['shift'] = $data->shift;
            $data_master['mengetahui'] = $data->mengetahui;
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
        }
        Log::info("data_master : ". json_encode($data_master));
        $pdf = PDF::loadView('SmartForm::LOG/pemakaian-solar-pdf',  ['data' => $data_master, 'data_detail' => $data_detail, 'error' => $errors]);
        return $pdf->download('BSS-FRM-LOG-037.pdf');
    }
    // ***** END PEMAKAIAN SOLAR *****
}
