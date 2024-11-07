<?php

namespace Modules\SmartForm\App\Http\Controllers\GS;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class MessController extends Controller {
    private const DB_SMARTFORM = "PICA_BETA";
    private const DB_HRD = "HRD";
    private const TABLE_REQ_MAKAN_MOBILE = "SCT_GS_CT_RQST_MB";
    private const TABLE_MASTER_MESS = "SCT_GS_MESS_MST";
    private const TABLE_PENGHUNI_MESS = "SCT_GS_MESS_HUNI";
    private const TABLE_KAMAR_MESS = "SCT_GS_MESS_KAMAR";
    private const TABLE_SUBMIT_ORDER = "SCT_GS_CT_ORDER";
    private const TABLE_SUBMIT_ORDER_DETAIL = "SCT_GS_CT_ORDER_DTL";
    private const TABLE_ABSENSI_HRD = self::DB_HRD . ".dbo.TAbsensi";
    private const TABLE_KARYAWAN_HRD = self::DB_HRD . ".dbo.TKaryawan";
    private const TABLE_PENEGASAN_CUTI = self::DB_HRD . ".dbo.TPenegasanCuti";
    private const TABLE_PENGAJUAN_CUTI = self::DB_HRD . ".dbo.tpengajuancuti";
    private const DB_CONN_NAME = 'sqlsrv';
    
    function GetListMess(Request $request) {
        $kode_site = $request->query('kodeSite', '');
        $isSuccess = false;
        $message = '';
        $errorMessage = '';
        $data = null;
        $sort = $request->query('sort', 'NoDoc'); // Default sort by id
        $order = $request->query('order', 'asc'); // Default order is ascending
        $offset = $request->query('offset', 0); // Default offset
        $limit = $request->query('limit', null);
        $filterSite = $request->query('site', null); 

        try {
            $sql_data_mess = DB::connection(self::DB_CONN_NAME)->table(self::TABLE_MASTER_MESS)
                ->select('KodeSite as site', 'NoDoc as kode_mess', 'NamaMess as nama_mess', 'Status as status', 'JumlahKamar as jumlah_kamar', 'DayaTampung as daya_tampung', 'keterangan', 'Alamat as alamat')
                ->where('is_deleted', 0);
            $sql_data_mess->orderBy($sort, $order);
            Log::debug("SQL : ".$sql_data_mess->toRawSql());

            if($filterSite == null || $filterSite == 'null') {
            } else {
                $sql_data_mess->where('KodeSite', $filterSite);
            }

            $jml = $sql_data_mess->count();
            if($limit == null || $limit == 'null' || $limit == '') {
                $sql_data_mess->skip($offset);
            } else {
                $sql_data_mess->skip($offset)->limit($limit);
            }
            $data_mess = $sql_data_mess->get();

            $data = [
                'total' => $jml,
                'totalNotFiltered' => $jml,
                'rows' => $data_mess
            ];
            $isSuccess = true;
        } catch (Exception $ex) {
            $data['errorMessage'] = 'Terjadi kesalahan, coba beberapa saat lagi!';
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
        }

        return response()->json(
            [
                'isError' => $isSuccess,
                'message' => $message,
                'errorMessage' => '',
                'data' => $data
            ]
        );
    }

    function DashboardMess(Request $request) {
        return view('SmartForm::GS/dashboard-mess');
    }

