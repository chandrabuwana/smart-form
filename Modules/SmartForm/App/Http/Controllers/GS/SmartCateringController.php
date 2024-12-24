<?php

namespace Modules\SmartForm\App\Http\Controllers\GS;

use App\Helper;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx as WriterXlsx;

enum Shift: string {
    case Pagi = 'pagi';
    case Siang = 'siang';
    case Sore = 'sore';
    case Malam = 'malam';
}

class SmartCateringController extends Controller {
    private const DB_SMARTFORM = "PICA_BETA";
    private const DB_HRD = "HRD";
    private const TABLE_REQ_MAKAN_MOBILE = "SCT_GS_CT_RQST_MB";
    private const TABLE_MASTER_MESS = "SCT_GS_MESS_MST";
    private const TABLE_PENGHUNI_MESS = "SCT_GS_MESS_HUNI";
    private const TABLE_SUBMIT_ORDER = "SCT_GS_CT_ORDER";
    private const TABLE_SUBMIT_ORDER_ADJUSTMENT_DTL = "SCT_GS_CT_ADJUSTMENT";
    // private const TABLE_SUBMIT_ORDER_DETAIL = "SCT_GS_CT_ORDER_DTL";
    private const TABLE_SUBMIT_ORDER_DETAIL = "SCT_GS_CT_ORDER_DETAIL";
    private const TABLE_SUBMIT_ORDER_VENDOR = "SCT_GS_CT_ORDER_VNDR";
    private const TABLE_VENDOR_MAPPING = "SCT_GS_VENDOR_MAPPING";
    private const TABLE_VENDOR_MAPPING_DAY = "SCT_GS_VENDOR_MAPPING_DAY";
    private const TABLE_VENDOR_ORDER = "SCT_GS_CT_ORDER_VNDR";
    private const TABLE_VENDOR_MASTER = "SCT_GS_VENDOR_MST";
    private const TABLE_ABSENSI_HRD = self::DB_HRD . ".dbo.TAbsensi";
    private const TABLE_NEW_ABSENSI_HRD = self::DB_HRD . ".dbo.TAttendance";
    private const TABLE_FINGERLOG_HRD = self::DB_HRD . ".dbo.TFingerlog";
    private const TABLE_KARYAWAN_HRD = self::DB_HRD . ".dbo.TKaryawan";
    private const TABLE_PENEGASAN_CUTI = self::DB_HRD . ".dbo.TPenegasanCuti";
    private const TABLE_PENGAJUAN_CUTI = self::DB_HRD . ".dbo.tpengajuancuti";
    private const DB_CONN_NAME = 'sqlsrv';
    private const MAPPING_COLUMN_VENDOR_DAY = [1 => 'senin', 2 => 'selasa', 3 => 'rabu', 4 => 'kamis', 5 => 'jumat', 6 => 'sabtu', 7 => 'minggu'];
    private $DB_LINK = [
        'MME' => 'DMME.',
        'JKT' => '',
        'JKT1' => '',
        'CDI' => 'CDI.',
        'PMSS' => 'DPMSS.',
        'MAS' => 'DMAS.',
        'AGM' => 'DAGM.',
        'BSSR' => 'DBSSR.',
        'MBL' => 'DMBL.',
        'MSJ' => 'DMSJ.',
        'TAJ' => 'DTAJ.'
    ];

    function AddPemesanan(Request $request) {
        // Helper::getAccessToken();
        return view("SmartForm::GS/pemesanan-catering");
    }

