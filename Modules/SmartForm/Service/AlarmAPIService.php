<?php
namespace Modules\SmartForm\Service;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Redis;

class AlarmAPIService {
    public function getToken()
    {
        $url = env('ALARM_API_URL') . '/external/login';
        $client = new Client();

        $request = $client->post($url, [
            'verify' => false,
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json'
            ],
            'body' => json_encode([
                'phone_number' => env('ALARM_SENDER'),
                'private_key' => env('ALARM_PASSWORD')
            ])
        ]);

        $response = json_decode($request->getBody()->getContents());
        if(!$response->status || !isset($response->data->token)) {
            throw new Exception($response->message ?? 'Unexpected error.');
        }

        Redis::set('alarm-api-token', $response->data->token);
        return $response->data->token;
    }

    public function sendMessage($phoneNumber, $message)
    {
        $token = Redis::get('alarm-api-token');
        $url = env('ALARM_API_URL') . '/external/send-message';
        $client = new Client();

        try {
            $request = $client->post($url, [
                'verify' => false,
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . $token
                ],
                'body' => json_encode([
                    'phone_number' => $phoneNumber,
                    'type' => 'text',
                    'body' => $message
                ])
            ]);

            $response = json_decode($request->getBody()->getContents());

        } catch(ClientException $e) {
            $statusCode = $e->getCode();
            if($statusCode == 401) {
                $this->getToken();
                return $this->sendMessage($phoneNumber, $message);
            }
        }

        if(isset($response)) {
            if(!$response->status) {
                throw new Exception($response->message ?? 'Unexpected error.');
            }

            return $response->data->message_id;
        }
    }
}
