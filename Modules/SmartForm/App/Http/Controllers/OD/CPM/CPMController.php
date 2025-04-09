<?php

namespace Modules\SmartForm\App\Http\Controllers\OD\CPM;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Modules\SmartForm\App\Models\CPMApproval;
use Modules\SmartForm\App\Models\CPMMForm;
use Modules\SmartForm\App\Models\CPMMFormDtl;

class CPMController extends Controller
{
    const T_CPM_APPROVAL = 'cpm_approval';
    const T_CPM_ACTIVITY_LOGS = 'cpm_activity_logs';
    const T_M_APPROVAL = 'cpm_m_form_approval';
    const T_M_JENIS_APPROVAL = 'cpm_m_form_jenis_approval';
    const T_M_OBJ = 'cpm_m_obj';
    const T_M_OBJ_CAT = 'cpm_m_obj_category';
    const T_HRD_KARYAWAN = 'TKaryawan';
    const T_HRD_DEPT = 'tdepartement';
    const T_HRD_SITE = 'tsite';
    const CPM_FORM_STATUS = [
        '0' => 'Not Yet',
        '1' => 'Approved',
        '-1' => 'Rejected'
    ];

    public function Index()
    {
        return view('smartform::OD/CPM/index');
    }

    public function Form()
    {
        // dd($this->getApproval('JKT'));
        return view('smartform::OD/CPM/form');
    }

    public function FormDtl($id)
    {
        $formCPM = CPMMForm::select('id', 'KodeST', DB::raw('YEAR(TanggalSubmit) as TanggalSubmit'))->where('id', $id)->first();

        if(!$formCPM) abort(404);
        $approvalColoumn = [];
        
        $dataApprove = $this->getCurrentFormAprroval($id)->get();
        foreach ($dataApprove->toArray() as $value) {
            $value->sttsMapping = self::CPM_FORM_STATUS[$value->stts];
            if(!isset($approvalColoumn[$value->approval_jenis])) $approvalColoumn[$value->approval_jenis] = 1;
            else {
                $approvalColoumn[$value->approval_jenis]++;
            }
        }

        
        // dd($dataApprove);
        $approvalData = [
            'column' => $approvalColoumn,
            'data' => $dataApprove->toArray(),
            'current' => $dataApprove->where('stts', 0)->first()
        ];
        $riwayatCPM = $this->getRevisiCPM($formCPM->id);
        // dd($riwayatCPM);
        // dd($this->getCurrentFormAprroval($id)->get()->toArray());
        // dd($approvalData);
        return view('smartform::OD/CPM/form-dtl', [
            'idForm' => $id,
            'dataCPM' => $formCPM,
            'approval' => $approvalData,
            'riwayatCPM' => $riwayatCPM
        ]);
    }

