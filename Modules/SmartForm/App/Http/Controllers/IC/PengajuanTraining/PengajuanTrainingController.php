<?php

namespace Modules\SmartForm\App\Http\Controllers\IC\PengajuanTraining;

use App\Http\Controllers\Controller;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

use function Laravel\Prompts\error;

class PengajuanTrainingController extends Controller {

    const DB_CONN_NAME = 'sqlsrv_training';
    const T_M_TRAINING = 'm_training';
    const T_PENGAJUAN_TRAINING = 'pengajuan_training';
    const T_PENGAJUAN_TRAINING_DTL = 'pengajuan_training_detail';
    const T_TRAINING_KATEGORI = 'training_kategori';
    const T_STD_JAB = 'std_jab_training';
    const T_TRAINING_SYARAT = 'training_syarat';
    const T_PIVOT_SYARAT_TRAINING = 'syarat_m_training';
    const T_HRD_JABATAN = 'HRD.dbo.tjabatan';
    const T_HRD_KARYAWAN = 'HRD.dbo.tkaryawan';
    const T_HRD_DEPT = 'HRD.dbo.tdepartement';
    const T_OFF_ONLINE = 'm_offline_online';
    const T_MANDATORY = 'mandatory_type';
    const T_TRJ = 'training_rekomendasi_justifikasi';
    const mappingDP = [
        'SM' => 'SM',
        'ATA' => 'FAT',
        'SHE' => 'SHE',
        'ORGANIZATION DEVELOPMENT' => 'OD',
        'PRODUKSI' => 'PRD',
        'PLANT' => 'RM',
        'LOGISTIK' => 'MM',
        'LEGAL' => 'LEG',
        'IT' => 'IT',
        'ICGS' => 'HRD',
        'FINANCE' => 'FAT',
        'ENGINEERING' => 'ENG',
        'DATA CENTER' => 'DTC',
        'BUSDEV' => 'BDV',
        'INTERNAL AUDIT' => 'OD',
    ];

    public function index() {
        // $data = DB::connection("sqlsrv_training")->table('m_training')->get();
        
        return view('smartform::ic/pengajuan-training/index');
    }

    public function AddPengajuan(Request $request) {
        return view('smartform::ic/pengajuan-training/add-pengajuan');
    }

