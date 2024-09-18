<?php

namespace Modules\SmartForm\App\Http\Controllers\GS;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

enum Shift: string {
    case Pagi = 'pagi';
    case Siang = 'siang';
    case Malam = 'malam';
}

class SmartCateringController extends Controller {
    private const TABLE_REQ_MAKAN_MOBILE = "PICA_BETA.dbo.SCT_GS_CT_RQST_MB";
    private const TABLE_MASTER_MESS = "PICA_BETA.dbo.SCT_GS_MESS_MST";
    private const TABLE_PENGHUNI_MESS = "PICA_BETA.dbo.SCT_GS_MESS_HUNI";
    private const TABLE_SUBMIT_ORDER = "PICA_BETA.dbo.SCT_GS_CT_ORDER";
    private const TABLE_SUBMIT_ORDER_DETAIL = "PICA_BETA.dbo.SCT_GS_CT_ORDER_DTL";
    private const TABLE_ABSENSI_HRD = "HRD.dbo.TAbsensi";
    private const TABLE_KARYAWAN_HRD = "HRD.dbo.TKaryawan";
    private const TABLE_PENEGASAN_CUTI = "HRD.dbo.TPenegasanCuti";
    private const TABLE_PENGAJUAN_CUTI = "HRD.dbo.tpengajuancuti";
    private const DB_CONN_NAME = 'sqlsrv';

    function AddPemesanan(Request $request) {
        return view("SmartForm::GS/add-pemesanan");
    }