    public function ApprovalAction(Request $request)
    {
        $isSuccess = false;
        $msg = '';
        $errMsg = [];
        $nik_session = $request->session()->get('user_id');
        $tglNow = now();

        $validator = Validator::make(
            $request->all(), 
            [
                'document' => ['required'], 
                'approvalValue' => ['required']
            ],
            [
                'document.required' => 'Document wajib diisi',
                'approvalValue.required' => 'approvalValue wajib diisi.'
            ]
        );
        $reqValidateResult = $validator->errors()->all();

        if(count($reqValidateResult) > 0) {
            $msg = 'Error mandatory field';
            $errMsg = $reqValidateResult;
        } else {
            $idForm = $request->input('document');
            $approvalValue = $request->input('approvalValue');
            $keterangan = $request->input('keterangan');
            // dd($formCPM = CPMMForm::select()->where('id', $idForm)->first());

            try {
                DB::beginTransaction();
                DB::enableQueryLog();
                DB::getQueryLog();
                $formCPM = CPMMForm::select()->where('id', $idForm)->first();
                
                if(!$formCPM) {
                    $msg = 'Data tidak ditemukan';
                } else {
                    $listApproval = $this->getCurrentFormAprroval($formCPM->id)->get();
                    $currentApproval = $listApproval->where('stts', 0)->first();

                    // dd($listApproval->toArray());
                    if(!$currentApproval) {
                        $msg = 'Unauthorized request';
                    } else {
                        $lastApproval = $listApproval[count($listApproval)-1];
                        // dd($lastApproval);
                        $isLastApproval = $lastApproval->id == $currentApproval->id;

                        if($currentApproval->nik != $nik_session) {
                            $msg = 'Unauthorized request';
                        } else {
                            $dataUpdate = [
                                'stts' => $approvalValue,
                                'updated_by' => $nik_session
                            ];

                            if($approvalValue == -1) $dataUpdate['keterangan'] = $keterangan;
        
                            $approvalUpdate = CPMApproval::where('id', $currentApproval->id)
                                ->where('is_deleted', 0)
                                ->update($dataUpdate);

                            if($isLastApproval && $approvalValue == 1) {
                                $formCPM->stts = 1;
                                $formCPM->updated_by = $nik_session;
                                $formCPM->save();
                            }

                            if($approvalValue == -1) {
                                CPMMForm::where('id', $idForm)
                                    ->update([
                                        'stts' => -1,
                                        'updated_by' => $nik_session,
                                        'updated_at' => $tglNow,
                                        'keterangan'=> $keterangan
                                    ]);
                                // $formCPM->stts = -1;
                                // $formCPM->updated_by = $nik_session;
                                // $formCPM->keterangan = $keterangan;
                                // $formCPM->save();
                            }

                            $isSuccess = true;
                            $msg = 'Berhail update';
                        }
                    }
                }
                DB::commit();
            } catch (Exception $ex) {
                DB::rollBack();
                $msg = 'Terjadi kesalahan';
                Log::error($ex->getMessage());
                Log::error($ex->getTraceAsString());
            }
        }

        return response()->json([
            'isSuccess' => $isSuccess,
            'message' => $msg,
            'errorMessage' => $errMsg
        ]);
    }

    public function FormDtlData(Request $request) {
        $isSuccess = false;
        $message = '';
        $errorMessage = [];
        $data = null;
        $idForm = $request->query('id');
        $revisiKe = $request->query('revisiKe');
        // dd($request->query());
        // $riwayatRevisi = $request->query('riwayatRevisi', 0);
        if(!$idForm) abort(404);

        try {
            // return response()->json($dataRevisi);
            // dd('a');
            if($revisiKe) {
                // dd('a');
                $dataRevisi = $this->getListHistoryCPM($idForm, $revisiKe);
                $data = $dataRevisi;
            } else {
                $data = CPMMFormDtl::from('cpm_m_form_dtl as fd')->select(
                    'fd.id', 'fd.id_m_obj as objective_id', 'mo.nama as objective_name', 'moc.nama as category', 'fd.id_m_cpm', 'fd.UOM', 'fd.HIG_HIB' ,'fd.created_by','fd.is_deleted', 'fd.stts', 
                    'fd.plan_b_1', 'fd.act_b_1', 'fd.plan_b_2', 'fd.act_b_2', 'fd.plan_b_3', 'fd.act_b_3', 'fd.plan_b_4', 'fd.act_b_4', 
                    'fd.plan_b_5', 'fd.act_b_5', 'fd.plan_b_6', 'fd.act_b_6', 'fd.plan_b_7', 'fd.act_b_7', 'fd.plan_b_8', 'fd.act_b_8',
                    'fd.plan_b_9', 'fd.act_b_9', 'fd.plan_b_10', 'fd.act_b_10', 'fd.plan_b_11', 'fd.act_b_11', 'fd.plan_b_12', 'fd.act_b_12',
                    'fd.plan_q1', 'fd.act_q1', 'fd.plan_q2', 'fd.act_q2', 'fd.plan_q3', 'fd.act_q3', 'fd.plan_q4', 'fd.act_q4',
                    'fd.plan_yearly', 'fd.act_yearly'
                )
                    ->leftJoin(self::T_M_OBJ . ' as mo', 'mo.id', '=', 'id_m_obj')
                    ->leftJoin(self::T_M_OBJ_CAT . ' as moc', 'moc.id', '=', 'mo.id_obj_category')
                    ->where('id_m_cpm', $idForm);
                
                $data = $data->get()->toArray();
            }

            // dd($data->get()->toArray());
            // $data = $dataRevisi;
            $message = 'Ok';
            $isSuccess = true;

        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
        }

        return response()->json([
            'isSuccess' => $isSuccess,
            'message' => $message,
            'errorMessage' => $errorMessage,
            'data' => $data
        ]);
    }

