<?php

namespace Modules\SmartForm\App\Http\Controllers\LOG;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Barryvdh\DomPDF\Facade\Pdf;
use Modules\SmartForm\helpers\HrdHelper;
use Modules\SmartForm\helpers\Status;

class PengeluaranOilController extends Controller {

    private const TABLE_SITES = 'tsite';
    private const TABLE_KARYAWAN = 'TKaryawan';

    private const LIST_SHIFT = [
        'I' => 'I',
        'II' => 'II',
        'III' => 'III',
    ];

    private const LIST_JENIS = [
        'COOLANT' => 'COOLANT',
        'GREASE' => 'GREASE',
        'OIL' => 'OIL',
    ];

    private const LIST_MERKS = [
        "2000000202 - SEIKEN COOLANT 50%" => "2000000202 - SEIKEN COOLANT 50%",
        "2000000044 - COOLANT MULTIROAD RECO COOL" => "2000000044 - COOLANT MULTIROAD RECO COOL",
        "2000000056 - SYCG-AF-NACDMPZ" => "2000000056 - SYCG-AF-NACDMPZ",
        "2000000201 - COOLANT MULTIROAD RECO COOL" => "2000000201 - COOLANT MULTIROAD RECO COOL",
        "2000000066 - S2 V220-2" => "2000000066 - S2 V220-2",
        "2000000013 - EPX-NL 2" => "2000000013 - EPX-NL 2",
        "2000000020 - 15W-40 DH-1" => "2000000020 - 15W-40 DH-1",
        "2000000088 - EO15W/40 KGO" => "2000000088 - EO15W/40 KGO",
        "2000000018 - RIMULA R3 MV 15W-40" => "2000000018 - RIMULA R3 MV 15W-40",
        "2000000077 - HTCG1490" => "2000000077 - HTCG1490",
        "2000000015 - SPIRAX S2 A 85W-140" => "2000000015 - SPIRAX S2 A 85W-140",
        "2000000010 - SAE 10" => "2000000010 - SAE 10",
        "2000000023 - HTC46TP" => "2000000023 - HTC46TP",
        "2000000025 - SHELL TELLUS 46" => "2000000025 - SHELL TELLUS 46",
        "2000000017 - RIMULA R2 30W" => "2000000017 - RIMULA R2 30W",
        "2000000630 - S6 ATF A295" => "2000000630 - S6 ATF A295",
        "2000000096 - 75W-80" => "2000000096 - 75W-80",
        "2000000092 - T030 KGO" => "2000000092 - T030 KGO",
        "2000000006 - SAE 15W/40" => "2000000006 - SAE 15W/40",
        "2000000007 - T030 SAE 30" => "2000000007 - T030 SAE 30",
        "2000000008 - T010 SAE 10" => "2000000008 - T010 SAE 10",
        "2000000014 - SPIRAX S2 A 80W-90" => "2000000014 - SPIRAX S2 A 80W-90",
        "2000000019 - TELLUS 68" => "2000000019 - TELLUS 68",
        "2000000049 - S2 M46" => "2000000049 - S2 M46",
        "2000000051 - RIMULA R2 10W" => "2000000051 - RIMULA R2 10W",
        "2000000043 - KGO-H046" => "2000000043 - KGO-H046"
    ];

    private const LIST_COMPONENT = [
        "ENGINE" => "ENGINE",
        "TRANSMISSION" => "TRANSMISSION",
        "FINAL DRIVE LH" => "FINAL DRIVE LH",
        "FINAL DRIVE RH" => "FINAL DRIVE RH",
        "HYDRAULIC" => "HYDRAULIC",
        "PTO" => "PTO",
        "SWING" => "SWING",
        "RADIATOR" => "RADIATOR",
        "DAMPER" => "DAMPER",
        "DIFFERENTIAL FRONT" => "DIFFERENTIAL FRONT",
        "DIFFERENTIAL CENTER" => "DIFFERENTIAL CENTER",
        "DIFFERENTIAL REAR" => "DIFFERENTIAL REAR",
        "DIFFERENTIAL" => "DIFFERENTIAL",
        "TRANSFER" => "TRANSFER",
        "BRAKE COOLING" => "BRAKE COOLING",
        "GEAR BOX" => "GEAR BOX",
        "TRANSFER CASE" => "TRANSFER CASE",
        "TANDEM RH" => "TANDEM RH",
        "TANDEM LH" => "TANDEM LH",
        "FRONT HUB LH" => "FRONT HUB LH",
        "FRONT HUB RH" => "FRONT HUB RH",
        "LUBRICATION LINE" => "LUBRICATION LINE",
        "BRAKE" => "BRAKE",
        "PIVOT" => "PIVOT",
        "SUSPENSION RR RH" => "SUSPENSION RR RH",
        "SUSPENSION RR LH" => "SUSPENSION RR LH",
        "TRACK ADJUSTER" => "TRACK ADJUSTER",
        "CIRCLE" => "CIRCLE",
        "ROTARY" => "ROTARY",
        "FINAL DRIVE RR RH" => "FINAL DRIVE RR RH",
        "FINAL DRIVE RR LH" => "FINAL DRIVE RR LH",
        "SWING FRONT" => "SWING FRONT",
        "SWING REAR" => "SWING REAR",
        "SWING RH" => "SWING RH",
        "SWING LH" => "SWING LH",
        "RESERVOIR" => "RESERVOIR",
        "COMPRESOR" => "COMPRESOR",
        "TELESCOPIC" => "TELESCOPIC",
        "STEERING" => "STEERING",
        "BAKE SHAFT" => "BAKE SHAFT",
        "TRAVEL REDUCTION GEAR RH" => "TRAVEL REDUCTION GEAR RH",
        "TRAVEL REDUCTION GEAR LH" => "TRAVEL REDUCTION GEAR LH",
        "MAIN PUMP" => "MAIN PUMP",
        "SUBTANK" => "SUBTANK",
        "FIBRASI DRUM" => "FIBRASI DRUM"
    ];

