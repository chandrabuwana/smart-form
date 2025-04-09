<?php

namespace Modules\SmartForm\App\Http\Controllers\IC\PengajuanTraining;

use App\Helper;
use App\Http\Controllers\Controller;
use Carbon\Exceptions\InvalidFormatException;
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
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

use function Laravel\Prompts\error;
use function Laravel\Prompts\select;

class PengajuanTrainingController extends Controller {

    const DB_CONN_NAME = 'sqlsrv_training';
    const T_M_TRAINING = 'm_training';
    const T_PENGAJUAN_TRAINING = 'pengajuan_training';
    const T_PENGAJUAN_TRAINING_DTL = 'pengajuan_training_detail';
    const T_TRAINING_KATEGORI = 'training_kategori';
    const T_TRAINING_KOMITMEN = 'training_komitmen';
    const T_STD_JAB = 'std_jab_training';
    const T_TRAINING_SYARAT = 'training_syarat';
    const T_PIVOT_SYARAT_TRAINING = 'syarat_m_training';
    const T_HRD_JABATAN = 'HRD.dbo.tjabatan';
    const T_HRD_KARYAWAN = 'HRD.dbo.tkaryawan';
    const T_HRD_DEPT = 'HRD.dbo.tdepartement';
    const T_OFF_ONLINE = 'm_offline_online';
    const T_MANDATORY = 'mandatory_type';
    const T_TRJ = 'training_rekomendasi_justifikasi';
    const T_TRJ_APPROVAL = 'trj_approval';
    const T_TRJ_URGENSI = 'trj_urgensi';
    const T_TRJ_TUJUAN = 'trj_tujuan';
    const T_TRJ_PENGGANTI = 'trj_pengganti';
    const T_TRJ_DOC = 'trj_document';
    const T_TRAINING_APPROVAL = 'm_training_approval';
    const T_KOMITMEN_APPROVAL = 'training_komitmen_approval';
    const T_JENIS_APPROVAL = 'jenis_approval';
    const T_PICA_KPI = 'SMF_KPI_MASTER';
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
        'FAT' => 'FAT',
        'OPERATION' => 'OPR',
        'SINERGY INSTITUTE' => 'SI'
    ];
    private  $bulanMapping = [
        '1' => 'Janurari',
        '2' => 'Februari',
        '3' => 'Maret', 
        '4' => 'April',
        '5' => 'Mei',
        '6' => 'Juni',
        '7' => 'Juli',
        '8' => 'Agustus',
        '9' => 'September',
        '10' => 'Oktober',
        '11' => 'November',
        '12' => 'Desember'
    ];

    public function index() {
        // $data = DB::connection("sqlsrv_training")->table('m_training')->get();
        
        return view('smartform::ic/pengajuan-training/index');
    }
    
    public function ImportApproval() {
        return view('smartform::ic/pengajuan-training/import-approval');
    }
    public function ImportApprovalSubmit(Request $request) {
        $isSuccess = false;
        $msg = '';
        $errMsg = [];
        $mappingDept = [];
        $listMasterAproval = $request->input('approval', []);

        try {
            DB::connection(self::DB_CONN_NAME)->beginTransaction();

            $dataDept = DB::connection(self::DB_CONN_NAME)->table(self::T_HRD_DEPT)->get();
            Log::info($dataDept);
            foreach ($dataDept as $value) {
                $mappingDept[strtoupper($value->Nama)] = $value->KodeDP;
            }
            $mappingDept['FINANCE'] = 'FAT';
            // dd($mappingDept);
            foreach ($listMasterAproval as $value) {
                // Log::info($value);
                if(isset($value['nik']) && isset($value['nama']) && isset($value['dept']) 
                    && isset($value['levelValidasi']) && isset($value['site'])
                ) {
                    if(isset($mappingDept[strtoupper($value['dept'])])) {
                        $value['KodeDP'] = $mappingDept[strtoupper($value['dept'])];
                        DB::connection(self::DB_CONN_NAME)->table(self::T_TRAINING_APPROVAL)
                            ->insert([
                                'NIK' => $value['nik'], 'nama' => $value['nama'],
                                'approval_role' => $value['levelValidasi'], 'KodeST' => $value['site'],
                                'KodeDP' => $value['KodeDP']
                            ]);
                    } else {
                        Log::error('Dept ' . $value['dept'] . ' tidak ada di maapping');
                    }

                }
            }
            // dd($listMasterAproval);
            DB::connection(self::DB_CONN_NAME)->commit();
            $isSuccess = true;
            $msg = 'Berhasil import master approval!';
        } catch (Exception $ex) {
            $errID = Str::uuid();
            $errMsg[] = 'Error ' . $errID;
            $msg = 'Terjadi kesalahaan, coba beberapa saat lagi';
            DB::connection(self::DB_CONN_NAME)->rollBack();
            Log::error('Error ' . $errID . ' : ' . $ex->getMessage());
            Log::error($ex->getTraceAsString());
        }

        return response()->json([
            'isSuccess' => $isSuccess,
            'message' => $msg,
            'errorMessage' => $errMsg
        ]);
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

    public function validasiMatrix($dataDetail): int {
        $isValid = 1;
        $toColl = collect($dataDetail);

        try {
            foreach ($dataDetail as $item) {
                if ($item['matrix_mk'] < 1) {
                    return 1;
                }
            }
            
        } catch (Exception $ex) {
            //throw $th;
        }

        return 0;
    }

    public function CrossCheckApprove(Request $request) {
        $trjId = $request->input('trjId', '');
        $pengajuanId = $request->input('pengajuanId', '');
        $detail = $request->input('detail', '');
        $approval = $request->input('approval', []);
        $tanggal = $request->input('tanggal');
        $tempat = $request->input('tempat');
        $listPengganti = $request->input('pengganti', []);
        $listTujuan = $request->input('tujuan', []);
        $listUrgensi = $request->input('urgensi', []);
        $isSuccess = false;
        $msg = '';
        $errMsg = '';
        $tgl = now();
        $nik_session = $request->session()->get('user_id', '');
        // return response()->json(['isSuccess' => false, 'message' =>  $approval]);

        try {
            DB::connection(self::DB_CONN_NAME)->beginTransaction();
            // select top 1 pt.id as pengajuan_id, mt.id as training_id, mt.nama as training_nama
            //     from pengajuan_training as pt
            //     left join m_training as mt on pt.m_training_id = mt.id
            //     where pt.id=127
            $dataUpdateTRJ =[
                'status' => 1,
                'jenis' => $this->validasiMatrix($detail),
                'tanggal' => $tanggal,
                'tempat' => $tempat,
                'created_by' => $nik_session,
                'created_at' => $tgl
            ];

             // TODO : insert detail pengganti
             foreach ($listPengganti as $value1) {
                DB::connection(self::DB_CONN_NAME)->table(self::T_TRJ_PENGGANTI)
                ->insert([
                    'trj_id' => $trjId,
                    'keterangan' => $value1,
                    'created_at' => $tgl,
                    'created_by' => $nik_session
                ]);
                // Log::info([
                //     'trj_id' => $trjId,
                //     'keterangan' => $value1,
                //     'created_at' => $tgl,
                //     'created_by' => $nik_session
                // ]);
            }
            // TODO : insert detail tujuan 
            foreach ($listTujuan as $value2) {
                DB::connection(self::DB_CONN_NAME)->table(self::T_TRJ_TUJUAN)
                ->insert([
                    'trj_id' => $trjId,
                    'keterangan' => $value2,
                    'created_at' => $tgl,
                    'created_by' => $nik_session
                ]);
                // Log::info([
                //     'trj_id' => $trjId,
                //     'keterangan' => $value2,
                //     'created_at' => $tgl,
                //     'created_by' => $nik_session
                // ]);
            }
            // TODO : insert detail urgensi 
            foreach ($listUrgensi as $value3) {
                DB::connection(self::DB_CONN_NAME)->table(self::T_TRJ_URGENSI)
                ->insert([
                    'trj_id' => $trjId,
                    'keterangan' => $value3,
                    'created_at' => $tgl,
                    'created_by' => $nik_session
                ]);
                // Log::info([
                //     'trj_id' => $trjId,
                //     'keterangan' => $value3,
                //     'created_at' => $tgl,
                //     'created_by' => $nik_session
                // ]);
            }
            // Log::info($dataUpdateTRJ);

            $namaTraining = DB::connection(self::DB_CONN_NAME)->table(self::T_PENGAJUAN_TRAINING . ' as pt')
                ->select('pt.id as pengajuan_id','mt.id as training_id', 'mt.nama as training_nama')
                ->leftJoin(self::T_M_TRAINING . ' as mt', 'pt.m_training_id', '=', 'mt.id')
                ->where('pt.id', $pengajuanId)->first();

            
            // TODO : update status trj menjadi 1
            DB::connection(self::DB_CONN_NAME)->table(self::T_TRJ)->where('id', $trjId)
                ->update($dataUpdateTRJ);

            // TODO : insert approval ke TRJ
            $_tempAppr = [
                'dibuat' => 1,
                'disetujui' => 1,
                'diketahui' => 1
            ];

            foreach($approval as $key => $value) {
                if($key > 2) {
                    DB::connection(self::DB_CONN_NAME)->table(self::T_TRJ_APPROVAL)->insert([
                    // Log::info([
                        'trj_id' => $trjId,
                        'm_training_approval_id' => $value,
                        'jenis' => 'diketahui',
                        'approval_order' => $_tempAppr['diketahui'],
                        'status' => 0,
                        'created_at' => $tgl,
                        'created_by' => $nik_session
                    ]);
                    $_tempAppr['diketahui']++;
                } else if($key > 1) {
                    DB::connection(self::DB_CONN_NAME)->table(self::T_TRJ_APPROVAL)->insert([
                    // Log::info([
                        'trj_id' => $trjId,
                        'm_training_approval_id' => $value,
                        'jenis' => 'disetujui',
                        'approval_order' => $_tempAppr['disetujui'],
                        'status' => 0,
                        'created_at' => $tgl,
                        'created_by' => $nik_session
                    ]);
                    $_tempAppr['disetujui']++;
                } else if($key > 0) {
                    DB::connection(self::DB_CONN_NAME)->table(self::T_TRJ_APPROVAL)->insert([
                    // Log::info([
                        'trj_id' => $trjId,
                        'm_training_approval_id' => $value,
                        'jenis' => 'dibuat',
                        'approval_order' => $_tempAppr['dibuat'],
                        'status' => 0,
                        'created_at' => $tgl,
                        'created_by' => $nik_session
                    ]);
                    $_tempAppr['dibuat']++;
                }
            } 

            // dd($approval);

            $listIdDetail = [];
            $listIdKomitmen = [];
            // TODO : insert atau update pengajuan training detail
            foreach ($detail as $value) {
                // Log::info('insert : '. json_encode($value));
                $pengajuanDetailId = 0;
                $trainingKomitmenId = 0;
                // detail bukan merupakan dari list ATMP
                if($value['id'] == 0) {
                    $pengajuanDetailId = DB::connection(self::DB_CONN_NAME)->table(self::T_PENGAJUAN_TRAINING_DTL)
                        ->insertGetId([
                            'NIK' => $value['NIK'],
                            'KodeDP' => $value['KodeDP'],
                            'KodeST' => $value['KodeST'],
                            'status_id' => $value['status_id'],
                            'matrix_kompetensi' => $value['matrix_kompetensi'],
                            'matrix_sertifikasi' => $value['matrix_sertifikasi'],
                            'matrix_masa_kerja' => $value['matrix_mk'],
                            'pengajuan_training_id' => $pengajuanId,
                            'trj_id' => $trjId,
                            'replacing' => isset($value['replacing']) ? $value['replacing'] : null,
                            'created_by' => $nik_session,
                            'created_at' => $tgl
                        ]);
                    // TODO : 
                    $trainingKomitmenId = DB::connection(self::DB_CONN_NAME)->table(self::T_TRAINING_KOMITMEN)
                        ->insertGetId([
                            'NIK' => $value['NIK'],
                            'nama' => $value['NIK_nama'],
                            'status' => 0,
                            'm_training_id' => $namaTraining->training_id,
                            'pengajuan_training_detail_id' => $pengajuanDetailId,
                            'pengajuan_training_id' => $pengajuanId,
                            'trj_id' => $trjId,
                            'KodeDP' => $value['KodeDP'],
                            'KodeST' => $value['KodeST'],
                            'KodeJB' => $value['KodeJB'],
                            'created_at' => $tgl,
                            'created_by' => $nik_session,
                        ]);
                    // $listIdKomitmen[] = $trainingKomitmenId;

                    // foreach($approval as $key => $value) {
                    //     if($key > 2) {
                    //         DB::connection(self::DB_CONN_NAME)->table(self::T_TRJ_APPROVAL)->insert([
                    //         // Log::info([
                    //             'trj_id' => $trjId,
                    //             'm_training_approval_id' => $value,
                    //             'jenis' => 'diketahui',
                    //             'approval_order' => $_tempAppr['diketahui'],
                    //             'status' => 0,
                    //             'created_at' => $tgl,
                    //             'created_by' => $nik_session
                    //         ]);
                    //         $_tempAppr['diketahui']++;
                    //     } else if($key > 1) {
                    //         DB::connection(self::DB_CONN_NAME)->table(self::T_TRJ_APPROVAL)->insert([
                    //         // Log::info([
                    //             'trj_id' => $trjId,
                    //             'm_training_approval_id' => $value,
                    //             'jenis' => 'disetujui',
                    //             'approval_order' => $_tempAppr['disetujui'],
                    //             'status' => 0,
                    //             'created_at' => $tgl,
                    //             'created_by' => $nik_session
                    //         ]);
                    //         $_tempAppr['disetujui']++;
                    //     } else if($key > 0) {
                    //         DB::connection(self::DB_CONN_NAME)->table(self::T_TRJ_APPROVAL)->insert([
                    //         // Log::info([
                    //             'trj_id' => $trjId,
                    //             'm_training_approval_id' => $value,
                    //             'jenis' => 'dibuat',
                    //             'approval_order' => $_tempAppr['dibuat'],
                    //             'status' => 0,
                    //             'created_at' => $tgl,
                    //             'created_by' => $nik_session
                    //         ]);
                    //         $_tempAppr['dibuat']++;
                    //     }
                    // } 
                    
                        // Helper::SFNotification($value['NIK'], 'Anda diajukan untuk mengikuti ' . $namaTraining->training_nama, 'info', '/ic/training/form-komitmen/'.$trainingKomitmenId);
                } else {
                    $pengajuanDetailId = $value['id'];
                    DB::connection(self::DB_CONN_NAME)->table(self::T_PENGAJUAN_TRAINING_DTL)
                        ->where('id', $value['id'])
                        ->update([
                            'status_id' => $value['status_id'],
                            'matrix_kompetensi' => $value['matrix_kompetensi'],
                            'matrix_sertifikasi' => $value['matrix_sertifikasi'],
                            'matrix_masa_kerja' => $value['matrix_mk'],
                            'KodeDP' => $value['KodeDP'],
                            'KodeST' => $value['KodeST'],
                            'trj_id' => $trjId
                        ]);
                    if($value['status_id'] == -1) {
                        DB::connection(self::DB_CONN_NAME)->table(self::T_TRAINING_KOMITMEN)
                            ->where('pengajuan_training_detail_id', $value['id'])
                            ->update([
                                'status' => -2
                            ]);
                    }
                }

                $listIdDetail[] = $pengajuanDetailId;
                // TODO : insert ke training_komitmen
                // TODO : ubah hanya insert ke tabel komitmen ketika penambahan atau penggantian
                // $trainingKomitmenId = DB::connection(self::DB_CONN_NAME)->table(self::T_TRAINING_KOMITMEN)
                //     ->insertGetId([
                //         'NIK' => $value['NIK'],
                //         'nama' => $value['NIK_nama'],
                //         'status' => 0,
                //         'm_training_id' => $namaTraining->training_id,
                //         'pengajuan_training_detail_id' => $pengajuanDetailId,
                //         'pengajuan_training_id' => $pengajuanId,
                //         'trj_id' => $trjId,
                //         'KodeDP' => $value['KodeDP'],
                //         'KodeST' => $value['KodeST'],
                //         'KodeJB' => $value['KodeJB'],
                //         'created_at' => $tgl,
                //         'created_by' => $nik_session,
                //     ]);
                // Helper::SFNotification($value['NIK'], 'Anda diajukan untuk mengikuti ' . $namaTraining->training_nama, 'info', '/ic/training/form-komitmen/'.$trainingKomitmenId);
                // TODO : terapkan approval yang dipilih ke semua komitmen
                // $_tempApprKom = [
                //     'disetujui' => 1,
                //     'diketahui' => 1
                // ];

                // foreach($approval as $key => $value) {
                //     if($key < 2) {
                //         DB::connection(self::DB_CONN_NAME)->table(self::T_KOMITMEN_APPROVAL)->insert([
                //             'training_komitmen_id' => $trainingKomitmenId,
                //             'm_training_approval_id' => $value,
                //             'approval_order' => $_tempApprKom['disetujui'],
                //             'status' => 0,
                //             'jenis' => 'disetujui',
                //             'created_at' => $tgl,
                //             'created_by' => $nik_session
                //         ]);
                //         $_tempApprKom['disetujui']++;
                //     } else if($key > 1 && $key < 4) {
                //         DB::connection(self::DB_CONN_NAME)->table(self::T_KOMITMEN_APPROVAL)->insert([
                //             'training_komitmen_id' => $trainingKomitmenId,
                //             'm_training_approval_id' => $value,
                //             'approval_order' => $_tempApprKom['diketahui'],
                //             'status' => 0,
                //             'jenis' => 'diketahui',
                //             'created_at' => $tgl,
                //             'created_by' => $nik_session
                //         ]);
                //         $_tempApprKom['diketahui']++;
                //     }
                // }
                
            }

            $idKomitmenFromDetail = DB::connection(self::DB_CONN_NAME)->table(self::T_TRAINING_KOMITMEN)
                ->select('id')
                ->whereIn('pengajuan_training_detail_id', $listIdDetail)->get();
            foreach($idKomitmenFromDetail as $_tempIdKomitmen) {
                $listIdKomitmen[] = $_tempIdKomitmen->id;
            }

            foreach ($listIdKomitmen as $_tempIdKomitmen) {
                $_tempApprKom = [
                    'disetujui' => 1,
                    'diketahui' => 1
                ];

                foreach($approval as $key => $value) {
                    if($key < 2) {
                        DB::connection(self::DB_CONN_NAME)->table(self::T_KOMITMEN_APPROVAL)->insert([
                            'training_komitmen_id' => $_tempIdKomitmen,
                            'm_training_approval_id' => $value,
                            'approval_order' => $_tempApprKom['disetujui'],
                            'status' => 0,
                            'jenis' => 'disetujui',
                            'created_at' => $tgl,
                            'created_by' => $nik_session
                        ]);
                        $_tempApprKom['disetujui']++;
                    } else if($key > 1 && $key < 4) {
                        DB::connection(self::DB_CONN_NAME)->table(self::T_KOMITMEN_APPROVAL)->insert([
                            'training_komitmen_id' => $_tempIdKomitmen,
                            'm_training_approval_id' => $value,
                            'approval_order' => $_tempApprKom['diketahui'],
                            'status' => 0,
                            'jenis' => 'diketahui',
                            'created_at' => $tgl,
                            'created_by' => $nik_session
                        ]);
                        $_tempApprKom['diketahui']++;
                    }
                }
            }

            $this->generateJustifikasi($detail, $trjId);
            
            DB::connection(self::DB_CONN_NAME)->commit();
            $isSuccess = true;
            $msg = 'Berhasil approve';
        } catch (Exception $ex) {
            $uuidMsg = Str::uuid();
            $msg = 'Error backend : ' . $uuidMsg;
            DB::connection(self::DB_CONN_NAME)->rollBack();
            Log::error('error CrossCheckApprove ' . $uuidMsg .  ' : '. $ex->getMessage());
            Log::error($ex->getTraceAsString());
        }

        return response()->json([
            'isSuccess' => $isSuccess,
            'message' => $msg,
            'errorMessage' => $errMsg
        ]);
    }

    private function generateJustifikasi($pengajuanDetail, $trjId) {
        $groupedData = [
            'form' => false,
            'ba' => false
        ];

        foreach ($pengajuanDetail as $value) {
            // $value['a'] = 'pp';
            if($value['matrix_mk'] < 1) $groupedData['ba'] = true;
            if($value['matrix_mk'] >= 1) $groupedData['form'] = true;
            if($value['id'] == 0) $groupedData['ba'] = true;
            if($value['id'] != 0) $groupedData['form'] = true;
        }
        
        if($groupedData['form']) {
            DB::connection(self::DB_CONN_NAME)->table(self::T_TRJ_DOC)->insert([
                'trj_id' => $trjId,
                'status' => 0,
                'jenis_dokumen' => 0
            ]);
        }

        if($groupedData['ba']) {
            DB::connection(self::DB_CONN_NAME)->table(self::T_TRJ_DOC)->insert([
                'trj_id' => $trjId,
                'status' => 0,
                'jenis_dokumen' => 1
            ]);
        }
        
        return $groupedData;
    }

    public function CrossCheckDtl($id, Request $request) {
        $stdJab = [];
        $dataSudahTraining = [];
        $nik_session = $request->session()->get('user_id', '');
        $dataApproval = [
            '1' => [],
            '2' => [],
            '3' => [],
            '4' => [],
            '5' => []
        ];

        $dataSubmitted = [
            'pengganti' => [],
            'tujuan' => [],
            'urgensi' => []
        ];
        // dd($this->getChecker('ENG', 'MME'));
        // select trj.id, trj.KodeDP, trj.KodeST, ptd.NIK
        //     from training_rekomendasi_justifikasi as trj
        //     left join pengajuan_training as pt on trj.pengajuan_training_id=pt.id
        //     right join pengajuan_training_detail as ptd on pt.id=ptd.pengajuan_training_id
        //     where trj.id=1 and ptd.KodeDP=trj.KodeDP and ptd.KodeST=trj.KodeST
        
        // select trj.id, trj.KodeDP, trj.KodeST, mt.nama as pelatihan, mt.id as id_training, sjt.*
        //     from training_rekomendasi_justifikasi as trj
        //     left join pengajuan_training as pt on trj.pengajuan_training_id = pt.id
        //     left join m_training as mt on pt.m_training_id = mt.id
        //     right join std_jab_training as sjt on mt.id=sjt.m_training_id
        //     where trj.id=603

        // select pt.id as pengajuan_id, mt.nama as pelatihan_nama, ptd.NIK, ptd.id as detail_id, ptd.status_id, ptd.KodeDP, ptd.KodeST 
        //     from pengajuan_training as pt
        //     left join m_training as mt on pt.m_training_id = mt.id
        //     right join pengajuan_training_detail as ptd on pt.id=ptd.pengajuan_training_id
        //     where pt.m_training_id = 341 and pt.id <> 241 and ptd.status_id = 1

        $sqlTRJ = DB::connection(self::DB_CONN_NAME)->table(self::T_TRJ . ' as trj')
            // ->select('ptd.id', 'trj.KodeDP', 'td.nama as departement', 'trj.KodeST', 'ptd.NIK', 
            ->select('trj.KodeDP', 'trj.KodeST', 'trj.id', 'mt.id as training_id', 'mt.nama as training_nama', 
                'trj.id as trj_id', 'trj.status as trj_status', 'tk.NIK', 'tk.nama', 'trj.tempat', 'trj.tanggal')
            ->leftJoin(self::T_PENGAJUAN_TRAINING . ' as pt','trj.pengajuan_training_id', '=', 'pt.id')
            ->leftJoin(self::T_M_TRAINING . ' as mt', 'pt.m_training_id', '=', 'mt.id')
            ->leftJoin(self::T_HRD_DEPT . ' as td', 'trj.KodeDP', '=', 'td.KodeDP')
            ->leftJoin(self::T_HRD_KARYAWAN . ' as tk', 'trj.created_by', '=', 'tk.NIK')
            ->where('trj.id', $id)->first();
        if(!$sqlTRJ) return abort(404, 'Data pelatihan tidak ditemukan');
        if($sqlTRJ) {
            try {
                $parsedTgl = Carbon::parse($sqlTRJ->tanggal)->locale('id');
                $sqlTRJ->tanggal = $parsedTgl->day . ' ' . $parsedTgl->monthName . ' ' .$parsedTgl->year;
            } catch (InvalidFormatException $err) {
                Log::error('error parsing tanggal');
            }
        }

        $sqlDataPelatihan = DB::connection(self::DB_CONN_NAME)->table(self::T_TRJ . ' as trj')
            ->select('mt.nama as pelatihan', 'mt.id as id_training', 'pt.id as pengajuan_id', 'trj.KodeDP as KodeDP_trj',
                'trj.KodeST as KodeST_trj', 'trj.id as trj_id', 'trj.status as trj_status', 'pt.bulan', 'pt.tahun')
            ->leftJoin(self::T_PENGAJUAN_TRAINING . ' as pt', 'trj.pengajuan_training_id', '=', 'pt.id')
            ->leftJoin(self::T_M_TRAINING . ' as mt', 'pt.m_training_id', '=', 'mt.id')
            ->where('trj.id', $id);
        $pelatihan = $sqlDataPelatihan->first();
        $pelatihan->planPelatihan = $this->bulanMapping[$pelatihan->bulan] . ' ' . $pelatihan->tahun;
        $crossCheckPIC = $this->getChecker($pelatihan->KodeDP_trj, $pelatihan->KodeST_trj);
        
        $sqlDataStdJab = DB::connection(self::DB_CONN_NAME)->table(self::T_TRJ . ' as trj')
            ->select('mt.nama as pelatihan', 'mt.id as id_training', 'sjt.KodeJB', 'tj.nama as jabatan')
            ->leftJoin(self::T_PENGAJUAN_TRAINING . ' as pt', 'trj.pengajuan_training_id', '=', 'pt.id')
            ->leftJoin(self::T_M_TRAINING . ' as mt', 'pt.m_training_id', '=', 'mt.id')
            ->rightJoin(self::T_STD_JAB . ' as sjt', 'mt.id', '=', 'sjt.m_training_id')
            ->leftJoin(self::T_HRD_JABATAN . ' as tj', 'sjt.KodeJB', '=', 'tj.KodeJB')
            ->where('trj.id', $id);
        $stdJab = $sqlDataStdJab->get();
        $sqlDataSudahTraining = DB::connection(self::DB_CONN_NAME)->table(self::T_PENGAJUAN_TRAINING . ' as pt')
            ->select('ptd.NIK')
            ->leftJoin(self::T_M_TRAINING . ' as mt', 'pt.m_training_id', '=', 'mt.id')
            ->rightJoin(self::T_PENGAJUAN_TRAINING_DTL .  ' as ptd', 'pt.id', '=', 'ptd.pengajuan_training_id')
            ->where('pt.m_training_id', $pelatihan->id_training)
            ->whereNot('pt.id', $pelatihan->pengajuan_id)
            ->where('ptd.status_id', 1);
        $dataSudahTraining = $sqlDataSudahTraining->get();

        $listApproval = $this->formKomitmenApprovalList($pelatihan->KodeDP_trj, $pelatihan->KodeST_trj, true);
        foreach ($listApproval as $value) {
            if($value->approval_role == 1) $dataApproval['1'][] = $value;
            if($value->approval_role == 2) $dataApproval['2'][] = $value;
            if($value->approval_role == 3) $dataApproval['3'][] = $value;
            if($value->approval_role == 4) $dataApproval['4'][] = $value;
            if($value->approval_role == 5) $dataApproval['5'][] = $value;
        }

        if($sqlTRJ->trj_status != 0) {
            // $selectedAppoval[] = ['NIK' => $sqlTRJ->NIK, 'nama' => $sqlTRJ->nama, 'status' => $apporvalStatus[1]];
            $sqlSelectedApproval =  DB::connection(self::DB_CONN_NAME)->table(self::T_TRJ_APPROVAL . ' as tka')
                ->select('tapp.NIK', 'tapp.nama', 'tka.jenis', 'tka.approval_order', 'tka.status', 'tka.id', 'tapp.id as approval_id')
                ->leftJoin(self::T_JENIS_APPROVAL . ' as ja', 'tka.jenis', '=', 'ja.kode')
                ->leftJoin(self::T_TRAINING_APPROVAL . ' as tapp', 'tapp.id', '=', 'tka.m_training_approval_id')
                ->orderBy('ja.urutan')
                ->orderBy('tka.approval_order')
                ->where('tka.trj_id', $id)->get();

            $sqlTujuan = DB::connection(self::DB_CONN_NAME)->table(self::T_TRJ_TUJUAN . ' as a')
                ->leftJoin(DB::getDatabaseName() . '.dbo.'. self::T_PICA_KPI . ' as b', 'a.keterangan', '=', 'b.kpi_code')
                ->select('a.keterangan', 'b.kpi as nama')
                ->where('trj_id', $id)->get();
            $sqlPengganti = DB::connection(self::DB_CONN_NAME)->table(self::T_TRJ_PENGGANTI. ' as a')
                ->leftJoin(self::T_HRD_KARYAWAN . ' as b', 'a.keterangan', '=', 'b.NIK')
                ->select('a.keterangan', 'b.nama')
                ->where('trj_id', $id)->get();
            $sqlUrgensi = DB::connection(self::DB_CONN_NAME)->table(self::T_TRJ_URGENSI)
                ->select('keterangan')
                ->where('trj_id', $id)->get();

            $dataSubmitted['tujuan'] = $sqlTujuan;
            $dataSubmitted['pengganti'] = $sqlPengganti;
            $dataSubmitted['urgensi'] = $sqlUrgensi;
        }
        // dd($dataApproval);
        // Log::info($crossCheckPIC);
        return view('smartform::ic/pengajuan-training/cross-check-dtl', [
            'stdJab' => $stdJab, 'trjID' => $id, 'pelatihan' => $pelatihan, 'sudahTraining' => $dataSudahTraining, 
            'crossCheckPIC' => $crossCheckPIC, 'listApproval' => $dataApproval , 'data' => $sqlTRJ, 
            'dataSubmitted' => $dataSubmitted
        ]);
        
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
                // ->select('ptd.id', 'trj.KodeDP', 'td.nama as departement', 'trj.KodeST', 'ptd.NIK', 
                ->select('ptd.id', 'tk.KodeDP', 'td.nama as departement', 'tk.KodeST', 'ptd.NIK', 'ptd.replacing',
                    'tk.nama as NIK_nama', 'ptd.status_id', 'tk.KodeJB', 'tj.nama as jabatan', 'tk.Tgl_Masuk as tmk', 'tkom.status as komitmen_status',
                    'tkom.id as komitmen_id'
                )
                ->leftJoin(self::T_PENGAJUAN_TRAINING . ' as pt','trj.pengajuan_training_id', '=', 'pt.id')   
                ->rightJoin(self::T_PENGAJUAN_TRAINING_DTL .  ' as ptd', 'pt.id', '=', 'ptd.pengajuan_training_id')
                ->leftJoin(self::T_HRD_KARYAWAN . ' as tk', 'ptd.NIK', '=', 'tk.NIK')
                ->leftJoin(self::T_HRD_DEPT . ' as td', 'tk.KodeDP', '=', 'td.KodeDP')
                ->leftJoin(self::T_HRD_JABATAN . ' as tj', 'tk.KodeJB', '=', 'tj.KodeJB')
                ->leftJoin(self::T_TRAINING_KOMITMEN . ' as tkom', 'tkom.pengajuan_training_detail_id', '=', 'ptd.id')
                ->where('trj.id', $idTRJ)
                // ->where('ptd.KodeDP', DB::raw('trj.KodeDP'))
                // ->where('ptd.KodeST', DB::raw('trj.KodeST'))
                ->where('tk.KodeDP', DB::raw('trj.KodeDP'))
                ->where('tk.KodeST', DB::raw('trj.KodeST'))
                // ->where('tkom.is_deleted', 0)
            ;
            Log::info($dataSql->toRawSql());
            // $data['total'] = $dataSql->count();
            // $data['totalNotFiltered'] = $data['total'];
            $data['rows'] = $dataSql->get();
            // Log::info(array_column($data['rows']->toArray(), 'NIK'));
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
        $pelatihanId = $request->query('pelatihan'); 
        $site = $request->query('site'); 
        $department = $request->query('department');
        $waktuPelatihan = $request->query('waktu');
        $validator = Validator::make(
            $request->only('waktu'), 
            [
                'waktu' => ['date_format:"m-Y"'], 
            ]
        );
        $filterNIK =  $request->query('nik');

        try {
            $sqlData = DB::connection(self::DB_CONN_NAME)->table(self::T_TRJ . ' as trj')
                ->select('trj.id as trj_id', 'trj.pengajuan_training_id', 'mt.nama as nama_pelatihan', 'mt.id as id_training', 
                    'trj.KodeDP', 'td.Nama as dept', 'trj.KodeST', 'pj.bulan', 'pj.tahun', 'trj.status')
                ->leftJoin(self::T_PENGAJUAN_TRAINING . ' as pj','trj.pengajuan_training_id', '=', 'pj.id')
                ->leftJoin(self::T_M_TRAINING . ' as mt', 'pj.m_training_id', '=', 'mt.id')
                ->leftJoin(self::T_HRD_DEPT . ' as td', 'td.KodeDP', '=', 'trj.KodeDP')
                // ->orderBy('pj.tahun')
                // ->orderBy('pj.bulan')
                ->orderByDesc('trj.status')
                // ->where('mt.id', 334)
            ;
            if($filterNIK) {
                $sqlData->join(self::T_TRAINING_KOMITMEN . ' as tkom', 'tkom.trj_id', '=', 'trj.id')->where('tkom.nik', $filterNIK);
            }
            if($pelatihanId) {
                $sqlData->where('pj.m_training_id', $pelatihanId);
            }
            if($site) {
                $sqlData->where('trj.KodeST', $site);
            }
            if($department) {
                $sqlData->where('trj.KodeDP', $department);
            }
            if($waktuPelatihan) {
                if(count($validator->errors()->all()) < 1) {
                    $splitWaktu = explode('-', $waktuPelatihan);
                    $sqlData->where('pj.bulan', $splitWaktu[0])->where('pj.tahun', $splitWaktu[1]);
                }
            }

            $jml = $sqlData->count();
            if($limit == null || $limit == 'null' || $limit == '') {
                $sqlData->skip($offset);
            } else {
                $sqlData->skip($offset)->limit($limit);
            }
            Log::debug('SQL Cross check : ' . $sqlData->toRawSql());
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

    private function getChecker($KodeDP, $KodeST) {
        $data = [];

        try {
            $sqlDataApproval = DB::connection(self::DB_CONN_NAME)->table(self::T_TRAINING_APPROVAL)
                ->select('NIK', 'nama', 'KodeDP', 'KodeST')
                ->where('KodeDP', $KodeDP)
                // ->where('KodeST', $KodeST)
                ->where('approval_role', 1);
            $data = $sqlDataApproval->get();
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
        }

        return $data;
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
        $isSuccess = false;
        $message = '';
        try {
            // Log::info("training kategori");
            // foreach ($training_kategori as $value) {
            //     Log::info(json_encode($value, JSON_PRETTY_PRINT));
            // }

            // Log::info("training");
            // Log::info("training kategori");
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
            // foreach ($jabatan as $value) {
            //     Log::info(json_encode($value, JSON_PRETTY_PRINT));
            //     DB::connection(self::DB_CONN_NAME)->table('tjabatan')->insert([
            //         'Nama' => $value['jabatan'],
            //         'KodeJB' => $value['KodeJB']
            //     ]);
            // }
            Log::info('sudah training');
            // $lowercaseArray = array_change_key_case($groupedSudahTraining, CASE_LOWER);
            // Log::info('grouped training : '. json_encode($lowercaseArray, JSON_PRETTY_PRINT));

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
            // Log::info($std_jab);

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
                    // Log::info($value1);
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
            // Log::info('grouped training : '. json_encode($lowercaseArray, JSON_PRETTY_PRINT));
            // Log::info('grouped sudah training : '. json_encode($groupedSudahTraining, JSON_PRETTY_PRINT));

            DB::connection(self::DB_CONN_NAME)->commit();
            $isSuccess = true;
            $message = "Berhasil import master training";
        } catch (Exception $ex) {
            $traceId = Str::uuid();
            $message = 'Terjadi kesalahan, trace id : ' . $traceId;
            DB::connection(self::DB_CONN_NAME)->rollBack();
            Log::error($traceId. ' : ' .$ex->getMessage());
            Log::error($ex->getTraceAsString());
        }

        return response()->json([
            'isSuccess' => $isSuccess,
            'message' => $message
        ]);
    }

    public function ImportATMP(Request $request) {
        Log::info('start');
        $createdAt = now();
        $nik_session = $request->session()->get('user_id', '');
        $atmp = $request->input('atmp', []);
        $groupedTraining = [];
        $typo = [];
        $perBulanperGrup = [];
        $nikERP = [];
        $listNik = $request->input('listNIK', []);
        $isSuccess = false;


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

            $listKaryawan = [];
            $mappingNIK = [];
            $chunkNIK = collect($listNik)->chunk(1000);
            try {
                foreach ($chunkNIK as $chunkNIK) {
                    // Log::info($chunkNIK);
                    $listKaryawan[] = DB::connection(self::DB_CONN_NAME)->table(self::T_HRD_KARYAWAN)
                        ->select('NIK', 'Nama', 'KodeJB', 'KodeDP', 'KodeST')
                        // ->whereIn('NIK', $chunkNIK)
                        ->get();
                }
                foreach ($listKaryawan as $chunkNIK) {
                    foreach ($chunkNIK as $dataListKaryawan) {
                        // Log::info(json_encode($dataListKaryawan));
                        $mappingNIK[$dataListKaryawan->NIK] = [
                            'NIK' => $dataListKaryawan->NIK,
                            'Nama' => $dataListKaryawan->Nama,
                            'KodeJB' => $dataListKaryawan->KodeJB,
                            'KodeDP' => $dataListKaryawan->KodeDP,
                            'KodeST' => $dataListKaryawan->KodeST
                        ];
                    }
                }
            } catch (Exception $ex) {

            }
            
            // Log::debug("debug");
            foreach ($value as $value1) {
                // Log::info($value1);
                if(isset($value1['DEPARTMENT'])) $value1['DEPARTMENT'] = self::mappingDP[$value1['DEPARTMENT']];
                if(isset($value1['NIK'])) {
                    if(isset($mappingNIK[$value1['NIK']])) {
                        $value1['DEPARTMENT'] = $mappingNIK[$value1['NIK']]['KodeDP'];
                        $value1['SITE'] = $mappingNIK[$value1['NIK']]['KodeST'];
                        $value1['KodeJB'] = $mappingNIK[$value1['NIK']]['KodeJB'];
                    }
                    // if(isset($mappingNIK[$value1['SITE']])) {
                    // }
                }
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
        // Log::info('perBulanPerGroup : '. json_encode($perBulanperGrup, JSON_PRETTY_PRINT));
        $perBulanPerGrup = collect($perBulanperGrup)->sortBy([['tahun', 'asc'], ['bulan', 'asc']]);
        // Log::info("grouped training " . count($groupedTraining). " : " . json_encode($groupedTraining, JSON_PRETTY_PRINT));
        Log::info('end');
        // return response()->json(['isSuccess' => $isSuccess]);
        try {
            DB::connection(self::DB_CONN_NAME)->beginTransaction();
            // dd($listNik);

            // DB::connection(self::DB_CONN_NAME)->beginTransaction();
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

                                    $groupPelatihanByDeptAndSite[$value2['SITE']. '_'. $value2['DEPARTMENT']]['trj_id'] = DB::connection(self::DB_CONN_NAME)->table(self::T_TRJ)->insertGetId([
                                        'pengajuan_training_id' => $idInsertPengajuan, 'jenis' => 0, 'status' => 0, 'KodeST' => $value2['SITE'], 'KodeDP' => $value2['DEPARTMENT']
                                    ]);
                                }
                            }
                            // TODO : insert pengajuan_training_detail
                            // Log::info([
                            //     'pengajuan_training_id' => $idInsertPengajuan,
                            //     'NIK' => $value2['NIK'],
                            //     'KodeST' => isset($value2['SITE']) ? $value2['SITE'] : '',
                            //     'KodeDP' => isset($value2['DEPARTMENT']) ? $value2['DEPARTMENT'] : '',
                            //     'status_id' => 0,
                            //     'matrix' => isset($value2['ALARM BY MATRIX KOMPETENSI']) ? $value2['ALARM BY MATRIX KOMPETENSI'] : '',
                            //     'created_at' => $createdAt,
                            //     'created_by' => $nik_session
                            // ]);
                            $pengajuanDetailId = DB::connection(self::DB_CONN_NAME)->table(self::T_PENGAJUAN_TRAINING_DTL)
                                ->insertGetId([
                                    'pengajuan_training_id' => $idInsertPengajuan,
                                    'NIK' => $value2['NIK'],
                                    // 'KodeST' => isset($value2['SITE']) ? $value2['SITE'] : '',
                                    // 'KodeDP' => isset($value2['DEPARTMENT']) ? $value2['DEPARTMENT'] : '',
                                    'status_id' => 0,
                                    'matrix' => isset($value2['ALARM BY MATRIX KOMPETENSI']) ? $value2['ALARM BY MATRIX KOMPETENSI'] : '',
                                    'created_at' => $createdAt,
                                    'created_by' => $nik_session,
                                    'trj_id' => $groupPelatihanByDeptAndSite[$value2['SITE']. '_'. $value2['DEPARTMENT']]['trj_id']
                                ]);

                            // Log::info($value2);
                            $trainingKomitmenId = DB::connection(self::DB_CONN_NAME)->table(self::T_TRAINING_KOMITMEN)
                                ->insertGetId([
                                    'NIK' => $value2['NIK'],
                                    'nama' => isset($value2['NAMA']) ? $value2['NAMA'] : $mappingNIK[$value2['NIK']]['Nama'],
                                    'status' => 0,
                                    'm_training_id' => $idTraining,
                                    'pengajuan_training_detail_id' => $pengajuanDetailId,
                                    'pengajuan_training_id' => $idInsertPengajuan,
                                    'trj_id' => $groupPelatihanByDeptAndSite[$value2['SITE']. '_'. $value2['DEPARTMENT']]['trj_id'],
                                    'KodeDP' => $value2['DEPARTMENT'],
                                    'KodeST' => $value2['SITE'],
                                    'KodeJB' => $value2['KodeJB'],
                                    'created_at' => $createdAt,
                                    'created_by' => $nik_session,
                                ]);
                            
                            // Helper::SFNotification($value2['NIK'], 'Anda diajukan untuk mengikuti ' . $value2['JENIS TRAINING'], 'info', '/ic/training/form-komitmen/'.$trainingKomitmenId);
                            
                        }
                        // Log::debug('groupPelatihanByDeptAndSite : '. json_encode($groupPelatihanByDeptAndSite, JSON_PRETTY_PRINT));
                        // foreach ($groupPelatihanByDeptAndSite as $key => $value) {   
                        //     DB::connection(self::DB_CONN_NAME)->table(self::T_TRJ)->insert($value);
                        // }
                    }
                }
            }
            DB::connection(self::DB_CONN_NAME)->commit();
            $isSuccess = true;
        } catch (Exception $ex) {

            // DB::connection(self::DB_CONN_NAME)->rollBack();
            Log::error('error insert pengajuan detail ' . $ex->getMessage(). ' : '. $ex->getTraceAsString());
        }

        return response()->json(['isSuccess' => $isSuccess]);
    }

    public function FormKomitmen($id) {
        $selectedApproval = [];
        $currentApproval = [
            'NIK' => null,
            'id' => 0
        ];
        $approvalStatusMapping = [
            0 => 'Not yet',
            1 => 'Approved',
            -1 => 'Rejected',
            -2 => 'Rejected'
        ];

        $sqlDataKomitmen = DB::connection(self::DB_CONN_NAME)->table(self::T_TRAINING_KOMITMEN . ' as tkom')
            ->select('trj.KodeDP', 'trj.KodeST', 'tkom.KodeJB', 'tkom.NIK', 'tkom.nama as NIK_nama', 'mt.nama as training_nama', 
                'tj.nama as jabatan', 'td.nama as departemen', 'tkom.status', 'tkom.keterangan', 'tkom.tanggal_dibuat')
            ->leftJoin(self::T_M_TRAINING . ' as mt', 'tkom.m_training_id', '=', 'mt.id')
            ->leftJoin(self::T_TRJ . ' as trj', 'tkom.trj_id', '=', 'trj.id')
            ->leftJoin(self::T_HRD_JABATAN . ' as tj', 'tkom.KodeJB', '=', 'tj.KodeJB')
            ->leftJoin(self::T_HRD_DEPT . ' as td', 'trj.KodeDP', '=', 'td.KodeDP')
            ->where('tkom.id', $id);
        $dataKomitmen = $sqlDataKomitmen->first();
        $listApproval = $this->formKomitmenApprovalList($dataKomitmen->KodeDP, $dataKomitmen->KodeST);
        // dd($dataKomitmen);
        $dataApproval = [
            'disetujui' => [
                '1' => []
            ],
            'diketahui' => [
                '1' => [],
                '2' => []
            ]
        ];

        foreach($listApproval as $value) {
            if($value->approval_role == 1) {
                $dataApproval['disetujui']['1'][] = $value;
            }
            if($value->approval_role == 2) {
                $dataApproval['diketahui']['1'][] = $value;
            }
            if($value->approval_role == 3 || $value->approval_role == 4) {
                $dataApproval['diketahui']['2'][] = $value;
            }
        }

        if($dataKomitmen->status != 0) {
            $selectedApprovalSql = DB::connection(self::DB_CONN_NAME)->table(self::T_KOMITMEN_APPROVAL . ' as tka')
                ->select('tapp.NIK', 'tapp.nama', 'tka.jenis', 'tka.approval_order', 'tka.status', 'tka.id')
                ->leftJoin(self::T_TRAINING_KOMITMEN . ' as tkom', 'tka.training_komitmen_id', '=', 'tkom.id')
                ->leftJoin(self::T_JENIS_APPROVAL . ' as ja', 'tka.jenis', '=', 'ja.kode')
                ->leftJoin(self::T_TRAINING_APPROVAL . ' as tapp', 'tapp.id', '=', 'tka.m_training_approval_id')
                ->orderBy('ja.urutan')
                ->orderBy('tka.approval_order')
                ->where('tkom.id', $id);
            Log::info($selectedApprovalSql->toRawSql());
            $selectedApproval = $selectedApprovalSql->get();
            // dd($selectedApproval);
            foreach($selectedApproval as $nilai) {
                if($nilai->status == 0) {
                    $currentApproval['id'] = $nilai->id;
                    $currentApproval['NIK'] = $nilai->NIK;
                    break;
                }
            }
        }

        $tgldibuat = $dataKomitmen->status != 0 ? Carbon::parse($dataKomitmen->tanggal_dibuat) : now();

        // dd(Carbon::parse($dataKomitmen->tanggal_dibuat)->locale('id')->month);
        $tgldibuat = $tgldibuat->day . " " . $this->bulanMapping[$tgldibuat->month] . " " . $tgldibuat->year;
        // dd($selectedApproval);
        return view('smartform::ic/pengajuan-training/form-komitmen', [
            'data' => $dataKomitmen, 'dataApproval' => $dataApproval, 'komitmenId' => $id,
            'selectedApproval' => $selectedApproval, 'currentApproval' => $currentApproval,
            'approvalStatusMapping' => $approvalStatusMapping, 'tglDibuat' => $tgldibuat
        ]);
    }

    public function SubmitFormKomitmen(Request $request) {
        $komitmenId = $request->input('komitmenId');
        $status = $request->input('isSetuju');
        $alasanId = $request->input('alasanMenolak');
        $keterangan = $request->input('textAlasan');
        $listApproval = $request->input('approval', []);
        $updatedAt = now();
        $nik_session = $request->session()->get('user_id', '');

        $isSuccess = false;
        $msg = "";
        $errMsg = [];

        try {
            DB::connection(self::DB_CONN_NAME)->beginTransaction();
            DB::connection(self::DB_CONN_NAME)->table(self::T_TRAINING_KOMITMEN)->where('id', $komitmenId)->update([
                'status' => $status,
                'alasan_id' => $alasanId,
                'keterangan' => $keterangan,
                'updated_at' => $updatedAt,
                'updated_by' => $nik_session,
                'tanggal_dibuat' => $updatedAt
            ]);
            // Log::info([
            //     'status' => $status,
            //     'alasan_id' => $alasanId,
            //     'keterangan' => $keterangan,
            //     'updated_at' => $updatedAt
            // ]);
            // TODO : implementasi notifikasi
            // $idApproval = array_column($listApproval, 'approvalId');
            // $nikApproval = DB::connection(self::DB_CONN_NAME)->table(self::T_TRAINING_APPROVAL)->select('NIK', 'id')
            //     ->whereIn('id', $idApproval)->get();
            // $nikKeyValue = [];
            // foreach($nikApproval as $data) {
            //     $nikKeyValue[$data->id] = $data->NIK;
            // }

            // if($status == 1) {
            //     foreach ($listApproval as $value) {
            //         // Log::error([
            //         //     'training_komitmen_id' => $komitmenId,
            //         //     'm_training_approval_id' => $value['approvalId'],
            //         //     'approval_order' => $value['approvalOrder'],
            //         //     'jenis' => $value['jenisApproval'],
            //         //     'status' => 0
            //         // ]);
            //         DB::connection(self::DB_CONN_NAME)->table(self::T_KOMITMEN_APPROVAL)->insert([
            //             'training_komitmen_id' => $komitmenId,
            //             'm_training_approval_id' => $value['approvalId'],
            //             'approval_order' => $value['approvalOrder'],
            //             'status' => 0,
            //             'jenis' => $value['jenisApproval'],
            //             'created_at' => $updatedAt,
            //             'created_by' => $nik_session
            //         ]);
            //     }
            //     // TODO : implementasi notifikasi
            // }

            DB::connection(self::DB_CONN_NAME)->commit();
            $isSuccess = true;
            $msg = "Berhasil!";
        } catch (Exception $ex) {
            $errId = Str::uuid();
            $msg = 'Terjadi kesalahan : ' . $errId;
            DB::connection(self::DB_CONN_NAME)->rollBack();
            Log::error('Error ' . $errId . ' : ' . $ex->getMessage());
            Log::error($ex->getTraceAsString());
        }

        return response()->json([
            'isSuccess' => $isSuccess,
            'message' => $msg,
            'errorMessage' => $errMsg
        ]);
    }

    private function formKomitmenApprovalList($KodeDP, $KodeST, $isJustifikasi=false) {
        $listApproval = [];
        try {
            $sqlListApprovalLv1 = DB::connection(self::DB_CONN_NAME)->table(self::T_TRAINING_APPROVAL . ' as tta')
                ->select('tta.NIK', 'tta.nama', 'tta.approval_role', 'tta.nama as text', 'tta.id')
                ->whereIn('tta.approval_role', [1, 3])->where('tta.KodeDP', $KodeDP)->get();
            $sqlListApprovalLv1Up = DB::connection(self::DB_CONN_NAME)->table(self::T_TRAINING_APPROVAL . ' as tta')
                ->select('tta.NIK', 'tta.nama', 'tta.approval_role', 'tta.nama as text', 'tta.id')
                ->where('tta.approval_role', 2);
            $sqlApprvDept = DB::connection(self::DB_CONN_NAME)->table(self::T_TRAINING_APPROVAL . ' as tta')
                ->select('tta.NIK', 'tta.nama', 'tta.approval_role', 'tta.nama as text', 'tta.id')
                ->where('tta.approval_role', 4)->where('tta.KodeDP', $KodeDP)->get();
            if($isJustifikasi) {
                $sqlApprvThinkTank = DB::connection(self::DB_CONN_NAME)->table(self::T_TRAINING_APPROVAL . ' as tta')
                    ->select('tta.NIK', 'tta.nama', 'tta.approval_role', 'tta.nama as text', 'tta.id')
                    ->where('tta.approval_role', 5)->get();
                foreach ($sqlApprvThinkTank as $value) {
                    array_push($listApproval, $value);
                }
            }
            // Log::info($sqlListApprovalLv1Up->toRawSql());
            foreach ($sqlListApprovalLv1Up->get() as $value) {
                array_push($listApproval, $value);
            }
            foreach ($sqlListApprovalLv1 as $value) {
                array_push($listApproval, $value);
            }
            foreach ($sqlApprvDept as $value) {
                array_push($listApproval, $value);
            }

            
        } catch (Exception $ex) {
            Log::error('formKomitmenApprovalList : ' . $ex->getMessage());
            Log::error($ex->getTraceAsString());
        }
        // Log::info($listApproval);
        return $listApproval;
    }

    public function KomitmenApprove(Request $request) {
        $isSuccess = false;
        $msg = "";
        $errMsg = [];

        $komitmenApprovalId = $request->input('approvalId');
        $status = $request->input('status');
        $komitmenId = $request->input('komitmenId');
        $keterangan = $request->input('keterangan');
        $nik_session = $request->session()->get('user_id', '');
        $currentApproval = [
            'id' => 0, 'NIK' => 0
        ];
        
        $tgl = now();

        try {
            DB::connection(self::DB_CONN_NAME)->beginTransaction();
            
            $selectedApproval = DB::connection(self::DB_CONN_NAME)->table(self::T_KOMITMEN_APPROVAL . ' as tka')
                ->select('tapp.NIK', 'tapp.nama', 'tka.jenis', 'tka.approval_order', 'tka.status', 'tka.id')
                ->leftJoin(self::T_TRAINING_KOMITMEN . ' as tkom', 'tka.training_komitmen_id', '=', 'tkom.id')
                ->leftJoin(self::T_JENIS_APPROVAL . ' as ja', 'tka.jenis', '=', 'ja.kode')
                ->leftJoin(self::T_TRAINING_APPROVAL . ' as tapp', 'tapp.id', '=', 'tka.m_training_approval_id')
                ->orderBy('ja.urutan')
                ->orderBy('tka.approval_order')
                ->where('tkom.id', $komitmenId)
            ->get();
            foreach($selectedApproval as $nilai) {
                if($nilai->status == 0) {
                    $currentApproval['id'] = $nilai->id;
                    $currentApproval['NIK'] = $nilai->NIK;
                    break;
                }
            }
            // dd($currentApproval);

            if($nik_session != $currentApproval['NIK']) {
                $msg = 'Error Unauthorized request';
            } else {
                $isLatestApproval = $selectedApproval->where('NIK', '=', $currentApproval['NIK'])->first();
                Log::info([
                    'latest' => $selectedApproval[count($selectedApproval)-1]->NIK,
                    'current' => $isLatestApproval->NIK
                ]);

                DB::connection(self::DB_CONN_NAME)->table(self::T_KOMITMEN_APPROVAL)->where('id', $komitmenApprovalId)
                    ->update([
                        'status' => $status,
                        'keterangan' => $keterangan,
                        'updated_at' => $tgl,
                        'updated_by' => $nik_session
                    ]);
                
                if($status == 1) {
                    if($isLatestApproval->NIK == $selectedApproval[count($selectedApproval)-1]->NIK) {
                        DB::connection(self::DB_CONN_NAME)->table(self::T_TRAINING_KOMITMEN)->where('id', $komitmenId)
                        ->update([
                            'status' => 2,
                            // 'updated_at' => $tgl,
                            // 'updated_by' => $nik_session
                        ]);
                    }

                } else if($status == -1) {
                    DB::connection(self::DB_CONN_NAME)->table(self::T_TRAINING_KOMITMEN)->where('id', $komitmenId)
                    ->update([
                        'status' => -2,
                        'keterangan' => $keterangan,
                        // 'updated_at' => $tgl,
                        // 'updated_by' => $nik_session
                    ]);
                }
                   
                $isSuccess = true;
                $msg = 'Ok!';
            }
            
            DB::connection(self::DB_CONN_NAME)->commit();
        } catch (Exception $ex) {
            DB::connection(self::DB_CONN_NAME)->rollBack();
            $errID = Str::uuid();
            $msg = 'Error ' . $errID;
            Log::error('Error ' . $errID . ' : '. $ex->getMessage());
            Log::error($ex->getTraceAsString());
        }
        
        return response()->json([
            'isSuccess' => $isSuccess,
            'message' => $msg,
            'errorMessage' => $errMsg
        ]);
    }
    
    public function DashboardKomitmen() {
        return view('smartform::ic/pengajuan-training/dashboard-komitmen');
    }

    public function DataDashboardKomitmen(Request $request) {
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
            $sqlData = DB::connection(self::DB_CONN_NAME)->table(self::T_TRAINING_KOMITMEN . ' as tkom')
                ->select('tkom.id', 'tkom.NIK', 'tkom.nama', 'tkom.status', 'tj.nama as jabatan', 'td.nama as department',
                    'tkom.KodeSt as site', 'mt.nama as training')
                ->leftJoin(self::T_HRD_JABATAN . ' as tj', 'tkom.KodeJB', '=', 'tj.KodeJB')
                ->leftJoin(self::T_HRD_DEPT . ' as td', 'tkom.KodeDP', '=', 'td.KodeDP')
                ->leftJoin(self::T_M_TRAINING . ' as mt', 'tkom.m_training_id', '=', 'mt.id')
                ->orderByDesc('tkom.status')
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

    public function Justifikasi($id, Request $request) {
        $selectedAppoval = [];
        $apporvalStatus = [
            '0' => 'On Progress',
            '1' => 'Approved',
            '-1' => 'Rejected'
        ];
        $dataSubmitted = [
            'pengganti' => [],
            'urgensi' => [],
            'tujuan' => []
        ];
        $currentApproval = null;
        
        $sqlTRJ = DB::connection(self::DB_CONN_NAME)->table(self::T_TRJ . ' as trj')
            // ->select('ptd.id', 'trj.KodeDP', 'td.nama as departement', 'trj.KodeST', 'ptd.NIK', 
            ->select('trj.KodeDP', 'trj.KodeST', 'trj.id', 'mt.id as training_id', 'mt.nama as training_nama', 
                'trj.id as trj_id', 'trj.status as trj_status', 'tk.NIK', 'tk.nama', 'trj.tempat', 'trj.tanggal')
            ->leftJoin(self::T_PENGAJUAN_TRAINING . ' as pt','trj.pengajuan_training_id', '=', 'pt.id')
            ->leftJoin(self::T_M_TRAINING . ' as mt', 'pt.m_training_id', '=', 'mt.id')
            ->leftJoin(self::T_HRD_DEPT . ' as td', 'trj.KodeDP', '=', 'td.KodeDP')
            ->leftJoin(self::T_HRD_KARYAWAN . ' as tk', 'trj.created_by', '=', 'tk.NIK')
            ->where('trj.id', $id)->first();
        if($sqlTRJ != null) {
            try {
                $parsedTgl = Carbon::parse($sqlTRJ->tanggal)->locale('id');
                $sqlTRJ->tanggal = $parsedTgl->day . ' ' . $parsedTgl->monthName . ' ' .$parsedTgl->year;
            } catch (InvalidFormatException $err) {
                Log::error('error parsing tanggal');
            }
        }
        $sqlKomitmen = DB::connection(self::DB_CONN_NAME)->table(self::T_TRJ . ' as trj')
            ->select('tkom.id as komitmen_id', 'mt.nama as training_nama', 'tkom.NIK', 'tkom.nama', 'tkom.KodeDP', 'td.nama as departement', 'tkom.KodeST', 'tkom.KodeJB', 'tj.nama as jabatan', 'tkom.status as komitmen_status')
            ->leftJoin(self::T_PENGAJUAN_TRAINING . ' as pt', 'trj.pengajuan_training_id', '=', 'pt.id')
            ->leftJoin(self::T_M_TRAINING . ' as mt', 'pt.m_training_id','=', 'mt.id')
            ->rightJoin(self::T_TRAINING_KOMITMEN . ' as tkom', 'trj.id', '=', 'tkom.trj_id')
            ->leftJoin(self::T_HRD_DEPT . ' as td', 'tkom.KodeDP', '=', 'td.KodeDP')
            ->leftJoin(self::T_HRD_JABATAN . ' as tj', 'tkom.KodeJB', '=', 'tj.KodeJB')
            // ->where('tkom.is_deleted', 0)
            ->where('trj.id', $id)->get();
        
        $sqlJustifikasi = DB::connection(self::DB_CONN_NAME)->table(self::T_TRJ. ' as trj')
            ->select('tdoc.id', 'tdoc.jenis_dokumen', 'tdoc.status')
            ->rightJoin(self::T_TRJ_DOC . ' as tdoc', 'trj.id', '=', 'tdoc.trj_id')
            ->where('trj.id', $id)->get();
        
        // dd($sqlKomitmen);
        // $dataKomitmen = $sqlDataKomitmen->first();
        $listApproval = $this->formKomitmenApprovalList($sqlTRJ->KodeDP, $sqlTRJ->KodeST, true);
        // dd($listApproval);
        $dataApproval = [
            'dibuat' => [
                '1' => []
            ],
            'disetujui' => [
                '1' => []
            ],
            'diketahui' => [
                '1' => [],
                '2' => [],
                '3' => []
            ],
            'authorized' => []
        ];

        foreach($listApproval as $value) {
            if($value->approval_role == 1) {
                $dataApproval['authorized'][] = $value->NIK;
            }
            if($value->approval_role == 1) {
                $dataApproval['dibuat']['1'][] = $value;
            }
            if($value->approval_role == 2) {
                $dataApproval['disetujui']['1'][] = $value;
            }
            if($value->approval_role == 3) {
                $dataApproval['diketahui']['1'][] = $value;
            }
            if($value->approval_role == 4) {
                $dataApproval['diketahui']['2'][] = $value;
            }
            if($value->approval_role == 5) {
                $dataApproval['diketahui']['3'][] = $value;
            }
        }
        // dd($dataApproval);

        $dataApproval['authorized'] = collect($dataApproval['authorized']);
        // $dataApproval['authorized']->search($request->session()->get('user_id', ''));
        // dd(['search' => $dataApproval['authorized']->search($request->session()->get('user_id', '')), 'data' => $dataApproval['authorized'] ]);

        // if($sqlTRJ->trj_status == 2 || $sqlTRJ->trj_status == 3 || $sqlTRJ->trj_status == -2) {
        if($sqlTRJ->trj_status != 0) {
            // $selectedAppoval[] = ['NIK' => $sqlTRJ->NIK, 'nama' => $sqlTRJ->nama, 'status' => $apporvalStatus[1]];
            $sqlSelectedApproval =  DB::connection(self::DB_CONN_NAME)->table(self::T_TRJ_APPROVAL . ' as tka')
                ->select('tapp.NIK', 'tapp.nama', 'tka.jenis', 'tka.approval_order', 'tka.status', 'tka.id', 'tapp.id as approval_id')
                ->leftJoin(self::T_JENIS_APPROVAL . ' as ja', 'tka.jenis', '=', 'ja.kode')
                ->leftJoin(self::T_TRAINING_APPROVAL . ' as tapp', 'tapp.id', '=', 'tka.m_training_approval_id')
                ->orderBy('ja.urutan')
                ->orderBy('tka.approval_order')
                ->where('tka.trj_id', $id)->get();

            $sqlTujuan = DB::connection(self::DB_CONN_NAME)->table(self::T_TRJ_TUJUAN . ' as a')
                ->leftJoin(DB::getDatabaseName() . '.dbo.'. self::T_PICA_KPI . ' as b', 'a.keterangan', '=', 'b.kpi_code')
                ->select('a.keterangan', 'b.kpi as nama')
                ->where('trj_id', $id)->get();
            $sqlPengganti = DB::connection(self::DB_CONN_NAME)->table(self::T_TRJ_PENGGANTI. ' as a')
                ->leftJoin(self::T_HRD_KARYAWAN . ' as b', 'a.keterangan', '=', 'b.NIK')
                ->select('a.keterangan', 'b.nama')
                ->where('trj_id', $id)->get();
            $sqlUrgensi = DB::connection(self::DB_CONN_NAME)->table(self::T_TRJ_URGENSI)
                ->select('keterangan')
                ->where('trj_id', $id)->get();
            
            foreach ($sqlSelectedApproval as $value) {
                $selectedAppoval[] = [
                    'id' => $value->id, 'NIK' => $value->NIK, 'nama' => $value->nama, 'jenis' => $value->jenis,
                    'approvalId' => $value->approval_id,
                    'status' => isset($apporvalStatus[$value->status]) ? $apporvalStatus[$value->status] : '-'
                ];
            }
            $dataSubmitted['pengganti'] = $sqlPengganti;
            $dataSubmitted['tujuan'] = $sqlTujuan;
            $dataSubmitted['urgensi'] = $sqlUrgensi;

            $currentApproval = collect($selectedAppoval)->firstWhere('status', $apporvalStatus['0']);
            // dd([
            //     'current' => $currentApproval,
            //     'session' => $request->session()->get('user_id')
            // ]);
        }
        $isDibuatOleh = false;
        if($currentApproval) {
            $isDibuatOleh = $dataApproval['authorized']->search($request->session()->get('user_id')) !== false && $currentApproval['NIK'] == $request->session()->get('user_id');
        }

        // dd($currentApproval);
        return view('smartform::ic/pengajuan-training/justifikasi', [
            'data' => $sqlTRJ, 'currentApproval' => $currentApproval,
            'listApproval' => $dataApproval, 'isDibuatOleh' => $isDibuatOleh,
            'listKomitmen' => $sqlKomitmen, 'listJustifikasi' => $sqlJustifikasi,
            'selectedApproval' => $selectedAppoval, 'dataSubmitted' => $dataSubmitted
        ]);
    }
    
    public function SubmitJustifikasi(Request $request) {
        $isSuccess = false;
        $msg = '';
        $errMsg = '';
        $data = [];
        $nik_session = $request->session()->get('user_id');
        $tgl = now();

        $trjId = $request->input('trjId');
        $listApproval = $request->input('approval');
        $listJustifikasi = $request->input('justifikasi');
        $listPengganti = $request->input('pengganti', []);
        $listTujuan = $request->input('tujuan', []);
        $listUrgensi = $request->input('urgensi', []);
        $tanggal = $request->input('tanggal');
        $tempat = $request->input('tempat');

        try {
            // TODO : update justifikasi
            DB::connection(self::DB_CONN_NAME)->beginTransaction();
            DB::connection(self::DB_CONN_NAME)->table(self::T_TRJ_DOC)->where('trj_id', $trjId)
                ->update([
                    'status' => 1,
                ]);
            
            // TODO : update tempat & tanggal pelaksanaan di TRJ
            // DB::connection(self::DB_CONN_NAME)->table(self::T_TRJ)->where('id', $trjId)
            //     ->update([
            //         'tanggal' => $tanggal,
            //         'tempat' => $tempat,
            //         'status' => 2,
            //         'created_by' => $nik_session,
            //         'created_at' => $tgl
            //     ]);
                
            // TODO : insert into trj_approval
            // foreach ($listApproval as $value) {
            //     if(isset($value['approvalId'])) {
            //         DB::connection(self::DB_CONN_NAME)->table(self::T_TRJ_APPROVAL)->insert([
            //             'trj_id' => $trjId,
            //             'm_training_approval_id' => $value['approvalId'],
            //             'jenis' => $value['jenisApproval'],
            //             'approval_order' => $value['approvalOrder'],
            //             'status' => 0,
            //             'created_at' => $tgl,
            //             'created_by' => $nik_session
            //         ]);
            //         // Log::info();
            //     }
            // }
            // TODO : insert detail pengganti
            // foreach ($listPengganti as $value1) {
            //     DB::connection(self::DB_CONN_NAME)->table(self::T_TRJ_PENGGANTI)
            //     ->insert([
            //         'trj_id' => $trjId,
            //         'keterangan' => $value1,
            //         'created_at' => $tgl,
            //         'created_by' => $nik_session
            //     ]);
            //     // Log::info([
            //     //     'trj_id' => $trjId,
            //     //     'keterangan' => $value1,
            //     //     'created_at' => $tgl,
            //     //     'created_by' => $nik_session
            //     // ]);
            // }
            // TODO : insert detail tujuan 
            // foreach ($listTujuan as $value2) {
            //     DB::connection(self::DB_CONN_NAME)->table(self::T_TRJ_TUJUAN)
            //     ->insert([
            //         'trj_id' => $trjId,
            //         'keterangan' => $value2,
            //         'created_at' => $tgl,
            //         'created_by' => $nik_session
            //     ]);
            //     // Log::info([
            //     //     'trj_id' => $trjId,
            //     //     'keterangan' => $value2,
            //     //     'created_at' => $tgl,
            //     //     'created_by' => $nik_session
            //     // ]);
            // }
            // TODO : insert detail urgensi 
            // foreach ($listUrgensi as $value3) {
            //     DB::connection(self::DB_CONN_NAME)->table(self::T_TRJ_URGENSI)
            //     ->insert([
            //         'trj_id' => $trjId,
            //         'keterangan' => $value3,
            //         'created_at' => $tgl,
            //         'created_by' => $nik_session
            //     ]);
            //     // Log::info([
            //     //     'trj_id' => $trjId,
            //     //     'keterangan' => $value3,
            //     //     'created_at' => $tgl,
            //     //     'created_by' => $nik_session
            //     // ]);
            // }
            DB::connection(self::DB_CONN_NAME)->commit();
        } catch (Exception $ex) {
            DB::connection(self::DB_CONN_NAME)->rollBack();
            $errId = Str::uuid();
            $msg = 'Terjadi kesalahan ' . $errId . ' : ';
            Log::error('Error ' . $errId . ' : '. $ex->getMessage());
            Log::error($ex->getTraceAsString());
        }

        return response()->json([
            'isSuccess' => $isSuccess,
            'message' => $msg,
            'errorMessage' => $errMsg,
            'data' => $data
        ]);
    }

    public function JustifikasiApprove(Request $request) {
        $isSuccess = false;
        $msg = "";
        $errMsg = [];

        $approvalId = $request->input('approvalId');
        $status = $request->input('status');
        $trjId = $request->input('trjId');
        $keterangan = $request->input('keterangan');
        $tanggal = $request->input('tanggal');
        $tempat = $request->input('tempat');
        $listKomitmen = $request->input('listKomitmen', []);
        $listPengganti = $request->input('pengganti', []);
        $listTujuan = $request->input('tujuan', []);
        $listUrgensi = $request->input('urgensi', []);
        $nik_session = $request->session()->get('user_id', '');
        $currentApproval = [
            'id' => 0, 'NIK' => 0
        ];
        
        $tgl = now();
        // dd([
        //     'listKomitmen' => $listKomitmen,
        //     'approvalId' =>  $approvalId
        // ]);
        try {
            DB::connection(self::DB_CONN_NAME)->beginTransaction();
            
            $selectedApproval =  DB::connection(self::DB_CONN_NAME)->table(self::T_TRJ_APPROVAL . ' as tka')
                ->select('tapp.NIK', 'tapp.nama', 'tka.jenis', 'tka.approval_order', 'tka.status', 'tka.id', 'tapp.id as m_approval_id')
                ->leftJoin(self::T_JENIS_APPROVAL . ' as ja', 'tka.jenis', '=', 'ja.kode')
                ->leftJoin(self::T_TRAINING_APPROVAL . ' as tapp', 'tapp.id', '=', 'tka.m_training_approval_id')
                ->orderBy('ja.urutan')
                ->orderBy('tka.approval_order')
                ->where('tka.trj_id', $trjId)->get();
            // dd($selectedApproval);
            
            // $isLastApproval = false;
            
            $approvalIndex = 0;
            foreach($selectedApproval as $nilai) {
                $approvalIndex++;
                if($nilai->status == 0) {
                    $currentApproval['id'] = $nilai->id;
                    $currentApproval['NIK'] = $nilai->NIK;
                    $currentApproval['jenis'] = $nilai->jenis;
                    $currentApproval['approvalId'] = $nilai->m_approval_id;
                    break;
                }
            }
            $isDibuat = $currentApproval['jenis'] == 'dibuat';
            // Log::info(['length' => count($selectedApproval->toArray()), 'appr_index' => $approvalIndex, 'approval' => $selectedApproval]);
            // Log::info($currentApproval);

            if($nik_session != $currentApproval['NIK']) {
                $msg = 'Error Unauthorized request';
            } else {
                // $isLatestApproval = $selectedApproval->where('NIK', '=', $currentApproval['NIK'])->first();
                // Log::info([
                //     'latest' => $selectedApproval[count($selectedApproval)-1]->NIK,
                //     'current' => $isLatestApproval->NIK
                // ]);

                DB::connection(self::DB_CONN_NAME)->table(self::T_TRJ_APPROVAL)->where('m_training_approval_id', $approvalId)
                    ->where('trj_id', $trjId)
                    ->update([
                        'status' => $status,
                        'keterangan' => $keterangan,
                        'updated_at' => $tgl,
                        'updated_by' => $nik_session
                    ]);
                
                $listIdKomitmen = array_column(collect($listKomitmen)->where('status','=', 1)->toArray(), 'id');
                // dd($listIdKomitmen);
                // DB::connection(self::DB_CONN_NAME)->rollBack();
                $updateSql = DB::connection(self::DB_CONN_NAME)->table(self::T_KOMITMEN_APPROVAL)->whereIn('training_komitmen_id', $listIdKomitmen)
                    ->where('m_training_approval_id', $approvalId)
                    ->update([
                        'status' => $status,
                        'keterangan' => $keterangan,
                        'updated_at' => $tgl,
                        'updated_by' => $nik_session
                    ]);
            
                if($status == 1) {
                    if(count($selectedApproval->toArray()) == $approvalIndex) {
                    // if($isLatestApproval->NIK == $selectedApproval[count($selectedApproval)-1]->NIK) {
                        DB::connection(self::DB_CONN_NAME)->table(self::T_TRJ)->where('id', $trjId)
                        ->update([
                            'status' => 2,
                            // 'updated_at' => $tgl,
                            // 'updated_by' => $nik_session
                        ]);
                    }

                } else if($status == -1) {
                    DB::connection(self::DB_CONN_NAME)->table(self::T_TRJ)->where('id', $trjId)
                    ->update([
                        'status' => -2,
                        'keterangan' => $keterangan,
                        // 'updated_at' => $tgl,
                        // 'updated_by' => $nik_session
                    ]);
                }
                
                if($currentApproval['jenis'] == 'dibuat') {
                    foreach ($listKomitmen as $formKomitmen) {
                        if($formKomitmen['status'] == -2) {
                            DB::connection(self::DB_CONN_NAME)->table(self::T_TRAINING_KOMITMEN)
                                ->where('id', $formKomitmen['id'])
                                ->update([
                                    'is_deleted' => 1,
                                    'status' => $formKomitmen['status'],
                                    'keterangan' => $formKomitmen['keterangan'],
                                    'updated_at' => $tgl,
                                    'updated_by' => $nik_session
                                ]);
                            DB::connection(self::DB_CONN_NAME)->table(self::T_KOMITMEN_APPROVAL)->where('training_komitmen_id', $formKomitmen['id'])
                                ->where('m_training_approval_id', $approvalId)
                                ->update([
                                    'status' => $formKomitmen['status'],
                                    'keterangan' => $formKomitmen['keterangan'],
                                    'updated_at' => $tgl,
                                    'updated_by' => $nik_session
                                ]);
                        }
                    }
                }
                $isSuccess = true;
                $msg = 'Ok!';
            }
            
            DB::connection(self::DB_CONN_NAME)->commit();
        } catch (Exception $ex) {
            DB::connection(self::DB_CONN_NAME)->rollBack();
            $errID = Str::uuid();
            $msg = 'Error ' . $errID;
            Log::error('Error ' . $errID . ' : '. $ex->getMessage());
            Log::error($ex->getTraceAsString());
        }
        
        return response()->json([
            'isSuccess' => $isSuccess,
            'message' => $msg,
            'errorMessage' => $errMsg
        ]);
    }
}
