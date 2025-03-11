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
                    DB::raw('CASE 
                        WHEN she_signature IS NOT NULL THEN \'Approved\'
                        WHEN dh_signature IS NOT NULL THEN \'DH Approved\'
                        WHEN supervisor_signature IS NOT NULL THEN \'Supervisor Approved\'
                        WHEN inspector_signature IS NOT NULL THEN \'Inspector Approved\'
                        WHEN created_signature IS NOT NULL THEN \'Created Approved\'
                        ELSE \'Pending\'
                    END as approval_status')
                ]);

            // Apply filters
            if ($request->filled('search')) {
                $searchTerm = $request->search;
                $query->where(function($q) use ($searchTerm) {
                    $q->where('doc_number', 'like', '%' . $searchTerm . '%')
                        ->orWhere('location', 'like', '%' . $searchTerm . '%')
                        ->orWhere('created_by', 'like', '%' . $searchTerm . '%')
                        ->orWhere('items_data', 'like', '%' . $searchTerm . '%')
                        ->orWhere('inspector', 'like', '%' . $searchTerm . '%')
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
                        $query->whereNull('created_signature');
                        break;
                    case 'created':
                        $query->whereNotNull('created_signature')
                             ->whereNull('inspector_signature');
                        break;
                    case 'inspector':
                        $query->whereNotNull('inspector_signature')
                             ->whereNull('supervisor_signature');
                        break;
                    case 'supervisor':
                        $query->whereNotNull('supervisor_signature')
                             ->whereNull('dh_signature');
                        break;
                    case 'dh':
                        $query->whereNotNull('dh_signature')
                             ->whereNull('she_signature');
                        break;
                    case 'approved':
                        $query->whereNotNull('she_signature');
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
                ->whereNull('she_signature')
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
                'latestInspections'
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
                'inspector' => 'nullable|string|max:255',
                'inspector_signature' => 'nullable|string',
                'inspector_date' => 'nullable|date',
                'supervisor_name' => 'nullable|string|max:255',
                'supervisor_signature' => 'nullable|string',
                'supervisor_date' => 'nullable|date',
                'dh_name' => 'nullable|string|max:255',
                'dh_signature' => 'nullable|string',
                'dh_date' => 'nullable|date',
                'she_name' => 'nullable|string|max:255',
                'she_signature' => 'nullable|string',
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
                    'inspector' => $request->inspector,
                    'inspector_signature' => $request->inspector_signature,
                    'inspector_date' => $request->inspector_date,
                    'supervisor_name' => $request->supervisor_name,
                    'supervisor_signature' => $request->supervisor_signature,
                    'supervisor_date' => $request->supervisor_date,
                    'dh_name' => $request->dh_name,
                    'dh_signature' => $request->dh_signature,
                    'dh_date' => $request->dh_date,
                    'she_name' => $request->she_name,
                    'she_signature' => $request->she_signature,
                    'she_date' => $request->she_date,
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
            $validator = Validator::make($request->all(), [
                'inspection_date' => 'required|date',
                'location' => 'required|string|max:255',
                'created_by' => 'required|string|max:255',
                'created_signature' => 'nullable|string',
                'created_date' => 'nullable|date',
                'inspector' => 'nullable|string|max:255',
                'inspector_signature' => 'nullable|string',
                'inspector_date' => 'nullable|date',
                'supervisor_name' => 'nullable|string|max:255',
                'supervisor_signature' => 'nullable|string',
                'supervisor_date' => 'nullable|date',
                'dh_name' => 'nullable|string|max:255',
                'dh_signature' => 'nullable|string',
                'dh_date' => 'nullable|date',
                'she_name' => 'nullable|string|max:255',
                'she_signature' => 'nullable|string',
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
                $record = DB::table('she_p3k')->where('id', $id)->first();
                
                if (!$record) {
                    throw new \Exception('Record not found');
                }

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
                        'inspector' => $request->inspector,
                        'inspector_signature' => $request->inspector_signature,
                        'inspector_date' => $request->inspector_date,
                        'supervisor_name' => $request->supervisor_name,
                        'supervisor_signature' => $request->supervisor_signature,
                        'supervisor_date' => $request->supervisor_date,
                        'dh_name' => $request->dh_name,
                        'dh_signature' => $request->dh_signature,
                        'dh_date' => $request->dh_date,
                        'she_name' => $request->she_name,
                        'she_signature' => $request->she_signature,
                        'she_date' => $request->she_date,
                        'updated_at' => now()
                    ]);

                // If any item needs restock, send notification
                if ($needsRestock) {
                    Log::info("P3K inspection {$record->doc_number} at {$request->location} needs restock after update.");
                }

                DB::commit();
                
                return response()->json([
                    'success' => true,
                    'message' => 'Form inspeksi P3K berhasil diperbarui.',
                    'needs_restock' => $needsRestock
                ]);

            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Error in P3K Update transaction: ' . $e->getMessage());
                throw $e;
            }

        } catch (\Exception $e) {
            Log::error('Error in P3K Update: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
            return response()->json([
                'success' => false,
                'message' => 'Failed to update form: ' . $e->getMessage()
            ], 500);
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
            if ($lastRecord && preg_match('/-(\d+)$/', $lastRecord->doc_number, $matches)) {
                $sequence = intval($matches[1]) + 1;
            }

            return sprintf("%s-%s-%03d", $prefix, $date, $sequence);

        } catch (\Exception $e) {
            Log::error('Error generating doc number: ' . $e->getMessage());
            throw $e;
        }
    }
}