    function GenerateDetailPemesanan(Request $request) {
        $reqTanggalPemesanan = $request->input('tanggalPemesanan');
        $reqSite = $request->input('site') == "JKT" ? "JKT1" : $request->input('site');
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
                'end' => '07:30'
            ],
            'NS' => [
                'start' => '17:00',
                'end' => '19:30'
            ]
        ];


        $message = '';
        $tgl = null;
        $validator = Validator::make($request->all(), [
            'tanggalPemesanan' => 'required|regex:/^\d{4}-\d{2}-\d{2}$/',
            'site' => 'required',
            'jenisPemesanan' => ['required', Rule::in(['pagi', 'siang', 'sore', 'malam'])],
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
            $errorMessage[] = $validator->errors()->all();
        } else {
            $tgl = Carbon::createFromFormat('Y-m-d', $reqTanggalPemesanan);
            // $selectedTahun = $tgl->year;
            // $selectedBulan = $tgl->month;
            // $selectedDate = $tgl->day;
            // $colSelectDate = 'tr.T'. $selectedDate . ' as tanggal';
            // Log::info('selectedTahun: '. $selectedTahun . ', selectedBulan: '. $selectedBulan . ', selectedDate: '. $selectedDate);
            try {
                $data_karyawan_mess = [];
                $pesan_makan = [];
                if($reqJenisPemesanan !== 'malam') {
                    $data_karyawan_mess = DB::connection(self::DB_CONN_NAME)->table(self::TABLE_PENGHUNI_MESS . " as dh")
                        ->select('dh.KodeSite', 'dh.Nik', 'dh.NoDoc', 'dm.NamaMess', 'tk.Nama as nama')
                        ->leftJoin(self::TABLE_MASTER_MESS.' as dm', 'dh.NoDoc', '=', 'dm.NoDoc')
                        ->leftJoin(self::TABLE_KARYAWAN_HRD . ' as tk', 'dh.nik', '=', 'tk.nik')
                        ->where('dh.KodeSite', $reqSite)
                        ->get();
                }

                $data_karyawan_absensi = [];
                if($reqJenisPemesanan !== 'malam') $pesan_makan = $this->ListPesanMakanMess($reqJenisPemesanan, $tgl);
                if($reqJenisPemesanan == 'pagi' || $reqJenisPemesanan == 'sore') {

                } else {
                    // tabel absensi
                    $data_karyawan_absensi = $this->getAbsensiKaryawan($reqSite, $selectedShift, $reqTanggalPemesanan);
                    // $data_karyawan_absensi = DB::connection(self::DB_CONN_NAME)->table($this->DB_LINK[$reqSite] . self::TABLE_ABSENSI_HRD . ' as ta')
                    //     ->select('ta.NIK', 'ta.Tanggal', 'ta.Masuk', 'tk.Nama')
                    //     ->leftJoin(self::TABLE_KARYAWAN_HRD . ' as tk', 'tk.Nik', '=', 'ta.Nik')
                    //     ->where('ta.lmasuk', $reqSite)
                    //     ->where('ta.Shift', $selectedShift)
                    //     ->whereDate('ta.Tanggal', Carbon::createFromFormat('Y-m-d', $reqTanggalPemesanan)->startOfDay()->format('Y-m-d H:i:s.u'))
                    //     // ->whereBetween('ta.Masuk', [$jam_absensi[$selectedShift]['start'], $jam_absensi[$selectedShift]['end']])
                    //     ;

                    // table fingerlog
                    // $data_karyawan_absensi = DB::connection(self::DB_CONN_NAME)->table($this->DB_LINK[$reqSite] . self::TABLE_FINGERLOG_HRD . ' as tf')
                    //     ->select('tf.IP', 'tf.NIK', 'tf.Tanggal', 'tf.Jam as Masuk', 'tk.Nama')
                    //     ->leftJoin(self::TABLE_KARYAWAN_HRD . ' as tk', 'tk.Nik', '=', 'tf.Nik')
                    //     ->where('tf.Status', 'IN')
                    //     ->whereDate('tf.Tanggal', Carbon::createFromFormat('Y-m-d', $reqTanggalPemesanan)->startOfDay()->format('Y-m-d H:i:s.u'))
                    //     ->whereBetween('tf.Jam', [$jam_absensi[$selectedShift]['start'], $jam_absensi[$selectedShift]['end']]);
                    // Log::debug('SQL absensi karyawan : '. $data_karyawan_absensi->toRawSql());
                    // tabel absensi
                    // $data_karyawan_absensi = $data_karyawan_absensi->get()->toArray();
                    // tabel fingerlog
                    // $data_karyawan_absensi = collect($data_karyawan_absensi->get()->toArray());
                    // $data_karyawan_absensi = $data_karyawan_absensi->unique('NIK')->values()->all();
                    // Log::debug("Data absensi ". $reqSite . " : " .count($data_karyawan_absensi));
                }

                $sql_karyawan_cuti = DB::connection(self::DB_CONN_NAME)->table($this->DB_LINK[$reqSite]. self::TABLE_PENEGASAN_CUTI . ' as pc')
                    ->leftJoin($this->DB_LINK[$reqSite]. self::TABLE_PENGAJUAN_CUTI . ' as pcuti', 'pc.NoPengajuan', '=', 'pcuti.nopengajuancuti')
                    ->leftJoin(self::TABLE_KARYAWAN_HRD . ' as tk', 'pcuti.nik', '=', 'tk.nik')
                    ->select('pc.Nodoc', 'pcuti.nik', 'pc.TglAwal', 'pc.TglAkhir', 'tk.Nama')
                    ->where('pc.aprovehrd', 1)
                    ->where('pc.Batal', 0)
                    ->where('pc.KodeST', $reqSite)
                    ->whereBetween(DB::raw("'".Carbon::createFromFormat('Y-m-d', $reqTanggalPemesanan)->startOfDay()->format('Y-m-d H:i:s').".000'"), [DB::raw('pc.TglAwal'), DB::raw('pc.TglAkhir')])
                    ->orderBy('pc.tanggal', 'desc');
                $karyawan_cuti = $sql_karyawan_cuti->get()->toArray();

                Log::info("SQL karyawan cuti : " .$sql_karyawan_cuti->toRawSql());
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
                $isError = false;
            } catch (Exception $ex) {
                $message = 'Terjadi Kesalahan, coba beberapa saat lagi';
                $errorMessage[] = $ex->getMessage();
                Log::error($ex->getMessage());
                Log::error($ex->getTraceAsString());
            }

            // $isError = false;
        }

        $data = [
            'isError' => $isError,
            'message' => $message,
            'errorMessage'=> $errorMessage,
            'dataMess' => $reqJenisPemesanan == 'malam' ? [] : $dataMess,
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
                ->table(self::TABLE_REQ_MAKAN_MOBILE. ' as a')
                ->select('a.Nama', 'a.NIK', 'a.lokasi', 'a.TanggalOrder', 'a.jenis', 'b.NamaMess as lokasi_name')
                ->leftJoin(self::TABLE_MASTER_MESS . ' as b', 'a.lokasi', '=', 'b.NoDoc')
                ->where('jenis', $jenis)
                ->whereDate('TanggalOrder', $tanggal);
            Log::debug("SQL Pesan Makan: ". $query_order_makan_mess->toRawSql());
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
        $tgl = now();

        $validator = Validator::make($request->all(), [
            'jenisPemesanan' => ['required',  Rule::in(['pagi', 'siang', 'sore', 'malam'])],
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

        // Log::info($request->input("listAdjustment", []));
        // foreach ($request->input("listAdjustment", []) as $adjustmentPerson) {
        //     $insertAdjustment = [
        //         'KodeST' => $request->input("site"),
        //         'kode_pemesanan' => "sf",
        //         'nik' => $adjustmentPerson['nik'],
        //         'nama' => $adjustmentPerson['nama'],
        //         'keterangan' => $adjustmentPerson['keterangan']
        //     ];
        //     Log::info($insertAdjustment);
        // }
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
                $summaryOrder = $request->input("summaryOrder", []);
                $detailAdjustment = $request->input("listAdjustment", []);
                $column_hari = self::MAPPING_COLUMN_VENDOR_DAY[Carbon::parse($request->input("tanggal"))->dayOfWeekIso];

                $data_order_insert = [
                    'jenis_pemesanan' => $jenisPemesanan,
                    'kode_pemesanan' => $kode_pemesanan,
                    'mess_by_system' => $messBySystem,
                    'mess_by_request' => $messByRequest,
                    'adjustment' => $adjustment,
                    'working' => $working,
                    'site' => $site,
                    'selected' => $selected_pemesanan,
                    'created_at' => $tgl,
                    'created_by' => $nik_session,
                    'tanggal'  => $tanggal
                ];

                Log::info($kode_pemesanan . ' | '.json_encode($data_order_insert, JSON_PRETTY_PRINT));
                Log::info('detail ' .count($detail));

                DB::connection(self::DB_CONN_NAME)->beginTransaction();
                $id_pemesanan = DB::connection(self::DB_CONN_NAME)->table(self::TABLE_SUBMIT_ORDER)
                    ->insertGetId($data_order_insert);
                $extractedLokasi = array_column($summaryOrder, 'lokasi');
                // Log::info(json_encode(array_column($summaryOrder, 'lokasi')));
                // Log::info("summary order: " . json_encode($summaryOrder, JSON_PRETTY_PRINT));
                // $vendorMapping = DB::connection(self::DB_CONN_NAME)->table(self::TABLE_VENDOR_MAPPING)
                $vendorMapping = DB::connection(self::DB_CONN_NAME)->table(self::TABLE_VENDOR_MAPPING_DAY)
                    ->select(['id as id_mapping', $column_hari . ' as VendorID', 'lokasi'])
                    ->whereIn('lokasi', $extractedLokasi)
                    ->where('KodeSite', $site)
                    ->where('status', 0)
                    ->where('JenisPemesanan', $jenisPemesanan == 'sore' ? 'malam' : $request->input("jenisPemesanan"));

                Log::debug("SQL vendor mapping : " . $vendorMapping->toRawSql());
                // Log::debug("SQL vendor mapping : ");
                // Log::debug($vendorMapping->get());
                $vendorMapping = $vendorMapping->get()->toArray();
                Log::debug("SQL result vendor mapping : " . json_encode($vendorMapping, JSON_PRETTY_PRINT));
                $newSummaryOrder = [];
                $summaryPerVendor = [];
                foreach ($summaryOrder as $pesanan) {
                    Log::debug("pesanan : ".json_encode($pesanan));
                    $lokasi_to_find = $pesanan['lokasi'];
                    $result = array_filter($vendorMapping, function($item) use ($lokasi_to_find) {
                        return $item->lokasi === $lokasi_to_find;
                    });

                    $result = reset($result);
                    // Log::debug("result : ".json_encode($result));
                    // $pesanan['id_mapping'] = !$result ? null : $result->id_mapping;
                    $vendor_id = !$result ? null : $result->VendorID;
                    $_temp_pesanan = [
                        'id_order' => $kode_pemesanan,
                        // 'id_mapping_vendor' => $result->VendorID, //!$result ? null : $result->id_mapping,
                        'id_vendor' => $vendor_id, //!$result ? null : $result->id_mapping,
                        'lokasi' => $pesanan['lokasi'],
                        'site' => $pesanan['site'],
                        'jenis_pemesanan' => $pesanan['jenis'],
                        'jumlah' => $pesanan['jumlah'],
                        'status' => 'Pesanan Baru',
                        'created_at' => $tgl,
                        'created_by' => $nik_session
                    ];

                    $insert_pesanan = $_temp_pesanan;
                    $_temp_pesanan['VendorID'] = $vendor_id;
                    // Log::info("insert_pesanan : " . json_encode($insert_pesanan, JSON_PRETTY_PRINT));

                    DB::connection(self::DB_CONN_NAME)->table(self::TABLE_SUBMIT_ORDER_DETAIL)->insert($insert_pesanan);

                    array_push($newSummaryOrder, $_temp_pesanan);
                }

                foreach($newSummaryOrder as $ordr) {
                    // Log::info($summaryPerVendor);
                    if(!array_key_exists($ordr['VendorID'], $summaryPerVendor)) {
                        $summaryPerVendor[$ordr['VendorID']] = [
                            'kode_pemesanan' => $kode_pemesanan,
                            'jumlah' => $ordr['jumlah'],
                            'TanggalOrder' => Carbon::createFromFormat('Y-m-d', $tanggal)->startOfDay()->format('Ymd'),
                            'JenisPemesanan' => $ordr['jenis_pemesanan'],
                            'KodeSite' => $ordr['site'],
                            'created_by' => $nik_session,
                            'created_at' => $tgl
                        ];
                    } else {
                        $summaryPerVendor[$ordr['VendorID']]['jumlah'] = $summaryPerVendor[$ordr['VendorID']]['jumlah'] + $ordr['jumlah'];
                    }
                }

                $summaryPerVendor_new = [];
                foreach ($summaryPerVendor as $vendorID => $details) {
                    // Tambahkan 'VendorID' ke array $details
                    $details['VendorID'] = $vendorID;
                    $details['status'] = 'Pesanan Baru';

                    $summaryPerVendor_new[] = $details;
                    DB::connection(self::DB_CONN_NAME)->table(self::TABLE_SUBMIT_ORDER_VENDOR)->insert($details);
                }

                $vendor_id_list = array_filter(array_column($summaryPerVendor_new, 'VendorID'));
                $sql_notification_vendor = DB::connection(self::DB_CONN_NAME)->table(self::TABLE_VENDOR_MASTER)
                    ->select('notification_token', 'id')
                    ->whereIn('id', $vendor_id_list)
                    ->whereNotNull('notification_token')
                    ->get();

                foreach ($sql_notification_vendor as $token_firebase_vendor) {
                    $notification_body = 'Waktu Pemesanan : ' . $summaryPerVendor[$token_firebase_vendor->id]['TanggalOrder'] . ' ' .$summaryPerVendor[$token_firebase_vendor->id]['JenisPemesanan']. ', Jumlah : '. $summaryPerVendor[$token_firebase_vendor->id]['jumlah'];
                    $notification_title = 'Pesanan Baru : ' . $summaryPerVendor[$token_firebase_vendor->id]['kode_pemesanan'];
                    Helper::sendPushNotification($token_firebase_vendor->notification_token, $notification_title, $notification_body);
                }

                foreach ($detailAdjustment as $adjustmentPerson) {
                    $insertAdjustment = [
                        'KodeST' => $site,
                        'kode_pemesanan' => $kode_pemesanan,
                        'nik' => $adjustmentPerson['nik'],
                        'nama' => $adjustmentPerson['nama'],
                        'keterangan' => $adjustmentPerson['keterangan'],
                        'created_by' => $nik_session,
                        'created_at' => $tgl
                    ];

                    DB::connection(self::DB_CONN_NAME)->table(self::TABLE_SUBMIT_ORDER_ADJUSTMENT_DTL)->insert($insertAdjustment);
                }

                Log::debug("SQL hasil match mapping : " . json_encode($newSummaryOrder, JSON_PRETTY_PRINT));
                Log::debug("Mapping per vendor : " . json_encode($summaryPerVendor_new, JSON_PRETTY_PRINT));

                DB::connection(self::DB_CONN_NAME)->commit();
                $isError = false;
                $message = 'Berhasil';
            }
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());

            $message = 'Terjadi kesalahan, coba beberapa saat lagi!';
            if(str_contains($ex->getMessage(), "Violation of PRIMARY KEY")) $message = "Sudah ada pemesanan";

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

    function DetailPemesanan(Request $request) {
        $data = [
            'isSucces' => false,
            'message' => 'halo',
            'detail' => [],
            'master' => null
        ];

        $kode_pemesanan = $request->input('id');

        try {

            $master_pemesanan = DB::connection(self::DB_CONN_NAME)->table(self::TABLE_SUBMIT_ORDER . ' as a')
                ->where('a.kode_pemesanan', $kode_pemesanan);
            $vendor_id = self::MAPPING_COLUMN_VENDOR_DAY[Carbon::parse($master_pemesanan->first()->tanggal)->dayOfWeekIso];
            Log::debug('Tanggal mapping : ' . $vendor_id);
            // $data_pemesanan = DB::connection(self::DB_CONN_NAME)->table(self::TABLE_VENDOR_ORDER . ' as a')
            //     ->select('a.kode_pemesanan', 'a.KodeSite', 'a.TanggalOrder', 'a.Jumlah', 'b.Nama as NamaVendor', 'a.status')
            //     ->leftJoin(self::TABLE_VENDOR_MASTER . ' as b', 'a.VendorID', '=', 'b.id')
            //     ->where('kode_pemesanan', $kode_pemesanan);
            // $detail_per_lokasi = db::connection(SELF::DB_CONN_NAME)->table(SELF::TABLE_SUBMIT_ORDER_DETAIL . ' as a')
            //     ->select('a.id_order as kode_pemesanan', 'a.jenis_pemesanan', 'a.jumlah','c.Nama as nama_vendor',  'd.NamaMess', 'a.status')
            //     ->leftJoin(self::TABLE_VENDOR_MAPPING_DAY . ' as b', 'a.id_mapping_vendor', '=', 'b.id')
            //     ->leftJoin(self::TABLE_VENDOR_MASTER . ' as c', 'b.'.$vendor_id , '=', 'c.id')
            //     ->leftJoin(self::TABLE_MASTER_MESS . ' as d', 'a.lokasi', '=', 'd.NoDoc')
            //     ->where('a.id_order', $kode_pemesanan);

            Log::debug('SQL master_pemesanan : ' . $master_pemesanan->toRawSql());
            // Log::debug('SQL data_pemesanan : '.$data_pemesanan->toRawSql());
            // Log::debug('SQL detail_per_lokasi : '.$detail_per_lokasi->toRawSql());
            // $data['detail'] = $data_pemesanan->get()->toArray();
            // $data['detail_lokasi'] = $detail_per_lokasi->get()->toArray();
            $data['master'] = $master_pemesanan->first();

            Log::debug(json_encode($data, JSON_PRETTY_PRINT));
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
        }


        return view('SmartForm::GS/detail-pemesanan', ['data' => $data]);
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
                ->select('kode_pemesanan', 'site', 'selected', 'jenis_pemesanan', 'tanggal', 'mess_by_request', 'mess_by_system', 'working', 'adjustment')
                ->orderBy('tanggal', 'desc');

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

    function GetListPemesananPerLokasi(Request $request) {
        $isSuccess = false;
        $message = '';
        $data = [
            'total' => 0,
            'totalNotFiltered' => 0,
            'rows' => null
        ];

        $idPemesanan = $request->query('id', null);
        $sort = $request->query('sort', 'id'); // Default sort by id
        $order = $request->query('order', 'asc'); // Default order is ascending
        $offset = $request->query('offset', 0); // Default offset
        $limit = $request->query('limit', null);

        try {

            $vendor_id = self::MAPPING_COLUMN_VENDOR_DAY[Carbon::parse(explode('/', $idPemesanan)[0])->dayOfWeekIso];
            $sql_master_data = db::connection(SELF::DB_CONN_NAME)->table(SELF::TABLE_SUBMIT_ORDER_DETAIL . ' as a')
            // ->select('a.id as id_detail', 'a.id_order as kode_pemesanan', 'a.jenis_pemesanan', 'a.jumlah','c.Nama as nama_vendor',  'd.NamaMess as lokasi', 'a.status', 'a.file_evidence')
            // ->leftJoin(self::TABLE_VENDOR_MAPPING_DAY . ' as b', 'a.id_mapping_vendor', '=', 'b.id')
            // ->leftJoin(self::TABLE_VENDOR_MASTER . ' as c', 'b.'.$vendor_id , '=', 'c.id')
            ->select('a.id as id_detail', 'a.id_order as kode_pemesanan', 'a.jenis_pemesanan', 'a.jumlah','c.Nama as nama_vendor',  'd.NamaMess as lokasi', 'a.status', 'a.file_evidence')
            // ->leftJoin(self::TABLE_VENDOR_MASTER . ' as c', 'a.id_mapping_vendor' , '=', 'c.id')
            ->leftJoin(self::TABLE_VENDOR_MASTER . ' as c', 'a.id_vendor' , '=', 'c.id')
            ->leftJoin(self::TABLE_MASTER_MESS . ' as d', 'a.lokasi', '=', 'd.NoDoc')
            ->where('a.id_order', $idPemesanan);

            $jml = $sql_master_data->count();
            if($limit == null || $limit == 'null' || $limit == '') {
                $sql_master_data->skip($offset);
            } else {
                $sql_master_data->skip($offset)->limit($limit);
            }

            $master_data = $sql_master_data->get();
            Log::info('SQL Pemesanan per lokasi : ' . $sql_master_data->toRawSql());
            Log::info('SQL Pemesanan per lokasi data: ' . json_encode($master_data, JSON_PRETTY_PRINT));

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

    function GetListPemesananPerVendor(Request $request) {
        $isSuccess = false;
        $message = '';
        $data = [
            'total' => 0,
            'totalNotFiltered' => 0,
            'rows' => null
        ];

        $idPemesanan = $request->query('id', null);
        $sort = $request->query('sort', 'id'); // Default sort by id
        $order = $request->query('order', 'asc'); // Default order is ascending
        $offset = $request->query('offset', 0); // Default offset
        $limit = $request->query('limit', null);

        try {
            $sql_data_pemesanan = DB::connection(self::DB_CONN_NAME)->table(self::TABLE_VENDOR_ORDER . ' as a')
                ->select('a.id as id_detail_vendor', 'a.kode_pemesanan', 'a.KodeSite', 'a.TanggalOrder', 'a.Jumlah', 'b.Nama as NamaVendor', 'b.id as IDVendor', 'a.status')
                ->leftJoin(self::TABLE_VENDOR_MASTER . ' as b', 'a.VendorID', '=', 'b.id')
                ->where('kode_pemesanan', $idPemesanan);

            $jml = $sql_data_pemesanan->count();
            if($limit == null || $limit == 'null' || $limit == '') {
                $sql_data_pemesanan->skip($offset);
            } else {
                $sql_data_pemesanan->skip($offset)->limit($limit);
            }
            // Log::info('SQL sql_data_pemesanan : ' . $sql_data_pemesanan->toRawSql());
            $master_data = $sql_data_pemesanan->get();

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

    public function UpdateStatusPemesanan(Request $request) {
        $isSuccess = false;
        $message = '';
        $errorMessage = [];
        $data = null;
        $nik_session = $request->session()->get('user_id', '');
        $validator = Validator::make(
            $request->all(),
            [
                'status' => ['required'],
                'id_detail' => ['required']
            ],
            [
                'status.required' => 'Status tidak valid',
                'id_detail.required' => 'ID detail tidak valid'
            ]
        );

        $data = $request->input();
        $errorList = $validator->errors()->all();

        if(count($errorList) > 0) {

            $message = "Error mandatory field";
            $errorMessage = $errorList;

        } else {
            $data_update = [
                'status' => $request->input('status'),
                'updated_at' => now(),
                'updated_by' => $nik_session
            ];

            try {
                DB::connection(self::DB_CONN_NAME)->beginTransaction();
                $id = $request->input('id_detail');
                // unset($data_input['id']);

                $sql_update_data = DB::connection(self::DB_CONN_NAME)->table(self::TABLE_SUBMIT_ORDER_DETAIL)
                    ->where('id', $id)
                    ->update($data_update);

                DB::connection(self::DB_CONN_NAME)->commit();
                $message = "Ok";
                $isSuccess = true;
            } catch (Exception $ex) {

                $message = "Terjadi kesalahan, coba beberapa saat lagi";
                $errorMessage = [$message];

                DB::connection(self::DB_CONN_NAME)->rollBack();


                Log::error(get_class($ex). " | ". $ex->getMessage());
                Log::error($ex->getTraceAsString());
            }
        }

        return response()->json([
            'isSuccess' => $isSuccess,
            'message' => $message,
            'errorMessage' => $errorMessage,
            'data' => $data
        ]);

    }

    public function UpdateStatusPemesananVendor(Request $request) {
        $isSuccess = false;
        $message = '';
        $errorMessage = [];
        $data = null;
        $nik_session = $request->session()->get('user_id', '');
        $validator = Validator::make(
            $request->all(),
            [
                'status' => ['required'],
                'id_detail_vendor' => ['required']
            ],
            [
                'status.required' => 'Status tidak valid',
                'id_detail_vendor.required' => 'ID detail tidak valid'
            ]
        );

        $data = $request->input();
        $errorList = $validator->errors()->all();

        if(count($errorList) > 0) {

            $message = "Error mandatory field";
            $errorMessage = $errorList;

        } else {
            $data_update = [
                'status' => $request->input('status'),
                'updated_at' => now(),
                'updated_by' => $nik_session
            ];

            try {
                DB::connection(self::DB_CONN_NAME)->beginTransaction();
                $id = $request->input('id_detail_vendor');
                // unset($data_input['id']);

                $sql_update_data = DB::connection(self::DB_CONN_NAME)->table(self::TABLE_SUBMIT_ORDER_VENDOR)
                    ->where('id', $id)
                    ->update($data_update);

                DB::connection(self::DB_CONN_NAME)->commit();
                $message = "Ok";
                $isSuccess = true;
            } catch (Exception $ex) {

                $message = "Terjadi kesalahan, coba beberapa saat lagi";
                $errorMessage = [$message];

                DB::connection(self::DB_CONN_NAME)->rollBack();


                Log::error(get_class($ex). " | ". $ex->getMessage());
                Log::error($ex->getTraceAsString());
            }
        }

        return response()->json([
            'isSuccess' => $isSuccess,
            'message' => $message,
            'errorMessage' => $errorMessage,
            'data' => $data
        ]);

    }

    function HelperSite(Request $d)
    {
        $data = $d->request->get("query");
        $dataFinal = $data;
        $dataDepartment = DB::connection('sqlsrv2')
            ->table('tsite')
            ->where('AKTIF', 0);


            // ->select("select * from tsite where AKTIF = 0 and Nama like '%$dataFinal%' or kodest like '%$dataFinal%'");
        if($data) $dataDepartment->where('Nama', 'like', "%$dataFinal%")->orWhere('KodeST', 'like', "%$dataFinal%");
        Log::debug('SQL helper site : '. $dataDepartment->toRawSql());

        $dataDepartment = $dataDepartment->get();

        $dataJs = [];
        foreach ($dataDepartment as $a) {
            $dataBaru = [
                'text' => $a->Nama . " (" . $a->KodeST . ")",
                'id' => $a->KodeST
            ];
            $dataJs[] = $dataBaru;
        }
        $final = [
            'data' => $dataJs,
        ];
        return json_encode($final);
    }

    public function viewImportMappingGS(Request $request) {
        return view('SmartForm::GS/import-mapping-gs');
    }

    private function _upsertVendorMst($site, $vendorName) {
        $checkVendor = DB::table('SCT_GS_VENDOR_MST')->where('KodeSite', $site)
            ->where('Nama', $vendorName)->first();
        if(!$checkVendor) {
            $vendorId = DB::table('SCT_GS_VENDOR_MST')->insertGetId([
                'KodeSite' => $site,
                'Nama' => $vendorName,
                'Email' => Str::slug($vendorName, '_') . '@gmail.com',
                'pwd' => Hash::make('password')
            ]);

        } else {
            $vendorId = $checkVendor->id;
        }

        return $vendorId;
    }

    public function importMappingGS(Request $request) {
        DB::beginTransaction();

        try {
            $tempFile = Storage::disk('public')->putFile($request->file('file_excel'));

            $reader = new Xlsx();
            $spreadsheet = $reader->load( storage_path('app/public/' . $tempFile) );
            $sheetNames = $spreadsheet->getSheetNames();

            // import Master Mess
            $masterMessCounter = 1;

            foreach($sheetNames as $sheetName) {
                if($sheetName == 'ROOSTER CATERING TAMBANG' || $sheetName == 'ROOSTER CATERING MESS' || $sheetName == 'Pemetaan Karyawan') {
                    continue;
                }

                $sheetMess = $spreadsheet->getSheetByName($sheetName);
                $kapasitas = $sheetMess->getCell('B1')->getValue();
                $keterangan = $sheetMess->getCell('B2')->getValue();
                $noDoc = 'MSS/' . $request->site . '/' . str_pad($masterMessCounter, 5, '0', STR_PAD_LEFT);

                DB::table('SCT_GS_MESS_MST')->insert([
                    'KodeSite' => strtoupper($request->site),
                    'NoDoc' => $noDoc,
                    'NamaMess' => trim($sheetName),
                    'Status' => '0',
                    'DayaTampung' => $kapasitas,
                    'JumlahKamar' => '1',
                    'Keterangan' => $keterangan,
                    'created_at' => now()
                ]);

                DB::table('SCT_GS_MESS_KAMAR')->insert([
                    'KodeSite' => $request->site,
                    'NoDoc' => $noDoc,
                    'NoKamar' => '1',
                    'kapasitas' => $kapasitas,
                    'created_at' => now(),
                ]);

                $i = 6;
                while(true) {
                    $nama = $sheetMess->getCell('B' . $i)->getValue();
                    $nik = $sheetMess->getCell('C' . $i)->getValue();
                    $keterangan = $sheetMess->getCell('D' . $i)->getValue();

                    if(empty($nama)) {
                        break;
                    }

                    DB::table('SCT_GS_MESS_HUNI')->insert([
                        'KodeSite' => $request->site,
                        'NoDoc' => $noDoc,
                        'Nik' => $nik,
                        'Keterangan' => $keterangan,
                        'status' => '0',
                        'NoKamar' => '1',
                        'created_at' => now()
                    ]);

                    $i++;
                }

                $masterMessCounter++;
            }

            $sheetMess = $spreadsheet->getSheetByName('ROOSTER CATERING MESS');
            foreach(['siang', 'malam', 'pagi'] as $shift) {
                $i = 7;

                while(true) {
                    switch($shift) {
                        case 'pagi':
                            $messName = $sheetMess->getCell('B' . $i)->getValue();
                            $senin = $sheetMess->getCell('C' . $i)->getValue();
                            $selasa = $sheetMess->getCell('D' . $i)->getValue();
                            $rabu = $sheetMess->getCell('E' . $i)->getValue();
                            $kamis = $sheetMess->getCell('F' . $i)->getValue();
                            $jumat = $sheetMess->getCell('G' . $i)->getValue();
                            $sabtu = $sheetMess->getCell('H' . $i)->getValue();
                            $minggu = $sheetMess->getCell('I' . $i)->getValue();
                            break;

                        case 'siang':
                            $messName = $sheetMess->getCell('K' . $i)->getValue();
                            $senin = $sheetMess->getCell('L' . $i)->getValue();
                            $selasa = $sheetMess->getCell('M' . $i)->getValue();
                            $rabu = $sheetMess->getCell('N' . $i)->getValue();
                            $kamis = $sheetMess->getCell('O' . $i)->getValue();
                            $jumat = $sheetMess->getCell('P' . $i)->getValue();
                            $sabtu = $sheetMess->getCell('Q' . $i)->getValue();
                            $minggu = $sheetMess->getCell('R' . $i)->getValue();
                            break;

                        case 'malam':
                            $messName = $sheetMess->getCell('T' . $i)->getValue();
                            $senin = $sheetMess->getCell('U' . $i)->getValue();
                            $selasa = $sheetMess->getCell('V' . $i)->getValue();
                            $rabu = $sheetMess->getCell('W' . $i)->getValue();
                            $kamis = $sheetMess->getCell('X' . $i)->getValue();
                            $jumat = $sheetMess->getCell('Y' . $i)->getValue();
                            $sabtu = $sheetMess->getCell('Z' . $i)->getValue();
                            $minggu = $sheetMess->getCell('AA' . $i)->getValue();
                            break;
                    }

                    if(empty($messName)) {
                        break;

                    } else {
                        $messName = trim($messName);

                        $messMst = DB::table('SCT_GS_MESS_MST')->where('KodeSite', $request->site)->where('NamaMess', $messName)->first('NoDoc');
                        if(is_null($messMst)) {
                            DB::rollBack();
                        }

                        $weeks = [
                            'senin' => null,
                            'selasa' => null,
                            'rabu' => null,
                            'kamis' => null,
                            'jumat' => null,
                            'sabtu' => null,
                            'minggu' => null
                        ];

                        foreach(array_keys($weeks) as $day) {
                            $vendorDay = $this->_upsertVendorMst($request->site, $$day);
                            $weeks[ $day ] = $vendorDay;

                            DB::table('SCT_GS_VENDOR_MAPPING')->updateOrInsert(
                                [
                                    'KodeSite' => $request->site,
                                    'lokasi' => $messMst->NoDoc,
                                ],
                                [
                                    'KodeSite' => $request->site,
                                    'VendorID' => $vendorDay,
                                    'lokasi' => $messMst->NoDoc,
                                ]
                            );
                        }

                        DB::table('SCT_GS_VENDOR_MAPPING_DAY')->insert([
                            'KodeSite' => $request->site,
                            'lokasi' => $messMst->NoDoc,
                            'JenisPemesanan' => $shift,
                            'senin' => $weeks['senin'],
                            'selasa' => $weeks['selasa'],
                            'rabu' => $weeks['rabu'],
                            'kamis' => $weeks['kamis'],
                            'jumat' => $weeks['jumat'],
                            'sabtu' => $weeks['sabtu'],
                            'minggu' => $weeks['minggu'],
                        ]);

                        $i++;
                    }
                }
            }

            $sheetTambang = $spreadsheet->getSheetByName('ROOSTER CATERING TAMBANG');

            foreach(['siang', 'malam'] as $shift) {
                $senin = $sheetTambang->getCell(($shift == 'malam' ? 'F' : 'C') . '5')->getValue();
                $selasa = $sheetTambang->getCell(($shift == 'malam' ? 'F' : 'C') . '6')->getValue();
                $rabu = $sheetTambang->getCell(($shift == 'malam' ? 'F' : 'C') . '7')->getValue();
                $kamis = $sheetTambang->getCell(($shift == 'malam' ? 'F' : 'C') . '8')->getValue();
                $jumat = $sheetTambang->getCell(($shift == 'malam' ? 'F' : 'C') . '9')->getValue();
                $sabtu = $sheetTambang->getCell(($shift == 'malam' ? 'F' : 'C') . '10')->getValue();
                $minggu = $sheetTambang->getCell(($shift == 'malam' ? 'F' : 'C') . '11')->getValue();

                $weeks = [
                    'senin' => null,
                    'selasa' => null,
                    'rabu' => null,
                    'kamis' => null,
                    'jumat' => null,
                    'sabtu' => null,
                    'minggu' => null
                ];

                foreach(array_keys($weeks) as $day) {
                    $$day = trim($$day);
                    $vendorDay = $this->_upsertVendorMst($request->site, $$day);
                    $weeks[ $day ] = $vendorDay;
                }

                DB::table('SCT_GS_VENDOR_MAPPING_DAY')->insert([
                    'KodeSite' => $request->site,
                    'lokasi' => 'working',
                    'JenisPemesanan' => $shift,
                    'senin' => $weeks['senin'],
                    'selasa' => $weeks['selasa'],
                    'rabu' => $weeks['rabu'],
                    'kamis' => $weeks['kamis'],
                    'jumat' => $weeks['jumat'],
                    'sabtu' => $weeks['sabtu'],
                    'minggu' => $weeks['minggu'],
                ]);
            }

            DB::commit();
            @unlink( storage_path('app/public/' . $tempFile) );

            return response()->json([
                'message' => "Berhasil import mapping GS untuk site {$request->site}!",
                'code' => 200
            ]);

        } catch(\Throwable $e) {
            DB::rollBack();
            @unlink( storage_path('app/public/' . $tempFile) );
            dd($e);
        }
    }

    public function generateReport(Request $request) {
        $filterSite = $request->query('site', null);
        $filterPeriode = $request->query('periode', null);
        $mappingBulan = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember'
        ];

        $spreadsheet = new Spreadsheet();
        $worksheet = $spreadsheet->getActiveSheet();

        $spasi = 1;
        $terisi = 0;
        $indexHeader = 2;
        $validator = Validator::make($request->all(), [
            'periode' => 'required|date_format:m-Y',
            'site' => 'required',
        ],[
            'periode.required' => 'Periode tidak valid (MM-yyyy)',
            'periode.date_format' => 'Periode tidak valid (MM-yyyy)',
            'site.required' => 'Site wajib diisi',
        ]);

        if(count($validator->errors()) > 0) {
            $errorMessage = $validator->errors()->all();

            return response()->json(['errors' => $errorMessage]);
        } else {
            $filterPeriode = explode('-', $filterPeriode);
            $filterBulan = (int) $filterPeriode[0];
            $filterTahun = (int) $filterPeriode[1];
            $worksheet->setTitle($mappingBulan[$filterBulan] . ' ' . $filterTahun);
            $worksheet->getDefaultRowDimension()->setRowHeight(20);
            $worksheet->getColumnDimension('A')->setWidth(4);
            $worksheet->getColumnDimension('B')->setWidth(6);
            $worksheet->getColumnDimension('C')->setWidth(15);
            // $worksheet->getColumnDimension('D')->setWidth(45);

            $sqlSite = DB::connection(self::DB_CONN_NAME)->table('HRD.dbo.tsite')
                ->select('KodeST', 'Nama as nama_site')
                ->where('KodeST', $filterSite)->first();

            $dataPemesenan = DB::connection(self::DB_CONN_NAME)->table(self::TABLE_SUBMIT_ORDER_DETAIL . ' as a')
                    ->select('a.id as id_order_detail', 'a.site', 'a.lokasi', 'c.NamaMess as nama_lokasi', 'a.jenis_pemesanan', 'a.jumlah', 'b.tanggal', 'd.Nama as nama_vendor')
                    ->leftJoin(self::TABLE_SUBMIT_ORDER . ' as b', 'a.id_order', '=', 'b.kode_pemesanan')
                    ->leftJoin(self::TABLE_MASTER_MESS . ' as c', 'a.lokasi', '=', 'c.NoDoc')
                    ->leftJoin(self::TABLE_VENDOR_MASTER . ' as d', 'a.id_vendor', '=', 'd.id')
                    ->where('a.site', $filterSite)
                    ->whereMonth('b.tanggal', $filterPeriode[0])
                    ->whereYear('b.tanggal', $filterPeriode[1])
                    ->orderBy('c.NoDoc', 'asc')
                    ->orderBy('b.tanggal', 'asc');
            Log::info('SQL report data pemesanan : ' . $dataPemesenan->toRawSql());
            $dataPemesenan = $dataPemesenan->get();
            Log::info($dataPemesenan);
            $groupedData = [];
            $worksheet->getCell("B2")->getStyle()->getFont()->setBold(true)->setSize(16);
            $worksheet->getCell("B2")->setValue("SITE : {$sqlSite->KodeST} - {$sqlSite->nama_site}");
            $terisi++;
            $worksheet->getCell("B3")->getStyle()->getFont()->setBold(true)->setSize(16);
            $worksheet->getCell("B3")->setValue("Periode : " . $mappingBulan[$filterBulan] . " " .$filterTahun);
            $terisi++;

            // Memisahkan data berdasarkan lokasi
            foreach ($dataPemesenan as $item) {
                $lokasi = $item->lokasi;
                $item->tanggal = implode('/', array_reverse( explode('-', $item->tanggal)));
                $tanggal = $item->tanggal;

                // Jika belum ada array untuk lokasi tersebut, inisialisasi dulu
                if (!isset($groupedData[$lokasi])) {
                    $groupedData[$lokasi] = [
                        'lokasi' => $lokasi,
                        'nama_lokasi' => $lokasi == 'working' ? 'Site / Lapangan' : $item->nama_lokasi,
                        'site' => $item->site,
                        'data' => []
                    ];
                }
                if (!isset($groupedData[$lokasi]['per_tgl'][$tanggal])) {
                    $groupedData[$lokasi]['per_tgl'][$tanggal] = [];
                }

                // Menambahkan item ke grup lokasi yang sesuai
                $groupedData[$lokasi]['per_tgl'][$tanggal][] = $item;
                // $groupedData[$lokasi]['data'][] = $item;
            }
            // dd($groupedData);
            Log::info($groupedData);

            foreach($groupedData as $nilai) {
                // if($nilai->lokasi == 'working') $nilai->nama_lokasi = 'Site / Lapangan';
                $barisTambahan = 0;
                $baris = $indexHeader + $terisi;

                $worksheet->getStyle("B{$baris}:M{$baris}")->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('fec024');
                $worksheet->getCell("B{$baris}")->getStyle()->getFont()->setBold(true)->setSize(16);
                $worksheet->getCell("B{$baris}")->setValue("Lokasi : {$nilai['nama_lokasi']}");
                $baris++;

                $worksheet->getStyle("B{$baris}:M{$baris}")->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FED46A');
                $worksheet->getCell("B{$baris}")->getStyle()->getFont()->setBold(true)->setSize(12);
                $worksheet->getCell("B{$baris}")->setValue("Site: {$nilai['site']}");
                $baris++;

                // No	Tanggal	Vendor	PAGI	SIANG	MALAM
                $worksheet->getCell("B{$baris}")->getStyle()->getFont()->setBold(true)->setSize(12);
                $worksheet->getCell("B{$baris}")->setValue("No");
                $worksheet->getCell("C{$baris}")->getStyle()->getFont()->setBold(true)->setSize(12);
                $worksheet->getCell("C{$baris}")->setValue("Tanggal");
                $worksheet->getCell("D{$baris}")->getStyle()->getFont()->setBold(true)->setSize(12);
                $worksheet->getCell("D{$baris}")->setValue("Pagi");
                $worksheet->getCell("E{$baris}")->getStyle()->getFont()->setBold(true)->setSize(12);
                $worksheet->getCell("E{$baris}")->setValue("Siang");
                $worksheet->getCell("F{$baris}")->getStyle()->getFont()->setBold(true)->setSize(12);
                $worksheet->getCell("F{$baris}")->setValue("Sore/Malam");
                // $worksheet->getCell("G{$baris}")->getStyle()->getFont()->setBold(true)->setSize(12);
                // $worksheet->getCell("G{$baris}")->setValue("Vendor");
                $baris++;

                $noPerHari = 1;
                foreach ($nilai['per_tgl'] as $key => $value) {
                    $jmlPagi = 0;
                    $jmlSiang = 0;
                    $jmlMalam = 0;
                    $worksheet->getCell("B{$baris}")->setValue($noPerHari);
                    $worksheet->getCell("C{$baris}")->getStyle()->getNumberFormat()->setFormatCode('dd/mm/yyyy');
                    $worksheet->getCell("C{$baris}")->setValue($key);

                    foreach ($value as $jenisPesan) {
                        if($jenisPesan->jenis_pemesanan == 'pagi') $jmlPagi = $jenisPesan->jumlah;
                        if($jenisPesan->jenis_pemesanan == 'siang') $jmlSiang = $jenisPesan->jumlah;
                        if($jenisPesan->jenis_pemesanan == 'sore') $jmlMalam = $jenisPesan->jumlah;
                        if($jenisPesan->jenis_pemesanan == 'malam') $jmlMalam = $jenisPesan->jumlah;

                        Log::info("jenis pesan");
                        Log::info(json_encode($jenisPesan));
                    }
                    $worksheet->getCell("D{$baris}")->setValue($jmlPagi);
                    $worksheet->getCell("E{$baris}")->setValue($jmlSiang);
                    $worksheet->getCell("F{$baris}")->setValue($jmlMalam);

                    $baris++;
                    $noPerHari++;
                }
                // for ($i=0; $i < count($nilai['data']); $i++) {
                //     $kolomPemesanan = $this->kolomWaktuPemesanan($nilai['data'][$i]->jenis_pemesanan, $nilai['data'][$i]->jumlah);

                //     $worksheet->getCell("B{$baris}")->setValue($i+1);
                //     $worksheet->getCell("C{$baris}")->getStyle()->getNumberFormat()->setFormatCode('dd-mm-yyyy');
                //     $worksheet->getCell("C{$baris}")->setValue($nilai['data'][$i]->tanggal);
                //     $worksheet->getCell("D{$baris}")->setValue($nilai['data'][$i]->nama_vendor);
                //     foreach ($kolomPemesanan as $kolom) {
                //         $worksheet->getCell("{$kolom['kolom']}{$baris}")->setValue($kolom['nilai']);
                //     }

                //     $baris++;
                // }
                // foreach ($nilai as $dataNilai) {
                //     $worksheet->getCell("B{$baris}")->setValue("Sore/Malam");
                //     $baris++;
                // }

                $terisi = $spasi + $baris;
            }

            $writer = new WriterXlsx($spreadsheet);
            $fileName = 'report_GS_catering_' . $filterPeriode[0]. '-' . $filterPeriode[1] .'.xlsx';
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment; filename="'. urlencode($fileName).'"');
            $writer->save('php://output');
        }
    }

    // protected function getAbsensiKaryawan($site, $shift, $tglPemesanan) {
    //     $dataAbsensi = [];
    //     try {
    //         $dataAbsensi = DB::connection(self::DB_CONN_NAME)->table($this->DB_LINK[$site] . self::TABLE_ABSENSI_HRD . ' as ta')
    //             ->select('ta.NIK', 'ta.Tanggal', 'ta.Masuk', 'tk.Nama')
    //             ->leftJoin(self::TABLE_KARYAWAN_HRD . ' as tk', 'tk.Nik', '=', 'ta.Nik')
    //             ->where('ta.lmasuk', $site)
    //             ->where('ta.Shift', $shift)
    //             ->whereDate('ta.Tanggal', Carbon::createFromFormat('Y-m-d', $tglPemesanan)->startOfDay()->format('Y-m-d H:i:s.u'));

    //             Log::debug('SQL absensi karyawan : '. $dataAbsensi->toRawSql());
    //             $dataAbsensi = $dataAbsensi->get()->toArray();
    //             Log::debug("Data absensi ". $site . " : " .count($dataAbsensi));
    //     } catch (Exception $ex) {
    //         Log::error('Error getAbsensiKaryawan');
    //         Log::error($ex->getMessage());
    //         Log::error($ex->getTraceAsString());
    //     }

    //     return $dataAbsensi;
    // }

    protected function getAbsensiKaryawan($site, $shift, $tglPemesanan) {
        $jam_absensi = [
            'DS' => [
                'start' => '05:00',
                'end' => '07:30'
            ],
            'NS' => [
                'start' => '17:00',
                'end' => '19:30'
            ]
        ];

        $dataAbsensi = [];
        try {
            $dataAbsensi = DB::connection(self::DB_CONN_NAME)->table($this->DB_LINK[$site] . self::TABLE_NEW_ABSENSI_HRD . ' as ta')
                ->select('ta.NIK', 'ta.Tanggal', 'ta.Jam AS Masuk', 'tk.Nama')
                ->leftJoin(self::TABLE_KARYAWAN_HRD . ' as tk', 'tk.Nik', '=', 'ta.Nik')
                ->where('ta.KodeST', $site)
                // ->where('ta.Shift', $shift)
                ->whereBetween('ta.Jam', [$jam_absensi[$shift]['start'], $jam_absensi[$shift]['end']])
                ->where('Status', 'IN')
                ->whereDate('ta.Tanggal', Carbon::createFromFormat('Y-m-d', $tglPemesanan)->startOfDay()->format('Y-m-d H:i:s.u'));

                Log::debug('SQL absensi karyawan : '. $dataAbsensi->toRawSql());
                $dataAbsensi = $dataAbsensi->get()->toArray();
                Log::debug("Data absensi ". $site . " : " .count($dataAbsensi));
        } catch (Exception $ex) {
            Log::error('Error getAbsensiKaryawan');
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
        }

        return $dataAbsensi;
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
