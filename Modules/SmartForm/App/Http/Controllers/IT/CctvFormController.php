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

class CCTVFormController extends Controller
{
    private $deviceType = 'cctv';

    public function IndexCCTVForm(Request $request)
    {
        $query = DB::table('it_fm_cctv')
            ->select([
                'it_fm_cctv.*',
                DB::raw('(CASE 
                    WHEN camera_condition = \'rusak\' THEN 1 
                    ELSE 0 END +
                    CASE WHEN lens_condition = \'rusak\' THEN 1 
                    ELSE 0 END +
                    CASE WHEN cable_condition = \'rusak\' THEN 1 
                    ELSE 0 END +
                    CASE WHEN storage_cctv_condition = \'rusak\' THEN 1 
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
        $sites = DB::table('it_fm_cctv')
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
        $totalRecords = DB::table('it_fm_cctv')->count();
        $brokenComponents = DB::table('it_fm_cctv')
            ->where('camera_condition', 'rusak')
            ->orWhere('lens_condition', 'rusak')
            ->orWhere('cable_condition', 'rusak')
            ->orWhere('storage_cctv_condition', 'rusak')
            ->count();

        $currentMonth = now()->month;
        $currentYear = now()->year;
        $maintenanceThisMonth = DB::table('it_fm_cctv')
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->count();

        $completedTasks = DB::table('it_fm_cctv')
            ->selectRaw('SUM(CAST(cover_area AS INT)) + 
                       SUM(CAST(video_quality AS INT)) + 
                       SUM(CAST(sound_quality AS INT)) + 
                       SUM(CAST(remote_view_nvr AS INT)) + 
                       SUM(CAST(remote_playback AS INT)) as total_completed')
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

        return view("SmartForm::it/dashboard-cctv", [
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

    public function CreateCctvForm(Request $request)
    {
        try {
            // If ID is provided, get maintenance data
            if ($request->has('id')) {
                $maintenanceRecord = DB::table('it_fm_cctv')
                    ->where('id', $request->id)
                    ->first();

                if (!$maintenanceRecord) {
                    Log::error('CCTV maintenance record not found for ID: ' . $request->id);
                    return redirect()->route('it-ops.dashboard-cctv')
                        ->with('error', 'CCTV maintenance record not found');
                }

                Log::info('Record found, rendering detail view');
                return view("SmartForm::it.form-cctv", [
                    'isShowDetail' => true,
                    'maintenanceRecord' => $maintenanceRecord
                ]);
            }

            // If no ID, show empty form
            return view("SmartForm::it.form-cctv", [
                'isShowDetail' => false,
                'maintenanceRecord' => null
            ]);

        } catch (\Exception $e) {
            Log::error('Error in CreateCctvForm: ' . $e->getMessage());
            return redirect()->route('it-ops.dashboard-cctv')
                ->with('error', 'An error occurred while loading the form');
        }
    }

    public function SubmitCctvForm(Request $request)
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
                'area_cctv' => 'required|string',

                // Hardware Conditions
                'camera_condition' => 'required|in:baik,rusak',
                'lens_condition' => 'required|in:baik,rusak',
                'cable_condition' => 'required|in:baik,rusak',
                'storage_cctv_condition' => 'required|in:baik,rusak',

                // Maintenance Tasks
                'cover_area' => 'nullable|boolean',
                'video_quality' => 'nullable|boolean',
                'sound_quality' => 'nullable|boolean',
                'remote_view_nvr' => 'nullable|boolean',
                'remote_playback' => 'nullable|boolean',
            ]);

            DB::beginTransaction();
            
            $docNumber = $this->generateDocNumber();

            $cctvMaintenance = DB::table('it_fm_cctv')->insertGetId([
              'doc_number' => $docNumber,
              'nama' => $validated['nama'],
              'nik' => $validated['nik'],
              'dept' => $validated['dept'],
              'site' => $validated['site'],
              'no_asset' => $validated['no_asset'],
              'jenis_aset' => $validated['jenis_aset'],
              'merk' => $validated['merk'],
              'model' => $validated['model'],
              'area_cctv' => $validated['area_cctv'],
              'camera_condition' => $validated['camera_condition'],
              'lens_condition' => $validated['lens_condition'],
              'cable_condition' => $validated['cable_condition'],
              'storage_cctv_condition' => $validated['storage_cctv_condition'],
              'cover_area' => $validated['cover_area'] ?? false,
              'video_quality' => $validated['video_quality'] ?? false,
              'sound_quality' => $validated['sound_quality'] ?? false,
              'remote_view_nvr' => $validated['remote_view_nvr'] ?? false,
              'remote_playback' => $validated['remote_playback'] ?? false,
              'created_at' => now(),
              'updated_at' => now()
          ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'CCTV maintenance record has been created successfully',
                'data' => $cctvMaintenance
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
                'message' => 'An error occurred while saving the CCTV maintenance record',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function ExportCctv($id)
    {
        try {
            $maintenanceRecord = DB::table('it_fm_cctv')
                ->select([
                    'it_fm_cctv.*',
                    DB::raw('(CASE 
                        WHEN camera_condition = \'rusak\' THEN 1 
                        ELSE 0 END +
                        CASE WHEN lens_condition = \'rusak\' THEN 1 
                        ELSE 0 END +
                        CASE WHEN cable_condition = \'rusak\' THEN 1 
                        ELSE 0 END +
                        CASE WHEN storage_cctv_condition = \'rusak\' THEN 1
                        ELSE 0 END) as broken_components')
                ])
                ->where('id', $id)
                ->first();

            if (!$maintenanceRecord) {
                Log::error('CCTV maintenance record not found for ID: ' . $id);
                return redirect()->route('it-ops.dashboard-cctv')
                    ->with('error', 'CCTV maintenance record not found');
            }

            $pdf = PDF::loadView('SmartForm::it/exports/cctv-maintenance', [
                'record' => $maintenanceRecord
            ]);
            $filename = 'form-cctv-' . str_replace('/', '-', $maintenanceRecord->doc_number) . '.pdf';

            return $pdf->download($filename);

        } catch (\Exception $e) {
            Log::error('Error in ExportCCTV: ' . $e->getMessage());
            return redirect()->route('it-ops.dashboard-cctv')
                ->with('error', 'An error occurred while exporting the record');
        }
    }

    private function generateDocNumber()
    {
        try {
            $prefix = 'BSS-FRM-IT-014';
            $date = now()->format('dmY');
            
            // Get the latest sequence number for the current month
            $lastRecord = DB::table('it_fm_cctv')
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