    public function FormSubmit(Request $request)
    {
        $isSuccess = false;
        $msg = "";
        $errMsg = "";
        $nik_session = $request->session()->get('user_id');
        $tglNow = now();

        if($this->checkCPMExist($request->input('tahun'), $request->input('KodeST'))) {
            $msg = "Data sudah ada!";
        } else {
            $KodeST = $request->input('KodeST');
            $listApproval = $this->getApproval($KodeST);
            if(count($listApproval) < 1) {
                $msg = "Approval untuk Site " . $KodeST . " belum ada";
            } else {
                try {
                    DB::beginTransaction();
                    $dtlReq = $request->input('dtl');
        
                    $formCPM = CPMMForm::create([
                        'KodeST' => $KodeST,
                        'TanggalSubmit' => $request->input('tahun'),
                        'created_by' => $nik_session
                    ]);
        
                    foreach ($dtlReq as $value) {
                        CPMMFormDtl::create([
                            'id_m_obj' => $value['id'],
                            'id_m_cpm' => $formCPM->id,
                            'UOM' => $value['uom'],
                            'HIG_HIB' => $value['hig_hib'],
                            'plan_b_1' => $value['januari'],
                            'plan_b_2' => $value['februari'],
                            'plan_b_3' => $value['maret'],
                            'plan_b_4' => $value['april'],
                            'plan_b_5' => $value['mei'],
                            'plan_b_6' => $value['juni'],
                            'plan_b_7' => $value['juli'],
                            'plan_b_8' => $value['agustus'],
                            'plan_b_9' => $value['september'],
                            'plan_b_10' => $value['oktober'],
                            'plan_b_11' => $value['november'],
                            'plan_b_12' => $value['desember'],
                            'plan_q1' => $value['q1'],
                            'plan_q2' => $value['q2'],
                            'plan_q3' => $value['q3'],
                            'plan_q4' => $value['q4'],
                            'plan_yearly' => $value['yearly'],
                        ]);
                    }

                    foreach ($listApproval as $appovalCPM) {
                        DB::table(self::T_CPM_APPROVAL)->insert([
                            'id_m_cpm' => $formCPM->id,
                            'id_m_approval' => $appovalCPM->id,
                            'stts' => 0,
                            'is_deleted' => 0,
                            'created_by' => $nik_session,
                            'created_at' => $tglNow,
                            'urutan' => $appovalCPM->urutan
                        ]);
                    }
        
                    DB::commit();
                    $isSuccess = true;
                    $msg = 'Berhasil';
                } catch (Exception $ex) {
                    DB::rollBack();
                    Log::error($ex->getMessage());
                    Log::error($ex->getTraceAsString());
                }
            }

        }

        return response()->json([
            'isSuccess' => $isSuccess,
            'message' => $msg,
            'errorMessage' => $errMsg
        ]);
    }

    public function FormEdit($id) 
    {
        $formCPM = CPMMForm::select('id', 'cpm_m_form.KodeST', DB::raw('YEAR(TanggalSubmit) as TanggalSubmit'), 'ts.nama as site')
            ->leftJoin(DB::connection('sqlsrv2')->getDatabaseName() . '.dbo.'. self::T_HRD_SITE . ' as ts', 'ts.KodeST', '=', 'cpm_m_form.KodeST')
            ->where('cpm_m_form.id', $id)->first();
        // dd($formCPM->revisionHistory[1]);

        if(!$formCPM) abort(404);
        return view('smartform::OD/CPM/form-edit',  [
            'idForm' => $id,
            'dataCPM' => $formCPM
        ]);
    }

