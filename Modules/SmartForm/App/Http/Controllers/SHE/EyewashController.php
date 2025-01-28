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

            return view('SmartForm::she/eyewash/dashboard', [
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
                    'maintenanceRecord' => $record
                ]);
            }

            return view('SmartForm::she/eyewash/form', [
                'isShowDetail' => false,
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
                'created_by' => 'required|string',
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

                // Create record
                DB::table('she_eyewash')->insert([
                    'doc_number' => $docNumber,
                    'inspection_date' => $request->inspection_date,
                    'location' => $request->location,
                    'monthly_data' => json_encode($monthlyData),
                    'notes' => $request->notes,
                    'created_by' => $request->created_by,
                    'created_at' => now(),
                    'updated_at' => now()
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
}