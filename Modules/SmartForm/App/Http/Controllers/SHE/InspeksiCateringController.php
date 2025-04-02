<?php

namespace Modules\SmartForm\App\Http\Controllers\SHE;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Database\QueryException;
use Barryvdh\DomPDF\Facade\Pdf;
use Modules\SmartForm\helpers\HrdHelper;

class InspeksiCateringController extends Controller {

    public function download() {
        $pdf = Pdf::loadView('pdf');
 
        return $pdf->download();
    }

    public function InspeksiCateringDashboard(Request $request)
    {
        try {
            // Get filters from request
            $filters = [
                'search' => $request->input('search'),
                'work_location' => $request->input('work_location'),
                'start_date' => $request->input('start_date'),
            ];
            
            // Build query with filters
            $query = DB::table('FM_SHE_048_INSPEKSI_CATERING');
            
            if (!empty($filters['search'])) {
                $query->where(function($q) use ($filters) {
                    $q->where('nama_site', 'like', '%' . $filters['search'] . '%')
                      ->orWhere('lokasi_kerja', 'like', '%' . $filters['search'] . '%');
                });
            }
            
            if (!empty($filters['work_location'])) {
                $query->where('lokasi_kerja', $filters['work_location']);
            }
            
            if (!empty($filters['start_date'])) {
                $query->whereDate('tanggal_form', $filters['start_date']);
            }
            
            // Get all records sorted by newest first
            $records = $query->orderBy('id', 'desc')->get();
            
            // Enhance records with username information from the users table
            foreach ($records as &$record) {
                // Look up the diinspeksi_oleh_1 name if it's not already set
                if (isset($record->diinspeksi_oleh_1) && !isset($record->diinspeksi_oleh_1_name)) {
                    $user = DB::table('users')
                        ->where('userid', $record->diinspeksi_oleh_1)
                        ->select('username')
                        ->first();
                    $record->diinspeksi_oleh_1_name = $user ? $user->username : null;
                }
                
                // Look up the diinspeksi_oleh_2 name if it's not already set
                if (isset($record->diinspeksi_oleh_2) && !isset($record->diinspeksi_oleh_2_name)) {
                    $user = DB::table('users')
                        ->where('userid', $record->diinspeksi_oleh_2)
                        ->select('username')
                        ->first();
                    $record->diinspeksi_oleh_2_name = $user ? $user->username : null;
                }
                
                // Look up the diinspeksi_oleh_3 name if it's not already set
                if (isset($record->diinspeksi_oleh_3) && !isset($record->diinspeksi_oleh_3_name)) {
                    $user = DB::table('users')
                        ->where('userid', $record->diinspeksi_oleh_3)
                        ->select('username')
                        ->first();
                    $record->diinspeksi_oleh_3_name = $user ? $user->username : null;
                }
                
                // Parse the status field if it exists
                if (isset($record->status) && !empty($record->status)) {
                    try {
                        $statusArray = json_decode($record->status, true);
                        if (is_array($statusArray)) {
                            $record->status = $statusArray;
                        } else {
                            $record->status = [null, null, null];
                        }
                    } catch (\Exception $e) {
                        $record->status = [null, null, null];
                    }
                } else {
                    $record->status = [null, null, null];
                }
            }
            
            // Get locations for filter dropdown
            $locations = DB::table('FM_SHE_048_INSPEKSI_CATERING')
                ->select('lokasi_kerja')
                ->whereNotNull('lokasi_kerja')
                ->distinct()
                ->get();
                
            //Get count of records for this month
            $recordsThisMonth = DB::table('FM_SHE_048_INSPEKSI_CATERING')
                ->whereMonth('tanggal_form', now()->month)
                ->whereYear('tanggal_form', now()->year)
                ->count();
            
            // Pass data to view
            return view('SmartForm::she/inspeksi-catering/inspeksi-catering', [
                'records' => $records,
                'locations' => $locations,
                'recordsThisMonth' => $recordsThisMonth,
                'filters' => $filters
            ]);
            
        } catch (Exception $e) {
            Log::error('Error in InspeksiCateringDashboard: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            // Return view with empty data to prevent undefined variable errors
            return view('SmartForm::she/inspeksi-catering/inspeksi-catering', [
                'records' => collect(),
                'locations' => collect(),
                'recordsThisMonth' => 0,
                'filters' => []
            ])->with('error', 'An error occurred while loading the dashboard: ' . $e->getMessage());
        }
    }

    function GetListInspeksiCatering(Request $request) {
        $TABLE_MASTER = "FM_SHE_048_INSPEKSI_CATERING";
        $response = array(
            'message' => '',
            'isSuccess' => false
        );
        $filterTanggal = $request->query('tanggal', null);
        $filterSite = $request->query('site', null);
        $filterNik = $request->query('nama', null);
        $filterStatus = $request->query('status', null);
        $search = $request->query('search', '');
        $sort = $request->query('sort', 'id'); // Default sort by id
        $order = $request->query('order', 'desc');
        $offset = $request->query('offset', 0); // Default offset
        $limit = $request->query('limit', null); // Default limit
        $filter = $request->query('filter', null); // Default limit
        try {
            $master = DB::table($TABLE_MASTER)
                ->select('id', 'lokasi_kerja as loker');
            
            if($filterTanggal == null || $filterTanggal == 'null') {
            } else {
                $tgl = Carbon::createFromFormat('Y-m-d', $filterTanggal);
                $master->whereDate('tanggal', $tgl);
            }
            if($filterSite == null || $filterSite == 'null') {
            } else {
                $master->where('site', $filterSite);
            }
            if($filterNik == null || $filterNik == 'null') {
            } else {
                $master->where('nik', $filterNik);
            }
            if($filterStatus == null || $filterStatus == 'null') {
            } else {
                $master->where('status', $filterStatus);
            }
            $master->orderBy($sort, $order);
            // Log::debug("SQL : ".$master->toRawSql());
            $jml = $master->count();
            if($limit == null || $limit == 'null' || $limit == '') {
                $master->skip($offset);
            } else {
                $master->skip($offset)->limit($limit);
            }
            $document = $master->get();

            $response['message'] = "Ok";
            $response['isSuccess'] = true;
            $response['data'] = [
                'total' => $jml,
                'totalNotFiltered' => $jml,
                'rows' => $document
            ];

        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            
            $response['message'] = $ex->getMessage();
            $response['isSuccess'] = false;
        }

        return response()->json($response);
    }

    function FormInspeksiCatering() {
        return view('SmartForm::she/inspeksi-catering/form-inspeksi-catering', [
                    'isShowDetail' => true,
                    'approvalList' => HrdHelper::getApprovalList()
                ]);
    }
    
    public function CreateInspeksiCatering(Request $request)
    {
        DB::beginTransaction();
        $requestData = $request->all();
    
        try {
            // Log current user info for debugging
            $user_id = session('user_id');
            $username = session('username');
            
            Log::info("Creating record with user_id: $user_id, username: $username");
            Log::info("Form data received: ", $requestData);
    
            // Create new data array
            $data = [
                'no_dok_form' => "BSS-FRM-SHE-048",
                'revisi_form' => "00",
                'tanggal_form' => now()->format('Y-m-d H:i:s'),
                'halaman_form' => "1 dari 3",
                
                // Basic information
                'nama_site' => $requestData['tNamaSite'] ?? '',
                'department' => $requestData['dDept'] ?? '',
                'shift' => $requestData['dShift'] ?? '',
                'lokasi_kerja' => $requestData['tLoker'] ?? '',
                'jumlah_inspektor' => $requestData['tJmlIns'] ?? '',
                'mengetahui' => $requestData['dMengetahui'] ?? null,
                
                // Store the creator's ID
                'dibuat_oleh' => $user_id,
                
                // Status for the three-level approval
                'status' => json_encode([null, null, null]),
            ];
            
            // Process all sections (A through E)
            $totalScore = 0;
            $questionCount = 0;
            
            // Section A (Penerimaan) - 10 questions
            for ($i = 1; $i <= 10; $i++) {
                $value = isset($requestData["tA{$i}"]) ? (int)$requestData["tA{$i}"] : 0;
                $data["q_penerimaan_{$i}"] = $value;
                $data["q_keterangan_penerimaan_{$i}"] = $requestData["tA{$i}" . chr(96 + $i)] ?? null;
                
                if ($value > 0) {
                    $totalScore += $value;
                    $questionCount++;
                }
            }
            
            // Section B (Penyimpanan) - 9 questions
            for ($i = 1; $i <= 9; $i++) {
                $value = isset($requestData["tB{$i}"]) ? (int)$requestData["tB{$i}"] : 0;
                $data["q_penyimpanan_{$i}"] = $value;
                $data["q_keterangan_penyimpanan_{$i}"] = $requestData["tB{$i}" . chr(96 + $i)] ?? null;
                
                if ($value > 0) {
                    $totalScore += $value;
                    $questionCount++;
                }
            }
            
            // Section C (Persiapan) - 10 questions
            for ($i = 1; $i <= 10; $i++) {
                $value = isset($requestData["tC{$i}"]) ? (int)$requestData["tC{$i}"] : 0;
                $data["q_persiapan_{$i}"] = $value;
                $data["q_keterangan_persiapan_{$i}"] = $requestData["tC{$i}" . chr(96 + $i)] ?? null;
                
                if ($value > 0) {
                    $totalScore += $value;
                    $questionCount++;
                }
            }
            
            // Section D (Pengolahan) - 10 questions
            for ($i = 1; $i <= 10; $i++) {
                $value = isset($requestData["tD{$i}"]) ? (int)$requestData["tD{$i}"] : 0;
                $data["q_pengolahan_{$i}"] = $value;
                $data["q_keterangan_pengolahan_{$i}"] = $requestData["tD{$i}" . chr(96 + $i)] ?? null;
                
                if ($value > 0) {
                    $totalScore += $value;
                    $questionCount++;
                }
            }
            
            // Section E (Penggolongan Sampah) - 9 questions
            for ($i = 1; $i <= 9; $i++) {
                $value = isset($requestData["tE{$i}"]) ? (int)$requestData["tE{$i}"] : 0;
                $data["q_penggolongan_sampah_{$i}"] = $value;
                $data["q_keterangan_penggolongan_sampah_{$i}"] = $requestData["tE{$i}" . chr(96 + $i)] ?? null;
                
                if ($value > 0) {
                    $totalScore += $value;
                    $questionCount++;
                }
            }
            
            // Calculate average score
            $averageScore = $questionCount > 0 ? round($totalScore / $questionCount, 2) : 0;
            
            // Determine conclusion based on average score
            $conclusion = '';
            if ($averageScore >= 9) {
                $conclusion = 'Sangat Baik';
            } elseif ($averageScore >= 7) {
                $conclusion = 'Baik';
            } elseif ($averageScore >= 5) {
                $conclusion = 'Cukup';
            } else {
                $conclusion = 'Kurang';
            }
            
            // Add score data
            $data['total_score'] = $averageScore;
            $data['conclusion'] = $conclusion;
            
            // Insert the record and capture the ID
            try {
                $insertId = DB::table('FM_SHE_048_INSPEKSI_CATERING')->insertGetId($data);
                Log::info("Successfully inserted record with ID: $insertId");
                
                DB::commit();
                return response()->json([
                    'success' => true,
                    'message' => 'Berhasil menyimpan data form Inspeksi Catering!',
                    'code' => 200,
                    'id' => $insertId
                ]);
            } catch (\Exception $insertEx) {
                Log::error('Error during DB insertion: ' . $insertEx->getMessage());
                Log::error('SQL error: ' . $insertEx->getCode());
                throw $insertEx;
            }
    
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating inspeksi catering: ' . $e->getMessage());
            Log::error('Exception trace: ' . $e->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong: ' . $e->getMessage(),
                'code' => 500
            ], 500);
        }
    }