    function GenerateDetailPemesanan(Request $request) {
        $reqTanggalPemesanan = $request->input('tanggalPemesanan');
        $reqSite = $request->input('site');
        $reqJenisPemesanan = $request->input('jenisPemesanan');
        $errorMessage = [];
        $dataMess = [];
        $pesan_makan = [];
        $dataWorking = [];
        $isError = true;
        $summary_rooster = [
            'on_mess' => [],
            'on_working' => [],
            'cuti' => [],
            'off' => []
        ];
        $jam_absensi = [
            'DS' => [
                'start' => '05:00',
                'end' => '07:15'
            ],
            'NS' => [
                'start' => '17:00',
                'end' => '19:15'
            ]
        ];
        
        
        $message = '';
        $tgl = null;
        $validator = Validator::make($request->all(), [
            'tanggalPemesanan' => 'required|regex:/^\d{4}-\d{2}-\d{2}$/',
            'site' => 'required',
            'jenisPemesanan' => ['required', Rule::in(['pagi', 'siang', 'malam'])], 
        ],[
            'tanggalPemesanan.required' => 'Field tanggal wajib diisi.',
            'tanggalPemesanan.regex' => 'Format tanggal harus sesuai dengan format YYYY-MM-DD.',
            'jenisPemesanan.in' => 'Nilai shift harus salah satu dari: pagi, siang, malam.'
        ]);
        
        // $selectedBulan = 0;
        // $selectedTahun = 0;
        // $selectedDate = 0;
        $selectedShift = $reqJenisPemesanan == 'siang' ? 'DS' : ($reqJenisPemesanan == 'malam' ? 'NS' : null);
        if(count($validator->errors()) > 0) {
            // TODO: error valdiasi
            $message = 'Error validasi request';
        } else {
            $tgl = Carbon::createFromFormat('Y-m-d', $reqTanggalPemesanan);
            // $selectedTahun = $tgl->year;
            // $selectedBulan = $tgl->month;
            // $selectedDate = $tgl->day;
            // $colSelectDate = 'tr.T'. $selectedDate . ' as tanggal';
            // Log::info('selectedTahun: '. $selectedTahun . ', selectedBulan: '. $selectedBulan . ', selectedDate: '. $selectedDate);
            try {
                $data_karyawan_mess = DB::connection(self::DB_CONN_NAME)->table(self::TABLE_PENGHUNI_MESS . " as dh")
                    ->select('dh.KodeSite', 'dh.Nik', 'dh.NoDoc', 'dm.NamaMess')
                    ->join(self::TABLE_MASTER_MESS.' as dm', 'dh.NoDoc', '=', 'dm.NoDoc')
                    ->where('dh.KodeSite', $reqSite)->get();
                    
                $data_karyawan_absensi = [];
                $pesan_makan = $this->ListPesanMakanMess($reqJenisPemesanan, $tgl);
                if($reqJenisPemesanan == 'pagi') {

                } else {
                    $data_karyawan_absensi = DB::connection(self::DB_CONN_NAME)->table(self::TABLE_ABSENSI_HRD . ' as ta')
                        ->select('ta.NIK', 'ta.Tanggal', 'ta.Masuk')
                        ->where('KodeST', 'AGM')
                        ->whereDate('ta.Tanggal', Carbon::createFromFormat('Y-m-d', $reqTanggalPemesanan)->startOfDay()->format('Y-m-d H:i:s.u'))
                        ->whereBetween('ta.Masuk', [$jam_absensi[$selectedShift]['start'], $jam_absensi[$selectedShift]['end']])
                        ->get()->toArray();
                }
                    
                $sql_karyawan_cuti = DB::connection(self::DB_CONN_NAME)->table(self::TABLE_PENEGASAN_CUTI . ' as pc')
                    ->join(self::TABLE_PENGAJUAN_CUTI . ' as pcuti', 'pc.NoPengajuan', '=', 'pcuti.nopengajuancuti')
                    ->join(self::TABLE_KARYAWAN_HRD . ' as tk', 'pcuti.nik', '=', 'tk.nik')
                    ->select('pc.Nodoc', 'pcuti.nik', 'pc.TglAwal', 'pc.TglAkhir', 'tk.Nama')
                    ->where('pc.aprovehrd', 1)
                    ->where('pc.Batal', 0)
                    ->where('pc.KodeST', $reqSite)
                    ->whereBetween(DB::raw("'".Carbon::createFromFormat('Y-m-d', $reqTanggalPemesanan)->startOfDay()->format('Y-m-d H:i:s').".000'"), [DB::raw('pc.TglAwal'), DB::raw('pc.TglAkhir')])
                    ->orderBy('pc.tanggal', 'desc');
                $karyawan_cuti = $sql_karyawan_cuti->get()->toArray();

                // Log::info("SQL : " .$sql_karyawan_cuti->toRawSql());
                // Log::info("result : " .json_encode($karyawan_cuti));
                $nik_data_karyawan_absensi = array_column($data_karyawan_absensi, 'NIK');
                $nik_pesan_makan = array_column($pesan_makan, 'NIK');
                $nik_karyawan_cuti = array_column($karyawan_cuti, 'nik');

                // Log::info("nik_karyawan_cuti : " .json_encode($nik_karyawan_cuti, JSON_PRETTY_PRINT));

                // Log::info('packmeal: '.$data_packmeal_mess->get());
                // Filter array_b untuk menghapus item yang NIK-nya ada di array_a
                // $data_karyawan_mess_filter_by_absensi = array_filter($data_karyawan_mess->get()->toArray(), function($item) use ($nik_data_karyawan_absensi) {
                //     return !in_array($item->Nik, $nik_data_karyawan_absensi);
                // });
                
                $data_clone = [];
                $sum_mess = 0;
                $sum_working = 0;
                foreach($data_karyawan_mess as $data) {
                    $pushed_data = [];
                    foreach($data as $key => $value) {
                        $pushed_data[$key] = $value;
                    }

                    if (in_array($data->Nik, $nik_data_karyawan_absensi)){
                        $pushed_data['lokasi'] = 'working';
                        $sum_working++;
                    } else {
                        $pushed_data['lokasi'] = 'mess';
                        $sum_mess++;
                    }

                    if (in_array($data->Nik, $nik_pesan_makan)){
                        $pushed_data['status'] = 1;
                    } else {
                        $pushed_data['status'] = 0;
                    }
                    
                    if (in_array($data->Nik, $nik_karyawan_cuti)){
                        $pushed_data['cuti'] = 1;
                    } else {
                        $pushed_data['cuti'] = 0;
                    }
                    array_push($data_clone, $pushed_data);
                }
                $dataMess = $data_clone;
                $dataWorking = $data_karyawan_absensi;
                // Log::info('array_b_filtered ('. count($data_karyawan_mess_filter_by_absensi) .') : '. json_encode($data_karyawan_mess_filter_by_absensi, JSON_PRETTY_PRINT));
                // Log::info('data_clone : '. json_encode($data_clone));
                // Log::info('mess: '.$sum_mess. ', working: '.$sum_working);

            } catch (Exception $ex) {
                Log::error($ex->getMessage());
                Log::error($ex->getTraceAsString());
            }

            $isError = false;
        }

        $data = [
            'isError' => $isError,
            'message' => $message,
            'errorMessage'=> $validator->errors(),
            'dataMess' => $dataMess,
            'dataWorking' => $dataWorking,
            'dataPesanMakanMess' => $pesan_makan,
            'data' => [
                'total' => 0,
                'totalNotFiltered' => 0,
                'rows' => []
            ]
        ];

        return response()->json($data);
    }

