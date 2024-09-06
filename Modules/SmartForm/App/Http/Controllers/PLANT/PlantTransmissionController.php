<?php

namespace Modules\SmartForm\App\Http\Controllers\PLANT;

use App\Helper;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PlantTransmissionController extends Controller
{
    public function __construct()
    {
        if(!Helper::isGrantPermission('PLANT')) {
            abort(403);
        }
    }

    public function form(Request $request)
    {
        $referenceNo = $request->query('reference_no');
        return view('SmartForm::/plant/form', [
            'referenceNo' => $referenceNo
        ]);
    }

    public function dashboard()
    {
        return view('SmartForm::plant/dashboard');
    }

    public function getDashboardData(Request $request)
    {
        $search  = $request->query('search', '');
        $sort    = $request->query('sort', 'id');
        $order   = $request->query('order', 'asc');
        $offset  = $request->query('offset', 0);
        $limit   = $request->query('limit', 10);

        try {
            $plantMasterNotFiltered = DB::table('FM_PLANT_PPM_TRANSMISI_CMT_BSS_MASTER')->select('id');

            $plantMaster = DB::table('FM_PLANT_PPM_TRANSMISI_CMT_BSS_MASTER')
                ->select('id', 'machine_number', 'machine_model', 'machine_serial_no', 'machine_smr', 'jobsite', 'checkdate');

            if(!empty($search)) {
                $plantMaster->where('machine_number', 'like', '%' . $search . '%')
                    ->orWhere('machine_model', 'like', '%' . $search . '%')
                    ->orWhere('machine_serial_no', 'like', '%' . $search . '%')
                    ->orWhere('machine_smr', 'like', '%' . $search . '%')
                    ->orWhere('jobsite', 'like', '%' . $search . '%');
            }

            $data = $plantMaster->orderBy($sort, $order)->offset($offset)
                ->limit($limit);

            return response()->json([
                'total' => $data->count(),
                'totalNotFiltered' => $plantMasterNotFiltered->count(),
                'rows' => $data->get()
            ]);

        } catch (Exception $ex) {
            return response()->json([
                'total' => 0,
                'totalNotFiltered' => 0,
                'rows' => []
            ]);
        }
    }

    public function detail($id)
    {
        $plantMasterData = DB::table('FM_PLANT_PPM_TRANSMISI_CMT_BSS_MASTER')->find($id);
        if(!$plantMasterData) abort(404);

        $detailHarness = DB::table('FM_PLANT_PPM_TRANSMISI_CMT_BSS_DETAIL_HARNESS')->where('plant_test_id', $id)
            ->orderBy('id', 'asc')->get();

        $detailSpeedSensor = DB::table('FM_PLANT_PPM_TRANSMISI_CMT_BSS_DETAIL_SPEED_SENSOR_TEST')->where('plant_test_id', $id)
            ->orderBy('id', 'asc')->get();

        $detailPowerTrain = DB::table('FM_PLANT_PPM_TRANSMISI_CMT_BSS_DETAIL_POWER_TRAIN_PRESSURE')->where('plant_test_id', $id)
            ->orderBy('id', 'asc')->get();

        $approvalPIC = DB::table('MS_FORM_PIC')->select('MS_FORM_PIC.id', 'pic_username')
            ->where('form_slug', 'plant-transmission-test')
            ->get()->map( function($pic) use($id, &$statusOverallApproval) {
                $detailPIC = DB::connection('sqlsrv2')->table('TKaryawan')
                    ->select('TKaryawan.Nama AS nama_karyawan', 'tdepartement.Nama as nama_departement', 'tjabatan.Nama AS nama_jabatan')
                    ->join('tdepartement', 'tdepartement.KodeDP', '=', 'TKaryawan.KodeDP')
                    ->join('tjabatan', 'tjabatan.KodeJB', '=', 'TKaryawan.KodeJB')
                    ->where('TKaryawan.NIK', $pic->pic_username)->first();

                $submissionApproval = DB::table('FM_APPROVAL')->select('status', 'reason')
                    ->where('ms_form_pic_id', $pic->id)
                    ->where('submission_form_id', $id)
                    ->first();

                $pic->nama_karyawan = $detailPIC->nama_karyawan;
                $pic->nama_departement = $detailPIC->nama_departement;
                $pic->nama_jabatan = $detailPIC->nama_jabatan;
                $pic->status = $submissionApproval->status ?? null;
                $pic->reason = $submissionApproval->reason ?? null;

                $statusOverallApproval = $pic->status == 'Rejected' ? 'Rejected' : $pic->status;
                return $pic;
            });

        $statusOverallApproval = 'Dalam Review';
        $approvalPIC->pluck('status')->each( function($status) use(&$statusOverallApproval) {
            if($status == 'Rejected') {
                $statusOverallApproval = 'Ditolak';
            } else if(is_null($status)) {
                $statusOverallApproval = 'Dalam Review';
            } else {
                $statusOverallApproval = 'Approved';
            }
        });

        return view('SmartForm::plant/form', [
            'plantMaster' => $plantMasterData,
            'detailHarness' => $detailHarness,
            'detailSpeedSensor' => $detailSpeedSensor,
            'detailPowerTrain' => $detailPowerTrain,
            'approvalPIC' => $approvalPIC,
            'statusOverallApproval' => $statusOverallApproval
        ]);
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
                'reference_no' => $requestData['reference_no'] ?? null,
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