    public function SubmitPengajuan(Request $request) {
        $isSuccess = false;
        $message = '';
        $errMsg = '';
        $data = null;
        $tgl = now();
        $nik_session = $request->session()->get('user_id', '');
        
        $validator = Validator::make($request->all(), [
            'pelatihanID' => ['required'], 
            'bulan' => ['required'], 
            'tahun' => ['required'], 
            'detail' => ['required'], 
        ],[
            'pelatihanID.required' => 'Pelatihan tidak valid',
            'bulan.required' => 'Bulan tidak valid',
            'tahun.required' => 'Tahun tidak valid',
            'detail.required' => 'Detail tidak valid'
        ]);

        $validation_errors = $validator->errors();
        if(count($validation_errors) > 0) {
            $errMsg = "Error validasi request";
        } else {
            $trainingID = $request->input('pelatihanID');
            $bulan = $request->input('bulan');
            $tahun = $request->input('tahun');
            $dataPengajuanDtl = $request->input('detail', []);
            try {
                // Log::debug($dataPengajuanDtl);
                // TODO : check jika pelatihan dengan ID, bulan & tahun sudah ada
                $dataPengajuan = [
                    'm_training_id' => $trainingID,
                    'bulan' => $bulan,
                    'tahun' => $tahun,
                    'jml_orang_plan' => count($dataPengajuanDtl),
                    'jml_orang_act' => 0,
                    'biaya_plan' => 0,
                    'biaya_act' => 0,
                    'biaya_act' => 0,
                    'created_at' => $tgl,
                    'created_by' => $nik_session
                ];
                // /**
                DB::connection(self::DB_CONN_NAME)->beginTransaction();
                // TODO : insert ke pengajuan
                $sqlInsertPengajuan = DB::connection(self::DB_CONN_NAME)->table(self::T_PENGAJUAN_TRAINING)
                    ->insertGetId($dataPengajuan);
                // TODO : insert ke pengajuan detail
                foreach ($dataPengajuanDtl as $value) {
                    Log::debug($value);
                    DB::connection(self::DB_CONN_NAME)->table(self::T_PENGAJUAN_TRAINING_DTL)
                        ->insert([
                            'pengajuan_training_id' => $sqlInsertPengajuan,
                            'KodeDP' => $value['KodeDP'],
                            'KodeST' => $value['site'],
                            'NIK' => $value['NIK'],
                            'status_id' => 0,
                            'matrix' => $value['kalibrasi_matrix'],
                            'created_at' => $tgl,
                            'created_by' => $nik_session
                        ]);
                }

                DB::connection(self::DB_CONN_NAME)->commit();
                // */
                $groupBySiteAndDeptResult = [];
                foreach ($dataPengajuanDtl as $item) {
                    $site = $item['site'];
                    $KodeDP = $item['KodeDP'];
                
                    // Jika site belum ada di hasil, tambahkan
                    if (!isset($groupBySiteAndDeptResult[$site])) {
                        $groupBySiteAndDeptResult[$site] = [];
                    }
                
                    // Jika KodeDP belum ada di dalam site, tambahkan
                    if (!isset($groupBySiteAndDeptResult[$site][$KodeDP])) {
                        $groupBySiteAndDeptResult[$site][$KodeDP] = [
                            'KodeDP' => $item['KodeDP'],
                            'KodeST' => $item['site'],
                            'data' => [],
                        ];
                    }
                
                    // Tambahkan data ke dalam grup KodeDP
                    $groupBySiteAndDeptResult[$site][$KodeDP]['data'][] = $item;
                }

                foreach ($groupBySiteAndDeptResult as $KodeST => $value) {
                    foreach ($value as $KodeDP => $value1) {
                        DB::connection(self::DB_CONN_NAME)->table(self::T_TRJ)
                            ->insert([
                                'pengajuan_training_id' => $sqlInsertPengajuan,
                                'KodeST' => $KodeST,
                                'KodeDP' => $KodeDP
                            ]);
                        // foreach($value1['data'] as $dataPerDeptAndSite) {
                        //     //Log::debug($dataPerDeptAndSite);
                        //     DB::connection(self::DB_CONN_NAME)->table(self::T_TRJ)
                        //         ->insert([
                        //             'pengajuan_training_id' => $sqlInsertPengajuan,
                        //             'KodeST' => $KodeST,
                        //             'KodeDP' => $KodeDP
                        //         ]);
                        //     // Log::debug([
                        //     //     'pengajuan_training_id' => $sqlInsertPengajuan,
                        //     //     'tahun' => $tahun,
                        //     //     'bulan' => $bulan,
                        //     //     'KodeST' => $KodeST,
                        //     //     'KodeDP' => $KodeDP,
                        //     //     'NIK' => $dataPerDeptAndSite['NIK']
                        //     // ]);
                        // }
                    }
                }

                // Log::debug("hasil grouping : " . json_encode($groupBySiteAndDeptResult, JSON_PRETTY_PRINT));
                $isSuccess = true;
                $message = "Berhasil";
            
            } catch (Exception $ex) {
                DB::connection(self::DB_CONN_NAME)->rollBack();
                Log::error('Error submit pengajuan : ' . $ex->getMessage());
                Log::error($ex->getTraceAsString());
            }
        }

        return response()->json([
            'isSuccess' => $isSuccess,
            'message' => $message,
            'errorMessage' => $errMsg,
            'data' => $data
        ]);
    }

    public function CrossCheck() {
        return view('smartform::ic/pengajuan-training/cross-check');
    }

    public function CrossCheckDtl($id, Request $request) {
        // select trj.id, trj.KodeDP, trj.KodeST, ptd.NIK
        //     from training_rekomendasi_justifikasi as trj
        //     left join pengajuan_training as pt on trj.pengajuan_training_id=pt.id
        //     right join pengajuan_training_detail as ptd on pt.id=ptd.pengajuan_training_id
        //     where trj.id=1 and ptd.KodeDP=trj.KodeDP and ptd.KodeST=trj.KodeST
        

        // dd($dataSql->get());
        return view('smartform::ic/pengajuan-training/cross-check-dtl', ['trjID' => $id]);
    }