    private const LIST_REMARKS = [
        "ADD" => "ADD",
        "CHANGE" => "CHANGE",
        "GREASING" => "GREASING",
        "REKONDISI" => "REKONDISI",
        "BREAKDOWN" => "BREAKDOWN"
    ];


    public function PengeluaranOliDashboard()
    {
        return view('SmartForm::LOG/pengeluaran-oli/dashboard-pengeluaran-oil');
    }

    public function GetListPengeluaranOli(Request $request) {
        $TABLE_PENGELUARAN_OLI = "FM_LOG_034_PENGELUARAN_OLI";
        $TABLE_KARYAWAN = "HRD.dbo.TKaryawan";
        $response = array(
            'message' => '',
            'isSuccess' => false
        );
    
        try {
            // Get pagination parameters
            $page = $request->query('offset', 0) / $request->query('limit', 10) + 1;
            $perPage = $request->query('limit', 10);
            $sort = $request->query('sort', 'id');
            $order = $request->query('order', 'desc');
            
            // Get filters from request
            $filters = $request->query('filters', []);
            $search = $request->query('search', '');
    
            $query = DB::table($TABLE_PENGELUARAN_OLI)
                ->select(
                    $TABLE_PENGELUARAN_OLI.'.id', 
                    $TABLE_PENGELUARAN_OLI.'.no_dok', 
                    $TABLE_PENGELUARAN_OLI.'.job_site as site', 
                    $TABLE_PENGELUARAN_OLI.'.no_lube_station as lube',
                    $TABLE_PENGELUARAN_OLI.'.status_req',
                    $TABLE_PENGELUARAN_OLI.'.dilaporkan_oleh',
                    DB::raw('(SELECT Nama FROM '.$TABLE_KARYAWAN.' WHERE NIK = '.$TABLE_PENGELUARAN_OLI.'.dilaporkan_oleh) as reported_by_name'),
                    $TABLE_PENGELUARAN_OLI.'.created_at',
                    DB::raw('(SELECT Nama FROM '.$TABLE_KARYAWAN.' WHERE NIK = '.$TABLE_PENGELUARAN_OLI.'.diketahui_oleh) as approval_by'),
                    $TABLE_PENGELUARAN_OLI.'.updated_at'
                );
    
            // Apply filters
            foreach ($filters as $field => $value) {
                if ($value) {
                    if ($field === 'dilaporkan_oleh') {
                        $findUser = DB::connection('sqlsrv2')->table($TABLE_KARYAWAN)
                            ->where('Nama', 'like', '%' . $value . '%')
                            ->first();
                        
                        if ($findUser) {    
                            $query->where($TABLE_PENGELUARAN_OLI.'.dilaporkan_oleh', $findUser->NIK);
                        } else {
                            $query->where($TABLE_PENGELUARAN_OLI.'.dilaporkan_oleh', null);
                        }
                    } else {
                        $query->where($TABLE_PENGELUARAN_OLI.'.'.$field, 'like', '%' . $value . '%');
                    }
                }
            }
    
            // Apply search
            if ($search) {
                $query->where(function($q) use ($search, $TABLE_PENGELUARAN_OLI, $TABLE_KARYAWAN) {
                    $q->where($TABLE_PENGELUARAN_OLI.'.no_dok', 'like', '%' . $search . '%')
                      ->orWhere($TABLE_PENGELUARAN_OLI.'.job_site', 'like', '%' . $search . '%')
                      ->orWhere($TABLE_PENGELUARAN_OLI.'.no_lube_station', 'like', '%' . $search . '%')
                      ->orWhere(DB::raw('(SELECT Nama FROM '.$TABLE_KARYAWAN.' WHERE NIK = '.$TABLE_PENGELUARAN_OLI.'.dilaporkan_oleh)'), 'like', '%' . $search . '%');
                });
            }
    
            // Get total count before pagination
            $total = $query->count();
    
            // Apply sorting and pagination
            $documents = $query->orderBy($sort, $order)
                              ->paginate($perPage, ['*'], 'page', $page);
    
            $response['message'] = "Ok";
            $response['isSuccess'] = true;
            $response['data'] = [
                'total' => $total,
                'totalNotFiltered' => $total,
                'rows' => $documents->items()
            ];
    
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            
            $response['message'] = $ex->getMessage();
            $response['isSuccess'] = false;
        }
    
        return response()->json($response);
    }

