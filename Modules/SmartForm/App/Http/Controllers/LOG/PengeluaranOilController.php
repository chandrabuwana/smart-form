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
use Modules\SmartForm\helpers\Status;

class PengeluaranOilController extends Controller {

    private const TABLE_MASTER = "FM_LOG_034_PENGELUARAN_OLI";
    private const TABLE_DETAIL = "FM_LOG_034_PENGELUARAN_OLI_DETAIL";
    private const TABLE_SITES = 'tsite';
    private const TABLE_KARYAWAN = 'TKaryawan';

    private const LIST_SHIFT = [
        'DS' => 'DS',
        'NS' => 'NS',
    ];

    private const LIST_JENIS = [
        "" => "",
        'COOLANT' => 'COOLANT',
        'GREASE' => 'GREASE',
        'OIL' => 'OIL',
    ];

    private const LIST_MERKS = [
        "" => "",
        "2000000202 - SEIKEN COOLANT 50%" => "2000000202 - SEIKEN COOLANT 50%",
        "2000000044 - COOLANT MULTIROAD RECO COOL" => "2000000044 - COOLANT MULTIROAD RECO COOL",
        "2000000056 - SYCG-AF-NACDMPZ" => "2000000056 - SYCG-AF-NACDMPZ",
        "2000000201 - COOLANT MULTIROAD RECO COOL" => "2000000201 - COOLANT MULTIROAD RECO COOL",
        "2000000066 - S2 V220-2" => "2000000066 - S2 V220-2",
        "2000000013 - EPX-NL 2" => "2000000013 - EPX-NL 2",
        "2000000020 - 15W-40 DH-1" => "2000000020 - 15W-40 DH-1",
        "2000000088 - EO15W/40 KGO" => "2000000088 - EO15W/40 KGO",
        "2000000018 - RIMULA R3 MV 15W-40" => "2000000018 - RIMULA R3 MV 15W-40",
        "2000000077 - HTCG1490" => "2000000077 - HTCG1490",
        "2000000015 - SPIRAX S2 A 85W-140" => "2000000015 - SPIRAX S2 A 85W-140",
        "2000000010 - SAE 10" => "2000000010 - SAE 10",
        "2000000023 - HTC46TP" => "2000000023 - HTC46TP",
        "2000000025 - SHELL TELLUS 46" => "2000000025 - SHELL TELLUS 46",
        "2000000017 - RIMULA R2 30W" => "2000000017 - RIMULA R2 30W",
        "2000000630 - S6 ATF A295" => "2000000630 - S6 ATF A295",
        "2000000096 - 75W-80" => "2000000096 - 75W-80",
        "2000000092 - T030 KGO" => "2000000092 - T030 KGO",
        "2000000006 - SAE 15W/40" => "2000000006 - SAE 15W/40",
        "2000000007 - T030 SAE 30" => "2000000007 - T030 SAE 30",
        "2000000008 - T010 SAE 10" => "2000000008 - T010 SAE 10",
        "2000000014 - SPIRAX S2 A 80W-90" => "2000000014 - SPIRAX S2 A 80W-90",
        "2000000019 - TELLUS 68" => "2000000019 - TELLUS 68",
        "2000000049 - S2 M46" => "2000000049 - S2 M46",
        "2000000051 - RIMULA R2 10W" => "2000000051 - RIMULA R2 10W",
        "2000000043 - KGO-H046" => "2000000043 - KGO-H046"
    ];

