<?php

namespace Modules\SmartForm\App\Http\Controllers\DC\BAUnbudget;

use Exception;
use Google\Cloud\Core\Exception\NotFoundException;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

use function PHPUnit\Framework\isEmpty;

class UnbudgetController extends Controller {

    const T_M_COA = 'unbudget_m_coa';
    const T_UNBUDGET_MASTER = 'unbudget_master';
    const T_UNBUDGET_DTL = 'unbudget_master_dtl';
    const T_UNBUDGET_APPROVAL = 'unbudget_approval';
    const SP_UNBUDGET = 'InsertNewBAUnbudget';
    const T_HRD_KARYAWAN = 'HRD.dbo.TKaryawan';
    const T_HRD_DEPT = 'HRD.dbo.tdepartement';
    const bulanMapping = [
        '1' => 'I', '2' => 'II', '3' => 'III', '4' => 'IV',
        '5' => 'V', '6' => 'VI', '7' => 'VII', '8' => 'VIII',
        '9' => 'IX', '10' => 'X', '11' => 'XI', '12' => 'XII'
    ];
    const bulanMappingDesc = [
        '1' => 'Januari', '2' => 'Februari', '3' => 'Maret', '4' => 'April',
        '5' => 'Mei', '6' => 'Juni', '7' => 'Juli', '8' => 'Agustus',
        '9' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
    ];
    
    public function Index(Request $request) {
        return view('SmartForm::DC/unbudget/index');
    }

    public function FormBAUnbudget() {
        return view('SmartForm::DC/unbudget/form');
    }

    public function FormEdit(Request $request) {
        $noDocument = $request->query('no_document');
        $isEditable = true;
        $data = [
            'master' => null,
            'detail' => [],
            'approval' => []
        ];

        if(!$noDocument) abort(404);

        try {
            $sqlSelectUnbudget = DB::table(self::T_UNBUDGET_MASTER . ' as um')
                ->select('um.NoDocument', 'um.strategi', 'um.ekonomi', 'um.finance', 'um.technology',  'um.operation', 
                'um.tempat', 'um.KodeST', 'um.KodeDP', 'um.Tanggal', 'um.created_by as NIK', 'tk.Nama', 'um.id', 'um.status')
                ->leftJoin(self::T_HRD_KARYAWAN . ' as tk', 'um.created_by', '=', 'tk.NIK')
                ->where('NoDocument', $noDocument)
                ->first();
            if(!$sqlSelectUnbudget) throw new NotFoundResourceException('No Document tidak valid');

            $sqlDetailUnbudget = DB::table(self::T_UNBUDGET_DTL)
                ->select('id', 'KodeMaterial', 'NamaMaterial', 'Code_COA', 'COA', 'QTY', 'HargaSatuan', 'keterangan',
                DB::raw('(HargaSatuan * QTY) as total'))
                ->where('master_id', $sqlSelectUnbudget->id)
                ->where('is_deleted', 0)
                ->get();

            $sqlUnbudgetApproval = DB::table(self::T_UNBUDGET_APPROVAL . ' as up')
                ->select('up.NIK', 'tk.Nama', 'up.status', 'up.urutan', 'up.role', 'up.id')
                ->leftJoin(self::T_HRD_KARYAWAN . ' as tk', 'up.NIK', '=', 'tk.NIK')
                ->where('master_id', $sqlSelectUnbudget->id)
                ->whereNot('status', -2)
                ->orderBy('up.urutan')->get();
            
            $data['master'] = $sqlSelectUnbudget;
            $data['detail'] = $sqlDetailUnbudget;
            $data['approval'] = $sqlUnbudgetApproval;  
            $data['noDocument'] = $noDocument;
            $isEdit = $sqlUnbudgetApproval->whereIn('status', [-1, 1]);
            $isEditable = count($isEdit) > 0 ? false : true;
        } catch (NotFoundResourceException $notFound) {
            Log::error($notFound);

            abort(404);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());

            abort(500);
        }

