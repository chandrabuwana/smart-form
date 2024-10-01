<?php

namespace Modules\API\App\Http\Controllers\Login;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CateringController extends Controller {
    private const DB_SMARTFORM = "PICA_BETA";
    private const DB_HRD = "HRD";
    private const TABLE_REQ_MAKAN_MOBILE = "SCT_GS_CT_RQST_MB";
    private const TABLE_MASTER_MESS = "SCT_GS_MESS_MST";
    private const TABLE_PENGHUNI_MESS = "SCT_GS_MESS_HUNI";
    private const TABLE_SUBMIT_ORDER = "SCT_GS_CT_ORDER";
    private const TABLE_SUBMIT_ORDER_DETAIL = "SCT_GS_CT_ORDER_DTL";
    private const TABLE_REQUEST_MAKAN_MOBILE = "SCT_GS_CT_RQST_MB";
    private const TABLE_ABSENSI_HRD = self::DB_HRD . ".dbo.TAbsensi";
    private const TABLE_KARYAWAN_HRD = self::DB_HRD . ".dbo.TKaryawan";
    private const TABLE_PENEGASAN_CUTI = self::DB_HRD . ".dbo.TPenegasanCuti";
    private const TABLE_PENGAJUAN_CUTI = self::DB_HRD . ".dbo.tpengajuancuti";
    private const DB_CONN_NAME = 'sqlsrv';

    public function history(Request $request) {
        $isSuccess = false;
        $message = '';
        $errorMessage = [];
        $data = null;
        $nik = $request->get('nik_from_token');

        try {
                $sql_select_history = DB::connection(self::DB_CONN_NAME)->table(self::TABLE_REQUEST_MAKAN_MOBILE)
                    ->select('NIK as nik', 'Nama as nama', 'TanggalOrder as tanggal', 'Jam as jam', 'jenis')
                    ->where('nik', $nik)
                    ->orderByDesc('tanggal')
                    ->orderByDesc('jam');

                Log::info('SQL : '. $sql_select_history->toRawSql());
    
                $history_request = $sql_select_history->get();
                $message = count($history_request) > 0 ? 'Ok!' : 'Empty Data!';
                $isSuccess = true;
                $data = $history_request->toArray();
                // Log::info('Result : '. json_encode($history_request, JSON_PRETTY_PRINT));
            
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
        }

        return response()->json(
            [
                'isSuccess' => $isSuccess,
                'message' => $message, 
                'errorMessage' => $errorMessage,
                'data' => $data
            ]
        );
    }

    public function RequestOrder(Request $request) {
        $isSuccess = false;
        $message = '';
        $errorMessage = [];
        $data = null;

        $validator = Validator::make($request->all(), [
            'jenis' => ['required', Rule::in(['siang', 'malam'])], 
        ],[
            'jenis.in' => 'NIK shift harus salah satu dari: siang, malam.',
            'jenis.required' => 'Jenis wajib diisi.',
        ]);

        $validation_errors = $validator->errors();

        if(count($validation_errors) > 0) {
            $errorMessage = $validation_errors->all();
        } else {
            $nama = $request->input(key: 'nama');
            $nik = $request->get('nik_from_token');
            $jenis = $request->input(key: 'jenis');
            // $tanggal = $request->input(key: 'tanggal');
            $tanggal = date('Y-m-d', time());
            $jam = date('H:i:s', time());
            $mess = $this->get_mess_karyawan($nik);
            if($mess == '') {
                $errorMessage = [
                    'NIK bukan penguni mess'
                ];
            } else {
                $is_already_ordered = $this->check_already_ordered($nik, $jenis, $tanggal);
                    
                if($is_already_ordered) {
                    $message = 'Anda sudah request makan!';
                    $errorMessage = [$message];
                } else {
                    $data_input = new MobileRequestOrder($nama, $nik, $mess, $tanggal, $jam, $jenis);
                    $status_insert_db = $this->insert_request_order($data_input);
                    if($status_insert_db) {
                        $isSuccess = true;
                        $message = 'Berhasil Order Makan!';
    
                    } else {
                        $errorMessage = [
                            'Terjadi kesalahan, Coba beberapa saat lagi'
                        ];
                    }
                }

            }
            
        }
        
        return response()->json(
            [
                'isSuccess' => $isSuccess,
                'message' => $message, 
                'errorMessage' => $errorMessage,
                'data' => $data
            ]
        );
    }