    function AddMess(Request $request) {
        $isSuccess = false;
        $message = "";
        $errorMessage = "";
        $data = null;
        $nik_session = $request->session()->get('user_id', '');
        $validator = Validator::make(
            $request->all(), 
            [
                '_action' => ['required', Rule::in(['add', 'edit', 'delete'])], 
                'site' => ['required'], 
                'no_doc' => ['required'], 
                'nama_mess' => ['required'], 
                'status' => ['required', Rule::in([1, 0])], 
                'jumlah_kamar' => ['required'], 
                'alamat' => ['required'], 
            ],
            [
                '_action.in' => 'Invalid action',
                '_action.required' => 'Invalid action',
                'no_doc.required' => 'No Doc/Kode Mess wajib diisi.',
                'nama_mess.required' => 'Nama Mess wajib diisi.',
                'status.required' => 'Status wajib diisi.',
                'status.in' => 'Invalid Status.',
                'jumlah_kamar.required' => 'Jumlah kamar wajib diisi.',
                'alamat.required' => 'Alamat wajib diisi.',
            ]
        );

        if(count($validator->errors()->all()) > 0) {
            $message = 'Error validating request';
            $errorMessage = $validator->errors()->all();
        } else {
            try {
                DB::connection(self::DB_CONN_NAME)->beginTransaction();
                $_no_doc = $request->input("no_doc");
                $_action = $request->input("_action");

                $data_insert = array (
                    '_action' => $_action,
                    'NoDoc' => $request->input("no_doc"),
                    'KodeSite' => $request->input("site"),
                    'NamaMess' => $request->input("nama_mess"),
                    'Status' => $request->input("status"),
                    // 'DayaTampung' => (int) $request->input("daya_tampung"),
                    'JumlahKamar' => (int) $request->input('jumlah_kamar'),
                    'Alamat' => $request->input("alamat"),
                    'keterangan' => $request->input("keterangan"),
                );
                $data_kamar = $this->generateKamar($data_insert['JumlahKamar'], $data_insert['NoDoc'], $data_insert['KodeSite'], $nik_session);
                
                if($_action == 'add') {
                    Log::info('_action : '. json_encode($data_insert, JSON_PRETTY_PRINT));
                    unset($data_insert['_action']);
                    $data_insert['created_by'] = $nik_session;
                    $sql_insert_mess = DB::connection(self::DB_CONN_NAME)->table(self::TABLE_MASTER_MESS)->insert($data_insert);
                    foreach ($data_kamar as $kamar) {
                        DB::connection(self::DB_CONN_NAME)->table(self::TABLE_KAMAR_MESS)->insert($kamar);
                    }

                    $data['kode_mess'] = $data_insert['NoDoc'];
                    $message = "Berhasil menambahkan mess";
                }
                if($_action == 'edit') {
                    $data_insert['updated_by'] = $nik_session;
                    $data_insert['updated_at'] = now();
                    $data['kode_mess'] = $data_insert['NoDoc'];
    
                    unset($data_insert['NoDoc']);
                    unset($data_insert['_action']);
                    // Log::info($data_insert);
                    $sql_insert_mess = DB::connection(self::DB_CONN_NAME)->table(self::TABLE_MASTER_MESS)
                        ->where('NoDoc', $_no_doc)
                        ->update($data_insert);
                    $message = "Berhasil update mess";
                }
                if($_action == 'delete') {
                    
                    $sql_insert_mess = DB::connection(self::DB_CONN_NAME)->table(self::TABLE_MASTER_MESS)
                        ->where('NoDoc', $_no_doc)
                        ->update(['is_deleted' => 1, 'updated_by' => $nik_session, 'updated_at' => now()]);
                    Log::info($sql_insert_mess);
                    $message = "Berhasil Hapus mess";
                }
                DB::connection(self::DB_CONN_NAME)->commit();
                $isSuccess = true;
            } catch (Exception $ex) {
                $message = 'Terjadi kesalahan, coba beberapa saat lagi';
                $errorMessage = [$message];
                DB::connection(self::DB_CONN_NAME)->rollBack();
    
                Log::error($ex->getMessage());
                Log::error($ex->getTraceAsString());
            }
        }

        return response()->json([
            'isSuccess' => $isSuccess,
            'message' => $message,
            'errorMessage' => $errorMessage,
            'data' => $data
        ]);
    }