    public function DataCrossCheckDtl(Request $request) {
        $idTRJ = $request->query('trj_id');
        $data = [
            'total' => 0,
            'totalNotFiltered' => 0,
            'rows' => []
        ];
        try {
            $dataSql = DB::connection(self::DB_CONN_NAME)->table(self::T_TRJ . ' as trj')
                ->select('trj.id', 'trj.KodeDP', 'trj.KodeST', 'ptd.NIK', 'tk.nama as NIK_nama', 'ptd.status_id')
                ->leftJoin(self::T_PENGAJUAN_TRAINING . ' as pt','trj.pengajuan_training_id', '=', 'pt.id')   
                ->rightJoin(self::T_PENGAJUAN_TRAINING_DTL .  ' as ptd', 'pt.id', '=', 'ptd.pengajuan_training_id')
                ->leftJoin(self::T_HRD_KARYAWAN . ' as tk', 'ptd.NIK', '=', 'tk.NIK')
                ->where('trj.id', $idTRJ)
                ->where('ptd.KodeDP', DB::raw('trj.KodeDP'))
                ->where('ptd.KodeST', DB::raw('trj.KodeST'))
            ;
            Log::info($dataSql->toRawSql());
            // $data['total'] = $dataSql->count();
            // $data['totalNotFiltered'] = $data['total'];
            $data['rows'] = $dataSql->get();
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
        }

        return response()->json($data);
        
    }

    public function DataCrossCheck(Request $request) {
        $isSuccess = false;
        $msg = '';
        $errMsg = '';
        $data = [];
        // select trj.pengajuan_training_id, mt.nama as nama_pelatihan, mt.id as id_training, trj.KodeDP, trj.KodeST, pj.bulan, pj.tahun
        //     from training_rekomendasi_justifikasi as trj 
        //     left join pengajuan_training as pj on trj.pengajuan_training_id = pj.id
        //     left join m_training as mt on pj.m_training_id=mt.id
        //     where bulan=1
        //     ORDER BY mt.nama 

        $sort = $request->query('sort', 'id'); // Default sort by id
        $order = $request->query('order', 'asc'); // Default order is ascending
        $offset = $request->query('offset', 0); // Default offset
        $limit = $request->query('limit', 10); 

        try {
            $sqlData = DB::connection(self::DB_CONN_NAME)->table(self::T_TRJ . ' as trj')
                ->select('trj.id as trj_id', 'trj.pengajuan_training_id', 'mt.nama as nama_pelatihan', 'mt.id as id_training', 'trj.KodeDP', 'td.Nama as dept', 'trj.KodeST', 'pj.bulan', 'pj.tahun', 'trj.status')
                ->leftJoin(self::T_PENGAJUAN_TRAINING . ' as pj','trj.pengajuan_training_id', '=', 'pj.id')
                ->leftJoin(self::T_M_TRAINING . ' as mt', 'pj.m_training_id', '=', 'mt.id')
                ->leftJoin(self::T_HRD_DEPT . ' as td', 'td.KodeDP', '=', 'trj.KodeDP')
                ->orderBy('mt.nama')
            ;

            $jml = $sqlData->count();
            if($limit == null || $limit == 'null' || $limit == '') {
                $sqlData->skip($offset);
            } else {
                $sqlData->skip($offset)->limit($limit);
            }
            $sqlDataGet = $sqlData->get();

            $data = [
                'total' => $jml,
                'totalNotFiltered' => $jml,
                'rows' => $sqlDataGet
            ];

        } catch (Exception $ex) {
            Log::error($ex->getMessage());
        }

        return response()->json([
            'isSuccess' => $isSuccess,
            'message' => $msg,
            'errorMessage' => $errMsg,
            'data' => $data
        ]);
    }

    private function checkPengajuanTrainingExist($pelatihanID, $tahun, $bulan): bool {
        $isExist = true;

        // select ptd.id, ptd.NIK, ptd.matrix, ptd.pengajuan_training_id, mt.nama as nama_training
        //     from pengajuan_training_detail as ptd
        //     left join pengajuan_training as pt on pt.id = ptd.pengajuan_training_id
        //     left join m_training as mt on pt.m_training_id=mt.id
        //     where ptd.NIK='1020340' and pt.m_training_id=7

        try {
            $isExist = DB::connection(self::DB_CONN_NAME)->table(self::T_PENGAJUAN_TRAINING)
                ->where('m_training_id', $pelatihanID)
                ->where('bulan', $bulan)
                ->where('tahun', $tahun)
                ->exists();
        } catch (Exception $ex) {
            Log::error('Error checkPengajuanTrainingExist : ' . $ex->getMessage());
            Log::error($ex->getTraceAsString());
        }

        return $isExist;
    }