    public function formPengeluaranOli() {
        $sites = DB::connection('sqlsrv2')->table(self::TABLE_SITES)->select(columns: 'KodeST')->get();
        $users = DB::connection('sqlsrv2')->table(self::TABLE_KARYAWAN)->select('NIK', 'nama')->get();
        $shifts = self::LIST_SHIFT;
        $jenis = self::LIST_JENIS;
        $merks = self::LIST_MERKS;
        $components = self::LIST_COMPONENT;
        $remarks = self::LIST_REMARKS;


        return view("SmartForm::LOG/pengeluaran-oli/form-pengeluaran-oli",
        compact('sites','users','shifts','jenis','merks','components','remarks'));
    }

    function SubmitFormPengeluaranOli(Request $req) {
        $TABLE_MASTER = "FM_LOG_034_PENGELUARAN_OLI";
        $TABLE_DETAIL = "FM_LOG_034_PENGELUARAN_OLI_DETAIL";
        $response = array(
            'message' => "",
            'isSuccess' => false
        );

        $tgl = now()->toDateTimeString();
        $requested_by = $req->session()->get('user_id');
        $data = $req->input();
        
        $data_insert = [
            'no_dok' => $data['noDoc'],
            'revisi' => "1",
            'created_at' => $data['tglDoc'],
            'halaman' => "1 dari 1",
            'job_site' => $data['jobSite'],
            'no_lube_station' => $data['lube'],
            'shift' => $data['shift'],
            'dilaporkan_oleh' => $requested_by,
            'diketahui_oleh' => $data['foreman'],
            'status_req' => STATUS::NEED_APPROVED,
        ];

        $spliited_no_doc = explode("/", $data_insert['no_dok']);
        $data_item = json_decode($data['item']);
        
        try {
            DB::beginTransaction();
            $id = DB::table($TABLE_MASTER)->insertGetId($data_insert);

            foreach ($data_item as $data_item_detail) {
                DB::table($TABLE_DETAIL)->insert(array(
                    'id_peng_oli' => $id,
                    'unit' => $data_item_detail->unit,
                    'time' => $data_item_detail->time,
                    'hm' => $data_item_detail->hm,
                    'jenis' => $data_item_detail->jenis,
                    'merk' => $data_item_detail->merk,
                    'awal' => $data_item_detail->awal,
                    'akhir' => $data_item_detail->akhir,
                    'qty' => $data_item_detail->qty,
                    'component' => $data_item_detail->compo,
                    'remark' => $data_item_detail->remark,
                    'pic_nama' => $data_item_detail->pic
                ));
            }

            $spliited_no_doc[0] = $id;
            $updated_no_doc = implode("/", $spliited_no_doc);

            $affected = DB::table($TABLE_MASTER)
              ->where('id', $id)
              ->update(['no_dok' => $updated_no_doc]);

            Db::commit();


            $response['message'] = "Ok";
            $response['isSuccess'] = true;
            $response['data'] = array(
                'no_doc' => $updated_no_doc
            );
        } catch (Exception $ex) {
            //throw $th;
            Log::error($ex->getTraceAsString());
            DB::rollBack();
            $response['message'] = $ex->getMessage();
            $response['isSuccess'] = false;
        }

        return response()->json($response);
    }

    public function PdfPengeluaranOli($id)
    {
        $TABLE_MASTER = "FM_LOG_034_PENGELUARAN_OLI";
        $TABLE_DETAIL = "FM_LOG_034_PENGELUARAN_OLI_DETAIL";
        $errors = array(
            'error' => false,
            'message' => ''
        );
        try {
            $data = DB::table($TABLE_MASTER)
                    ->select('id', 'no_dok','revisi','tanggal','job_site as jobsite','no_lube_station as nolube','shift','dilaporkan_oleh as pelapor','diketahui_oleh as mengetahui')
                    ->where('id', $id)
                    ->first();
                
            $data_detail = DB::table($TABLE_DETAIL)
                ->select('id_peng_oli','unit','time','hm','jenis','merk','awal','akhir','qty','component','remark','pic_nama as pic')
                ->where('id_peng_oli', $data->id)
                ->get();
            
            $nomor = 1;
            foreach($data_detail as $detail) {
                $detail->nomor = $nomor;            
                $nomor++;
            }
        
            $data_master['id'] = $data->id;
            $data_master['no_dok'] = $data->no_dok;
            $data_master['jobsite'] = $data->jobsite;
            $data_master['tanggal'] = $data->tanggal;
            $data_master['pelapor'] = $data->pelapor;
            $data_master['mengetahui'] = $data->mengetahui;
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
        }
        Log::info("data_master : ". json_encode($data_master));
        $pdf = PDF::loadView('SmartForm::LOG/pengeluaran-oli-pdf',  ['data' => $data_master, 'data_detail' => $data_detail, 'error' => $errors])->setPaper('a4', 'landscape');
        return $pdf->download('BSS-FRM-LOG-034.pdf');
    }
}