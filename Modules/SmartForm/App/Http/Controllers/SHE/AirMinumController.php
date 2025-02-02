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
                ->pluck('work_location');

            // Filter options object
            $filter_options = (object)[
                'locations' => $locations,
            ];

            // Get records with pagination
            $records = $query->orderBy('created_at', 'desc')
                           ->paginate(10)
                           ->withQueryString();

            // Calculate statistics
            $statistics = (object)[
                'total_records' => DB::table('she_air_minum')->count(),
                'total_this_month' => DB::table('she_air_minum')
                    ->whereMonth('created_at', now()->month)
                    ->whereYear('created_at', now()->year)
                    ->count(),
                'locations_count' => $locations->count(),
                'need_attention' => DB::table('she_air_minum')
                    ->where(function($query) {
                        $query->where('has_scattered_items', true)  // Barang berserakan
                            ->orWhere('has_scattered_trash', true); // Sampah berserakan
                    })
                    ->count()
            ];

            Log::info($records);
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
                    return redirect()->route('she-air-minum.dashboard')
                        ->with('error', 'Record not found');
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

                Log::info('Air Minum record for ID: ' . $record->acknowledged_date);

                return view('SmartForm::she/air_minum/form', [
                    'isShowDetail' => true,
                    'maintenanceRecord' => $record
                ]);
            }

            return view('SmartForm::she/air_minum/form', [
                'isShowDetail' => false,
                'maintenanceRecord' => null
            ]);

        } catch (\Exception $e) {
            Log::error('Error in AddForm: ' . $e->getMessage());
            return redirect()->route('she-air-minum.dashboard')
                ->with('error', 'Failed to load form: ' . $e->getMessage());
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
                'inspector_1' => 'required|string',
                'inspection_date' => 'required|date',
                'acknowledged_by' => 'required|string',
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
                    'inspection_date' => $request->inspection_date,
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
                    'inspector_1' => $request->inspector_1,
                    'inspector_1_signature' => $request->inspector_1_signature,
                    'acknowledged_by' => $request->acknowledged_by,
                    'acknowledged_by_signature' => $request->acknowledged_by_signature,
                    'acknowledged_date' => $request->acknowledged_date,
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
                Log::error('Error in transaction: ' . $e->getMessage());
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menyimpan form: ' . $e->getMessage()
                ], 500);
            }

        } catch (\Exception $e) {
            Log::error('Error in Store: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to submit form: ' . $e->getMessage()
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
            Log::error('Error in ExportForm: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Failed to export form: ' . $e->getMessage());
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