        return view('SmartForm::DC/unbudget/form-edit', ['data' => $data, 'isEditable' => $isEditable]);
    }

    public function FormEditSubmit(Request $request) {
        $isSuccess = false;
        $msg = "";
        $errMsg = [];
        $nik_session = $request->session()->get('user_id');
        $KodeDP_session = $request->session()->get('kode_department');
        $KodeST_session = $request->session()->get('kode_site');
        $createdAt = now();
        $noDocument = $request->input('noDocument');
        $dataMaster = $request->input('master');
        $dataDetail = $request->input('detail');
        $dataApproval = $request->input('approval');

        try {
            DB::beginTransaction();
            Log::debug(count($dataMaster));
            $idMaster = DB::table(self::T_UNBUDGET_MASTER)->where('NoDocument', $noDocument)->first();

            if(!$idMaster) {

            } else {
                if(count($dataMaster) > 0) {
                    // $affectedMaster = DB::table(self::T_UNBUDGET_MASTER)->where('NoDocument', $noDocument)
                    //     ->update($dataMaster);
                    // Log::debug('Affected Master : ' . $affectedMaster);
                }
    
                if(isset($dataDetail['insert'])) {
                    if(count($dataDetail['insert']) > 0) {
                        foreach ($dataDetail['insert'] as $nilaiDetail) {
                            // DB::table(self::T_UNBUDGET_DTL)->insert([
                            //     'master_id' => $idMaster->id,
                            //     'KodeMaterial' => $nilaiDetail['kode_material'],
                            //     'NamaMaterial' => $nilaiDetail['nama_material'],
                            //     'Code_COA' => $nilaiDetail['kode_coa'],
                            //     'COA' => $nilaiDetail['nama_coa'],
                            //     'QTY' => $nilaiDetail['qty'],
                            //     'HargaSatuan' => $nilaiDetail['harga_satuan'],
                            //     'keterangan' => $nilaiDetail['keterangan']
                            // ]);
                        }
                    }
                }

                if(isset($dataDetail['update'])) {
                    if(count($dataDetail['update']) > 0) {
                        foreach ($dataDetail['update'] as $nilaiDetail) {
                            // DB::table(self::T_UNBUDGET_DTL)->where('id', $nilaiDetail)->update([
                            //     'is_deleted' => 1
                            // ]);
                        }
                    }
                }

                // if(isset($dataApproval)) {
                    if(count($dataApproval) > 0) {
                        foreach ($dataApproval as $valueApproval) {
                            if(isset($valueApproval['nik']) && isset($valueApproval['approvalOrder']) && isset($valueApproval['role'])) {
                                $valueApproval['created_at'] = $createdAt;
                                $valueApproval['master_id'] = $idMaster->id;
                                $insertApproval = DB::table(self::T_UNBUDGET_APPROVAL)
                                    ->insert([
                                        'master_id' => $idMaster->id,
                                        'NIK' => $valueApproval['nik'],
                                        'urutan' => $valueApproval['approvalOrder'],
                                        'role' => $valueApproval['role'],
                                        'created_at' => $createdAt,
                                        'replacing' => $valueApproval['replacing']
                                    ]);

                                if(isset($valueApproval['replacing'])) {
                                    $affectedApproval = DB::table(self::T_UNBUDGET_APPROVAL)
                                        ->where('id', $valueApproval['replacing'])
                                        ->update([
                                            'updated_at' => $createdAt,
                                            'status' => -2
                                        ]);
                                }
                            }
                        }
                        
                    }
                // }
            }
            
            
            
            // dd($dataMaster);

            DB::commit();
        } catch (Exception $ex) {
            DB::rollBack();
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
        }

        return response()->json([
            'isSuccess' => $isSuccess,
            'message' => $msg,
            'errorMessage' => $errMsg,
        ]);
    }

    public function SubmitBA(Request $request) {
        $isSuccess = false;
        $msg = "";
        $errMsg = [];
        $nik_session = $request->session()->get('user_id');
        $KodeDP_session = $request->session()->get('kode_department');
        $KodeST_session = $request->session()->get('kode_site');
        $createdAt = now();

        try {
            $listApproval = $request->input('approval', []);
            // dd($listApproval);
            $approvalCostControl = env('UNBUDGET_COST_CONTROL', '1001114');
            array_push($listApproval, [
                'nik' => env('UNBUDGET_COST_CONTROL', '1001114'),
                'approvalOrder' => 2,
                'role' => 'Sect. Head Cost Control'
            ]);

            $listApproval = collect($listApproval)->sortBy('approvalOrder');

            // dd($listApproval);
            // return;
            DB::beginTransaction();
            // dd();
            $dataMasterForm = [
                'strategi' => $request->input('strategi'),
                'ekonomi' => $request->input('ekonomi'),
                'finance' => $request->input('finance'),
                'technology' => $request->input('technology'),
                'operation' => $request->input('operation'),
                'tempat' => $request->input('tempat'),
                'KodeST' => $KodeST_session,
                'KodeDP' => $KodeDP_session,
                'tanggal' => $request->input('tanggal'),
                'status' => 0,
                'created_at' => $createdAt,
                'created_by' => $nik_session,
            ];
            $bulan = self::bulanMapping[Carbon::parse($request->input('tanggal'))->month];
            $tahun = Carbon::parse($request->input('tanggal'))->year;

            $dataDetailForm = [];

            // $sqlInsertUnbudget = DB::table(self::T_UNBUDGET_MASTER)->insertGetId($dataMasterForm);
            // $result = DB::select('EXEC '. self::SP_UNBUDGET .' ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?',  [$dataMasterForm['KodeST'],  $dataMasterForm['KodeDP'], $dataMasterForm['tanggal'], $dataMasterForm['strategi'], $dataMasterForm['ekonomi'], $dataMasterForm['finance'], $dataMasterForm['technology'], $dataMasterForm['operation'], $dataMasterForm['tempat'], $dataMasterForm['created_by'], $dataMasterForm['created_at'],  $bulan,  $tahun]);
            // $result = DB::select('EXEC '. self::SP_UNBUDGET .' '. $dataMasterForm['KodeST'] .', '. $dataMasterForm['KodeDP'] .', '. $dataMasterForm['tanggal'] .', '. $dataMasterForm['strategi'] .', '. $dataMasterForm['ekonomi'] .', '. $dataMasterForm['finance'] .', '. $dataMasterForm['technology'] .', '. $dataMasterForm['operation'] .', ' .$dataMasterForm['tempat']. ', '. $dataMasterForm['created_by'] .', '. $dataMasterForm['created_at'] .', '. $bulan .', '. $tahun);
            $result = DB::select('EXEC '. self::SP_UNBUDGET .' :KodeST, :KodeDP, :Tanggal, :s, :e, :f, :t, :o, :tempat, :created_by, :created_at, :bulan, :tahun', [
                'KodeST' => $dataMasterForm['KodeST'],
                'KodeDP' => $dataMasterForm['KodeDP'],
                'Tanggal' => $dataMasterForm['tanggal'],
                's' => $dataMasterForm['strategi'],
                'e' => $dataMasterForm['ekonomi'],
                'f' => $dataMasterForm['finance'],
                't' => $dataMasterForm['technology'],
                'o' => $dataMasterForm['operation'],
                'tempat' => $dataMasterForm['tempat'],
                'created_by' => $dataMasterForm['created_by'],
                'created_at' => $dataMasterForm['created_at'],
                'bulan' => $bulan,
                'tahun' => $tahun
            ]);

            // dd($result);

            if($result[0]->status != 0) new Exception('Error exec SP : ' . $result[0]->msg); 
            if(empty($result)) new Exception('Error exec SP : empty result');

            foreach($request->input('listMaterial') as $listDetail) {
                DB::table(self::T_UNBUDGET_DTL)->insert([
                    'master_id' => $result[0]->id_master,
                    'KodeMaterial' => $listDetail['kode_material'],
                    'NamaMaterial' => $listDetail['nama_material'],
                    'Code_COA' => $listDetail['kode_coa'],
                    'COA' => $listDetail['nama_coa'],
                    'QTY' => $listDetail['qty'],
                    'HargaSatuan' => $listDetail['harga_satuan'],
                    'keterangan' => $listDetail['keterangan']
                ]);

                // $dataDetailForm[] = [
                //     'master_id' => $result->id_master,
                //     'KodeMaterial' => $listDetail['kode_material'],
                //     'NamaMaterial' => $listDetail['nama_material'],
                //     'Code_COA' => $listDetail['kode_coa'],
                //     'COA' => $listDetail['nama_coa'],
                //     'QTY' => $listDetail['qty'],
                //     'HargaSatuan' => $listDetail['harga_satuan'],
                //     'keterangan' => $listDetail['keterangan']
                // ];
            }

            foreach($listApproval as $approvalUnbudget) {
                DB::table(self::T_UNBUDGET_APPROVAL)->insert([
                    'NIK' => $approvalUnbudget['nik'],
                    'master_id' => $result[0]->id_master,
                    'status' => 0,
                    'urutan' => $approvalUnbudget['approvalOrder'],
                    'role' => $approvalUnbudget['role']
                ]);
            }

            $msg = 'Berhasil submit form ' . $result[0]->NoDocument;
            $isSuccess = true;
            // dd(['master' => $dataMasterForm, 'detail' => $dataDetailForm]);
            DB::commit();
        } catch (Exception $ex) {
            DB::rollBack();
            $errID = Str::uuid();
            $msg = "Terjadi kesalahan, trace ID " . $errID;

            Log::error('Error ID'. $errID .' : ' . $ex->getMessage());
            Log::error($ex->getTraceAsString());
        }

        return response()->json([
            'isSuccess' => $isSuccess,
            'message' => $msg,
            'errorMessage' => $errMsg,
        ]);
    }

    public function FormInfo(Request $request) {
        $noDocument = $request->query('no_document');
        if(!$noDocument) return abort(404);
        // '0: not yet, 1: approved, -1: rejected, -2: replaced'
        $APPROVAL_STATUS_MAPPING = [
            '0' => 'Not Yet',
            '1' => 'Approved',
            '-1' => 'Rejected',
            '-2' => 'Replaced'
        ];

        $data = [
            'master' => null,
            'detail' => [],
            'approval' => [],
            'current_approval' => ['id' => 0, 'NIK' => 0]
        ];

        try {
            $sqlSelectUnbudget = DB::table(self::T_UNBUDGET_MASTER . ' as um')
                ->select('um.NoDocument', 'um.strategi', 'um.ekonomi', 'um.finance', 'um.technology',  'um.operation', 
                'um.tempat', 'um.KodeST', 'um.KodeDP', 'um.Tanggal', 'um.created_by as NIK', 'tk.Nama', 'um.id', 'um.status')
                ->leftJoin(self::T_HRD_KARYAWAN . ' as tk', 'um.created_by', '=', 'tk.NIK')
                ->where('NoDocument', $noDocument)
                ->first();
            // dd(!$sqlSelectUnbudget);
            if(!$sqlSelectUnbudget) {
                throw new NotFoundException("No Document " . $noDocument . " tidak ditemukan");
            }

            $sqlSelectUnbudget->tanggal_format = $this->formatTanggal($sqlSelectUnbudget->Tanggal);

            $sqlDetailUnbudget = DB::table(self::T_UNBUDGET_DTL)
                ->select('KodeMaterial', 'NamaMaterial', 'Code_COA', 'COA', 'QTY', 'HargaSatuan', 'keterangan',
                DB::raw('(HargaSatuan * QTY) as total'))
                ->where('master_id', $sqlSelectUnbudget->id)
                ->get();

            $sqlUnbudgetApproval = DB::table(self::T_UNBUDGET_APPROVAL . ' as up')
                ->select('up.NIK', 'tk.Nama', 'up.status', 'up.urutan', 'up.role', 'up.id')
                ->leftJoin(self::T_HRD_KARYAWAN . ' as tk', 'up.NIK', '=', 'tk.NIK')
                ->where('master_id', $sqlSelectUnbudget->id)
                ->whereNot('up.status', -2)
                ->orderBy('up.urutan')->get();
            foreach ($sqlUnbudgetApproval as $value) {
                $value->status_nama = $APPROVAL_STATUS_MAPPING[$value->status];
            }
            
            $currentApproval = $sqlUnbudgetApproval->where('status', 0)->first();
            if($currentApproval) $data['current_approval'] = ['id' => $currentApproval->id, 'NIK' => $currentApproval->NIK];
            
            $data['master'] = $sqlSelectUnbudget;
            $data['detail'] = $sqlDetailUnbudget;
            $data['approval'] = $sqlUnbudgetApproval;

        } catch (NotFoundException $exNotFOund) {
            Log::error($exNotFOund->getMessage());
            Log::error($exNotFOund->getTraceAsString());

            return abort(404, $exNotFOund->getMessage());
        } 
        catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());

            return abort(500);
        }

        return view('SmartForm::DC/unbudget/form-info', ['data' => $data]);
    }

    public function FormApproval(Request $request) {
        $isSuccess = false;
        $msg = '';
        $errMsg = [];
        $nik_session = $request->session()->get('user_id');
        $validator = Validator::make(
            $request->all(), 
            [
                'NoDocument' => ['required'], 
                'approvalValue' => ['required']
            ],
            [
                'NoDocument.required' => 'NoDocument tidak valid',
                'approvalValue.required' => 'approvalValue tidak valid'
            ]
        );
        $errorList = $validator->errors()->all();
        $updatedAt = now();

        if(count($errorList) > 0) {
            $msg = "Error mandatory field";
            $errMsg = $errorList;

        } else {
            $noDocument = $request->input('NoDocument');
            $approvalValue = $request->input('approvalValue');

            try {
                DB::beginTransaction();
                $sqlUnbudget = DB::table(self::T_UNBUDGET_MASTER)->select('status', 'id', 'NoDocument')->first();
                
                if(!$sqlUnbudget) {
                    $msg = "Invalid Request!";
                } else {
                    $currentApproval = DB::table(self::T_UNBUDGET_MASTER . ' as um')
                        ->select('um.id', 'um.NoDocument', 'ua.status', 'ua.NIK', 'ua.role', 'ua.replacing', 'ua.urutan', 'ua.id as approval_id')
                        ->leftJoin(self::T_UNBUDGET_APPROVAL . ' as ua', 'um.id', '=', 'ua.master_id')
                        ->where('um.NoDocument', $noDocument)
                        ->where('ua.status', 0)
                        ->whereNot('ua.status', -2)
                        ->orderBy('ua.urutan')
                        ->first();
                    
                    // Log::info($currentApproval->toRawSql());

                    if(!$currentApproval) {
                        $msg = "Invalid Request!";
                    } else {
                        if($currentApproval->NIK != $nik_session) {
                            $msg = "Unauthorized Request!";
                        }
                        else {
                            // dd($currentApproval);
                            DB::table(self::T_UNBUDGET_APPROVAL)->where('id', $currentApproval->approval_id)->update([
                                'updated_at' => $updatedAt,
                                'status' => $approvalValue
                            ]);

                            if($approvalValue == -1) {
                                DB::table(self::T_UNBUDGET_MASTER)->where('id', $currentApproval->id)->update([
                                    'updated_at' => $updatedAt,
                                    'updated_by' => $nik_session,
                                    'status' => '-1'
                                ]);
                            }

                            $msg = 'Berhasil update!';
                            $isSuccess = true;
                        }
                    }

                }

                DB::commit();
            } catch (Exception $ex) {
                DB::rollBack();

                Log::error($ex->getMessage());
                Log::error($ex->getTraceAsString());
            }
        }

        return response()->json([
            'isSuccess' => $isSuccess,
            'message' => $msg,
            'errorMessage' => $errMsg,
        ]);
    }

    public function FormList(Request $request) {
        $isSuccess = false;
        $message = '';
        $errorMessage = [];
        $data = [
            'total' => 0,
            'totalNotFiltered' => 0,
            'rows' => []
        ];

        $sort = $request->query('sort', 'id'); // Default sort by id
        $order = $request->query('order', 'asc'); // Default order is ascending
        $offset = $request->query('offset', 0); // Default offset
        $limit = $request->query('limit', 10); 

        try {
            $sqlMaster = DB::table(self::T_UNBUDGET_MASTER . ' as um')
                ->select('um.id', 'um.NoDocument', 'um.tanggal', 'um.created_by as NIK', 'um.KodeDP', 'tk.Nama', 'td.Nama as department', 'um.status')
                ->leftJoin(self::T_HRD_KARYAWAN . ' as tk', 'um.created_by', '=', 'tk.NIK')
                ->leftJoin(self::T_HRD_DEPT . ' as td', 'um.KodeDP', '=', 'td.KodeDP');

            Log::info('SQL : '. $sqlMaster->toRawSql());
            
            $jml = $sqlMaster->count();
            if($limit == null || $limit == 'null' || $limit == '') {
                $sqlMaster->skip($offset);
            } else {
                $sqlMaster->skip($offset)->limit($limit);
            }

            $masterData = $sqlMaster->get();

            $data = [
                'total' => $jml,
                'totalNotFiltered' => $jml,
                'rows' => $masterData
            ];
            $message = "Ok";
            $isSuccess = true;
        } catch (Exception $ex) {
            $errID = Str::uuid();
            $message = 'Terjadi kesalahan! Error ID : ' . $errID;

            Log::error('Error '. $errID. ' : ' . $ex->getMessage());
            Log::error($ex->getTraceAsString());
        }

        return response()->json([
            'isSuccess' => $isSuccess,
            'message' => $message,
            'errorMessage' => $errorMessage,
            'data' => $data
        ]);
    }

    public function Dashboard(Request $request) {
        // select um.KodeDP, SUM(umd.HargaSatuan * umd.QTY) as TotalHarga
        //     from unbudget_master as um
        //     right join unbudget_master_dtl as umd on umd.master_id=um.id
        //     group by KodeDP

        // select KodeDP, count(KodeDP) as Jumlah from unbudget_master
        //     group by KodeDP
        $dataNominalBySite = DB::table(self::T_UNBUDGET_MASTER . ' as um')->select('um.KodeST', DB::raw('SUM(umd.HargaSatuan * umd.QTY) as Total'))
            ->rightJoin(self::T_UNBUDGET_DTL . ' as umd', 'umd.master_id', '=', 'um.id')
            ->groupBy('um.KodeST')->get();
        $dataJumlahBySite = DB::table(self::T_UNBUDGET_MASTER)->select('KodeST', DB::raw('count(KodeST) as Jumlah'))->groupBy('KodeST')->get();
        $result = $dataNominalBySite->map(function ($item) use ($dataJumlahBySite) {
            $jumlah = $dataJumlahBySite->firstWhere('KodeST', $item->KodeST);
            return [
                "KodeST" => $item->KodeST,
                "Total" => $item->Total,
                "Jumlah" => $jumlah->Jumlah ?? null, // Gunakan null jika tidak ditemukan
            ];
        })->values()->toArray();

        $dataNominalByDept = DB::table(self::T_UNBUDGET_MASTER . ' as um')->select('um.KodeDP', DB::raw('SUM(umd.HargaSatuan * umd.QTY) as Total'))
            ->rightJoin(self::T_UNBUDGET_DTL . ' as umd', 'umd.master_id', '=', 'um.id')
            ->groupBy('um.KodeDP')->get();
        $dataJumlahByDept = DB::table(self::T_UNBUDGET_MASTER)->select('KodeDP', DB::raw('count(KodeDP) as Jumlah'))->groupBy('KodeDP')->get();
        $result2 = $dataNominalByDept->map(function ($item) use ($dataJumlahByDept) {
            $jumlah = $dataJumlahByDept->firstWhere('KodeDP', $item->KodeDP);
            return [
                "KodeDP" => $item->KodeDP,
                "Total" => $item->Total,
                "Jumlah" => $jumlah->Jumlah ?? null, // Gunakan null jika tidak ditemukan
            ];
        })->values()->toArray();
        
        // Hasil akhir tanpa redundansi KodeDP
        $finalResult = [
            "bySite" => $result,
            "byDept" => $result2
        ];

        
        // return response()->json($finalResult);
        return view('SmartForm::DC/unbudget/dashboard', ['finalResult' => $finalResult]);
    }

    public function HelperCOA(Request $request) {
        $data = [];
        $query = $request->get("query");

        try {
            $dataSQL = DB::table(self::T_M_COA)->select('Code_COA as id', 'COA as text');

            if($query) $dataSQL->where('COA', 'like', "%$query%")->orWhere('Code_COA', 'like', "%$query%");
            Log::info('SQL : '. $dataSQL->toRawSql());
            $data = $dataSQL->get();

        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
        }

        return response()->json(['data' => $data]);
    }

    public function HelperMP(Request $request) {

        $data = [];
        $query = $request->get("query");

        try {
            Log::info($query . ' - '. trim($query) . ' - ' . strlen(trim($query)));
            if(strlen(trim($query))) {
                $data = DB::connection('sqlsrv2')->table(self::T_HRD_KARYAWAN)->select('NIK as id', 'Nama as text')->where('Aktif', 0);

                if($query) $data->where('NIK', 'like', "%$query%")->orWhere('Nama', 'like', "%$query%");
                Log::info($data->toRawSql());
                $data = $data->get();
            }

        } catch (Exception $ex) {
            $errID = Str::uuid();
            $msg = "Terjadi kesalahan, trace ID " . $errID;

            Log::error('Error ID'. $errID .' : ' . $ex->getMessage());
            Log::error($ex->getTraceAsString());
        }

        return response()->json(['data' => $data]);
    }

    private function formatTanggal($tgl) {
        $splittedTgl = explode('-', $tgl);

        $splittedTgl[1] = self::bulanMappingDesc[(int) $splittedTgl[1]];

        return $splittedTgl[2] . ' ' . $splittedTgl[1] . ' ' . $splittedTgl[0];
    }
}
