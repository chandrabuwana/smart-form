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

            // Format dates using the helper method
            $records->transform(function($record) {
                // Format survey_date using the helper method
                $this->formatDateField($record, 'survey_date');
                
                // Format other date fields if they exist
                if (isset($record->completion_date)) {
                    $this->formatDateField($record, 'completion_date');
                }
                if (isset($record->inspection_date)) {
                    $this->formatDateField($record, 'inspection_date');
                }
                if (isset($record->inspection_date2)) {
                    $this->formatDateField($record, 'inspection_date2');
                }
                if (isset($record->inspection_date3)) {
                    $this->formatDateField($record, 'inspection_date3');
                }
                if (isset($record->acknowledgment_date)) {
                    $this->formatDateField($record, 'acknowledgment_date');
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
            if ($id) {
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

                // Format all date fields using the helper method
                $this->formatDateField($record, 'survey_date');
                $this->formatDateField($record, 'completion_date');
                $this->formatDateField($record, 'inspection_date');
                $this->formatDateField($record, 'inspection_date2');
                $this->formatDateField($record, 'inspection_date3');
                $this->formatDateField($record, 'acknowledgment_date');

                $selectedNames = collect([
                    $record->inspected_by_name ,
                    $record->inspected_by2_name,
                    $record->inspected_by3_name,
                    $record->acknowledged_by_name,
                ])->filter();

                $approvalList = HrdHelper::getApprovalList();
                foreach ($selectedNames as $name) {
                    if (!$approvalList->pluck('nama')->contains($name)) {
                        $user = HrdHelper::getApprovalList(null, $name)->first(); // Cari user berdasarkan nama
                        if ($user) {
                            $approvalList->push($user);
                        }
                    }
                }

                return view('smartform::she.mess.form', [
                    'data' => $record,
                    'isShowDetail' => true,
                    'approvalList' => $approvalList,
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
                    'work_location' => 'Office', // Default value for work_location
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
                    'acknowledged_signature' => 0,
                    'inspected_by_status' => 'pending',
                    'inspected_by2_status' => 'pending',
                    'inspected_by3_status' => 'pending',
                    'acknowledged_by_status' => 'pending',
                    'approval_status' => 'pending',
                    'inspected_by_nik' => session('user_id') ?? '',
                    'inspected_by2_nik' => '',
                    'inspected_by3_nik' => '',
                    'acknowledged_by_nik' => '',
                    'inspected_by_name' => session('username') ?? '',
                    'inspected_by2_name' => '',
                    'inspected_by3_name' => '',
                    'acknowledged_by_name' => ''
                ],
                'isShowDetail' => false,
                'approvalList' => HrdHelper::getApprovalList(),
            ]);

        } catch (\Exception $e) {
            Log::error('Error in AddForm: ' . $e->getMessage());
            return redirect()->route('she.mess.dashboard')
                ->with('error', 'Failed to load form: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing a mess survey record
     * 
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function EditForm($id)
    {
        try {
            // Retrieve the record from the database
            $record = DB::table('she_mess_survey')->where('id', $id)->first();
            
            if (!$record) {
                Log::error('Record not found for editing, ID: ' . $id);
                return redirect()->route('she.mess.dashboard')
                    ->with('error', 'Record not found');
            }
            
            // Decode checklist items
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
            
            // Format dates for the form using the helper method
            $this->formatDateField($record, 'survey_date');
            $this->formatDateField($record, 'completion_date');
            $this->formatDateField($record, 'inspection_date');
            $this->formatDateField($record, 'inspection_date2');
            $this->formatDateField($record, 'inspection_date3');
            $this->formatDateField($record, 'acknowledgment_date');

            $selectedNames = collect([
                $record->inspected_by_name ,
                $record->inspected_by2_name,
                $record->inspected_by3_name,
                $record->acknowledged_by_name,
            ])->filter();

            $approvalList = HrdHelper::getApprovalList();
            foreach ($selectedNames as $name) {
                if (!$approvalList->pluck('nama')->contains($name)) {
                    $user = HrdHelper::getApprovalList($name, null)->first(); // Cari user berdasarkan nama
                    if ($user) {
                        $approvalList->push($user);
                    }
                }
            }
            
            // Return the edit form view with the record data
            return view('smartform::she.mess.edit', [
                'data' => $record,
                'approvalList' => $approvalList,
                'isShowDetail' => true,
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error in EditForm: ' . $e->getMessage());
            return redirect()->route('she.mess.dashboard')
                ->with('error', 'Failed to load edit form: ' . $e->getMessage());
        }
    }

    public function Store(Request $request)
    {
        try {
            Log::info('Store method called with request:', $request->all());
            
            // Validate required fields
            $request->validate([
                'site_name' => 'required',
                'work_location' => 'required',
                'department' => 'required',
                'shift' => 'required',
            ]);
            
            // Format checklist items - store only conditions
            $checklistItems = [];
            if ($request->has('checklist')) {
                foreach ($request->checklist as $index => $condition) {
                    $checklistItems[] = $condition;
                }
            }

            // Handle arrays and nullable fields
            $doneBy = $request->input('done_by');
            $riskDescription = $request->input('risk_description');
            $improvementAction = $request->input('improvement_action');

            // Format dates
            $data = [
                'site_name' => $request->site_name,
                'work_location' => $request->work_location,
                'department' => $request->department,
                'shift' => $request->shift,
                'inspector_count' => $request->inspector_count,
                'survey_date' => $request->survey_date,
                'completion_date' => $request->completion_date,
                'checklist_items' => json_encode($checklistItems),
                'keterangan' => $request->keterangan,
                'risk_description' => $riskDescription,
                'improvement_action' => $improvementAction,
                'done_by' => $doneBy,
                
                // Updated fields for inspector 1
                'inspected_by_name' => $request->input('inspected_by_name'),
                'inspected_by_nik' => $request->input('inspected_by_nik'),
                'inspection_date' => $request->inspection_date,
                'inspected_by_status' => $request->input('inspected_by_status', 'pending'),
                
                // Updated fields for inspector 2
                'inspected_by2_name' => $request->input('inspected_by2_name'),
                'inspected_by2_nik' => $request->input('inspected_by2_nik'),
                'inspection_date2' => $request->inspection_date2,
                'inspected_by2_status' => $request->input('inspected_by2_status', 'pending'),
                
                // Updated fields for inspector 3
                'inspected_by3_name' => $request->input('inspected_by3_name'),
                'inspected_by3_nik' => $request->input('inspected_by3_nik'),
                'inspection_date3' => $request->inspection_date3,
                'inspected_by3_status' => $request->input('inspected_by3_status', 'pending'),
                
                // Updated fields for acknowledger
                'acknowledged_by_name' => $request->input('acknowledged_by_name'),
                'acknowledged_by_nik' => $request->input('acknowledged_by_nik'),
                'acknowledgment_date' => $request->acknowledgment_date,
                'acknowledged_by_status' => $request->input('acknowledged_by_status', 'pending'),
                
                // Overall approval status
                'approval_status' => $request->input('approval_status', 'pending'),
                
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

            // Directly query the database again to get the raw date values
            $rawDates = DB::select("SELECT 
                CONVERT(VARCHAR, inspection_date, 120) as raw_inspection_date,
                CONVERT(VARCHAR, acknowledgment_date, 120) as raw_acknowledgment_date,
                CONVERT(VARCHAR, survey_date, 120) as raw_survey_date,
                CONVERT(VARCHAR, inspection_date2, 120) as raw_inspection_date2,
                CONVERT(VARCHAR, inspection_date3, 120) as raw_inspection_date3
                FROM she_mess_survey WHERE id = ?", [$id]);
            
            if (count($rawDates) > 0) {
                $rawDate = $rawDates[0];
                Log::info('Raw dates from direct SQL query:', [
                    'raw_inspection_date' => $rawDate->raw_inspection_date,
                    'raw_acknowledgment_date' => $rawDate->raw_acknowledgment_date,
                    'raw_survey_date' => $rawDate->raw_survey_date
                ]);
                
                // Format dates using the raw values from SQL
                $record->formatted_inspection_date = !empty($rawDate->raw_inspection_date) ? 
                    date('d/m/Y', strtotime($rawDate->raw_inspection_date)) : '-';
                $record->formatted_acknowledgment_date = !empty($rawDate->raw_acknowledgment_date) ? 
                    date('d/m/Y', strtotime($rawDate->raw_acknowledgment_date)) : '-';
                $record->formatted_survey_date = !empty($rawDate->raw_survey_date) ? 
                    date('d/m/Y', strtotime($rawDate->raw_survey_date)) : '-';
                $record->formatted_inspection_date2 = !empty($rawDate->raw_inspection_date2) ? 
                    date('d/m/Y', strtotime($rawDate->raw_inspection_date2)) : '-';
                $record->formatted_inspection_date3 = !empty($rawDate->raw_inspection_date3) ? 
                    date('d/m/Y', strtotime($rawDate->raw_inspection_date3)) : '-';
            } else {
                // Fallback to direct formatting if SQL query fails
                $record->formatted_inspection_date = $record->inspection_date ? 
                    date('d/m/Y', strtotime($record->inspection_date)) : '-';
                $record->formatted_acknowledgment_date = $record->acknowledgment_date ? 
                    date('d/m/Y', strtotime($record->acknowledgment_date)) : '-';
                $record->formatted_survey_date = $record->survey_date ? 
                    date('d/m/Y', strtotime($record->survey_date)) : '-';
                $record->formatted_inspection_date2 = $record->inspection_date2 ? 
                    date('d/m/Y', strtotime($record->inspection_date2)) : '-';
                $record->formatted_inspection_date3 = $record->inspection_date3 ? 
                    date('d/m/Y', strtotime($record->inspection_date3)) : '-';
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

    /**
     * Approve a mess survey record
     * 
     * @param int $id
     * @param string $role
     * @return \Illuminate\Http\Response
     */
    public function Approve($id, $role)
    {
        try {
            // Get current user ID and username from session
            $currentUserId = session('user_id') ?? '';
            $currentUsername = session('username') ?? '';
            
            if (empty($currentUserId) || empty($currentUsername)) {
                return redirect()->route('she.mess.dashboard')
                    ->with('error', 'Please login first');
            }
            
            // Get the record
            $record = DB::table('she_mess_survey')->where('id', $id)->first();
            
            if (!$record) {
                return redirect()->route('she.mess.dashboard')
                    ->with('error', 'Record not found');
            }
            
            // Create user object with session data
            $user = (object)[
                'nik' => $currentUserId,
                'nama' => $currentUsername
            ];
            
            // Check which role is approving and update accordingly
            $updateData = [];
            $now = now()->format('Y-m-d');
            
            switch ($role) {
                case 'inspector1':
                    $updateData = [
                        'inspected_by_name' => $user->nama,
                        'inspected_by_nik' => $user->nik,
                        'inspection_date' => $now,
                        'inspected_by_status' => 'approved'
                    ];
                    break;
                    
                case 'inspector2':
                    // Check if inspector1 has approved
                    if ($record->inspected_by_status !== 'approved') {
                        return redirect()->route('she.mess.dashboard')
                            ->with('error', 'Inspector 1 must approve first');
                    }
                    
                    $updateData = [
                        'inspected_by2_name' => $user->nama,
                        'inspected_by2_nik' => $user->nik,
                        'inspection_date2' => $now,
                        'inspected_by2_status' => 'approved'
                    ];
                    break;
                    
                case 'inspector3':
                    // Check if inspector2 has approved
                    if ($record->inspected_by2_status !== 'approved') {
                        return redirect()->route('she.mess.dashboard')
                            ->with('error', 'Inspector 2 must approve first');
                    }
                    
                    $updateData = [
                        'inspected_by3_name' => $user->nama,
                        'inspected_by3_nik' => $user->nik,
                        'inspection_date3' => $now,
                        'inspected_by3_status' => 'approved'
                    ];
                    break;
                    
                case 'acknowledger':
                    // Check if inspector3 has approved
                    if ($record->inspected_by3_status !== 'approved') {
                        return redirect()->route('she.mess.dashboard')
                            ->with('error', 'Inspector 3 must approve first');
                    }
                    
                    $updateData = [
                        'acknowledged_by_name' => $user->nama,
                        'acknowledged_by_nik' => $user->nik,
                        'acknowledgment_date' => $now,
                        'acknowledged_by_status' => 'approved'
                    ];
                    break;
                    
                default:
                    return redirect()->route('she.mess.dashboard')
                        ->with('error', 'Invalid approval role');
            }
            
            // Update the overall approval status
            if ($role === 'acknowledger') {
                $updateData['approval_status'] = 'approved';
            } else if ($role === 'inspector1') {
                $updateData['approval_status'] = 'in_progress';
            }
            
            // Update the record
            DB::table('she_mess_survey')
                ->where('id', $id)
                ->update($updateData);
                
            return redirect()->route('she.mess.dashboard')
                ->with('success', 'Record approved successfully');
                
        } catch (\Exception $e) {
            Log::error('Error in Approve method: ' . $e->getMessage());
            return redirect()->route('she.mess.dashboard')
                ->with('error', 'Failed to approve record: ' . $e->getMessage());
        }
    }

    /**
     * Reject a mess survey record
     * 
     * @param int $id
     * @param string $role
     * @return \Illuminate\Http\Response
     */
    public function Reject($id, $role)
    {
        try {
            // Get current user ID and username from session
            $currentUserId = session('user_id') ?? '';
            $currentUsername = session('username') ?? '';
            
            if (empty($currentUserId) || empty($currentUsername)) {
                return redirect()->route('she.mess.dashboard')
                    ->with('error', 'Please login first');
            }
            
            // Get the record
            $record = DB::table('she_mess_survey')->where('id', $id)->first();
            
            if (!$record) {
                return redirect()->route('she.mess.dashboard')
                    ->with('error', 'Record not found');
            }
            
            // Create user object with session data
            $user = (object)[
                'nik' => $currentUserId,
                'nama' => $currentUsername
            ];
            
            // Check which role is rejecting and update accordingly
            $updateData = [];
            $now = now()->format('Y-m-d');
            
            switch ($role) {
                case 'inspector1':
                    $updateData = [
                        'inspected_by_name' => $user->nama,
                        'inspected_by_nik' => $user->nik,
                        'inspection_date' => $now,
                        'inspected_by_status' => 'rejected'
                    ];
                    break;
                    
                case 'inspector2':
                    // Check if inspector1 has approved
                    if ($record->inspected_by_status !== 'approved') {
                        return redirect()->route('she.mess.dashboard')
                            ->with('error', 'Inspector 1 must approve first');
                    }
                    
                    $updateData = [
                        'inspected_by2_name' => $user->nama,
                        'inspected_by2_nik' => $user->nik,
                        'inspection_date2' => $now,
                        'inspected_by2_status' => 'rejected'
                    ];
                    break;
                    
                case 'inspector3':
                    // Check if inspector2 has approved
                    if ($record->inspected_by2_status !== 'approved') {
                        return redirect()->route('she.mess.dashboard')
                            ->with('error', 'Inspector 2 must approve first');
                    }
                    
                    $updateData = [
                        'inspected_by3_name' => $user->nama,
                        'inspected_by3_nik' => $user->nik,
                        'inspection_date3' => $now,
                        'inspected_by3_status' => 'rejected'
                    ];
                    break;
                    
                case 'acknowledger':
                    // Check if inspector3 has approved
                    if ($record->inspected_by3_status !== 'approved') {
                        return redirect()->route('she.mess.dashboard')
                            ->with('error', 'Inspector 3 must approve first');
                    }
                    
                    $updateData = [
                        'acknowledged_by_name' => $user->nama,
                        'acknowledged_by_nik' => $user->nik,
                        'acknowledgment_date' => $now,
                        'acknowledged_by_status' => 'rejected'
                    ];
                    break;
                    
                default:
                    return redirect()->route('she.mess.dashboard')
                        ->with('error', 'Invalid rejection role');
            }
            
            // Update the overall approval status
            $updateData['approval_status'] = 'rejected';
            
            // Update the record
            DB::table('she_mess_survey')
                ->where('id', $id)
                ->update($updateData);
                
            // Log the update for debugging
            Log::info('Record rejected successfully', [
                'id' => $id,
                'role' => $role,
                'user' => $user->nama,
                'updateData' => $updateData
            ]);
                
            return redirect()->route('she.mess.dashboard')
                ->with('success', 'Record rejected successfully');
                
        } catch (\Exception $e) {
            Log::error('Error in Reject method: ' . $e->getMessage());
            return redirect()->route('she.mess.dashboard')
                ->with('error', 'Failed to reject record: ' . $e->getMessage());
        }
    }

    /**
     * Delete a mess survey record
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function Delete(Request $request)
    {
        try {
            // Get the record ID from the request
            $id = $request->input('id');
            
            // Find the record
            $record = DB::table('she_mess_survey')->where('id', $id)->first();
            
            if (!$record) {
                return response()->json([
                    'success' => false,
                    'message' => 'Record not found'
                ]);
            }
            
            // Check if the record is in a state that allows deletion
            if ($record->approval_status === 'approved') {
                return response()->json([
                    'success' => false,
                    'message' => 'Approved records cannot be deleted'
                ]);
            }
            
            // Delete the record
            DB::table('she_mess_survey')->where('id', $id)->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Record deleted successfully'
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error in Delete method: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete record: ' . $e->getMessage()
            ]);
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

    public function getApprovalList(Request $request)
    {
        $search = $request->input('search', '');
        $list = HrdHelper::getApprovalList($search);

        return response()->json($list);
    }
}