    private function ListPesanMakanMess(string $jenis, $tanggal): array {
        $list_pesan_makan = [];

        try {
            $query_order_makan_mess = DB::connection(self::DB_CONN_NAME)
                ->table(self::TABLE_REQ_MAKAN_MOBILE)
                ->select('Nama', 'NIK', 'lokasi', 'TanggalOrder', 'jenis')
                ->where('jenis', $jenis)
                ->whereDate('TanggalOrder', $tanggal);
            Log::debug("SQL : ". $query_order_makan_mess->toRawSql());
            $list_pesan_makan = $query_order_makan_mess->get()->toArray();

        } catch (Exception $ex) {
            Log::error('ListPesanMakanMess : '. $ex->getMessage());
            Log::error($ex->getTraceAsString());
        }

        return $list_pesan_makan;
    }

    function SubmitPesanMakan(Request $request) {
        $isError = true;
        $message = "";
        $errorMessage = [];
        $data = null;
        $hasil = [
            'isError' => true,
            'message' => ''
        ];
        $nik_session = $request->session()->get('user_id', '');

        $validator = Validator::make($request->all(), [
            'jenisPemesanan' => ['required',  Rule::in(['pagi', 'siang', 'malam'])],
            'messBySystem' => 'required',
            'messByRequest' => 'required',
            'adjustment' => 'required',
            'site' => 'required',
            'tanggal' => 'required',
            'selected' => ['required', Rule::in(['system', 'request'])]
        ],[
            'jenisPemesanan.required' => 'Jenis Pemesanan tidak boleh kosong',
            'jenisPemesanan.in' => 'Jenis Pemesananan tidak sesuai',
            'messBySystem.required' => 'Mess by System tidak boleh kosong',
            'messByRequest.required' => 'Mess by Request tidak boleh kosong',
            'adjustment.required' => 'Adjustment tidak boleh kosong',
            'adjustment.required' => 'Tanggal Pemesanan tidak boleh kosong',
            'site.required' => 'Site tidak boleh kosong',
            'selected.required' => 'Selected tidak boleh kosong',
            'selected.in' => 'Selected tidak sesuai',
        ]);

        Log::info($validator->errors()->all());
        try {
            if(count($validator->errors()->all())) {
                $errorMessage = $validator->errors()->all();
            } else {
                $jenisPemesanan = $request->input("jenisPemesanan");
                $messBySystem = $request->input("messBySystem");
                $messByRequest = $request->input("messByRequest");
                $adjustment = $request->input("adjustment");
                $working = $request->input("working");
                $site = $request->input("site");
                $tanggal = $request->input("tanggal");
                $kode_pemesanan = Carbon::createFromFormat('Y-m-d', $tanggal)->startOfDay()->format('Ymd') . '/' .$site . '/' . $jenisPemesanan;
                $selected_pemesanan = $request->input("selected");
                $detail = $request->input("detail", []);

                $data_order_insert = [
                    'jenis_pemesanan' => $jenisPemesanan,
                    'kode_pemesanan' => $kode_pemesanan,
                    'mess_by_system' => $messBySystem,
                    'mess_by_request' => $messByRequest,
                    'adjustment' => $adjustment,
                    'working' => $working,
                    'site' => $site,
                    'selected' => $selected_pemesanan,
                    'created_by' => $nik_session,
                    'tanggal'  => $tanggal
                ];

                Log::info($kode_pemesanan . ' | '.json_encode($data_order_insert, JSON_PRETTY_PRINT));
                Log::info('detail ' .count($detail));
                
                DB::connection(self::DB_CONN_NAME)->beginTransaction();
                $id_pemesanan = DB::connection(self::DB_CONN_NAME)->table(self::TABLE_SUBMIT_ORDER)
                    ->insertGetId($data_order_insert);
                
                for($i=0;$i<count($detail);$i++) {
                    $detail[$i]['id_order'] = $kode_pemesanan;
                }
                $batchSize = 100; // Sesuaikan batch size sesuai dengan kebutuhan (misalnya 100 baris per batch)
                $chunks = array_chunk($detail, $batchSize);
                foreach ($chunks as $chunk) {
                    DB::connection(self::DB_CONN_NAME)->table(self::TABLE_SUBMIT_ORDER_DETAIL)->insert($chunk);
                }
                // foreach($detail as $dtl_order_makan) {
                //     $dtl_order_makan['id_order'] = $kode_pemesanan;
                //     Log::info(json_encode($dtl_order_makan['nik']));
                // }
                // Log::info(json_encode($detail, JSON_PRETTY_PRINT));

                // $dtl_pemesanan = DB::connection(self::DB_CONN_NAME)->table(self::TABLE_SUBMIT_ORDER_DETAIL)
                //     ->insert($detail);

                DB::connection(self::DB_CONN_NAME)->commit();
                $isError = false;
                $message = 'Berhasil';
                // $data['id_pemesanan'] = $id_pemesanan;
            }
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            
            $message = 'Terjadi kesalahan, coba beberapa saat lagi!';

            DB::connection(self::DB_CONN_NAME)->rollBack();
        }

        return [
            'isError' => $isError,
            'message' => $message,
            'errorMessage' => $errorMessage,
            'data' => $data
        ];
    }

