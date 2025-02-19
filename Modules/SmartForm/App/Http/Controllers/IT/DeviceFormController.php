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

class DeviceFormController extends Controller
{
    private $deviceType = 'device';

    public function IndexDeviceForm(Request $request)
    {
      $query = DB::table('it_fm_device')
            ->select([
                'it_fm_device.*',
                DB::raw('(CASE 
                    WHEN case_casing_condition = \'rusak\' THEN 1 
                    ELSE 0 END +
                    CASE WHEN touchscreen_condition = \'rusak\' THEN 1 
                    ELSE 0 END +
                    CASE WHEN mouse_condition = \'rusak\' THEN 1 
                    ELSE 0 END +
                    CASE WHEN adaptor_condition = \'rusak\' THEN 1 
                    ELSE 0 END +
                    CASE WHEN monitor_condition = \'rusak\' THEN 1 
                    ELSE 0 END +
                    CASE WHEN keyboard_condition = \'rusak\' THEN 1 
                    ELSE 0 END +
                    CASE WHEN port_usb_condition = \'rusak\' THEN 1 
                    ELSE 0 END +
                    CASE WHEN webcam_condition = \'rusak\' THEN 1 
                    ELSE 0 END +
                    CASE WHEN display_condition = \'rusak\' THEN 1  
                    ELSE 0 END +
                    CASE WHEN speaker_condition = \'rusak\' THEN 1  
                    ELSE 0 END +
                    CASE WHEN fan_processor_condition = \'rusak\' THEN 1  
                    ELSE 0 END +
                    CASE WHEN wireless_condition = \'rusak\' THEN 1  
                    ELSE 0 END +
                    CASE WHEN mic_condition = \'rusak\' THEN 1  
                    ELSE 0 END +
                    CASE WHEN battery_condition = \'rusak\' THEN 1   
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
        $sites = DB::table('it_fm_device')
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
        $totalRecords = DB::table('it_fm_device')->count();
        $brokenComponents = DB::table('it_fm_device')
            ->where('case_casing_condition', 'rusak')
            ->orWhere('touchscreen_condition', 'rusak')
            ->orWhere('mouse_condition', 'rusak')
            ->orWhere('adaptor_condition', 'rusak')
            ->orWhere('monitor_condition', 'rusak')
            ->orWhere('keyboard_condition', 'rusak')
            ->orWhere('port_usb_condition', 'rusak')
            ->orWhere('webcam_condition', 'rusak')
            ->orWhere('display_condition', 'rusak')
            ->orWhere('speaker_condition', 'rusak')
            ->orWhere('fan_processor_condition', 'rusak')
            ->orWhere('wireless_condition', 'rusak')
            ->orWhere('mic_condition', 'rusak')
            ->orWhere('battery_condition', 'rusak')
            ->count();

        $currentMonth = now()->month;
        $currentYear = now()->year;
        $maintenanceThisMonth = DB::table('it_fm_device')
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->count();

        // $completedTasks = DB::table('it_fm_device')
        //     ->selectRaw('SUM(CAST(cover_area AS INT)) + 
        //                SUM(CAST(video_quality AS INT)) + 
        //                SUM(CAST(sound_quality AS INT)) + 
        //                SUM(CAST(remote_view_nvr AS INT)) + 
        //                SUM(CAST(remote_playback AS INT)) as total_completed')
        //     ->first();

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

        return view("SmartForm::it/dashboard-device", [
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

    public function CreateDeviceForm(Request $request)
    {
        try {
            // If ID is provided, get maintenance data
            if ($request->has('id')) {
                
                $maintenanceRecord = DB::table('it_fm_device')
                    ->select([
                        'it_fm_device.*',
                        DB::raw('(CASE 
                            WHEN case_casing_condition = \'rusak\' THEN 1 
                            ELSE 0 END +
                            CASE WHEN touchscreen_condition = \'rusak\' THEN 1 
                            ELSE 0 END +
                            CASE WHEN mouse_condition = \'rusak\' THEN 1 
                            ELSE 0 END +
                            CASE WHEN adaptor_condition = \'rusak\' THEN 1 
                            ELSE 0 END +
                            CASE WHEN monitor_condition = \'rusak\' THEN 1 
                            ELSE 0 END +
                            CASE WHEN keyboard_condition = \'rusak\' THEN 1 
                            ELSE 0 END +
                            CASE WHEN port_usb_condition = \'rusak\' THEN 1 
                            ELSE 0 END +
                            CASE WHEN webcam_condition = \'rusak\' THEN 1 
                            ELSE 0 END +
                            CASE WHEN display_condition = \'rusak\' THEN 1 
                            ELSE 0 END +
                            CASE WHEN speaker_condition = \'rusak\' THEN 1 
                            ELSE 0 END +
                            CASE WHEN fan_processor_condition = \'rusak\' THEN 1 
                            ELSE 0 END +
                            CASE WHEN wireless_condition = \'rusak\' THEN 1 
                            ELSE 0 END +
                            CASE WHEN mic_condition = \'rusak\' THEN 1 
                            ELSE 0 END +
                            CASE WHEN battery_condition = \'rusak\' THEN 1 
                            ELSE 0 END) as broken_components')
                    ])
                    ->where('id', $request->id)
                    ->first();

                if (!$maintenanceRecord) {
                    return redirect()->route('it-ops.dashboard-device')
                        ->with('error', 'Device maintenance record not found');
                }

                return view("SmartForm::it.form-device", [
                    'isShowDetail' => true,
                    'maintenanceRecord' => $maintenanceRecord
                ]);
            }

            // If no ID, show empty form
            return view("SmartForm::it.form-device", [
                'isShowDetail' => false,
                'maintenanceRecord' => null
            ]);

        } catch (\Exception $e) {
            Log::error('Error in CreateDeviceForm: ' . $e->getMessage());
            return redirect()->route('it-ops.dashboard-device')
                ->with('error', 'An error occurred while loading the form');
        }
    }

    public function SubmitDeviceForm(Request $request)
    {
      try {
        $validated = $request->validate([
            // Document Info
            'doc_number' => 'nullable|string',
            'revision' => 'nullable|integer',
            'doc_date' => 'nullable|date',

            // Teknisi Information
            'nama' => 'required|string',
            'nik' => 'required|string',
            'dept' => 'required|string',
            'site' => 'required|in:agm,mbl,mme,mas,pmss,taj,bssr,tdm,msj',

            // User Information
            'user_name' => 'required|string',
            'user_nik' => 'required|string',
            'user_dept' => 'required|string',
            'user_site' => 'required|in:agm,mbl,mme,mas,pmss,taj,bssr,tdm,msj',
            'user_no_asset' => 'required|string',

            // Device Information
            'jenis_aset' => 'required|string',
            'merk' => 'required|string',
            'model' => 'required|string',
            'tipe_aset' => 'required|string',
            'processor' => 'required|string',
            'ram' => 'required|string',
            'hdd' => 'required|string',
            'vga' => 'required|string',
            'os' => 'required|string',

            // Hardware Conditions
            'case_casing_condition' => 'required|in:baik,rusak',
            'touchscreen_condition' => 'required|in:baik,rusak',
            'mouse_condition' => 'required|in:baik,rusak',
            'adaptor_condition' => 'required|in:baik,rusak',
            'monitor_condition' => 'required|in:baik,rusak',
            'keyboard_condition' => 'required|in:baik,rusak',
            'port_usb_condition' => 'required|in:baik,rusak',
            'webcam_condition' => 'required|in:baik,rusak',
            'display_condition' => 'required|in:baik,rusak',
            'speaker_condition' => 'required|in:baik,rusak',
            'fan_processor_condition' => 'required|in:baik,rusak',
            'wireless_condition' => 'required|in:baik,rusak',
            'mic_condition' => 'required|in:baik,rusak',
            'battery_condition' => 'required|in:baik,rusak',

            // Maintenance Tasks
            'disk_defragment' => 'nullable|boolean',
            'driver_printer' => 'nullable|boolean',
            'clean_temp_file' => 'nullable|boolean',
            'unused_app' => 'nullable|boolean',
            'scan_antivirus' => 'nullable|boolean',
            'cleaning_fan_internal' => 'nullable|boolean',
            'clean_junk_file' => 'nullable|boolean',
            'brightness_level' => 'nullable|boolean',
            'speaker' => 'nullable|boolean',
            'wifi_connection' => 'nullable|boolean',
            'hdmi' => 'nullable|boolean',

            // Software Installed
            'has_ccleaner' => 'required|in:ada,tidak',
            'has_zoom' => 'required|in:ada,tidak',
            'has_sap' => 'required|in:ada,tidak',
            'has_microsoft_office' => 'required|in:ada,tidak',
            'has_anydesk' => 'required|in:ada,tidak',
            'has_sisoft' => 'required|in:ada,tidak',
            'has_erp' => 'required|in:ada,tidak',
            'has_vnc_remote' => 'required|in:ada,tidak',
            'has_minning_software' => 'required|in:ada,tidak',
            'has_pdf_viewer' => 'required|in:ada,tidak',
            'has_wepresent' => 'required|in:ada,tidak',
        ]);

        DB::beginTransaction();
        $docNumber = $this->generateDocNumber();

        $deviceMaintenance = DB::table('it_fm_device')->insertGetId([
            // Document Info
            'doc_number' => $docNumber,
            'revision' => $validated['revision'] ?? 0,
            'doc_date' => $validated['doc_date'] ?? now(),

            // Teknisi Information
            'nama' => $validated['nama'],
            'nik' => $validated['nik'],
            'dept' => $validated['dept'],
            'site' => $validated['site'],

            // User Information
            'user_name' => $validated['user_name'],
            'user_nik' => $validated['user_nik'],
            'user_dept' => $validated['user_dept'],
            'user_site' => $validated['user_site'],
            'user_no_asset' => $validated['user_no_asset'],

            // Device Information
            'jenis_aset' => $validated['jenis_aset'],
            'merk' => $validated['merk'],
            'model' => $validated['model'],
            'tipe_aset' => $validated['tipe_aset'],
            'processor' => $validated['processor'],
            'ram' => $validated['ram'],
            'hdd' => $validated['hdd'],
            'vga' => $validated['vga'],
            'os' => $validated['os'],
            
            // Hardware Conditions
            'case_casing_condition' => $validated['case_casing_condition'],
            'touchscreen_condition' => $validated['touchscreen_condition'],
            'mouse_condition' => $validated['mouse_condition'],
            'adaptor_condition' => $validated['adaptor_condition'],
            'monitor_condition' => $validated['monitor_condition'],
            'keyboard_condition' => $validated['keyboard_condition'],
            'port_usb_condition' => $validated['port_usb_condition'],
            'webcam_condition' => $validated['webcam_condition'],
            'display_condition' => $validated['display_condition'],
            'speaker_condition' => $validated['speaker_condition'],
            'fan_processor_condition' => $validated['fan_processor_condition'],
            'wireless_condition' => $validated['wireless_condition'],
            'mic_condition' => $validated['mic_condition'],
            'battery_condition' => $validated['battery_condition'],

            // Maintenance Tasks
            'disk_defragment' => $validated['disk_defragment'] ?? false,
            'driver_printer' => $validated['driver_printer'] ?? false,
            'clean_temp_file' => $validated['clean_temp_file'] ?? false,
            'unused_app' => $validated['unused_app'] ?? false,
            'scan_antivirus' => $validated['scan_antivirus'] ?? false,
            'cleaning_fan_internal' => $validated['cleaning_fan_internal'] ?? false,
            'clean_junk_file' => $validated['clean_junk_file'] ?? false,
            'brightness_level' => $validated['brightness_level'] ?? false,
            'speaker' => $validated['speaker'] ?? false,
            'wifi_connection' => $validated['wifi_connection'] ?? false,
            'hdmi' => $validated['hdmi'] ?? false,

            // Software Installed
            'has_ccleaner' => $validated['has_ccleaner'],
            'has_zoom' => $validated['has_zoom'],
            'has_sap' => $validated['has_sap'],
            'has_microsoft_office' => $validated['has_microsoft_office'],
            'has_anydesk' => $validated['has_anydesk'],
            'has_sisoft' => $validated['has_sisoft'],
            'has_erp' => $validated['has_erp'],
            'has_vnc_remote' => $validated['has_vnc_remote'],
            'has_minning_software' => $validated['has_minning_software'],
            'has_pdf_viewer' => $validated['has_pdf_viewer'],
            'has_wepresent' => $validated['has_wepresent'],
            
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::commit();

        return response()->json([
            'success' => true,
            'message' => 'Device maintenance record has been created successfully',
            'data' => $deviceMaintenance
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
            Log::error('Error in SubmitDeviceForm: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while saving the Device maintenance record',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function ExportDevice($id)
    {
        try {
            $maintenanceRecord = DB::table('it_fm_device')
                ->select([
                    'it_fm_device.*',
                    DB::raw('(CASE 
                        WHEN case_casing_condition = \'rusak\' THEN 1 
                        ELSE 0 END +
                        CASE WHEN touchscreen_condition = \'rusak\' THEN 1 
                        ELSE 0 END +
                        CASE WHEN mouse_condition = \'rusak\' THEN 1 
                        ELSE 0 END +
                        CASE WHEN adaptor_condition = \'rusak\' THEN 1 
                        ELSE 0 END +
                        CASE WHEN monitor_condition = \'rusak\' THEN 1 
                        ELSE 0 END +
                        CASE WHEN keyboard_condition = \'rusak\' THEN 1 
                        ELSE 0 END +
                        CASE WHEN port_usb_condition = \'rusak\' THEN 1 
                        ELSE 0 END +
                        CASE WHEN webcam_condition = \'rusak\' THEN 1 
                        ELSE 0 END +
                        CASE WHEN display_condition = \'rusak\' THEN 1 
                        ELSE 0 END +
                        CASE WHEN speaker_condition = \'rusak\' THEN 1 
                        ELSE 0 END +
                        CASE WHEN fan_processor_condition = \'rusak\' THEN 1 
                        ELSE 0 END +
                        CASE WHEN wireless_condition = \'rusak\' THEN 1 
                        ELSE 0 END +
                        CASE WHEN mic_condition = \'rusak\' THEN 1 
                        ELSE 0 END +
                        CASE WHEN battery_condition = \'rusak\' THEN 1 
                        ELSE 0 END) as broken_components')
                ])
                ->where('id', $id)
                ->first();

            if (!$maintenanceRecord) {
                return redirect()->route('it-ops.dashboard-device')
                    ->with('error', 'Device maintenance record not found');
            }
            
            $pdf = PDF::loadView('SmartForm::it.exports.device-maintenance', [
                'record' => $maintenanceRecord
            ]);

            $filename = 'form-device-' . str_replace('/', '-', $maintenanceRecord->doc_number) . '.pdf';
            
            
            return $pdf->download($filename);

        } catch (\Exception $e) {
            Log::error('Error in ExportDevice: ' . $e->getMessage());
            return redirect()->route('it-ops.dashboard-device')
                ->with('error', 'An error occurred while generating the PDF');
        }
    }

    private function generateDocNumber()
    {
        try {
            $prefix = 'BSS-FRM-IT-012';
            $date = now()->format('dmY');
            
            // Get the latest sequence number for the current month
            $lastRecord = DB::table('it_fm_device')
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
