<?php

namespace Modules\SmartForm\App\Http\Controllers\SHE;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class ErgonomiController extends Controller
{
    public function Dashboard(Request $request)
    {
        $query = DB::table('she_027_ergonomi')
            ->whereNull('deleted_at');

        // Apply filters
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('employee_name', 'like', "%{$search}%")
                  ->orWhere('job_position', 'like', "%{$search}%");
            });
        }

        if ($request->filled('reviewer_name')) {
            $query->where('reviewer_name', $request->reviewer_name);
        }

        if ($request->filled('start_date')) {
            $query->where('evaluation_date', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->where('evaluation_date', '<=', $request->end_date);
        }

        // Get statistics
        $statistics = (object)[
            'total_records' => DB::table('she_027_ergonomi')->whereNull('deleted_at')->count(),
            'total_this_month' => DB::table('she_027_ergonomi')
                ->whereNull('deleted_at')
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count(),
            'total_employees' => DB::table('she_027_ergonomi')
                ->whereNull('deleted_at')
                ->sum('total_employee') ?? 0,
            'high_risk_count' => DB::table('she_027_ergonomi')
                ->whereNull('deleted_at')
                ->where(function($query) {
                    $query->where('wmsd_bahu_1', true)
                          ->orWhere('wmsd_bahu_2', true)
                          ->orWhere('wmsd_punggung_1', true)
                          ->orWhere('wmsd_punggung_2', true)
                          ->orWhere('wmsd_tangan_kuat_1', true)
                          ->orWhere('wmsd_tangan_kuat_2', true)
                          ->orWhere('wmsd_tangan_kuat_3', true)
                          ->orWhere('wmsd_berulang_1', true)
                          ->orWhere('wmsd_berulang_2', true);
                })
                ->count()
        ];

        // Get filter options
        $filter_options = (object)[
            'reviewers' => DB::table('she_027_ergonomi')
                ->whereNull('deleted_at')
                ->distinct()
                ->pluck('reviewer_name')
                ->filter()
                ->values()
                ->toArray()
        ];

        // Get paginated records
        $records = $query->orderBy('created_at', 'desc')
                        ->paginate(10)
                        ->withQueryString();

        return view('smartform::she.ergonomi.dashboard', [
            'records' => $records,
            'statistics' => $statistics,
            'filter_options' => $filter_options,
            'filters' => $request->all()
        ]);
    }

    public function DashboardNew(Request $request)
    {
        $query = DB::table('she_027_ergonomi')
            ->whereNull('deleted_at');

        // Apply filters
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('employee_name', 'like', "%{$search}%")
                  ->orWhere('job_position', 'like', "%{$search}%");
            });
        }

        if ($request->filled('reviewer_name')) {
            $query->where('reviewer_name', $request->reviewer_name);
        }

        if ($request->filled('start_date')) {
            $query->where('evaluation_date', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->where('evaluation_date', '<=', $request->end_date);
        }

        // Get statistics
        $statistics = (object)[
            'total_records' => $query->count(),
            'total_this_month' => $query->whereMonth('created_at', now()->month)
                                      ->whereYear('created_at', now()->year)
                                      ->count(),
            'total_employees' => $query->sum('total_employee'),
            'high_risk_count' => $query->where(function($q) {
                $q->where('wmsd_bahu_1', true)
                  ->orWhere('wmsd_bahu_2', true)
                  ->orWhere('wmsd_punggung_1', true)
                  ->orWhere('wmsd_punggung_2', true)
                  ->orWhere('wmsd_tangan_kuat_1', true)
                  ->orWhere('wmsd_tangan_kuat_2', true)
                  ->orWhere('wmsd_tangan_kuat_3', true)
                  ->orWhere('wmsd_berulang_1', true)
                  ->orWhere('wmsd_berulang_2', true);
            })->count()
        ];

        // Get filter options
        $filter_options = (object)[
            'reviewers' => DB::table('she_027_ergonomi')
                            ->whereNull('deleted_at')
                            ->distinct()
                            ->pluck('reviewer_name')
                            ->filter()
                            ->values()
                            ->toArray()
        ];

        // Get paginated records
        $records = $query->orderBy('created_at', 'desc')
                        ->paginate(10);

        return view('smartform::she.ergonomi.dashboard', compact(
            'records',
            'statistics',
            'filter_options'
        ))->with('filters', $request->all());
    }

    public function AddForm()
    {
        return view('SmartForm::she/ergonomi/form', [
            'isShowDetail' => false
        ]);
    }

    public function Store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'total_employee' => 'required|integer',
                'employee_name' => 'required|string',
                'reviewer_name' => 'required|string',
                'paramedic_name' => 'required|string',
                'doctor_name' => 'required|string',
                'dept_head_name' => 'required|string',
                'review_date' => 'required|date'
            ]);

            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            $data = [
                // Required fields
                'total_employee' => $request->total_employee,
                'employee_name' => $request->employee_name,
                'reviewer_name' => $request->reviewer_name,
                'paramedic_name' => $request->paramedic_name,
                'doctor_name' => $request->doctor_name,
                'dept_head_name' => $request->dept_head_name,
                'review_date' => $request->review_date,
                
                // Optional fields
                'job_position' => $request->job_position,
                'evaluation_date' => $request->evaluation_date,
                'employee_id' => $request->employee_id,
                'reviewer_id' => $request->reviewer_id,
                
                // Checklist items
                'item_1' => $request->has('item_1'),
                'item_2' => $request->has('item_2'),
                'item_3' => $request->has('item_3'),
                'item_4' => $request->has('item_4'),
                'item_5' => $request->has('item_5'),
                'item_6' => $request->has('item_6'),
                'item_7' => $request->has('item_7'),
                'item_8' => $request->has('item_8'),
                'item_9' => $request->has('item_9'),
                'item_10' => $request->has('item_10'),
                'item_11' => $request->has('item_11'),
                'item_12' => $request->has('item_12'),
                'item_13' => $request->has('item_13'),
                'item_14' => $request->has('item_14'),
                
                // WMSD checkboxes
                'wmsd_bahu_1' => $request->has('wmsd_bahu_1'),
                'wmsd_bahu_2' => $request->has('wmsd_bahu_2'),
                'wmsd_punggung_1' => $request->has('wmsd_punggung_1'),
                'wmsd_punggung_2' => $request->has('wmsd_punggung_2'),
                'wmsd_tangan_kuat_1' => $request->has('wmsd_tangan_kuat_1'),
                'wmsd_tangan_kuat_2' => $request->has('wmsd_tangan_kuat_2'),
                'wmsd_tangan_kuat_3' => $request->has('wmsd_tangan_kuat_3'),
                'wmsd_berulang_1' => $request->has('wmsd_berulang_1'),
                'wmsd_berulang_2' => $request->has('wmsd_berulang_2'),
                
                // Observations and comments
                'posture_observation' => $request->posture_observation,
                'force_observation' => $request->force_observation,
                'impact_observation' => $request->impact_observation,
                'vibration_observation' => $request->vibration_observation,
                'kesimpulan_penilai' => $request->kesimpulan_penilai,
                'komentar_berulang' => $request->komentar_berulang,
                
                'created_at' => now(),
                'updated_at' => now()
            ];

            DB::table('she_027_ergonomi')->insert($data);

            return response()->json([
                'success' => true,
                'message' => 'Ergonomi survey has been saved successfully.'
            ]);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Error in Store: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to save ergonomi survey: ' . $e->getMessage()
            ], 500);
        }
    }

    public function Show($id)
    {
        try {
            $data = DB::table('she_027_ergonomi')
                ->where('id', $id)
                ->first();

            if (!$data) {
                return redirect()
                    ->route('she.ergonomi.dashboard')
                    ->with('error', 'Record not found.');
            }

            return view('SmartForm::she/ergonomi/form', [
                'isShowDetail' => true,
                'data' => $data
            ]);

        } catch (\Exception $e) {
            Log::error('Error in Show: ' . $e->getMessage());
            return redirect()
                ->back()
                ->with('error', 'Failed to load record: ' . $e->getMessage());
        }
    }

    public function Export($id)
    {
        try {
            $data = DB::table('she_027_ergonomi')
                ->where('id', $id)
                ->first();

            if (!$data) {
                return redirect()
                    ->route('she.ergonomi.dashboard')
                    ->with('error', 'Record not found.');
            }

            $pdf = PDF::loadView('SmartForm::she/ergonomi/export-pdf', [
                'data' => $data
            ]);

            return $pdf->stream('ergonomi-survey.pdf');

        } catch (\Exception $e) {
            Log::error('Error in Export: ' . $e->getMessage());
            return redirect()
                ->back()
                ->with('error', 'Failed to generate PDF: ' . $e->getMessage());
        }
    }
}