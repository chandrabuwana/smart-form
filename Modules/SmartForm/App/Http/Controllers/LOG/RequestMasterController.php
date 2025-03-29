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

class RequestMasterController extends Controller {


    private const TABLE_MASTER = 'FM_LOG_002_REQUESTER_MASTER';
    private const TABLE_DETAIL = 'FM_LOG_002_REQUESTER_MASTER_DETAIL';

    private const TABLE_SITES = 'tsite';
    private const TABLE_KARYAWAN = 'TKaryawan';

    private const LIST_KODE_PLANTS = [
        '' => '',
        'PL1' => 'PL1',
        'PL2' => 'PL2',
        'PL3' => 'PL3',
        'PL4' => 'PL4',
        'PL5' => 'PL5',
        'PL6' => 'PL6',
        'PL7' => 'PL7',
        'PL8' => 'PL8',
        'PL9' => 'PL9',
        'PL10' => 'PL10',
        'PL11' => 'PL11',
        'PL12' => 'PL12',
        'PL13' => 'PL13',
        'PL14' => 'PL14',
        'PL15' => 'PL15',
        'PL16' => 'PL16',
        'PL17' => 'PL17',
        'PL18' => 'PL18',
        'PL19' => 'PL19',
        'PL20' => 'PL20',
        'PL21' => 'PL21',
        'PL22' => 'PL22',
        'PL23' => 'PL23',
        'PL24' => 'PL24',
        'PL25' => 'PL25',
        'PL26' => 'PL26',
        'PL27' => 'PL27',
    ];
    private const LIST_UOMS = [
        '' => '',
        "BTG" => "BTG", 
        "BUK" => "BUK", 
        "PC" => "PC", 
        "SET" => "SET", 
        "KG" => "KG",
        "LBR" => "LBR", 
        "CM" => "CM", 
        "M" => "M", 
        "KLG" => "KLG", 
        "BOX" => "BOX",
        "DUS" => "DUS", 
        "BT" => "BT", 
        "AU" => "AU", 
        "PAC" => "PAC", 
        "STRIP" => "STRIP",
        "UN" => "UN", 
        "L" => "L", 
        "ROL" => "ROL", 
        "CAR" => "CAR",
        "M3" => "M3",
        "PL" => "PL", 
        "TBC" => "TBC", 
        "PAA" => "PAA", 
        "RIM" => "RIM", 
        "TAB" => "TAB",
        "PKT" => "PKT", 
        "EA" => "EA", 
        "SAK" => "SAK", 
        "KRG" => "KRG", 
        "DER" => "DER",
        "HM" => "HM", 
        "TUB" => "TUB", 
        "GAL" => "GAL", 
        "PRS" => "PRS"
    ];

    private const LIST_MATERIAL_TYPE = [
        '' => '',
        'SPRT' => 'SPRT',
        'FOGC' => 'FOGC',
        'TIRE' => 'TIRE',
        'CONS' => 'CONS',
        'GENS' => 'GENS',
        'ASET' => 'ASET',
        'SEJA' => 'SEJA',
        'MDLE' => 'MDLE',
        'BOMM' => 'BOMM',
        'FFF' => 'FFF'
    ];

    private const LIST_MATERIAL_GROUP = [
        '' => '',
        'S001' => 'S001',
        'S002' => 'S002',
        'S003' => 'S003',
        'S004' => 'S004',
        'S005' => 'S005',
        'S006' => 'S006',
        'F001' => 'F001',
        'F002' => 'F002',
        'F003' => 'F003',
        'F004' => 'F004',
        'T001' => 'T001',
        'G001' => 'G001',
        'G002' => 'G002',
        'C001' => 'C001',
        'C002' => 'C002',
        'C003' => 'C003',
        'C004' => 'C004',
        'C005' => 'C005',
        'C006' => 'C006',
        'C007' => 'C007',
        'A001' => 'A001',
        'A002' => 'A002',
        'A003' => 'A003',
        'A004' => 'A004',
        'A005' => 'A005',
        'A006' => 'A006',
        'J001' => 'J001',
        'J002' => 'J002',
        'J003' => 'J003',
        'J004' => 'J004',
        'J005' => 'J005',
        'J006' => 'J006',
        'J007' => 'J007',
        'J008' => 'J008',
        'J009' => 'J009',
        'J010' => 'J010',
        'J011' => 'J011',
        'J012' => 'J012',
        'J013' => 'J013',
        'J014' => 'J014',
        'M001' => 'M001'
    ];