    function AddKamar(Request $request) {
        $isSuccess = false;
        $message = "";
        $errorMessage = "";
        $data = null;
        $nik_session = $request->session()->get('user_id', '');

        $validator = Validator::make(
            $request->all(), 
            [
                'site' => ['required'], 
                'kode_mess' => ['required'], 
                'kamar' => ['required'], 
                'kapasitas' => ['required'], 
            ],
            [
                'site.required' => 'Site wajib diisi',
                'kode_mess.required' => 'No Doc/Kode Mess wajib diisi.',
                'kamar.required' => 'Kamar wajib diisi.',
                'kapasitas.required' => 'Kapasitas wajib diisi.',
            ]
        );
        $reqValidateResult = $validator->errors()->all();

        if(count($reqValidateResult) > 0) {
            $errorMessage = $reqValidateResult;
            
        } else {
            $request_body = [
                'KodeSite' => $request->input('site'),
                'NoDoc' => $request->input('kode_mess'),
                'NoKamar' => $request->input('kamar'),
                'kapasitas' => $request->input('kapasitas'),
                'created_at' => now(),
                'created_by' => $nik_session
            ];

            try {
                DB::connection(self::DB_CONN_NAME)->beginTransaction();
                $kamarExistInMess = $this->isKamarExist($request_body['KodeSite'], $request_body['NoDoc'], $request_body['NoKamar']);
                
                if($kamarExistInMess) {
                    $message = "No Kamar sudah ada";
                } else {
                    DB::connection(self::DB_CONN_NAME)->table(self::TABLE_KAMAR_MESS)
                        ->insert($request_body);
                    $this->addJumlahKamarMess($request_body['KodeSite'], $request_body['NoDoc']);

                    DB::connection(self::DB_CONN_NAME)->commit();

                    $message = "Berhasil tambah kamar";
                    $isSuccess = true;
                    $data = $request_body;
                }
                

            } catch (Exception $ex) {
                $message = "Terjadi kesalahan, coba beberapa saat lagi";
                $errorMessage = [$message];

                DB::rollBack();
                Log::error($ex->getMessage());
                Log::error($ex->getTraceAsString());
            }

        }
        
        return response()->json([
            'isSuccess' => $isSuccess,
            'message' => $message,
            'errorMessage' => $errorMessage,
            'data' => $data
        ]);
    }

    function EditKamar(Request $request) {
        $isSuccess = false;
        $message = "";
        $errorMessage = "";
        $data = null;
        $nik_session = $request->session()->get('user_id', '');

        $validator = Validator::make(
            $request->all(), 
            [
                'site' => ['required'], 
                'kode_mess' => ['required'], 
                'kamar' => ['required'], 
                'edited_kamar' => ['required'], 
            ],
            [
                'site.required' => 'Site wajib diisi',
                'kode_mess.required' => 'No Doc/Kode Mess wajib diisi.',
                'kamar.required' => 'Kamar wajib diisi.',
                'edited_kamar.required' => 'Edit Kamar wajib diisi.',
            ]
        );
        $reqValidateResult = $validator->errors()->all();

        if(count($reqValidateResult) > 0) {
            $errorMessage = $reqValidateResult;
            
        } else {
            $site = $request->input('site');
            $mess = $request->input('kode_mess');
            $kamar = $request->input('kamar');
            $kapasitas = $request->input('kapasitas');

            $request_body = [
                'NoKamar' => $request->input('edited_kamar'),
                'kapasitas' => $request->input('kapasitas'),
                'updated_at' => now(),
                'updated_by' => $nik_session,
            ];

            try {
                DB::connection(self::DB_CONN_NAME)->beginTransaction();
                $kamarExistInMess = $this->isKamarExist($site, $mess, $kamar);
                
                if(!$kamarExistInMess) {
                    $message = "No Kamar Tidak ada";
                    
                } else {
                    DB::connection(self::DB_CONN_NAME)->table(self::TABLE_KAMAR_MESS)
                        ->where([
                            ['KodeSite', '=', $site],
                            ['NoDoc', '=', $mess],
                            ['NoKamar', '=', $kamar]
                        ])
                        ->update($request_body);

                    DB::connection(self::DB_CONN_NAME)->commit();

                    $message = "Berhasil edit kamar";
                    $isSuccess = true;
                    $data = $request_body;
                }
                

            } catch (Exception $ex) {
                $message = "Terjadi kesalahan, coba beberapa saat lagi";
                $errorMessage = [$message];

                DB::rollBack();
                Log::error($ex->getMessage());
                Log::error($ex->getTraceAsString());
            }

        }
        
        return response()->json([
            'isSuccess' => $isSuccess,
            'message' => $message,
            'errorMessage' => $errorMessage,
            'data' => $data
        ]);
    }

