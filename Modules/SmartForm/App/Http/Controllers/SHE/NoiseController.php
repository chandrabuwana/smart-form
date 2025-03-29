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

class NoiseController extends Controller
{
    public function Dashboard(Request $request)
    {
        try {
            $query = DB::table('she_noise_survey')
                ->select([
                    'she_noise_survey.id',
                    'she_noise_survey.doc_number',
                    'she_noise_survey.revision',
                    'she_noise_survey.survey_date',
                    'she_noise_survey.department',
                    'she_noise_survey.site_name',
                    'she_noise_survey.inspector_count',
                    'she_noise_survey.inspection_date',
                    'she_noise_survey.acknowledgment_date',
                    'she_noise_survey.inspected_by_name',
                    'she_noise_survey.inspected_by_nik',
                    'she_noise_survey.acknowledged_by_name',
                    'she_noise_survey.acknowledged_by_nik',
                    'she_noise_survey.shift',
                    'she_noise_survey.work_location',
                    'she_noise_survey.risk_level',
                    'she_noise_survey.activities',
                    'she_noise_survey.work_areas',
                    'she_noise_survey.findings_description',
                    'she_noise_survey.approval_status',
                    'she_noise_survey.created_at',
                    'she_noise_survey.updated_at',
                    DB::raw('CONVERT(varchar, survey_date, 23) as formatted_date')
                ]);

            // Search functionality
            if ($request->has('search')) {
                $searchTerm = $request->search;
                $query->where(function($q) use ($searchTerm) {
                    $q->where('doc_number', 'like', '%' . $searchTerm . '%')
                        ->orWhere('work_location', 'like', '%' . $searchTerm . '%')
                        ->orWhere('inspected_by_name', 'like', '%' . $searchTerm . '%')
                        ->orWhere('inspected_by_nik', 'like', '%' . $searchTerm . '%');
                });
            }

            // Date range filter
            if ($request->has('start_date') && $request->start_date) {
                $query->whereDate('survey_date', '>=', $request->start_date);
            }
            if ($request->has('end_date') && $request->end_date) {
                $query->whereDate('survey_date', '<=', $request->end_date);
            }

            // Location filter
            if ($request->has('work_location') && $request->work_location) {
                $query->where('work_location', $request->work_location);
            }

            // Get unique locations for filter
            $locations = DB::table('she_noise_survey')
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
                'total_records' => DB::table('she_noise_survey')->count(),
                'total_this_month' => DB::table('she_noise_survey')
                    ->whereMonth('created_at', now()->month)
                    ->whereYear('created_at', now()->year)
                    ->count(),
                'locations_count' => $locations->count(),
                'high_risk_count' => DB::table('she_noise_survey')
                    ->whereJsonContains('activities', ['status' => 'above_nab'])
                    ->orWhereJsonContains('work_areas', ['status' => 'above_nab'])
                    ->count()
            ];

            return view('SmartForm::she/noise/dashboard', [
                'records' => $records,
                'statistics' => $statistics,
                'filter_options' => $filter_options,
                'filters' => [
                    'search' => $request->search,
                    'start_date' => $request->start_date,
                    'end_date' => $request->end_date,
                    'work_location' => $request->work_location,
                ],
                'user' => (object)[
                    'userid' => session('user_id')
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
                $record = DB::table('she_noise_survey')
                    ->where('id', $request->id)
                    ->first();

                if (!$record) {
                    return redirect()->route('she.noise.dashboard')
                        ->with('error', 'Record not found');
                }

                // Decode JSON fields
                $record->activities = json_decode($record->activities ?? '[]', true);
                $record->work_areas = json_decode($record->work_areas ?? '[]', true);

                // Format dates from SQL Server for form inputs
                $formatSqlServerDate = function($dateString) {
                    if (empty($dateString)) {
                        return null;
                    }
                    
                    // Handle SQL Server date format (e.g., "Mar 9 2025 12:00:00:AM")
                    if (preg_match('/([A-Za-z]+)\s+(\d+)\s+(\d{4})/', $dateString, $matches)) {
                        $month = $matches[1];
                        $day = (int)$matches[2];
                        $year = $matches[3];
                        
                        // Convert month name to month number
                        $months = [
                            'Jan' => '01', 'Feb' => '02', 'Mar' => '03', 'Apr' => '04',
                            'May' => '05', 'Jun' => '06', 'Jul' => '07', 'Aug' => '08',
                            'Sep' => '09', 'Oct' => '10', 'Nov' => '11', 'Dec' => '12'
                        ];
                        
                        if (isset($months[$month])) {
                            // Format as Y-m-d for HTML date inputs
                            return $year . '-' . $months[$month] . '-' . str_pad($day, 2, '0', STR_PAD_LEFT);
                        }
                    }
                    
                    // Try Carbon parsing as fallback
                    try {
                        return \Carbon\Carbon::parse($dateString)->format('Y-m-d');
                    } catch (\Exception $e) {
                        \Log::warning('Failed to parse date in AddForm: ' . $dateString);
                        return null;
                    }
                };

                // Format the dates for HTML date inputs
                $record->inspection_date = $formatSqlServerDate($record->inspection_date);
                $record->acknowledgment_date = $formatSqlServerDate($record->acknowledgment_date);
                $record->survey_date = $formatSqlServerDate($record->survey_date);

                // Log the formatted dates
                \Log::info('Formatted dates for form:', [
                    'inspection_date' => $record->inspection_date,
                    'acknowledgment_date' => $record->acknowledgment_date,
                    'survey_date' => $record->survey_date
                ]);

                // Add default values for fields that might be missing
                $defaultValues = [
                    'site_name' => 'BSS',
                    'department' => 'SHE',
                    'shift' => 'DS',
                    'page' => 1,
                    'total_pages' => 1,
                    'inspector_signature' => '',
                    'acknowledger_signature' => '',
                    'risk_level' => $record->risk_level ?? 'N/A',
                    'findings_description' => $record->findings_description ?? ''
                ];

                foreach ($defaultValues as $key => $value) {
                    if (!isset($record->$key)) {
                        $record->$key = $value;
                    }
                }

                // Convert activities to associative array if needed
                if (!empty($record->activities) && is_array($record->activities)) {
                    $formattedActivities = [];
                    foreach ($record->activities as $activity) {
                        if (is_array($activity)) {
                            $formattedActivities[$activity['name']] = [
                                'actual' => $activity['actual'] ?? '',
                                'description' => $activity['description'] ?? '',
                                'status' => $activity['status'] ?? ''
                            ];
                        }
                    }
                    $record->activities = $formattedActivities;
                }

                return view('smartform::she.noise.form', [
                    'maintenanceRecord' => $record,
                    'approvalList' => HrdHelper::getApprovalList(),
                    'isShowDetail' => true
                ]);
            }

            // Default values for new form
            $activities = [
                'Pekerjaan Pengelasan',
                'Pekerjaan Melakukan Gerinda',
                'Pekerjan Hammering',
                'Pekerjaan Drilling',
                'Pekerjaan Infrasturktur',
                'Etc.'
            ];

            $workAreas = [
                'Area Lubricant',
                'Area Wokrshop Tyre',
                'Area Genset',
                'Area Tower Lamp / Mega Tower',
                'Area Fabrikasi',
                'Area Kompresor',
                'HD-785',
                'HD-465',
                'DT MERCY / HINO / BEIBEN / DONGFENG',
                'A2B (EXCA, DOZER, GRADER, COMPACT, DLL)',
                'Etc'
            ];

            return view('smartform::she.noise.form', [
                'activities' => $activities,
                'workAreas' => $workAreas,
                'approvalList' => HrdHelper::getApprovalList(),
                'isShowDetail' => false,
                'defaultValues' => [
                    'site_name' => 'BSS',
                    'department' => 'SHE',
                    'shift' => 'DS',
                    'work_location' => 'WORKSHOP',
                    'page' => 1,
                    'total_pages' => 1,
                    'inspector_count' => 1
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Error in AddForm: ' . $e->getMessage());
            return redirect()->route('she.noise.dashboard')
                ->with('error', 'Failed to load form: ' . $e->getMessage());
        }
    }

    public function Store(Request $request)
    {
        try {
            // Validate the request
            $validator = Validator::make($request->all(), [
                'site_name' => 'required|string',
                'department' => 'required|string',
                'shift' => 'required|string',
                'doc_number' => 'nullable|string',
                'revision' => 'nullable|string',
                'survey_date' => 'nullable|date',
                'inspector_count' => 'required|integer',
                'inspection_date' => 'required|date',
                'acknowledgment_date' => 'required|date',
                'inspected_by_name' => 'required|string',
                'inspected_by_nik' => 'required|string',
                'acknowledged_by_name' => 'required|string',
                'acknowledged_by_nik' => 'required|string',
                'work_location' => 'required|string',
                'risk_level' => 'nullable|string',
                'activities' => 'required|array',
                'activities.*.name' => 'required|string',
                'activities.*.actual' => 'nullable|numeric',
                'activities.*.status' => 'nullable|in:below_nab,above_nab',
                'work_areas' => 'nullable|array',
                'work_areas.*.name' => 'required|string',
                'work_areas.*.actual' => 'nullable|numeric',
                'work_areas.*.status' => 'nullable|in:below_nab,above_nab',
                'findings_description' => 'nullable|string'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => $validator->errors()->first()
                ], 422);
            }

            // Generate document number
            $docNumber = $this->generateDocNumber();

            // Format activities data
            $activities = collect($request->activities)->map(function ($activity) {
                return [
                    'name' => $activity['name'],
                    'actual' => $activity['actual'] === null || $activity['actual'] === '' ? 0 : floatval($activity['actual']),
                    'status' => $activity['status'] ??  ''
                ];
            })->all();

            // Format work_areas data
            $workAreas = collect($request->work_areas)->map(function ($area) {
                return [
                    'name' => $area['name'],
                    'actual' => $area['actual'] === null || $area['actual'] === '' ? 0 : floatval($area['actual']),
                    'status' => $area['status'] ?? ''
                ];
            })->all();

            // Insert the record
            DB::table('she_noise_survey')->insert([
                'doc_number' => $docNumber,
                'revision' => '00',
                'survey_date' => now()->format('Y-m-d'),
                'site_name' => $request->site_name,
                'department' => $request->department,
                'shift' => $request->shift,
                'inspector_count' => $request->inspector_count,
                'inspection_date' => \Carbon\Carbon::parse($request->inspection_date)->format('Y-m-d'),
                'acknowledgment_date' => \Carbon\Carbon::parse($request->acknowledgment_date)->format('Y-m-d'),
                'inspected_by_name' => $request->inspected_by_name,
                'inspected_by_nik' => $request->inspected_by_nik,
                'acknowledged_by_name' => $request->acknowledged_by_name,
                'acknowledged_by_nik' => $request->acknowledged_by_nik,
                'work_location' => $request->work_location,
                'risk_level' => $request->risk_level,
                'findings_description' => $request->findings_description,
                'activities' => json_encode($activities),
                'work_areas' => json_encode($workAreas),
                'created_at' => now(),
                'updated_at' => now()
            ]);

            return response()->json([
                'message' => 'Noise survey record created successfully'
            ]);

        } catch (\Exception $e) {
            Log::error('Error in Store: ' . $e->getMessage());
            return response()->json([
                'message' => 'Failed to save record: ' . $e->getMessage()
            ], 500);
        }
    }

    public function Update(Request $request, $id)
    {
        try {
            // Validate the request
            $validator = Validator::make($request->all(), [
                'site_name' => 'required|string',
                'department' => 'required|string',
                'shift' => 'required|string',
                'doc_number' => 'nullable|string',
                'revision' => 'nullable|string',
                'survey_date' => 'nullable|date',
                'inspector_count' => 'required|integer',
                'inspection_date' => 'required|date',
                'acknowledgment_date' => 'required|date',
                'inspected_by_name' => 'required|string',
                'inspected_by_nik' => 'required|string',
                'acknowledged_by_name' => 'required|string',
                'acknowledged_by_nik' => 'required|string',
                'work_location' => 'required|string',
                'risk_level' => 'nullable|string',
                'activities' => 'required|array',
                'activities.*.name' => 'required|string',
                'activities.*.actual' => 'nullable|numeric',
                'activities.*.status' => 'nullable|in:below_nab,above_nab',
                'work_areas' => 'nullable|array',
                'work_areas.*.name' => 'required|string',
                'work_areas.*.actual' => 'nullable|numeric',
                'work_areas.*.status' => 'nullable|in:below_nab,above_nab',
                'findings_description' => 'nullable|string'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => $validator->errors()->first()
                ], 422);
            }

            // Get existing record to merge with new data
            $existingRecord = DB::table('she_noise_survey')->where('id', $id)->first();

            // Format activities data
            $activities = [];
            foreach ($request->activities as $activity) {
                if (!empty($activity['name'])) {
                    $activities[] = [
                        'name' => $activity['name'],
                        'actual' => $activity['actual'] === null || $activity['actual'] === '' ? 0 : floatval($activity['actual']),
                        'status' => $activity['status'] ?? ''
                    ];
                }
            }

            // Format work_areas data
            $workAreas = [];
            foreach ($request->work_areas as $area) {
                if (!empty($area['name'])) {
                    $workAreas[] = [
                        'name' => $area['name'],
                        'actual' => $area['actual'] === null || $area['actual'] === '' ? 0 : floatval($area['actual']),
                        'status' => $area['status'] ?? ''
                    ];
                }
            }

            // Update record
            DB::table('she_noise_survey')
                ->where('id', $id)
                ->update([
                    'site_name' => $request->site_name,
                    'department' => $request->department,
                    'shift' => $request->shift,
                    'revision' => $request->revision,
                    'survey_date' => $request->survey_date,
                    'inspector_count' => $request->inspector_count,
                    'inspection_date' => $request->inspection_date,
                    'acknowledgment_date' => $request->acknowledgment_date,
                    'inspected_by_name' => $request->inspected_by_name,
                    'inspected_by_nik' => $request->inspected_by_nik,
                    'acknowledged_by_name' => $request->acknowledged_by_name,
                    'acknowledged_by_nik' => $request->acknowledged_by_nik,
                    'work_location' => $request->work_location,
                    'risk_level' => $request->risk_level,
                    'activities' => json_encode($activities),
                    'work_areas' => json_encode($workAreas),
                    'findings_description' => $request->findings_description,
                    'updated_at' => now()
                ]);

            return response()->json([
                'success' => true,
                'message' => 'Noise survey record updated successfully'
            ]);

        } catch (\Exception $e) {
            Log::error('Error in Update: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to update record: ' . $e->getMessage()
            ], 500);
        }
    }

    public function EditForm($id)
    {
        try {
            // Get the record
            $record = DB::table('she_noise_survey')->where('id', $id)->first();
            
            if (!$record) {
                return redirect()->route('she.noise.dashboard')
                    ->with('error', 'Record not found');
            }
            
            // Decode JSON fields
            $record->activities = json_decode($record->activities, true);
            $record->work_areas = json_decode($record->work_areas, true);
            
            // Format dates for HTML date inputs
            try {
                // Handle SQL Server date format (e.g., "Mar 28 2025 12:00:00:AM")
                $formatDate = function($dateString) {
                    if (empty($dateString)) {
                        return null;
                    }
                    
                    // Remove the colon before AM/PM if present
                    $dateString = str_replace(':AM', ' AM', $dateString);
                    $dateString = str_replace(':PM', ' PM', $dateString);
                    
                    try {
                        return \Carbon\Carbon::parse($dateString)->format('Y-m-d');
                    } catch (\Exception $e) {
                        // If direct parsing fails, try manual parsing
                        if (preg_match('/([A-Za-z]+)\s+(\d+)\s+(\d{4})/', $dateString, $matches)) {
                            $month = $matches[1];
                            $day = (int)$matches[2];
                            $year = $matches[3];
                            
                            // Convert month name to month number
                            $months = [
                                'Jan' => '01', 'Feb' => '02', 'Mar' => '03', 'Apr' => '04',
                                'May' => '05', 'Jun' => '06', 'Jul' => '07', 'Aug' => '08',
                                'Sep' => '09', 'Oct' => '10', 'Nov' => '11', 'Dec' => '12'
                            ];
                            
                            if (isset($months[$month])) {
                                // Format as Y-m-d for HTML date inputs
                                return $year . '-' . $months[$month] . '-' . str_pad($day, 2, '0', STR_PAD_LEFT);
                            }
                        }
                        
                        // If all parsing fails, log the error and return today's date
                        \Log::error('Failed to parse date in EditForm: ' . $dateString . ' - ' . $e->getMessage());
                        return now()->format('Y-m-d');
                    }
                };
                
                $record->inspection_date = $formatDate($record->inspection_date);
                $record->acknowledgment_date = $formatDate($record->acknowledgment_date);
                $record->survey_date = $formatDate($record->survey_date);
                
                // Log the formatted dates
                \Log::info('Formatted dates for edit form:', [
                    'inspection_date' => $record->inspection_date,
                    'acknowledgment_date' => $record->acknowledgment_date,
                    'survey_date' => $record->survey_date
                ]);
                
            } catch (\Exception $e) {
                \Log::error('Error formatting dates in EditForm: ' . $e->getMessage());
            }
            
            return view('smartform::she.noise.edit-form', [
                'record' => $record,
                'approvalList' => HrdHelper::getApprovalList()
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Error in EditForm: ' . $e->getMessage());
            return redirect()->route('she.noise.dashboard')
                ->with('error', 'Failed to load edit form: ' . $e->getMessage());
        }
    }

    public function ExportForm($id)
    {
        try {
            $record = DB::table('she_noise_survey')->where('id', $id)->first();

            if (!$record) {
                Log::error('Record not found for export, ID: ' . $id);
                return redirect()->back()->with('error', 'Record not found');
            }

            // Decode JSON fields if they are strings
            $record->activities = is_string($record->activities) ? json_decode($record->activities, true) : $record->activities;
            $record->work_areas = is_string($record->work_areas) ? json_decode($record->work_areas, true) : $record->work_areas;

            // Format dates from SQL Server for display
            try {
                // Log raw dates for debugging
                \Log::info('Raw dates from SQL Server:', [
                    'inspection_date' => $record->inspection_date,
                    'acknowledgment_date' => $record->acknowledgment_date,
                    'survey_date' => $record->survey_date
                ]);

                // Helper function to format SQL Server dates
                $formatSqlServerDate = function($dateString) {
                    if (empty($dateString)) {
                        return '';
                    }
                    
                    // Handle SQL Server date format (e.g., "Mar 9 2025 12:00:00:AM")
                    if (preg_match('/([A-Za-z]+)\s+(\d+)\s+(\d{4})/', $dateString, $matches)) {
                        $month = $matches[1];
                        $day = (int)$matches[2];
                        $year = $matches[3];
                        
                        // Convert month name to month number
                        $months = [
                            'Jan' => '01', 'Feb' => '02', 'Mar' => '03', 'Apr' => '04',
                            'May' => '05', 'Jun' => '06', 'Jul' => '07', 'Aug' => '08',
                            'Sep' => '09', 'Oct' => '10', 'Nov' => '11', 'Dec' => '12'
                        ];
                        
                        if (isset($months[$month])) {
                            // Format as Y-m-d for database operations
                            $formattedDate = $year . '-' . $months[$month] . '-' . str_pad($day, 2, '0', STR_PAD_LEFT);
                            
                            // Format as d/m/Y for display
                            $displayDate = str_pad($day, 2, '0', STR_PAD_LEFT) . '/' . $months[$month] . '/' . $year;
                            
                            return [
                                'database' => $formattedDate,
                                'display' => $displayDate
                            ];
                        }
                    }
                    
                    // Fallback for other date formats
                    try {
                        $carbon = \Carbon\Carbon::parse($dateString);
                        return [
                            'database' => $carbon->format('Y-m-d'),
                            'display' => $carbon->format('d/m/Y')
                        ];
                    } catch (\Exception $e) {
                        \Log::warning('Failed to parse date: ' . $dateString . ' - ' . $e->getMessage());
                        return [
                            'database' => $dateString,
                            'display' => $dateString
                        ];
                    }
                };
                
                // Process each date field
                $inspectionDate = $formatSqlServerDate($record->inspection_date);
                $acknowledgmentDate = $formatSqlServerDate($record->acknowledgment_date);
                $surveyDate = $formatSqlServerDate($record->survey_date);
                
                // Store both formats
                $record->inspection_date = $inspectionDate['database'];
                $record->formatted_inspection_date = $inspectionDate['display'];
                
                $record->acknowledgment_date = $acknowledgmentDate['database'];
                $record->formatted_acknowledgment_date = $acknowledgmentDate['display'];
                
                $record->survey_date = $surveyDate['database'];
                $record->formatted_survey_date = $surveyDate['display'];
                
                \Log::info('Formatted dates:', [
                    'inspection_date' => $record->inspection_date,
                    'acknowledgment_date' => $record->acknowledgment_date,
                    'survey_date' => $record->survey_date
                ]);
                
            } catch (\Exception $e) {
                \Log::error('Date formatting error: ' . $e->getMessage());
                
                // Keep original values if formatting fails
                $record->formatted_inspection_date = $record->inspection_date;
                $record->formatted_acknowledgment_date = $record->acknowledgment_date;
                $record->formatted_survey_date = $record->survey_date;
            }

            $pdf = PDF::loadView('SmartForm::she/noise/export-pdf', [
                'record' => $record
            ]);

            Log::info('Successfully generated PDF for record ID: ' . $id);
            return $pdf->download('noise-survey-' . $record->doc_number . '.pdf');

        } catch (\Exception $e) {
            Log::error('Error in ExportForm: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Failed to export form: ' . $e->getMessage());
        }
    }

    /**
     * Display the noise survey details
     * 
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function ViewForm($id)
    {
        try {
            $record = DB::table('she_noise_survey')->where('id', $id)->first();
            
            if (!$record) {
                Log::error('Record not found for viewing, ID: ' . $id);
                return redirect()->route('she.noise.dashboard')
                    ->with('error', 'Record not found');
            }
            
            // Decode JSON fields if they are strings
            $record->activities = is_string($record->activities) ? json_decode($record->activities, true) : $record->activities;
            $record->work_areas = is_string($record->work_areas) ? json_decode($record->work_areas, true) : $record->work_areas;
            
            // Format dates from SQL Server for display
            try {
                $formatDate = function($dateString) {
                    if (empty($dateString)) {
                        return '';
                    }
                    
                    // Handle SQL Server date format (e.g., "Mar 9 2025 12:00:00:AM")
                    if (preg_match('/([A-Za-z]+)\s+(\d+)\s+(\d{4})/', $dateString, $matches)) {
                        $month = $matches[1];
                        $day = (int)$matches[2];
                        $year = $matches[3];
                        
                        // Convert month name to month number
                        $months = [
                            'Jan' => '01', 'Feb' => '02', 'Mar' => '03', 'Apr' => '04',
                            'May' => '05', 'Jun' => '06', 'Jul' => '07', 'Aug' => '08',
                            'Sep' => '09', 'Oct' => '10', 'Nov' => '11', 'Dec' => '12'
                        ];
                        
                        if (isset($months[$month])) {
                            return $year . '-' . $months[$month] . '-' . str_pad($day, 2, '0', STR_PAD_LEFT);
                        }
                    }
                    
                    return $dateString;
                };
                
                $record->inspection_date = $formatDate($record->inspection_date);
                $record->acknowledgment_date = $formatDate($record->acknowledgment_date);
                if ($record->survey_date) {
                    $record->survey_date = $formatDate($record->survey_date);
                }
            } catch (\Exception $e) {
                \Log::error('Error in ViewForm: ' . $e->getMessage());
                // If date parsing fails, use today's date as fallback
                $record->inspection_date = now()->format('Y-m-d');
                $record->acknowledgment_date = now()->format('Y-m-d');
                if ($record->survey_date) {
                    $record->survey_date = now()->format('Y-m-d');
                }
            }
            
            // Default activity and work area options for the form
            $activities = [
                'Pekerjaan Pengelasan',
                'Pekerjaan Melakukan Gerinda',
                'Pekerjan Hammering',
                'Pekerjaan Drilling',
                'Pekerjaan Infrasturktur',
                'Etc.'
            ];

            $workAreas = [
                'Area Lubricant',
                'Area Wokrshop Tyre',
                'Area Genset',
                'Area Tower Lamp / Mega Tower',
                'Area Fabrikasi',
                'Area Kompresor',
                'HD-785',
                'HD-465',
                'DT MERCY / HINO / BEIBEN / DONGFENG',
                'A2B (EXCA, DOZER, GRADER, COMPACT, DLL)',
                'Etc'
            ];
            
            return view('smartform::she.noise.form', [
                'record' => $record,
                'activities' => $activities,
                'workAreas' => $workAreas,
                'approvalList' => HrdHelper::getApprovalList(),
                'isShowDetail' => true, // Set to true to indicate this is a view-only page
                'maintenanceRecord' => $record,
                'defaultValues' => [
                    'site_name' => $record->site_name,
                    'department' => $record->department,
                    'work_location' => $record->work_location,
                    'inspector_count' => $record->inspector_count
                ]
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error in ViewForm: ' . $e->getMessage());
            return redirect()->route('she.noise.dashboard')
                ->with('error', 'Failed to load detail view: ' . $e->getMessage());
        }
    }

    /**
     * Delete a noise survey record
     * 
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function Delete($id)
    {
        try {
            // Check if record exists
            $record = DB::table('she_noise_survey')->where('id', $id)->first();
            
            if (!$record) {
                return response()->json([
                    'success' => false,
                    'message' => 'Record not found'
                ], 404);
            }
            
            // Hard delete the record
            DB::table('she_noise_survey')
                ->where('id', $id)
                ->delete();
                
            return response()->json([
                'success' => true,
                'message' => 'Record deleted successfully'
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error in Delete: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete record: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the approval status of a noise survey record
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function UpdateStatus(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id' => 'required|integer',
                'status' => 'required|in:approved,reject'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation error: ' . $validator->errors()->first()
                ], 422);
            }

            // Check if record exists
            $record = DB::table('she_noise_survey')->where('id', $request->id)->first();
            
            if (!$record) {
                return response()->json([
                    'success' => false,
                    'message' => 'Record not found'
                ], 404);
            }
            
            // Update approval status
            DB::table('she_noise_survey')
                ->where('id', $request->id)
                ->update([
                    'approval_status' => $request->status,
                    'updated_at' => now()
                ]);
                
            return response()->json([
                'success' => true,
                'message' => 'Status updated successfully to ' . ucfirst($request->status)
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error in UpdateStatus: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to update status: ' . $e->getMessage()
            ], 500);
        }
    }

    private function generateDocNumber()
    {
        $prefix = 'BSS-FRM-SHE-015';
        $date = now()->format('dmY');
        $lastRecord = DB::table('she_noise_survey')
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