    // public function DeleteInspeksiCatering($id)
    // {
    //     DB::table('FM_SHE_048_INSPEKSI_CATERING')->where('id', $id)->delete();
    //     return view('SmartForm::she/inspeksi-catering/inspeksi-catering');
    // }

    public function PdfInspeksiCatering($id)
    {
        $data = DB::table('FM_SHE_048_INSPEKSI_CATERING')->where('id', $id)->first();
        $pdf = PDF::loadView('SmartForm::she/inspeksi-catering/inspeksi-catering-pdf',  compact('data'));

        return $pdf->download('BSS-FRM-SHE-048.pdf');
    }

    public function DetailInspeksiCatering($id)
    {
        try {
            // Get master data
            $data = DB::table('FM_SHE_048_INSPEKSI_CATERING')
                ->where('id', $id)
                ->first();
                
            if (!$data) {
                return abort(404, 'Data not found');
            }
            
            // Get current user ID
            $user_id = session('user_id');
            
            return view('smartform::she.inspeksi-catering.detail-inspeksi-catering', [
                'data' => $data,
                'nik' => $user_id
            ]);
        } catch (Exception $e) {
            Log::error('Error in DetailInspeksiCatering: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error loading data: ' . $e->getMessage());
        }
    }

    public function EditInspeksiCatering(Request $request)
    {
        $id = $request->query('id');
        
        if (empty($id)) {
            return redirect()->back()->with('error', 'ID is missing');
        }
        
        try {
            // Get master data
            $data = DB::table('FM_SHE_048_INSPEKSI_CATERING')
                ->where('id', $id)
                ->first();
                
            if (!$data) {
                return abort(404, 'Data not found');
            }
            
            // Get current user ID
            $user_id = session('user_id');
            
            // Get list of users for approval dropdowns
            $approvalList = HrdHelper::getApprovalList();
            
            return view('smartform::she.inspeksi-catering.edit-inspeksi-catering', [
                'data' => $data, // Changed variable name from 'formInspeksiCatering' to 'data'
                'nik' => $user_id,
                'approvalList' => $approvalList
            ]);
        } catch (Exception $e) {
            Log::error('Error in EditInspeksiCatering: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error loading data: ' . $e->getMessage());
        }
    }

