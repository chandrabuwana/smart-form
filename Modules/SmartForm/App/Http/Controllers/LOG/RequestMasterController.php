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

    private const LIST_SITES = [
        '' => '--- Pilih Site ---',
        'AGM' => 'AGM',
        'MBL' => 'MBL',
        'MME' => 'MME',
        'MAS' => 'MAS',
        'PMSS' => 'PMSS',
        'TAJ' => 'TAJ',
        'BSSR' => 'BSSR',
        'TDM' => 'TDM',
        'MSJ' => 'MSJ',
    ];

    private const LIST_APPROVALS = [
        '' => '--- Pilih Approval ---',
        'Planner HO' => 'Planner HO',
    ];

    public function download() {
        $pdf = Pdf::loadView('pdf');
 
        return $pdf->download();
    }

    public function RequestMasterDashboard()
    {
        return view('SmartForm::LOG/request-master/dashboard-request-master');
    }

    public function GetListRequestMaster(Request $request) {
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
    
    public function formReqMaster() {
        return view("SmartForm::LOG/request-master/form-request-master");
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
                    'valuation_class' => $data_item_detail->valuationStatus,
                    'req' => $data_item_detail->req,
                    'date' => $data_item_detail->date,
                    'site' => $data_item_detail->site
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
                ->select('kode_master as kodeMaster','part_name as partName','uom', 'part_number as partNumber','brand','gen_itc as gen','model','compartement as cmp','fff_class as fC','plan_material_status as pms','mrp_type as mrpT','scrap','material_type as matType','material_group as matGroup','valuation_class as vC','req','date','site')
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
        $pdf = PDF::loadView('SmartForm::LOG/request-master/req-master-pdf',  ['data' => $data_master, 'data_detail' => $data_detail, 'error' => $errors])->setPaper('a4', 'landscape');
        return $pdf->download('BSS-FRM-LOG-002.pdf');
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
            $master = DB::table($TABLE_MASTER)
                ->select('id', 'no_dok', 'site', 'created_by', 'created_at','disetujui_oleh','diproses_oleh','diketahui_oleh','updated_by','updated_at')
                ->where('id', $id)
                ->first();
            
            $detail = DB::table($TABLE_DETAIL)
                ->select('kode_master as kodeMaster','part_name as partName','uom', 'part_number as partNumber','brand','gen_itc as gen','model','compartement','fff_class as fffC','plan_material_status as planMatStatus','mrp_type as mrpType','scrap','material_type as matType','material_group as matGroup','valuation_class as valuationStatus','req','date','site')
                ->where('id_req_master', $master->id)
                ->get();

            $response['message'] = "Ok";
            $response['isSuccess'] = true;
            $response['data'] = [
                'master' => $master,
                'detail' => $detail
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
        $nik_session = $request->session()->get('user_id', '');
        $response = $this->getDetail($request, $id);
        
        // Convert response to array if it's a JsonResponse
        $responseData = $response instanceof \Illuminate\Http\JsonResponse 
            ? $response->getData(true) 
            : (array)$response;

        Log::debug('response edit: '. json_encode($responseData, JSON_PRETTY_PRINT));

      

        $responseData['sites'] = self::LIST_SITES;
        $responseData['approvals'] = self::LIST_APPROVALS;
        return view('SmartForm::LOG/request-master/edit-form-req-master', $responseData);
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
        
        $data_update = [
            'site' => $data['site'],
            'no_dok' => $data['noDoc'],
            'disetujui_oleh' => $data['disetujuiOleh'],
            'updated_by' => $requested_by,
            'updated_at' => now()->toDateTimeString()
        ];
        
        $data_item = json_decode($data['item']);
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
                    'valuation_class' => $data_item_detail->valuationStatus,
                    'req' => $data_item_detail->req,
                    'date' => $data_item_detail->date,
                    'site' => $data_item_detail->site
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

      

        $responseData['sites'] = self::LIST_SITES;
        $responseData['approvals'] = self::LIST_APPROVALS;
        return view('SmartForm::LOG/request-master/detail-form-req-master', $responseData);
    }

}
