<?php

namespace App\Http\Controllers\PLANT;

use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PlantTransmissionController extends Controller
{
    public function index()
    {
        return view('plant/transmission-test-form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'machine_number' => 'required|string|max:255',
            'machine_model' => 'required|string|max:255',
            'machine_serial_no' => 'required|string|max:255',
            'machine_smr' => 'required|string|max:255',
            'jobsite' => 'required|string|max:255',
            'checkdate' => 'required|date_format:Y-m-d',
            'solenoid_position' => 'required',
            'solenoid_actual' => 'required',
            'speed_sensor' => 'required',
            'speed_sensor_low_iddle_actual' => 'required',
            'speed_sensor_high_iddle_actual' => 'required',
            'power_train_description' => 'required',
            'lever_position' => 'required',
            'power_train_low_iddle_actual' => 'required',
            'power_train_low_iddle_after_adjustment' => 'required',
            'power_train_high_iddle_actual' => 'required',
            'power_train_high_iddle_after_adjustment' => 'required'
        ]);

        DB::beginTransaction();
        $requestData = $request->all();

        try {
            $master = DB::table('FM_PLANT_PPM_TRANSMISI_CMT_BSS_MASTER')->insertGetId([
                'machine_number' => $requestData['machine_number'],
                'machine_model' => $requestData['machine_model'],
                'machine_serial_no' => $requestData['machine_serial_no'],
                'machine_smr' => $requestData['machine_smr'],
                'jobsite' => $requestData['jobsite'],
                'checkdate' => $requestData['checkdate'],
                'created_at' => now(),
                'created_by' => session("user_id"),
                'updated_at' => null,
                'updated_by' => null
            ]);

            // Harness Test
            foreach($requestData['solenoid_position'] as $key => $solenoidPosition) {
                $solenoidActual = $requestData['solenoid_actual'][$key];
                DB::table('FM_PLANT_PPM_TRANSMISI_CMT_BSS_DETAIL_HARNESS')->insert([
                    'plant_test_id' => $master,
                    'selonoid_position' => $solenoidPosition,
                    'actual' => $solenoidActual,
                    'created_at' => now(),
                    'created_by' => session("user_id"),
                    'updated_at' => null,
                    'updated_by' => null
                ]);
            }

            // Speed Sensor Test
            foreach($requestData['speed_sensor'] as $key => $speedSensor) {
                $lowIddleActual = $requestData['speed_sensor_low_iddle_actual'][$key];
                $highIddleActual = $requestData['speed_sensor_high_iddle_actual'][$key];

                DB::table('FM_PLANT_PPM_TRANSMISI_CMT_BSS_DETAIL_SPEED_SENSOR_TEST')->insert([
                    'plant_test_id' => $master,
                    'speed_sensor' => $speedSensor,
                    'actual_low_iddle' => $lowIddleActual,
                    'actual_high_iddle' => $highIddleActual,
                    'created_at' => now(),
                    'created_by' => session("user_id"),
                    'updated_at' => null,
                    'updated_by' => null
                ]);
            }

            // Power Train Pressures
            foreach($requestData['power_train_description'] as $key => $powerTrainDescription) {
                $leverPosition = $requestData['lever_position'][$key];
                $lowIddleActual = $requestData['power_train_low_iddle_actual'][$key];
                $lowIddleAfterAdjustment = $requestData['power_train_low_iddle_after_adjustment'][$key];
                $highIddleActual = $requestData['power_train_high_iddle_actual'][$key];
                $highIddleAfterAdjustment = $requestData['power_train_high_iddle_after_adjustment'][$key];

                DB::table('FM_PLANT_PPM_TRANSMISI_CMT_BSS_DETAIL_POWER_TRAIN_PRESSURE')->insert([
                    'plant_test_id' => $master,
                    'description' => $powerTrainDescription,
                    'lever_position' => $leverPosition,
                    'actual_low_iddle' => $lowIddleActual,
                    'actual_high_iddle' => $highIddleActual,
                    'after_adjust_low_iddle' => $lowIddleAfterAdjustment,
                    'after_adjust_high_iddle' => $highIddleAfterAdjustment,
                    'created_at' => now(),
                    'created_by' => session("user_id"),
                    'updated_at' => null,
                    'updated_by' => null
                ]);
            }

            DB::commit();
            return response()->json([
                'message' => 'Berhasil menyimpan data plant transmission!',
                'code' => 200
            ]);

        } catch (QueryException $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Something went wrong: ' . $e->getMessage(),
                'code' => 500
            ]);
        }
    }
}