    public function UpdateInspeksiCatering(Request $request)
    {
        try {
            // Log incoming request for debugging
            Log::info('Starting UpdateInspeksiCatering with data: ' . json_encode($request->except('_token')));
            
            // Begin transaction
            DB::beginTransaction();
            
            // Get the ID and validate it exists
            $id = $request->input('id');
            if (empty($id)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Missing record ID'
                ], 400);
            }
            
            // Verify record exists
            $record = DB::table('FM_SHE_048_INSPEKSI_CATERING')
                ->where('id', $id)
                ->first();
                
            if (!$record) {
                return response()->json([
                    'success' => false,
                    'message' => 'Record not found'
                ], 404);
            }
            
            // Prepare basic data
            $updateData = [
                'nama_site' => $request->input('tNamaSite'),
                'department' => $request->input('dDept'),
                'shift' => $request->input('dShift'),
                'lokasi_kerja' => $request->input('tLoker'),
                'jumlah_inspektor' => $request->input('tJmlIns'),
                'mengetahui' => $request->input('dMengetahui'),
            ];
            
            // Process all the question fields
            // Section A - Penerimaan (10 questions)
            for ($i = 1; $i <= 10; $i++) {
                $updateData['q_penerimaan_' . $i] = $request->input('tA' . $i);
                $updateData['q_keterangan_penerimaan_' . $i] = $request->input('tA' . $i . chr(96 + $i));
            }
            