    public function FormEditSubmit(Request $request)
    {
        // $currentApproval = $this->getCurrentFormAprroval($request->query('idCPM'))->get()->toArray();
        // dd(array_column($currentApproval, 'id'));
        // return 'a';
        // dd($request->all());
        /*
            contoh request
            {
            "idCPM": 1,
            "dtl": {
                "deleted": [
                    {
                        "id": 4,
                        "objective_id": "142"
                    }
                ],
                "changed": [
                    {
                        "id": 2,
                        "detail": {
                            "plan_b_1": "10"
                        }
                    }
                ],
                "added": [
                    {
                        "id": 0,
                        "objective_id": "182",
                        "objective_name": "Catering Delivery On Time",
                        "category": "GENERAL SERVICE",
                        "id_m_cpm": null,
                        "UOM": "",
                        "HIG_HIB": "",
                        "created_by": null,
                        "is_deleted": null,
                        "stts": 0,
                        "plan_b_1": 0,
                        "act_b_1": 0,
                        "plan_b_2": 0,
                        "act_b_2": 0,
                        "plan_b_3": 0,
                        "act_b_3": 0,
                        "plan_b_4": 0,
                        "act_b_4": 0,
                        "plan_b_5": 0,
                        "act_b_5": 0,
                        "plan_b_6": 0,
                        "act_b_6": 0,
                        "plan_b_7": 0,
                        "act_b_7": 0,
                        "plan_b_8": 0,
                        "act_b_8": 0,
                        "plan_b_9": 0,
                        "act_b_9": 0,
                        "plan_b_10": 0,
                        "act_b_10": 0,
                        "plan_b_11": 0,
                        "act_b_11": 0,
                        "plan_b_12": 0,
                        "act_b_12": 0,
                        "plan_q1": 0,
                        "act_q1": 0,
                        "plan_q2": 0,
                        "act_q2": 0,
                        "plan_q3": 0,
                        "act_q3": 0,
                        "plan_q4": 0,
                        "act_q4": 0,
                        "plan_yearly": 0,
                        "act_yearly": 0
                    }
                ]
            }
        }
        */
        // return 'a';
        $isSuccess = false;
        $msg = '';
        $errMsg = [];
        $data = null;

        // $validator = Validator::make(
        //     $request->all(), 
        //     [
        //         'idCPM' => ['require'], 
        //         'dtl' => ['required', 'array'],
        //         // 'dtl.deleted' => ['required', 'array'],
        //         // 'dtl.changed' => ['required', 'array'],
        //         // 'dtl.added' => ['required', 'array']
        //     ],
        //     [
        //         'idCPM.required' => 'CPM wajib diisi',
        //         'dtl.required' => 'detail wajib diisi',
        //         // 'dtl.deleted.required' => 'deleted wajib diisi',
        //         // 'dtl.changed.required' => 'changed wajib diisi',
        //         // 'dtl.added.required' => 'added wajib diisi',
        //         // 'dtl.array' => 'detail bukan array',
        //         // 'dtl.deleted.array' => 'deleted bukan array',
        //         // 'dtl.changed.array' => 'changed bukan array',
        //         // 'dtl.added.array' => 'added bukan array'
        //     ]
        // );
        // // $validatorErr = $validator->errors()->all();
        // dd($validator);
        // // return;

        // if(count($validatorErr) > 0) {
        //     $msg = 'Error request validation';
        //     $errMsg = $validatorErr;

        //     return response()->json([
        //         'isSuccess' => $isSuccess,
        //         'message' => $msg,
        //         'errorMessage' => $errMsg,
        //         'data' => $data
        //     ]);
        // }
        // dd($validatorErr);
        $idCPM = $request->query('idCPM');
        $tglNow = now();
        $nik_session = $request->session()->get('user_id');

        // save history form
        $selectedData = CPMMForm::with('details')->where('id', $idCPM)->first();
        // dd($selectedData);
        if(!$selectedData) return abort(404);
        
        $dataForm = [
            'master' => null,
            'detail' => null
        ];
        $decodedData = json_decode($selectedData->toJson(), true);
        $dataForm['detail'] = $decodedData['details'];
        $dataForm['master'] = $decodedData;
        unset($dataForm['master']['details']);

        $latestHistory = $this->CPMHistory($idCPM);
        $nextRevisi = 0;

        if($latestHistory) $nextRevisi = $latestHistory->revisi_ke + 1;
        $idLog = 0;

        try {
            DB::beginTransaction();
            $updateReq = $request->input('dtl.changed');
            $deleteReq = $request->input('dtl.deleted');
            $addedReq = $request->input('dtl.added');
            $restoredReq = $request->input('dtl.restored');

            // dd(['update' => $updateReq, 'delete' => $deleteReq, 'addedReq' => $addedReq]);

            foreach ($updateReq as $nilai1) {
                CPMMFormDtl::where('id', $nilai1['id'])->update($nilai1['detail']);
            }
            foreach ($deleteReq as $nilai2) {
                CPMMFormDtl::where('id', $nilai2['id'])->update([
                    'is_deleted' => 1
                ]);
            }

            foreach ($addedReq as $nilai3) {
                unset($nilai3['id']);
                $nilai3['id_m_obj'] = $nilai3['objective_id'];

                CPMMFormDtl::create($nilai3);
            }

            foreach ($restoredReq as $nilai4) {

                CPMMFormDtl::where('id', $nilai4)->update([
                    'is_deleted' => 0
                ]);
            }

            $idLog = DB::table(self::T_CPM_ACTIVITY_LOGS)->insertGetId([
                'id_m_cpm' => $idCPM,
                'changed_type' => 'update',
                'changed_dtl' => $selectedData->toJson(),
                'created_at' => $tglNow,
                'created_by' => $nik_session,
                'revisi_ke' => $nextRevisi
            ]);

            if($selectedData->stts != 0) {
                $selectedData->stts = 0;
                $selectedData->keterangan = null;
                $selectedData->updated_by = $nik_session;
                $selectedData->save();
            }
            // if($selectedData->stts != 0) {
                // todo : get approval sebelumnya, set is_deleted = 1, generate new approval
                $currentApproval = $this->getCurrentFormAprroval($idCPM)->get()->toArray();
                $approvalIDs = array_column($currentApproval, 'id');
                DB::table(self::T_CPM_APPROVAL)->whereIn('id', $approvalIDs)->update([
                    'is_deleted' => 1,
                    'updated_by' => $nik_session,
                    'updated_at' => $tglNow
                ]);

                $newAppoval = $this->getApproval($selectedData->KodeST);

                foreach ($newAppoval as $appovalCPM) {
                    DB::table(self::T_CPM_APPROVAL)->insert([
                        'id_m_cpm' => $idCPM,
                        'id_m_approval' => $appovalCPM->id,
                        'stts' => 0,
                        'is_deleted' => 0,
                        'created_by' => $nik_session,
                        'created_at' => $tglNow,
                        'urutan' => $appovalCPM->urutan
                    ]);
                }
                $msg = 'Berhasil update data';
                $isSuccess = true;
                
            // }

            DB::commit();
        } catch (Exception $ex) {
            DB::rollBack();
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
        }

        $data['log_id'] = $idLog;

        return response()->json([
            'isSuccess' => $isSuccess,
            'message' => $msg,
            'errorMessage' => $errMsg,
            'data' => $data
        ]);

        // dd(CPMMForm::with('details')->where('id', $request->query('idCPM'))->first()->toJson(JSON_PRETTY_PRINT));
        
    } 

