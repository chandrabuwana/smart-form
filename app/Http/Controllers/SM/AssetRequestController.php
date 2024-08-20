<?php

namespace App\Http\Controllers\SM;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class AssetRequestController extends Controller {
        private $TABLE_MASTER = "FM_SM_016_MASTER";
        private $TABLE_DETAIL = "FM_SM_016_DETAIL";
        private $TABLE_UPLOADS = "FM_SM_016_UPLOADS";
        private $user_sm = ['1008491', '1008492', '1008493', '1008494', '1008526'];
    
    function IndexForm(Request $request) {
        // Log::info('user SM : '. config('app.user_sm', ''));
        return view("SM/form-asset-request");
    }

    function EditForm(Request $request) {
        $no_doc = $request->query('no_doc');
        $nik_session = $request->session()->get('user_id', '');
        $data = $this->getDetail($request, $no_doc, $nik_session);
        if($data['data']['requested_by'] != $nik_session) {
            return abort(401, 'Unauthoried Request!');
        } else {
            return view("SM/form-asset-request-edit", $data);
        }
    }

    function SubmitEditForm(Request $req) {
        $tgl = now()->toDateTimeString();
        $no_doc = $req->query('no_doc');
        $response = array(
            'message' => "",
            'isSuccess' => false
        );
        $nik_session = $req->session()->get('user_id', '');
        $data = $req->input();

        $data_insert = [
            'department' => $data['department'],
            'project' => $data['project'],
            'department_allocation' => $data['departmentAllocation'],
            'project_allocation' => $data['projectAllocation'],
            // 'area' => $data['area'],
            // 'date_doc' => $data['tglDoc'],
            'reason_for_purchase' => $data['reasonPurchase'],
            'estimated_ready_at_site' => $data['estimatedReadyAtSite'],
            'estimated_kurs_idr' => (float) $data['estimatedIdr'],
            'estimated_kurs_usd' => (float) $data['estimatedUsd'],
            'estimated_kurs_cny' => (float) $data['estimatedCny'],
            'total_price_idr' => (float) $data['totalPrice'],
            'ref_doc' => $data['refDoc'],
            'nature_replacement' => $data['replacement'] == "true" ? 1 : 0,
            'nature_additional' => $data['additional'] == "true" ? 1 : 0,
            'nature_budgeted' => $data['budgeted'] == "true" ? 1 : 0,
            'nature_not_budgeted' => $data['notBudgeted'] == "true" ? 1 : 0,
        ];
        $data_item = json_decode($data['item']);
        Log::info($data_item);
        $uploadedFiles = [];
        if($req->hasFile('pendukungReason')) {
            foreach ($req->file('pendukungReason') as $file) {
                $path = $file->store('uploads');
                $stored_filename = explode('/', $path);
                $uploadedFiles[] = array('jenis' => 'pendukungReason', 'name' => $file->getClientOriginalName(), 'path' => $stored_filename[1]);
            }
        }

        try {
            DB::beginTransaction();
            $old_value_master = DB::table($this->TABLE_MASTER)
                ->select('id', 'department', 'project', 'department_allocation', 'project_allocation',
                    'date_doc', 'reason_for_purchase', 'estimated_ready_at_site', 'estimated_kurs_idr',
                    'estimated_kurs_usd', 'estimated_kurs_cny', 'total_price_idr', 'ref_doc',
                    'nature_replacement', 'nature_additional', 'nature_budgeted', 'nature_not_budgeted')
                ->where('no_doc', $no_doc)
                ->first();

            $old_value_detail = DB::table($this->TABLE_DETAIL)
                ->select('type', 'model', 'brand', 'condition', 'qty', 'uom', 'currency', 'price')
                ->where('id_master', $old_value_master->id)
                ->get();
            $is_item_edit_item = $this->isArrayDifferent($old_value_detail, $data_item);
            
            if($is_item_edit_item) {
                $deleted = DB::table($this->TABLE_DETAIL)->where('id_master', $old_value_master->id)->delete();
                foreach ($data_item as $data_item_detail) {
                    DB::table($this->TABLE_DETAIL)->insert(array(
                        'id_master' => $old_value_master->id,
                        'type' => $data_item_detail->type,
                        'model' => $data_item_detail->model,
                        'brand' => $data_item_detail->brand,
                        'condition' => $data_item_detail->condition,
                        'qty' => (int) $data_item_detail->qty,
                        'uom' => $data_item_detail->uom,
                        'currency' => $data_item_detail->currency,
                        'price' => (float) $data_item_detail->price
                    ));
                }
                $history_detail = $this->addHistory($old_value_master->id, $tgl, $nik_session, 'AssetRequestEdit', $data_item, $old_value_detail);
            }

            foreach ($uploadedFiles as $uploaded) {
                DB::table($this->TABLE_UPLOADS)->insert(array(
                    'id_form' => $old_value_master->id,
                    'file_name' => $uploaded['name'],
                    'path' => $uploaded['path'],
                    'jenis' => $uploaded['jenis'],
                ));
            }
            // Log::info($old_value_detail);
            // Log::info(json_encode($this->isArrayDifferent($old_value_detail, $data_item)));
            $affected_rows = DB::table($this->TABLE_MASTER)
                ->where('no_doc', $no_doc)
                ->update($data_insert);
            $history_master = $this->addHistory($old_value_master->id, $tgl, $nik_session, 'AssetRequestEdit', $data_insert, $old_value_master);
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

    function DashboardForm(Request $req) {
        $nik_session = $req->session()->get('user_id', '');

        return view("SM/dashboard-form-sm", ['nik_session' => $nik_session]); 
    }

    function SubmitFormAssetRequest(Request $req) {
        $TABLE_MASTER = "FM_SM_016_MASTER";
        $TABLE_DETAIL = "FM_SM_016_DETAIL";
        $TABLE_UPLOADS = "FM_SM_016_UPLOADS";
        $response = array(
            'message' => "",
            'isSuccess' => false
        );
        $tgl = now()->toDateTimeString();
        $requested_by = $req->session()->get('user_id');
        $data = $req->input();
        // Log::info(json_encode(array('body' => $data)));
        $validation_matrix = $this->getValidationMatrix(
            $data['department'], $data['project'], 
            $data['departmentAllocation'], $data['projectAllocation']
        );
        $data_insert = [
            'requested_by' => $requested_by,
            'department' => $data['department'],
            'project' => $data['project'],
            'department_allocation' => $data['departmentAllocation'],
            'project_allocation' => $data['projectAllocation'],
            // 'area' => $data['area'],
            'no_doc' => $data['noDoc'],
            'date_doc' => $data['tglDoc'],
            'reason_for_purchase' => $data['reasonPurchase'],
            'estimated_ready_at_site' => $data['estimatedReadyAtSite'],
            'estimated_kurs_idr' => (float) $data['estimatedIdr'],
            'estimated_kurs_usd' => (float) $data['estimatedUsd'],
            'estimated_kurs_cny' => (float) $data['estimatedCny'],
            'total_price_idr' => (float) $data['totalPrice'],
            'ref_doc' => $data['refDoc'],
            'nature_replacement' => $data['replacement'] == "true" ? 1 : 0,
            'nature_additional' => $data['additional'] == "true" ? 1 : 0,
            'nature_budgeted' => $data['budgeted'] == "true" ? 1 : 0,
            'nature_not_budgeted' => $data['notBudgeted'] == "true" ? 1 : 0,
            'acknowledge_by_1_nik' => $validation_matrix['acknowledge_by_1_nik'],
            'acknowledge_by_2_nik' => $validation_matrix['acknowledge_by_2_nik'],
            'approved_by_1_nik' => $validation_matrix['approved_by_1_nik'],
            'approved_by_2_nik' => $validation_matrix['approved_by_2_nik'],
            'created_by' => $requested_by
        ];
        $spliited_no_doc = explode("/", $data_insert['no_doc']);
        // Log::info("data_insert : " . json_encode($data_insert));
        $data_item = json_decode($data['item']);
        $uploadedFiles = [];
        // Log::info('has file ? ' . json_encode($req->hasFile('pendukungReason')));
        if($req->hasFile('pendukungReason')) {
            foreach ($req->file('pendukungReason') as $file) {
                $path = $file->store('uploads');
                $stored_filename = explode('/', $path);
                $uploadedFiles[] = array('jenis' => 'pendukungReason', 'name' => $file->getClientOriginalName(), 'path' => $stored_filename[1]);
            }
        }

        try {
            DB::beginTransaction();
            $id = DB::table($TABLE_MASTER)->insertGetId($data_insert);
            
            foreach ($data_item as $data_item_detail) {
                DB::table($TABLE_DETAIL)->insert(array(
                    'id_master' => $id,
                    'type' => $data_item_detail->type,
                    'model' => $data_item_detail->model,
                    'brand' => $data_item_detail->brand,
                    'condition' => $data_item_detail->condition,
                    'qty' => (int) $data_item_detail->qty,
                    'uom' => $data_item_detail->uom,
                    'currency' => $data_item_detail->currency,
                    'price' => (float) $data_item_detail->price,
                    'created_by' => $requested_by,
                    'created_at' => $tgl
                ));
            }

            foreach ($uploadedFiles as $uploaded) {
                DB::table($TABLE_UPLOADS)->insert(array(
                    'id_form' => $id,
                    'file_name' => $uploaded['name'],
                    'path' => $uploaded['path'],
                    'jenis' => $uploaded['jenis'],
                    'created_by' => $requested_by,
                    'created_at' => $tgl
                ));
            }
            
            
            $spliited_no_doc[0] = $id;
            $updated_no_doc = implode("/", $spliited_no_doc);

            $affected = DB::table($TABLE_MASTER)
              ->where('id', $id)
              ->update(['no_doc' => $updated_no_doc]);

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

    function GetFormsData(Request $request) {
        $TABLE_MASTER = "FM_SM_016_MASTER";
        $TABLE_DETAIL = "FM_SM_016_DETAIL";
        $response = array(
            'message' => '',
            'isSuccess' => false
        );
        $search = $request->query('search', '');
        $sort = $request->query('sort', 'id'); // Default sort by id
        $order = $request->query('order', 'asc'); // Default order is ascending
        $offset = $request->query('offset', 0); // Default offset
        $limit = $request->query('limit', 10); // Default limit

        try {
            $users = DB::table($TABLE_MASTER)
                ->select('no_doc', 'date_doc', 'department', 'project', 'area', 'requested_by', 'total_price_idr', 'status')
                // ->orderBy($sort, $order)
                ->skip($offset)->take($limit)
                ->get();
                // if($search) {
            //     $users->where('no_doc', 'like', "%$search%")
            //       ->orWhere('department', 'like', "%$search%")
            //       ->orWhere('project', 'like', "%$search%")
            //       ->orWhere('area', 'like', "%$search%")
            //       ->orWhere('requested_by', 'like', "%$search%");
            // }
            // Apply sorting
            // $documents = $users->skip($offset)->take($limit)->get();
            $totalNotFiltered = DB::table($TABLE_MASTER)->count();

            $response['message'] = "Ok";
            $response['isSuccess'] = true;
            $response['data'] = ['total'=> $totalNotFiltered, 'totalNotFiltered'=> $totalNotFiltered, 'rows' => $users];
            // $response['data'] = $documents;

        } catch (Exception $ex) {
            Log::info($ex->getTraceAsString());
            $response['message'] = $ex->getMessage();
            $response['isSuccess'] = false;
        }

        return response()->json($response);
        // return response()->json(['total'=> $totalNotFiltered, 'totalNotFiltered'=> $totalNotFiltered, 'rows' => $users]);
    }

    function FormDetailByNoDoc(Request $request) {
        $no_doc = $request->query('no_doc');
        $nik_session = $request->session()->get('user_id', '');
        $data = $this->getDetail($request, $no_doc, $nik_session);
        $history_edit = $this->getHistory($data['data']['id']);
        $data = array_merge($data, $history_edit);
        
        return view('SM/detail-form-asset-request', $data);
    }

    private function getDetail(Request $request, $no_doc, $nik) {
        $TABLE_MASTER = "FM_SM_016_MASTER";
        $TABLE_DETAIL = "FM_SM_016_DETAIL";
        $isError = true;
        $errorMessage = '';
        $this->user_sm = explode(',', config('app.user_sm', ''));
        $data_master = array(
            'requested_name' => '',
            'requested_by' => '',
            'replacement' => '',
            'additional' => '',
            'budgeted' => '',
            'not_budgeted' => '',
            'no_doc' => '',
            'tgl_doc' => '',
            'department' => '',
            'project' => '',
            'department_allocation' => '',
            'project_allocation' => '',
            'area' => '',
            'estimated_ready_at_site' => '',
            'total_price' => '',
            'calculated_idr' => '',
            'calculated_usd' => '',
            'calculated_cny' => '',
            'estimated_idr' => '',
            'estimated_usd' => '',
            'estimated_cny' => '',
            'ref_doc' => '',
            'reason_purchase' => ''
        );
        $data_detail = array();
        $pendukung_reason = array();
        try {
            $data = DB::table($TABLE_MASTER)
                ->select(
                    'id', 'estimated_ready_at_site',
                    'requested_by', 'nature_replacement as replacement', 'nature_additional as additional', 
                    'nature_budgeted as budgeted', 'nature_not_budgeted as not_budgeted', 'no_doc', 'date_doc as tgl_doc', 
                    'department', 'project', 'area', 'total_price_idr as total_price',
                    'estimated_kurs_idr as estimated_idr', 'estimated_kurs_usd as estimated_usd', 'estimated_kurs_cny as estimated_cny',
                    'ref_doc', 'reason_for_purchase as reason_purchase',
                    'department_allocation', 'project_allocation', 'status',
                    'acknowledge_by_1_nik', 'acknowledge_by_2_nik', 'approved_by_1_nik', 'approved_by_2_nik',
                    'acknowledge_1', 'acknowledge_2', 'approved_1', 'approved_2'

                )
                ->where('no_doc', $no_doc)
                ->first();
            if(!is_null($data)) {
                // Log::info("id : ". json_encode($data));
                $data_detail = DB::table($TABLE_DETAIL)
                    ->select('type', 'model', 'brand', 'condition', 'qty', 'uom', 'currency', 'price')
                    ->where('id_master', $data->id)
                    ->get();

                $calculated_idr = 0;
                $calculated_usd = 0;
                $calculated_cny = 0;

                foreach($data_detail as $detail) {
                    if($detail->currency == 'IDR') {
                        $calculated_idr = $calculated_idr + ($detail->qty * $detail->price);
                    }
                    if($detail->currency == 'USD') {
                        $calculated_usd = $calculated_usd + ($detail->qty * $detail->price);
                    }
                    if($detail->currency == 'CNY') {
                        $calculated_cny = $calculated_cny + ($detail->qty * $detail->price);
                    }
                }


                $data_user = DB::connection('sqlsrv2')
                    ->table("TKaryawan")
                    ->select('NIK as nik', 'Nama as nama')
                    ->where("nik", $data->requested_by)
                    ->first();

                $pendukung_reason = DB::table('FM_SM_016_UPLOADS')
                    ->select('jenis', 'file_name', 'path as lokasi')
                    ->where('id_form', $data->id)
                    ->get();

                // Log::info("pendukungReason : ". json_encode($pendukung_reason));
                $data_master['requested_by'] = $data_user->nik;
                $data_master['id'] = $data->id;
                $data_master['requested_name'] = $data_user->nama;
                $data_master['replacement'] = $data->replacement == 1 ? "checked" : "";
                $data_master['additional'] = $data->additional == 1 ? "checked" : "";
                $data_master['budgeted'] = $data->budgeted == 1 ? "checked" : "";
                $data_master['not_budgeted'] = $data->not_budgeted == 1 ? "checked" : "";
                $data_master['no_doc'] = $data->no_doc;
                $data_master['tgl_doc'] = $data->tgl_doc;
                $data_master['department'] = $data->department;
                $data_master['project'] = $data->project;
                $data_master['department_allocation'] = $data->department_allocation;
                $data_master['project_allocation'] = $data->project_allocation;
                $data_master['area'] = $data->area;
                $data_master['estimated_ready_at_site'] = $data->estimated_ready_at_site;
                $data_master['total_price'] = $data->total_price;
                $data_master['estimated_idr'] = $data->estimated_idr;
                $data_master['estimated_usd'] = $data->estimated_usd;
                $data_master['estimated_cny'] = $data->estimated_cny;
                $data_master['ref_doc'] = $data->ref_doc;
                $data_master['reason_purchase'] = $data->reason_purchase;
                $data_master['calculated_idr'] = $calculated_idr;
                $data_master['calculated_usd'] = $calculated_usd;
                $data_master['calculated_cny'] = $calculated_cny;
                $data_master['status'] = $data->status;
                $data_master['acknowledge_by_1_nik'] = $data->acknowledge_by_1_nik;
                $data_master['acknowledge_by_2_nik'] = $data->acknowledge_by_2_nik;
                $data_master['approved_by_1_nik'] = $data->approved_by_1_nik;
                $data_master['approved_by_2_nik'] = $data->approved_by_2_nik;
                $data_master['acknowledge_1'] = $data->acknowledge_1;
                $data_master['acknowledge_2'] = $data->acknowledge_2;
                $data_master['approved_1'] = $data->approved_1;
                $data_master['approved_2'] = $data->approved_2;

                // Log::info("FormDetailByNoDoc : " .json_encode(array('data_master' => $data_master, 'data_detail' => $data_detail, 'data_user' => $data_user, 'pendukung_reason' => $pendukung_reason)));
                $isError = false;
            } else {
                $isError = true;
                $errorMessage = "Data tidak ditemukan";
            }
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            $errorMessage = $ex->getMessage();
        }
        $is_user_sm = in_array($request->session()->get('user_id', ''), $this->user_sm);

        return ['error' => $isError, 'errorMessage' => $errorMessage, 'data' => $data_master, 'detail' => $data_detail, 'pendukung_reason' => $pendukung_reason, 'is_user_sm' => $is_user_sm, 'nik_session' => $nik];
    }

    function download($fileName)
    {
        // $filePath = storage_path("app/uploads/{$file->generated_name}");

        // Log::info("download : ".' fileName ' . Storage::exists('uploads/' . $fileName));
        if (Storage::exists('uploads/' . $fileName)) {
            return Storage::download('uploads/' . $fileName);
        } else {
            abort(404, 'File not found');
        }
    }

    function ValidasiRequest(Request $request) {

        $body = $request->input();
        $nik_session = $request->session()->get('user_id', '');
        $data = DB::table($this->TABLE_MASTER)
            ->select('id', 'acknowledge_by_1_nik', 'acknowledge_by_2_nik', 'approved_by_1_nik', 'approved_by_2_nik')
            ->where('no_doc', $body['noDoc'])
            ->first();
        $isError = false;
        $errorMessage = "";
        $message = "";

        switch ($body['action']) {
            case 'acknowledge':
                if($data->acknowledge_by_1_nik == $nik_session) {
                    $result = $this->updateValidation('acknowledge_1', $body['noDoc'], $nik_session, 'acknowledge', $data->id);
                    $isError = $result['error'];
                    $errorMessage = $result['errorMessage'];
                    $message = $result['message'];
                } else if($data->acknowledge_by_2_nik == $nik_session) {
                    $result = $this->updateValidation('acknowledge_2', $body['noDoc'], $nik_session, 'acknowledge', $data->id);
                    $isError = $result['error'];
                    $errorMessage = $result['errorMessage'];
                    $message = $result['message'];
                } else {
                    $isError = true;
                    $errorMessage = 'Unauthorized Action';
                }
                break;
            case 'approve':
                if($data->approved_by_1_nik == $nik_session) {
                    $result = $this->updateValidation('approved_1', $body['noDoc'], $nik_session, 'approve', $data->id);
                    $isError = $result['error'];
                    $errorMessage = $result['errorMessage'];
                    $message = $result['message'];
                } else if($data->approved_by_2_nik == $nik_session) {
                    $result = $this->updateValidation('approved_2', $body['noDoc'], $nik_session, 'approve', $data->id);
                    $isError = $result['error'];
                    $errorMessage = $result['errorMessage'];
                    $message = $result['message'];
                } else {
                    $isError = true;
                    $errorMessage = 'Unauthorized Action';
                }
                break;
            case 'proses':
                $result = $this->updateValidation('proses', $body['noDoc'], $nik_session, 'proses', $data->id);
                $isError = $result['error'];
                $errorMessage = $result['errorMessage'];
                $message = $result['message'];
                break;
            case 'selesai':
                $result = $this->updateValidation('proses', $body['noDoc'], $nik_session, 'selesai', $data->id);
                $isError = $result['error'];
                $errorMessage = $result['errorMessage'];
                $message = $result['message'];
                break;
            
            default:
                $isError = true;
                $errorMessage = "Unknown Action";
                break;
        }

        return response()->json([
            'error' => $isError,
            'errorMessage' => $errorMessage,
            'message' => $message,
            'data' => ['data' => $data, 'no_doc' => $body['noDoc'], 'action' => $body['action'], 'nik' => $request->session()->get('user_id', '')]
        ]);
    }

    private function updateValidation($column, $no_doc, $nik, $action, $id) {
        $affected = 0;
        $error = true;
        $errorMessage = '';
        $message = '';
        $tgl = now()->toDateTimeString();
        $new_value = [];

        try {
            if($action == 'proses') {
                $affected = DB::table($this->TABLE_MASTER)
                    ->where('no_doc', $no_doc)
                    ->update(['status' => 2, 'updated_by' => $nik, 'updated_at' => $tgl]);
                $new_value['status'] = 2;
            } else if ($action == 'selesai') {
                $affected = DB::table($this->TABLE_MASTER)
                    ->where('no_doc', $no_doc)
                    ->update(['status' => 3, 'updated_by' => $nik, 'updated_at' => $tgl]);
                $new_value['status'] = 3;
            }  
            else {
                $affected = DB::table($this->TABLE_MASTER)
                    ->where('no_doc', $no_doc)
                    ->update([$column => 1, 'updated_by' => $nik, 'updated_at' => $tgl]);
                if($action == 'approve') {
                    $status = DB::table($this->TABLE_MASTER)
                        ->select('status', 'acknowledge_1', 'acknowledge_2', 'approved_1', 'approved_2')
                        ->where('no_doc', $no_doc)
                        ->first();
                    if($status->status == 0 && $status->acknowledge_1 == 1 && $status->acknowledge_2 == 1 && $status->approved_1 == 1 && $status->approved_2 == 1) {
                        $affected_status = DB::table($this->TABLE_MASTER)
                            ->where('no_doc', $no_doc)
                            ->update(['status' => 1, 'updated_by' => $nik, 'updated_at' => $tgl]);
                        $new_value['status'] = 1;
                    }
                }
                $new_value[$column] = 1;
            }
            
            $this->addHistory($id, $tgl, $nik, $action, $new_value);

            $error = false;
            $message = 'Berhasil ' . $action . ' dokumen ' . $no_doc;
        } catch (Exception $ex) {
            $errorMessage = 'Terjadi Kesalahan update action '.$action;
        }

        return ['affected' => $affected, 'error' => $error, 'errorMessage' => $errorMessage, 'message' => $message];
    }

    private function addHistory($form_id, $updated_at, $updated_by, $action, $new_value, $old_value=null) {
        try {
            DB::table("FM_SM_016_HISTORY")
                ->insert([
                    'id_form' => $form_id,
                    'action' => $action,
                    'updated_at' => $updated_at,
                    'updated_by' => $updated_by,
                    'old_value' => json_encode($old_value),
                    'new_value' => json_encode($new_value)
                ]);

        } catch (Exception $ex) {
            Log::error($ex->getMessage());
        }
    }

    private function getHistory($form_id) {
        $history_detail = DB::table('FM_SM_016_HISTORY')
            ->select('updated_by', 'updated_at')
            ->where('id_form', $form_id)
            ->get();

        return ['history' => $history_detail];
    }

    private function getValidationMatrix($department, $project, $department_allocation, $project_allocation) {
        // TODO : parameterized validation matrix
        return [
            'acknowledge_by_1_nik' => '1008590',
            'acknowledge_by_2_nik' => '1008643',
            'approved_by_1_nik' => '1008821',
            'approved_by_2_nik' => '1008886'
        ];
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