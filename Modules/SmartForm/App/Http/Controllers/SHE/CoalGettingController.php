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

class CoalGettingController extends Controller
{
    public function Dashboard(Request $request)
    {
        try {
            $query = DB::table('she_coal_getting')
                ->select([
                    'she_coal_getting.*',
                    DB::raw('FORMAT(inspection_date, \'yyyy-MM-dd\') as formatted_date')
                ]);

            // Search functionality
            if ($request->has('search')) {
                $searchTerm = $request->search;
                $query->where(function($q) use ($searchTerm) {
                    $q->where('doc_number', 'like', '%' . $searchTerm . '%')
                        ->orWhere('location', 'like', '%' . $searchTerm . '%')
                        ->orWhere('area_pic', 'like', '%' . $searchTerm . '%')
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
            $locations = DB::table('she_coal_getting')
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
                'total_records' => DB::table('she_coal_getting')->count(),
                'total_this_month' => DB::table('she_coal_getting')
                    ->whereMonth('created_at', now()->month)
                    ->whereYear('created_at', now()->year)
                    ->count(),
                'locations_count' => $locations->count(),
                'need_attention' => DB::table('she_coal_getting')
                    ->whereJsonContains('checklist_items', 0) // Items marked as "Tidak"
                    ->count()
            ];

            return view('smartform::she/coal_getting/dashboard', [
                'records' => $records,
                'statistics' => (object)$statistics,
                'filter_options' => $filter_options,
                'filters' => [
                    'search' => $request->search,
                    'start_date' => $request->start_date,
                    'end_date' => $request->end_date,
                    'location' => $request->location,
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
                $record = DB::table('she_coal_getting')->where('id', $request->id)->first();

                if (!$record) {
                    Log::error('Coal Getting record not found for ID: ' . $request->id);
                    return redirect()->route('she.coal.dashboard')
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

                // Decode checklist items
                $record->checklist_items = json_decode($record->checklist_items, true);

                return view('smartform::she/coal_getting/form', [
                    'isShowDetail' => true,
                    'record' => $record,
                    'checklistItems' => $this->getChecklistItems()
                ]);
            }

            // For new record
            return view('smartform::she/coal_getting/form', [
                'isShowDetail' => false,
                'record' => null,
                'checklistItems' => $this->getChecklistItems()
            ]);
        } catch (\Exception $e) {
            Log::error('Error in AddForm: ' . $e->getMessage());
            return redirect()->route('she.coal.dashboard')
                ->with('error', 'Failed to load form: ' . $e->getMessage());
        }
    }

    public function Store(Request $request)
    {
        try {
            Log::info('Processing Coal Getting form submission');

            $validator = Validator::make($request->all(), [
                'inspection_date' => 'required|date',
                'location' => 'required|string',
                'area_pic' => 'required|string',
                'created_by' => 'required|string',
                'acknowledged_by' => 'required|string',
                'checklist' => 'required|array',
                'checklist.*' => 'required',
            ]);

            if ($validator->fails()) {
                Log::warning('Validation failed: ' . json_encode($validator->errors()));
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            DB::beginTransaction();

            try {
                // Generate document number
                $docNumber = $this->generateDocNumber();

                // Process checklist items and notes
                $checklistItems = [];
                if (!empty($request->checklist)) {
                    foreach ($request->checklist as $index => $value) {
                        if (is_array($value)) {
                            // Handle subitems (like Kebersihan Front Loading)
                            $checklistItems[$index] = [];
                            foreach ($value as $subIndex => $subValue) {
                                $checklistItems[$index][$subIndex] = [
                                    'value' => $subValue,
                                    'notes' => $request->notes[$index][$subIndex] ?? null
                                ];
                            }
                        } else {
                            // Handle regular items
                            $checklistItems[$index] = [
                                'value' => $value,
                                'notes' => $request->notes[$index] ?? null
                            ];
                        }
                    }
                }

                if (empty($checklistItems)) {
                    throw new \Exception('Checklist items cannot be empty');
                }

                // Insert the record
                DB::table('she_coal_getting')->insert([
                    'doc_number' => $docNumber,
                    'inspection_date' => $request->inspection_date,
                    'location' => $request->location,
                    'area_pic' => $request->area_pic,
                    'checklist_items' => json_encode($checklistItems),
                    'created_by' => $request->created_by,
                    'acknowledged_by' => $request->acknowledged_by,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                DB::commit();
                
                return response()->json([
                    'success' => true,
                    'message' => 'Data berhasil disimpan'
                ]);

            } catch (\Exception $e) {
                DB::rollback();
                Log::error('Error in transaction: ' . $e->getMessage());
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage()
                ], 500);
            }
        } catch (\Exception $e) {
            Log::error('Error in form submission: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem'
            ], 500);
        }
    }

    public function ExportForm($id)
    {
        try {
            $record = DB::table('she_coal_getting')->where('id', $id)->first();

            if (!$record) {
                return redirect()->back()->with('error', 'Record not found');
            }

            $record->checklist_items = json_decode($record->checklist_items, true);

            $pdf = PDF::loadView('smartform::she/coal_getting/export-pdf', [
                'record' => $record,
                'checklistItems' => $this->getChecklistItems()
            ]);

            // Set paper size and orientation
            $pdf->setPaper('A4', 'portrait');

            return $pdf->download('coal-getting-inspection-' . $record->doc_number . '.pdf');
            // return $pdf->stream('coal-getting-inspection-' . $record->doc_number . '.pdf');

        } catch (\Exception $e) {
            Log::error('Error in ExportPdf: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to generate PDF: ' . $e->getMessage());
        }
    }

    private function generateDocNumber()
    {
        $prefix = 'CBSS-FRM-PRO-001';
        $year = date('Y');
        $month = date('m');
        
        // Get the last document number for this month
        $lastDoc = DB::table('she_coal_getting')
            ->where('doc_number', 'like', $prefix . '/' . $year . '/' . $month . '/%')
            ->orderBy('doc_number', 'desc')
            ->first();

        if ($lastDoc) {
            // Extract the sequence number and increment it
            $lastSequence = (int) substr($lastDoc->doc_number, -3);
            $newSequence = $lastSequence + 1;
        } else {
            $newSequence = 1;
        }

        // Format: CG/YYYY/MM/001
        return sprintf('%s-%s-%s-%03d', $prefix, $year, $month, $newSequence);
    }

    private function getChecklistItems()
    {
        return [
            'Pengawas melakukan validasi P2H fleet coal getting',
            'Operator sudah mendapatkan edukasi coal quality',
            'Kebersihan Track shoe Excavator',
            'Teeth Bucket dalam kondisi baik/normal',
            'Tidak ada kebocoran oli/solar unit',
            'Kebersihan bak unit hauler',
            'Tidak ada potensi komponen unit hauler terlepas',
            'Batubara ter expose',
            'Cleaning batubara menggunakan cutting edge',
            'Cleaning area offset roof dan floor min 1 meter',
            'Batubara sudah di cleaning',
            'Size batubara sesuai keinginan customer',
            [
                'title' => 'Kebersihan Front Loading',
                'subitems' => [
                    'a. tanah',
                    'b. lumpur',
                    'c. parting',
                    'd. sampah'
                ]
            ],
            'Drainase area loading point',
            'Penanganan parting (penanganan batas dan pengerjaan pada siang hari)',
            'penerangan pada malam hari',
            'Pengukuran data roof dan floor'
        ];
    }
}