    public function ListCPM(Request $request)
    {
        $data = [
            'total' => 0,
            'totalNotFiltered' => 0,
            'rows' => []
        ];
        $isSuccess = false;
        $message = '';
        $errorMessage = '';

        $sort = $request->query('sort', 'id'); // Default sort by id
        $order = $request->query('order', 'asc'); // Default order is ascending
        $offset = $request->query('offset', 0); // Default offset
        $limit = $request->query('limit', 10); 
        $site = $request->query('site'); 
        $periode = $request->query('periode'); 

        try {
            $sql_master_data = CPMMForm::select("id","KodeST", DB::raw('YEAR(TanggalSubmit) as Tahun'), 'stts', 'created_by', 'keterangan');

            if($site) $sql_master_data = $sql_master_data->where('KodeST', $site);
            if($periode) $sql_master_data = $sql_master_data->whereYear('TanggalSubmit', $periode);
            
            $jml = $sql_master_data->count();

            if($limit == null || $limit == 'null' || $limit == '') {
                $sql_master_data->skip($offset);
            } else {
                $sql_master_data->skip($offset)->limit($limit);
            }

            
            $master_data = $sql_master_data->get();

            $data = [
                'total' => $jml,
                'totalNotFiltered' => $jml,
                'rows' => $master_data
            ];
            $message= "Ok";
            $isSuccess = true;

        }  catch (Exception $ex) {
            $message = 'Terjadi kesalahan, coba beberapa saat lagi!';
            $errorMessage = [$message];

            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
        }
        
        return response()->json([
            'isSuccess' => $isSuccess,
            'message' => $message,
            'errorMessage' => $errorMessage,
            'data' => $data
        ]);
    }

