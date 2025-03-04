<?php

namespace Modules\SmartForm\App\Http\Controllers\PLANT\GeneralInspection;

use App\Http\Controllers\Controller;
use App\Models\Plant\GeneralInspection\InspectionCmt;
use App\Models\Plant\GeneralInspection\InspectionCmtActivity;
use App\Models\Plant\GeneralInspection\InspectionCmtResult;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class InspectionCmtController extends Controller
{
    public function index()
    {
        try {
            return view('smartform::plant.general-inspection.cmt.index');
        } catch (Exception $e) {
            $errorMessages = env('APP_DEBUG') ? $e->getMessage() : 'Error Occurred';
            return redirect()->back()->with('error', $errorMessages);
        }
    }

    public function getData(Request $request)
    {
        try {
            $search = $request->query('search');
            $sort   = $request->query('sort', 'created_at'); 
            $order  = $request->query('order', 'desc');

            $inspectionCmt = InspectionCmt::select('id', 'site', 'model_unit', 'cn', 'hm', 'created_at')
                ->when($search, function ($query) use ($search) {
                    $query->where('site', 'LIKE', "%$search%")
                        ->orWhere('model_unit', 'LIKE', "%$search%")
                        ->orWhere('cn', 'LIKE', "%$search%")
                        ->orWhere('hm', 'LIKE', "%$search%")
                        ->orWhere('created_at', 'LIKE', "%$search%");
                })
                ->orderBy($sort, $order)
                ->paginate(10);
            
            $inspectionCmt->getCollection()->transform(function ($inspection) {
                return [
                    ...$inspection->toArray(),
                    'created_at' => Carbon::parse($inspection->created_at)->format('d M Y'),
                ];
            });

            return response()->json([
                'status'  => true,
                'message' => 'Data fetched successfully.',
                'data'    => $inspectionCmt,
            ]);
        } catch (Exception $e) {
            $errorMessages = env('APP_DEBUG') ? $e->getMessage() : 'Error Occurred';
            return redirect()->back()->with('error', $errorMessages);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $result['sites'] = ['PMSS', 'MAS', 'MME', 'BRAM', 'TAJ', 'AGM', 'MSJ', 'TDM', 'BSSR', 'MBLM', 'MBLH', 'others'];

        $json = file_get_contents(resource_path('data/general-inspection/cmt/activity-list.json'));
        $result['activityChecklistJson'] = json_decode($json, true);
        
        $json = file_get_contents(resource_path('data/general-inspection/cmt/inspection-result.json'));
        $result['inspectionResultJson'] = json_decode($json, true);

        return view('smartform::plant.general-inspection.cmt.create', $result);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $validator = Validator::make($request->all(), [
                'site'        => 'required|string',
                'model_unit'  => 'required|string',
                'cn'          => 'required|string',
                'hm'          => 'required|string',
                'inspection'  => 'array',
                'performance' => 'array',
                'remark'      => 'array'
            ]);

            if($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => $validator->errors()->first(),
                ], 422);
            }

            $inspectionCmt = InspectionCmt::create([
                'site'       => $request->site,
                'model_unit' => $request->model_unit,
                'cn'         => $request->cn,
                'hm'         => $request->hm
            ]);

            if (!empty($request->inspection)) {
                $activityData = [];

                foreach ($request->inspection as $category => $activities) {
                    foreach ($activities as $activity => $data) {
                        $activityData[] = [
                            'inspection_cmt_id' => $inspectionCmt->id,
                            'category'          => $category,
                            'activity'          => $activity,
                            'critical_point'    => $data['critical_point'] ?? '',
                            'pre_inspect'       => $data['pre_inspect'],
                            'final_inspect'     => $data['final_inspect'],
                            'delivery_inspect'  => $data['delivery_inspect']
                        ];
                    }
                }
                InspectionCmtActivity::insert($activityData);
            }

            if (!empty($request->performance) || !empty($request->remark)) {

                $resultData = [];
                foreach ($request->remark as $component => $item) {
                    $resultData[] = [
                        'inspection_cmt_id' => $inspectionCmt->id,
                        'component'         => $component,
                        'performance'       => $request->performance[$component] ?? null,
                        'remark'            => $item,
                    ];
                }
                InspectionCmtResult::insert($resultData);
            }

            DB::commit();
            return redirect()->route('bss-form.plant.general-inspection.cmt.index')->with('success', 'Inspection data saved successfully.');
        } catch (Exception $e) {
            DB::rollBack();
            $errorMessages = 'Error Occured';
            if(env('APP_DEBUG')) {
                $errorMessages = $e->getMessage();
            }
            return response()->json([
                'success' => false,
                'message' => $errorMessages,
            ], 500);
        }
    }

    /**
     * Show the specified resource.
     */
    public function show(InspectionCmt $cmt)
    {
        return view('inspection_cmt.show', compact('cmt'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(InspectionCmt $cmt)
    {
        $result['sites'] = ['PMSS', 'MAS', 'MME', 'BRAM', 'TAJ', 'AGM', 'MSJ', 'TDM', 'BSSR', 'MBLM', 'MBLH', 'others'];
    
        $json = file_get_contents(resource_path('data/general-inspection/cmt/activity-list.json'));
        $result['activityChecklistJson'] = json_decode($json, true);
        
        $json = file_get_contents(resource_path('data/general-inspection/cmt/inspection-result.json'));
        $result['inspectionResultJson'] = json_decode($json, true);
        
        $inspectionData = [];

        foreach ($cmt->inspectionActivity as $activity) {
            $category = $activity->category;
            $activityName = $activity->activity;
    
            $inspectionData[$category][$activityName] = [
                'pre_inspect' => $activity->pre_inspect,
                'final_inspect' => $activity->final_inspect,
                'delivery_inspect' => $activity->delivery_inspect,
            ];
        }

        $inspectionResultData = [];
        $remarkData       = [];
        foreach ($cmt->inspectionResult as $inspectionResult) {
            $component   = $inspectionResult->component;
            $performance = $inspectionResult->performance;
            $remark      = $inspectionResult->remark;

            $inspectionResultData[$component] = $performance;

            $remarkData[$component] = $remark;
        }

        $result['inspection'] = [
            ...$cmt->toArray(),
            'activity'    => $inspectionData,
            'performance' => $inspectionResultData,
            'remark'      => $remarkData
        ];

        return view('smartform::plant.general-inspection.cmt.edit', $result);
    }    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $validator = Validator::make($request->all(), [
                'site'        => 'required|string',
                'model_unit'  => 'required|string',
                'cn'          => 'required|string',
                'hm'          => 'required|string',
                'inspection'  => 'array',
                'performance' => 'array',
                'remark'      => 'array'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => $validator->errors()->first(),
                ], 422);
            }

            // Find the existing record
            $inspectionCmt = InspectionCmt::findOrFail($id);

            // Update the main inspection details
            $inspectionCmt->update([
                'site'       => $request->site,
                'model_unit' => $request->model_unit,
                'cn'         => $request->cn,
                'hm'         => $request->hm
            ]);

            // Update Inspection Activities
            if (!empty($request->inspection)) {
                // Delete old records to prevent duplication
                InspectionCmtActivity::where('inspection_cmt_id', $id)->delete();

                $activityData = [];
                foreach ($request->inspection as $category => $activities) {
                    foreach ($activities as $activity => $data) {
                        $activityData[] = [
                            'inspection_cmt_id' => $id,
                            'category'          => $category,
                            'activity'          => $activity,
                            'critical_point'    => $data['critical_point'] ?? '',
                            'pre_inspect'       => $data['pre_inspect'],
                            'final_inspect'     => $data['final_inspect'],
                            'delivery_inspect'  => $data['delivery_inspect'],
                        ];
                    }
                }

                InspectionCmtActivity::insert($activityData);
            }

            // Update Performance Results
            if (!empty($request->performance) || !empty($request->remark)) {
                // Delete old records to prevent duplication
                InspectionCmtResult::where('inspection_cmt_id', $id)->delete();

                $resultData = [];
                foreach ($request->remark as $component => $item) {
                    $resultData[] = [
                        'inspection_cmt_id' => $id,
                        'component'         => $component,
                        'performance'       => $request->performance[$component] ?? null,
                        'remark'            => $item,
                    ];

                }
                InspectionCmtResult::insert($resultData);
            }

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Inspection data updated successfully.',
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            $errorMessages = 'Error Occurred';
            if (env('APP_DEBUG')) {
                $errorMessages = $e->getMessage();
            }
            return response()->json([
                'success' => false,
                'message' => $errorMessages,
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $inspectionCmt = InspectionCmt::findOrFail($id);

            $inspectionCmt->inspectionActivity()->delete();
            $inspectionCmt->inspectionResult()->delete();

            $inspectionCmt->delete();

            DB::commit();

            return redirect()->route('bss-form.plant.general-inspection.cmt.index')->with('success', 'Inspection deleted successfully.');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to delete inspection: ' . $e->getMessage());
        }
    }

    public function print($id)
    {
        $json = file_get_contents(resource_path('data/general-inspection/cmt/activity-list.json'));
        $result['activityChecklistJson'] = json_decode($json, true);

        $json = file_get_contents(resource_path('data/general-inspection/cmt/inspection-result.json'));
        $result['inspectionResultJson'] = json_decode($json, true);

        $inspectionData = [];

        $cmt = InspectionCmt::find($id);

        foreach ($cmt->inspectionActivity as $activity) {
            $category = $activity->category;
            $activityName = $activity->activity;
    
            $inspectionData[$category][$activityName] = [
                'pre_inspect' => $activity->pre_inspect,
                'final_inspect' => $activity->final_inspect,
                'delivery_inspect' => $activity->delivery_inspect,
            ];
        }

        $inspectionResultData = [];
        $remarkData       = [];
        foreach ($cmt->inspectionResult as $inspectionResult) {
            $component   = $inspectionResult->component;
            $performance = $inspectionResult->performance;
            $remark      = $inspectionResult->remark;

            $inspectionResultData[$component] = $performance;

            $remarkData[$component] = $remark;
        }

        $result['inspection'] = [
            ...$cmt->toArray(),
            'activity'    => $inspectionData,
            'performance' => $inspectionResultData,
            'remark'      => $remarkData
        ];



        return view('smartform::plant.general-inspection.cmt.print-template.index', $result);
    }

}
