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

class SheMessController extends Controller
{
    public function Dashboard(Request $request)
    {
        try {
            $query = DB::table('she_mess_survey');

            // Apply date filter
            if ($request->filled('start_date')) {
                $query->whereDate('survey_date', '>=', $request->start_date);
            }
            if ($request->filled('end_date')) {
                $query->whereDate('survey_date', '<=', $request->end_date);
            }

            // Apply location filter
            if ($request->filled('work_location')) {
                $query->where('work_location', $request->work_location);
            }

            // Apply search
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('doc_number', 'like', "%{$search}%")
                      ->orWhere('site_name', 'like', "%{$search}%")
                      ->orWhere('work_location', 'like', "%{$search}%");
                });
            }

            // Get records
            $records = $query->orderBy('created_at', 'desc')->get();

            // Format dates using Carbon
            $records->transform(function($record) {
                if ($record->survey_date) {
                    try {
                        // First try parsing the date in the format "Feb 4 2025 12:00:00:AM"
                        $dateStr = preg_replace('/:([AP]M)/', ' $1', $record->survey_date);
                        $date = \Carbon\Carbon::createFromFormat('M d Y h:i:s A', $dateStr);
                    } catch (\Exception $e) {
                        try {
                            // If that fails, try parsing it as a standard date format
                            $date = \Carbon\Carbon::parse($record->survey_date);
                        } catch (\Exception $e2) {
                            Log::error('Date parsing error: ' . $e2->getMessage());
                            $date = now();
                        }
                    }
                    $record->survey_date = $date->format('d/m/Y');
                }
                return $record;
            });

            // Get unique locations for filter
            $locations = DB::table('she_mess_survey')
                          ->select('work_location')
                          ->distinct()
                          ->pluck('work_location');

            // Get filter values for the view
            $filters = $request->all();

            return view('smartform::she.mess.dashboard', compact('records', 'locations', 'filters'));

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error loading dashboard: ' . $e->getMessage());
        }
    }

    public function AddForm(Request $request, $id = null)
    {
        try {
            Log::info('AddForm method called with request:', $request->all());
            Log::info('Route parameters:', $request->route()->parameters());
            
            if ($id) {
                Log::info('ID from route parameter: ' . $id);
                $record = DB::table('she_mess_survey')
                    ->where('id', $id)
                    ->first();

                if (!$record) {
                    Log::error('Record not found for ID: ' . $id);
                    return redirect()->route('she.mess.dashboard')
                        ->with('error', 'Record not found');
                }

                // Parse checklist items - now stored as simple array
                try {
                    $record->checklist_items = json_decode($record->checklist_items, true);
                    Log::info('Checklist items decoded:', ['id' => $id, 'items' => $record->checklist_items]);
                    if (!is_array($record->checklist_items)) {
                        Log::error('Invalid checklist items format: ' . $record->checklist_items);
                        $record->checklist_items = [];
                    }
                } catch (\Exception $e) {
                    Log::error('Error decoding checklist items: ' . $e->getMessage());
                    $record->checklist_items = [];
                }

                // Format survey_date
                try {
                    $dateStr = preg_replace(['/::/', '/\s+/'], [':', ' '], $record->survey_date);
                    $dateStr = trim($dateStr);
                    
                    if (strpos($dateStr, 'AM') !== false || strpos($dateStr, 'PM') !== false) {
                        $record->survey_date = Carbon::createFromFormat('M d Y h:i:s A', $dateStr)->format('Y-m-d');
                    } else {
                        $record->survey_date = Carbon::parse($dateStr)->format('Y-m-d');
                    }
                } catch (\Exception $e) {
                    Log::error('Date parsing error for survey_date: ' . $e->getMessage() . ' | Original value: ' . $record->survey_date);
                    $record->survey_date = now()->format('Y-m-d');
                }

                // Format completion_date
                try {
                    if ($record->completion_date) {
                        $dateStr = preg_replace(['/::/', '/\s+/'], [':', ' '], $record->completion_date);
                        $dateStr = trim($dateStr);
                        
                        if (strpos($dateStr, 'AM') !== false || strpos($dateStr, 'PM') !== false) {
                            $record->completion_date = Carbon::createFromFormat('M d Y h:i:s A', $dateStr)->format('Y-m-d');
                        } else {
                            $record->completion_date = Carbon::parse($dateStr)->format('Y-m-d');
                        }
                    }
                } catch (\Exception $e) {
                    Log::error('Date parsing error for completion_date: ' . $e->getMessage() . ' | Original value: ' . $record->completion_date);
                    $record->completion_date = null;
                }

                // Format inspection dates
                foreach (['inspection_date', 'inspection_date2', 'inspection_date3'] as $dateField) {
                    try {
                        if ($record->$dateField) {
                            $dateStr = preg_replace(['/::/', '/\s+/'], [':', ' '], $record->$dateField);
                            $dateStr = trim($dateStr);
                            
                            if (strpos($dateStr, 'AM') !== false || strpos($dateStr, 'PM') !== false) {
                                $record->$dateField = Carbon::createFromFormat('M d Y h:i:s A', $dateStr)->format('Y-m-d');
                            } else {
                                $record->$dateField = Carbon::parse($dateStr)->format('Y-m-d');
                            }
                        }
                    } catch (\Exception $e) {
                        Log::error("Date parsing error for {$dateField}: " . $e->getMessage() . " | Original value: " . $record->$dateField);
                        $record->$dateField = null;
                    }
                }

                // Format acknowledgment_date
                try {
                    if ($record->acknowledgment_date) {
                        $dateStr = preg_replace(['/::/', '/\s+/'], [':', ' '], $record->acknowledgment_date);
                        $dateStr = trim($dateStr);
                        
                        if (strpos($dateStr, 'AM') !== false || strpos($dateStr, 'PM') !== false) {
                            $record->acknowledgment_date = Carbon::createFromFormat('M d Y h:i:s A', $dateStr)->format('Y-m-d');
                        } else {
                            $record->acknowledgment_date = Carbon::parse($dateStr)->format('Y-m-d');
                        }
                    }
                } catch (\Exception $e) {
                    Log::error('Date parsing error for acknowledgment_date: ' . $e->getMessage() . ' | Original value: ' . $record->acknowledgment_date);
                    $record->acknowledgment_date = now()->format('Y-m-d');
                }

                return view('smartform::she.mess.form', [
                    'data' => $record,
                    'isShowDetail' => true
                ]);
            }

            // Default values for new form
            $defaultChecklistItems = [
                'Kondisi Bangunan',
                'Kondisi Lantai',
                'Kondisi Dinding',
                'Kondisi Atap',
                'Kondisi Plafon',
                'Kondisi Jendela',
                'Kondisi Pintu',
                'Kondisi Toilet',
                'Kondisi Wastafel',
                'Kondisi Tempat Sampah',
                'Kondisi Ventilasi',
                'Kondisi Penerangan',
                'Kondisi AC/Kipas Angin',
                'Kondisi Furniture',
                'Kondisi Dapur',
                'Kondisi Area Makan',
                'Kondisi Area Parkir',
                'Kondisi Area Taman',
                'Kebersihan Umum'
            ];

            return view('smartform::she.mess.form', [
                'data' => (object)[
                    'doc_number' => $this->generateDocNumber(),
                    'site_name' => '',
                    'work_location' => '',
                    'department' => '',
                    'shift' => '',
                    'inspector_count' => '',
                    'survey_date' => now()->format('Y-m-d'),
                    'completion_date' => now()->format('Y-m-d'),
                    'inspection_date' => now()->format('Y-m-d'),
                    'inspection_date2' => now()->format('Y-m-d'),
                    'inspection_date3' => now()->format('Y-m-d'),
                    'acknowledgment_date' => now()->format('Y-m-d'),
                    'checklist_items' => $defaultChecklistItems,
                    'keterangan' => '',
                    'risk_description' => '',
                    'improvement_action' => '',
                    'done_by' => '',
                    'inspected_by' => '',
                    'inspected_by2' => '',
                    'inspected_by3' => '',
                    'inspected_signature' => 0,
                    'inspected_signature2' => 0,
                    'inspected_signature3' => 0,
                    'acknowledged_by' => '',
                    'acknowledged_signature' => 0
                ],
                'isShowDetail' => false
            ]);

        } catch (\Exception $e) {
            Log::error('Error in AddForm: ' . $e->getMessage());
            return redirect()->route('she.mess.dashboard')
                ->with('error', 'Failed to load form: ' . $e->getMessage());
        }
    }

    public function Store(Request $request)
    {
        try {
            Log::info('Store method called with request:', $request->all());
            
            // Format checklist items - store only conditions
            $checklistItems = [];
            if ($request->has('checklist')) {
                foreach ($request->checklist as $index => $condition) {
                    $checklistItems[] = $condition;
                }
            }

            // Handle arrays and nullable fields
            $inspectedBy = $request->input('inspected_by', []);
            $inspectedSignatures = $request->input('inspected_signature', []);
            $doneBy = $request->input('done_by');
            $riskDescription = $request->input('risk_description');
            $improvementAction = $request->input('improvement_action');
            $acknowledgedBy = $request->input('acknowledged_by');

            // Format dates
            $data = [
                'site_name' => $request->site_name,
                'work_location' => $request->work_location,
                'department' => $request->department,
                'shift' => $request->shift,
                'inspector_count' => $request->inspector_count,
                'survey_date' => $request->survey_date,
                'completion_date' => $request->completion_date,
                'inspection_date' => $request->inspection_date,
                'inspection_date2' => $request->inspection_date2,
                'inspection_date3' => $request->inspection_date3,
                'acknowledgment_date' => $request->acknowledgment_date,
                'checklist_items' => json_encode($checklistItems),
                'keterangan' => $request->keterangan,
                'risk_description' => $riskDescription,
                'improvement_action' => $improvementAction,
                'done_by' => $doneBy,
                'inspected_by' => isset($inspectedBy[0]) ? $inspectedBy[0] : null,
                'inspected_by2' => isset($inspectedBy[1]) ? $inspectedBy[1] : null,
                'inspected_by3' => isset($inspectedBy[2]) ? $inspectedBy[2] : null,
                'acknowledged_by' => $acknowledgedBy,
                'inspected_signature' => isset($inspectedSignatures[0]) ? 1 : 0,
                'inspected_signature2' => isset($inspectedSignatures[1]) ? 1 : 0,
                'inspected_signature3' => isset($inspectedSignatures[2]) ? 1 : 0,
                'acknowledged_signature' => $request->has('acknowledged_signature') ? 1 : 0,
                'updated_at' => now()->format('Y-m-d H:i:s')
            ];

            Log::info('Data to be stored:', $data);

            if ($request->has('id')) {
                Log::info('Updating record with ID: ' . $request->id);
                DB::table('she_mess_survey')
                    ->where('id', $request->id)
                    ->update($data);
            } else {
                Log::info('Creating new record');
                $data['created_at'] = now()->format('Y-m-d H:i:s');
                $data['doc_number'] = $this->generateDocNumber();
                DB::table('she_mess_survey')->insert($data);
            }

            return redirect()->route('she.mess.dashboard')
                ->with('success', 'Data saved successfully');
        } catch (\Exception $e) {
            Log::error('Error in Store method: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return redirect()->back()
                ->with('error', 'Failed to save data: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function ExportForm($id)
    {
        try {
            $record = DB::table('she_mess_survey')->where('id', $id)->first();

            if (!$record) {
                Log::error('Record not found for export, ID: ' . $id);
                return redirect()->back()->with('error', 'Record not found');
            }

            // Decode and validate JSON fields
            try {
                $record->checklist_items = is_string($record->checklist_items) ? 
                    json_decode($record->checklist_items, true) : 
                    (is_array($record->checklist_items) ? $record->checklist_items : []);
                
                // Ensure checklist_items is always an array
                if (!is_array($record->checklist_items)) {
                    $record->checklist_items = [];
                    Log::warning('Checklist items converted to empty array for record ID: ' . $id);
                }
            } catch (\Exception $e) {
                Log::error('Error decoding checklist items: ' . $e->getMessage());
                $record->checklist_items = [];
            }

            // Format dates for display with error handling
            try {
                $record->formatted_inspection_date = $record->inspection_date ? 
                    Carbon::parse($record->inspection_date)->format('d/m/Y') : '';
                $record->formatted_acknowledgment_date = $record->acknowledgment_date ? 
                    Carbon::parse($record->acknowledgment_date)->format('d/m/Y') : '';
                $record->formatted_survey_date = $record->survey_date ? 
                    Carbon::parse($record->survey_date)->format('d/m/Y') : '';
            } catch (\Exception $e) {
                Log::error('Error formatting dates: ' . $e->getMessage());
                $record->formatted_inspection_date = '';
                $record->formatted_acknowledgment_date = '';
                $record->formatted_survey_date = '';
            }

            // Ensure all necessary fields are present
            $record->site_name = $record->site_name ?? '';
            $record->work_location = $record->work_location ?? '';
            $record->department = $record->department ?? '';
            $record->shift = $record->shift ?? '';
            $record->doc_number = $record->doc_number ?? '';
            
            $pdf = PDF::loadView('smartform::she.mess.export-pdf', [
                'data' => $record,
            ]);

            Log::info('Successfully generated PDF for record ID: ' . $id);
            return $pdf->download('mess-survey-' . $record->doc_number . '.pdf');

        } catch (\Exception $e) {
            Log::error('Error in ExportForm: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return redirect()->back()
                ->with('error', 'Failed to export form: ' . $e->getMessage());
        }
    }

    private function generateDocNumber()
    {
        $prefix = 'BSS-FRM-SHE-034';
        $date = now()->format('dmY');
        $lastRecord = DB::table('she_mess_survey')
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