            // Section B - Penyimpanan (9 questions)
            for ($i = 1; $i <= 9; $i++) {
                $updateData['q_penyimpanan_' . $i] = $request->input('tB' . $i);
                $updateData['q_keterangan_penyimpanan_' . $i] = $request->input('tB' . $i . chr(96 + $i));
            }
            
            // Section C - Persiapan (10 questions)
            for ($i = 1; $i <= 10; $i++) {
                $updateData['q_persiapan_' . $i] = $request->input('tC' . $i);
                $updateData['q_keterangan_persiapan_' . $i] = $request->input('tC' . $i . chr(96 + $i));
            }
            
            // Section D - Pengolahan (10 questions)
            for ($i = 1; $i <= 10; $i++) {
                $updateData['q_pengolahan_' . $i] = $request->input('tD' . $i);
                $updateData['q_keterangan_pengolahan_' . $i] = $request->input('tD' . $i . chr(96 + $i));
            }
            
            // Section E - Penggolongan Sampah (9 questions)
            for ($i = 1; $i <= 9; $i++) {
                $updateData['q_penggolongan_sampah_' . $i] = $request->input('tE' . $i);
                $updateData['q_keterangan_penggolongan_sampah_' . $i] = $request->input('tE' . $i . chr(96 + $i));
            }
            