    private const LIST_COMPONENT = [
        "" => "",
        "ENGINE" => "ENGINE",
        "TRANSMISSION" => "TRANSMISSION",
        "FINAL DRIVE LH" => "FINAL DRIVE LH",
        "FINAL DRIVE RH" => "FINAL DRIVE RH",
        "HYDRAULIC" => "HYDRAULIC",
        "PTO" => "PTO",
        "SWING" => "SWING",
        "RADIATOR" => "RADIATOR",
        "DAMPER" => "DAMPER",
        "DIFFERENTIAL FRONT" => "DIFFERENTIAL FRONT",
        "DIFFERENTIAL CENTER" => "DIFFERENTIAL CENTER",
        "DIFFERENTIAL REAR" => "DIFFERENTIAL REAR",
        "DIFFERENTIAL" => "DIFFERENTIAL",
        "TRANSFER" => "TRANSFER",
        "BRAKE COOLING" => "BRAKE COOLING",
        "GEAR BOX" => "GEAR BOX",
        "TRANSFER CASE" => "TRANSFER CASE",
        "TANDEM RH" => "TANDEM RH",
        "TANDEM LH" => "TANDEM LH",
        "FRONT HUB LH" => "FRONT HUB LH",
        "FRONT HUB RH" => "FRONT HUB RH",
        "LUBRICATION LINE" => "LUBRICATION LINE",
        "BRAKE" => "BRAKE",
        "PIVOT" => "PIVOT",
        "SUSPENSION RR RH" => "SUSPENSION RR RH",
        "SUSPENSION RR LH" => "SUSPENSION RR LH",
        "TRACK ADJUSTER" => "TRACK ADJUSTER",
        "CIRCLE" => "CIRCLE",
        "ROTARY" => "ROTARY",
        "FINAL DRIVE RR RH" => "FINAL DRIVE RR RH",
        "FINAL DRIVE RR LH" => "FINAL DRIVE RR LH",
        "SWING FRONT" => "SWING FRONT",
        "SWING REAR" => "SWING REAR",
        "SWING RH" => "SWING RH",
        "SWING LH" => "SWING LH",
        "RESERVOIR" => "RESERVOIR",
        "COMPRESOR" => "COMPRESOR",
        "TELESCOPIC" => "TELESCOPIC",
        "STEERING" => "STEERING",
        "BAKE SHAFT" => "BAKE SHAFT",
        "TRAVEL REDUCTION GEAR RH" => "TRAVEL REDUCTION GEAR RH",
        "TRAVEL REDUCTION GEAR LH" => "TRAVEL REDUCTION GEAR LH",
        "MAIN PUMP" => "MAIN PUMP",
        "SUBTANK" => "SUBTANK",
        "FIBRASI DRUM" => "FIBRASI DRUM"
    ];

    private const LIST_REMARKS = [
        "" => "",
        "ADD" => "ADD",
        "CHANGE" => "CHANGE",
        "GREASING" => "GREASING",
        "REKONDISI" => "REKONDISI",
        "BREAKDOWN" => "BREAKDOWN"
    ];


    public function PengeluaranOliDashboard()
    {
        return view('SmartForm::LOG/pengeluaran-oli/dashboard-pengeluaran-oil');
    }

