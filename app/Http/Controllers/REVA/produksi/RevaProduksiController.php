<?php

namespace App\Http\Controllers\REVA\produksi;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class RevaProduksiController extends Controller {

    private const SITE_DB_CONNECTION = [
        'AGM'
    ];
    
    private function getConfigurationSite() {
        $credentialsPath = base_path(env('FIREBASE_CREDENTIALS'));
        
        $configurationDBPath = base_path(config('app.reva_db_json'));
        $contents = File::get($configurationDBPath);
        $firebaseConfig = json_decode(json: $contents, associative: true);

        return $firebaseConfig;
    }

    public function index() {
        $listSite = [];

        foreach ($this->getConfigurationSite() as $key => $value) {
            array_push($listSite, $key);
            Log::info(base64_decode($value['DB_URL']));
        }

        return view('REVA/produksi/index', ['listSite' => $listSite]);
    }

    public function getOB (Request $request) {
        $data = [];
        $isSuccess = false;
        $message = '';
        $errorMessage = [];
        $dataColumn = [
            'Tanggal', 'Shift', 'NamaSupervisor', 'NamaForeman', 'Loader', 'Model', 'NamaOperator', 'Service', 'NamaPit', 'NamaLoading',
            'NamaArea', 'NamaMaterial', 'UOM', 'Hauler', 'NamaHauler', 'Jarak', 'Actual1', 'Actual2', 'Actual3', 'Actual4', 'Actual5', 'Actual6',
            'Actual7', 'Actual8', 'Actual9', 'Actual10', 'Actual11', 'Actual12', 'Rit', 'OBCapacity', 'ProdTruck', 'NamaLokasi', 'NoDoc', 'Loader',
            'NikOptLoader', 'KodePit', 'KodeLoading', 'KodeMaterial', 'KodeLokasi', 'VKodeMaterial', 'VCheck'
        ];

        $inputValidation = Validator::make(
            $request->all(), 
            [
                'site' => ['required'],
                'startDate' => ['date'],
                'endDate' => ['date', 'after_or_equal:startDate'],
            ],
            [
                'site.required' => 'Site tidak valid',
                'startDate.date' => 'Start Date tidak valid',
                'endDate.date' => 'End Date tidak valid',
                'endDate.after_or_equal' => 'End Date harus lebih dari atau sama dengan Start Date',
            ]
        );

        if(count($inputValidation->errors()->all()) > 0) {
            $message = 'Error validating request';
            $errorMessage = $inputValidation->errors()->all();
        } else {
            try {
                $startDate = $request->query('startDate');
                $endDate = $request->query('endDate');
                $site = $request->query('site');

                foreach ($this->getConfigurationSite() as $key => $value) {
                    config([
                        'database.connections.REVA_'.$key => [
                            'driver'    => 'sqlsrv',
                            'host'      => base64_decode($value['DB_URL']),
                            'port'      => base64_decode($value['DB_PORT']),
                            'database'  => base64_decode($value['DB_NAME']),
                            'username'  => base64_decode($value['DB_USER']),
                            'password'  => base64_decode($value['DB_PASS']),
                            'charset'   => 'utf8',
                            'collation' => 'utf8_unicode_ci',
                            'prefix'    => '',
                            'strict'    => false,
                            'engine'    => null,
                        ]
                    ]);
                }
    
                $hasil = DB::connection('REVA_'. $site)->select('EXEC CUSP_REVA_OB ?, ?', [$startDate, $endDate]);
                // Log::info('OB : '. json_encode($hasil));

                $data = $hasil;
                $message = 'Ok';
                $isSuccess = true;
            } catch (Exception $ex) {
                $message = 'Terjadi kesalahan, coba beberapa saat lagi';
                Log::error($ex->getMessage());
                Log::error($ex->getTraceAsString());
            }
        }

        return response()->json([
            'isSuccess' => $isSuccess,
            'message' => $message,
            'errors' => $errorMessage,
            'column' => $dataColumn,
            'data' => $data
        ]);
    }

