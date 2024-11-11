<?php

namespace Modules\SmartForm\App\Http\Controllers\PLANT;

use App\Helper;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class PlantTransmissionController extends Controller
{
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
        $machine    = $request->query('machine', '');
        $jobsite    = $request->query('jobsite', '');
        $checkdate  = $request->query('checkdate', '');
        $sort       = $request->query('sort', 'id');
        $order      = $request->query('order', 'asc');
        $offset     = $request->query('offset', 0);
        $limit      = $request->query('limit', 10);

        try {
            $plantMasterNotFiltered = DB::table('FM_PLANT_PPM_TRANSMISI_CMT_BSS_MASTER')->select('id');

            $plantMaster = DB::table('FM_PLANT_PPM_TRANSMISI_CMT_BSS_MASTER')
                ->select('id', 'machine_number', 'machine_model', 'machine_serial_no', 'machine_smr', 'jobsite', 'checkdate');

            if(!empty($machine)) {
                $plantMaster->where('machine_number', 'like', '%' . $machine . '%')
                    ->orWhere('machine_serial_no', 'like', '%' . $machine . '%');
            }

            if(!empty($jobsite)) {
                $plantMaster->where('jobsite', 'like', '%' . $jobsite . '%');
            }

            if(!empty($checkdate)) {
                $plantMaster->where('checkdate', 'like', '%' . $checkdate . '%');
            }

            $data = $plantMaster->orderBy($sort, $order)->offset($offset)
                ->limit($limit)->get();

            return response()->json([
                'total' => $data->count(),
                'totalNotFiltered' => $plantMasterNotFiltered->count(),
                'rows' => $data
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

    public function downloadReport(Request $request)
    {
        $machine    = $request->query('machine', '');
        $jobsite    = $request->query('jobsite', '');
        $checkdate  = $request->query('checkdate', '');

        $plantMaster = DB::table('FM_PLANT_PPM_TRANSMISI_CMT_BSS_MASTER')
                ->select('id', 'machine_number', 'machine_model', 'machine_serial_no', 'machine_smr', 'jobsite', 'checkdate');

        if(!empty($machine)) {
            $plantMaster->where('machine_number', 'like', '%' . $machine . '%')
                ->orWhere('machine_serial_no', 'like', '%' . $machine . '%');
        }
        if(!empty($jobsite)) {
            $plantMaster->where('jobsite', 'like', '%' . $jobsite . '%');
        }
        if(!empty($checkdate)) {
            $plantMaster->where('checkdate', 'like', '%' . $checkdate . '%');
        }

        $spreadsheet = new Spreadsheet();
        $worksheet = $spreadsheet->getActiveSheet();
        $worksheet->getDefaultRowDimension()->setRowHeight(20);
        $offset = 0;

        foreach(range('B', 'M') as $column) {
            $worksheet->getColumnDimension($column)->setAutoSize(false)->setWidth(30);
        }

        $plantMaster->orderBy('id', 'desc')->get()->map( function($item) use($spreadsheet, $worksheet, &$offset) {
            $indexHeader = $offset + 3;
            $worksheet->getStyle("B{$indexHeader}:M{$indexHeader}")->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('fec024');
            $worksheet->getCell("B{$indexHeader}")->getStyle()->getFont()->setBold(true)->setSize(16);
            $worksheet->getCell("B{$indexHeader}")->setValue("Form ID : #{$item->id}");

            $indexHead = $offset + 4;
            $indexBody = $offset + 5;

            $worksheet->getStyle("B{$indexHead}:G{$indexHead}")->applyFromArray([ 'font' => ['bold' => true] ])
                ->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('f1f1f1');

            $worksheet->getCell("B{$indexHead}")->setValue('Machine Number');
            $worksheet->getCell('B' . $indexBody)->setValue($item->machine_number);

            $worksheet->getCell("C{$indexHead}")->setValue('Machine Model');
            $worksheet->getCell("C{$indexBody}")->setValue($item->machine_model);

            $worksheet->getCell("D{$indexHead}")->setValue('Machine Serial No');
            $worksheet->getCell("D{$indexBody}")->setValue($item->machine_serial_no);

            $worksheet->getCell("E{$indexHead}")->setValue('Machine SMR / HM');
            $worksheet->getCell("E{$indexBody}")->setValue($item->machine_smr);

            $worksheet->getCell("F{$indexHead}")->setValue('JobSite');
            $worksheet->getCell("F{$indexBody}")->setValue($item->jobsite);

            $worksheet->getCell("G{$indexHead}")->setValue('Check Date');
            $worksheet->getCell("G{$indexBody}")->setValue($item->checkdate);

            $indexSolenoid = $offset + 7;
            $worksheet->getCell("B{$indexSolenoid}")->getStyle()->getFont()->setSize(14)->setBold(true);
            $worksheet->getCell("B{$indexSolenoid}")->setValue('Detail Harness Test');

            $detailHarness = DB::table('FM_PLANT_PPM_TRANSMISI_CMT_BSS_DETAIL_HARNESS')->where('plant_test_id', $item->id)
                ->orderBy('ID', 'asc')->get();

            $indexHeadSolenoid = $offset + 8;
            $worksheet->getStyle("B{$indexHeadSolenoid}:C{$indexHeadSolenoid}")->applyFromArray([ 'font' => ['bold' => true] ])
                ->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('f1f1f1');

            $worksheet->getCell("B{$indexHeadSolenoid}")->setValue('Solenoid Position');
            $worksheet->getCell("C{$indexHeadSolenoid}")->setValue('Actual');

            $indexBodySolenoid = $offset + 9;
            foreach($detailHarness as $itemHarness) {
                $worksheet->getCell("B{$indexBodySolenoid}")->setValue($itemHarness->selonoid_position);
                $worksheet->getCell("C{$indexBodySolenoid}")->setValue($itemHarness->actual);

                $indexBodySolenoid++;
            }

            $indexSpeedSensor = $indexBodySolenoid + 1;
            $worksheet->getCell("B{$indexSpeedSensor}")->getStyle()->getFont()->setSize(14)->setBold(true);
            $worksheet->getCell("B{$indexSpeedSensor}")->setValue('Detail Speed Sensor Test');

            $detailSpeedSensor = DB::table('FM_PLANT_PPM_TRANSMISI_CMT_BSS_DETAIL_SPEED_SENSOR_TEST')->where('plant_test_id', $item->id)
                ->orderBy('ID', 'asc')->get();

            $indexHeadSpeedSensor = $indexBodySolenoid + 2;
            $worksheet->getStyle("B{$indexHeadSpeedSensor}:D{$indexHeadSpeedSensor}")->applyFromArray([ 'font' => ['bold' => true] ])
                ->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('f1f1f1');

            $worksheet->getCell("B{$indexHeadSpeedSensor}")->setValue('Speed Sensor');
            $worksheet->getCell("C{$indexHeadSpeedSensor}")->setValue('Low Iddle');
            $worksheet->getCell("D{$indexHeadSpeedSensor}")->setValue('High Iddle');

            $indexBodySpeedSensor = $indexBodySolenoid + 3;
            foreach($detailSpeedSensor as $itemSpeedSensor) {
                $worksheet->getCell("B{$indexBodySpeedSensor}")->setValue($itemSpeedSensor->speed_sensor);
                $worksheet->getCell("C{$indexBodySpeedSensor}")->setValue($itemSpeedSensor->actual_low_iddle);
                $worksheet->getCell("D{$indexBodySpeedSensor}")->setValue($itemSpeedSensor->actual_high_iddle);

                $indexBodySpeedSensor++;
            }

            $indexPowerTrain = $indexBodySpeedSensor + 1;
            $worksheet->getCell("B{$indexPowerTrain}")->getStyle()->getFont()->setSize(14)->setBold(true);
            $worksheet->getCell("B{$indexPowerTrain}")->setValue('Detail Power Train Pressure');

            $detailPowerTrain = DB::table('FM_PLANT_PPM_TRANSMISI_CMT_BSS_DETAIL_POWER_TRAIN_PRESSURE')->where('plant_test_id', $item->id)
                ->orderBy('ID', 'asc')->get();

            $indexHeadPowerTrain = $indexBodySpeedSensor + 2;
            $worksheet->getStyle("B{$indexHeadPowerTrain}:G{$indexHeadPowerTrain}")->applyFromArray([ 'font' => ['bold' => true] ])
                ->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('f1f1f1');

            $worksheet->getCell("B{$indexHeadPowerTrain}")->setValue('Description');
            $worksheet->getCell("C{$indexHeadPowerTrain}")->setValue('Lever Position');
            $worksheet->getCell("D{$indexHeadPowerTrain}")->setValue('Actual (Low Iddle)');
            $worksheet->getCell("E{$indexHeadPowerTrain}")->setValue('After Adjustment (Low Iddle)');
            $worksheet->getCell("F{$indexHeadPowerTrain}")->setValue('Actual (High Iddle)');
            $worksheet->getCell("G{$indexHeadPowerTrain}")->setValue('After Adjustment (High Iddle)');

            $indexBodyPowerTrain = $indexBodySpeedSensor + 3;
            foreach($detailPowerTrain as $itemPowerTrain) {
                $worksheet->getCell("B{$indexBodyPowerTrain}")->setValue($itemPowerTrain->description);
                $worksheet->getCell("C{$indexBodyPowerTrain}")->setValue($itemPowerTrain->lever_position);
                $worksheet->getCell("D{$indexBodyPowerTrain}")->setValue($itemPowerTrain->actual_low_iddle);
                $worksheet->getCell("E{$indexBodyPowerTrain}")->setValue($itemPowerTrain->after_adjust_low_iddle);
                $worksheet->getCell("F{$indexBodyPowerTrain}")->setValue($itemPowerTrain->actual_high_iddle);
                $worksheet->getCell("G{$indexBodyPowerTrain}")->setValue($itemPowerTrain->after_adjust_high_iddle);

                $indexBodyPowerTrain++;
            }

            $offset += $indexBodyPowerTrain + 2;
        });

        $writer = new Xlsx($spreadsheet);
        $fileName = 'report_plant_transmission_test.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="'. urlencode($fileName).'"');
        $writer->save('php://output');
    }
}