    function DeleteKamar(Request $request) {
        $isSuccess = false;
        $message = "";
        $errorMessage = "";
        $data = null;
        $nik_session = $request->session()->get('user_id', '');
        $validator = Validator::make(
            $request->all(), 
            [
                '_action' => ['required', Rule::in(['delete'])], 
                'site' => ['required'], 
                'no_doc' => ['required'], 
                'kamar' => ['required'],
            ],
            [
                '_action.in' => 'Invalid action',
                '_action.required' => 'Invalid action',
                'site.required' => 'Site Mess wajib diisi.',
                'kamar.required' => 'Kamar wajib diisi.',
                'no_doc.required' => 'No Doc/Kode Mess wajib diisi.',
            ]
        );

        if(count($validator->errors()->all()) > 0) {
            $message = 'Error validating request';
            $errorMessage = $validator->errors()->all();
        } else {
            $site = $request->input('site');
            $no_doc = $request->input('no_doc');
            $kamar = $request->input('kamar');
            $tgl = now();
            Log::debug(json_encode([$site, $no_doc, $kamar]));
            try {
                $sql_soft_delete = DB::connection(self::DB_CONN_NAME)->table(self::TABLE_KAMAR_MESS)
                    ->where('KodeSite', $site)
                    ->where('NoDoc', $no_doc)
                    ->where('NoKamar', $kamar)
                    ->update(['is_deleted' => 1, 'updated_by' => $nik_session, 'updated_at' => $tgl]);
                Log::info($sql_soft_delete);
                $message = 'Berhasil hapus data!';
                $isSuccess = true;
            } catch (Exception $ex) {
                $message = 'Terjadi kesalahan, coba beberapa saat lagi';
                $errorMessage = [$message];

                Log::error($ex->getMessage());
                Log::error($ex->getTraceAsString());
            }
        }

        return response()->json([
            'isSuccess' => $isSuccess,
            'message' => $message,
            'errorMessage' => $errorMessage,
            'data' => $data
        ]);
    }

    function AddPenghuniMess(Request $request) {
        $isSuccess = false;
        $message = "";
        $errorMessage = "";
        $data = null;
        $nik_session = $request->session()->get('user_id', '');
        $validator = Validator::make(
            $request->all(), 
            [
                'site' => ['required'], 
                'kode_mess' => ['required'], 
                'kamar' => ['required'],
                'nik' => ['required']
            ],
            [
                'site.required' => 'Site Mess wajib diisi.',
                'kamar.required' => 'Kamar wajib diisi.',
                'kode_mess.required' => 'Mess wajib diisi.',
                'nik.required' => 'NIK wajib diisi.',
            ]
        );
        if(count($validator->errors()->all()) > 0) {
            $message = 'Error validating request';
            $errorMessage = $validator->errors()->all();
        } else {
            $site = $request->input('site');
            $kode_mess = $request->input('kode_mess');
            $kamar = $request->input('kamar');
            $nik = $request->input('nik');
            $tgl = now();

            try {
                $isNikAlreadyInMess = DB::connection(self::DB_CONN_NAME)->table(self::TABLE_PENGHUNI_MESS)->where('nik', $nik)->exists();
                if($isNikAlreadyInMess) {
                    $message = "NIK sudah ada di Mess";
                    $errorMessage = [$message];
                } else {
                    $kamar_terisi = $this->checkKapasitasKamar($site, $kode_mess, $kamar);
                    Log::debug('SQL check kapasitas kamar : '. json_encode($kamar_terisi));
                    
                    if($kamar_terisi['terisi'] < $kamar_terisi['kapasitas']) {
                        DB::connection(self::DB_CONN_NAME)->table(self::TABLE_PENGHUNI_MESS)
                            ->insert(
                                ['KodeSite' => $site, 'NoDoc' => $kode_mess, 'NoKamar' => $kamar, 'nik' => $nik, 'created_at' => $tgl, 'created_by' => $nik_session],
                            );
                        $message = "Berhasil";
                        $isSuccess = true;
                    } else {
                        $message = "Kamar ". $kamar . " sudah penuh";
                        $errorMessage = [$message];
                    }
                    Log::info(json_encode($kamar_terisi));
                    
                }
            } catch (Exception $ex) {
                $message = "Terjadi kesalahan, coba beberapa saat lagi";
                $errorMessage = [$message];

                Log::error($ex->getMessage());
                log::error($ex->getTraceAsString());
            }
        }
        
        return response()->json([
            'isSuccess' => $isSuccess,
            'message' => $message,
            'errorMessage' => $errorMessage,
            'data' => $data
        ]);
    }