    private function insert_request_order(MobileRequestOrder $mobileRequestOrder): bool {
        
        $isSuccess = false;

        try {
            DB::connection(self::DB_CONN_NAME)->beginTransaction();

            $sql_insert_order_mobile = DB::connection(self::DB_CONN_NAME)->table(self::TABLE_REQUEST_MAKAN_MOBILE)
                ->insert(
                    [
                        'Nama' => $mobileRequestOrder->nama,
                        'NIK' => $mobileRequestOrder->nik,
                        'lokasi' => $mobileRequestOrder->lokasi,
                        'TanggalOrder' => $mobileRequestOrder->tanggal,
                        'Jam' => $mobileRequestOrder->jam,
                        'jenis' => $mobileRequestOrder->jenis,
                        'created_at' => Carbon::now(),
                        'created_by' => $mobileRequestOrder->nik
                    ]
                );
            DB::connection(self::DB_CONN_NAME)->commit();
            $isSuccess = true;
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());

            DB::connection(self::DB_CONN_NAME)->rollBack();
        }
        return $isSuccess;
    }

    private function get_mess_karyawan(string $nik): string {
        $mess = "";
        try {
            $result = DB::connection(self::DB_CONN_NAME)->table(self::TABLE_PENGHUNI_MESS.' as hn')
                ->select('hn.NoDoc as mess')
                // ->leftJoin(self::TABLE_MASTER_MESS. ' as mm', 'hn.NoDoc', '=', 'mm.NoDoc')
                ->where('Nik', $nik)
                ->first();
            // Log::info(json_encode($result->mess));
            $mess = $result == null ? '' : $result->mess;
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
        }

        return $mess;
    }

    private function check_already_ordered(string $nik, string $jenis, $tgl): bool {
        $is_already_ordered = true;

        try {
            $sql_check_order = DB::connection(self::DB_CONN_NAME)->table(self::TABLE_REQUEST_MAKAN_MOBILE)
                ->where('nik', $nik)
                ->where('jenis', $jenis)
                ->whereDate('TanggalOrder', $tgl);
            Log::info('SQl : '. $sql_check_order->toRawSql());
            $is_already_ordered = $sql_check_order->exists();
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
        }
        
        return $is_already_ordered;
    }
}

class MobileRequestOrder {
    public $nama;
    public $nik;
    public $lokasi;
    public $tanggal;
    public $jam;
    public $jenis;

    function __construct($nama, $nik, $lokasi, $tanggal, $jam, $jenis) {
        $this->nama = $nama;
        $this->nik = $nik;
        $this->lokasi = $lokasi;
        $this->tanggal = $tanggal;
        $this->jam = $jam;
        $this->jenis = $jenis;
    }

    public static function fromJson(array $json): MobileRequestOrder {
        $nama = array_key_exists('nama', $json) ? $json['nama'] : '';
        $nik = array_key_exists('nik', $json) ? $json['nik'] : '';
        $lokasi = array_key_exists('lokasi', $json) ? $json['lokasi'] : '';
        $tanggal = array_key_exists('tanggal', $json) ? $json['tanggal'] : '';
        $jam = array_key_exists('jam', $json) ? $json['jam'] : '';
        $jenis = array_key_exists('jenis', $json) ? $json['jenis'] : '';

        return new MobileRequestOrder(nama: $nama, nik: $nik, lokasi: $lokasi, tanggal: $tanggal, jam: $jam, jenis: $jenis);
    } 

    
}