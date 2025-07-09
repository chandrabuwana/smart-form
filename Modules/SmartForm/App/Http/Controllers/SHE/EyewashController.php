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

class EyewashController extends Controller
{
    public function Dashboard(Request $request)
    {
        try {
            $query = DB::table('she_eyewash')
                ->select([
                    'she_eyewash.*',
                    DB::raw('FORMAT(inspection_date, \'yyyy-MM-dd\') as formatted_date')
                ]);

            // Search functionality
            if ($request->has('search')) {
                $searchTerm = $request->search;
                $query->where(function($q) use ($searchTerm) {
                    $q->where('doc_number', 'like', '%' . $searchTerm . '%')
                        ->orWhere('location', 'like', '%' . $searchTerm . '%')
                        ->orWhere('created_by', 'like', '%' . $searchTerm . '%');
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
            if ($request->has('location') && $request->location) {
                $query->where('location', $request->location);
            }

            // Get unique locations for filter
            $locations = DB::table('she_eyewash')
                ->select('location')
                ->distinct()
                ->whereNotNull('location')
                ->pluck('location');

            // Filter options object
            $filter_options = (object)[
                'locations' => $locations,
            ];

            // Get records with pagination
            $records = $query->orderBy('created_at', 'desc')
                           ->paginate(10)
                           ->withQueryString();

            // Calculate statistics
            $statistics = [
                'total_records' => DB::table('she_eyewash')->count(),
                'total_this_month' => DB::table('she_eyewash')
                    ->whereMonth('created_at', now()->month)
                    ->whereYear('created_at', now()->year)
                    ->count(),
                'locations_count' => $locations->count(),
                'need_attention' => DB::table('she_eyewash')
                    ->where(function($query) {
                        $query->whereJsonContains('monthly_data->tank_condition', 'Rusak')
                            ->orWhereJsonContains('monthly_data->water_volume', 'Kosong')
                            ->orWhereJsonContains('monthly_data->eyewash_function', 'Rusak');
                    })
                    ->count()
            ];

            // Get current user's username for authorization checks
            $username = session('username');

            // Debug session values
            Log::info('Dashboard - Session user_id: ' . (session('user_id') ?? 'NULL'));
            Log::info('Dashboard - Session username: ' . (session('username') ?? 'NULL'));
            
            return view('SmartForm::she/eyewash/dashboard', [
                'records' => $records,
                'statistics' => (object)$statistics,
                'filter_options' => $filter_options,
                'filters' => [
                    'search' => $request->search,
                    'start_date' => $request->start_date,
                    'end_date' => $request->end_date,
                    'location' => $request->location,
                ],
                'username' => $username
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
                
                // Debug the query
                $query = DB::table('she_eyewash')->where('id', $request->id);
                
                $record = $query->first();

                if (!$record) {
                    Log::error('Eyewash record not found for ID: ' . $request->id);
                    return redirect()->route('she-inspeksi.dashboard')
                        ->with('error', 'Record not found');
                }

                try {
                    // Remove the :AM/:PM format and convert to standard format
                    $dateStr = preg_replace('/:([AP]M)/', ' $1', $record->inspection_date);
                    $record->inspection_date = Carbon::createFromFormat('M d Y h:i:s A', $dateStr)->format('Y-m-d');
                } catch (\Exception $e) {
                    Log::error('Date parsing error: ' . $e->getMessage());
                    // Fallback to current date if parsing fails
                    $record->inspection_date = now()->format('Y-m-d');
                }

                // Decode monthly data
                $record->monthly_data = json_decode($record->monthly_data, true);

                return view('SmartForm::she/eyewash/form', [
                    'isShowDetail' => true,
                    'approvalList' => HrdHelper::getApprovalList(),
                    'maintenanceRecord' => $record
                ]);
            }

            return view('SmartForm::she/eyewash/form', [
                'isShowDetail' => false,
                'approvalList' => HrdHelper::getApprovalList(),
                'maintenanceRecord' => null
            ]);

        } catch (\Exception $e) {
            Log::error('Error in AddForm: ' . $e->getMessage());
            return redirect()->route('she-inspeksi.dashboard')
                ->with('error', 'Failed to load form: ' . $e->getMessage());
        }
    }

    public function Store(Request $request)
    {
        try {
            Log::info('Processing Eyewash form submission');

            $validator = Validator::make($request->all(), [
                'inspection_date' => 'required|date',
                'location' => 'required|string',
                'supervisor_name' => 'nullable|string',
                'supervisor_nik' => 'nullable|string',
                'dh_name' => 'nullable|string',
                'dh_nik' => 'nullable|string',
                'dh_terkait_name' => 'nullable|string',
                'dh_terkait_nik' => 'nullable|string',
                // 'created_by' => 'required|string',
                // 'supervisor' => 'required|string',
                // 'dh' => 'required|string',
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

                // Prepare monthly data
                $monthlyData = [];
                $months = [
                    'JANUARI', 'FEBRUARI', 'MARET', 'APRIL', 'MEI', 'JUNI',
                    'JULI', 'AGUSTUS', 'SEPTEMBER', 'OKTOBER', 'NOVEMBER', 'DESEMBER'
                ];

                foreach ($months as $month) {
                    if ($request->has("kondisi_tangki_$month") || 
                        $request->has("penutup_tangki_$month") || 
                        $request->has("warna_air_$month") || 
                        $request->has("bau_air_$month") || 
                        $request->has("volume_air_$month") || 
                        $request->has("kebersihan_tangki_$month") || 
                        $request->has("fungsi_eyewash_$month") ||
                        $request->has("paraf_$month")) {
                        
                        $monthlyData[$month] = [
                            'kondisi_tangki' => $request->input("kondisi_tangki_$month"),
                            'penutup_tangki' => $request->input("penutup_tangki_$month"),
                            'warna_air' => $request->input("warna_air_$month"),
                            'bau_air' => $request->input("bau_air_$month"),
                            'volume_air' => $request->input("volume_air_$month"),
                            'kebersihan_tangki' => $request->input("kebersihan_tangki_$month"),
                            'fungsi_eyewash' => $request->input("fungsi_eyewash_$month"),
                            'paraf' => $request->has("paraf_$month") ? true : false
                        ];
                    }
                }

                // Debug session values
                Log::info('Session user_id: ' . (session('user_id') ?? 'NULL'));
                Log::info('Session username: ' . (session('username') ?? 'NULL'));
                
                // Create record
                DB::table('she_eyewash')->insert([
                    'doc_number' => $docNumber,
                    'inspection_date' => $request->inspection_date,
                    'location' => $request->location,
                    'monthly_data' => json_encode($monthlyData),
                    'notes' => $request->notes,
                    'created_by' => session('username'),
                    'hygiene_name' => session('username'), // Set the creator as the hygiene approver
                    'hygiene_nik' => session('user_id'),   // Set the creator's ID as the hygiene NIK
                    'hygiene_signed_at' => now(),         // Set the current time as the hygiene signed timestamp
                    'supervisor_name' => $request->supervisor_name,
                    'supervisor_nik' => $request->supervisor_nik,
                    'supervisor_signed_at' => $request->has('supervisor_signed_at') ? $request->supervisor_signed_at : null,
                    'dh_name' => $request->dh_name,
                    'dh_nik' => $request->dh_nik,
                    'dh_signed_at' => $request->has('dh_signed_at') ? $request->dh_signed_at : null,
                    'dh_terkait_name' => $request->dh_terkait_name,
                    'dh_terkait_nik' => $request->dh_terkait_nik,
                    'dh_terkait_signed_at' => $request->has('dh_terkait_signed_at') ? $request->dh_terkait_signed_at : null,
                    'created_at' => now(),
                    'updated_at' => now(),
                    'hygiene_status' => 'pending',
                    'supervisor_status' => 'pending',
                    'dh_status' => 'pending',
                    'dh_terkait_status' => 'pending',
                    'approval_status' => 'pending'
                ]);

                DB::commit();
                Log::info('Eyewash form submitted successfully');
                
                return response()->json([
                    'success' => true,
                    'message' => 'Form inspeksi eyewash berhasil disimpan.'
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
            Log::info('Exporting Eyewash record for ID: ' . $id);

            $record = DB::table('she_eyewash')
                ->where('id', $id)
                ->first();

            if (!$record) {
                Log::error('Record not found for export, ID: ' . $id);
                return redirect()->back()->with('error', 'Record not found');
            }

            $record->monthly_data = json_decode($record->monthly_data, true);
            try {
                // Remove the :AM/:PM format and convert to standard format
                $dateStr = preg_replace('/:([AP]M)/', ' $1', $record->inspection_date);
                $record->inspection_date = Carbon::createFromFormat('M d Y h:i:s A', $dateStr)->format('Y-m-d');
            } catch (\Exception $e) {
                Log::error('Date parsing error: ' . $e->getMessage());
                // Fallback to current date if parsing fails
                $record->inspection_date = now()->format('Y-m-d');
            }

            $pdf = PDF::loadView('SmartForm::she/eyewash/export-pdf', [
                'record' => $record
            ]);

            Log::info('Successfully generated PDF for record ID: ' . $id);
            return $pdf->download('eyewash-inspection-' . $record->doc_number . '.pdf');

        } catch (\Exception $e) {
            Log::error('Error in ExportForm: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Failed to export form: ' . $e->getMessage());
        }
    }

    public function EditForm(Request $request, $id = null)
    {
        try {
            // Check if ID is provided either as route parameter or query parameter
            $recordId = $id ?? $request->id;
            
            if (!$recordId) {
                return redirect()->route('she-inspeksi.dashboard')
                    ->with('error', 'Record ID is required');
            }
            
            $record = DB::table('she_eyewash')->where('id', $recordId)->first();
            
            if (!$record) {
                return redirect()->route('she-inspeksi.dashboard')
                    ->with('error', 'Record not found');
            }
            
            // Check if user is the creator of the record
            if ($record->created_by !== session('username')) {
                return redirect()->route('she-inspeksi.dashboard')
                    ->with('error', 'You are not authorized to edit this record');
            }
            
            // Check if record can be edited (only pending or rejected records)
            if ($record->approval_status !== 'pending' && $record->approval_status !== 'rejected') {
                return redirect()->route('she-inspeksi.dashboard')
                    ->with('error', 'Only pending or rejected records can be edited');
            }
            
            try {
                // Remove the :AM/:PM format and convert to standard format
                $dateStr = preg_replace('/:([AP]M)/', ' $1', $record->inspection_date);
                $record->inspection_date = Carbon::createFromFormat('M d Y h:i:s A', $dateStr)->format('Y-m-d');
            } catch (\Exception $e) {
                Log::error('Date parsing error: ' . $e->getMessage());
                // Fallback to current date if parsing fails
                $record->inspection_date = now()->format('Y-m-d');
            }
            
            // Decode monthly data
            $record->monthly_data = json_decode($record->monthly_data, true);
            
            return view('SmartForm::she/eyewash/edit', [
                'maintenanceRecord' => $record,
                'approvalList' => HrdHelper::getApprovalList()
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error in EditForm: ' . $e->getMessage());
            return redirect()->route('she-inspeksi.dashboard')
                ->with('error', 'Failed to load edit form: ' . $e->getMessage());
        }
    }
    
    public function UpdateForm(Request $request)
    {
        try {
            Log::info('Processing Eyewash form update');
            
            $validator = Validator::make($request->all(), [
                'id' => 'required|exists:she_eyewash,id',
                'inspection_date' => 'required|date',
                'location' => 'required|string',
                'supervisor_name' => 'nullable|string',
                'supervisor_nik' => 'nullable|string',
                'dh_name' => 'nullable|string',
                'dh_nik' => 'nullable|string',
                'dh_terkait_name' => 'nullable|string',
                'dh_terkait_nik' => 'nullable|string',
            ]);
            
            if ($validator->fails()) {
                Log::warning('Validation failed: ' . json_encode($validator->errors()));
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }
            
            $record = DB::table('she_eyewash')->where('id', $request->id)->first();
            
            // Check if user is the creator of the record
            if ($record->created_by !== session('username')) {
                return response()->json([
                    'success' => false,
                    'message' => 'You are not authorized to update this record'
                ], 403);
            }
            
            // Check if record can be edited (only pending or rejected records)
            if ($record->approval_status !== 'pending' && $record->approval_status !== 'rejected') {
                return response()->json([
                    'success' => false,
                    'message' => 'Only pending or rejected records can be updated'
                ], 403);
            }
            
            DB::beginTransaction();
            
            try {
                // Prepare monthly data
                $monthlyData = [];
                $months = [
                    'JANUARI', 'FEBRUARI', 'MARET', 'APRIL', 'MEI', 'JUNI',
                    'JULI', 'AGUSTUS', 'SEPTEMBER', 'OKTOBER', 'NOVEMBER', 'DESEMBER'
                ];
                
                foreach ($months as $month) {
                    if ($request->has("kondisi_tangki_$month") || 
                        $request->has("penutup_tangki_$month") || 
                        $request->has("warna_air_$month") || 
                        $request->has("bau_air_$month") || 
                        $request->has("volume_air_$month") || 
                        $request->has("kebersihan_tangki_$month") || 
                        $request->has("fungsi_eyewash_$month") ||
                        $request->has("paraf_$month")) {
                        
                        $monthlyData[$month] = [
                            'kondisi_tangki' => $request->input("kondisi_tangki_$month"),
                            'penutup_tangki' => $request->input("penutup_tangki_$month"),
                            'warna_air' => $request->input("warna_air_$month"),
                            'bau_air' => $request->input("bau_air_$month"),
                            'volume_air' => $request->input("volume_air_$month"),
                            'kebersihan_tangki' => $request->input("kebersihan_tangki_$month"),
                            'fungsi_eyewash' => $request->input("fungsi_eyewash_$month"),
                            'paraf' => $request->has("paraf_$month") ? true : false
                        ];
                    }
                }
                
                $updateData = [
                    'inspection_date' => $request->inspection_date,
                    'location' => $request->location,
                    'monthly_data' => json_encode($monthlyData),
                    'notes' => $request->notes,
                    'updated_at' => now(),
                ];
                
                // Only update approver fields if they are provided in the request
                // Otherwise, preserve the existing values
                if ($request->filled('supervisor_name')) {
                    $updateData['supervisor_name'] = $request->supervisor_name;
                }
                if ($request->filled('supervisor_nik')) {
                    $updateData['supervisor_nik'] = $request->supervisor_nik;
                }
                if ($request->has('supervisor_signed_at')) {
                    $updateData['supervisor_signed_at'] = $request->supervisor_signed_at;
                }
                
                if ($request->filled('dh_name')) {
                    $updateData['dh_name'] = $request->dh_name;
                }
                if ($request->filled('dh_nik')) {
                    $updateData['dh_nik'] = $request->dh_nik;
                }
                if ($request->has('dh_signed_at')) {
                    $updateData['dh_signed_at'] = $request->dh_signed_at;
                }
                
                if ($request->filled('dh_terkait_name')) {
                    $updateData['dh_terkait_name'] = $request->dh_terkait_name;
                }
                if ($request->filled('dh_terkait_nik')) {
                    $updateData['dh_terkait_nik'] = $request->dh_terkait_nik;
                }
                if ($request->has('dh_terkait_signed_at')) {
                    $updateData['dh_terkait_signed_at'] = $request->dh_terkait_signed_at;
                }
                
                // Reset approval statuses if it was rejected
                if ($record->approval_status === 'rejected') {
                    $updateData['hygiene_status'] = 'pending';
                    $updateData['supervisor_status'] = 'pending';
                    $updateData['dh_status'] = 'pending';
                    $updateData['dh_terkait_status'] = 'pending';
                    $updateData['approval_status'] = 'pending';
                }
                
                DB::table('she_eyewash')
                    ->where('id', $request->id)
                    ->update($updateData);
                
                DB::commit();
                Log::info('Eyewash form updated successfully');
                
                return response()->json([
                    'success' => true,
                    'message' => 'Form inspeksi eyewash berhasil diperbarui.'
                ]);
                
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Error in transaction: ' . $e->getMessage());
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal memperbarui form: ' . $e->getMessage()
                ], 500);
            }
            
        } catch (\Exception $e) {
            Log::error('Error in UpdateForm: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to update form: ' . $e->getMessage()
            ], 500);
        }
    }
    
    public function DeleteRecord($id)
    {
        try {
            $record = DB::table('she_eyewash')->where('id', $id)->first();
            
            if (!$record) {
                return redirect()->route('she-inspeksi.dashboard')
                    ->with('error', 'Record not found');
            }
            
            // Check if user is the creator of the record
            if ($record->created_by !== session('username')) {
                return redirect()->route('she-inspeksi.dashboard')
                    ->with('error', 'You are not authorized to delete this record');
            }
            
            // Check if record can be deleted (only pending or rejected records)
            if ($record->approval_status !== 'pending' && $record->approval_status !== 'rejected') {
                return redirect()->route('she-inspeksi.dashboard')
                    ->with('error', 'Only pending or rejected records can be deleted');
            }
            
            DB::table('she_eyewash')->where('id', $id)->delete();
            
            return redirect()->route('she-inspeksi.dashboard')
                ->with('success', 'Record deleted successfully');
                
        } catch (\Exception $e) {
            Log::error('Error in DeleteRecord: ' . $e->getMessage());
            return redirect()->route('she-inspeksi.dashboard')
                ->with('error', 'Failed to delete record: ' . $e->getMessage());
        }
    }
    
    public function ApproveRecord(Request $request, $id)
    {
        try {
            $record = DB::table('she_eyewash')->where('id', $id)->first();
            
            if (!$record) {
                return redirect()->route('she-inspeksi.dashboard')
                    ->with('error', 'Record not found');
            }
            
            $username = session('username');
            $userId = session('user_id');
            $role = $request->role;
            
            if (!$username || !$userId) {
                return redirect()->route('she-inspeksi.dashboard')
                    ->with('error', 'User session not found');
            }
            
            DB::beginTransaction();
            
            try {
                $updateData = [];
                $message = '';
                
                // Process approval based on role
                switch ($role) {
                    case 'hygiene':
                        // Check if this is the first approval
                        if ($record->approval_status !== 'pending') {
                            return redirect()->route('she-inspeksi.dashboard')
                                ->with('error', 'Invalid approval sequence');
                        }
                        
                        $updateData = [
                            'hygiene_name' => $username,
                            'hygiene_nik' => $userId,
                            'hygiene_signed_at' => now(),
                            'hygiene_status' => 'approved',
                            'approval_status' => 'in_progress'
                        ];
                        $message = 'Hygiene approval successful';
                        break;
                        
                    case 'supervisor':
                        // Check if previous approver has approved
                        if ($record->hygiene_status !== 'approved') {
                            return redirect()->route('she-inspeksi.dashboard')
                                ->with('error', 'Previous approval required');
                        }
                        
                        $updateData = [
                            'supervisor_name' => $username,
                            'supervisor_nik' => $userId,
                            'supervisor_signed_at' => now(),
                            'supervisor_status' => 'approved',
                            'approval_status' => 'in_progress'
                        ];
                        $message = 'Supervisor approval successful';
                        break;
                        
                    case 'dh':
                        // Check if previous approver has approved
                        if ($record->supervisor_status !== 'approved') {
                            return redirect()->route('she-inspeksi.dashboard')
                                ->with('error', 'Previous approval required');
                        }
                        
                        $updateData = [
                            'dh_name' => $username,
                            'dh_nik' => $userId,
                            'dh_signed_at' => now(),
                            'dh_status' => 'approved',
                            'approval_status' => 'in_progress'
                        ];
                        $message = 'Department Head approval successful';
                        break;
                        
                    case 'dh_terkait':
                        // Check if previous approver has approved
                        if ($record->dh_status !== 'approved') {
                            return redirect()->route('she-inspeksi.dashboard')
                                ->with('error', 'Previous approval required');
                        }
                        
                        $updateData = [
                            'dh_terkait_name' => $username,
                            'dh_terkait_nik' => $userId,
                            'dh_terkait_signed_at' => now(),
                            'dh_terkait_status' => 'approved',
                            'approval_status' => 'approved' // Final approval
                        ];
                        $message = 'Related Department Head approval successful. Record is now fully approved.';
                        break;
                        
                    default:
                        return redirect()->route('she-inspeksi.dashboard')
                            ->with('error', 'Invalid approval role');
                }
                
                DB::table('she_eyewash')
                    ->where('id', $id)
                    ->update($updateData);
                
                DB::commit();
                
                return redirect()->route('she-inspeksi.dashboard')
                    ->with('success', $message);
                    
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Error in approval transaction: ' . $e->getMessage());
                return redirect()->route('she-inspeksi.dashboard')
                    ->with('error', 'Approval failed: ' . $e->getMessage());
            }
            
        } catch (\Exception $e) {
            Log::error('Error in ApproveRecord: ' . $e->getMessage());
            return redirect()->route('she-inspeksi.dashboard')
                ->with('error', 'Failed to process approval: ' . $e->getMessage());
        }
    }
    
    public function RejectRecord(Request $request, $id)
    {
        try {
            $record = DB::table('she_eyewash')->where('id', $id)->first();
            
            if (!$record) {
                return redirect()->route('she-inspeksi.dashboard')
                    ->with('error', 'Record not found');
            }
            
            $username = session('username');
            $userId = session('user_id');
            $role = $request->role;
            $reason = $request->reason;
            
            if (!$username || !$userId) {
                return redirect()->route('she-inspeksi.dashboard')
                    ->with('error', 'User session not found');
            }
            
            if (!$reason) {
                return redirect()->route('she-inspeksi.dashboard')
                    ->with('error', 'Rejection reason is required');
            }
            
            DB::beginTransaction();
            
            try {
                $updateData = [];
                $message = '';
                
                // Process rejection based on role
                switch ($role) {
                    case 'hygiene':
                        $updateData = [
                            'hygiene_name' => $username,
                            'hygiene_nik' => $userId,
                            'hygiene_signed_at' => now(),
                            'hygiene_status' => 'rejected',
                            'approval_status' => 'rejected',
                            'notes' => ($record->notes ? $record->notes . "\n\n" : '') . 
                                      "Rejected by Hygiene ($username) on " . now()->format('Y-m-d H:i:s') . ":\n$reason"
                        ];
                        $message = 'Record rejected by Hygiene';
                        break;
                        
                    case 'supervisor':
                        $updateData = [
                            'supervisor_name' => $username,
                            'supervisor_nik' => $userId,
                            'supervisor_signed_at' => now(),
                            'supervisor_status' => 'rejected',
                            'approval_status' => 'rejected',
                            'notes' => ($record->notes ? $record->notes . "\n\n" : '') . 
                                      "Rejected by Supervisor ($username) on " . now()->format('Y-m-d H:i:s') . ":\n$reason"
                        ];
                        $message = 'Record rejected by Supervisor';
                        break;
                        
                    case 'dh':
                        $updateData = [
                            'dh_name' => $username,
                            'dh_nik' => $userId,
                            'dh_signed_at' => now(),
                            'dh_status' => 'rejected',
                            'approval_status' => 'rejected',
                            'notes' => ($record->notes ? $record->notes . "\n\n" : '') . 
                                      "Rejected by Department Head ($username) on " . now()->format('Y-m-d H:i:s') . ":\n$reason"
                        ];
                        $message = 'Record rejected by Department Head';
                        break;
                        
                    case 'dh_terkait':
                        $updateData = [
                            'dh_terkait_name' => $username,
                            'dh_terkait_nik' => $userId,
                            'dh_terkait_signed_at' => now(),
                            'dh_terkait_status' => 'rejected',
                            'approval_status' => 'rejected',
                            'notes' => ($record->notes ? $record->notes . "\n\n" : '') . 
                                      "Rejected by Related Department Head ($username) on " . now()->format('Y-m-d H:i:s') . ":\n$reason"
                        ];
                        $message = 'Record rejected by Related Department Head';
                        break;
                        
                    default:
                        return redirect()->route('she-inspeksi.dashboard')
                            ->with('error', 'Invalid rejection role');
                }
                
                DB::table('she_eyewash')
                    ->where('id', $id)
                    ->update($updateData);
                
                DB::commit();
                
                return redirect()->route('she-inspeksi.dashboard')
                    ->with('success', $message);
                    
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Error in rejection transaction: ' . $e->getMessage());
                return redirect()->route('she-inspeksi.dashboard')
                    ->with('error', 'Rejection failed: ' . $e->getMessage());
            }
            
        } catch (\Exception $e) {
            Log::error('Error in RejectRecord: ' . $e->getMessage());
            return redirect()->route('she-inspeksi.dashboard')
                ->with('error', 'Failed to process rejection: ' . $e->getMessage());
        }
    }
    
    private function generateDocNumber()
    {
        $prefix = 'BSS-FRM-SHE-037';
        $date = now()->format('dmY');
        $lastRecord = DB::table('she_eyewash')
            ->whereDate('created_at', now())
            ->orderBy('created_at', 'desc')
            ->first();

        $sequence = 1;
        if ($lastRecord && preg_match('/-(\d+)$/', $lastRecord->doc_number, $matches)) {
            $sequence = intval($matches[1]) + 1;
        }

        return sprintf("%s-%s-%03d", $prefix, $date, $sequence);
    }

    public function getApprovalList(Request $request)
    {
        $search = $request->input('search', '');
        $list = HrdHelper::getApprovalList($search);

        return response()->json($list);
    }
}