    function EditPenghuniMess(Request $request) {
        $isSuccess = false;
        $message = "";
        $errorMessage = "";
        $data = null;
        $nik_session = $request->session()->get('user_id', '');
        $validator = Validator::make(
            $request->all(), 
            [
                'site' => ['required'], 
                'kode_mess' => ['required'], 
                'kamar' => ['required'],
                'nik' => ['required']
            ],
            [
                'site.required' => 'Site Mess wajib diisi.',
                'kamar.required' => 'Kamar wajib diisi.',
                'kode_mess.required' => 'Mess wajib diisi.',
                'nik.required' => 'NIK wajib diisi.',
            ]
        );

        if(count($validator->errors()->all()) > 0) {
            $message = 'Error validating request';
            $errorMessage = $validator->errors()->all();
        } else {
            $site = $request->input('site');
            $kode_mess = $request->input('kode_mess');
            $kamar = $request->input('kamar');
            $nik = $request->input('nik');
            $tgl = now();

            try {
                $isNikAlreadyInMess = DB::connection(self::DB_CONN_NAME)->table(self::TABLE_PENGHUNI_MESS)->where('nik', $nik)->exists();
                if(!$isNikAlreadyInMess) {
                    $message = "NIK belum terdaftar di Mess";
                    $errorMessage = [$message];
                } else {
                    $kamar_terisi = $this->checkKapasitasKamar($site, $kode_mess, $kamar);
                    Log::debug('SQL check kapasitas kamar : '. json_encode($kamar_terisi));
                    
                    if($kamar_terisi['terisi'] < $kamar_terisi['kapasitas']) {
                        DB::connection(self::DB_CONN_NAME)->table(self::TABLE_PENGHUNI_MESS)
                            ->where('nik', $nik)
                            ->update(
                                ['KodeSite' => $site, 'NoDoc' => $kode_mess, 'NoKamar' => $kamar, 'nik' => $nik, 'updated_at' => $tgl, 'updated_by' => $nik_session],
                            );

                        $message = "Berhasil";
                        $isSuccess = true;
                    } else {
                        $message = "Kamar ". $kamar . " sudah penuh";
                        $errorMessage = [$message];
                    }
                    Log::info(json_encode($kamar_terisi));
                    
                }
            } catch (Exception $ex) {
                $message = "Terjadi kesalahan, coba beberapa saat lagi";
                $errorMessage = [$message];

                Log::error($ex->getMessage());
                Log::error($ex->getTraceAsString());
            }
        }

        return response()->json([
            'isSuccess' => $isSuccess,
            'message' => $message,
            'errorMessage' => $errorMessage,
            'data' => $data
        ]);
    }

    function DeletePenghuniMess(Request $request) {
        $isSuccess = false;
        $message = "";
        $errorMessage = "";
        $data = null;
        $nik_session = $request->session()->get('user_id', '');
        $validator = Validator::make(
            $request->all(), 
            [
                '_action' => ['required', Rule::in(['delete'])], 
                'site' => ['required'], 
                'no_doc' => ['required'], 
                'kamar' => ['required'],
                'nik_penghuni' => ['required']
            ],
            [
                '_action.in' => 'Invalid action',
                '_action.required' => 'Invalid action',
                'site.required' => 'Site Mess wajib diisi.',
                'kamar.required' => 'Kamar wajib diisi.',
                'no_doc.required' => 'No Doc/Kode Mess wajib diisi.',
                'nik_penghuni.required' => 'NIK Penghuni wajib diisi.',
            ]
        );

        if(count($validator->errors()->all()) > 0) {
            $message = 'Error validating request';
            $errorMessage = $validator->errors()->all();
        } else {
            $site = $request->input('site');
            $no_doc = $request->input('no_doc');
            $kamar = $request->input('kamar');
            $nik_penghuni = $request->input('nik_penghuni');
            $tgl = now();
            Log::debug(json_encode([$site, $no_doc, $kamar, $nik_penghuni]));
            try {
                $sql_soft_delete = DB::connection(self::DB_CONN_NAME)->table(self::TABLE_PENGHUNI_MESS)
                    ->where('KodeSite', $site)
                    ->where('NoDoc', $no_doc)
                    ->where('NoKamar', $kamar)
                    ->where('Nik', $nik_penghuni)
                    ->delete();
                    // ->update(['is_deleted' => 1, 'updated_by' => $nik_session, 'updated_at' => $tgl]);
                Log::info($sql_soft_delete);
                $message = 'Berhasil hapus data!';
                $isSuccess = true;
            } catch (Exception $ex) {
                $message = 'Terjadi kesalahan, coba beberapa saat lagi';
                $errorMessage = [$message];

                Log::error($ex->getMessage());
                Log::error($ex->getTraceAsString());
            }
        }

        return response()->json([
            'isSuccess' => $isSuccess,
            'message' => $message,
            'errorMessage' => $errorMessage,
            'data' => $data
        ]);
    }

