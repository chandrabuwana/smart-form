<?php

namespace Modules\SmartForm\App\Http\Controllers\Production;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductionTimeSheetDashboarController extends Controller
{
    //

    function IndexDashboard(){
        return view("SmartForm::production/timesheet/dashboard-form-timesheet-prod");
    }

    function FormTimesheetProduksi() {
        return view("SmartForm::production/timesheet/form-timesheet-prod");
    }

    function SubmitFormTimesheet(Request $req) {
        $isError = true;
        $tgl = now()->toDateTimeString();
        $nik_session = $req->session()->get('user_id', '');
        $TABLE_MASTER = "FM_PRODUKSI_TIMESHEET_MASTER";
        $TABLE_DETAIL = "FM_PRODUKSI_TIMESHEET_DETAIL";
        $response = array(
            'message' => "",
            'isSuccess' => false
        );

        // $requested_by = $req->session()->get('user_id');
        $data_input = $req->input();
        $data_insert = array(
            'driver' => '',
            'site' => '',
            'tanggal' => '',
            'shift' => '',
            'no_unit' => '',
            'hm_awal' => 0.0,
            'hm_akhir' => 0.0,
            'total_rit' => 0
        );
        Log::info("request body : " . json_encode(array('body' => $data_input)));

        try {
            $data_insert['driver'] = $data_input['driver'];
            $data_insert['site'] = $data_input['site'];
            $data_insert['tanggal'] = $data_input['tanggal'];
            $data_insert['shift'] = $data_input['shift'];
            $data_insert['no_unit'] = $data_input['noUnit'];
            $data_insert['hm_awal'] = $data_input['awalHM'];
            $data_insert['hm_akhir'] = $data_input['akhirHM'];
            $data_insert['total_rit'] = $data_input['totalRit'];
            $data_insert['total_rit'] = $data_input['totalRit'];
            $data_insert['created_by'] = $nik_session;
            $data_insert['nik'] = $nik_session;
            $data_insert['blok'] = $data_input['blok'];

            DB::beginTransaction();
            $id = DB::table($TABLE_MASTER)->insertGetId($data_insert);

            foreach ($data_input['detail'] as $data_item_detail) {
                DB::table($TABLE_DETAIL)->insert(array(
                    'id_master' => $id,
                    'jam' => $data_item_detail['jam'],
                    'rit_menit_ke' => $data_item_detail['rit_menit'],
                    'problem' => $data_item_detail['problem'],
                    'material_seam' => $data_item_detail['mns'],
                    'kode_aktifitas' => $data_item_detail['kd_aktifitas'],
                    'awal' => (float) $data_item_detail['awal'],
                    'akhir' => (float) $data_item_detail['akhir'],
                    'created_by' => $nik_session,
                    'created_at' => $tgl
                ));
            }
            DB::commit();
            $response['isSuccess'] = true;
            $response['message'] = "Berhasil Submit Timesheet";
            $response['data'] = ['id' => $id];
        } catch (Exception $ex) {
            DB::rollBack();
            Log::error($ex->getMessage());
            $response['isSuccess'] = false;
            $response['message'] = $ex->getMessage();
        }

        return response()->json(data: $response);
    }

    function GetFormsTimesheet(Request $request) {
        $TABLE_MASTER = "FM_PRODUKSI_TIMESHEET_MASTER";
        $TABLE_DETAIL = "FM_PRODUKSI_TIMESHEET_DETAIL";
        $response = array(
            'message' => '',
            'isSuccess' => false
        );
        $search = $request->query('search', '');
        $sort = $request->query('sort', 'id'); // Default sort by id
        $order = $request->query('order', 'asc'); // Default order is ascending
        $offset = $request->query('offset', 0); // Default offset
        $limit = $request->query('limit', 10); // Default limit

        try {
            $master = DB::table($TABLE_MASTER)
                ->select('id', 'driver', 'tanggal', 'shift', 'no_unit', 'hm_awal', 'hm_akhir', 'total_rit');

            $master->orderBy($sort, $order);
            $document = $master->skip($offset)->take($limit)->get();

            $response['message'] = "Ok";
            $response['isSuccess'] = true;
            $response['data'] = $document;

        } catch (Exception $ex) {
            $response['message'] = $ex->getMessage();
            $response['isSuccess'] = false;
        }

        return response()->json($response);
    }

    function GetFormTimesheetDetail(Request $request) {
        $id = $request->query('id');
        $TABLE_MASTER = "FM_PRODUKSI_TIMESHEET_MASTER";
        $TABLE_DETAIL = "FM_PRODUKSI_TIMESHEET_DETAIL";
        $HARI_MAPPING = array("Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu");
        $errors = array(
            'error' => false,
            'message' => ''
        );
        $data_master = array(
            'id' => '',
            'driver' => '',
            'site' => '',
            'tanggal' => '',
            'shift' => '',
            'no_unit' => '',
            'hm_awal' => '',
            'hm_akhir' => '',
            'total_rit' => 0,
            'hari' => ''
        );
        try {
            $data = DB::table($TABLE_MASTER)
                ->select('id', 'driver', 'site', 'tanggal', 'shift', 'no_unit', 'hm_awal', 'hm_akhir', 'total_rit', 'nik')
                ->where('id', $id)
                ->first();

            $data_detail = DB::table($TABLE_DETAIL)
                ->select('jam', 'rit_menit_ke as rit_menit', 'problem', 'material_seam as mns', 'blok', 'kode_aktifitas as kd_aktifitas', 'awal', 'akhir')
                ->where('id_master', $data->id)
                ->get();

            $nameOfDay = date('w', strtotime($data->tanggal));

            $data_master['id'] = $data->id;
            $data_master['driver'] = $data->driver;
            $data_master['nik'] = $data->nik;
            $data_master['site'] = $data->site;
            $data_master['hari'] = $HARI_MAPPING[$nameOfDay];

            $data_master['tanggal'] = $data->tanggal;
            $data_master['shift'] = $data->shift == "DS" ? "Day Shift (DS)" :  ($data_master['shift'] == "DS" ? "Night Shift (NS)" : "");
            $data_master['no_unit'] = $data->no_unit;
            $data_master['hm_awal'] = $data->hm_awal;
            $data_master['hm_akhir'] = $data->hm_akhir;
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
        }

        Log::info("data_master : ". json_encode($data_master));
        return view('SmartForm::production/timesheet/detail-form-timesheet', ['data' => $data_master, 'data_detail' => $data_detail, 'error' => $errors]);
    }
}
