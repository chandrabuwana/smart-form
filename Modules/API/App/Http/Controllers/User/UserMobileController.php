<?php

namespace Modules\API\App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\VendorMaster;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class UserMobileController extends Controller {
    private const TABLE_REQ_MAKAN_MOBILE = "SCT_GS_CT_RQST_MB";
    private const TABLE_MASTER_MESS = "SCT_GS_MESS_MST";
    private const TABLE_PENGHUNI_MESS = "SCT_GS_MESS_HUNI";
    private const TABLE_SUBMIT_ORDER = "SCT_GS_CT_ORDER";
    private const TABLE_SUBMIT_ORDER_DETAIL = "SCT_GS_CT_ORDER_DTL";
    private const TABLE_ABSENSI_HRD = "HRD.dbo.TAbsensi";
    private const TABLE_KARYAWAN_HRD = "HRD.dbo.TKaryawan";
    private const TABLE_PENEGASAN_CUTI = "HRD.dbo.TPenegasanCuti";
    private const TABLE_PENGAJUAN_CUTI = "HRD.dbo.tpengajuancuti";
    private const TABLE_VENDOR_MASTER = 'SCT_GS_VENDOR_MST';
    private const DB_CONN_NAME = 'sqlsrv';
    private const WAKTU_PEMESANAN = [
        [
            'waktu' => 'siang',
            'start' => '03:00:00',
            'end' => '07:00:00'
        ],
        [
            'waktu' => 'malam',
            'start' => '12:00:00',
            'end' => '19:00:00'
        ]
    ];

    public function GetUser(Request $request) {
        // Log::debug("NIK : ".$nik);
        $nik_from_token = $request->get('nik_from_token');
        $waktu_order = $request->get('time');
        $isSuccess = false;
        $message = "";
        $errorMessage = [];
        $httpRespCode = 401;
        $data = null;
        $validator = Validator::make($request->all(), [
            'time' => 'required|regex:/^\d{2}:\d{2}:\d{2}$/',
        ],[
            'time.required' => 'Tanggal wajib diisi.',
            'time.regex' => 'Format time harus sesuai dengan format hh:mm:ss.'
        ]);

        if(count($validator->errors()) > 0) {

            $errorMessage = $validator->errors()->all();
        } else {
            $httpRespCode = 200;
            Log::info('waktu pemesanan : '.json_encode($this->getWaktuPemesanan($waktu_order), JSON_PRETTY_PRINT));
            try {
                $sql_data_user = DB::connection(self::DB_CONN_NAME)->table(self::TABLE_KARYAWAN_HRD.' as tk')
                    ->select('tk.NIK', 'tk.Nama', 'tk.KodeST', 'mm.NamaMess as Mess')
                    ->leftJoin(self::TABLE_PENGHUNI_MESS. ' as hn', 'tk.NIK', '=', 'hn.Nik')
                    ->leftJoin(self::TABLE_MASTER_MESS. ' as mm', 'hn.NoDoc', '=', 'mm.NoDoc')
                    ->where('tk.NIK', $nik_from_token);

                // Log::debug($sql_data_user->toRawSql());
                $data_user = $sql_data_user->first();
                // Log::debug(json_encode($data_user, JSON_PRETTY_PRINT));
                foreach($data_user as $key => $value) {
                    Log::info('key => '.$key. ', value => '. $value);
                    $data[$key] = $value;
                }
                $data['next_shift'] = $this->getWaktuPemesanan($waktu_order);

                $isSuccess = true;
                $message = 'Berhasil!';
            } catch (Exception $ex) {
                Log::error($ex->getMessage());
                Log::error($ex->getTraceAsString());

                $errorMessage = [
                    'Terjadi Kesalahan, coba beberapa saat lagi'
                ];
            }

        }


        return response()->json(
            [
                'isSuccess' => $isSuccess,
                'message' => $message,
                'errorMessage' => $errorMessage,
                'data' => $data
            ],
            $httpRespCode,
            [
                'X-CSRF-TOKEN' => csrf_token()
            ]
        );
    }

    private function getWaktuPemesanan($requestTime) {
        Log::info($requestTime);
        $inc = 0;
        $difference = 0;
        $waktuPesan = self::WAKTU_PEMESANAN[0];
        foreach (self::WAKTU_PEMESANAN as $waktu) {
            // Menggunakan DateTime untuk membandingkan waktu
            $startTime = DateTime::createFromFormat('H:i:s', $waktu['start']);
            $endTime = DateTime::createFromFormat('H:i:s', $waktu['end']);
            $request = DateTime::createFromFormat('H:i:s', $requestTime);

            if ($request >= $startTime && $request <= $endTime) {
                return $waktu;
            } else if ($request < $startTime){
                return $waktu;
            }
            $inc++;
        }

        return $waktuPesan; // Jika tidak ada waktu yang sesuai
    }

    public function GetUserVendor(Request $request) {
        $emailFromToken = $request->get('email_from_token');
        $user = DB::connection(self::DB_CONN_NAME)->table(self::TABLE_VENDOR_MASTER)
            ->where('Email', $emailFromToken)->first();

        $isSuccess = true;
        $message = 'Berhasil!';

        return response()->json(
            [
                'isSuccess' => $isSuccess,
                'message' => $message,
                'errorMessage' => '',
                'data' => $user
            ],
            200,
            [
                'X-CSRF-TOKEN' => csrf_token()
            ]
        );
    }

    public function UpdateFcmToken(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fcm_token'  => 'required',
            'apps'  => 'required',
        ]);

        $isSuccess = false;
        $message = '';
        $errorMessage = [];
        $data = null;

        if (count($validator->errors()->all()) > 0 ) {
            $message = 'Error request body validation';
            $errorMessage = $validator->errors()->all();

        } else {
            $isSuccess = true;
            $message = 'Berhasil!';
            $data = [];

            if($request->apps == 'vendor') {
                $emailFromToken = $request->get('email_from_token');
                VendorMaster::where('email', $emailFromToken)->update([
                    'notification_token' => $request->fcm_token,
                ]);
            }
        }

        return response()->json([
            'isSuccess' => $isSuccess,
            'message' => $message,
            'errorMessage' => $errorMessage,
            'data' => $data
        ],
        200,
        [
            'X-CSRF-TOKEN' => csrf_token()
        ]);
    }
}