    public function IndexObjective ()
    {
        return view('SmartForm::OD/CPM/index-objective');
    }

    public function SubmitObjective(Request $request)
    {
        $isSuccess = false;
        $msg = '';
        $errMsg = [];
        $nik_session = $request->session()->get('user_id');
        $tglNow = now();

        try {
            $nama = $request->input('nama');
            $categoryId = $request->input('categoryId');
            DB::beginTransaction();

            $insertedData = DB::table(self::T_M_OBJ)->insertGetId([
                'id_obj_category' => $categoryId,
                'nama' => $nama,
                'created_at' => $tglNow,
                'created_by' => $nik_session
            ]);

            DB::commit();

            $msg = 'Berhasil tambah objective';
            $isSuccess = true;
            
        } catch (Exception $ex) {
            DB::rollBack();
            Log::error('SubmitObjective : ' . $ex->getMessage());
            Log::error($ex->getTraceAsString());
        }

        return response()->json([
            'isSuccess' => $isSuccess,
            'message' => $msg,
            'errorMessage' => $errMsg,
        ]);
    }

    public function ListObjective (Request $request)
    {
        $isSuccess = false;
        $msg = '';
        $errMsg = [];
        $data = null;

        $sort = $request->query('sort', 'id'); // Default sort by id
        $order = $request->query('order', 'asc'); // Default order is ascending
        $offset = $request->query('offset', 0); // Default offset
        $limit = $request->query('limit', 10); 

        try {
            $sqlDataObjective = DB::table(self::T_M_OBJ . ' as mo')
                ->select(
                    'mo.id', 'mo.nama', 'moc.nama as category'
                )
                ->leftJoin(self::T_M_OBJ_CAT . ' as moc', 'mo.id_obj_category', '=', 'moc.id');

            $jml = $sqlDataObjective->count();

            if($limit == null || $limit == 'null' || $limit == '') {
                $sqlDataObjective->skip($offset);
            } else {
                $sqlDataObjective->skip($offset)->limit($limit);
            }
            $masterData = $sqlDataObjective->get();

            $data = [
                'total' => $jml,
                'totalNotFiltered' => $jml,
                'rows' => $masterData
            ];

            $msg = "Ok";
            $isSuccess = true;
        } catch (Exception $ex) {
            $msg = 'Terjadi kesalahan, coba beberapa saat lagi';
            Log::error('ListObjective : ' . $ex->getMessage());
            Log::error($ex->getTraceAsString());
        }

        return response()->json([
            'isSuccess' => $isSuccess,
            'message' => $msg,
            'errorMessage' => $errMsg,
            'data' => $data
        ]);
    }

    public function AddObjectiveCategory(Request $request)
    {
        $id = null;
        $text = '';
        $nik_session = $request->session()->get('user_id');
        $tglNow = now();

        $reqText = $request->input('text');
        try {
            DB::beginTransaction();

            $insertedData = DB::table(self::T_M_OBJ_CAT)->insertGetId([
                'nama' => $reqText,
                'created_by' => $nik_session,
                'created_at' => $tglNow
            ]);
            $id = $insertedData;

            DB::commit();
        } catch (Exception $ex) {
            DB::rollBack();
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
        }

        return response()->json([
            'id' => $id, 'text' => $reqText
        ]);
    }