    private const LIST_VALUATION_CLASS = [
        '' => '',
        'V001' => 'V001',
        'V002' => 'V002',
        'V003' => 'V003',
        'V004' => 'V004',
        'V005' => 'V005',
        'V006' => 'V006',
        'V007' => 'V007',
        'V008' => 'V008',
        'V009' => 'V009',
        'V010' => 'V010',
        'V011' => 'V011',
        'V012' => 'V012',
        'V013' => 'V013',
        'V014' => 'V014',
        'V015' => 'V015',
        'V016' => 'V016',
        'V017' => 'V017',
        'V018' => 'V018',
        'V019' => 'V019',
        'V020' => 'V020',
        'V021' => 'V021',
        'V022' => 'V022',
        'V023' => 'V023',
        'V024' => 'V024',
        'V025' => 'V025',
        'V026' => 'V026',
        'V027' => 'V027',
        'V028' => 'V028',
        'V029' => 'V029',
        'V030' => 'V030',
        'V032' => 'V032',
        'V033' => 'V033',
        'V034' => 'V034'
    ];

    private const LIST_PURCHASING_GROUP = [
        '' => '',
        'G01' => 'G01',
        'G02' => 'G02',
        'G03' => 'G03',
        'G04' => 'G04',
        'G05' => 'G05',
        'G06' => 'G06',
        'G07' => 'G07',
    ];

    private const LIST_SERIAL_NUMBERS = [
        '' => '',
        'SNI1' => 'SNI1',
        'SNI2' => 'SNI2',
        'SNI3' => 'SNI3',
    ];

    public function download() {
        $pdf = Pdf::loadView('pdf');
 
        return $pdf->download();
    }

    public function RequestMasterDashboard()
    {
        return view('SmartForm::LOG/request-master/dashboard-request-master');
    }

    // public function GetListRequestMaster(Request $request) {
    //     $TABLE_REQUEST_MASTER = "FM_LOG_002_REQUESTER_MASTER";
    //     $response = array(
    //         'message' => '',
    //         'isSuccess' => false
    //     );

    //     $sort = $request->query('sort', 'id'); // Default sort by id
    //     $order = $request->query('order', 'desc'); // Default order is desc
    //     $offset = $request->query('offset', 0); // Default offset
    //     $limit = $request->query('limit', null); // Default limit
    //     $filter = $request->query('filter', null); // Default limit
    //     try {
    //         // $master = DB::table($TABLE_REQUEST_MASTER)
    //         //     ->select('id', 'no_dok', 'site', 'created_by');
            

    //         $master = DB::table($TABLE_REQUEST_MASTER)
    //         ->select(
    //             $TABLE_REQUEST_MASTER.'.id', 
    //             $TABLE_REQUEST_MASTER.'.no_dok', 
    //             $TABLE_REQUEST_MASTER.'.site', 
    //             $TABLE_REQUEST_MASTER.'.created_by',
    //             DB::raw('(SELECT Nama FROM HRD.dbo.TKaryawan WHERE NIK = '.$TABLE_REQUEST_MASTER.'.created_by) as request_by'),
    //             DB::raw('(SELECT Nama FROM HRD.dbo.TKaryawan WHERE NIK = '.$TABLE_REQUEST_MASTER.'.cataloging_id) as cataloging_by'),
    //             $TABLE_REQUEST_MASTER.'.cataloging_update',
    //             DB::raw('(SELECT Nama FROM HRD.dbo.TKaryawan WHERE NIK = '.$TABLE_REQUEST_MASTER.'.disetujui_oleh) as approval_by'),
    //             $TABLE_REQUEST_MASTER.'.status_req',
    //             $TABLE_REQUEST_MASTER.'.created_at',
    //             $TABLE_REQUEST_MASTER.'.updated_at',
    //         );

    //         $master->orderBy($sort, $order);
    //         $jml = $master->count();            
    //         $document = $master->get();

    //         $response['message'] = "Ok";
    //         $response['isSuccess'] = true;
    //         $response['data'] = [
    //             'total' => $jml,
    //             'totalNotFiltered' => $jml,
    //             'rows' => $document
    //         ];