    public function training() {
        return view('smartform::ic/pengajuan-training/import-master-training');
    }

    public function atmp() {
        return view('smartform::ic/pengajuan-training/import-atmp');
    }

    public function ImportMasterTraining(Request $request) {
        DB::connection(self::DB_CONN_NAME)->beginTransaction();
        $training = $request->input('training', []);
        $jabatan = $request->input('jabatan', []);
        $training_kategori = $request->input('training_kategori', []);
        $sudah_training = $request->input('sudah_training', []);
        $std_jab = $request->input('std_jab', []);
        $groupedTraining = [];
        $groupedSudahTraining = [];
        $lowercaseArray = [];
        try {
            // Log::info("training kategori");
            // foreach ($training_kategori as $value) {
            //     Log::info(json_encode($value, JSON_PRETTY_PRINT));
            // }

            // Log::info("training");
            Log::info("training kategori");
            foreach ($training_kategori as $value) {
                // Log::info(json_encode($value, JSON_PRETTY_PRINT));
                DB::connection(self::DB_CONN_NAME)->table(self::T_TRAINING_KATEGORI)->insert([
                    'code' => $value,
                    'nama' => $value
                ]);
            }
            
            Log::info("training");
            foreach ($training as $value) {
                if(isset($value['nama'])) {
                    unset($value['no']);
                    Log::info(json_encode($value, JSON_PRETTY_PRINT));
                    $id = DB::connection(self::DB_CONN_NAME)->table(self::T_M_TRAINING)->insertGetId($value);
                    if (!isset($groupedTraining[$value['nama']])) {
                        $groupedTraining[$value['nama']] = [];
                        $lowercaseArray[strtolower($value['nama'])] = [];
                    }
                    $groupedTraining[$value['nama']]['id'] = $id;
                    $groupedTraining[$value['nama']]['data'][] = $value;
                    $lowercaseArray[strtolower($value['nama'])]['id'] = $id;
                    $lowercaseArray[strtolower($value['nama'])]['data'][] = $value;
                }

            }
            // Log::info('grouped training : '. json_encode($groupedTraining, JSON_PRETTY_PRINT));
            Log::info('jabatan');
            foreach ($jabatan as $value) {
                // Log::info(json_encode($value, JSON_PRETTY_PRINT));
                DB::connection(self::DB_CONN_NAME)->table('tjabatan')->insert([
                    'Nama' => $value['jabatan'],
                    'KodeJB' => $value['KodeJB']
                ]);
            }
            Log::info('sudah training');
            // $lowercaseArray = array_change_key_case($groupedSudahTraining, CASE_LOWER);
            Log::info('grouped training : '. json_encode($lowercaseArray, JSON_PRETTY_PRINT));

            foreach ($sudah_training as $value) {
                // Log::info($value);
                if(isset($value['NIK']) && isset($value['PELATIHAN'])) {
                    $namaPelatihan = strtolower($value['PELATIHAN']);
                    if (!isset($groupedSudahTraining[$namaPelatihan])) {
                        $groupedSudahTraining[$namaPelatihan] = [];

                        if(isset($lowercaseArray[$namaPelatihan])) {
                            $groupedSudahTraining[$namaPelatihan]['pelatihan_id'] = $lowercaseArray[$namaPelatihan]['id'];
                        } else {
                            Log::info($namaPelatihan . ' tidak ada di master training');
                            $groupedSudahTraining[$namaPelatihan]['pelatihan_id'] = 0;
                        }
                    }
                    $groupedSudahTraining[$namaPelatihan]['data'][] = ['nik' => $value['NIK']];
                }
            }
            $tgl = now();

            Log::info('STD jabatan');
            // Log::info($lowercaseArray);
            $std_jab = array_map(function($item) use ($lowercaseArray) {
                if(isset($lowercaseArray[strtolower($item['LIST TRAINING'])])) {
                    // Log::info($lowercaseArray[strtolower($item['LIST TRAINING'])]['id']);
                    // $value['id_training'] = $lowercaseArray[strtolower($value['LIST TRAINING'])]['id'];
                    $item['id_training'] = $lowercaseArray[strtolower($item['LIST TRAINING'])]['id']; // Anda bisa mengganti nilai nama sesuai kebutuhan
                    if($item['KodeJB'] != '-') {
                        Log::info([
                            'm_training_id' => $item['id_training'],
                            'KodeJB' => $item['KodeJB']
                        ]);
                        $sqlStdJab= DB::connection(self::DB_CONN_NAME)->table(self::T_STD_JAB)
                            ->insert([
                                'm_training_id' => $item['id_training'],
                                'KodeJB' => $item['KodeJB']
                            ]);
                    }
                    
                    return $item;
                    
                }
            }, $std_jab);

            // foreach ($std_jab as $value) {
            //     // Log::info($lowercaseArray[strtolower($value['LIST TRAINING'])]['id']);
            //     if(isset($lowercaseArray[strtolower($value['LIST TRAINING'])])) {
            //         // Log::info($lowercaseArray[strtolower($value['LIST TRAINING'])]['id']);
            //         array_push($value, ['id_training' => $lowercaseArray[strtolower($value['LIST TRAINING'])]['id']]);
            //         // $value['id_training'] = $lowercaseArray[strtolower($value['LIST TRAINING'])]['id'];
            //         if($value['KodeJB'] != '-') {
            //             // $sqlStdJab= DB::connection(self::DB_CONN_NAME)->table(self::T_STD_JAB)
            //             //     ->insert([
            //             //         'm_training_id' => $value['id_training'],
            //             //         'KodeJB' => $value['KodeJB']
            //             //     ]);
            //         }
            //     }
            // }
            Log::info($std_jab);

            foreach ($groupedSudahTraining as $key => $value) {
                
                $sqlInsertPengajuan = DB::connection(self::DB_CONN_NAME)->table(self::T_PENGAJUAN_TRAINING)
                    ->insertGetId([
                        'm_training_id' => $value['pelatihan_id'],
                        'jml_orang_plan' => count($value['data']),
                        'jml_orang_act' => count($value['data']),
                        'biaya_plan' => 0,
                        'biaya_act' => 0,
                        'tahun' => 2024,
                        'bulan' => 12,
                        'status' => 1,
                        'created_at' => $tgl,
                        'created_by' => 'system'
                    ]);
                foreach ($value['data'] as $value1) {
                    Log::info($value1);
                    DB::connection(self::DB_CONN_NAME)->table(self::T_PENGAJUAN_TRAINING_DTL)
                        ->insert([
                            'pengajuan_training_id' => $sqlInsertPengajuan,
                            // 'KodeDP' => $value['KodeDP'],
                            // 'KodeST' => $value['site'],
                            'NIK' => $value1['nik'],
                            'status_id' => 1,
                            'matrix' => '',
                            'created_at' => $tgl,
                            'created_by' => 'system'
                        ]);
                }
            }
            Log::info('grouped training : '. json_encode($lowercaseArray, JSON_PRETTY_PRINT));
            Log::info('grouped sudah training : '. json_encode($groupedSudahTraining, JSON_PRETTY_PRINT));

            DB::connection(self::DB_CONN_NAME)->commit();
        } catch (Exception $ex) {
            DB::connection(self::DB_CONN_NAME)->rollBack();
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
        }

        return response()->json([
            'isSuccess' => true
        ]);
    }

