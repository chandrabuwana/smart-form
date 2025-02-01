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

class RouterFormController extends Controller
{
  public function Dashboard(Request $request)
  {
    // Get filter parameters
    $filters = [
      'start_date' => $request->get('start_date'),
      'end_date' => $request->get('end_date'),
      'site' => $request->get('site', 'all'),
      'search' => $request->get('search')
    ];

    // Build query
    $query = DB::table('it_fm_router')
      ->select('*')
      ->orderBy('created_at', 'desc');

    // Apply filters
    if ($filters['start_date']) {
      $query->whereDate('created_at', '>=', $filters['start_date']);
    }
    if ($filters['end_date']) {
      $query->whereDate('created_at', '<=', $filters['end_date']);
    }
    if ($filters['site'] && $filters['site'] !== 'all') {
      $query->where('site', $filters['site']);
    }
    if ($filters['search']) {
      $query->where(function($q) use ($filters) {
        $q->where('nama', 'like', '%' . $filters['search'] . '%')
          ->orWhere('nik', 'like', '%' . $filters['search'] . '%');
      });
    }

    // Get statistics
    $statistics = (object)[
      'total_records' => $query->count(),
      'broken_components' => $query->clone()
        ->where(function($q) {
          $q->where('router_condition', 'rusak')
            ->orWhere('antena_condition', 'rusak')
            ->orWhere('cable_condition', 'rusak');
        })->count(),
      'maintenance_this_month' => $query->clone()
        ->whereYear('created_at', now()->year)
        ->whereMonth('created_at', now()->month)
        ->count(),
    ];

    // Calculate completion rate (percentage of maintenance tasks completed)
    $totalTasks = $query->clone()->count() * 3; // 3 maintenance tasks per record
    $completedTasks = $query->clone()
      ->whereNotNull('dust_cleaner_check')
      ->whereNotNull('restart_router_check')
      ->whereNotNull('port_check')
      ->count() * 3;
    
    $statistics->completion_rate = $totalTasks > 0 
      ? round(($completedTasks / $totalTasks) * 100) 
      : 0;

    // Get unique sites for filter dropdown
    $sites = DB::table('it_fm_router')
      ->select('site')
      ->distinct()
      ->pluck('site')
      ->toArray();

    // Get paginated maintenance records
    $maintenanceRecords = $query->paginate(10);

    // Add broken components count to each record
    foreach ($maintenanceRecords as $record) {
      $record->broken_components = 0;
      if ($record->router_condition === 'rusak') $record->broken_components++;
      if ($record->antena_condition === 'rusak') $record->broken_components++;
      if ($record->cable_condition === 'rusak') $record->broken_components++;
    }

    return view('SmartForm::it.dashboard-router', [
      'maintenanceRecords' => $maintenanceRecords,
      'statistics' => $statistics,
      'filters' => $filters,
      'sites' => $sites
    ]);
  }

  public function CreateRouterForm(Request $request){
    try {
      // If ID is provided, get maintenance data
      if ($request->has('id')) {
        $maintenanceRecord = DB::table('it_fm_router')
                    ->where('id', $request->id)
                    ->first();

        if (!$maintenanceRecord) {
            Log::error('Router maintenance record not found for ID: ' . $request->id);
            return redirect()->route('it-ops.dashboard-router')
                ->with('error', 'Router maintenance record not found');
        }
        return view("SmartForm::it.form-router", [
            'isShowDetail' => true,
            'maintenanceRecord' => $maintenanceRecord
        ]);
      }

      // If no ID, show empty form
      return view("SmartForm::it.form-router", [
        'isShowDetail' => false,
        'maintenanceRecord' => null
      ]);
    } catch (\Exception $e) {
      Log::error('Error in CreateRouterForm: ' . $e->getMessage());
      return redirect()->route('it-ops.dashboard-router')
                ->with('error', 'An error occurred while loading the form');
    }
    
  }

  public function SubmitRouterForm(Request $request)
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
        'router_condition' => 'required|in:baik,rusak',
        'antena_condition' => 'required|in:baik,rusak',
        'cable_condition' => 'required|in:baik,rusak',
 
        // Maintenance Tasks
        'dust_cleaner_check' => 'nullable|boolean',
        'restart_router_check' => 'nullable|boolean',
        'port_check' => 'nullable|boolean',
      ]);

      DB::beginTransaction();
      
      $docNumber = $this->generateDocNumber();
      
      $routerMaintenance = DB::table('it_fm_router')->insert([
        'doc_number' => $docNumber,
        'nama' => $validated['nama'],
        'nik' => $validated['nik'],
        'dept' => $validated['dept'],
        'site' => $validated['site'],
        'no_asset' => $validated['no_asset'],
        'jenis_aset' => $validated['jenis_aset'],
        'merk' => $validated['merk'],
        'model' => $validated['model'],
        'router_condition' => $validated['router_condition'],
        'antena_condition' => $validated['antena_condition'],
        'cable_condition' => $validated['cable_condition'],
        'dust_cleaner_check' => $validated['dust_cleaner_check'] ?? false,
        'restart_router_check' => $validated['restart_router_check'] ?? false,
        'port_check' => $validated['port_check'] ?? false,
        'created_at' => now(),
        'updated_at' => now()
      ]);

      DB::commit();

      return response()->json([
        'success' => true,
        'message' => 'Router maintenance record has been created successfully',
        'data' => [
          'doc_number' => $docNumber
        ]
      ]);
      
    } catch (ValidationException $e) {
      DB::rollBack();
      return response()->json([
        'success' => false,
        'message' => 'Validation failed',
        'errors' => $e->errors()
      ], 422);
    } catch (\Exception $e) {
      DB::rollBack();
      Log::error('Error creating router maintenance record: ' . $e->getMessage());
      return response()->json([
        'success' => false,
        'message' => 'An error occurred while creating the router maintenance record'
      ], 500);
    }
  }

  public function ExportRouter($id)
  {
    try {
      // Get the router maintenance record
      $record = DB::table('it_fm_router')
        ->where('id', $id)
        ->first();

      if (!$record) {
        return redirect()->back()->with('error', 'Router maintenance record not found');
      }

      // Generate PDF
      $pdf = PDF::loadView('SmartForm::it.exports.router-maintenance', [
        'record' => $record
      ]);

      // Set paper size and orientation
      $pdf->setPaper('A4', 'portrait');

      // Generate filename
      $filename = sprintf(
        'Router_Maintenance_%s_%s.pdf',
        $record->doc_number,
        date('Ymd', strtotime($record->created_at))
      );

      // Return PDF for download
      return $pdf->download($filename);

    } catch (\Exception $e) {
      Log::error('Error exporting router maintenance record: ' . $e->getMessage());
      return redirect()->back()->with('error', 'Failed to generate PDF. Please try again later.');
    }
  }

  private function generateDocNumber(){
    try {
      $prefix = 'BSS-FRM-IT-015';
      $date = now()->format('dmY');
      
      // Get the latest sequence number for the current month
      $lastRecord = DB::table('it_fm_router')
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
}