    function DashboardHuni(Request $request) {
        return view('SmartForm::GS/dashboard-huni-mess');
    }

    function DashboardKamar(Request $request) {
        return view('SmartForm::GS/dashboard-kamar');
    }

    function GetListHuni(Request $request) {
        $no_doc = $request->query('kode_mess', '');
        $site = $request->query('site', '');
        $mess = $request->query('mess', '');
        $kamar = $request->query('kamar', '');
        
        $isSuccess = false;
        $message = '';
        $errorMessage = '';
        $data = null;
        $sort = $request->query('sort', 'NoDoc'); // Default sort by id
        $order = $request->query('order', 'asc'); // Default order is ascending
        $offset = $request->query('offset', 0); // Default offset
        $limit = $request->query('limit', null);

        try {
            $sql_data_mess = DB::connection(self::DB_CONN_NAME)->table(self::TABLE_PENGHUNI_MESS . ' as a')
                ->select('a.KodeSite as site', 'a.Nik as nik', 'a.status', 'a.keterangan', 'b.NamaMess as nama_mess', 'a.NoDoc as kode_mess', 'a.NoKamar as no_kamar', 'c.nama')
                ->leftJoin(self::TABLE_MASTER_MESS.' as b', 'a.NoDoc', '=', 'b.NoDoc')
                ->leftJoin(self::TABLE_KARYAWAN_HRD. ' as c', 'a.Nik', '=', 'c.nik')
                ->orderByDesc('a.created_at')
                ->where('a.NoDoc', $mess)
                ->where('a.KodeSite', $site)
                ->where('a.NoKamar', $kamar)
                ->where(function($query) {
                    $query->whereNull('a.is_deleted')
                        ->orWhere('a.is_deleted', 0);
                })
                ->where(function($query) {
                    $query->whereNull('b.is_deleted')
                        ->orWhere('b.is_deleted', 0);
                });
                
            Log::debug("SQL : ".$sql_data_mess->toRawSql());
            $jml = $sql_data_mess->count();
            $data_mess = $sql_data_mess->get();

            $data = [
                'total' => $jml,
                'totalNotFiltered' => $jml,
                'rows' => $data_mess
            ];

            $isSuccess = true;
        } catch (Exception $ex) {
            $data['errorMessage'] = 'Terjadi kesalahan, coba beberapa saat lagi!';
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
        }

        return response()->json(
            [
                'isError' => $isSuccess,
                'message' => $message,
                'errorMessage' => '',
                'data' => $data
            ]
        );
    }

