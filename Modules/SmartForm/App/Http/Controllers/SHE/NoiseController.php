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

class NoiseController extends Controller
{
    public function Dashboard(Request $request)
    {
        try {
            $query = DB::table('she_noise_survey')
                ->select([
                    'she_noise_survey.*',
                    DB::raw('CONVERT(varchar, survey_date, 23) as formatted_date')
                ]);

            // Search functionality
            if ($request->has('search')) {
                $searchTerm = $request->search;
                $query->where(function($q) use ($searchTerm) {
                    $q->where('doc_number', 'like', '%' . $searchTerm . '%')
                        ->orWhere('work_location', 'like', '%' . $searchTerm . '%')
                        ->orWhere('inspected_by', 'like', '%' . $searchTerm . '%');
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
                'inspected_by' => 'required|string',
                'acknowledged_by' => 'required|string',
                'inspected_signature' => 'required|boolean',
                'acknowledged_signature' => 'required|boolean',
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
                'inspector_count' => $request->inspector_count,
                'inspection_date' => \Carbon\Carbon::parse($request->inspection_date)->format('Y-m-d'),
                'acknowledgment_date' => \Carbon\Carbon::parse($request->acknowledgment_date)->format('Y-m-d'),
                'inspected_by' => $request->inspected_by,
                'acknowledged_by' => $request->acknowledged_by,
                'inspected_signature' => (bool) $request->input('inspected_signature', false),
                'acknowledged_signature' => (bool) $request->input('acknowledged_signature', false),
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

            // Debug the dates
            \Log::info('Raw dates:', [
                'inspection_date' => $record->inspection_date,
                'acknowledgment_date' => $record->acknowledgment_date,
                'survey_date' => $record->survey_date
            ]);

            // Format dates for display using Carbon
            try {
                $record->formatted_inspection_date = $record->inspection_date ? \Carbon\Carbon::createFromFormat('Y-m-d', $record->inspection_date)->format('d/m/Y') : '';
                $record->formatted_acknowledgment_date = $record->acknowledgment_date ? \Carbon\Carbon::createFromFormat('Y-m-d', $record->acknowledgment_date)->format('d/m/Y') : '';
                $record->formatted_survey_date = $record->survey_date ? \Carbon\Carbon::createFromFormat('Y-m-d', $record->survey_date)->format('d/m/Y') : '';
            } catch (\Exception $e) {
                Log::error('Date formatting error: ' . $e->getMessage());
                // Use fallback date formatting if createFromFormat fails
                $record->formatted_inspection_date = $record->inspection_date ? date('d/m/Y', strtotime($record->inspection_date)) : '';
                $record->formatted_acknowledgment_date = $record->acknowledgment_date ? date('d/m/Y', strtotime($record->acknowledgment_date)) : '';
                $record->formatted_survey_date = $record->survey_date ? date('d/m/Y', strtotime($record->survey_date)) : '';
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