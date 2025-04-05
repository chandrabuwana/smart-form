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
use Modules\SmartForm\helpers\HrdHelper;

class ErgonomiController extends Controller
{
    public function Dashboard(Request $request)
    {
        $query = DB::table('she_027_ergonomi')
            ->select(
                'id',
                'employee_name',
                'job_position',
                'reviewer_name',
                'total_employee',
                DB::raw('CONVERT(varchar, evaluation_date, 23) as evaluation_date'),
                'approval_status',
                'created_at'
            )
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
            // Check if this is a view/edit request for an existing record
            if ($request->filled('id')) {
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

                // Check if this is an edit request
                if ($request->has('edit')) {
                    return view('smartform::she.ergonomi.edit', [
                        'data' => (object)$data,
                        'approvalList' => HrdHelper::getApprovalList(),
                    ]);
                }

                return view('smartform::she.ergonomi.form', [
                    'isShowDetail' => true,
                    'data' => (object)$data,
                    'approvalList' => HrdHelper::getApprovalList(),
                ]);
            }

            return view('smartform::she.ergonomi.form', [
                'isShowDetail' => false,
                'isEditMode' => false,
                'approvalList' => HrdHelper::getApprovalList(),
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
                'reviewer_nik' => $request->reviewer_nik,
                'paramedic_nik' => $request->paramedic_nik,
                'doctor_nik' => $request->doctor_nik,
                'dept_head_nik' => $request->dept_head_nik,
                
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
            // Use DB::raw to format the dates in SQL Server
            $data = DB::table('she_027_ergonomi')
                ->select(
                    '*',
                    DB::raw("FORMAT(evaluation_date, 'yyyy-MM-dd') as formatted_evaluation_date"),
                    DB::raw("FORMAT(review_date, 'yyyy-MM-dd') as formatted_review_date")
                )
                ->where('id', $id)
                ->first();

            if (!$data) {
                return redirect()
                    ->route('she.ergonomi.dashboard')
                    ->with('error', 'Record not found.');
            }

            // Convert the formatted dates to the actual date fields for display
            if (isset($data->formatted_evaluation_date)) {
                $data->evaluation_date = $data->formatted_evaluation_date;
            }
            
            if (isset($data->formatted_review_date)) {
                $data->review_date = $data->formatted_review_date;
            }

            // Get approval list for dropdowns using HrdHelper
            $approvalList = HrdHelper::getApprovalList();

            return view('smartform::she/ergonomi/form', [
                'isShowDetail' => true,
                'data' => $data,
                'approvalList' => $approvalList
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

    /**
     * Show the edit form for a specific record
     */
    public function EditForm(Request $request, $id)
    {
        try {
            $data = DB::table('she_027_ergonomi')
                ->select(
                    '*',
                    DB::raw('CONVERT(varchar, evaluation_date, 23) as evaluation_date'),
                    DB::raw('CONVERT(varchar, review_date, 23) as review_date')
                )
                ->whereNull('deleted_at')
                ->where('id', $id)
                ->first();

            if (!$data) {
                return redirect()
                    ->route('she.ergonomi.dashboard')
                    ->with('error', 'Record not found.');
            }

            // Check if the current user is the creator of the record
            if (!session('username') || $data->employee_name != session('username')) {
                return redirect()->route('she.ergonomi.dashboard')
                    ->with('error', 'You are not authorized to edit this record');
            }

            // Check if the record has an approval status that allows editing
            if (isset($data->approval_status) && $data->approval_status == 'approved') {
                return redirect()->route('she.ergonomi.dashboard')
                    ->with('error', 'Approved records cannot be edited');
            }

            // Get approval list for dropdowns using HrdHelper
            $approvalList = HrdHelper::getApprovalList();

            return view('smartform::she/ergonomi/edit', [
                'data' => $data,
                'approvalList' => $approvalList
            ]);

        } catch (\Exception $e) {
            Log::error('Error in EditForm: ' . $e->getMessage());
            return redirect()->route('she.ergonomi.dashboard')
                ->with('error', 'Failed to load edit form: ' . $e->getMessage());
        }
    }

    /**
     * Update an existing record
     */
    public function UpdateForm(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id' => 'required|exists:she_027_ergonomi,id',
                'total_employee' => 'required|integer',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }

            // Get the record
            $record = DB::table('she_027_ergonomi')
                ->where('id', $request->id)
                ->first();

            if (!$record) {
                return response()->json([
                    'success' => false,
                    'message' => 'Record not found'
                ], 404);
            }

            // Check if the current user is the creator of the record
            if (!session('username') || $record->employee_name != session('username')) {
                return response()->json([
                    'success' => false,
                    'message' => 'You are not authorized to update this record'
                ], 403);
            }

            // Check if the record has an approval status that allows editing
            if (isset($record->approval_status) && $record->approval_status == 'approved') {
                return response()->json([
                    'success' => false,
                    'message' => 'Approved records cannot be edited'
                ], 403);
            }

            // Prepare the data for update
            $data = [
                'job_position' => $request->job_position,
                'evaluation_date' => $request->evaluation_date ? Carbon::createFromFormat('Y-m-d', $request->evaluation_date)->format('Y-m-d') : null,
                'reviewer_nik' => $request->reviewer_nik,
                'paramedic_nik' => $request->paramedic_nik,
                'doctor_nik' => $request->doctor_nik,
                'dept_head_nik' => $request->dept_head_nik,
                'total_employee' => $request->total_employee,
                'employee_name' => $request->employee_name,
                'reviewer_name' => $request->reviewer_name,
                'paramedic_name' => $request->paramedic_name,
                'doctor_name' => $request->doctor_name,
                'dept_head_name' => $request->dept_head_name,
                'review_date' => $request->review_date ? Carbon::createFromFormat('Y-m-d', $request->review_date)->format('Y-m-d') : null,
                'updated_at' => now(),
            ];

            // Add all the checklist items
            for ($i = 1; $i <= 14; $i++) {
                $data['item_' . $i] = $request->has('item_' . $i) ? true : false;
                $data['item_' . $i . '_observation'] = $request->{'item_' . $i . '_observation'};
            }

            // Add WMSD checkbox values
            $wmsdFields = [
                'wmsd_bahu_1', 'wmsd_bahu_2', 'wmsd_leher', 
                'wmsd_punggung_1', 'wmsd_punggung_2', 
                'wmsd_tangan_kuat_1', 'wmsd_tangan_kuat_2', 'wmsd_tangan_kuat_3',
                'wmsd_berulang_1', 'wmsd_berulang_2'
            ];
            
            foreach ($wmsdFields as $field) {
                $data[$field] = $request->has($field) ? true : false;
            }
            
            // Add observation fields
            $observationFields = [
                'posture_observation', 'force_observation', 
                'impact_observation', 'vibration_observation',
                'kesimpulan_penilai', 'komentar_berulang'
            ];
            
            foreach ($observationFields as $field) {
                if ($request->has($field)) {
                    $data[$field] = $request->{$field};
                }
            }

            // Update the record
            DB::table('she_027_ergonomi')
                ->where('id', $request->id)
                ->update($data);

            return response()->json([
                'success' => true,
                'message' => 'Ergonomi record updated successfully'
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Error in UpdateForm: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to update record: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete a record
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function Delete(Request $request, $id)
    {
        try {
            // Get the record
            $record = DB::table('she_027_ergonomi')
                ->where('id', $id)
                ->first();

            if (!$record) {
                return response()->json([
                    'success' => false,
                    'message' => 'Record not found.'
                ], 404);
            }

            // Check if the current user is the creator of the record
            if (!session('username') || $record->employee_name != session('username')) {
                return response()->json([
                    'success' => false,
                    'message' => 'You are not authorized to delete this record.'
                ], 403);
            }

            // Check if the record has an approval status that allows deletion
            if (isset($record->approval_status) && $record->approval_status == 'approved') {
                return response()->json([
                    'success' => false,
                    'message' => 'Approved records cannot be deleted.'
                ], 403);
            }

            // Soft delete the record
            DB::table('she_027_ergonomi')
                ->where('id', $id)
                ->update([
                    'deleted_at' => now()
                ]);

            return response()->json([
                'success' => true,
                'message' => 'Record deleted successfully.'
            ]);

        } catch (\Exception $e) {
            Log::error('Error in Delete: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete record: ' . $e->getMessage()
            ], 500);
        }
    }
}