<?php

namespace Modules\SmartForm\App\Http\Controllers\IT;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class PrinterFormController extends Controller
{
    private $deviceType = 'printer';

    public function IndexPrinterForm(Request $request)
    {
        $query = DB::table('it_fm_printer')
            ->select([
                'it_fm_printer.id',
                'it_fm_printer.doc_number',
                'it_fm_printer.doc_date',
                'it_fm_printer.nama',
                'it_fm_printer.nik',
                'it_fm_printer.dept',
                'it_fm_printer.site',
                'it_fm_printer.no_asset',
                'it_fm_printer.jenis_aset',
                'it_fm_printer.merk',
                'it_fm_printer.model',
                'it_fm_printer.created_at',
                DB::raw('(CASE 
                    WHEN case_casing_condition = \'rusak\' THEN 1 
                    ELSE 0 END +
                    CASE WHEN adaptor_condition = \'rusak\' THEN 1 
                    ELSE 0 END +
                    CASE WHEN kabel_power_condition = \'rusak\' THEN 1 
                    ELSE 0 END +
                    CASE WHEN paper_tray_condition = \'rusak\' THEN 1 
                    ELSE 0 END +
                    CASE WHEN ink_condition = \'rusak\' THEN 1 
                    ELSE 0 END +
                    CASE WHEN cartridge_condition = \'rusak\' THEN 1 
                    ELSE 0 END +
                    CASE WHEN lamp_indicator_condition = \'rusak\' THEN 1 
                    ELSE 0 END +
                    CASE WHEN touchscreen_condition = \'rusak\' THEN 1 
                    ELSE 0 END) as broken_components')
            ]);

        // Apply search filter if provided
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('nama', 'like', "%{$searchTerm}%")
                  ->orWhere('nik', 'like', "%{$searchTerm}%")
                  ->orWhere('no_asset', 'like', "%{$searchTerm}%");
            });
        }

        // Apply date range filter if provided
        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('doc_date', [$request->start_date, $request->end_date]);
        }

        // Apply site filter if provided
        if ($request->has('site') && $request->site !== 'all') {
            $query->where('site', $request->site);
        }

        // Get unique sites for filter dropdown
        $sites = DB::table('it_fm_printer')
            ->select('site')
            ->distinct()
            ->whereNotNull('site')
            ->pluck('site');

        // Get the paginated results
        $maintenanceRecords = $query
            ->orderBy('doc_date', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Calculate statistics
        $totalRecords = DB::table('it_fm_printer')->count();
        $brokenComponents = DB::table('it_fm_printer')
            ->where('case_casing_condition', 'rusak')
            ->orWhere('adaptor_condition', 'rusak')
            ->orWhere('kabel_power_condition', 'rusak')
            ->orWhere('paper_tray_condition', 'rusak')
            ->orWhere('ink_condition', 'rusak')
            ->orWhere('cartridge_condition', 'rusak')
            ->orWhere('lamp_indicator_condition', 'rusak')
            ->orWhere('touchscreen_condition', 'rusak')
            ->count();

        $currentMonth = now()->month;
        $currentYear = now()->year;
        $maintenanceThisMonth = DB::table('it_fm_printer')
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->count();

        $completedTasks = DB::table('it_fm_printer')
            ->selectRaw('SUM(CAST(software_update AS INT)) + 
                       SUM(CAST(print_test AS INT)) + 
                       SUM(CAST(scan_test AS INT)) + 
                       SUM(CAST(network_test AS INT)) + 
                       SUM(CAST(bluetooth_test AS INT)) + 
                       SUM(CAST(cable_test AS INT)) + 
                       SUM(CAST(toner_level AS INT)) as total_completed')
            ->first();

        $totalCompleted = $completedTasks->total_completed ?? 0;
        $completionRate = $totalRecords > 0 
            ? ($totalCompleted / ($totalRecords * 7)) * 100 
            : 0;

        $statistics = (object)[
            'total_records' => $totalRecords,
            'broken_components' => $brokenComponents,
            'maintenance_this_month' => $maintenanceThisMonth,
            'completion_rate' => round($completionRate, 2)
        ];

        return view("SmartForm::it/dashboard-printer", [
            'maintenanceRecords' => $maintenanceRecords,
            'sites' => $sites,
            'statistics' => $statistics,
            'filters' => [
                'search' => $request->search,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'site' => $request->site
            ]
        ]);
    }

    public function CreatePrinterForm(Request $request)
    {
        try {
            // If ID is provided, get maintenance data
            if ($request->has('id')) {
                $maintenanceRecord = DB::table('it_fm_printer')
                    ->select([
                        'it_fm_printer.*',
                        DB::raw('(CASE 
                            WHEN case_casing_condition = \'rusak\' THEN 1 
                            ELSE 0 END +
                            CASE WHEN adaptor_condition = \'rusak\' THEN 1 
                            ELSE 0 END +
                            CASE WHEN kabel_power_condition = \'rusak\' THEN 1 
                            ELSE 0 END +
                            CASE WHEN paper_tray_condition = \'rusak\' THEN 1 
                            ELSE 0 END +
                            CASE WHEN ink_condition = \'rusak\' THEN 1 
                            ELSE 0 END +
                            CASE WHEN cartridge_condition = \'rusak\' THEN 1 
                            ELSE 0 END +
                            CASE WHEN lamp_indicator_condition = \'rusak\' THEN 1 
                            ELSE 0 END +
                            CASE WHEN touchscreen_condition = \'rusak\' THEN 1 
                            ELSE 0 END) as broken_components')
                    ])
                    ->where('id', $request->id)
                    ->first();

                if (!$maintenanceRecord) {
                    return redirect()->route('it-ops.dashboard-printer')
                        ->with('error', 'Printer maintenance record not found');
                }

                return view("SmartForm::it/form-printer", [
                    'isShowDetail' => true,
                    'maintenanceRecord' => $maintenanceRecord
                ]);
            }

            // If no ID, show empty form
            return view("SmartForm::it/form-printer", [
                'isShowDetail' => false,
                'maintenanceRecord' => null
            ]);

        } catch (\Exception $e) {
            Log::error('Error in CreatePrinterForm: ' . $e->getMessage());
            return redirect()->route('it-ops.dashboard-printer')
                ->with('error', 'An error occurred while loading the form');
        }
    }

    public function SubmitPrinterForm(Request $request)
    {
        try {
            $validated = $request->validate([
                // Teknisi Information
                'nama' => 'required|string',
                'nik' => 'required|string',
                'dept' => 'required|string',
                'site' => 'required|string',

                // Asset Information
                'no_asset' => 'required|string',
                'jenis_aset' => 'required|string',
                'merk' => 'required|string',
                'model' => 'required|string',

                // Hardware Conditions
                'case_casing_condition' => 'required|in:baik,rusak',
                'adaptor_condition' => 'required|in:baik,rusak',
                'kabel_power_condition' => 'required|in:baik,rusak',
                'paper_tray_condition' => 'required|in:baik,rusak',
                'ink_condition' => 'required|in:baik,rusak',
                'cartridge_condition' => 'required|in:baik,rusak',
                'lamp_indicator_condition' => 'required|in:baik,rusak',
                'touchscreen_condition' => 'required|in:baik,rusak',

                // Maintenance Tasks
                'software_update' => 'nullable|boolean',
                'print_test' => 'nullable|boolean',
                'scan_test' => 'nullable|boolean',
                'network_test' => 'nullable|boolean',
                'bluetooth_test' => 'nullable|boolean',
                'cable_test' => 'nullable|boolean',
                'toner_level' => 'nullable|boolean',
            ]);

            DB::beginTransaction();
            $docNumber = $this->generateDocNumber();

            $printerMaintenance = DB::table('it_fm_printer')->insertGetId([
                'doc_number' => $docNumber,
                'nama' => $validated['nama'],
                'nik' => $validated['nik'],
                'dept' => $validated['dept'],
                'site' => $validated['site'],
                'no_asset' => $validated['no_asset'],
                'jenis_aset' => $validated['jenis_aset'],
                'merk' => $validated['merk'],
                'model' => $validated['model'],
                'case_casing_condition' => $validated['case_casing_condition'],
                'adaptor_condition' => $validated['adaptor_condition'],
                'kabel_power_condition' => $validated['kabel_power_condition'],
                'paper_tray_condition' => $validated['paper_tray_condition'],
                'ink_condition' => $validated['ink_condition'],
                'cartridge_condition' => $validated['cartridge_condition'],
                'lamp_indicator_condition' => $validated['lamp_indicator_condition'],
                'touchscreen_condition' => $validated['touchscreen_condition'],
                'software_update' => $validated['software_update'] ?? false,
                'print_test' => $validated['print_test'] ?? false,
                'scan_test' => $validated['scan_test'] ?? false,
                'network_test' => $validated['network_test'] ?? false,
                'bluetooth_test' => $validated['bluetooth_test'] ?? false,
                'cable_test' => $validated['cable_test'] ?? false,
                'toner_level' => $validated['toner_level'] ?? false,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Printer maintenance record has been created successfully',
                'data' => $printerMaintenance
            ]);

        } catch (ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while saving the printer maintenance record',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function ExportPrinter($id)
    {
        try {
            $maintenanceRecord = DB::table('it_fm_printer')
                ->select([
                    'it_fm_printer.*',
                    DB::raw('(CASE 
                        WHEN case_casing_condition = \'rusak\' THEN 1 
                        ELSE 0 END +
                        CASE WHEN adaptor_condition = \'rusak\' THEN 1 
                        ELSE 0 END +
                        CASE WHEN kabel_power_condition = \'rusak\' THEN 1 
                        ELSE 0 END +
                        CASE WHEN paper_tray_condition = \'rusak\' THEN 1 
                        ELSE 0 END +
                        CASE WHEN ink_condition = \'rusak\' THEN 1 
                        ELSE 0 END +
                        CASE WHEN cartridge_condition = \'rusak\' THEN 1 
                        ELSE 0 END +
                        CASE WHEN lamp_indicator_condition = \'rusak\' THEN 1 
                        ELSE 0 END +
                        CASE WHEN touchscreen_condition = \'rusak\' THEN 1 
                        ELSE 0 END) as broken_components')
                ])
                ->where('id', $id)
                ->first();

            if (!$maintenanceRecord) {
                return redirect()->route('it-ops.dashboard-printer')
                    ->with('error', 'Printer maintenance record not found');
            }

            $pdf = PDF::loadView('SmartForm::it/exports/printer-maintenance', [
                'record' => $maintenanceRecord
            ]);

            $filename = 'form-printer-' . str_replace('/', '-', $maintenanceRecord->doc_number) . '.pdf';

            return $pdf->download($filename);

        } catch (\Exception $e) {
            Log::error('Error in ExportPrinter: ' . $e->getMessage());
            return redirect()->route('it-ops.dashboard-printer')
                ->with('error', 'An error occurred while exporting the record');
        }
    }

    private function generateDocNumber()
    {
        try {
            $prefix = 'BSS-FRM-IT-013';
            $date = now()->format('dmY');
            
            // Get the latest sequence number for the current month
            $lastRecord = DB::table('it_fm_printer')
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
