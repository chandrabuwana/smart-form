<?php

namespace Modules\SmartForm\App\Http\Controllers\SHE;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Modules\SmartForm\helpers\HrdHelper;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Validation\ValidationException;

class P3KController extends Controller
{
    private $p3kItems = [
        ['id' => 1, 'name' => 'Kasa steril terbungkus', 'qty' => 20],
        ['id' => 2, 'name' => 'Perban (lebar 5 cm)', 'qty' => 2],
        ['id' => 3, 'name' => 'Perban (lebar 10 cm)', 'qty' => 2],
        ['id' => 4, 'name' => 'Plester (lebar 1,25 cm)', 'qty' => 2],
        ['id' => 5, 'name' => 'Plester Cepat', 'qty' => 10],
        ['id' => 6, 'name' => 'Kapas (25 gram)', 'qty' => 1],
        ['id' => 7, 'name' => 'Kain segitiga/ mittela', 'qty' => 2],
        ['id' => 8, 'name' => 'Gunting', 'qty' => 1],
        ['id' => 9, 'name' => 'Peniti', 'qty' => 12],
        ['id' => 10, 'name' => 'Sarung tangan sekali pakai', 'qty' => 2],
        ['id' => 11, 'name' => 'Masker', 'qty' => 2],
        ['id' => 12, 'name' => 'Pinset', 'qty' => 1],
        ['id' => 13, 'name' => 'Lampu senter', 'qty' => 1],
        ['id' => 14, 'name' => 'Gelas untuk cuci mata', 'qty' => 1],
        ['id' => 15, 'name' => 'Kantong plastik bersih', 'qty' => 1],
        ['id' => 16, 'name' => 'Aquades (100 ml lar. Saline)', 'qty' => 1],
        ['id' => 17, 'name' => 'Povidon Iodin (60 ml)', 'qty' => 1],
        ['id' => 18, 'name' => 'Alkohol 70%', 'qty' => 1],
        ['id' => 19, 'name' => 'Buku panduan P3K di tempat kerja', 'qty' => 1],
        ['id' => 20, 'name' => 'Buku catatan', 'qty' => 1],
        ['id' => 21, 'name' => 'Daftar isi kotak', 'qty' => 1],
    ];

    private $itemThresholds = [
        'kasa_steril' => 5,      // Alert when less than 5 sterile gauze
        'perban' => 1,           // Alert when less than 1 bandage
        'plester' => 2,          // Alert when less than 2 plasters
        'sarung_tangan' => 1,    // Alert when less than 1 pair of gloves
    ];

