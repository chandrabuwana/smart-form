<?php

namespace App\Http\Controllers\UnderCarriage;

use App\Helper;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UnderCarriageInspectionController extends Controller
{
    public function form(Request $request)
    {
        if(!Helper::isGrantPermission('create-form-under-carriage-inspection')) {
            return redirect('/');
        }

        $getComponentThirsts = DB::table('FM_REFF_PLANT_UNDERCARRIAGE_COMPONENT_THIRST')
            ->select('component_name', 'percentage', 'thirst_value')
            ->join('FM_REFF_PLANT_UNDERCARRIAGE_COMPONENT', 'FM_REFF_PLANT_UNDERCARRIAGE_COMPONENT.id', '=', 'FM_REFF_PLANT_UNDERCARRIAGE_COMPONENT_THIRST.component_id')
            ->orderBy('FM_REFF_PLANT_UNDERCARRIAGE_COMPONENT.id', 'ASC')->get();

        $componentThirsts = [];
        $componentLabels = $getComponentThirsts->pluck('component_name')->unique();

        foreach($getComponentThirsts as $item) {
            $componentThirsts[ $item->percentage ][] = $item->thirst_value;
        }

        $componentInspections = DB::table('FM_REFF_PLANT_UNDERCARRIAGE_INSPECTION_COMPONENT')
            ->orderBy('id', 'ASC')->get();
        $subComponentInspections = collect([]);

        $componentInspections->each( function($component, $keyComponent) use(&$subComponentInspections, $componentInspections) {
            $getSubComponents = DB::table('FM_REFF_PLANT_UNDERCARRIAGE_INSPECTION_SUB_COMPONENT')
                ->where('inspection_component_id', $component->id);

            if($getSubComponents->count() > 0) {
                $component->sub_components = $getSubComponents->orderBy('id', 'ASC')->get();
                $subComponentInspections->push($component);
                $componentInspections->forget($keyComponent);
            }
        });

        $components = DB::table('FM_REFF_PLANT_UNDERCARRIAGE_COMPONENT')
            ->orderBy('id', 'ASC')->get();

        return view('undercarriage/undercarriage-inspection-form', [
            'components' => $components,
            'componentThirsts' => $componentThirsts,
            'componentLabels' => $componentLabels,
            'componentInspections' => $componentInspections,
            'subComponentInspections' => $subComponentInspections
        ]);
    }

    public function store(Request $request)
    {
        if(!Helper::isGrantPermission('create-form-under-carriage-inspection')) {
            return redirect('/');
        }

        $request->validate([
            'document_no' => 'required|string|max:255',
            'unit_model' => 'required|string|max:255',
            'unit_sn' => 'required|string|max:255',
            'unit_smr_hm' => 'required|string|max:255',
            'work_operation' => 'required|string|max:255',
            'ground_condition' => 'required|string|max:255',
            'condition_area' => 'required|string|max:255',
            'inspection_date' => 'required|date_format:Y-m-d',
            'comment' => 'required|string|max:255',
        ]);

        DB::beginTransaction();
        $requestData = $request->all();

        try {
            $masterId = DB::table('FM_PLANT_UNDERCARRIAGE_INSPECTION_MASTER')->insertGetId([
                'document_no' => $requestData['document_no'],
                'unit_model' => $requestData['unit_model'],
                'unit_sn' => $requestData['unit_sn'],
                'unit_smr_hm' => $requestData['unit_smr_hm'],
                'work_operation' => $requestData['work_operation'],
                'ground_condition' => $requestData['ground_condition'],
                'condition_area_frame' => $requestData['condition_area'],
                'inspection_date' => $requestData['inspection_date'],
                'comment' => $requestData['comment'],
                'created_at' => now(),
                'created_by' => session("user_id"),
                'updated_at' => null,
                'updated_by' => null
            ]);

            // Form Inspection
            foreach($requestData['inspection_right_side'] as $componentId => $valueRightSide) {
                if(is_array($valueRightSide)) {
                    foreach($valueRightSide as $subComponentId => $inspectionRightSide) {
                        $inspectionLeftSide = $requestData['inspection_left_side'][$componentId][$subComponentId];

                        DB::table('FM_PLANT_UNDERCARRIAGE_INSPECTION_DETAIL')->insert([
                            'inspection_id' => $masterId,
                            'inspection_component_id' => $componentId,
                            'inspection_sub_component_id' => $subComponentId,
                            'right_side' => $inspectionRightSide ?? 0,
                            'left_side' => $inspectionLeftSide ?? 0,
                            'created_at' => now(),
                            'created_by' => session("user_id"),
                            'updated_at' => null,
                            'updated_by' => null
                        ]);
                    }

                } else {
                    $inspectionRightSide = $valueRightSide;
                    $inspectionLeftSide = $requestData['inspection_left_side'][$componentId];

                    DB::table('FM_PLANT_UNDERCARRIAGE_INSPECTION_DETAIL')->insert([
                        'inspection_id' => $masterId,
                        'inspection_component_id' => $componentId,
                        'inspection_sub_component_id' => null,
                        'right_side' => $inspectionRightSide ?? 0,
                        'left_side' => $inspectionLeftSide ?? 0,
                        'created_at' => now(),
                        'created_by' => session("user_id"),
                        'updated_at' => null,
                        'updated_by' => null
                    ]);
                }
            }

            // Form Temuan
            foreach($requestData['issue_right_side'] as $componentId => $issueRightSide) {
                $issueLeftSide = $requestData['issue_left_side'][$componentId];

                DB::table('FM_PLANT_UNDERCARRIAGE_COMPONENT_ISSUE')->insert([
                    'inspection_id' => $masterId,
                    'component_id' => $componentId,
                    'right_side' => $issueRightSide ?? '',
                    'left_side' => $issueLeftSide ?? '',
                    'created_at' => now(),
                    'created_by' => session("user_id"),
                    'updated_at' => null,
                    'updated_by' => null
                ]);
            }

            DB::commit();
            return response()->json([
                'message' => 'Berhasil menyimpan data plant under carriage inspection!',
                'code' => 200
            ]);

        } catch (QueryException $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Something went wrong: ' . $e->getMessage(),
                'code' => 500
            ]);
        }
    }

    public function dashboard(Request $request)
    {
        if(!Helper::isGrantPermission('dashboard-under-carriage-inspection')) {
            return redirect('/');
        }

        return view('undercarriage/dashboard-inspection');
    }

    public function getDashboardData(Request $request)
    {
        $search  = $request->query('search', '');
        $sort    = $request->query('sort', 'id');
        $order   = $request->query('order', 'asc');
        $offset  = $request->query('offset', 0);
        $limit   = $request->query('limit', 10);

        try {
            $underCarriageMaster = DB::table('FM_PLANT_UNDERCARRIAGE_INSPECTION_MASTER')
                ->select('id', 'document_no', 'unit_model', 'unit_sn', 'unit_smr_hm', 'work_operation', 'ground_condition', 'condition_area_frame', 'inspection_date');

            if(!empty($search)) {
                $underCarriageMaster->where('document_no', 'like', '%' . $search . '%')
                    ->orWhere('unit_model', 'like', '%' . $search . '%')
                    ->orWhere('unit_sn', 'like', '%' . $search . '%')
                    ->orWhere('unit_smr_hm', 'like', '%' . $search . '%')
                    ->orWhere('work_operation', 'like', '%' . $search . '%');
            }

            $data = $underCarriageMaster->orderBy($sort, $order)->offset($offset)
                ->limit($limit)->get();

            $response['message'] = "Ok";
            $response['isSuccess'] = true;
            $response['data'] = $data;

        } catch (Exception $ex) {
            $response['message'] = $ex->getMessage();
            $response['isSuccess'] = false;
        }

        return response()->json($response);
    }

    public function detail($id)
    {
        if(!Helper::isGrantPermission('detail-data-under-carriage-inspection')) {
            return redirect('/');
        }

        $underCarriageMasterData = DB::table('FM_PLANT_UNDERCARRIAGE_INSPECTION_MASTER')->find($id);
        if(!$underCarriageMasterData) abort(404);

        $getComponentThirsts = DB::table('FM_REFF_PLANT_UNDERCARRIAGE_COMPONENT_THIRST')
            ->select('component_name', 'percentage', 'thirst_value')
            ->join('FM_REFF_PLANT_UNDERCARRIAGE_COMPONENT', 'FM_REFF_PLANT_UNDERCARRIAGE_COMPONENT.id', '=', 'FM_REFF_PLANT_UNDERCARRIAGE_COMPONENT_THIRST.component_id')
            ->orderBy('FM_REFF_PLANT_UNDERCARRIAGE_COMPONENT.id', 'ASC')->get();

        $componentThirsts = [];
        $componentLabels = $getComponentThirsts->pluck('component_name')->unique();

        foreach($getComponentThirsts as $item) {
            $componentThirsts[ $item->percentage ][] = $item->thirst_value;
        }

        $components = DB::table('FM_PLANT_UNDERCARRIAGE_COMPONENT_ISSUE')
            ->join('FM_REFF_PLANT_UNDERCARRIAGE_INSPECTION_COMPONENT', 'FM_REFF_PLANT_UNDERCARRIAGE_INSPECTION_COMPONENT.id', '=', 'FM_PLANT_UNDERCARRIAGE_COMPONENT_ISSUE.component_id')
            ->orderBy('FM_PLANT_UNDERCARRIAGE_COMPONENT_ISSUE.id', 'ASC')->get();

        $componentInspections = DB::table('FM_PLANT_UNDERCARRIAGE_INSPECTION_DETAIL')
            ->join('FM_REFF_PLANT_UNDERCARRIAGE_INSPECTION_COMPONENT', 'FM_REFF_PLANT_UNDERCARRIAGE_INSPECTION_COMPONENT.id', '=', 'FM_PLANT_UNDERCARRIAGE_INSPECTION_DETAIL.inspection_component_id')
            ->whereNull('inspection_sub_component_id')->where('inspection_id', $id)
            ->orderBy('FM_PLANT_UNDERCARRIAGE_INSPECTION_DETAIL.id', 'ASC')->get();

        $getSubComponentInspections = DB::table('FM_PLANT_UNDERCARRIAGE_INSPECTION_DETAIL')
            ->join('FM_REFF_PLANT_UNDERCARRIAGE_INSPECTION_SUB_COMPONENT', 'FM_REFF_PLANT_UNDERCARRIAGE_INSPECTION_SUB_COMPONENT.id', '=', 'FM_PLANT_UNDERCARRIAGE_INSPECTION_DETAIL.inspection_sub_component_id')
            ->whereNotNull('inspection_sub_component_id')->where('inspection_id', $id)
            ->orderBy('FM_PLANT_UNDERCARRIAGE_INSPECTION_DETAIL.id', 'ASC')->get()->groupBy('inspection_component_id');

        $subComponentInspections = collect([]);
        foreach($getSubComponentInspections as $componentId => $subComponents) {
            $component = DB::table('FM_REFF_PLANT_UNDERCARRIAGE_INSPECTION_COMPONENT')
                ->where('id', $componentId)->first();

            $component->sub_components = $subComponents;
            $subComponentInspections->push($component);
        }

        return view('undercarriage/undercarriage-inspection-form', [
            'underCarriageMaster' => $underCarriageMasterData,
            'componentInspections' => $componentInspections,
            'subComponentInspections' => $subComponentInspections,
            'components' => $components,
            'componentThirsts' => $componentThirsts,
            'componentLabels' => $componentLabels,
        ]);
    }
}
