<?php

namespace Modules\API\App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class SettingsMobileController extends Controller
{
    private const TABLE_VENDOR_MASTER = 'SCT_GS_VENDOR_MST';
    private const DB_CONN_NAME = 'sqlsrv';

    public function UpdateAccount(Request $request) {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'kota' => 'required',
            'kecamatan' => 'required',
            'kelurahan' => 'required',
            'alamat' => 'required',
            'telepon' => 'required',
            'keterangan' => 'required',
        ], [
            'required' => 'Kolom :attribute wajib diisi.'
        ]);

        $httpRespCode = 401;
        $isSuccess = false;
        $message = "";
        $errorMessage = [];
        $data = null;

        if(count($validator->errors()) > 0) {
            $errorMessage = $validator->errors()->all();

        } else {
            $httpRespCode = 200;
            DB::beginTransaction();

            try {
                $payload = [
                    'Nama' => $request->input('nama'),
                    'Kota' => $request->input('kota'),
                    'Kecamatan' => $request->input('kecamatan'),
                    'Kelurahan' => $request->input('kelurahan'),
                    'Alamat' => $request->input('alamat'),
                    'Telepon' => $request->input('telepon'),
                    'Keterangan' => $request->input('keterangan'),
                ];

                $emailFromToken = $request->get('email_from_token');
                DB::connection(self::DB_CONN_NAME)->table(self::TABLE_VENDOR_MASTER)
                    ->where('Email', $emailFromToken)->update($payload);

                DB::commit();
                $data = $payload;
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

    public function UpdatePassword(Request $request) {
        $validator = Validator::make($request->all(), [
            'password_lama' => 'required',
            'password_baru' => 'required|min:5|max:15',
            'konfirmasi_password_baru' => 'required|same:password_baru',
        ], [
            'required' => 'Kolom :attribute wajib diisi.',
            'password_baru.min' => 'Password baru minimal berisi 5 karakter',
            'password_baru.max' => 'Password baru maksimal berisi 15 karakter',
            'konfirmasi_password_baru.same' => 'Konfirmasi password baru wajib sesuai dengan password baru',
        ]);

        $httpRespCode = 401;
        $isSuccess = false;
        $message = "";
        $errorMessage = [];
        $data = null;

        $emailFromToken = $request->get('email_from_token');
        $user = DB::connection(self::DB_CONN_NAME)->table(self::TABLE_VENDOR_MASTER)
            ->where('Email', $emailFromToken)->first();

        if(!Hash::check($request->password_lama, $user->pwd)) {
            $errorMessage[] = 'Password lama yang anda masukkan salah';

        } else if(count($validator->errors()) > 0) {
            $errorMessage = $validator->errors()->all();

        } else {
            $httpRespCode = 200;
            DB::beginTransaction();

            try {
                DB::connection(self::DB_CONN_NAME)->table(self::TABLE_VENDOR_MASTER)
                    ->where('Email', $emailFromToken)->update([ 'pwd' => Hash::make($request->password_baru) ]);

                DB::commit();
                $data = [];
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
}