    public function GetListPengeluaranOli(Request $request) {
        $TABLE_PENGELUARAN_OLI = "FM_LOG_034_PENGELUARAN_OLI";
        $TABLE_KARYAWAN = "HRD.dbo.TKaryawan";
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
    
            $query = DB::table($TABLE_PENGELUARAN_OLI)
                ->select(
                    $TABLE_PENGELUARAN_OLI.'.id', 
                    $TABLE_PENGELUARAN_OLI.'.no_dok', 
                    $TABLE_PENGELUARAN_OLI.'.job_site as site', 
                    $TABLE_PENGELUARAN_OLI.'.no_lube_station as lube',
                    $TABLE_PENGELUARAN_OLI.'.status_req',
                    $TABLE_PENGELUARAN_OLI.'.dilaporkan_oleh',
                    $TABLE_PENGELUARAN_OLI.'.diketahui_oleh',
                    DB::raw('(SELECT Nama FROM '.$TABLE_KARYAWAN.' WHERE NIK = '.$TABLE_PENGELUARAN_OLI.'.dilaporkan_oleh) as reported_by_name'),
                    $TABLE_PENGELUARAN_OLI.'.created_at',
                    DB::raw('(SELECT Nama FROM '.$TABLE_KARYAWAN.' WHERE NIK = '.$TABLE_PENGELUARAN_OLI.'.diketahui_oleh) as approval_by'),
                    $TABLE_PENGELUARAN_OLI.'.updated_at'
                )->where('status_req', '!=', STATUS::DELETED);
    
            // Apply filters
            foreach ($filters as $field => $value) {
                if ($value) {
                    if ($field === 'dilaporkan_oleh') {
                        $findUser = DB::connection('sqlsrv2')->table($TABLE_KARYAWAN)
                            ->where('Nama', 'like', '%' . $value . '%')
                            ->first();
                        
                        if ($findUser) {    
                            $query->where($TABLE_PENGELUARAN_OLI.'.dilaporkan_oleh', $findUser->NIK);
                        } else {
                            $query->where($TABLE_PENGELUARAN_OLI.'.dilaporkan_oleh', null);
                        }
                    } else {
                        $query->where($TABLE_PENGELUARAN_OLI.'.'.$field, 'like', '%' . $value . '%');
                    }
                }
            }
    
            // Apply search
            if ($search) {
                $query->where(function($q) use ($search, $TABLE_PENGELUARAN_OLI, $TABLE_KARYAWAN) {
                    $q->where($TABLE_PENGELUARAN_OLI.'.no_dok', 'like', '%' . $search . '%')
                      ->orWhere($TABLE_PENGELUARAN_OLI.'.job_site', 'like', '%' . $search . '%')
                      ->orWhere($TABLE_PENGELUARAN_OLI.'.no_lube_station', 'like', '%' . $search . '%')
                      ->orWhere(DB::raw('(SELECT Nama FROM '.$TABLE_KARYAWAN.' WHERE NIK = '.$TABLE_PENGELUARAN_OLI.'.dilaporkan_oleh)'), 'like', '%' . $search . '%');
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
                'totalNotFiltered' => $total,
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

    public function formPengeluaranOli() {
        $sites = DB::connection('sqlsrv2')->table(self::TABLE_SITES)->select(columns: 'KodeST')->get();
        $users = DB::connection('sqlsrv2')->table(self::TABLE_KARYAWAN)->select('NIK', 'nama')->get();
        $shifts = self::LIST_SHIFT;
        $jenis = self::LIST_JENIS;
        $merks = self::LIST_MERKS;
        $components = self::LIST_COMPONENT;
        $remarks = self::LIST_REMARKS;


        return view("SmartForm::LOG/pengeluaran-oli/form-pengeluaran-oli",
        compact('sites','users','shifts','jenis','merks','components','remarks'));
    }

    function SubmitFormPengeluaranOli(Request $req) {
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
            'no_dok' => $data['noDoc'],
            'revisi' => "1",
            'created_at' => $data['tglDoc'],
            'halaman' => "1 dari 1",
            'job_site' => $data['jobSite'],
            'no_lube_station' => $data['lube'],
            'shift' => $data['shift'],
            'dilaporkan_oleh' => $requested_by,
            'diketahui_oleh' => $data['foreman'],
            'status_req' => STATUS::NEED_APPROVAL,
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
        $TABLE_MASTER = self::TABLE_MASTER;
        $TABLE_DETAIL = self::TABLE_DETAIL;
        $errors = array(
            'error' => false,
            'message' => ''
        );
        try {
            $data = DB::table($TABLE_MASTER)
                ->select(  
                $TABLE_MASTER.'.id', 
                    $TABLE_MASTER.'.no_dok', 
                    $TABLE_MASTER.'.revisi', 
                    $TABLE_MASTER.'.status_req',
                    $TABLE_MASTER.'.job_site AS site',
                    $TABLE_MASTER.'.no_lube_station AS lube',
                    $TABLE_MASTER.'.shift', 
                    $TABLE_MASTER.'.dilaporkan_oleh',
                    DB::raw('(SELECT Nama FROM HRD.dbo.TKaryawan WHERE NIK = '.$TABLE_MASTER.'.dilaporkan_oleh) as created_by'),
                    $TABLE_MASTER.'.created_at',
                    $TABLE_MASTER.'.diketahui_oleh',
                    DB::raw('(SELECT Nama FROM HRD.dbo.TKaryawan WHERE NIK = '.$TABLE_MASTER.'.diketahui_oleh) as approvad_by'),
                    DB::raw('(SELECT Nama FROM HRD.dbo.TKaryawan WHERE NIK = '.$TABLE_MASTER.'.updated_by) as updated_by'),
                    $TABLE_MASTER.'.updated_at',
                    $TABLE_MASTER.'.remark',
                )
                ->where('id', $id)
                ->first();

            if (!$data) {
                throw new Exception("Data not found");
            }
                
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
            $data_master['revisi'] = $data->revisi;
            $data_master['jobsite'] = $data->site;
            $data_master['tanggal'] = $data->created_at;
            $data_master['pelapor'] = $data->created_by;
            $data_master['mengetahui'] = $data->approvad_by;
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
        }
        Log::info("data_master : ". json_encode($data_master));
        $pdf = PDF::loadView('SmartForm::LOG/pengeluaran-oli/pengeluaran-oli-pdf',  ['data' => $data_master, 'data_detail' => $data_detail, 'error' => $errors])->setPaper('a4', 'landscape');
        return $pdf->download($data->no_dok.'.pdf');
    }

    public function GetDetail($request, $id, $returnJson = false){
        $TABLE_MASTER = self::TABLE_MASTER;
        $TABLE_DETAIL = self::TABLE_DETAIL;
        $isError = true;
        $errorMessage = '';
        $response = array(
            'message' => '',
            'isSuccess' => false
        );

        try {
            $sites = DB::connection('sqlsrv2')->table(self::TABLE_SITES)->select(columns: 'KodeST')->get();
            $users = DB::connection('sqlsrv2')->table(self::TABLE_KARYAWAN)->select('NIK', 'nama')->get();
            $shifts = self::LIST_SHIFT;
            $jenis = self::LIST_JENIS;
            $merks = self::LIST_MERKS;
            $components = self::LIST_COMPONENT;
            $remarks = self::LIST_REMARKS;

            $data = DB::table($TABLE_MASTER)
                ->select(  
                $TABLE_MASTER.'.id', 
                    $TABLE_MASTER.'.no_dok', 
                    $TABLE_MASTER.'.status_req',
                    $TABLE_MASTER.'.job_site AS site',
                    $TABLE_MASTER.'.no_lube_station AS lube',
                    $TABLE_MASTER.'.shift', 
                    $TABLE_MASTER.'.dilaporkan_oleh',
                    DB::raw('(SELECT Nama FROM HRD.dbo.TKaryawan WHERE NIK = '.$TABLE_MASTER.'.dilaporkan_oleh) as created_by'),
                    $TABLE_MASTER.'.created_at',
                    $TABLE_MASTER.'.diketahui_oleh',
                    DB::raw('(SELECT Nama FROM HRD.dbo.TKaryawan WHERE NIK = '.$TABLE_MASTER.'.diketahui_oleh) as approvad_by'),
                    DB::raw('(SELECT Nama FROM HRD.dbo.TKaryawan WHERE NIK = '.$TABLE_MASTER.'.updated_by) as updated_by'),
                    $TABLE_MASTER.'.updated_at',
                    $TABLE_MASTER.'.remark',
                )
                ->where('id', $id)->where('status_req', '!=', STATUS::DELETED)
                ->first();

            if (!$data) {
                throw new Exception("Data not found");
            }

            $data_detail = DB::table($TABLE_DETAIL)
                ->select('id_peng_oli', 'unit', 'time', 'hm', 'jenis', 'merk', 'awal', 'akhir', 'qty', 'component AS compo', 'remark', 'pic_nama as pic')
                ->where('id_peng_oli', $data->id)
                ->get();

            $response['message'] = "Ok";
            $response['isSuccess'] = true;
            $response['data'] = [
                'master' => $data,
                'detail' => $data_detail,
                'sites' => $sites,
                'users' => $users,
                'shifts' => $shifts,
                'jenis' => $jenis,
                'merks' => $merks,
                'components' => $components,
                'remarks' => $remarks
            ];

        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            
            $response['message'] = $ex->getMessage();
            $response['isSuccess'] = false;
        }
    
        return $returnJson ? response()->json($response) : $response;
    }

    public function EditPengeluaranOli(Request $request){
        $id = $request->query('id');
        $response = $this->getDetail($request, $id);
        
        // Convert response to array if it's a JsonResponse
        $responseData = $response instanceof \Illuminate\Http\JsonResponse 
            ? $response->getData(true) 
            : (array)$response;
        //dd($responseData);
        Log::debug('response edit: '. json_encode($responseData, JSON_PRETTY_PRINT));

        return view('SmartForm::LOG/pengeluaran-oli/edit-form-pengeluaran-oli', $responseData);
    }

    
    public function UpdateFormPengeluaranOli(Request $req) {
        $TABLE_MASTER = "FM_LOG_034_PENGELUARAN_OLI";
        $TABLE_DETAIL = "FM_LOG_034_PENGELUARAN_OLI_DETAIL";

        $response = array(
            'message' => "",
            'isSuccess' => false
        );
        
        $requested_by = $req->session()->get('user_id');
        $data = $req->input();
        
        $id = $data['id']; 

        $data_item = json_decode($data['item']);
        
        $master = DB::table($TABLE_MASTER)
                ->select()
                ->where('id', $id)
                ->first();

        $data_update = [
            'no_dok' => $data['noDoc'],
            'revisi' => $master->revisi + 1,
            //'created_at' => $data['tglDoc'],
            'job_site' => $data['jobSite'],
            //'no_lube_station' => $data['lube'],
            'shift' => $data['shift'],
            //'dilaporkan_oleh' => $requested_by,
            'diketahui_oleh' => $data['foreman'],
            'status_req' => STATUS::NEED_APPROVAL,
            'updated_by' => $requested_by,
            'updated_at' => now()->toDateTimeString(),
        ];

        try {
            DB::beginTransaction();
            
            // Update master record
            $affected = DB::table($TABLE_MASTER)
                ->where('id', $id)
                ->update($data_update);
            
            // First delete all existing detail records
            DB::table($TABLE_DETAIL)
                ->where('id_peng_oli', $id)
                ->delete();
            
            // Then insert the updated detail records
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

    public function DetailPengeluaranOli(Request $request){
        $id = $request->query('id');
        $response = $this->getDetail($request, $id);
        
        // Convert response to array if it's a JsonResponse
        $responseData = $response instanceof \Illuminate\Http\JsonResponse 
            ? $response->getData(true) 
            : (array)$response;
        //dd($responseData);
        Log::debug('response edit: '. json_encode($responseData, JSON_PRETTY_PRINT));

        return view('SmartForm::LOG/pengeluaran-oli/detail-form-pengeluaran-oli', $responseData);
    }

    public function ApproveRejectPengeluaranOli(Request $request)
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
            $PengeluaranOli = DB::table($TABLE_MASTER)->where('id', $request->id)->first();
            
            if (!$PengeluaranOli) {
                return response()->json([
                    'success' => false,
                    'message' => 'Document not found'
                ], 404);
            }

            // Authorization check
            if (session('user_id') != $PengeluaranOli->diketahui_oleh) {
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

    public function DeletePengeluaranOli(Request $request) {
        $TABLE_MASTER = self::TABLE_MASTER;

        $response = array(
            'message' => "",
            'isSuccess' => false
        );
        
        $id = $request->id; 
        
        try {
            $data_update = [
                'status_req' => STATUS::DELETED,
                'deleted_at' => now()->toDateTimeString(),
                'deleted_by' => $request->session()->get('user_id')
            ];

             // soft delete master 
             DB::table($TABLE_MASTER)
             ->where('id', $id)
             ->update($data_update);
    
            $response['message'] = "Delete successful";
            $response['isSuccess'] = true;
        } catch (Exception $ex) {
            Log::error($ex->getTraceAsString());
            DB::rollBack();
            $response['message'] = $ex->getMessage();
            $response['isSuccess'] = false;
        }
    
        return response()->json($response);

    }



}