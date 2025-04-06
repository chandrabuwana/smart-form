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

class AirMinumController extends Controller
{
    public function Dashboard(Request $request)
    {
        try {
            $query = DB::table('she_air_minum')
                ->select([
                    'she_air_minum.*',
                    DB::raw('CONVERT(varchar, inspection_date, 23) as formatted_date')
                ]);

            // Search functionality
            if ($request->has('search')) {
                $searchTerm = $request->search;
                $query->where(function($q) use ($searchTerm) {
                    $q->where('doc_number', 'like', '%' . $searchTerm . '%')
                        ->orWhere('work_location', 'like', '%' . $searchTerm . '%')
                        ->orWhere('inspector_1', 'like', '%' . $searchTerm . '%');
                });
            }

            // Date range filter
            if ($request->has('start_date') && $request->start_date) {
                $query->whereDate('inspection_date', '>=', $request->start_date);
            }
            if ($request->has('end_date') && $request->end_date) {
                $query->whereDate('inspection_date', '<=', $request->end_date);
            }

            // Location filter
            if ($request->has('work_location') && $request->work_location) {
                $query->where('work_location', $request->work_location);
            }

            // Get unique locations for filter
            $locations = DB::table('she_air_minum')
                ->select('work_location')
                ->distinct()
                ->whereNotNull('work_location')
                ->whereNull('deleted_at')
                ->pluck('work_location');

            // Filter options object
            $filter_options = (object)[
                'locations' => $locations,
            ];

            // Get records with pagination
            $records = $query->whereNull('deleted_at')
                           ->orderBy('created_at', 'desc')
                           ->paginate(10)
                           ->withQueryString();

            // Calculate statistics
            $statistics = (object)[
                'total_records' => DB::table('she_air_minum')->whereNull('deleted_at')->count(),
                'total_this_month' => DB::table('she_air_minum')
                    ->whereNull('deleted_at')
                    ->whereMonth('created_at', now()->month)
                    ->whereYear('created_at', now()->year)
                    ->count(),
                'locations_count' => $locations->count(),
                'need_attention' => DB::table('she_air_minum')
                    ->whereNull('deleted_at')
                    ->where(function($query) {
                        $query->where('has_scattered_items', true)  // Barang berserakan
                            ->orWhere('has_scattered_trash', true); // Sampah berserakan
                    })
                    ->count()
            ];

            return view('SmartForm::she/air_minum/dashboard', [
                'records' => $records,
                'statistics' => $statistics,
                'filter_options' => $filter_options,
                'filters' => [
                    'search' => $request->search,
                    'start_date' => $request->start_date,
                    'end_date' => $request->end_date,
                    'work_location' => $request->work_location,
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Error in Dashboard: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to load dashboard data: ' . $e->getMessage());
        }
    }

    public function AddForm(Request $request)
    {
        try {
            if ($request->has('id')) {
                $record = DB::table('she_air_minum')
                    ->where('id', $request->id)
                    ->first();

                if (!$record) {
                    Log::error('Air Minum record not found for ID: ' . $request->id);
                    return redirect()->route('she.air-minum.dashboard')
                        ->with('error', 'Record not found');
                }

                try {
                    // Clean up the date string by removing extra colons and normalizing AM/PM
                    $dateStr = preg_replace(['/::/', '/\s+/'], [':', ' '], $record->inspection_date);
                    $dateStr = str_replace(':AM', ' AM', str_replace(':PM', ' PM', $dateStr));
                    $dateStr = trim($dateStr);
                    
                    if (strpos($dateStr, 'AM') !== false || strpos($dateStr, 'PM') !== false) {
                        // If it's in AM/PM format
                        try {
                            $record->inspection_date = Carbon::createFromFormat('M d Y h:i:s A', $dateStr)->format('Y-m-d');
                        } catch (\Exception $e) {
                            // Try another format
                            try {
                                $record->inspection_date = Carbon::parse($dateStr)->format('Y-m-d');
                            } catch (\Exception $e2) {
                                Log::error('Failed to parse inspection_date: ' . $e2->getMessage());
                                $record->inspection_date = now()->format('Y-m-d');
                            }
                        }
                    } else {
                        // If it's in regular date format
                        try {
                            $record->inspection_date = Carbon::parse($dateStr)->format('Y-m-d');
                        } catch (\Exception $e) {
                            Log::error('Failed to parse inspection_date: ' . $e->getMessage());
                            $record->inspection_date = now()->format('Y-m-d');
                        }
                    }
                } catch (\Exception $e) {
                    Log::error('Date parsing error for inspection_date: ' . $e->getMessage() . ' | Original value: ' . $record->inspection_date);
                    $record->inspection_date = now()->format('Y-m-d');
                }

                // Format inspector dates
                $this->formatDateField($record, 'inspector_1_date');
                $this->formatDateField($record, 'inspector_2_date');
                $this->formatDateField($record, 'inspector_3_date');
                $this->formatDateField($record, 'acknowledged_date');

                $approvalList = HrdHelper::getApprovalList();
                
                // Check if this is a detail view or edit view
                $isEditMode = $request->has('edit') && $request->edit === 'true';
                $isShowDetail = true;
                
                // If it's a detail view (not edit mode), use the form view with read-only fields
                if (!$isEditMode) {
                    return view('smartform::she.air_minum.form', [
                        'maintenanceRecord' => $record,
                        'approvalList' => $approvalList,
                        'isShowDetail' => $isShowDetail,
                        'isEditMode' => false
                    ]);
                }
                
                // If it's an edit view, use the edit view
                return view('smartform::she.air_minum.edit', [
                    'maintenanceRecord' => $record,
                    'approvalList' => $approvalList,
                    'isShowDetail' => $isShowDetail
                ]);
            }

            $defaultValues = [
                'site_name' => session('site_name', ''),
                'shift' => session('shift', '')
            ];

            $approvalList = HrdHelper::getApprovalList();

            return view('smartform::she.air_minum.form', [
                'defaultValues' => $defaultValues,
                'approvalList' => $approvalList,
                'isShowDetail' => false,
                'isEditMode' => false
            ]);
        } catch (\Exception $e) {
            Log::error('Error in AddForm: ' . $e->getMessage());
            return redirect()->route('she.air-minum.dashboard')
                ->with('error', 'Failed to load form: ' . $e->getMessage());
        }
    }

    /**
     * Helper method to format date fields
     */
    private function formatDateField(&$record, $fieldName)
    {
        if (empty($record->$fieldName)) {
            return;
        }

        try {
            // Clean up the date string
            $dateStr = preg_replace(['/::/', '/\s+/'], [':', ' '], $record->$fieldName);
            $dateStr = str_replace(':AM', ' AM', str_replace(':PM', ' PM', $dateStr));
            $dateStr = trim($dateStr);
            
            if (strpos($dateStr, 'AM') !== false || strpos($dateStr, 'PM') !== false) {
                // If it's in AM/PM format
                try {
                    $record->$fieldName = Carbon::createFromFormat('M d Y h:i:s A', $dateStr)->format('Y-m-d');
                } catch (\Exception $e) {
                    // Try another format
                    try {
                        $record->$fieldName = Carbon::parse($dateStr)->format('Y-m-d');
                    } catch (\Exception $e2) {
                        Log::error("Failed to parse $fieldName: " . $e2->getMessage());
                        $record->$fieldName = now()->format('Y-m-d');
                    }
                }
            } else {
                // If it's in regular date format
                try {
                    $record->$fieldName = Carbon::parse($dateStr)->format('Y-m-d');
                } catch (\Exception $e) {
                    Log::error("Failed to parse $fieldName: " . $e->getMessage());
                    $record->$fieldName = now()->format('Y-m-d');
                }
            }
        } catch (\Exception $e) {
            Log::error("Date parsing error for $fieldName: " . $e->getMessage() . ' | Original value: ' . $record->$fieldName);
            $record->$fieldName = now()->format('Y-m-d');
        }
    }

    public function Store(Request $request)
    {
        try {
            Log::info('Processing Air Minum form submission');

            $validator = Validator::make($request->all(), [
                'site_name' => 'required|string',
                'department' => 'required|string',
                'shift' => 'required|string',
                'work_location' => 'required|string',
                'inspector_count' => 'required|integer',
                'inspector_1_name' => 'required|string',
                'inspector_1_nik' => 'required|string',
                'inspector_1_date' => 'required|date',
                'inspector_2_name' => 'nullable|string',
                'inspector_2_nik' => 'nullable|string',
                'inspector_2_date' => 'nullable|date',
                'inspector_3_name' => 'nullable|string',
                'inspector_3_nik' => 'nullable|string',
                'inspector_3_date' => 'nullable|date',
                'acknowledged_by_name' => 'required|string',
                'acknowledged_by_nik' => 'required|string',
                'acknowledged_date' => 'required|date',
                'is_work_area_clean' => 'required|boolean',
                'has_scattered_items' => 'required|boolean',
                'has_trash_bin' => 'required|boolean',
                'has_scattered_trash' => 'required|boolean',
                'has_storage_warehouse' => 'required|boolean',
                'is_water_filter_regularly_changed' => 'required|boolean',
                'is_water_reservoir_cleaned' => 'required|boolean',
                'is_distribution_packing_clean' => 'required|boolean',
                'is_water_quality_checked_quarterly' => 'required|boolean',
            ]);

            if ($validator->fails()) {
                Log::warning('Validation failed: ' . json_encode($validator->errors()));
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }

            DB::beginTransaction();

            try {
                // Generate document number
                $docNumber = $this->generateDocNumber();

                // Calculate score based on checklist items
                $score = 0;
                $score += $request->is_work_area_clean ? 1 : 0;
                $score += !$request->has_scattered_items ? 1 : 0; // Inverse for negative questions
                $score += $request->has_trash_bin ? 1 : 0;
                $score += !$request->has_scattered_trash ? 1 : 0; // Inverse for negative questions
                $score += $request->has_storage_warehouse ? 1 : 0;
                $score += $request->is_water_filter_regularly_changed ? 1 : 0;
                $score += $request->is_water_reservoir_cleaned ? 1 : 0;
                $score += $request->is_distribution_packing_clean ? 1 : 0;
                $score += $request->is_water_quality_checked_quarterly ? 1 : 0;

                // Determine conclusion based on score
                $conclusion = 'Good'; // Default
                if ($score <= 2) {
                    $conclusion = 'Very Poor';
                } elseif ($score <= 5) {
                    $conclusion = 'Poor';
                } elseif ($score >= 9) {
                    $conclusion = 'Excellent';
                }

                // Create record
                DB::table('she_air_minum')->insert([
                    'doc_number' => $docNumber,
                    'site_name' => $request->site_name,
                    'department' => $request->department,
                    'shift' => $request->shift,
                    'work_location' => $request->work_location,
                    'inspector_count' => $request->inspector_count,
                    'inspection_date' => now()->format('Y-m-d'),
                    'inspector_1_name' => $request->inspector_1_name,
                    'inspector_1_nik' => $request->inspector_1_nik,
                    'inspector_1_date' => $request->inspector_1_date,
                    'inspector_2_name' => $request->inspector_2_name,
                    'inspector_2_nik' => $request->inspector_2_nik,
                    'inspector_2_date' => $request->inspector_2_date,
                    'inspector_3_name' => $request->inspector_3_name,
                    'inspector_3_nik' => $request->inspector_3_nik,
                    'inspector_3_date' => $request->inspector_3_date,
                    'acknowledged_by_name' => $request->acknowledged_by_name,
                    'acknowledged_by_nik' => $request->acknowledged_by_nik,
                    'acknowledged_date' => $request->acknowledged_date,
                    'is_work_area_clean' => $request->is_work_area_clean,
                    'has_scattered_items' => $request->has_scattered_items,
                    'has_trash_bin' => $request->has_trash_bin,
                    'has_scattered_trash' => $request->has_scattered_trash,
                    'has_storage_warehouse' => $request->has_storage_warehouse,
                    'is_water_filter_regularly_changed' => $request->is_water_filter_regularly_changed,
                    'is_water_reservoir_cleaned' => $request->is_water_reservoir_cleaned,
                    'is_distribution_packing_clean' => $request->is_distribution_packing_clean,
                    'is_water_quality_checked_quarterly' => $request->is_water_quality_checked_quarterly,
                    'score' => $score,
                    'conclusion' => $conclusion,
                    'inspector_1_status' => 'pending',
                    'inspector_2_status' => 'pending',
                    'inspector_3_status' => 'pending',
                    'acknowledged_status' => 'pending',
                    'approval_status' => 'pending',
                    'created_at' => now(),
                    'updated_at' => now()
                ]);

                DB::commit();
                Log::info('Air Minum form submitted successfully');
                
                return response()->json([
                    'success' => true,
                    'message' => 'Form inspeksi air minum berhasil disimpan.'
                ]);

            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Error in transaction: ' . $e->getMessage(), [
                    'request' => $request->all(),
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menyimpan form: ' . $e->getMessage()
                ], 500);
            }

        } catch (\Exception $e) {
            Log::error('Error in Store: ' . $e->getMessage(), [
                'request' => $request->all(),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Failed to submit form: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update an existing Air Minum record
     */
    public function Update(Request $request, $id)
    {
        try {
            Log::info('Processing Air Minum form update', [
                'id' => $id,
                'user' => session('username')
            ]);

            $validator = Validator::make($request->all(), [
                'site_name' => 'required|string',
                'department' => 'required|string',
                'shift' => 'required|string',
                'work_location' => 'required|string',
                'inspector_count' => 'required|integer',
                'inspector_1_name' => 'required|string',
                'inspector_1_nik' => 'required|string',
                'inspector_1_date' => 'required|date',
                'inspector_2_name' => 'nullable|string',
                'inspector_2_nik' => 'nullable|string',
                'inspector_2_date' => 'nullable|date',
                'inspector_3_name' => 'nullable|string',
                'inspector_3_nik' => 'nullable|string',
                'inspector_3_date' => 'nullable|date',
                'acknowledged_by_name' => 'required|string',
                'acknowledged_by_nik' => 'required|string',
                'acknowledged_date' => 'required|date',
                'is_work_area_clean' => 'required|boolean',
                'has_scattered_items' => 'required|boolean',
                'has_trash_bin' => 'required|boolean',
                'has_scattered_trash' => 'required|boolean',
                'has_storage_warehouse' => 'required|boolean',
                'is_water_filter_regularly_changed' => 'required|boolean',
                'is_water_reservoir_cleaned' => 'required|boolean',
                'is_distribution_packing_clean' => 'required|boolean',
                'is_water_quality_checked_quarterly' => 'required|boolean',
            ]);

            if ($validator->fails()) {
                Log::warning('Validation failed for update: ' . json_encode($validator->errors()));
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Get the record
            $record = DB::table('she_air_minum')
                ->where('id', $id)
                ->first();

            if (!$record) {
                Log::error('Air Minum record not found for update', [
                    'id' => $id
                ]);
                
                return response()->json([
                    'success' => false,
                    'message' => 'Record not found'
                ], 404);
            }

            // Check if the record has any approved status
            if ($record->inspector_1_status === 'approved' || 
                $record->inspector_2_status === 'approved' || 
                $record->inspector_3_status === 'approved' || 
                $record->acknowledged_status === 'approved') {
                
                Log::error('Cannot update Air Minum record with approved status', [
                    'id' => $id,
                    'inspector_1_status' => $record->inspector_1_status,
                    'inspector_2_status' => $record->inspector_2_status,
                    'inspector_3_status' => $record->inspector_3_status,
                    'acknowledged_status' => $record->acknowledged_status
                ]);
                
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot update record with approved status'
                ], 400);
            }

            DB::beginTransaction();

            try {
                // Calculate score based on checklist items
                $score = 0;
                $score += $request->is_work_area_clean ? 1 : 0;
                $score += !$request->has_scattered_items ? 1 : 0; // Inverse for negative questions
                $score += $request->has_trash_bin ? 1 : 0;
                $score += !$request->has_scattered_trash ? 1 : 0; // Inverse for negative questions
                $score += $request->has_storage_warehouse ? 1 : 0;
                $score += $request->is_water_filter_regularly_changed ? 1 : 0;
                $score += $request->is_water_reservoir_cleaned ? 1 : 0;
                $score += $request->is_distribution_packing_clean ? 1 : 0;
                $score += $request->is_water_quality_checked_quarterly ? 1 : 0;

                // Determine conclusion based on score
                $conclusion = 'Good'; // Default
                if ($score <= 2) {
                    $conclusion = 'Very Poor';
                } elseif ($score <= 5) {
                    $conclusion = 'Poor';
                } elseif ($score >= 9) {
                    $conclusion = 'Excellent';
                }

                // Format dates to ensure they're stored correctly
                $inspection_date = $request->inspection_date;
                $inspector_1_date = $request->inspector_1_date;
                $inspector_2_date = $request->filled('inspector_2_date') ? $request->inspector_2_date : null;
                $inspector_3_date = $request->filled('inspector_3_date') ? $request->inspector_3_date : null;
                $acknowledged_date = $request->acknowledged_date;

                // Update record
                DB::table('she_air_minum')
                    ->where('id', $id)
                    ->update([
                        'site_name' => $request->site_name,
                        'department' => $request->department,
                        'shift' => $request->shift,
                        'work_location' => $request->work_location,
                        'inspector_count' => $request->inspector_count,
                        'inspection_date' => $inspection_date,
                        'inspector_1_name' => $request->inspector_1_name,
                        'inspector_1_nik' => $request->inspector_1_nik,
                        'inspector_1_date' => $inspector_1_date,
                        'inspector_2_name' => $request->inspector_2_name,
                        'inspector_2_nik' => $request->inspector_2_nik,
                        'inspector_2_date' => $inspector_2_date,
                        'inspector_3_name' => $request->inspector_3_name,
                        'inspector_3_nik' => $request->inspector_3_nik,
                        'inspector_3_date' => $inspector_3_date,
                        'acknowledged_by_name' => $request->acknowledged_by_name,
                        'acknowledged_by_nik' => $request->acknowledged_by_nik,
                        'acknowledged_date' => $acknowledged_date,
                        'is_work_area_clean' => $request->is_work_area_clean,
                        'has_scattered_items' => $request->has_scattered_items,
                        'has_trash_bin' => $request->has_trash_bin,
                        'has_scattered_trash' => $request->has_scattered_trash,
                        'has_storage_warehouse' => $request->has_storage_warehouse,
                        'is_water_filter_regularly_changed' => $request->is_water_filter_regularly_changed,
                        'is_water_reservoir_cleaned' => $request->is_water_reservoir_cleaned,
                        'is_distribution_packing_clean' => $request->is_distribution_packing_clean,
                        'is_water_quality_checked_quarterly' => $request->is_water_quality_checked_quarterly,
                        'score' => $score,
                        'conclusion' => $conclusion,
                        'notes' => $request->notes,
                        'updated_at' => now()
                    ]);

                DB::commit();

                Log::info('Air Minum record updated successfully', [
                    'id' => $id
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Record updated successfully'
                ]);

            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Database error during update: ' . $e->getMessage(), [
                    'id' => $id,
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
                
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to update record: ' . $e->getMessage()
                ], 500);
            }

        } catch (\Exception $e) {
            Log::error('Error in Update: ' . $e->getMessage(), [
                'id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to update record: ' . $e->getMessage()
            ], 500);
        }
    }

    public function ExportForm($id)
    {
        try {
            Log::info('Exporting Air Minum record for ID: ' . $id);

            $record = DB::table('she_air_minum')
                ->where('id', $id)
                ->first();

            if (!$record) {
                Log::error('Record not found for export, ID: ' . $id);
                return redirect()->back()->with('error', 'Record not found');
            }

            try {
                // Clean up the date string by removing extra colons and normalizing AM/PM
                $dateStr = preg_replace(['/::/', '/\s+/'], [':', ' '], $record->inspection_date);
                $dateStr = trim($dateStr);
                
                if (strpos($dateStr, 'AM') !== false || strpos($dateStr, 'PM') !== false) {
                    // If it's in AM/PM format
                    $record->inspection_date = Carbon::createFromFormat('M d Y h:i:s A', $dateStr)->format('Y-m-d');
                } else {
                    // If it's in regular date format
                    $record->inspection_date = Carbon::parse($dateStr)->format('Y-m-d');
                }
            } catch (\Exception $e) {
                Log::error('Date parsing error for inspection_date: ' . $e->getMessage() . ' | Original value: ' . $record->inspection_date);
                $record->inspection_date = now()->format('Y-m-d');
            }

            try {
                if ($record->acknowledged_date) {
                    $dateStr = preg_replace(['/::/', '/\s+/'], [':', ' '], $record->acknowledged_date);
                    $dateStr = trim($dateStr);
                    
                    if (strpos($dateStr, 'AM') !== false || strpos($dateStr, 'PM') !== false) {
                        // If it's in AM/PM format
                        $record->acknowledged_date = Carbon::createFromFormat('M d Y h:i:s A', $dateStr)->format('Y-m-d');
                    } else {
                        // If it's in regular date format
                        $record->acknowledged_date = Carbon::parse($dateStr)->format('Y-m-d');
                    }
                }
            } catch (\Exception $e) {
                Log::error('Date parsing error for acknowledged_date: ' . $e->getMessage() . ' | Original value: ' . $record->acknowledged_date);
                $record->acknowledged_date = now()->format('Y-m-d');
            }

            $pdf = PDF::loadView('SmartForm::she/air_minum/export-pdf', [
                'record' => $record
            ]);

            Log::info('Successfully generated PDF for record ID: ' . $id);
            return $pdf->download('air-minum-inspection-' . $record->doc_number . '.pdf');

        } catch (\Exception $e) {
            Log::error('Error in ExportForm: ' . $e->getMessage(), [
                'id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()
                ->with('error', 'Failed to export form: ' . $e->getMessage());
        }
    }

    /**
     * Update the approval status of a record
     */
    public function UpdateApprovalStatus(Request $request, $id, $role)
    {
        try {
            // Get current user ID from session
            $currentUserId = session('user_id') ?? '';
            
            if (empty($currentUserId)) {
                return redirect()->route('she.air-minum.dashboard')
                    ->with('error', 'Please set your ID first');
            }
            
            // Get the record
            $record = DB::table('she_air_minum')->where('id', $id)->first();
            
            if (!$record) {
                return redirect()->route('she.air-minum.dashboard')
                    ->with('error', 'Record not found');
            }
            
            // Check if user is the correct approver
            if ($record->{$role . '_nik'} !== $currentUserId) {
                return redirect()->route('she.air-minum.dashboard')
                    ->with('error', 'You are not authorized to approve this record');
            }
            
            // Check if the approval is in the correct sequence
            $canApprove = false;
            
            switch ($role) {
                case 'inspector_1':
                    $canApprove = true;
                    break;
                case 'inspector_2':
                    $canApprove = $record->inspector_1_status === 'approved';
                    break;
                case 'inspector_3':
                    $canApprove = $record->inspector_1_status === 'approved' && 
                                 $record->inspector_2_status === 'approved';
                    break;
                case 'acknowledged_by':
                    $canApprove = $record->inspector_1_status === 'approved' && 
                                 $record->inspector_2_status === 'approved' && 
                                 $record->inspector_3_status === 'approved';
                    break;
                default:
                    $canApprove = false;
            }
            
            if (!$canApprove) {
                return redirect()->route('she.air-minum.dashboard')
                    ->with('error', 'Previous approvals must be completed first');
            }
            
            // Update the approval status
            $updateData = [
                $role . '_status' => 'approved',
                $role . '_date' => date('Y-m-d'), // Use simple date format
                'updated_at' => now()
            ];
            
            // Update overall approval status
            if ($role === 'acknowledged_by') {
                $updateData['approval_status'] = 'approved';
            } else {
                $updateData['approval_status'] = 'in_progress';
            }
            
            // Check if the same user is assigned to multiple roles and approve them all
            $this->approveAllUserRoles($record, $currentUserId, $role);
            
            DB::table('she_air_minum')
                ->where('id', $id)
                ->update($updateData);
            
            return redirect()->route('she.air-minum.dashboard')
                ->with('success', 'Record approved successfully');
            
        } catch (\Exception $e) {
            Log::error('Error in UpdateApprovalStatus: ' . $e->getMessage());
            return redirect()->route('she.air-minum.dashboard')
                ->with('error', 'Failed to approve record: ' . $e->getMessage());
        }
    }
    
    /**
     * Approve all roles for a user with the same ID
     * 
     * @param object $record The Air Minum record
     * @param string $userId The current user's ID
     * @param string $currentRole The role being approved
     * @return void
     */
    private function approveAllUserRoles($record, $userId, $currentRole)
    {
        $roles = ['inspector_1', 'inspector_2', 'inspector_3', 'acknowledged_by'];
        $updateData = [];
        $now = now();
        $dateNow = $now->format('Y-m-d');
        
        // First, approve the current role directly in the record object
        // This helps with the sequential checks for later roles
        $record->{$currentRole . '_status'} = 'approved';
        
        // If the user is assigned to multiple roles, approve them all in sequence
        foreach ($roles as $role) {
            // Skip roles that don't match the user ID or are already approved
            if ($record->{$role . '_nik'} !== $userId || $record->{$role . '_status'} === 'approved') {
                continue;
            }
            
            // Skip the current role (it's handled in the main UpdateApprovalStatus method)
            if ($role === $currentRole) {
                continue;
            }
            
            // Check if we can approve this role based on the sequence
            $canApprove = false;
            
            switch ($role) {
                case 'inspector_1':
                    $canApprove = true;
                    break;
                    
                case 'inspector_2':
                    // Can approve if inspector_1 is approved
                    $canApprove = $record->inspector_1_status === 'approved';
                    break;
                    
                case 'inspector_3':
                    // Can approve if both inspector_1 and inspector_2 are approved
                    $canApprove = ($record->inspector_1_status === 'approved' && 
                                  $record->inspector_2_status === 'approved');
                    break;
                    
                case 'acknowledged_by':
                    // Can approve if all inspectors are approved
                    $canApprove = ($record->inspector_1_status === 'approved' && 
                                  $record->inspector_2_status === 'approved' && 
                                  $record->inspector_3_status === 'approved');
                    break;
            }
            
            if ($canApprove) {
                $updateData[$role . '_status'] = 'approved';
                $updateData[$role . '_date'] = $dateNow;
                
                // Update the record object for sequential checks
                $record->{$role . '_status'} = 'approved';
                
                // If this is the acknowledged_by role, update the overall status
                if ($role === 'acknowledged_by') {
                    $updateData['approval_status'] = 'approved';
                }
            }
        }
        
        // If we have updates to make, apply them
        if (!empty($updateData)) {
            DB::table('she_air_minum')
                ->where('id', $record->id)
                ->update($updateData);
        }
    }

    /**
     * Delete a record (soft delete)
     */
    public function Delete($id)
    {
        try {
            Log::info('Processing Air Minum delete request', [
                'id' => $id,
                'user' => session('username')
            ]);

            // Get the record
            $record = DB::table('she_air_minum')
                ->where('id', $id)
                ->first();

            if (!$record) {
                Log::error('Air Minum record not found for deletion', [
                    'id' => $id
                ]);
                
                return response()->json([
                    'success' => false,
                    'message' => 'Record not found'
                ]);
            }

            // Check if the record has any approved status
            if ($record->inspector_1_status === 'approved' || 
                $record->inspector_2_status === 'approved' || 
                $record->inspector_3_status === 'approved' || 
                $record->acknowledged_status === 'approved') {
                
                Log::error('Cannot delete Air Minum record with approved status', [
                    'id' => $id,
                    'inspector_1_status' => $record->inspector_1_status,
                    'inspector_2_status' => $record->inspector_2_status,
                    'inspector_3_status' => $record->inspector_3_status,
                    'acknowledged_status' => $record->acknowledged_status
                ]);
                
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot delete record with approved status'
                ]);
            }

            // Soft delete the record
            DB::table('she_air_minum')
                ->where('id', $id)
                ->update(['deleted_at' => now()]);

            Log::info('Air Minum record deleted successfully', [
                'id' => $id
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Record deleted successfully'
            ]);

        } catch (\Exception $e) {
            Log::error('Error in Delete: ' . $e->getMessage(), [
                'id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete record: ' . $e->getMessage()
            ]);
        }
    }

    private function generateDocNumber()
    {
        $prefix = 'BSS-FRM-SHE-049';
        $date = now()->format('dmY');
        $lastRecord = DB::table('she_air_minum')
            ->whereDate('created_at', now())
            ->orderBy('created_at', 'desc')
            ->first();

        $sequence = 1;
        if ($lastRecord && preg_match('/-(\d+)$/', $lastRecord->doc_number, $matches)) {
            $sequence = intval($matches[1]) + 1;
        }

        return sprintf("%s-%s-%03d", $prefix, $date, $sequence);
    }
}