    //     } catch (Exception $ex) {
    //         Log::error($ex->getMessage());
    //         Log::error($ex->getTraceAsString());
            
    //         $response['message'] = $ex->getMessage();
    //         $response['isSuccess'] = false;
    //     }

    //     return response()->json($response);
    // }
    
    
    public function GetListRequestMaster(Request $request) {
        $TABLE_REQUEST_MASTER = "FM_LOG_002_REQUESTER_MASTER";
        $response = array(
            'message' => '',
            'isSuccess' => false
        );
    
        try {
            // Get pagination parameters
            $page = $request->query('offset', 0) / $request->query('limit', 10) + 1;
            $perPage = $request->query('limit', 10);
            $sort = $request->query('sort', 'id');
            $order = $request->query('order', 'desc');
            
            // Get filters from request
            $filters = $request->query('filters', []);
            $search = $request->query('search', '');
    
            $query = DB::table($TABLE_REQUEST_MASTER)
                ->select(
                    $TABLE_REQUEST_MASTER.'.id', 
                    $TABLE_REQUEST_MASTER.'.no_dok', 
                    $TABLE_REQUEST_MASTER.'.site', 
                    $TABLE_REQUEST_MASTER.'.created_by',
                    DB::raw('(SELECT Nama FROM HRD.dbo.TKaryawan WHERE NIK = '.$TABLE_REQUEST_MASTER.'.created_by) as request_by'),
                    DB::raw('(SELECT Nama FROM HRD.dbo.TKaryawan WHERE NIK = '.$TABLE_REQUEST_MASTER.'.cataloging_id) as cataloging_by'),
                    $TABLE_REQUEST_MASTER.'.cataloging_update',
                    DB::raw('(SELECT Nama FROM HRD.dbo.TKaryawan WHERE NIK = '.$TABLE_REQUEST_MASTER.'.disetujui_oleh) as approval_by'),
                    $TABLE_REQUEST_MASTER.'.status_req',
                    $TABLE_REQUEST_MASTER.'.created_at',
                    $TABLE_REQUEST_MASTER.'.updated_at',
                );
    
            // Apply filters
            foreach ($filters as $field => $value) {
                
                if ($value) {
                    if($field == 'request_by') {
                        $findUser = DB::connection('sqlsrv2')->table(self::TABLE_KARYAWAN)->where('Nama', 'like', '%' . $value . '%')->first();
                        
                        $query->where('created_by', $findUser->NIK);
                    } else{
                        $query->where($field, 'like', '%' . $value . '%');
                    }
                   
                }
            }
    
            // Apply search
            if ($search) {
                $query->where(function($q) use ($search, $TABLE_REQUEST_MASTER) {
                    $q->where($TABLE_REQUEST_MASTER.'.no_dok', 'like', '%' . $search . '%')
                      ->orWhere($TABLE_REQUEST_MASTER.'.site', 'like', '%' . $search . '%')
                      ->orWhere(DB::raw('(SELECT Nama FROM HRD.dbo.TKaryawan WHERE NIK = '.$TABLE_REQUEST_MASTER.'.created_by)'), 'like', '%' . $search . '%')
                      ->orWhere($TABLE_REQUEST_MASTER.'.status_req', 'like', '%' . $search . '%');
                });
            }
    
            // Get total count before pagination
            $total = $query->count();
    
            // Apply sorting and pagination
            $documents = $query->orderBy($sort, $order)
                              ->paginate($perPage, ['*'], 'page', $page);
    
            $response['message'] = "Ok";
            $response['isSuccess'] = true;
            $response['data'] = [
                'total' => $total,
                'totalNotFiltered' => $total, // This is important for bootstrap-table
                'rows' => $documents->items()
            ];
    
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            
            $response['message'] = $ex->getMessage();
            $response['isSuccess'] = false;
        }
    
        return response()->json($response);
    }
    
