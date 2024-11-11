<?php

namespace App;

use DateTime;
use Exception;
use Google_Client;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class Helper
{
    public static function isGrantPermission(string $username, string $moduleName)
    {
        // spesific action
        // $username = session('user_id');
        // return DB::table('users')->select('MS_ROLE_PERMISSION.id')
        //     ->join('MS_ROLE', 'MS_ROLE.role_code', '=', 'users.role')
        //     ->join('MS_ROLE_PERMISSION', 'MS_ROLE_PERMISSION.role_id', '=', 'MS_ROLE.id')
        //     ->join('MS_PERMISSION_MODULE', 'MS_PERMISSION_MODULE.id', 'MS_ROLE_PERMISSION.permission_module_id')
        //     ->where('users.username', $username)
        //     ->where( function($q) use($moduleSlug) {
        //         if(is_array($moduleSlug)) {
        //             $q->whereIn('MS_PERMISSION_MODULE.module_slug', $moduleSlug);
        //         } else {
        //             $q->where('MS_PERMISSION_MODULE.module_slug', $moduleSlug);
        //         }

        //     })->count() > 0;

        return DB::table('users')->select('MS_ROLE_PERMISSION.id')
            ->join('MS_ROLE', 'MS_ROLE.role_code', '=', 'users.role')
            ->join('MS_ROLE_PERMISSION', 'MS_ROLE_PERMISSION.role_id', '=', 'MS_ROLE.id')
            ->join('MasterMenu', 'MasterMenu.id', 'MS_ROLE_PERMISSION.master_menu_id')
            ->where('users.username', $username)
            ->where('MasterMenu.nama', $moduleName)->count() > 0;
    }

    public static function getAccessToken() {
        $credentialsPath = base_path(env('FIREBASE_CREDENTIALS'));
        $client = new Google_Client();
        $client->setAuthConfig($credentialsPath);
        $client->addScope('https://www.googleapis.com/auth/firebase.messaging');

        $data = $client->fetchAccessTokenWithAssertion();
        Log::debug($data);

        return $data['access_token'];
    }

    public static function getFirebaseConfig() {
        $firebase_config = [
            'type' => '',
            'project_id' => '',
            'private_key_id' => '',
            'private_key' => '',
            'client_email' => '',
            'client_id' => '',
            'auth_uri' => '',
            'token_uri' => '',
            'auth_provider_x509_cert_url' => '',
            'client_x509_cert_url' => '',
            'universe_domain' => ''
        ];

        try {
            $credentialsPath = base_path(env('FIREBASE_CREDENTIALS'));
            $contents = File::get($credentialsPath);
            $firebase_config = json_decode(json: $contents, associative: true);
            // $contents = Storage::json(env('FIREBASE_CREDENTIALS'), JSON_THROW_ON_ERROR);

            Log::debug($credentialsPath);
            // Log::debug($contents);
            Log::debug($firebase_config);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
        }

        return $firebase_config;
    }

    public static function sendPushNotification($token, $title, $body) {
        $status  = 500;
        try {
            $client = new Client();
            $firebase_config = Helper::getFirebaseConfig();

            // URL API FCM v1
            $url = 'https://fcm.googleapis.com/v1/projects/' . $firebase_config['project_id'] . '/messages:send';

            // Dapatkan access token menggunakan Service Account JSON
            $accessToken = Helper::getAccessToken();

            // Payload yang dikirim ke API
            $payload = [
                'message' => [
                    'token' => $token,
                    'notification' => [
                        'title' => $title,
                        'body' => $body,
                    ],
                    'data' => [
                        'key' => 'value', // Data tambahan
                    ],
                ],
            ];

            // Kirim request ke API FCM
            $response = $client->post($url, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $accessToken,
                    'Content-Type'  => 'application/json',
                ],
                'json' => $payload,
            ]);

            $status = $response->getStatusCode();
        } catch (Exception $ex) {
            Log::error('Error sending notification');
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
        }

        return $status;
    }

    public static function numberToRomanRepresentation($number) {
        $map = array('M' => 1000, 'CM' => 900, 'D' => 500, 'CD' => 400, 'C' => 100, 'XC' => 90, 'L' => 50, 'XL' => 40, 'X' => 10, 'IX' => 9, 'V' => 5, 'IV' => 4, 'I' => 1);
        $returnValue = '';
        while ($number > 0) {
            foreach ($map as $roman => $int) {
                if($number >= $int) {
                    $number -= $int;
                    $returnValue .= $roman;
                    break;
                }
            }
        }
        return $returnValue;
    }

    public static function validateDateFormat($format, $date) {
        $dt = DateTime::createFromFormat($format, $date);
        return $dt !== false && !array_sum($dt::getLastErrors());
    }
}
