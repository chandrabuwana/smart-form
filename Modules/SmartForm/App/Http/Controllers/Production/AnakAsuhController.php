<?php

namespace Modules\SmartForm\App\Http\Controllers\Production;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;
use Modules\SmartForm\helpers\HrdHelper;

class AnakAsuhController extends Controller
{
    public function Dashboard(Request $request)
    {
        // dd(session()->all());
        try {
            $query = DB::table('prod_anak_asuh_monitoring')
                ->select('*')
                ->where('isActive', true)
                ->orderBy('created_at', 'desc');

            if ($request->has('search')) {
                $searchTerm = $request->search;
                $query->where(function($q) use ($searchTerm) {
                    $q->where('doc_number', 'like', '%' . $searchTerm . '%')
                        ->orWhere('name', 'like', '%' . $searchTerm . '%')
                        ->orWhere('nama_anak_asuh_items', 'like', '%' . $searchTerm . '%')
                        ->orWhere('departemen', 'like', '%' . $searchTerm . '%');
                });
            }

            if ($request->has('departemen') && $request->departemen) {
                $query->where('departemen', $request->departemen);
            }

            if ($request->has('start_date') && $request->start_date) {
                $query->whereDate('created_at', '>=', $request->start_date);
            }
            if ($request->has('end_date') && $request->end_date) {
                $query->whereDate('created_at', '<=', $request->end_date);
            }

            $departments = DB::table('prod_anak_asuh_monitoring')
                ->select('departemen')
                ->distinct()
                ->whereNotNull('departemen')
                ->pluck('departemen');

            $filter_options = (object)[
                'departments' => $departments
            ];

            $records = $query->paginate(10);

            $statistics = (object)[
                'total_records' => DB::table('prod_anak_asuh_monitoring')->count(),
                'total_this_month' => DB::table('prod_anak_asuh_monitoring')
                    ->whereMonth('created_at', now()->month)
                    ->whereYear('created_at', now()->year)
                    ->count(),
                'total_anak_asuh' => DB::table('prod_anak_asuh_monitoring')
                    ->select('nama_anak_asuh_items')
                    ->distinct()
                    ->count(),
                'need_attention' => DB::table('prod_anak_asuh_monitoring')
                    ->where(function($query) {
                        $query->whereRaw("JSON_QUERY(disiplin_score_items, '$[0]') = '1'")
                            ->orWhereRaw("JSON_QUERY(skill_score_items, '$[0]') = '1'")
                            ->orWhereRaw("JSON_QUERY(attitude_score_items, '$[0]') = '1'");
                    })
                    ->count()
            ];

            return view('smartform::production.anak_asuh.dashboard', [
                'records' => $records,
                'statistics' => $statistics,
                'filter_options' => $filter_options,
                'filters' => [
                    'search' => $request->search,
                    'departemen' => $request->departemen,
                    'start_date' => $request->start_date,
                    'end_date' => $request->end_date,
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
            $approvalList = HrdHelper::getApprovalList();
            
            if ($request->has('id')) {
                $record = DB::table('prod_anak_asuh_monitoring')
                    ->where('id', $request->id)
                    ->first();
    
                if (!$record) {
                    Log::error('Anak Asuh record not found for ID: ' . $request->id);
                    return redirect()->route('prod.anak-asuh.dashboard')
                        ->with('error', 'Record not found');
                }
    
                $record->tanggal_items = json_decode($record->tanggal_items);
                $record->attendance_items = json_decode($record->attendance_items);
                $record->nama_anak_asuh_items = json_decode($record->nama_anak_asuh_items);
                $record->review_temuan_items = json_decode($record->review_temuan_items);
                $record->disiplin_score_items = json_decode($record->disiplin_score_items);
                $record->skill_score_items = json_decode($record->skill_score_items);
                $record->attitude_score_items = json_decode($record->attitude_score_items);
                $record->shift_items = json_decode($record->shift_items);
    
                Log::info('Anak Asuh record loaded for ID: ' . $request->id);
    
                return view('smartform::production.anak_asuh.form', [
                    'record' => $record,
                    'isShowDetail' => true,
                    'approvalList' => $approvalList
                ]);
            }
    
            return view('smartform::production.anak_asuh.form', [
                'isShowDetail' => false,
                'approvalList' => $approvalList
            ]);
    
        } catch (\Exception $e) {
            Log::error('Error in AddForm: ' . $e->getMessage());
            return redirect()->route('prod.anak-asuh.dashboard')
                ->with('error', 'Failed to load form: ' . $e->getMessage());
        }
    }

    /**
     * Display the form in edit mode with existing data
     * 
     * @param int $id
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function EditForm($id)
    {
        try {
            $approvalList = HrdHelper::getApprovalList();
            
            $record = DB::table('prod_anak_asuh_monitoring')
                ->where('id', $id)
                ->first();
    
            if (!$record) {
                Log::error('Anak Asuh record not found for ID: ' . $id);
                return redirect()->route('prod.anak-asuh.dashboard')
                    ->with('error', 'Record not found');
            }
    
            $record->tanggal_items = json_decode($record->tanggal_items);
            $record->attendance_items = json_decode($record->attendance_items);
            $record->nama_anak_asuh_items = json_decode($record->nama_anak_asuh_items);
            $record->review_temuan_items = json_decode($record->review_temuan_items);
            $record->disiplin_score_items = json_decode($record->disiplin_score_items);
            $record->skill_score_items = json_decode($record->skill_score_items);
            $record->attitude_score_items = json_decode($record->attitude_score_items);
            $record->shift_items = json_decode($record->shift_items);
    
            Log::info('Anak Asuh record loaded for editing, ID: ' . $id);
    
            return view('smartform::production.anak_asuh.edit-form', [
                'record' => $record,
                'isEdit' => true,
                'approvalList' => $approvalList
            ]);
    
        } catch (\Exception $e) {
            Log::error('Error in EditForm: ' . $e->getMessage());
            return redirect()->route('prod.anak-asuh.dashboard')
                ->with('error', 'Failed to load edit form: ' . $e->getMessage());
        }
    }

    public function Store(Request $request)
    {
        try {
            $data = [
                'doc_number' => $this->generateDocNumber(),
                'name' => $request->name ?? session('username'),
                'nik' => $request->nik ?? session('user_id'),
                'jabatan' => $request->jabatan ?? session('jabatan'),
                'departemen' => $request->departemen ?? session('kode_department'),
                'created_by' => $request->created_by,
                'site' => $request->site ?? session('kode_site'),
                'tanggal_items' => $request->tanggal_items ?? date('Y-m-d'),
                'shift_items' => $request->shift_items,
                'isActive' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ];
    
            $tanggal_items = [];
            $attendance_items = [];
            $nama_anak_asuh_items = [];
            $review_temuan_items = [];
            $disiplin_score_items = [];
            $skill_score_items = [];
            $attitude_score_items = [];
            $shift_items = [];
    
            $maxRows = $request->row_count ?? 100;
            
            for ($i = 1; $i <= $maxRows; $i++) {
                if ($request->has("nama_anak_asuh_$i")) {
                    $nama_anak_asuh = $request->input("nama_anak_asuh_$i");
                    
                    if (!empty($nama_anak_asuh)) {
                        $tanggal_items[] = $request->input("tanggal_$i");
                        $attendance_items[] = $request->input("attendance_$i");
                        $nama_anak_asuh_items[] = $nama_anak_asuh;
                        $review_temuan_items[] = $request->input("review_temuan_$i");
                        $disiplin_score_items[] = $request->input("disiplin_score_$i") ?: null;
                        $skill_score_items[] = $request->input("skill_score_$i") ?: null;
                        $attitude_score_items[] = $request->input("attitude_score_$i") ?: null; 
                        $shift_items[] = $request->input("shift_$i");
                    }
                } else {
                    break;
                }
            }
    
            if (empty($nama_anak_asuh_items)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Minimal satu data anak asuh harus diisi'
                ], 422);
            }
    
            Log::info('Processing ' . count($nama_anak_asuh_items) . ' rows of anak asuh data');
    
            $data['tanggal_items'] = json_encode(array_values($tanggal_items));
            $data['attendance_items'] = json_encode(array_values($attendance_items));
            $data['nama_anak_asuh_items'] = json_encode(array_values($nama_anak_asuh_items));
            $data['review_temuan_items'] = json_encode(array_values($review_temuan_items));
            $data['disiplin_score_items'] = json_encode(array_values($disiplin_score_items));
            $data['skill_score_items'] = json_encode(array_values($skill_score_items));
            $data['attitude_score_items'] = json_encode(array_values($attitude_score_items));
            $data['shift_items'] = json_encode(array_values($shift_items));
    
            DB::beginTransaction();
    
            $id = DB::table('prod_anak_asuh_monitoring')->insertGetId($data);
    
            DB::commit();
    
            Log::info('Anak Asuh record created successfully. ID: ' . $id);
    
            return response()->json([
                'success' => true,
                'message' => 'Data berhasil disimpan',
                'id' => $id
            ]);
    
        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Error in Store: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to save record: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update an existing Anak Asuh record
     * 
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function UpdateAnakAsuh(Request $request)
    {
        try {
            $validated = $request->validate([
                'id' => 'required|exists:prod_anak_asuh_monitoring,id',
                'name' => 'required|string|max:255',
                'nik' => 'required|string|max:50',
                'jabatan' => 'required|string|max:255',
                'departemen' => 'required|string|max:255',
                'created_by' => 'required|string|max:255',
            ]);

            $existingRecord = DB::table('prod_anak_asuh_monitoring')
                ->where('id', $validated['id'])
                ->first();
                
            if (!$existingRecord) {
                return response()->json([
                    'success' => false,
                    'message' => 'Record not found'
                ], 404);
            }
    
            $tanggal_items = [];
            $attendance_items = [];
            $nama_anak_asuh_items = [];
            $review_temuan_items = [];
            $disiplin_score_items = [];
            $skill_score_items = [];
            $attitude_score_items = [];
            $shift_items = [];
    
            $maxRows = $request->row_count ?? 100;
            
            for ($i = 1; $i <= $maxRows; $i++) {
                if ($request->has("nama_anak_asuh_$i")) {
                    $nama_anak_asuh = $request->input("nama_anak_asuh_$i");
                    
                    if (!empty($nama_anak_asuh)) {
                        $tanggal_items[] = $request->input("tanggal_$i");
                        $attendance_items[] = $request->input("attendance_$i");
                        $nama_anak_asuh_items[] = $nama_anak_asuh;
                        $review_temuan_items[] = $request->input("review_temuan_$i");
                        $disiplin_score_items[] = $request->input("disiplin_score_$i") ?: null;
                        $skill_score_items[] = $request->input("skill_score_$i") ?: null;
                        $attitude_score_items[] = $request->input("attitude_score_$i") ?: null;
                        $shift_items[] = $request->input("shift_$i");
                    }
                } else {
                    break;
                }
            }
    
            if (empty($nama_anak_asuh_items)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Minimal satu data anak asuh harus diisi'
                ], 422);
            }
    
            DB::beginTransaction();
    
            DB::table('prod_anak_asuh_monitoring')
                ->where('id', $validated['id'])
                ->update([
                    'name' => $validated['name'],
                    'nik' => $validated['nik'],
                    'jabatan' => $validated['jabatan'],
                    'departemen' => $validated['departemen'],
                    'created_by' => $validated['created_by'],
                    'site' => $request->site,
                    'tanggal_items' => json_encode($tanggal_items),
                    'attendance_items' => json_encode($attendance_items),
                    'nama_anak_asuh_items' => json_encode($nama_anak_asuh_items),
                    'review_temuan_items' => json_encode($review_temuan_items),
                    'disiplin_score_items' => json_encode($disiplin_score_items),
                    'skill_score_items' => json_encode($skill_score_items),
                    'attitude_score_items' => json_encode($attitude_score_items),
                    'shift_items' => json_encode($shift_items),
                    'updated_at' => now()
                ]);
    
            DB::commit();
    
            Log::info('Anak Asuh record updated successfully. ID: ' . $validated['id']);
            
            return response()->json([
                'success' => true,
                'message' => 'Record updated successfully',
                'id' => $validated['id']
            ]);
                    
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Error updating Anak Asuh record: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to update record: ' . $e->getMessage()
            ], 500);
        }
    }

    public function ExportForm($id)
    {
        try {
            $record = DB::table('prod_anak_asuh_monitoring')
                ->where('id', $id)
                ->first();

            if (!$record) {
                return redirect()
                    ->route('prod.anak-asuh.dashboard')
                    ->with('error', 'Data tidak ditemukan');
            }

            $safeJsonDecode = function($value) {
                if (is_string($value)) {
                    return json_decode($value);
                } elseif (is_array($value)) {
                    return $value;
                }
                return null;
            };

            $record->tanggal_items = $safeJsonDecode($record->tanggal_items);
            $record->attendance_items = $safeJsonDecode($record->attendance_items);
            $record->nama_anak_asuh_items = $safeJsonDecode($record->nama_anak_asuh_items);
            $record->review_temuan_items = $safeJsonDecode($record->review_temuan_items);
            $record->disiplin_score_items = $safeJsonDecode($record->disiplin_score_items);
            $record->skill_score_items = $safeJsonDecode($record->skill_score_items);
            $record->attitude_score_items = $safeJsonDecode($record->attitude_score_items);
            $record->shift_items = $safeJsonDecode($record->shift_items);

            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('smartform::production.anak_asuh.export-pdf', compact('record'));
            $pdf->setPaper('a4', 'portrait');
            
            return $pdf->download('Anak_Asuh_Monitoring_' . $record->doc_number . '.pdf');

        } catch (\Exception $e) {
            Log::error('Error in ExportForm: ' . $e->getMessage());
            return redirect()
                ->route('prod.anak-asuh.dashboard')
                ->with('error', 'Failed to generate PDF: ' . $e->getMessage());
        }
    }

    /**
     * Soft delete an Anak Asuh record by setting isActive to false
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function Delete(Request $request)
    {
        try {
            $validated = $request->validate([
                'id' => 'required|exists:prod_anak_asuh_monitoring,id',
            ]);

            DB::beginTransaction();
            
            DB::table('prod_anak_asuh_monitoring')
                ->where('id', $validated['id'])
                ->update([
                    'isActive' => false,
                    'updated_at' => now()
                ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Anak Asuh record has been deleted successfully',
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error deleting Anak Asuh record: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while deleting the record',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    private function generateDocNumber()
    {
        $today = Carbon::now();
        $prefix = sprintf(
            'BSS-FRM-PROD-03-%s%s-',
            $today->format('y'),
            $today->format('m')
        );
        
        $highestRecord = DB::table('prod_anak_asuh_monitoring')
            ->where('doc_number', 'like', $prefix . '%')
            ->orderByRaw('LEN(doc_number) DESC, doc_number DESC')
            ->first();
            
        $nextNumber = 1;
        
        if ($highestRecord) {
            $lastPart = substr($highestRecord->doc_number, strlen($prefix));
            if (is_numeric($lastPart)) {
                $nextNumber = intval($lastPart) + 1;
            }
        }
        
        return $prefix . sprintf('%03d', $nextNumber);
    }

    public function getApprovalList(Request $request)
    {
        $search = $request->input('search', '');
        $list = HrdHelper::getApprovalList($search);

        return response()->json($list);
    }
}