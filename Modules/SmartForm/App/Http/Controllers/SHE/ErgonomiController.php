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
                          ->orWhere('wmsd_leher', true)
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

    public function AddForm(Request $request)
    {
        try {
            if ($request->has('id')) {
                Log::info('Ergonomi AddForm - Fetching record with ID: ' . $request->id);
                
                $query = DB::table('she_027_ergonomi')
                    ->whereNull('deleted_at')
                    ->where('id', $request->id);
                
                Log::info('Ergonomi AddForm - SQL Query: ' . $query->toSql());
                Log::info('Ergonomi AddForm - Query Bindings: ', $query->getBindings());
                
                $data = $query->first();
                Log::info('Ergonomi AddForm - Query Result: ', ['data' => $data]);

                if (!$data) {
                    Log::error('Ergonomi record not found for ID: ' . $request->id);
                    return redirect()->route('she.ergonomi.dashboard')
                        ->with('error', 'Record not found');
                }

                // Convert stdClass to array to make it easier to work with in the view
                $data = json_decode(json_encode($data), true);

                return view('smartform::she.ergonomi.form', [
                    'isShowDetail' => true,
                    'data' => (object)$data
                ]);
            }

            return view('smartform::she.ergonomi.form', [
                'isShowDetail' => false
            ]);
        } catch (\Exception $e) {
            Log::error('Error in AddForm: ' . $e->getMessage());
            return redirect()->route('she.ergonomi.dashboard')
                ->with('error', 'Failed to load form: ' . $e->getMessage());
        }
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
                
                // Item observations
                'item_1_observation' => $request->item_1_observation,
                'item_2_observation' => $request->item_2_observation,
                'item_3_observation' => $request->item_3_observation,
                'item_4_observation' => $request->item_4_observation,
                'item_5_observation' => $request->item_5_observation,
                'item_6_observation' => $request->item_6_observation,
                'item_7_observation' => $request->item_7_observation,
                'item_8_observation' => $request->item_8_observation,
                'item_9_observation' => $request->item_9_observation,
                'item_10_observation' => $request->item_10_observation,
                'item_11_observation' => $request->item_11_observation,
                'item_12_observation' => $request->item_12_observation,
                'item_13_observation' => $request->item_13_observation,
                'item_14_observation' => $request->item_14_observation,
                
                // WMSD checkboxes
                'wmsd_bahu_1' => $request->has('wmsd_bahu_1'),
                'wmsd_bahu_2' => $request->has('wmsd_bahu_2'),
                'wmsd_leher' => $request->has('wmsd_leher'),
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

            // Convert stdClass to array to make it easier to work with in the view
            $data = json_decode(json_encode($data), true);

            return view('smartform::she/ergonomi/form', [
                'isShowDetail' => true,
                'data' => (object)$data // Convert back to object for view compatibility
            ]);

        } catch (\Exception $e) {
            Log::error('Error in Show: ' . $e->getMessage());
            return redirect()
                ->back()
                ->with('error', 'Failed to load record: ' . $e->getMessage());
        }
    }

    public function ExportForm($id)
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

            // Convert stdClass to array to make it easier to work with in the view
            $data = json_decode(json_encode($data), true);

            // Helper function to parse SQL Server dates
            $parseSqlServerDate = function($date) {
                if (!$date) return null;
                try {
                    // Remove the :AM or :PM from SQL Server date
                    $date = preg_replace('/:([AP]M)/', ' $1', $date);
                    return Carbon::createFromFormat('M j Y h:i:s A', $date)->format('Y-m-d');
                } catch (\Exception $e) {
                    Log::error('Date parsing error: ' . $e->getMessage());
                    return null;
                }
            };

            // Format dates properly for SQL Server dates
            if (isset($data['evaluation_date'])) {
                $data['evaluation_date'] = $parseSqlServerDate($data['evaluation_date']);
            }
            if (isset($data['review_date'])) {
                $data['review_date'] = $parseSqlServerDate($data['review_date']);
            }
            if (isset($data['created_at'])) {
                $data['created_at'] = $parseSqlServerDate($data['created_at']);
            }
            if (isset($data['updated_at'])) {
                $data['updated_at'] = $parseSqlServerDate($data['updated_at']);
            }

            $pdf = PDF::loadView('smartform::she/ergonomi/export-pdf', [
                'data' => (object)$data // Convert back to object for view compatibility
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