    public function getEvent(Request $request) {

        $data = [];
        $isSuccess = false;
        $message = '';
        $dataColumn = [
            'Nomor', 'Tanggal', 'Shift', 'Nounit', 'Model', 'NamaDriver', 'Idx', 'JamAwal', 'JamAkhir', 'Durasi2', 'KodeStatus',
            'NamaStatus', 'KodeReason', 'NamaReason', 'Loader', 'Keterangan', 'Line', 'Line2', 'Line3', 'Line4', 'Line5',
            'Line5', 'Replacement', 'NamaLoading', 'NamaArea', 'Jam1', 'Jam2', 'Jam3', 'Jam4', 'Jam5', 'Jam6', 'Jam7', 'Jam8',
            'Jam9', 'Jam10', 'Jam11', 'Jam12'
        ];
        $errorMessage = [];

        $inputValidation = Validator::make(
            $request->all(), 
            [
                'site' => ['required'],
                'startDate' => ['date'],
                'endDate' => ['date', 'after_or_equal:startDate'],
            ],
            [
                'site.required' => 'Site tidak valid',
                'startDate.date' => 'Start Date tidak valid',
                'endDate.date' => 'End Date tidak valid',
                'endDate.after_or_equal' => 'End Date harus lebih dari atau sama dengan Start Date',
            ]
        );

        if(count($inputValidation->errors()->all()) > 0) {
            $message = 'Error validating request';
            $errorMessage = $inputValidation->errors()->all();
        } else {
            try {
                $startDate = $request->query('startDate');
                $endDate = $request->query('endDate');
                $site = $request->query('site');
                foreach ($this->getConfigurationSite() as $key => $value) {
                    config([
                        'database.connections.REVA_'.$key => [
                            'driver'    => 'sqlsrv',
                            'host'      => base64_decode($value['DB_URL']),
                            'port'      => base64_decode($value['DB_PORT']),
                            'database'  => base64_decode($value['DB_NAME']),
                            'username'  => base64_decode($value['DB_USER']),
                            'password'  => base64_decode($value['DB_PASS']),
                            'charset'   => 'utf8',
                            'collation' => 'utf8_unicode_ci',
                            'prefix'    => '',
                            'strict'    => false,
                            'engine'    => null,
                        ]
                    ]);
                }
    
                $hasil = DB::connection('REVA_'. $site)->select('EXEC CUSP_REVA_EVENT ?, ?', [$startDate, $endDate]);
                foreach($hasil as $key => $data) {
                    $hasil[$key]->Durasi2 = (float) $hasil[$key]->Durasi2;
                }
                // Log::info('HASIL Event : '. json_encode($hasil, JSON_PRETTY_PRINT));
                
                $data = $hasil;
    
                $message = 'Ok';
                $isSuccess = true;
            } catch (Exception $ex) {
                $message = 'Terjadi kesalahan, coba beberapa saat lagi';
                Log::error($ex->getMessage());
                Log::error($ex->getTraceAsString());
            }
        }


        return response()->json([
            'isSuccess' => $isSuccess,
            'message' => $message,
            'errors' => $errorMessage,
            'column' => $dataColumn,
            'data' => $data
        ]);
    }

    public function getConstraint(Request $request) {

        $data = [];
        $isSuccess = false;
        $message = '';
        $errorMessage = [];
        $dataColumn = [
            'Tanggal', 'Shift', 'Nounit', 'Model', 'NikOperator', 'NamaOperator', 'NikForeman', 'NamaForeman', 'JamAwal',
            'JamAkhir', 'Constraint', 'SubConstraint', 'LokConstraint', 'Remark', 'Jam1', 'Jam2', 'Jam3', 'Jam4', 'Jam5', 'Jam6', 
            'Jam7', 'Jam8', 'Jam9', 'Jam10', 'Jam11', 'Jam12', 'LoadingPoint', 'DumpingLocation'
        ];

        $inputValidation = Validator::make(
            $request->all(), 
            [
                'site' => ['required'],
                'startDate' => ['date'],
                'endDate' => ['date', 'after_or_equal:startDate'],
            ],
            [
                'site.required' => 'Site tidak valid',
                'startDate.date' => 'Start Date tidak valid',
                'endDate.date' => 'End Date tidak valid',
                'endDate.after_or_equal' => 'End Date harus lebih dari atau sama dengan Start Date',
            ]
        );

        if(count($inputValidation->errors()->all()) > 0) {
            $message = 'Error validating request';
            $errorMessage = $inputValidation->errors()->all();
        } else {
            try {
                $startDate = $request->query('startDate');
                $endDate = $request->query('endDate');
                $site = $request->query('site');
    
                foreach ($this->getConfigurationSite() as $key => $value) {
                    config([
                        'database.connections.REVA_'.$key => [
                            'driver'    => 'sqlsrv',
                            'host'      => base64_decode($value['DB_URL']),
                            'port'      => base64_decode($value['DB_PORT']),
                            'database'  => base64_decode($value['DB_NAME']),
                            'username'  => base64_decode($value['DB_USER']),
                            'password'  => base64_decode($value['DB_PASS']),
                            'charset'   => 'utf8',
                            'collation' => 'utf8_unicode_ci',
                            'prefix'    => '',
                            'strict'    => false,
                            'engine'    => null,
                        ]
                    ]);
                }
    
                $hasil = DB::connection('REVA_'. $site)->select('EXEC CUSP_REVA_CONSTRAINT ?, ?', [$startDate, $endDate]);
                $data = $hasil;
                
                $message = 'Ok';
                $isSuccess = true;
            } catch (Exception $ex) {
                $message = 'Terjadi kesalahan, coba beberapa saat lagi';
                $errorMessage = $message;
                Log::error($ex->getMessage());
                Log::error($ex->getTraceAsString());
            }
        }

        return response()->json([
            'isSuccess' => $isSuccess,
            'message' => $message,
            'errors' => $errorMessage,
            'column' => $dataColumn,
            'data' => $data
        ]);
    }
}