    function GetListKamar(Request $request) {
        $no_doc = $request->query('kode_mess', '');
        $site = $request->query('site', '');
        $mess = $request->query('mess', '');
        
        $isSuccess = false;
        $message = '';
        $errorMessage = '';
        $data = null;
        $sort = $request->query('sort', 'NoDoc'); // Default sort by id
        $order = $request->query('order', 'asc'); // Default order is ascending
        $offset = $request->query('offset', 0); // Default offset
        $limit = $request->query('limit', null);

        $new_data_mess = [];

        try {
            $sql_data_mess = DB::connection(self::DB_CONN_NAME)->table(self::TABLE_KAMAR_MESS . ' as a')
                ->select('a.KodeSite as site', 'a.NoDoc as kode_mess', 'a.NoKamar as no_kamar', 'b.NamaMess as nama_mess', 'a.kapasitas')
                ->leftJoin(self::TABLE_MASTER_MESS.' as b', 'a.NoDoc', '=', 'b.NoDoc')
                ->where('a.NoDoc', $mess)
                ->where('a.KodeSite', $site)
                ->where('a.is_deleted', 0);

            $sql_jumlah_kamar_terisi = DB::connection(self::DB_CONN_NAME)->table(self::TABLE_KAMAR_MESS.' as a')
                ->join(self::TABLE_PENGHUNI_MESS.' as b', function($join) {
                    $join->on('a.NoDoc', '=', 'b.NoDoc')
                        ->on('a.NoKamar', '=', 'b.NoKamar');
                })
                ->select('a.KodeSite', 'a.NoDoc', 'a.NoKamar', DB::raw('COUNT(a.NoKamar) as terisi'), 'a.kapasitas')
                ->where('a.NoDoc', $mess)
                ->where('a.is_deleted', 0)
                ->groupBy('a.NoKamar', 'a.KodeSite', 'a.NoDoc', 'a.kapasitas');
            
                
            Log::debug("SQL : ".$sql_jumlah_kamar_terisi->toRawSql());
            Log::debug("SQL : ".$sql_data_mess->toRawSql());
            $jml = $sql_data_mess->count();
            $data_mess = $sql_data_mess->get();
            $kamar_terisi = [];
            foreach($sql_jumlah_kamar_terisi->get() as $result) {
                $kamar_terisi[$result->NoKamar] = (int) $result->terisi;
            }

            foreach($data_mess as $data_looped) {
                $temp_looped = [
                    'site' => $data_looped->site,
                    'kode_mess' => $data_looped->kode_mess,
                    'no_kamar' => $data_looped->no_kamar,
                    'nama_mess' => $data_looped->nama_mess,
                    'kapasitas' => (int) $data_looped->kapasitas,
                    'terisi' => 0
                ];
                if(array_key_exists($data_looped->no_kamar, $kamar_terisi)) {
                    $temp_looped['terisi'] = $kamar_terisi[$data_looped->no_kamar];
                }
                array_push($new_data_mess, $temp_looped);
            }

            $data = [
                'total' => $jml,
                'totalNotFiltered' => $jml,
                'rows' => $new_data_mess
            ];

            $isSuccess = true;
        } catch (Exception $ex) {
            $data['errorMessage'] = 'Terjadi kesalahan, coba beberapa saat lagi!';
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
        }

        return response()->json(
            [
                'isError' => $isSuccess,
                'message' => $message,
                'errorMessage' => '',
                'data' => $data
            ]
        );
    }

    private function generateKamar(int $jumlahKamar, string $noDoc, string $site, string $nik) {
        $data = [];
        $tgl = now();
        for($i=0;$i<$jumlahKamar;$i++) {
            array_push($data, [
                'KodeSite' => $site,
                'NoDoc' => $noDoc,
                'NoKamar' => $i+1,
                'kapasitas' => 0,
                'created_by' => $nik,
                'created_at' => $tgl
            ]);
        }

        Log::info("Jumlah kamar : ". json_encode($data, JSON_PRETTY_PRINT));

        return $data;
    }

    function HelperMess(Request $request) {
        $kode_site = $request->query("site");

        $data_mess = DB::connection(self::DB_CONN_NAME)->table(self::TABLE_MASTER_MESS)
            ->select('NoDoc as id', 'NamaMess as text')
            ->where('KodeSite', $kode_site)
            ->where('status', 0);
        Log::debug('SQL : '. $data_mess->toRawSql());

        return response()->json(['data' => $data_mess->get()->toArray()]);
    }

    function HelperKamar(Request $request) {
        $kode_site = $request->query("site");
        $mess = $request->query("mess");

        $data = [

        ];

        $data_kamar = DB::connection(self::DB_CONN_NAME)->table(self::TABLE_KAMAR_MESS)
            ->select('NoKamar as id')
            ->where('KodeSite', $kode_site)
            ->where('NoDoc', $mess);
        Log::debug('SQL : '. $data_kamar->toRawSql());
        
        foreach($data_kamar->get()->toArray() as $kamar) {
            // $data['id'] = $kamar->id;
            // $data['text'] = 'Kamar '. $kamar->id;
            array_push($data, [
                'id' => $kamar->id,
                'text' => 'Kamar '. $kamar->id
            ]);
        }

        return response()->json(['data' => $data]);

    }