            // Calculate total score
            $totalScore = 0;
            
            // Add up scores from section A
            for ($i = 1; $i <= 10; $i++) {
                $totalScore += (int)$request->input('tA' . $i);
            }
            
            // Add up scores from section B
            for ($i = 1; $i <= 9; $i++) {
                $totalScore += (int)$request->input('tB' . $i);
            }
            
            // Add up scores from section C
            for ($i = 1; $i <= 10; $i++) {
                $totalScore += (int)$request->input('tC' . $i);
            }
            
            // Add up scores from section D
            for ($i = 1; $i <= 10; $i++) {
                $totalScore += (int)$request->input('tD' . $i);
            }
            
            // Add up scores from section E
            for ($i = 1; $i <= 9; $i++) {
                $totalScore += (int)$request->input('tE' . $i);
            }
            
            // Determine conclusion based on total score
            $conclusion = '';
            if ($totalScore >= 432) {
                $conclusion = 'Sangat Baik';
            } elseif ($totalScore >= 336) {
                $conclusion = 'Baik';
            } elseif ($totalScore >= 240) {
                $conclusion = 'Cukup';
            } else {
                $conclusion = 'Kurang';
            }
            
            // Add total score and conclusion to update data
            $updateData['total_score'] = $totalScore;
            $updateData['conclusion'] = $conclusion;
            
            // Log the data being updated
            Log::info('Updating inspeksi catering with data: ' . json_encode($updateData));
            
            // Perform the update
            DB::table('FM_SHE_048_INSPEKSI_CATERING')
                ->where('id', $id)
                ->update($updateData);
                
