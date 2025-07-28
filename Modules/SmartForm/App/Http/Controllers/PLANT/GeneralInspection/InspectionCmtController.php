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
use Modules\SmartForm\helpers\HrdHelper;

class InspectionCmtController extends Controller
{
    public function index()
    {
        try {
            $nik_session = request()->session()->get('user_id', '');
            $statistics = ( object )[
                'total_records' => DB::table( 'plant_general_inspection_cmt' )->count(),
                'total_this_month' => DB::table( 'plant_general_inspection_cmt' )
                ->whereMonth( 'created_at', now()->month )
                ->whereYear( 'created_at', now()->year )
                ->count(),
                'model_unit' => DB::table( 'plant_general_inspection_cmt' )->distinct()->count( 'model_unit' ),

            ];

            $sites = ['PMSS', 'MAS', 'MME', 'BRAM', 'TAJ', 'AGM', 'MSJ', 'TDM', 'BSSR', 'MBLM', 'MBLH', 'others'];
            return view('smartform::plant.general-inspection.cmt.index', ['sites'=>$sites, 'approvalList' => HrdHelper::getApprovalList(), 'session'=>$nik_session, 'statistics'=> $statistics]);
        } catch (Exception $e) {
            $errorMessages = env('APP_DEBUG') ? $e->getMessage() : 'Error Occurred';
            return redirect()->back()->with('error', $errorMessages);
        }
    }