    private function isKamarExist($site, $mess, $kamar): bool {
        $isExist = true;

        try {
            $isExist = DB::connection(self::DB_CONN_NAME)->table(self::TABLE_KAMAR_MESS)
                ->where('KodeSite', $site)
                ->where('NoDoc', $mess)
                ->where('NoKamar', $kamar)
                ->exists();
            Log::debug($kamar);
        } catch (Exception $ex) {

            Log::info($ex->getMessage());
            Log::info($ex->getTraceAsString());
        }

        return $isExist;
    }

    private function addJumlahKamarMess($site, $mess): bool {
        $isSuccess = false;

        try {
            DB::connection(self::DB_CONN_NAME)->table(self::TABLE_MASTER_MESS)
                ->where(['KodeSite' => $site, 'NoDoc' => $mess])
                ->increment('JumlahKamar');
            $isSuccess = true;
            
        } catch (Exception $ex) {

            Log::info($ex->getMessage());
            Log::info($ex->getTraceAsString());
        }

        return $isSuccess;
    }

    private function checkKapasitasKamar($site, $mess, $kamar) {
        Log::debug("Kamar : ". $kamar);
        $new_data_mess = [];

        $sql_data_mess = DB::connection(self::DB_CONN_NAME)->table(self::TABLE_KAMAR_MESS . ' as a')
                ->select('a.KodeSite as site', 'a.NoDoc as kode_mess', 'a.NoKamar as no_kamar', 'b.NamaMess as nama_mess', 'a.kapasitas')
                ->leftJoin(self::TABLE_MASTER_MESS.' as b', 'a.NoDoc', '=', 'b.NoDoc')
                ->where('a.NoDoc', $mess)
                ->where('a.KodeSite', $site)
                ->where('a.NoKamar', $kamar)
                ->where('a.is_deleted', 0);
        
        $sql_jumlah_kamar_terisi = DB::connection(self::DB_CONN_NAME)->table(self::TABLE_KAMAR_MESS.' as a')
            ->join(self::TABLE_PENGHUNI_MESS.' as b', function($join) {
                $join->on('a.NoDoc', '=', 'b.NoDoc')
                    ->on('a.NoKamar', '=', 'b.NoKamar');
            })
            ->select('a.KodeSite', 'a.NoDoc', 'a.NoKamar', DB::raw('COUNT(a.NoKamar) as terisi'))
            ->where('a.NoDoc', $mess)
            ->where('a.is_deleted', 0)
            ->where('a.NoKamar', $kamar)
            ->groupBy('a.NoKamar', 'a.KodeSite', 'a.NoDoc');
        
            
        Log::debug("SQL  : ".$sql_jumlah_kamar_terisi->toRawSql());
        Log::debug("SQL : ".$sql_data_mess->toRawSql());
        $jml = $sql_data_mess->count();
        $data_mess = $sql_data_mess->first();
        $kamar_terisi = [];
        $jumlah_kamar_terisi = $sql_jumlah_kamar_terisi->first();
        Log::debug(json_encode($jumlah_kamar_terisi));
        if($jumlah_kamar_terisi) $kamar_terisi[$jumlah_kamar_terisi->NoKamar] = (int) $jumlah_kamar_terisi->terisi;

            $new_data_mess = [
                'site' => $data_mess->site,
                'kode_mess' => $data_mess->kode_mess,
                'no_kamar' => $data_mess->no_kamar,
                'nama_mess' => $data_mess->nama_mess,
                'kapasitas' => (int) $data_mess->kapasitas,
                'terisi' => 0
            ];
            if(array_key_exists($data_mess->no_kamar, $kamar_terisi)) {
                $new_data_mess['terisi'] = $kamar_terisi[$data_mess->no_kamar];
            }

        return $new_data_mess;
    }
}

// query kapasitas mess berdasarkan kapasitas kamar
// select a.NoDoc, sum(b.kapasitas) as capacity
// 	from [PICA_BETA].[dbo].[SCT_GS_MESS_MST] as a
// 	left join [PICA_BETA].[dbo].[SCT_GS_MESS_KAMAR] as b
// 	on a.NoDoc=b.NoDoc
// 	group by a.NoDoc
// 	order by a.[NoDoc] asc 