<?php

namespace App\Http\Controllers\absensi;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Uuid;

class CompareAbsensiController extends Controller {
    
    function index(Request $request) {
        $tgl = '2024-08-22';
        $data_absensi = DB::connection('sqlsrv2')
                ->table("TAbsensi as ta")
                ->select('ta.nik', 'ta.tanggal', 'ta.masuk')
                ->whereDate("ta.Tanggal", $tgl)->get();
                // ->whereIn('ta.KodeST', ['JKT', 'ISI', 'FAT']);
        $data_finger_log = DB::connection('sqlsrv2')
                ->table("TFingerlog as tf")
                ->select('tf.nik', 'tf.tanggal', DB::raw('SUBSTRING(CAST(jam AS VARCHAR), 1, 5) AS jam'), 'tk.nama')
                ->leftJoin('Tkaryawan as tk', 'tf.nik', '=', 'tk.nik' )
                ->where('Status', 'IN')
                ->where('tk.AKTIF', 0)
                ->whereDate("Tanggal", $tgl)
                ->whereNotNull('tk.nama')
                ->orderBy('tf.nik')
                ->orderBy('Jam')->get();
        $data_absensi_merged = array();
        $merged = array();


        foreach($data_absensi as $finger) {
            $data_absensi_merged[$finger->nik] =  array('tanggal' => $finger->tanggal, 'Jam' => str_replace('.', ':', $finger->masuk));
        }

        foreach($data_finger_log as $finger_log) {
            // Log::info(json_encode(['nik' => $finger_log->nik, $data_absensi_merged[$finger_log->nik]]));
            array_push($merged, array('nik' => $finger_log->nik,'nama' => $finger_log->nama, 'absensi' => $data_absensi_merged[$finger_log->nik], 'finger' => $finger_log));
            // Log::debug(json_encode(array($data_absensi_merged[$finger_log->nik] => array('nik' => $finger_log->nik, 'tanggal' => $finger_log->tanggal, 'jam' => $finger_log->jam))));
            // array_push(array($data_absensi_merged[$finger_log->nik] => array('nik' => $finger_log->nik, 'tanggal' => $finger_log->tanggal, 'jam' => $finger_log->jam)), $merged);
        }
        // array_push($data_absensi_merged, 'adf');
        Log::info(json_encode($merged, JSON_PRETTY_PRINT). count($merged));
        // Log::info('{"data_absensi": ' . json_encode($data_absensi_merged) . ', "data_finger_log": ' . json_encode($data_finger_log) . '}');

        return view("SM/coba", ['data' => $merged]);
    }

    function Absensi() {
        return view("absensi/compare-absensi");
    }

    function CompareAbsensi(Request $request) {
        $tanggalAbsensi = $request->query('tanggalAbsensi', null);
        // $tgl = Carbon::now()->startOfDay()->format('Y-m-d H:i:s.u');

        $message = "";
        $isSuccess = false;
        $data_absensi_merged = array();
        $merged = array();

        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $tanggalAbsensi)) {
            try {
                $tgl = Carbon::createFromFormat('Y-m-d', $tanggalAbsensi)->startOfDay()->format('Y-m-d H:i:s.u');
                $data_absensi = DB::connection('sqlsrv2')
                        ->table("TAbsensi as ta")
                        ->select('ta.nik', 'ta.tanggal', 'ta.masuk', 'ta.lmasuk')
                        ->whereDate("ta.Tanggal", $tgl)
                        ->where('ta.lmasuk', 'JKT1')
                        ;
                        // ->whereIn('ta.KodeST', ['JKT', 'ISI', 'FAT']);
                $data_finger_log = DB::connection('sqlsrv2')
                        ->table("TFingerlog as tf")
                        ->select('tf.nik', 'tf.tanggal', DB::raw('SUBSTRING(CAST(jam AS VARCHAR), 1, 5) AS jam'), 'tk.nama')
                        // ->select('tf.nik', 'tf.tanggal', DB::raw('SUBSTRING(CAST(jam AS VARCHAR), 1, 5) AS jam'), 'tk.nama', 'tk.kodedp')
                        ->leftJoin('Tkaryawan as tk', 'tf.nik', '=', 'tk.nik' )
                        ->where('Status', 'IN')
                        ->where('tk.AKTIF', 0)
                        ->whereDate("Tanggal", $tgl)
                        ->whereNotNull('tk.nama')
                        ->orderBy('tf.nik')
                        ->orderBy('Jam');

                Log::info("SQL data_absensi : " . $data_absensi->toRawSql());
                Log::info($data_finger_log->toRawSql());
                $data_absensi = $data_absensi->get();
                $data_finger_log = $data_finger_log->get();
                Log::info("data_absensi : ". count($data_absensi));
                Log::info("data_finger_log: ". count($data_finger_log));
                if(count($data_finger_log) < 1 || count($data_absensi) < 1) {
                    $isSuccess = false;
                    $message = "Belum ada absensi di Tanggal ".$tgl;
                } else {
    
                    foreach($data_absensi as $finger) {
                        $data_absensi_merged[$finger->nik] =  array('tanggal' => $finger->tanggal, 'Jam' => str_replace('.', ':', $finger->masuk));
                    }
                    // Log::info(json_encode($data_absensi_merged, JSON_PRETTY_PRINT));
                    foreach($data_finger_log as $finger_log) {
                        if(key_exists($finger_log->nik, $data_absensi_merged)) {
                            array_push($merged, array(
                                    'nik' => $finger_log->nik,
                                    'nama' => $finger_log->nama, 
                                    'absensi' => key_exists($finger_log->nik, $data_absensi_merged) ? $data_absensi_merged["$finger_log->nik"] : ['tanggal' => null, 'Jam' => null], 
                                    'finger' => $finger_log
                                )
                            );
                        }
                    }
                    $isSuccess = true;
                    $message = "Berhasil get data!";
                    // Log::info(json_encode($merged, JSON_PRETTY_PRINT). count($merged));
                }
            } catch (Exception $e) {
                $error_id = Uuid::uuid4();
                Log::error("(id : $error_id) Error : ". $e->getMessage() . " " . $e->getTraceAsString());
                $isSuccess = false;
                
                $message = "Terjadi kesalahan, Coba beberapa saat lagi! (error id: $error_id)";
            }
        } else {
            // Jika format tidak valid, kembalikan pesan error
            // echo "Format tanggal tidak valid. Harus dalam format yyyy-mm-dd.";
            $isSuccess = false;
            $message = "Format tanggal tidak valid. Harus dalam format yyyy-mm-dd.";
        }
        return response()->json([
            'isSuccess' => $isSuccess, 
            'message' => $message, 
            'data' => [
                'rows' => $merged
            ]
        ]);
    }
}