    function DashboardPemesanan(Request $request) {
        return view("SmartForm::GS/dashboard-pemesanan");
    }

    function GetListPemesanan(Request $request) {
        $isSuccess = false;
        $message = '';
        $data = [
            'total' => 0,
            'totalNotFiltered' => 0,
            'rows' => null
        ];

        $filterTanggal = $request->query('tanggal', null);
        $filterSite = $request->query('site', null);
        $filterSelected = $request->query('selected', null);
        $filterJenis = $request->query('jenis', null);
        $sort = $request->query('sort', 'id'); // Default sort by id
        $order = $request->query('order', 'asc'); // Default order is ascending
        $offset = $request->query('offset', 0); // Default offset
        $limit = $request->query('limit', null);

        try {
            $sql_master_data = DB::connection(self::DB_CONN_NAME)->table(self::TABLE_SUBMIT_ORDER)
                ->select('kode_pemesanan', 'site', 'selected', 'jenis_pemesanan');
                
            if($filterTanggal == null || $filterTanggal == 'null') {
            } else {
                // Log::debug('Debug : '. now()->format($filterTanggal));
                $tgl = Carbon::createFromFormat('Y-m-d', $filterTanggal);
                $tgl_akhir = Carbon::createFromFormat('Y-m-d', $filterTanggal)->endOfDay()->format('Y-m-d H:i:s');;
                $sql_master_data->whereDate('tanggal', $tgl);
            }
            if($filterSite == null || $filterSite == 'null') {
            } else {
                $sql_master_data->where('site', $filterSite);
            }
            if($filterJenis == null || $filterJenis == 'null') {
            } else {
                $sql_master_data->where('jenis_pemesanan', $filterJenis);
            }
            if($filterSelected == null || $filterSelected == 'null') {
            } else {
                $sql_master_data->where('selected', $filterSelected);
            }
            $jml = $sql_master_data->count();
            if($limit == null || $limit == 'null' || $limit == '') {
                $sql_master_data->skip($offset);
            } else {
                $sql_master_data->skip($offset)->limit($limit);
            }
            Log::info('SQL : ' . $sql_master_data->toRawSql());
            $master_data = $sql_master_data->get();

            $message= "Ok";
            $isSuccess = true;
            $data = [
                'total' => $jml,
                'totalNotFiltered' => $jml,
                'rows' => $master_data
            ];
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            
            $message= $ex->getMessage();
            $isSuccess = false;
        }

        return response()->json([
            'isSuccess' => $isSuccess,
            'message' => $message,
            'data' => $data
        ]);
    }
}

/**
 * DECLARE @tgl DATETIME = '2024-08-27 00:00:00.000';
 * INSERT INTO [HRD].[dbo].[tabsensi]
 *      ([IDX],[Hari],[Tanggal],[NIK],[IDCard],[Masuk],[TGL_Masuk],[SHIFT],[kodeABS],[kodeST],[IDXS],[lmasuk])
 *  VALUES
 *      ('202408271015069192168260542070', 'Senin', '@tgl', '1015069', '1015069', '05:42' ,
 *      '@tgl', 'DS', 'H', 'AGM', '@tgl', 'AGM')
 */