    public function Dashboard(Request $request)
    {
        try {
            // Get current user ID from session
            $currentUserId = session('user_id') ?? '';

            // Base query for records
            $query = DB::table('she_p3k')
                ->select([
                    'she_p3k.*',
                    DB::raw('FORMAT(inspection_date, \'yyyy-MM-dd\') as formatted_date'),
                    DB::raw('CASE WHEN 
                        EXISTS (
                            SELECT 1 FROM OPENJSON(items_data)
                            WITH (
                                current_qty int \'$.current_qty\',
                                qty int \'$.qty\'
                            )
                            WHERE current_qty < qty
                        )
                        THEN 1 ELSE 0 END as need_restock'),
                    DB::raw('(
                        SELECT STRING_AGG(name, \', \')
                        FROM OPENJSON(items_data)
                        WITH (
                            name nvarchar(100) \'$.name\',
                            current_qty int \'$.current_qty\',
                            qty int \'$.qty\'
                        )
                        WHERE current_qty < qty
                    ) as low_stock_items'),
                    'she_p3k.approval_status'
                ]);

            // Apply filters
            if ($request->filled('search')) {
                $searchTerm = $request->search;
                $query->where(function($q) use ($searchTerm) {
                    $q->where('doc_number', 'like', '%' . $searchTerm . '%')
                        ->orWhere('location', 'like', '%' . $searchTerm . '%')
                        ->orWhere('created_by', 'like', '%' . $searchTerm . '%')
                        ->orWhere('items_data', 'like', '%' . $searchTerm . '%')
                        ->orWhere('inspector_1_name', 'like', '%' . $searchTerm . '%')
                        ->orWhere('inspector_2_name', 'like', '%' . $searchTerm . '%')
                        ->orWhere('supervisor_name', 'like', '%' . $searchTerm . '%')
                        ->orWhere('dh_name', 'like', '%' . $searchTerm . '%')
                        ->orWhere('she_name', 'like', '%' . $searchTerm . '%');
                });
            }

            if ($request->filled('start_date')) {
                $query->whereDate('inspection_date', '>=', $request->start_date);
            }

            if ($request->filled('end_date')) {
                $query->whereDate('inspection_date', '<=', $request->end_date);
            }

            if ($request->filled('location')) {
                $query->where('location', $request->location);
            }

            if ($request->filled('approval_status')) {
                switch ($request->approval_status) {
                    case 'pending':
                        $query->where('approval_status', 'pending');
                        break;
                    case 'in_progress':
                        $query->where('approval_status', 'in_progress');
                        break;
                    case 'approved':
                        $query->where('approval_status', 'approved');
                        break;
                    case 'rejected':
                        $query->where('approval_status', 'rejected');
                        break;
                    case 'inspector_1':
                        $query->where('inspector_1_status', 'approved')
                              ->where('inspector_2_status', 'pending');
                        break;
                    case 'inspector_2':
                        $query->where('inspector_2_status', 'approved')
                              ->where('supervisor_status', 'pending');
                        break;
                    case 'supervisor':
                        $query->where('supervisor_status', 'approved')
                              ->where('dh_status', 'pending');
                        break;
                    case 'dh':
                        $query->where('dh_status', 'approved')
                              ->where('she_status', 'pending');
                        break;
                }
            }

            if ($request->filled('status')) {
                if ($request->status === 'need_restock') {
                    $query->whereRaw('EXISTS (
                        SELECT 1 FROM OPENJSON(items_data)
                        WITH (
                            current_qty int \'$.current_qty\',
                            qty int \'$.qty\'
                        )
                        WHERE current_qty < qty
                    )');
                } elseif ($request->status === 'complete') {
                    $query->whereRaw('NOT EXISTS (
                        SELECT 1 FROM OPENJSON(items_data)
                        WITH (
                            current_qty int \'$.current_qty\',
                            qty int \'$.qty\'
                        )
                        WHERE current_qty < qty
                    )');
                }
            }

            // Get statistics
            $statistics = new \stdClass();
            
            // Total records
            $statistics->total_records = DB::table('she_p3k')->count();
            
            // Records this month
            $statistics->total_this_month = DB::table('she_p3k')
                ->whereYear('inspection_date', now()->year)
                ->whereMonth('inspection_date', now()->month)
                ->count();
            
            // Unique locations count
            $statistics->locations_count = DB::table('she_p3k')
                ->distinct()
                ->count('location');
            
            // Records needing restock
            $statistics->need_restock = DB::table('she_p3k')
                ->whereRaw('EXISTS (
                    SELECT 1 FROM OPENJSON(items_data)
                    WITH (
                        current_qty int \'$.current_qty\',
                        qty int \'$.qty\'
                    )
                    WHERE current_qty < qty
                )')
                ->count();

            // Pending approvals
            $statistics->pending_approvals = DB::table('she_p3k')
                ->where('approval_status', 'pending')
                ->count();
            
            // Get critical items (items below threshold)
            $statistics->critical_items = DB::table('she_p3k')
                ->whereRaw('EXISTS (
                    SELECT 1 FROM OPENJSON(items_data)
                    WITH (
                        current_qty int \'$.current_qty\'
                    )
                    WHERE current_qty <= ?
                )', [min($this->itemThresholds)])
                ->count();

            // Get unique locations for filter
            $locations = DB::table('she_p3k')
                ->select('location')
                ->distinct()
                ->whereNotNull('location')
                ->orderBy('location')
                ->pluck('location');

            // Get paginated records
            $records = $query->orderBy('created_at', 'desc')
                           ->paginate(10)
                           ->withQueryString();
            
            // Process records to add approval information
            foreach ($records as $record) {
                // Add approval info for the current user
                $approvalInfo = $this->getUserApprovalInfo($record, $currentUserId);
                $record->user_approval_info = $approvalInfo;
                
                // Check if this user can approve this record
                $record->can_approve = $approvalInfo['is_approver'] && $approvalInfo['status'] === 'pending';
                
                // Determine if we should show approval button based on workflow
                $record->show_approval_button = false;
                
                if ($record->can_approve) {
                    // Inspector 1 can always approve if pending
                    if ($approvalInfo['role'] === 'inspector_1') {
                        $record->show_approval_button = true;
                    }
                    // Inspector 2 can approve if Inspector 1 has approved
                    else if ($approvalInfo['role'] === 'inspector_2' && $record->inspector_1_status === 'approved') {
                        $record->show_approval_button = true;
                    }
                    // Supervisor can approve if both inspectors have approved
                    else if ($approvalInfo['role'] === 'supervisor' && 
                             $record->inspector_1_status === 'approved' && 
                             $record->inspector_2_status === 'approved') {
                        $record->show_approval_button = true;
                    }
                    // Department Head can approve if supervisor has approved
                    else if ($approvalInfo['role'] === 'dh' && $record->supervisor_status === 'approved') {
                        $record->show_approval_button = true;
                    }
                    // SHE can approve if Department Head has approved
                    else if ($approvalInfo['role'] === 'she' && $record->dh_status === 'approved') {
                        $record->show_approval_button = true;
                    }
                }
            }

            // Prepare filter data
            $filters = [
                'search' => $request->search,
                'location' => $request->location,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'status' => $request->status,
                'approval_status' => $request->approval_status
            ];

            // Get latest inspection dates by location
            $latestInspections = DB::table('she_p3k')
                ->select('location', DB::raw('MAX(inspection_date) as last_inspection'))
                ->groupBy('location')
                ->get()
                ->keyBy('location');

            return view('SmartForm::she/p3k/dashboard', compact(
                'records',
                'statistics',
                'locations',
                'filters',
                'latestInspections',
                'currentUserId'
            ));

        } catch (\Exception $e) {
            Log::error('Error in P3K Dashboard: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
            return redirect()->back()->with('error', 'Failed to load dashboard data: ' . $e->getMessage());
        }
    }

    public function AddForm(Request $request)
    {
        try {
            if ($request->has('id')) {
                $record = DB::table('she_p3k')->where('id', $request->id)->first();

                if (!$record) {
                    return redirect()->route('she-p3k.dashboard')
                        ->with('error', 'Record not found');
                }

                $record->items_data = json_decode($record->items_data, true);

                return view('SmartForm::she/p3k/form', [
                    'isShowDetail' => true,
                    'record' => $record,
                    'p3kItems' => $this->p3kItems,
                    'approvalList' => HrdHelper::getApprovalList(),
                ]);
            }

            return view('SmartForm::she/p3k/form', [
                'isShowDetail' => false,
                'record' => null,
                'p3kItems' => $this->p3kItems,
                'approvalList' => HrdHelper::getApprovalList(),
            ]);

        } catch (\Exception $e) {
            Log::error('Error in AddForm: ' . $e->getMessage());
            return redirect()->route('she-p3k.dashboard')
                ->with('error', 'Failed to load form: ' . $e->getMessage());
        }
    }

    public function Store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'inspection_date' => 'required|date',
                'location' => 'required|string|max:255',
                'created_by' => 'required|string|max:255',
                'created_signature' => 'nullable|string',
                'created_date' => 'nullable|date',
                'inspector_1_name' => 'nullable|string|max:255',
                'inspector_1_nik' => 'nullable|string',
                'inspector_1_date' => 'nullable|date',
                'inspector_2_name' => 'nullable|string|max:255',
                'inspector_2_nik' => 'nullable|string',
                'inspector_2_date' => 'nullable|date',
                'supervisor_name' => 'nullable|string|max:255',
                'supervisor_nik' => 'nullable|string',
                'supervisor_date' => 'nullable|date',
                'dh_name' => 'nullable|string|max:255',
                'dh_nik' => 'nullable|string',
                'dh_date' => 'nullable|date',
                'she_name' => 'nullable|string|max:255',
                'she_nik' => 'nullable|string',
                'she_date' => 'nullable|date',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }

            DB::beginTransaction();

            try {
                // Generate document number
                $docNumber = $this->generateDocNumber();

                // Prepare items data
                $itemsData = [];
                $needsRestock = false;
                foreach ($this->p3kItems as $item) {
                    $itemId = $item['id'];
                    $currentQty = $request->input("qty_$itemId", 0);
                    $inStock = $request->boolean("stock_$itemId", false);
                    
                    if ($currentQty < $item['qty']) {
                        $needsRestock = true;
                    }

                    $itemsData[$itemId] = [
                        'name' => $item['name'],
                        'qty' => $item['qty'],
                        'current_qty' => $currentQty,
                        'in_stock' => $inStock,
                        'notes' => $request->input("notes_$itemId", '')
                    ];
                }

                // Create record
                $id = DB::table('she_p3k')->insertGetId([
                    'doc_number' => $docNumber,
                    'inspection_date' => $request->inspection_date,
                    'location' => $request->location,
                    'items_data' => json_encode($itemsData),
                    'created_by' => $request->created_by,
                    'created_signature' => $request->created_signature,
                    'created_date' => $request->created_date,
                    'inspector_1_name' => $request->inspector_1_name,
                    'inspector_1_nik' => $request->inspector_1_nik,
                    'inspector_1_date' => $request->inspector_1_date,
                    'inspector_1_status' => $request->inspector_1_status ?? 'pending',
                    'inspector_2_name' => $request->inspector_2_name,
                    'inspector_2_nik' => $request->inspector_2_nik,
                    'inspector_2_date' => $request->inspector_2_date,
                    'inspector_2_status' => $request->inspector_2_status ?? 'pending',
                    'supervisor_name' => $request->supervisor_name,
                    'supervisor_nik' => $request->supervisor_nik,
                    'supervisor_date' => $request->supervisor_date,
                    'supervisor_status' => $request->supervisor_status ?? 'pending',
                    'dh_name' => $request->dh_name,
                    'dh_nik' => $request->dh_nik,
                    'dh_date' => $request->dh_date,
                    'dh_status' => $request->dh_status ?? 'pending',
                    'she_name' => $request->she_name,
                    'she_nik' => $request->she_nik,
                    'she_date' => $request->she_date,
                    'she_status' => $request->she_status ?? 'pending',
                    // Set overall approval status
                    'approval_status' => $this->determineApprovalStatus($request),
                    'created_at' => now(),
                    'updated_at' => now()
                ]);

                // If any item needs restock, send notification
                if ($needsRestock) {
                    // You can implement notification logic here
                    Log::info("P3K inspection {$docNumber} at {$request->location} needs restock.");
                }

                DB::commit();
                
                return response()->json([
                    'success' => true,
                    'message' => 'Form inspeksi P3K berhasil disimpan.',
                    'id' => $id,
                    'needs_restock' => $needsRestock
                ]);

            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Error in P3K Store transaction: ' . $e->getMessage());
                throw $e;
            }

        } catch (\Exception $e) {
            Log::error('Error in P3K Store: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
            return response()->json([
                'success' => false,
                'message' => 'Failed to submit form: ' . $e->getMessage()
            ], 500);
        }
    }

    public function Update(Request $request, $id)
    {
        try {
            // Get current user from session
            $currentUsername = session('username') ?? '';
            
            if (empty($currentUsername)) {
                return redirect()->route('she-p3k.dashboard')
                    ->with('error', 'Please set your username first');
            }
            
            // Get the record
            $record = DB::table('she_p3k')->where('id', $id)->first();
            
            if (!$record) {
                return redirect()->route('she-p3k.dashboard')
                    ->with('error', 'Record not found');
            }
            
            // Check if user is the creator of the record
            if ($record->created_by !== $currentUsername) {
                return redirect()->route('she-p3k.dashboard')
                    ->with('error', 'You are not authorized to edit this record');
            }
            
            // Check if the record has any approvals
            if ($record->inspector_1_status === 'approved' || 
                $record->inspector_2_status === 'approved' || 
                $record->supervisor_status === 'approved' || 
                $record->dh_status === 'approved' || 
                $record->she_status === 'approved') {
                return redirect()->route('she-p3k.dashboard')
                    ->with('error', 'Cannot edit a record that has been approved');
            }
            
            $validator = Validator::make($request->all(), [
                'inspection_date' => 'required|date',
                'location' => 'required|string|max:255',
                'created_by' => 'required|string|max:255',
                'inspector_1_name' => 'required|string|max:255',
                'inspector_1_nik' => 'required|string',
                'inspector_1_date' => 'required|date',
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            DB::beginTransaction();

            try {
                // Prepare items data
                $itemsData = [];
                $needsRestock = false;
                foreach ($this->p3kItems as $item) {
                    $itemId = $item['id'];
                    $currentQty = $request->input("qty_$itemId", 0);
                    $inStock = $request->boolean("stock_$itemId", false);
                    
                    if ($currentQty < $item['qty']) {
                        $needsRestock = true;
                    }

                    $itemsData[$itemId] = [
                        'name' => $item['name'],
                        'qty' => $item['qty'],
                        'current_qty' => $currentQty,
                        'in_stock' => $inStock,
                        'notes' => $request->input("notes_$itemId", '')
                    ];
                }

                // Determine approval status - preserve current status unless there's a reason to change it
                $approvalStatus = $record->approval_status;
                
                // Update record
                DB::table('she_p3k')
                    ->where('id', $id)
                    ->update([
                        'inspection_date' => $request->inspection_date,
                        'location' => $request->location,
                        'items_data' => json_encode($itemsData),
                        'created_by' => $request->created_by,
                        'created_signature' => $request->created_signature,
                        'created_date' => $request->created_date,
                        'inspector_1_name' => $request->inspector_1_name,
                        'inspector_1_nik' => $request->inspector_1_nik,
                        'inspector_1_date' => $request->inspector_1_date,
                        'inspector_1_status' => $request->inspector_1_status ?? 'pending',
                        'inspector_2_name' => $request->inspector_2_name,
                        'inspector_2_nik' => $request->inspector_2_nik,
                        'inspector_2_date' => $request->inspector_2_date,
                        'inspector_2_status' => $request->inspector_2_status ?? 'pending',
                        'supervisor_name' => $request->supervisor_name,
                        'supervisor_nik' => $request->supervisor_nik,
                        'supervisor_date' => $request->supervisor_date,
                        'supervisor_status' => $request->supervisor_status ?? 'pending',
                        'dh_name' => $request->dh_name,
                        'dh_nik' => $request->dh_nik,
                        'dh_date' => $request->dh_date,
                        'dh_status' => $request->dh_status ?? 'pending',
                        'she_name' => $request->she_name,
                        'she_nik' => $request->she_nik,
                        'she_date' => $request->she_date,
                        'she_status' => $request->she_status ?? 'pending',
                        'approval_status' => $approvalStatus,
                        'updated_at' => now()
                    ]);

                DB::commit();
                
                return redirect()->route('she-p3k.dashboard')
                    ->with('success', 'P3K record updated successfully');
                    
            } catch (\Exception $e) {
                DB::rollback();
                Log::error('Error updating P3K record: ' . $e->getMessage());
                return redirect()->back()
                    ->with('error', 'Failed to update record: ' . $e->getMessage())
                    ->withInput();
            }
            
        } catch (\Exception $e) {
            Log::error('Error in Update: ' . $e->getMessage());
            return redirect()->route('she-p3k.dashboard')
                ->with('error', 'Failed to update record: ' . $e->getMessage());
        }
    }

    public function ExportForm($id)
    {
        try {
            $record = DB::table('she_p3k')
                ->select([
                    'she_p3k.*',
                    DB::raw('CONVERT(varchar, inspection_date, 23) as formatted_date'),
                    DB::raw('CASE WHEN 
                        EXISTS (
                            SELECT 1 FROM OPENJSON(items_data)
                            WITH (
                                current_qty int \'$.current_qty\',
                                qty int \'$.qty\'
                            )
                            WHERE current_qty < qty
                        )
                        THEN 1 ELSE 0 END as need_restock')
                ])
                ->where('id', $id)
                ->first();

            if (!$record) {
                return redirect()->route('she-p3k.dashboard')
                    ->with('error', 'Record not found');
            }

            $record->items_data = json_decode($record->items_data, true);

            // Group items by their status
            $itemsByStatus = [
                'need_restock' => [],
                'complete' => []
            ];

            foreach ($record->items_data as $itemId => $item) {
                if ($item['current_qty'] < $item['qty']) {
                    $itemsByStatus['need_restock'][] = $item;
                } else {
                    $itemsByStatus['complete'][] = $item;
                }
            }

            $data = [
                'record' => $record,
                'p3kItems' => $this->p3kItems,
                'itemsByStatus' => $itemsByStatus,
                'logo_path' => public_path('img/logo-ct-dark.png')
            ];

            $pdf = PDF::loadView('SmartForm::she/p3k/export-pdf', $data);
            
            // Set PDF options
            $pdf->setPaper('A4');
            $pdf->setOption([
                'dpi' => 150,
                'defaultFont' => 'sans-serif',
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true
            ]);

            $filename = 'p3k-inspection-' . str_replace('/', '-', $record->doc_number) . '.pdf';

            // Log export activity
            Log::info("P3K inspection report exported: {$record->doc_number}");

            return $pdf->download($filename);

        } catch (\Exception $e) {
            Log::error('Error in P3K ExportForm: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
            return redirect()->back()
                ->with('error', 'Failed to generate PDF: ' . $e->getMessage());
        }
    }

    private function generateDocNumber()
    {
        try {
            $prefix = 'BSS-FRM-SHE-035';
            $date = now()->format('dmY');
            
            // Get the latest sequence number for the current month
            $lastRecord = DB::table('she_p3k')
                ->whereDate('created_at', now())
                ->orderBy('created_at', 'desc')
                ->value('doc_number');

            $sequence = 1;
            if ($lastRecord && preg_match('/-(\d+)$/', $lastRecord, $matches)) {
                $sequence = intval($matches[1]) + 1;
            }

            return sprintf("%s-%s-%03d", $prefix, $date, $sequence);

        } catch (\Exception $e) {
            Log::error('Error generating doc number: ' . $e->getMessage());
            throw $e;
        }
    }

    private function determineApprovalStatus(Request $request)
    {
        // Default status is pending
        if (!$request->has('inspector_1_nik') && 
            !$request->has('inspector_2_nik') && 
            !$request->has('supervisor_nik') && 
            !$request->has('dh_nik') && 
            !$request->has('she_nik')) {
            return 'pending';
        }
        
        // If any approval is rejected, the whole form is rejected
        if (($request->inspector_1_status ?? '') === 'rejected' ||
            ($request->inspector_2_status ?? '') === 'rejected' ||
            ($request->supervisor_status ?? '') === 'rejected' ||
            ($request->dh_status ?? '') === 'rejected' ||
            ($request->she_status ?? '') === 'rejected') {
            return 'rejected';
        }
        
        // If SHE has approved, the form is fully approved
        if (($request->she_status ?? '') === 'approved') {
            return 'approved';
        }
        
        // If any approval is in progress, the form is in progress
        if (($request->inspector_1_status ?? '') === 'approved' ||
            ($request->inspector_2_status ?? '') === 'approved' ||
            ($request->supervisor_status ?? '') === 'approved' ||
            ($request->dh_status ?? '') === 'approved') {
            return 'in_progress';
        }
        
        // Otherwise, it's pending
        return 'pending';
    }

    /**
     * Check if the current user is an approver for a record
     * 
     * @param object $record The P3K record
     * @param string $userId The current user's ID
     * @return array Information about the user's approval role
     */
    private function getUserApprovalInfo($record, $userId)
    {
        if (empty($userId)) {
            return [
                'is_approver' => false,
                'role' => null,
                'status' => null
            ];
        }

        // Check each approver role
        if ($record->inspector_1_nik === $userId) {
            return [
                'is_approver' => true,
                'role' => 'inspector_1',
                'status' => $record->inspector_1_status
            ];
        }
        
        if ($record->inspector_2_nik === $userId) {
            return [
                'is_approver' => true,
                'role' => 'inspector_2',
                'status' => $record->inspector_2_status
            ];
        }
        
        if ($record->supervisor_nik === $userId) {
            return [
                'is_approver' => true,
                'role' => 'supervisor',
                'status' => $record->supervisor_status
            ];
        }
        
        if ($record->dh_nik === $userId) {
            return [
                'is_approver' => true,
                'role' => 'dh',
                'status' => $record->dh_status
            ];
        }
        
        if ($record->she_nik === $userId) {
            return [
                'is_approver' => true,
                'role' => 'she',
                'status' => $record->she_status
            ];
        }
        
        return [
            'is_approver' => false,
            'role' => null,
            'status' => null
        ];
    }

    /**
     * Approve a P3K record
     * 
     * @param Request $request
     * @param int $id Record ID
     * @param string $role Approver role
     * @return \Illuminate\Http\Response
     */
    public function Approve(Request $request, $id, $role)
    {
        try {
            // Get current user ID from session
            $currentUserId = session('user_id') ?? '';
            
            if (empty($currentUserId)) {
                return redirect()->route('she-p3k.dashboard')
                    ->with('error', 'Please set your ID first');
            }
            
            // Get the record
            $record = DB::table('she_p3k')->where('id', $id)->first();
            
            if (!$record) {
                return redirect()->route('she-p3k.dashboard')
                    ->with('error', 'Record not found');
            }
            
            // Check if user is the correct approver
            if ($record->{$role . '_nik'} !== $currentUserId) {
                return redirect()->route('she-p3k.dashboard')
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
                case 'supervisor':
                    $canApprove = $record->inspector_1_status === 'approved' && 
                                 $record->inspector_2_status === 'approved';
                    break;
                case 'dh':
                    $canApprove = $record->supervisor_status === 'approved';
                    break;
                case 'she':
                    $canApprove = $record->dh_status === 'approved';
                    break;
                default:
                    $canApprove = false;
            }
            
            if (!$canApprove) {
                return redirect()->route('she-p3k.dashboard')
                    ->with('error', 'Previous approvals must be completed first');
            }
            
            // Update the approval status
            $updateData = [
                $role . '_status' => 'approved',
                $role . '_date' => date('Y-m-d'), // Use simple date format
                'updated_at' => now()
            ];
            
            // Update overall approval status
            if ($role === 'she') {
                $updateData['approval_status'] = 'approved';
            } else {
                $updateData['approval_status'] = 'in_progress';
            }
            
            // Check if the same user is assigned to multiple roles and approve them all
            $this->approveAllUserRoles($record, $currentUserId, $role);
            
            DB::table('she_p3k')
                ->where('id', $id)
                ->update($updateData);
            
            return redirect()->route('she-p3k.dashboard')
                ->with('success', 'Record approved successfully');
            
        } catch (\Exception $e) {
            Log::error('Error in Approve: ' . $e->getMessage());
            return redirect()->route('she-p3k.dashboard')
                ->with('error', 'Failed to approve record: ' . $e->getMessage());
        }
    }
    
    /**
     * Approve all roles for a user with the same ID
     * 
     * @param object $record The P3K record
     * @param string $userId The current user's ID
     * @param string $currentRole The role being approved
     * @return void
     */
    private function approveAllUserRoles($record, $userId, $currentRole)
    {
        $roles = ['inspector_1', 'inspector_2', 'supervisor', 'dh', 'she'];
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
            
            // Skip the current role (it's handled in the main Approve method)
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
                    // Can approve if inspector_1 is approved or we're currently approving as inspector_1
                    $canApprove = $record->inspector_1_status === 'approved';
                    break;
                    
                case 'supervisor':
                    // Can approve if both inspectors are approved or we're approving as inspector_2 and inspector_1 is approved
                    $canApprove = ($record->inspector_1_status === 'approved' && $record->inspector_2_status === 'approved');
                    break;
                    
                case 'dh':
                    // Can approve if supervisor is approved or we're currently approving as supervisor
                    $canApprove = $record->supervisor_status === 'approved';
                    break;
                    
                case 'she':
                    // Can approve if dh is approved or we're currently approving as dh
                    $canApprove = $record->dh_status === 'approved';
                    break;
            }
            
            if ($canApprove) {
                $updateData[$role . '_status'] = 'approved';
                $updateData[$role . '_date'] = $dateNow;
                
                // Update the record object for sequential checks
                $record->{$role . '_status'} = 'approved';
                
                // If this is the SHE role, update the overall status
                if ($role === 'she') {
                    $updateData['approval_status'] = 'approved';
                }
            }
        }
        
        if (!empty($updateData)) {
            $updateData['updated_at'] = $now;
            DB::table('she_p3k')
                ->where('id', $record->id)
                ->update($updateData);
        }
    }

    /**
     * Approve all roles for a record at once
     * 
     * @param Request $request
     * @param int $id Record ID
     * @return \Illuminate\Http\Response
     */
    public function ApproveAll(Request $request, $id)
    {
        try {
            // Get current user ID from session
            $currentUserId = session('user_id') ?? '';
            
            if (empty($currentUserId)) {
                return redirect()->route('she-p3k.dashboard')
                    ->with('error', 'Please log in first');
            }
            
            // Get the record
            $record = DB::table('she_p3k')->where('id', $id)->first();
            
            if (!$record) {
                return redirect()->route('she-p3k.dashboard')
                    ->with('error', 'Record not found');
            }
            
            // Check if user is assigned to any role
            $userRoles = [];
            $roles = ['inspector_1', 'inspector_2', 'supervisor', 'dh', 'she'];
            
            foreach ($roles as $role) {
                if ($record->{$role . '_nik'} === $currentUserId) {
                    $userRoles[] = $role;
                }
            }
            
            if (empty($userRoles)) {
                return redirect()->route('she-p3k.dashboard')
                    ->with('error', 'You are not assigned to any role for this record');
            }
            
            // Approve all roles in sequence
            $now = now();
            $dateNow = $now->format('Y-m-d');
            $updateData = [];
            
            // First approve Inspector 1 if needed
            if (in_array('inspector_1', $userRoles) && $record->inspector_1_status !== 'approved') {
                $updateData['inspector_1_status'] = 'approved';
                $updateData['inspector_1_date'] = $dateNow;
            }
            
            // Then approve Inspector 2 if needed
            if (in_array('inspector_2', $userRoles) && $record->inspector_2_status !== 'approved') {
                $updateData['inspector_2_status'] = 'approved';
                $updateData['inspector_2_date'] = $dateNow;
            }
            
            // Then approve Supervisor if needed
            if (in_array('supervisor', $userRoles) && $record->supervisor_status !== 'approved') {
                $updateData['supervisor_status'] = 'approved';
                $updateData['supervisor_date'] = $dateNow;
            }
            
            // Then approve Department Head if needed
            if (in_array('dh', $userRoles) && $record->dh_status !== 'approved') {
                $updateData['dh_status'] = 'approved';
                $updateData['dh_date'] = $dateNow;
            }
            
            // Finally approve SHE if needed
            if (in_array('she', $userRoles) && $record->she_status !== 'approved') {
                $updateData['she_status'] = 'approved';
                $updateData['she_date'] = $dateNow;
                $updateData['approval_status'] = 'approved';
            } else if (!empty($updateData)) {
                $updateData['approval_status'] = 'in_progress';
            }
            
            if (!empty($updateData)) {
                $updateData['updated_at'] = $now;
                
                DB::table('she_p3k')
                    ->where('id', $record->id)
                    ->update($updateData);
                
                return redirect()->route('she-p3k.dashboard')
                    ->with('success', 'All your roles have been approved successfully');
            } else {
                return redirect()->route('she-p3k.dashboard')
                    ->with('info', 'No changes were made - all your roles are already approved');
            }
            
        } catch (\Exception $e) {
            Log::error('Error in ApproveAll: ' . $e->getMessage());
            return redirect()->route('she-p3k.dashboard')
                ->with('error', 'Failed to approve record: ' . $e->getMessage());
        }
    }

    /**
     * Delete a P3K record
     * 
     * @param int $id Record ID
     * @return \Illuminate\Http\Response
     */
    public function Delete($id)
    {
        try {
            // Get current user from session
            $currentUsername = session('username') ?? '';
            
            if (empty($currentUsername)) {
                return redirect()->route('she-p3k.dashboard')
                    ->with('error', 'Please set your username first');
            }
            
            // Get the record
            $record = DB::table('she_p3k')->where('id', $id)->first();
            
            if (!$record) {
                return redirect()->route('she-p3k.dashboard')
                    ->with('error', 'Record not found');
            }
            
            // Check if user is the creator of the record
            if ($record->created_by !== $currentUsername) {
                return redirect()->route('she-p3k.dashboard')
                    ->with('error', 'You are not authorized to delete this record');
            }
            
            // Check if the record has any approvals (only approved records cannot be deleted)
            if ($record->inspector_1_status === 'approved' || 
                $record->inspector_2_status === 'approved' || 
                $record->supervisor_status === 'approved' || 
                $record->dh_status === 'approved' || 
                $record->she_status === 'approved') {
                return redirect()->route('she-p3k.dashboard')
                    ->with('error', 'Cannot delete a record that has been approved');
            }
            
            // Delete the record (pending or rejected status are allowed to be deleted)
            DB::table('she_p3k')->where('id', $id)->delete();
            
            return redirect()->route('she-p3k.dashboard')
                ->with('success', 'Record deleted successfully');
            
        } catch (\Exception $e) {
            Log::error('Error in Delete: ' . $e->getMessage());
            return redirect()->route('she-p3k.dashboard')
                ->with('error', 'Failed to delete record: ' . $e->getMessage());
        }
    }

    /**
     * Set the current user's ID in the session
     * 
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function SetUserId(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->route('she-p3k.dashboard')
                ->with('error', 'Invalid ID provided');
        }

        // Store the ID in the session
        session(['user_id' => $request->user_id]);

        return redirect()->route('she-p3k.dashboard')
            ->with('success', 'User ID set successfully');
    }

    /**
     * Show the form for editing a P3K record
     * 
     * @param int $id Record ID
     * @return \Illuminate\Http\Response
     */
    public function EditForm($id)
    {
        try {
            // Get current user from session
            $currentUsername = session('username') ?? '';
            
            if (empty($currentUsername)) {
                return redirect()->route('she-p3k.dashboard')
                    ->with('error', 'Please set your username first');
            }
            
            // Get the record
            $record = DB::table('she_p3k')->where('id', $id)->first();
            
            if (!$record) {
                return redirect()->route('she-p3k.dashboard')
                    ->with('error', 'Record not found');
            }
            
            // Check if user is the creator of the record
            if ($record->created_by !== $currentUsername) {
                return redirect()->route('she-p3k.dashboard')
                    ->with('error', 'You are not authorized to edit this record');
            }
            
            // Check if the record has any approvals
            if ($record->inspector_1_status === 'approved' || 
                $record->inspector_2_status === 'approved' || 
                $record->supervisor_status === 'approved' || 
                $record->dh_status === 'approved' || 
                $record->she_status === 'approved') {
                return redirect()->route('she-p3k.dashboard')
                    ->with('error', 'Cannot edit a record that has been approved');
            }
            
            $record->items_data = json_decode($record->items_data, true);
            
            return view('SmartForm::she/p3k/edit-form', [
                'record' => $record,
                'p3kItems' => $this->p3kItems,
                'approvalList' => HrdHelper::getApprovalList(),
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error in EditForm: ' . $e->getMessage());
            return redirect()->route('she-p3k.dashboard')
                ->with('error', 'Failed to load edit form: ' . $e->getMessage());
        }
    }
}
