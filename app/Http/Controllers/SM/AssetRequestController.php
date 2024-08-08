<?php

namespace App\Http\Controllers\SM;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AssetRequestController extends Controller {
    
    function IndexForm(Request $request) {
        $no_doc = $request->query('no_doc');
        $str = "checked";
        if($no_doc != null) {
            Log::info("no_doc != null");
        } else {
            Log::info("no_doc == null");
            $str = "";
        }
        return view("SM/form-asset-request", ['data' => $str]);
    }

    function DashboardForm() {
       return view("SM/dashboard-form-sm"); 
    }

    function SubmitFormAssetRequest(Request $req) {
        $TABLE_MASTER = "FM_SM_016_MASTER";
        $TABLE_DETAIL = "FM_SM_016_DETAIL";
        $response = array(
            'message' => "",
            'isSuccess' => false
        );

        $requested_by = $req->session()->get('user_id');
        $data = $req->input();
        Log::info(json_encode(array('body' => $data)));
        $data_insert = [
            'requested_by' => $requested_by,
            'department' => $data['department'],
            'project' => $data['project'],
            'area' => $data['area'],
            'no_doc' => $data['noDoc'],
            'date_doc' => $data['tglDoc'],
            'reason_for_purchase' => $data['reasonPurchase'],
            'estimated_ready_at_site' => $data['estimatedReadyAtSite'],
            'estimated_kurs_idr' => (float) $data['estimatedIdr'],
            'estimated_kurs_usd' => (float) $data['estimatedUsd'],
            'estimated_kurs_cny' => (float) $data['estimatedCny'],
            'total_price_idr' => (float) $data['totalPrice'],
            'ref_doc' => $data['refDoc'],
            'nature_replacement' => $data['replacement'],
            'nature_additional' => $data['additional'],
            'nature_budgeted' => $data['budgeted'],
            'nature_not_budgeted' => $data['notBudgeted'],
        ];
        $spliited_no_doc = explode("/", $data_insert['no_doc']);
        Log::info("spliited_no_doc : " . json_encode($spliited_no_doc) . " gabung : ". implode("/", $spliited_no_doc));
        $data_item = $data['item'];
        // DB
        // foreach ($data_item as $data_item_detail) {
        //     Log::info(json_encode($data_item_detail));
        // }

        try {
            DB::beginTransaction();
            $id = DB::table($TABLE_MASTER)->insertGetId($data_insert);
            foreach ($data_item as $data_item_detail) {
                DB::table($TABLE_DETAIL)->insert(array(
                    'id_master' => $id,
                    'type' => $data_item_detail['type'],
                    'model' => $data_item_detail['model'],
                    'brand' => $data_item_detail['brand'],
                    'condition' => $data_item_detail['condition'],
                    'qty' => (int) $data_item_detail['qty'],
                    'uom' => $data_item_detail['uom'],
                    'currency' => $data_item_detail['currency'],
                    'price' => (float) $data_item_detail['price']
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
            // DB::rollBack();
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
                ->select('no_doc', 'date_doc', 'department', 'project', 'area', 'requested_by', 'total_price_idr');
            if($search) {
                $users->where('no_doc', 'like', "%$search%")
                  ->orWhere('department', 'like', "%$search%")
                  ->orWhere('project', 'like', "%$search%")
                  ->orWhere('area', 'like', "%$search%")
                  ->orWhere('requested_by', 'like', "%$search%");
            }
            // Apply sorting
            $users->orderBy($sort, $order);
            $documents = $users->skip($offset)->take($limit)->get();

            $response['message'] = "Ok";
            $response['isSuccess'] = true;
            $response['data'] = $documents;

        } catch (Exception $ex) {
            $response['message'] = $ex->getMessage();
            $response['isSuccess'] = false;
        }

        return response()->json($response);
    }

    function FormDetailByNoDoc(Request $request) {
        $no_doc = $request->query('no_doc');
        $TABLE_MASTER = "FM_SM_016_MASTER";
        $TABLE_DETAIL = "FM_SM_016_DETAIL";

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
            'reason_pruchase' => ''
        );
        $data_detail = array();

        try {
            $data = DB::table($TABLE_MASTER)
                ->select(
                    'id', 'estimated_ready_at_site',
                    'requested_by', 'nature_replacement as replacement', 'nature_additional as additional', 
                    'nature_budgeted as budgeted', 'nature_not_budgeted as not_budgeted', 'no_doc', 'date_doc as tgl_doc', 
                    'department', 'project', 'area', 'total_price_idr as total_price',
                    'estimated_kurs_idr as estimated_idr', 'estimated_kurs_usd as estimated_usd', 'estimated_kurs_cny as estimated_cny',
                    'ref_doc', 'reason_for_purchase as reason_purchase'
                )
                ->where('no_doc', $no_doc)
                ->first();
            // Log::info("id : ". $data->id);
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
            
            $data_master['requested_by'] = $data_user->nik;
            $data_master['requested_name'] = $data_user->nama;
            $data_master['replacement'] = $data->replacement == 1 ? "checked" : "";
            $data_master['additional'] = $data->additional == 1 ? "checked" : "";
            $data_master['budgeted'] = $data->budgeted == 1 ? "checked" : "";
            $data_master['not_budgeted'] = $data->not_budgeted == 1 ? "checked" : "";
            $data_master['no_doc'] = $data->no_doc;
            $data_master['tgl_doc'] = $data->tgl_doc;
            $data_master['department'] = $data->department;
            $data_master['project'] = $data->project;
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

            Log::info("FormDetailByNoDoc : " .json_encode(array('data_master' => $data_master, 'data_detail' => $data_detail, 'data_user' => $data_user)));

        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            $response['message'] = $ex->getMessage();
            $response['isSuccess'] = false;
        }

        return view('SM/detail-form-asset-request', ['data' => $data_master, 'detail' => $data_detail]);
    }
}