    private function checkCPMExist($tahun, $KodeST)
    {
        $isExist = false;

        try {
            $isExist = CPMMForm::whereYear('TanggalSubmit', $tahun)->where('KodeST', $KodeST)->exists();
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
        }

        return false;
    }

    private function getApproval($KodeST)
    {   
        $listApproval = [];
        try {
            $listApproval = DB::table(self::T_M_APPROVAL . ' as mfa')
                ->select( 'mfa.id', 'mfa.nik', 'mfa.KodeST', 'mfa.KodeDP', 'mfa.urutan', 'mfja.nama as jenis')
                ->leftJoin(self::T_M_JENIS_APPROVAL . ' as mfja', 'mfja.id', '=', 'mfa.id_jenis_approval')
                ->where('mfa.KodeST', $KodeST)
                ->orderBy('mfja.urutan')
                ->orderBy('mfa.urutan')->get();
        } catch (Exception $ex) {
            Log::error($ex->getTraceAsString());
        }

        return $listApproval;
    }

    private function getCurrentFormAprroval($idForm)
    {
        $currentApproval = null;

        try {
            $currentApproval = DB::table(self::T_CPM_APPROVAL . ' as ca')
                ->leftJoin(self::T_M_APPROVAL . ' as ma', 'ma.id', '=', 'ca.id_m_approval')
                ->leftJoin(self::T_M_JENIS_APPROVAL . ' as mja', 'mja.id', '=', 'ma.id_jenis_approval')
                ->leftJoin(DB::connection('sqlsrv2')->getDatabaseName() . '.dbo.' . self::T_HRD_KARYAWAN . ' as tk', 'ma.nik', '=', 'tk.NIK')
                ->select('ca.id', 'ca.stts', 'ma.nik', 'mja.nama as approval_jenis', 'tk.Nama')
                ->orderBy('mja.urutan')
                ->orderBy('ca.urutan')
                ->where('id_m_cpm', $idForm)
                ->where('ca.is_deleted', 0);
                // dd($currentApproval->toRawSql());
        } catch (Exception $ex) {
            Log::error($ex->getTraceAsString());
        }

        return $currentApproval;
    }

    private function CPMHistory($idCPM) 
    {
        $dataHistoryCPM = DB::table(self::T_CPM_ACTIVITY_LOGS)->where('id_m_cpm', $idCPM)->orderByDesc('revisi_ke')->first();

        return $dataHistoryCPM;
    }

    private function getListHistoryCPM($idCPM, $revisiKe=1)
    {
        Log::info('tes');
        try {
            $shouldJoinedData = [];
            $newMapped = [];
            $dataRevisi = DB::table(self::T_CPM_ACTIVITY_LOGS)->where('id_m_cpm', $idCPM)->where('revisi_ke', $revisiKe);
            Log::info($dataRevisi->toRawSql());
            $decodedData = json_decode($dataRevisi->first()->changed_dtl, false);
            foreach ($decodedData->details as $value) {
                $value->objective_id = $value->id_m_obj;
                
                $shouldJoinedData[] = $value->id_m_obj;
            }

            $dtlObj = DB::table(self::T_M_OBJ . ' as mo')
                ->leftJoin(self::T_M_OBJ_CAT . ' as moc', 'moc.id', '=', 'mo.id_obj_category')
                ->select('mo.id as objective_id', 'mo.nama as objective_name', 'moc.nama as category')
                ->whereIn('mo.id', $shouldJoinedData)->get();
                
            foreach ($dtlObj as $value2) {
                $newMapped[$value2->objective_id] = $value2; 
            }

            // dd($newMapped);

            foreach ($decodedData->details as $value3) {
                $value3->objective_name =  $newMapped[$value3->id_m_obj]->objective_name;
                $value3->category =  $newMapped[$value3->id_m_obj]->category;
            }

            return $decodedData->details;
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return [];
        }

        return [];
    }

    private function getRevisiCPM($idCPM)
    {
        $riwayat = [];
        try {
            $dataRevisi = DB::table(self::T_CPM_ACTIVITY_LOGS)->where('id_m_cpm', $idCPM)->select('id', 'revisi_ke');

            $riwayat = $dataRevisi->get()->toArray();
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return null;
        }

        return $riwayat;
    }

}