    public function getData( Request $request)
    {
        try {
            $search = $request->query('search');
            $sort   = $request->query('sort', 'created_at');
            $order  = $request->query('order', 'desc');

            // Ambil filter tambahan dari request
            $site       = $request->query('site');
            $status  = $request->query('status');
            $date       = $request->query('date');
            $model       = $request->query('model');

            $inspectionCmt = InspectionCmt::select('id', 'diperiksa','creator','diketahui','status', 'status_form', 'site', 'model_unit', 'cn', 'hm', 'created_at')
                ->when($search, function ($query) use ($search) {
                    $query->where(function ($q) use ($search) {
                        $q->where('site', 'LIKE', "%$search%")
                            ->orWhere('model_unit', 'LIKE', "%$search%")
                            ->orWhere('cn', 'LIKE', "%$search%")
                            ->orWhere('hm', 'LIKE', "%$search%")
                            ->orWhere('created_at', 'LIKE', "%$search%");
                    });
                })
                ->when($site, function ($query) use ($site) {
                    return $query->where('site', 'LIKE', "%$site%");
                })
                ->when($status, function ($query) use ($status) {
                    return $query->where('status', 'LIKE', "%$status%");
                })
                ->when($date, function ($query) use ($date) {
                    return $query->whereDate('created_at', $date);
                })
                ->when($model, function ($query) use ($model) {
                    return $query->where('model_unit','LIKE', "%$model%");
                })
                ->orderBy($sort, $order)
                ->paginate(10);





            $inspectionCmt->getCollection()->transform(function ($inspection) {
                $statuses = collect(json_decode($inspection->status, true));


                if ($statuses->contains('Rejected')) {
                    $status = 'Rejected';
                } elseif ($statuses->contains('Draft')) {
                    $status = 'Draft';
                } else {
                    $status = 'Approved';
                }
                return [
                    ...$inspection->toArray(),
                    'created_at' => Carbon::parse($inspection->created_at)->format('d M Y'),
                    'status' =>$status,
                ];

            });

            return response()->json([
                'status'  => true,
                'message' => 'Data fetched successfully.',
                'data'    => $inspectionCmt,
            ]);
        } catch (Exception $e) {
            $errorMessages = env('APP_DEBUG') ? $e->getMessage() : 'Error Occurred';
            return response()->json(['status' => false, 'message' => $errorMessages], 500);
        }
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $nik_session = request()->session()->get('username', '');
        $sites = ['PMSS', 'MAS', 'MME', 'BRAM', 'TAJ', 'AGM', 'MSJ', 'TDM', 'BSSR', 'MBLM', 'MBLH', 'others'];

        $json = file_get_contents(resource_path('data/general-inspection/cmt/activity-list.json'));
        $activityChecklistJson = json_decode($json, true);

        $json = file_get_contents(resource_path('data/general-inspection/cmt/inspection-result.json'));
        $inspectionResultJson = json_decode($json, true);
        $cn_data = DB::table( 'alat_angkut_data' )->select('no_lambung','model')->get();
        return view('smartform::plant.general-inspection.cmt.create', [
            'nik' => $nik_session,
            'cn' => $cn_data,
            'sites' => $sites,
            'activityChecklistJson' => $activityChecklistJson,
            'inspectionResultJson' => $inspectionResultJson,
            'approvalList' => HrdHelper::getApprovalList()
        ]);

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
                'dilakukan1'  => 'required|string',
                'dilakukan2'  => 'required|string',
                'diperiksa'   => 'required|string',
                'diketahui'   => 'required|string',
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
                'hm'         => $request->hm,
                'dilakukan1' => $request->dilakukan1,
                'dilakukan2' => $request->dilakukan2,
                'diperiksa'  => $request->diperiksa,
                'diketahui'  => $request->diketahui,
                'note' => $request->note,
                'date_inspection' => $request->date,
                'creator'    => $request->session()->get('user_id', ''),
                'date_sign1' => Carbon::now(),
                'date_sign2' => null,
                'date_sign3' => null,
                'status_form' =>"Pre inspeksi",
                'status' => json_encode( array_values( [
                    'Draft',
                    'Draft'
                ] ) ),
                'created_at' => Carbon::now(),
                 'updated_at' => Carbon::now()
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
    public function show(InspectionCmt $cmt, Request $request)
    {
        $nik_session = $request->session()->get( 'user_id', '' );
        $sites = ['PMSS', 'MAS', 'MME', 'BRAM', 'TAJ', 'AGM', 'MSJ', 'TDM', 'BSSR', 'MBLM', 'MBLH', 'others'];

        $json = file_get_contents(resource_path('data/general-inspection/cmt/activity-list.json'));
        $activityChecklistJson = json_decode($json, true);

        $json = file_get_contents(resource_path('data/general-inspection/cmt/inspection-result.json'));
        $inspectionResultJson = json_decode($json, true);

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

        $inspection = [
            ...$cmt->toArray(),
            'activity'    => $inspectionData,
            'performance' => $inspectionResultData,
            'remark'      => $remarkData
        ];

  $cn_data = DB::table( 'alat_angkut_data' )->select('no_lambung','model')->get();
        $status = json_decode($cmt->status, true);

        return view('smartform::plant.general-inspection.cmt.show', [
            'cn' => $cn_data,
            'activityChecklistJson' => $activityChecklistJson,
            'inspectionResultJson' => $inspectionResultJson,
            'inspection' => $inspection,
            'sites' => $sites,
            'nik'=> $nik_session,
            'status' => $status,
            'approvalList' => HrdHelper::getApprovalList()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(InspectionCmt $cmt)
    {
        $sites = ['PMSS', 'MAS', 'MME', 'BRAM', 'TAJ', 'AGM', 'MSJ', 'TDM', 'BSSR', 'MBLM', 'MBLH', 'others'];

        $json = file_get_contents(resource_path('data/general-inspection/cmt/activity-list.json'));
        $activityChecklistJson = json_decode($json, true);

        $json = file_get_contents(resource_path('data/general-inspection/cmt/inspection-result.json'));
        $inspectionResultJson = json_decode($json, true);

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


        $inspection = [
            ...$cmt->toArray(),
            'activity'    => $inspectionData,
            'performance' => $inspectionResultData,
            'remark'      => $remarkData
        ];





  $cn_data = DB::table( 'alat_angkut_data' )->select('no_lambung','model')->get();
        return view('smartform::plant.general-inspection.cmt.edit', [
            'cn' => $cn_data,
            'activityChecklistJson' => $activityChecklistJson,
            'inspectionResultJson' => $inspectionResultJson,
            'inspection' => $inspection,
            'sites' => $sites,
            'approvalList' => HrdHelper::getApprovalList()
        ]);
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
                'note'       => $request->note,
                'date_inspection' => $request->date,
                'hm'         => $request->hm,
                'status_form' =>$request->status_form,
                'dilakukan1' => $request->dilakukan1,
                'dilakukan2' => $request->dilakukan2,
                'diperiksa'  => $request->diperiksa,
                'diketahui'  => $request->diketahui,
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
    public function Approve( Request $request ) {

        if($request->date2 == true){
          $date2 = Carbon::now();
        }else{
            $date2 = $request->datesign2;
        }
        if($request->date3 == true){
          $date3 = Carbon::now();
        }else{
            $date3 = $request->datesign3;

        }

        $data = [
            'status' => json_encode( array_values( [
                $request->diperiksa,
                $request->diketahui
            ] ) ),
            'date_sign2' => $date2,
            'date_sign3' =>$date3,
            'updated_at' => Carbon::now()
        ];

        DB::table( 'plant_general_inspection_cmt' )
        ->where( 'id', $request->id )
        ->update( $data );

        return response()->json( [
            'success' => true,
            'message' => 'Data berhasil di Approve'
        ] );

    }
    public function Reset( $id ) {

        $data = [
            'status' => json_encode( array_values( [
              'Draft',
              'Draft'
            ] ) ),
            'date_sign2' => null,
            'date_sign3' => null,
            'updated_at' => Carbon::now()
        ];

        DB::table( 'plant_general_inspection_cmt' )
        ->where( 'id', $id )
        ->update( $data );

        return response()->json( [
            'success' => true,
            'message' => 'Data berhasil di Reset'
        ] );

    }

    public function Reject( Request $request ) {
        if($request->date2 == true){
            $date2 = Carbon::now();
          }else{
              $date2 = $request->datesign2;
          }
          if($request->date3 == true){
            $date3 = Carbon::now();
          }else{
              $date3 = $request->datesign3;

          }
        $data = [
            'status' => json_encode( array_values( [
                $request->diperiksa,
                $request->diketahui

            ] ) ),
            'date_sign2' => $date2,
            'date_sign3' => $date3,
            'updated_at' => Carbon::now()
        ];

        DB::table( 'plant_general_inspection_cmt' )
        ->where( 'id', $request->id )
        ->update( $data );

        return response()->json( [
            'success' => true,
            'message' => 'Data berhasil di Reject'
        ] );
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



        $result['approvalList'] = HrdHelper::getApprovalList();


        return view('smartform::plant.general-inspection.cmt.print-template.index', $result);
    }
public function getApprovalList(Request $request)
    {
        $search = $request->input('search', '');
        $list = HrdHelper::getApprovalList($search);

        return response()->json($list);
    }
}