    public function ImportATMP(Request $request) {
        $createdAt = now();
        $nik_session = $request->session()->get('user_id', '');
        $atmp = $request->input('atmp', []);
        $groupedTraining = [];
        $typo = [];
        $perBulanperGrup = [];
        $nikERP = [];
        $listNik = [];

        $dbTraining = DB::connection(self::DB_CONN_NAME)->table(self::T_M_TRAINING)->select('id', DB::raw('UPPER(nama) as nama'))->get();
        $dbTrainingKey = [];
        foreach ($dbTraining as $value) {
            $dbTrainingKey[$value->nama]['id'] = $value->id; 
        }
        
        foreach ($atmp as $key => $value) {
            // Log::info($key);
            $jadwal = explode("_", $key);
            if(!isset($perBulanperGrup[$key])) {
                $perBulanperGrup[$key] = [];
                $perBulanperGrup[$key]['bulan'] = (int) $jadwal[0];
                $perBulanperGrup[$key]['tahun'] = (int) $jadwal[1];
            }
            Log::debug("debug");
            foreach ($value as $value1) {
                // Log::info($value1);
                if(isset($value1['DEPARTMENT'])) $value1['DEPARTMENT'] = self::mappingDP[$value1['DEPARTMENT']];
                // if(!isset($nikERP[$value1['NIK']]) ) {
                //     $nikERP[$value1['NIK']] = [
                //         'KodeDp' => '',
                //         'KodeST' => ''
                //     ];
                //     $listNik[] = $value1['NIK'];
                // }

                if(isset($value1['JENIS TRAINING'])) {
                    if(!isset($perBulanperGrup[$key]['data'][$value1['JENIS TRAINING']])) {
                        $perBulanperGrup[$key]['data'][$value1['JENIS TRAINING']] = [];
                        $perBulanperGrup[$key]['data'][$value1['JENIS TRAINING']]['id_training'] = "";
                        $perBulanperGrup[$key]['data'][$value1['JENIS TRAINING']]['data'] = [];
                        // $perBulanperGrup[$key][$value1['JENIS TRAINING']]['bulan'] = $jadwal[0];
                        // $perBulanperGrup[$key][$value1['JENIS TRAINING']]['tahun'] = $jadwal[1];
                        // $perBulanperGrup[$key]['data'][$value1['JENIS TRAINING']]['data'] = [];
                        if(isset($dbTrainingKey[strtoupper($value1['JENIS TRAINING'])])) {
                            $perBulanperGrup[$key]['data'][$value1['JENIS TRAINING']]['id_training'] = $dbTrainingKey[strtoupper($value1['JENIS TRAINING'])]['id'];                            
                        } else {
                            // Log::error("Typo : ". $value1['JENIS TRAINING']);
                            if(!isset($typo[$value1['JENIS TRAINING']])) $typo[$value1['JENIS TRAINING']] = [];
                        }

                    }
                    $perBulanperGrup[$key]['data'][$value1['JENIS TRAINING']]['data'][] = $value1;
                }
            }
            foreach ($value as $value1) {
                $tglSplit = Carbon::parse($value1['TANGGAL PELAKSANAAN'])->month. '_'. Carbon::parse($value1['TANGGAL PELAKSANAAN'])->year;
                if(isset($value1['JENIS TRAINING'])) {
                    if(!isset($groupedTraining[$value1['JENIS TRAINING']])) $groupedTraining[$value1['JENIS TRAINING']] = [];
                    if(!isset($groupedTraining[$value1['JENIS TRAINING']][$tglSplit])) $groupedTraining[$value1['JENIS TRAINING']][$tglSplit] = [];
                    
                    $groupedTraining[$value1['JENIS TRAINING']][$tglSplit]['data'][] = $value1;
                    if(!isset($dbTrainingKey[strtoupper($value1['JENIS TRAINING'])])) {
                        // Log::error("Typo : ". $value1['JENIS TRAINING']);
                        if(!isset($typo[$value1['JENIS TRAINING']])) $typo[$value1['JENIS TRAINING']] = [];
                    }

                    else $groupedTraining[$value1['JENIS TRAINING']][$tglSplit]['id'] = $dbTrainingKey[strtoupper($value1['JENIS TRAINING'])]['id'];
                }
            }
        }

        // Log::info('tidak ada di master training : ' . json_encode($typo, JSON_PRETTY_PRINT));
        Log::info('perBulanPerGroup : '. json_encode($perBulanperGrup, JSON_PRETTY_PRINT));
        $perBulanPerGrup = collect($perBulanperGrup)->sortBy([['tahun', 'asc'], ['bulan', 'asc']]);
        // Log::info("grouped training " . count($groupedTraining). " : " . json_encode($groupedTraining, JSON_PRETTY_PRINT));

        try {
            DB::connection(self::DB_CONN_NAME)->beginTransaction();
            foreach ($perBulanPerGrup as $key => $value) {
                $bulan = $value['bulan'];
                $tahun = $value['tahun'];
                foreach ($value['data'] as $key => $value1) {
                    Log::info(['bulan' => $bulan, 'tahun' => $tahun, 'data' => $value1]);
                    // TODO : insert pengajuan_training
                    $idTraining = $value1['id_training'];
                    $groupPelatihanByDeptAndSite = [];
                    if($idTraining != "") {
                        $idInsertPengajuan = DB::connection(self::DB_CONN_NAME)->table(self::T_PENGAJUAN_TRAINING)
                            ->insertGetId([
                                'm_training_id' => $idTraining,
                                'jml_orang_plan' => count($value1['data']),
                                'jml_orang_act' => 0,
                                'biaya_plan' => 0,
                                'biaya_act' => 0,
                                'bulan' => $bulan,
                                'tahun' => $tahun,
                                'status' => 0,
                                'created_at' => $createdAt,
                                'created_by' => $nik_session
                            ]);

                        foreach ($value1['data'] as $key => $value2) {
                            
                            if(isset($value2['SITE'])) {
                                if(!isset($groupPelatihanByDeptAndSite[$value2['SITE']. '_'. $value2['DEPARTMENT']])) {
                                    $groupPelatihanByDeptAndSite[$value2['SITE']. '_'. $value2['DEPARTMENT']] = [];
                                    $groupPelatihanByDeptAndSite[$value2['SITE']. '_'. $value2['DEPARTMENT']]['pengajuan_training_id'] = $idInsertPengajuan;
                                    $groupPelatihanByDeptAndSite[$value2['SITE']. '_'. $value2['DEPARTMENT']]['jenis'] = 0;
                                    $groupPelatihanByDeptAndSite[$value2['SITE']. '_'. $value2['DEPARTMENT']]['status'] = 0;
                                    $groupPelatihanByDeptAndSite[$value2['SITE']. '_'. $value2['DEPARTMENT']]['KodeST'] = $value2['SITE'];
                                    $groupPelatihanByDeptAndSite[$value2['SITE']. '_'. $value2['DEPARTMENT']]['KodeDP'] = $value2['DEPARTMENT'];
                                }
                            }
                            // TODO : insert pengajuan_training_detail
                            Log::info([
                                'pengajuan_training_id' => $idInsertPengajuan,
                                'NIK' => $value2['NIK'],
                                'KodeST' => isset($value2['SITE']) ? $value2['SITE'] : '',
                                'KodeDP' => isset($value2['DEPARTMENT']) ? $value2['DEPARTMENT'] : '',
                                'status_id' => 0,
                                'matrix' => isset($value2['ALARM BY MATRIX KOMPETENSI']) ? $value2['ALARM BY MATRIX KOMPETENSI'] : '',
                                'created_at' => $createdAt,
                                'created_by' => $nik_session
                            ]);
                            DB::connection(self::DB_CONN_NAME)->table(self::T_PENGAJUAN_TRAINING_DTL)
                                ->insert([
                                    'pengajuan_training_id' => $idInsertPengajuan,
                                    'NIK' => $value2['NIK'],
                                    'KodeST' => isset($value2['SITE']) ? $value2['SITE'] : '',
                                    'KodeDP' => isset($value2['DEPARTMENT']) ? $value2['DEPARTMENT'] : '',
                                    'status_id' => 0,
                                    'matrix' => isset($value2['ALARM BY MATRIX KOMPETENSI']) ? $value2['ALARM BY MATRIX KOMPETENSI'] : '',
                                    'created_at' => $createdAt,
                                    'created_by' => $nik_session
                                ]);
                        }
                        Log::debug('groupPelatihanByDeptAndSite : '. json_encode($groupPelatihanByDeptAndSite, JSON_PRETTY_PRINT));
                        foreach ($groupPelatihanByDeptAndSite as $key => $value) {   
                            DB::connection(self::DB_CONN_NAME)->table(self::T_TRJ)->insert($value);
                        }
                    }
                }
            }
            DB::connection(self::DB_CONN_NAME)->commit();
        } catch (Exception $ex) {
            DB::connection(self::DB_CONN_NAME)->rollBack();
            Log::error('error insert pengajuan detail ' . $ex->getMessage(). ' : '. $ex->getTraceAsString());
        }

        return response()->json(['isSuccess' => 'Ok']);
    }
    
    
}