            // Commit the transaction
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Data berhasil diupdate',
                'data' => [
                    'id' => $id,
                    'total_score' => $totalScore,
                    'conclusion' => $conclusion
                ]
            ]);
            
        } catch (Exception $e) {
            // Rollback the transaction
            DB::rollBack();
            
            // Log the error
            Log::error('Error in UpdateInspeksiCatering: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function DeleteInspeksiCatering(Request $request)
    {
        try {
            Log::info('DeleteInspeksiCatering request data:', $request->all());
            
            $id = $request->id;
            
            if (empty($id)) {
                return response()->json([
                    'success' => false,
                    'message' => 'ID is required'
                ], 400);
            }
            
            DB::beginTransaction();
            
            try {
                // Delete the record
                $deleted = DB::table('FM_SHE_048_INSPEKSI_CATERING')
                    ->where('id', $id)
                    ->delete();
                    
                if ($deleted == 0) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Record not found'
                    ], 404);
                }
                
                DB::commit();
                
                return response()->json([
                    'success' => true,
                    'message' => 'Record successfully deleted'
                ]);
            } catch (Exception $e) {
                DB::rollBack();
                throw $e;
            }
        } catch (Exception $e) {
            Log::error('Error in DeleteInspeksiCatering: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function Approve(Request $request)
    {
        try {
            // Add detailed logging for debugging
            Log::info('Approve request data:', $request->all());
            
            DB::beginTransaction();
            
            $id = $request->id;
            $position = (int)($request->position ?? 0); // Ensure position is an integer
            $nik = session('user_id');
            $username = session('username');
            
            if (empty($id)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Missing record ID'
                ], 400);
            }
            
            // Log the current user info
            Log::info("Approval attempt by user: $nik ($username) for position: $position on record: $id");
            
            // Get existing record
            $data = DB::table('FM_SHE_048_INSPEKSI_CATERING')
                ->where('id', $id)
                ->first();
                
            if (!$data) {
                Log::error("Record not found for ID: $id");
                return response()->json([
                    'success' => false,
                    'message' => 'Record not found'
                ], 404);
            }
            
            // Initialize status array
            $currentStatus = [null, null, null];
            
            // Try to parse existing status if it exists
            if (!empty($data->status)) {
                try {
                    $decoded = json_decode($data->status, true);
                    if (is_array($decoded) && count($decoded) == 3) {
                        $currentStatus = $decoded;
                    }
                } catch (\Exception $e) {
                    Log::error("Error decoding status JSON: " . $e->getMessage());
                    // Keep default array if there's an error
                }
            }
            
            // Update the status for this position
            $currentStatus[$position] = 'approved';
            
            // Prepare the update data - ONLY update the fields that exist
            $updateData = [
                'status' => json_encode($currentStatus)
            ];
            
            // Set the approver information based on position - REMOVED name columns
            if ($position === 0) {
                $updateData['diinspeksi_oleh_1'] = $nik;
            } else if ($position === 1) {
                $updateData['diinspeksi_oleh_2'] = $nik;
            } else if ($position === 2) {
                $updateData['diinspeksi_oleh_3'] = $nik;
            }
            
            // Log the data being updated
            Log::info("Updating record with data:", $updateData);
            
            // Update the record
            DB::table('FM_SHE_048_INSPEKSI_CATERING')
                ->where('id', $id)
                ->update($updateData);
                
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Approval successful'
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error in Approve: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
    
    public function Reject(Request $request)
    {
        try {
            // Log request data for debugging
            Log::info('Reject request data:', $request->all());
            
            DB::beginTransaction();
            
            $id = $request->id;
            $position = (int)($request->position ?? 0);
            $nik = session('user_id');
            $username = session('username');
            
            if (empty($id)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Missing record ID'
                ], 400);
            }
            
            // Get existing record
            $data = DB::table('FM_SHE_048_INSPEKSI_CATERING')
                ->where('id', $id)
                ->first();
                
            if (!$data) {
                Log::error("Record not found for ID: $id");
                return response()->json([
                    'success' => false,
                    'message' => 'Record not found'
                ], 404);
            }
            
            // Initialize status array
            $currentStatus = [null, null, null];
            
            // Try to parse existing status if it exists
            if (!empty($data->status)) {
                try {
                    $decoded = json_decode($data->status, true);
                    if (is_array($decoded) && count($decoded) == 3) {
                        $currentStatus = $decoded;
                    }
                } catch (\Exception $e) {
                    Log::error("Error decoding status JSON: " . $e->getMessage());
                    // Keep default array if there's an error
                }
            }
            
            // Update the status for this position
            $currentStatus[$position] = 'rejected';
            
            // Prepare the update data
            $updateData = [
                'status' => json_encode($currentStatus)
            ];

            // Set the approver information based on position - REMOVED name columns
            if ($position === 0) {
                $updateData['diinspeksi_oleh_1'] = $nik;
            } else if ($position === 1) {
                $updateData['diinspeksi_oleh_2'] = $nik;
            } else if ($position === 2) {
                $updateData['diinspeksi_oleh_3'] = $nik;
            }
            
            // Log the data being updated
            Log::info("Updating record with data:", $updateData);
            
            // Update the record
            DB::table('FM_SHE_048_INSPEKSI_CATERING')
                ->where('id', $id)
                ->update($updateData);
                
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Rejection successful'
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error in Reject: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
    
    public function Reset(Request $request, $id)
    {
        try {
            Log::info('Reset request for record ID: ' . $id);
            
            DB::beginTransaction();
            
            // Check if record exists
            $data = DB::table('FM_SHE_048_INSPEKSI_CATERING')
                ->where('id', $id)
                ->first();
                
            if (!$data) {
                Log::error("Record not found for ID: $id");
                return response()->json([
                    'success' => false,
                    'message' => 'Record not found'
                ], 404);
            }
            
            // Reset status to all nulls
            $updateData = [
                'status' => json_encode([null, null, null]),
                'diinspeksi_oleh_1' => null,
                'diinspeksi_oleh_2' => null,
                'diinspeksi_oleh_3' => null
            ];
            
            Log::info("Resetting approval status for record ID: $id");
            
            // Update the record
            DB::table('FM_SHE_048_INSPEKSI_CATERING')
                ->where('id', $id)
                ->update($updateData);
                
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Approval status reset successfully'
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error in Reset: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
}
