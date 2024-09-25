<?php

namespace Modules\API\App\Http\Controllers\Login;

use App\Http\Controllers\Controller;
use App\Models\VendorMaster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class MobileLoginController extends Controller {

    public function login(Request $request) {
        // Log::debug($request->all());

        $validator = Validator::make($request->all(), [
            'username'  => 'required',
            'password'  => 'required',
        ]);

        $isSuccess = false;
        $message = '';
        $errorMessage = [];
        $data = null;

        if (count($validator->errors()->all()) > 0 ) {
            $message = 'Error request body validation';
            $errorMessage = $validator->errors()->all();

        } else {
            if(!empty($request->apps) && $request->apps == 'vendor') {
                $payload = [
                    'Email' => $request->input('username'),
                    'pwd' => $request->input('password'),
                ];

                $user = VendorMaster::where('Email', $payload['Email'])->first();
                $token = null;

                if(!is_null($user) && Hash::check($payload['pwd'], $user->pwd)) {
                    if(!empty($request->fcm_token)) {
                        VendorMaster::where('Email', $payload['Email'])->update([
                           'notification_token' => $request->fcm_token
                        ]);
                    }

                    $token = auth()->guard('api_vendor')->login($user);
                }

            } else {
                $payload = [
                    'username' => $request->input('username'),
                    'password' => $request->input('password')
                ];
                $token = auth()->guard('api')->attempt($payload);
            }

            if (!$token) {

                $message = 'Username atau password tidak sesuai';
                $errorMessage = [
                    'Username atau password tidak sesuai'
                ];

            } else {

                $isSuccess = true;
                $message = 'Ok!';
                $data = [
                    'access_token' => $token,
                    'token_type' => 'bearer'
                ];

                // $data['token'] = $token;
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

    public function logout(Request $request) {
        auth()->guard('api')->logout();

        return response()->json([
            'isSuccess' => true,
            'message' => "Successfully logged out",
            'errorMessage' => [],
            'data' => null
        ]);
    }
}
