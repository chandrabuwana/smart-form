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

class AparController extends Controller {
    private const TABLE_KARYAWAN = 'TKaryawan';

    private $user_sm = [ '1008491', '1008492', '1008493', '1008494', '1008526' ];
    private const LIST_DEPT = [
        '' => '--- Pilih Departmen ---',
        'ENG' => 'ENGINEERING',
        'SHE' => 'SHE',
        'PRD' => 'PRODUKSI',
        'SM' => 'SM',
        'IC' => 'IC',
        'GS' => 'GS',
        'RM' => 'PLANT',
        'BDV' => 'BUSDEV',
        'FIN' => 'FINANCE',
        'ATA' => 'Accounting & Tax',
        'DTC' => 'DATA CENTER',
        'MM' => 'LOGISTIK',
        'OPR' => 'OPERATION',
        'LEG' => 'LEGAL',
        'OD' => 'ORGANIZATION DEVELOPMENT',
        'CIVIL' => 'CIVIL'
    ];
    public function download() {
        $pdf = Pdf::loadView('pdf');
 
        return $pdf->download();
    }

    public function inspeksiAparDashboard(Request $request)
    {
        try {
            $query = DB::table('FM_SHE_036_INSPEKSI_APAR');

            if ($request->filled('start_date')) {
                $query->whereDate('tanggal', '>=', $request->start_date);
            }

            if ($request->filled('work_location')) {
                $query->where('lokasi_inspeksi', $request->work_location);
            }

            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('no_dok', 'like', "%{$search}%")
                    ->orWhere('lokasi_inspeksi', 'like', "%{$search}%");
                });
            }

            $records = $query->orderBy('id', 'desc')->get();
                
            $locations = DB::table('FM_SHE_036_INSPEKSI_APAR')
                ->select('lokasi_inspeksi')
                ->distinct()
                ->get();
                
            $startOfMonth = now()->startOfMonth()->format('Y-m-d');
            $recordsThisMonth = $records->filter(function($record) use ($startOfMonth) {
                try {
                    $recordDate = \Carbon\Carbon::parse($record->tanggal)->format('Y-m-d');
                    return $recordDate >= $startOfMonth;
                } catch (\Exception $e) {
                    return false;
                }
            })->count();

            $filters = $request->all();
                
            return view('SmartForm::she/inspeksi-apar/inspeksi-apar', [
                'records' => $records,
                'locations' => $locations,
                'recordsThisMonth' => $recordsThisMonth,
                'filters' => $filters
            ]);
        } catch (Exception $e) {
            Log::error('Error in inspeksiAparDashboard: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return redirect()->back()->with('error', 'Failed to load dashboard: ' . $e->getMessage());
        }
    }

    function GetListInspeksiApar(Request $request) {
        $TABLE_MASTER = "FM_SHE_036_INSPEKSI_APAR";
        $response = array(
            'message' => '',
            'isSuccess' => false
        );

        $sort = $request->query('sort', 'id');
        $order = $request->query('order', 'desc');
        $offset = $request->query('offset', 0); 
        $limit = $request->query('limit', null);
        $filter = $request->query('filter', null);
        try {
            $master = DB::table($TABLE_MASTER)
                ->select('id', 'no_dok', 'lokasi_inspeksi as lokasi', 'dibuat_oleh as dibuat','tanggal as tgl');
            
            $master->orderBy($sort, $order);
            $jml = $master->count();            
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

    function formInspeksiApar() {
        return view('SmartForm::she/inspeksi-apar/form-inspeksi-apar', [
            'isShowDetail' => false,
            'record' => null,
            'approvalList' => HrdHelper::getApprovalList(),
        ]);
    }

    function SubmitFormInspeksiApar(Request $req) {
        $TABLE_MASTER = "FM_SHE_036_INSPEKSI_APAR";
        $TABLE_DETAIL = "FM_SHE_036_INSPEKSI_APAR_DETAIL";
        $response = array(
            'message' => "",
            'success' => false
        );
        $tgl = now()->toDateTimeString();
        $requested_by = $req->session()->get('user_id');
        $data = $req->input();
        $dibuat_nama = DB::connection('sqlsrv2')->table(self::TABLE_KARYAWAN)
                    ->select('Nama')
                    ->where('NIK', $requested_by)
                    ->value('Nama');
        $diperiksa_nama = DB::connection('sqlsrv2')->table(self::TABLE_KARYAWAN)
                    ->select('Nama')
                    ->where('NIK', $req->diperiksa)
                    ->get('Nama');
        $diketahui_nama = DB::connection('sqlsrv2')->table(self::TABLE_KARYAWAN)
                    ->select('Nama')
                    ->where('NIK', $req->diketahui)
                    ->value('Nama');
        $disetujui_nama = DB::connection('sqlsrv2')->table(self::TABLE_KARYAWAN)
                    ->select('Nama')
                    ->where('NIK', $req->disetujui)
                    ->value('Nama');
        $data_insert = [
            'dibuat_oleh' => $requested_by,
            'dibuat_oleh_nama' => $dibuat_nama,
            'diperiksa_oleh' => $data['diperiksa'],
            'diperiksa_oleh_nama' => $diperiksa_nama,
            'diketahui_oleh' => $data['diketahui'] ?? null,
            'diketahui_oleh_nama' => $diketahui_nama,
            'disetujui_oleh' => $data['disetujui'] ?? null,
            'disetujui_oleh_nama' => $disetujui_nama,
            'status' => json_encode(array_values([null, null, null])),
            'lokasi_inspeksi' => $data['lok1'],
            'no_dok' => $data['noDoc'],
            'revisi' => "01",
            'tanggal' => $data['tglDoc'],
            'halaman' => "1 dari 2",
            'catatan' => $data['catatan'] ?? ''
        ];
        
        $data_item = json_decode($data['item']);
        
        try {
            DB::beginTransaction();
            $id = DB::table($TABLE_MASTER)->insertGetId($data_insert);
            
            foreach ($data_item as $data_item_detail) {
                DB::table($TABLE_DETAIL)->insert(array(
                    'id_inspeksi_apar' => $id,
                    'lokasi_apar' => $data_item_detail->lok2,
                    'jenis_apar' => $data_item_detail->jenis,
                    'tekanan_tabung' => $data_item_detail->tekananTab,
                    'tabung' => isset($data_item_detail->tabung1) && ($data_item_detail->tabung1 === true || $data_item_detail->tabung1 === 1) ? 1 : 0,
                    'handle' => isset($data_item_detail->handle) && ($data_item_detail->handle === true || $data_item_detail->handle === 1) ? 1 : 0,
                    'selang' => isset($data_item_detail->selang) && ($data_item_detail->selang === true || $data_item_detail->selang === 1) ? 1 : 0,
                    'label_tabung' => isset($data_item_detail->label) && ($data_item_detail->label === true || $data_item_detail->label === 1) ? 1 : 0,
                    'label_kartu' => isset($data_item_detail->tabung2) && ($data_item_detail->tabung2 === true || $data_item_detail->tabung2 === 1) ? 1 : 0,
                    'berlaku_sampai' => $data_item_detail->tglBerlaku,
                    'berat_apar' => $data_item_detail->berat,
                    'metode_pemenuhan' => $data_item_detail->metode,
                    'tanggal' => $data_item_detail->tanggal,
                    'pic' => $data_item_detail->pic,
                    'keterangan' => $data_item_detail->ket
                ));
            }
            
            $no_doc_parts = explode('/', $data_insert['no_dok']);
            $no_doc_parts[0] = $id;
            $updated_no_doc = implode('/', $no_doc_parts);
            
            DB::table($TABLE_MASTER)
                ->where('id', $id)
                ->update(['no_dok' => $updated_no_doc]);
            
            DB::commit();
            
            $response['message'] = "Data berhasil disimpan";
            $response['success'] = true;
            $response['data'] = [
                'id' => $id,
                'no_dok' => $updated_no_doc
            ];
            
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            DB::rollBack();
            $response['message'] = $ex->getMessage();
            $response['success'] = false;
        }
        
        return response()->json($response);
    }

    public function DetailInspeksiApar($id) {
        try {
            $data = DB::table('FM_SHE_036_INSPEKSI_APAR')
                ->where('id', $id)
                ->first();
                
            if (!$data) {
                abort(404, 'Record not found');
            }
            
            $createdBy = DB::table('users')
                ->where('userid', $data->dibuat_oleh)
                ->select('username')
                ->first();
                
            $checkedBy = null;
            if (!empty($data->diperiksa_oleh)) {
                $checkedBy = DB::table('users')
                    ->where('userid', $data->diperiksa_oleh)
                    ->select('username')
                    ->first();
            }
            
            $knownBy = null;
            if (!empty($data->diketahui_oleh)) {
                $knownBy = DB::table('users')
                    ->where('userid', $data->diketahui_oleh)
                    ->select('username')
                    ->first();
            }
            
            $approvedBy = null;
            if (!empty($data->disetujui_oleh)) {
                $approvedBy = DB::table('users')
                    ->where('userid', $data->disetujui_oleh)
                    ->select('username')
                    ->first();
            }
            
            $data->dibuat_oleh_name = $createdBy ? $createdBy->username : null;
            $data->diperiksa_oleh_name = $checkedBy ? $checkedBy->username : null;
            $data->diketahui_oleh_name = $knownBy ? $knownBy->username : null;
            $data->disetujui_oleh_name = $approvedBy ? $approvedBy->username : null;
            
            if (isset($data->status) && !empty($data->status)) {
                $statusArray = json_decode($data->status, true);
                if (is_array($statusArray)) {
                    $data->status = $statusArray;
                } else {
                    $data->status = [null, null, null];
                }
            } else {
                $data->status = [null, null, null];
            }
            
            $detail = DB::table('FM_SHE_036_INSPEKSI_APAR_DETAIL')
                ->where('id_inspeksi_apar', $id)
                ->get();
                
            $user_id = session('user_id');
            
            $isApproved = false;
            if (isset($data->status) && is_array($data->status)) {
                if (count(array_filter($data->status, function($item) { return $item === 'approved'; })) === 3) {
                    $isApproved = true;
                }
            }
            
            return view('smartform::she.inspeksi-apar.detail-inspeksi-apar', [
                'data' => $data,
                'detail' => $detail,
                'nik' => $user_id,
                'isApproved' => $isApproved
            ]);
        } catch (\Exception $e) {
            Log::error('Error in DetailInspeksiApar: ' . $e->getMessage());
            abort(500, 'Error loading record details');
        }
    }
    
    public function UpdateInspeksiApar(Request $request)
    {
        try {
            Log::info('UpdateInspeksiApar request data:', $request->all());
            
            DB::beginTransaction();
    
            $id = $request->id;
            $lokasi_inspeksi = $request->lok1;
            $catatan = $request->catatan;
            
            if (!$request->has('item') || empty($request->item)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No item data provided'
                ], 400);
            }
            
            try {
                $data_item = json_decode($request->item);
                
                if (json_last_error() !== JSON_ERROR_NONE) {
                    throw new \Exception('Invalid JSON: ' . json_last_error_msg());
                }
                
                if (!is_array($data_item) && !is_object($data_item)) {
                    throw new \Exception('Item data is not an array or object');
                }
                
                Log::info('Decoded item data:', ['count' => is_array($data_item) ? count($data_item) : 1, 'data' => $data_item]);
            } catch (\Exception $e) {
                Log::error('JSON decode error: ' . $e->getMessage());
                Log::error('Raw item data: ' . $request->item);
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid item data: ' . $e->getMessage()
                ], 400);
            }
            
            $existingData = DB::table('FM_SHE_036_INSPEKSI_APAR')
                ->where('id', $id)
                ->first();
                
            if (!$existingData) {
                return response()->json([
                    'success' => false,
                    'message' => 'Record not found'
                ], 404);
            }
            
            $updateData = [
                'lokasi_inspeksi' => $lokasi_inspeksi,
                'catatan' => $catatan
            ];
            
            if ($request->has('diperiksa')) {
                $updateData['diperiksa_oleh'] = $request->diperiksa;
            }
            if ($request->has('diketahui')) {
                $updateData['diketahui_oleh'] = $request->diketahui;
            }
            if ($request->has('disetujui')) {
                $updateData['disetujui_oleh'] = $request->disetujui;
            }
            
            Log::info('Update data:', $updateData);
            
            $affected = DB::table('FM_SHE_036_INSPEKSI_APAR')
                ->where('id', $id)
                ->update($updateData);
                
            Log::info('Master record updated, affected rows: ' . $affected);
            
            $detailsDeleted = DB::table('FM_SHE_036_INSPEKSI_APAR_DETAIL')
                ->where('id_inspeksi_apar', $id)
                ->delete();
                
            Log::info('Deleted details: ' . $detailsDeleted);
            
            foreach ($data_item as $data_item_detail) {
                if (!isset($data_item_detail->lok2) || empty($data_item_detail->lok2)) {
                    throw new \Exception('Location is required for all items');
                }
                
                $berlaku_sampai = null;
                if (isset($data_item_detail->tglBerlaku) && !empty($data_item_detail->tglBerlaku)) {
                    try {
                        $berlaku_sampai = $this->formatDate($data_item_detail->tglBerlaku);
                    } catch (\Exception $e) {
                        Log::warning('Could not parse berlaku_sampai date: ' . $data_item_detail->tglBerlaku);
                    }
                }
                
                $tanggal = null;
                if (isset($data_item_detail->tanggal) && !empty($data_item_detail->tanggal)) {
                    try {
                        $tanggal = $this->formatDate($data_item_detail->tanggal);
                    } catch (\Exception $e) {
                        Log::warning('Could not parse tanggal date: ' . $data_item_detail->tanggal);
                    }
                }
                
                $insertData = [
                    'id_inspeksi_apar' => $id,
                    'lokasi_apar' => $data_item_detail->lok2,
                    'jenis_apar' => $data_item_detail->jenis ?? '',
                    'tekanan_tabung' => $data_item_detail->tekananTab ?? '',
                    'tabung' => isset($data_item_detail->tabung1) && ($data_item_detail->tabung1 === true || $data_item_detail->tabung1 === 1 || $data_item_detail->tabung1 === 'true') ? 1 : 0,
                    'handle' => isset($data_item_detail->handle) && ($data_item_detail->handle === true || $data_item_detail->handle === 1 || $data_item_detail->handle === 'true') ? 1 : 0,
                    'selang' => isset($data_item_detail->selang) && ($data_item_detail->selang === true || $data_item_detail->selang === 1 || $data_item_detail->selang === 'true') ? 1 : 0,
                    'label_tabung' => isset($data_item_detail->label) && ($data_item_detail->label === true || $data_item_detail->label === 1 || $data_item_detail->label === 'true') ? 1 : 0,
                    'label_kartu' => isset($data_item_detail->tabung2) && ($data_item_detail->tabung2 === true || $data_item_detail->tabung2 === 1 || $data_item_detail->tabung2 === 'true') ? 1 : 0,
                    'berlaku_sampai' => $berlaku_sampai,
                    'berat_apar' => $data_item_detail->berat ?? 0,
                    'metode_pemenuhan' => $data_item_detail->metode ?? '',
                    'tanggal' => $tanggal,
                    'pic' => $data_item_detail->pic ?? '',
                    'keterangan' => $data_item_detail->ket ?? ''
                ];
                
                $insertId = DB::table('FM_SHE_036_INSPEKSI_APAR_DETAIL')->insertGetId($insertData);
                Log::info('Inserted detail with ID: ' . $insertId);
            }
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Data inspeksi APAR berhasil diupdate'
            ]);
            
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error in UpdateInspeksiApar: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
    
    private function formatDate($dateString)
    {
        if (empty($dateString)) return null;
        
        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $dateString)) {
            return $dateString;
        }
        
        if (preg_match('/(\w+)\s+(\d+)\s+(\d{4})\s+(\d{2}):(\d{2}):(\d{2}):(\w+)/', $dateString, $matches)) {
            $month = date('m', strtotime($matches[1]));
            $day = $matches[2];
            $year = $matches[3];
            return "$year-$month-$day";
        }
        
        try {
            return date('Y-m-d', strtotime($dateString));
        } catch (\Exception $e) {
            Log::error('Error formatting date: ' . $e->getMessage());
            return null;
        }
    }
    
    public function DeleteInspeksiApar(Request $request) {
        try {
            Log::info('DeleteInspeksiApar request data:', $request->all());
            
            $id = $request->id;
            
            if (empty($id)) {
                return response()->json([
                    'success' => false,
                    'message' => 'ID is required'
                ], 400);
            }
            
            $recordExists = DB::table('FM_SHE_036_INSPEKSI_APAR')
                ->where('id', $id)
                ->exists();
                
            if (!$recordExists) {
                return response()->json([
                    'success' => false,
                    'message' => 'Record not found'
                ], 404);
            }
            
            $detailTableStructure = DB::getSchemaBuilder()->getColumnListing('FM_SHE_036_INSPEKSI_APAR_DETAIL');
            $masterTableStructure = DB::getSchemaBuilder()->getColumnListing('FM_SHE_036_INSPEKSI_APAR');
            
            Log::info('Detail table structure:', $detailTableStructure);
            Log::info('Master table structure:', $masterTableStructure);
            
            $existingDetails = DB::table('FM_SHE_036_INSPEKSI_APAR_DETAIL')
                ->where('id_inspeksi_apar', $id)
                ->get();
                
            Log::info('Existing details count: ' . count($existingDetails));
            
            DB::beginTransaction();
            
            try {
                $detailsDeleted = DB::table('FM_SHE_036_INSPEKSI_APAR_DETAIL')
                    ->where('id_inspeksi_apar', $id)
                    ->delete();
                    
                Log::info('Details deleted: ' . $detailsDeleted);
                
                $masterDeleted = DB::table('FM_SHE_036_INSPEKSI_APAR')
                    ->where('id', $id)
                    ->delete();
                    
                Log::info('Master deleted: ' . $masterDeleted);
                
                DB::commit();
                
                return response()->json([
                    'success' => true,
                    'message' => 'Record successfully deleted'
                ]);
            } catch (Exception $e) {
                DB::rollBack();
                throw $e;
            }
        } catch (QueryException $e) {
            Log::error('Database error in DeleteInspeksiApar: ' . $e->getMessage());
            Log::error('SQL: ' . $e->getSql() . ' Bindings: ' . implode(', ', $e->getBindings()));
            
            return response()->json([
                'success' => false,
                'message' => 'Database error: ' . $e->getMessage()
            ], 500);
        } catch (Exception $e) {
            Log::error('Error in DeleteInspeksiApar: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
        
    public function PdfInspeksiApar($id)
    {
        $TABLE_MASTER = "FM_SHE_036_INSPEKSI_APAR";
        $TABLE_DETAIL = "FM_SHE_036_INSPEKSI_APAR_DETAIL";
        $errors = array(
            'error' => false,
            'message' => ''
        );
        try {
            $data = DB::table($TABLE_MASTER)
            ->select('id','tanggal as tgl','lokasi_inspeksi as lok1','dibuat_oleh as dibuat',
            'diketahui_oleh as mengetahui','diketahui_oleh_nama as mengetahui_nama',
            'disetujui_oleh as approval','catatan','dibuat_oleh_nama as dibuat_nama',
            'diperiksa_oleh as diperiksa','diperiksa_oleh_nama as diperiksa_nama',
            'tgl_diketahui','tgl_diperiksa')
            ->where('id', $id)
            ->first();
            
            $data_detail = DB::table($TABLE_DETAIL)
            ->select('id_inspeksi_apar','lokasi_apar as lok2','jenis_apar as jenis','berat_apar as berat','tekanan_tabung as tekanan','tabung','handle','label_tabung as label','selang','label_kartu','berlaku_sampai as berlaku','metode_pemenuhan as metode','pic','tanggal','keterangan')
            ->where('id_inspeksi_apar', $data->id)
            ->get();
            
            $nomor = 1;
            foreach($data_detail as $detail) {
                $detail->nomor = $nomor;            
                $nomor++;
            }
            $data_master['id'] = $data->id;
            $data_master['tgl'] = $data->tgl;
            $data_master['dibuat'] = $data->dibuat;
            $data_master['dibuat_nama'] = $data->dibuat_nama;
            $data_master['diperiksa'] = $data->diperiksa;
            $data_master['diperiksa_nama'] = $data->diperiksa_nama;
            $data_master['tgl_diperiksa'] = $data->tgl_diperiksa;
            $data_master['mengetahui'] = $data->mengetahui;
            $data_master['mengetahui_nama'] = $data->mengetahui_nama;
            $data_master['tgl_diketahui'] = $data->tgl_diketahui;
            $data_master['lok1'] = $data->lok1;
            $data_master['catatan'] = $data->catatan;
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
        }
        Log::info("data_master : ". json_encode($data_master));
        $pdf = PDF::loadView('SmartForm::she/inspeksi-apar/inspeksi-apar-pdf',  ['data' => $data_master, 'data_detail' => $data_detail, 'error' => $errors])->setPaper('a4', 'landscape');
        return $pdf->download('BSS-FRM-SHE-036.pdf');
    }

    
    public function EditInspeksiApar(Request $request) {
        $id = $request->query('id');
        
        if (empty($id)) {
            return redirect()->back()->with('error', 'ID is missing');
        }
        
        try {
            $data = DB::table('FM_SHE_036_INSPEKSI_APAR')
                ->where('id', $id)
                ->first();
                
            if (!$data) {
                return abort(404, 'Data not found');
            }
            
            $detail = DB::table('FM_SHE_036_INSPEKSI_APAR_DETAIL')
                ->where('id_inspeksi_apar', $id)
                ->get();
            
            $user_id = session('user_id');
            
            $approvalList = DB::table('users')
                ->select('userid as nik', 'username as nama')
                ->orderBy('username')
                ->get();
            
            return view('smartform::she.inspeksi-apar.edit-inspeksi-apar', [
                'data' => $data,
                'detail' => $detail,
                'list_dept' => self::LIST_DEPT,
                'nik' => $user_id,
                'approvalList' => $approvalList
            ]);
        } catch (Exception $e) {
            Log::error('Error in EditInspeksiApar: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error loading data: ' . $e->getMessage());
        }
    }

    public function Approve(Request $request)
    {
        try {
            Log::info('Approve request data:', $request->all());
            
            $id = $request->id;
            $userId = $request->session()->get('user_id');
            $tgl = now()->toDateTimeString();
            
            $user = DB::table('users')
                ->where('userid', $userId)
                ->first();
                
            if (!$user) {
                Log::warning('User not found in users table: ' . $userId);
                return response()->json([
                    'success' => false,
                    'message' => 'User information not found'
                ]);
            }
            
            Log::info('Current user:', ['userid' => $user->userid, 'username' => $user->username]);
            
            $record = DB::table('FM_SHE_036_INSPEKSI_APAR')
                ->where('id', $id)
                ->first();
                
            if (!$record) {
                return response()->json([
                    'success' => false,
                    'message' => 'Record not found'
                ], 404);
            }
            
            Log::info('Record data:', (array)$record);
            
            if (!property_exists($record, 'status') || empty($record->status)) {
                $statusArray = [null, null, null];
            } else {
                try {
                    $statusArray = json_decode($record->status, true);
                    if (!is_array($statusArray) || count($statusArray) !== 3) {
                        $statusArray = [null, null, null];
                    }
                } catch (\Exception $e) {
                    Log::error('Error decoding status JSON: ' . $e->getMessage());
                    $statusArray = [null, null, null];
                }
            }
            
            Log::info('Status array before update:', $statusArray);
            
            $updateData = [
                'status' => null
            ];
            
            if (isset($request->diperiksa)) {
                $statusArray[0] = 'approved';
                $updateData['diperiksa_oleh'] = $userId;
                $updateData['tgl_diperiksa'] = $tgl;
                Log::info('Updating diperiksa status');
            } elseif (isset($request->diketahui)) {
                $statusArray[1] = 'approved';
                $updateData['diketahui_oleh'] = $userId;
                $updateData['tgl_diketahui'] = $tgl;
                Log::info('Updating diketahui status');
            } elseif (isset($request->disetujui)) {
                $statusArray[2] = 'approved';
                $updateData['disetujui_oleh'] = $userId;
                Log::info('Updating disetujui status');
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid approval request'
                ]);
            }
            
            $updateData['status'] = json_encode($statusArray);
            
            Log::info('Status array after update:', $statusArray);
            Log::info('Update data:', $updateData);
            
            DB::table('FM_SHE_036_INSPEKSI_APAR')
                ->where('id', $id)
                ->update($updateData);
                    
            return response()->json([
                'success' => true,
                'message' => 'Document approved successfully'
            ]);
            
        } catch (Exception $e) {
            Log::error('Error in Approve method: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $e->getMessage()
            ]);
        }
    }
    
    public function Reject(Request $request)
    {
        try {
            Log::info('Reject request data:', $request->all());
            
            $id = $request->id;
            $userId = $request->session()->get('user_id');
            
            $user = DB::table('users')
                ->where('userid', $userId)
                ->first();
                
            if (!$user) {
                Log::warning('User not found in users table: ' . $userId);
                return response()->json([
                    'success' => false,
                    'message' => 'User information not found'
                ]);
            }
            
            Log::info('Current user:', ['userid' => $user->userid, 'username' => $user->username]);
            
            $record = DB::table('FM_SHE_036_INSPEKSI_APAR')
                ->where('id', $id)
                ->first();
                
            if (!$record) {
                return response()->json([
                    'success' => false,
                    'message' => 'Record not found'
                ], 404);
            }
            
            Log::info('Record data:', (array)$record);
            
            if (!property_exists($record, 'status') || empty($record->status)) {
                $statusArray = [null, null, null];
            } else {
                try {
                    $statusArray = json_decode($record->status, true);
                    if (!is_array($statusArray) || count($statusArray) !== 3) {
                        $statusArray = [null, null, null];
                    }
                } catch (\Exception $e) {
                    Log::error('Error decoding status JSON: ' . $e->getMessage());
                    $statusArray = [null, null, null];
                }
            }
            
            Log::info('Status array before update:', $statusArray);
            
            $updateData = [
                'status' => null
            ];
            
            if (isset($request->diperiksa)) {
                $statusArray[0] = 'rejected';
                $updateData['diperiksa_oleh'] = $userId;
                Log::info('Updating diperiksa status to rejected');
            } elseif (isset($request->diketahui)) {
                $statusArray[1] = 'rejected';
                $updateData['diketahui_oleh'] = $userId;
                Log::info('Updating diketahui status to rejected');
            } elseif (isset($request->disetujui)) {
                $statusArray[2] = 'rejected';
                $updateData['disetujui_oleh'] = $userId;
                Log::info('Updating disetujui status to rejected');
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid rejection request'
                ]);
            }
            
            $updateData['status'] = json_encode($statusArray);
            
            Log::info('Status array after update:', $statusArray);
            Log::info('Update data:', $updateData);
            
            DB::table('FM_SHE_036_INSPEKSI_APAR')
                ->where('id', $id)
                ->update($updateData);
                    
            return response()->json([
                'success' => true,
                'message' => 'Document rejected successfully'
            ]);
            
        } catch (Exception $e) {
            Log::error('Error in Reject method: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $e->getMessage()
            ]);
        }
    }

    public function Reset($id, Request $request)
    {
        try {
            Log::info('Reset request for ID: ' . $id);
            
            $userId = $request->session()->get('user_id');
            Log::info('Current user ID: ' . $userId);
            
            $record = DB::table('FM_SHE_036_INSPEKSI_APAR')
                ->where('id', $id)
                ->first();
                
            if (!$record) {
                return response()->json([
                    'success' => false,
                    'message' => 'Record not found'
                ], 404);
            }
            
            Log::info('Record data:', (array)$record);
            
            $user = DB::table('users')
                ->where('userid', $userId)
                ->first();
                
            if (!$user) {
                Log::warning('User not found in users table: ' . $userId);
            } else {
                Log::info('User info:', ['userid' => $user->userid, 'username' => $user->username]);
            }
            
            $isAuthorized = ($record->dibuat_oleh == $userId) || 
                            in_array($userId, $this->user_sm);
            
            if (!$isAuthorized) {
                return response()->json([
                    'success' => false,
                    'message' => 'You are not authorized to reset this document'
                ]);
            }
            
            $resetStatus = json_encode([null, null, null]);
            
            DB::table('FM_SHE_036_INSPEKSI_APAR')
                ->where('id', $id)
                ->update([
                    'status' => $resetStatus,
                    'diperiksa_oleh' => null,
                    'diketahui_oleh' => null,
                    'disetujui_oleh' => null
                ]);
                
            Log::info('Status reset successfully');
            
            return response()->json([
                'success' => true,
                'message' => 'Approval status has been reset successfully'
            ]);
            
        } catch (Exception $e) {
            Log::error('Error in Reset method: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $e->getMessage()
            ]);
        }
    }

    
}