    public function formReqMaster() {
        $sites = DB::connection('sqlsrv2')->table(self::TABLE_SITES)->select(columns: 'KodeST')->get();
        $users = DB::connection('sqlsrv2')->table(self::TABLE_KARYAWAN)->select('NIK', 'nama')->get();
        $plants = Self::LIST_KODE_PLANTS;
        $uoms = Self::LIST_UOMS;
        $materialTypes = self::LIST_MATERIAL_TYPE;
        $materialGroups = self::LIST_MATERIAL_GROUP;
        $vulationClass = self::LIST_VALUATION_CLASS;
        $purchasingGroups = self::LIST_PURCHASING_GROUP;
        $serialNumbers = self::LIST_SERIAL_NUMBERS;

        return view("SmartForm::LOG.request-master.form-request-master", 
        compact('sites', 'users','plants','uoms','materialTypes','materialGroups','vulationClass','purchasingGroups','serialNumbers'));
    }

    public function SubmitFormRequestMaster(Request $req) {
        $TABLE_MASTER = self::TABLE_MASTER;
        $TABLE_DETAIL = self::TABLE_DETAIL;

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
            'disetujui_oleh' => $data['disetujuiOleh'],
            'cataloging_id' => $data['cataloging'],
            'kode_plant' => $data['kodePlant'],
            'status_req' => STATUS::OPEN,
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
                    'part_name' => $data_item_detail->partName,
                    'uom' => $data_item_detail->uom,
                    'part_number' => $data_item_detail->partNumber,
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
                    'valuation_class' => $data_item_detail->valuationStatus,
                    'purchasing_group' => $data_item_detail->purchasingGroup,
                    'serial_number' => $data_item_detail->serialNumber,
                    // 'req' => $data_item_detail->requested_by,
                    // 'date' => $data_item_detail->date,
                    // 'site' => $data_item_detail->site
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
                    ->select('id', 'no_dok','site','created_at','created_by','disetujui_oleh','cataloging_id')
                    ->where('id', $id)
                    ->first();
                
            // $data_detail = DB::table($TABLE_DETAIL)
            //     ->select('kode_master as kodeMaster','part_name as partName','uom', 'part_number as partNumber','brand','gen_itc as gen','model','compartement as cmp','fff_class as fC','plan_material_status as pms','mrp_type as mrpT','scrap','material_type as matType','material_group as matGroup','valuation_class as vC','req','date','site')
            //     ->where('id_req_master', $data->id)
            //     ->get();

            $data_detail = DB::table($TABLE_DETAIL)
            ->select('kode_master as kodeMaster','part_name as partName','uom', 'part_number as partNumber','brand','gen_itc as gen','model','compartement','fff_class as fffC','plan_material_status as planMatStatus','mrp_type as mrpType','scrap','material_type as matType','material_group as matGroup','valuation_class as valuationStatus','req','date','site','serial_number as serialNumber','purchasing_group as purchasingGroup')
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
            $data_master['diproses_oleh'] = DB::connection('sqlsrv2')->table(self::TABLE_KARYAWAN)->where('NIK', $data->cataloging_id)->value('Nama');
            $data_master['dibuat_oleh'] = DB::connection('sqlsrv2')->table(self::TABLE_KARYAWAN)->where('NIK', $data->created_by)->value('Nama');
            $data_master['disetujui_oleh'] = DB::connection('sqlsrv2')->table(self::TABLE_KARYAWAN)->where('NIK', $data->disetujui_oleh)->value('Nama');
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
        }
        Log::info("data_master : ". json_encode($data_master));
        $pdf = PDF::loadView('SmartForm::LOG/request-master/req-master-pdf',  ['data' => $data_master, 'data_detail' => $data_detail, 'error' => $errors])->setPaper('a4', 'landscape');
        return $pdf->download($data->no_dok.'.pdf');
    }

    public function GetDetail($request, $id, $returnJson = false){
        $TABLE_MASTER = "FM_LOG_002_REQUESTER_MASTER";
        $TABLE_DETAIL = "FM_LOG_002_REQUESTER_MASTER_DETAIL";
        $isError = true;
        $errorMessage = '';
        $response = array(
            'message' => '',
            'isSuccess' => false
        );

        try {
            $sites = DB::connection('sqlsrv2')->table(self::TABLE_SITES)->select('KodeST')->get();
            $users = DB::connection('sqlsrv2')->table(self::TABLE_KARYAWAN)->select('NIK', 'nama')->get();
            $plants = Self::LIST_KODE_PLANTS;
            $uoms = Self::LIST_UOMS;
            $materialTypes = self::LIST_MATERIAL_TYPE;
            $materialGroups = self::LIST_MATERIAL_GROUP;
            $vulationClass = self::LIST_VALUATION_CLASS;
            $purchasingGroups = self::LIST_PURCHASING_GROUP;
            $serialNumbers = self::LIST_SERIAL_NUMBERS;


            $master = DB::table($TABLE_MASTER)
                ->select(
                    $TABLE_MASTER.'.id', 
                    $TABLE_MASTER.'.no_dok', 
                    $TABLE_MASTER.'.site', 
                    DB::raw('(SELECT Nama FROM HRD.dbo.TKaryawan WHERE NIK = '.$TABLE_MASTER.'.created_by) as created_by'),
                    $TABLE_MASTER.'.created_at',
                    $TABLE_MASTER.'.disetujui_oleh',
                    $TABLE_MASTER.'.diproses_oleh',
                    $TABLE_MASTER.'.diketahui_oleh',
                    DB::raw('(SELECT Nama FROM HRD.dbo.TKaryawan WHERE NIK = '.$TABLE_MASTER.'.updated_by) as updated_by'),
                    $TABLE_MASTER.'.updated_at',
                    $TABLE_MASTER.'.cataloging_id',
                    $TABLE_MASTER.'.cataloging_update',
                    $TABLE_MASTER.'.status_req',
                    $TABLE_MASTER.'.kode_plant',
                    $TABLE_MASTER.'.remark',
                )
                ->where('id', $id)
                ->first();
            
            $detail = DB::table($TABLE_DETAIL)
                ->select('kode_master as kodeMaster','part_name as partName','uom', 'part_number as partNumber','brand','gen_itc as gen','model','compartement','fff_class as fffC','plan_material_status as planMatStatus','mrp_type as mrpType','scrap','material_type as matType','material_group as matGroup','valuation_class as valuationStatus','req','date','site','serial_number as serialNumber','purchasing_group as purchasingGroup')
                ->where('id_req_master', $master->id)
                ->get();

            $response['message'] = "Ok";
            $response['isSuccess'] = true;
            $response['data'] = [
                'master' => $master,
                'detail' => $detail,
                'sites' => $sites,
                'users' => $users,
                'plants' => $plants,
                'uoms' => $uoms,
                'materialTypes' => $materialTypes,
                'materialGroups' => $materialGroups,
                'vulationClass' => $vulationClass,
                'purchasingGroups' => $purchasingGroups,
                'serialNumbers' => $serialNumbers
            ];


        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            
            $response['message'] = $ex->getMessage();
            $response['isSuccess'] = false;
        }

        return $returnJson ? response()->json($response) : $response;
    }

    public function EditReqMaster(Request $request){
        $id = $request->query('id');
        $response = $this->getDetail($request, $id);
        
        // Convert response to array if it's a JsonResponse
        $responseData = $response instanceof \Illuminate\Http\JsonResponse 
            ? $response->getData(true) 
            : (array)$response;

        Log::debug('response edit: '. json_encode($responseData, JSON_PRETTY_PRINT));

        return view('SmartForm::LOG/request-master/edit-form-req-master', $responseData);
    }

    
    public function CatalogViewReqMaster(Request $request){
        $id = $request->query('id');
        $nik_session = $request->session()->get('user_id', '');
        $response = $this->getDetail($request, $id);
        
        // Convert response to array if it's a JsonResponse
        $responseData = $response instanceof \Illuminate\Http\JsonResponse 
            ? $response->getData(true) 
            : (array)$response;

        Log::debug('response detail: '. json_encode($responseData, JSON_PRETTY_PRINT));

        return view('SmartForm::LOG/request-master/cataloging-form-req-master', $responseData);
    }

    

    public function UpdateFormRequestMaster(Request $req) {
        $TABLE_MASTER = self::TABLE_MASTER;
        $TABLE_DETAIL = self::TABLE_DETAIL;

        $response = array(
            'message' => "",
            'isSuccess' => false
        );
        
        $requested_by = $req->session()->get('user_id');
        $data = $req->input();
        

        $data_item = json_decode($data['item']);
        
        $data_update = [
            'site' => $data['site'],
            'no_dok' => $data['noDoc'],
            //'disetujui_oleh' => $data['disetujuiOleh'],
            'updated_by' => $requested_by,
            'updated_at' => now()->toDateTimeString(),
            //'cataloging_id' => $data['cataloging'],
            'kode_plant' => $data['kodePlant'],
            'status_req' => STATUS::OPEN,
        ];


        if ($data['isCataloging'] == 1) {
            $data_update['cataloging_update'] = now()->toDateTimeString();
        }


        // Check if any kode_master is null in data_item
        $hasNullKodeMaster = false;
        foreach ($data_item as $item) {
            if (empty($item->kodeMaster)) {
                $hasNullKodeMaster = true;
                break;
            }
        }
       // Update status based on kode_master values
        $data_update['status_req'] = $hasNullKodeMaster ? STATUS::OPEN : STATUS::CLOSE;

        $id = $data['id']; 
        
        try {
            DB::beginTransaction();
            
            // Update master record
            $affected = DB::table($TABLE_MASTER)
                ->where('id', $id)
                ->update($data_update);
            
            // First delete all existing detail records
            DB::table($TABLE_DETAIL)
                ->where('id_req_master', $id)
                ->delete();
            
            // Then insert the updated detail records
            foreach ($data_item as $data_item_detail) {
                DB::table($TABLE_DETAIL)->insert(array(
                    'id_req_master' => $id,
                    'kode_master' => $data_item_detail->kodeMaster,
                    'part_name' => $data_item_detail->partName,
                    'uom' => $data_item_detail->uom,
                    'part_number' => $data_item_detail->partNumber,
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
                    'valuation_class' => $data_item_detail->valuationStatus,
                    'purchasing_group' => $data_item_detail->purchasingGroup,
                    'serial_number' => $data_item_detail->serialNumber,
                ));
            }
    
            DB::commit();
    
            $response['message'] = "Update successful";
            $response['isSuccess'] = true;
            $response['data'] = array(
                'no_doc' => $data_update['no_dok']
            );
        } catch (Exception $ex) {
            Log::error($ex->getTraceAsString());
            DB::rollBack();
            $response['message'] = $ex->getMessage();
            $response['isSuccess'] = false;
        }
    
        return response()->json($response);
    }

    public function DetailReqMaster(Request $request){
        $id = $request->query('id');
        $nik_session = $request->session()->get('user_id', '');
        $response = $this->getDetail($request, $id);
        
        // Convert response to array if it's a JsonResponse
        $responseData = $response instanceof \Illuminate\Http\JsonResponse 
            ? $response->getData(true) 
            : (array)$response;

        Log::debug('response detail: '. json_encode($responseData, JSON_PRETTY_PRINT));

        return view('SmartForm::LOG/request-master/detail-form-req-master', $responseData);
    }


    public function ApproveRejectRequestMaster(Request $request)
    {
        $TABLE_MASTER = self::TABLE_MASTER;

        try {
            $request->validate([
                'id' => 'required|integer',
                'noDoc' => 'required|string',
                'disetujuiOleh' => 'required|integer',
                'action' => 'required|string|in:approve,reject',
                'remark' => 'nullable|string'
            ]);

            // Using DB::table() with where()->first() instead of findOrFail()
            $requestMaster = DB::table($TABLE_MASTER)->where('id', $request->id)->first();
            
            if (!$requestMaster) {
                return response()->json([
                    'success' => false,
                    'message' => 'Document not found'
                ], 404);
            }

            // Authorization check
            if (session('user_id') != $requestMaster->disetujui_oleh) {
                return response()->json([
                    'success' => false,
                    'message' => 'You are not authorized to perform this action'
                ], 403);
            }

            // Update status based on action
            $updateData = [
                'status_req' => $request->action === 'approve' ? STATUS::APPROVED : STATUS::REJECTED,
                'updated_at' => now(),
                'updated_by' => session('user_id'),
                'remark' => $request->remark
            ];

            DB::table($TABLE_MASTER)
                ->where('id', $request->id)
                ->update($updateData);

            $message = 'Document ' . $request->noDoc . ' ' . $request->action . 'ed successfully';

            // If you need the updated record, fetch it again
            $updatedRecord = DB::table($TABLE_MASTER)->find($request->id);

            return response()->json([
                'success' => true,
                'data' => $updatedRecord,
                'message' => $message
            ]);

        } catch (Exception $e) {
            Log::error($e->getTraceAsString());
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

}

class STATUS {
    const OPEN = 'OPEN';
    const CLOSE = 'CLOSE';
    const APPROVED = 'APPROVED';
    const REJECTED = 'REJECTED';
}
