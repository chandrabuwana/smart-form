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
    // private const TABLE_SUBMIT_ORDER_DETAIL = "PICA_BETA.dbo.SCT_GS_CT_ORDER_DTL";
    private const TABLE_SUBMIT_ORDER_DETAIL = "PICA_BETA.dbo.SCT_GS_CT_ORDER_DETAIL";
    private const TABLE_SUBMIT_ORDER_VENDOR = "PICA_BETA.dbo.SCT_GS_CT_ORDER_VNDR";
    private const TABLE_VENDOR_MAPPING = "PICA_BETA.dbo.SCT_GS_VENDOR_MAPPING";
    private const TABLE_VENDOR_ORDER = "PICA_BETA.dbo.SCT_GS_CT_ORDER_VNDR";
    private const TABLE_VENDOR_MASTER = "PICA_BETA.dbo.SCT_GS_VENDOR_MST";
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
                        ->where('lmasuk', $reqSite)
                        ->whereDate('ta.Tanggal', Carbon::createFromFormat('Y-m-d', $reqTanggalPemesanan)->startOfDay()->format('Y-m-d H:i:s.u'))
                        ->whereBetween('ta.Masuk', [$jam_absensi[$selectedShift]['start'], $jam_absensi[$selectedShift]['end']])
                        ;
                    Log::debug('SQL absensi karyawan : '. $data_karyawan_absensi->toRawSql());
                    $data_karyawan_absensi = $data_karyawan_absensi->get()->toArray();
                    Log::debug("Data absensi ". $reqSite . " : " .count($data_karyawan_absensi));
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
                $summaryOrder = $request->input("summaryOrder", []);

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
                $vendorMapping = DB::connection(self::DB_CONN_NAME)->table(self::TABLE_VENDOR_MAPPING)
                    ->select(['id as id_mapping', 'VendorID', 'lokasi'])
                    ->whereIn('lokasi', $extractedLokasi)
                    ->where('KodeSite', $site)
                    ->where('JenisPemesanan', $jenisPemesanan);
                
                Log::debug("SQL vendor mapping : " . $vendorMapping->toRawSql());
                // Log::debug("SQL vendor mapping : ");
                // Log::debug($vendorMapping->get());
                $vendorMapping = $vendorMapping->get()->toArray();
                $newSummaryOrder = [];
                $summaryPerVendor = [];
                foreach ($summaryOrder as $pesanan) {
                    // Log::debug("pesanan : ".json_encode($pesanan));
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
                        'id_mapping_vendor' => !$result ? null : $result->id_mapping,
                        'lokasi' => $pesanan['lokasi'],
                        'site' => $pesanan['site'],
                        'jenis_pemesanan' => $pesanan['jenis'],
                        'jumlah' => $pesanan['jumlah'],
                        'created_at' => $tgl,
                        'created_by' => $nik_session
                    ];

                    $insert_pesanan = $_temp_pesanan;
                    $_temp_pesanan['VendorID'] = $vendor_id;

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
                    
                    $summaryPerVendor_new[] = $details;
                    DB::connection(self::DB_CONN_NAME)->table(self::TABLE_SUBMIT_ORDER_VENDOR)->insert($details);
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
            $data_pemesanan = DB::connection(self::DB_CONN_NAME)->table(self::TABLE_VENDOR_ORDER . ' as a')
                ->select('a.kode_pemesanan', 'a.KodeSite', 'a.TanggalOrder', 'a.Jumlah', 'b.Nama')    
                ->leftJoin(self::TABLE_VENDOR_MASTER . ' as b', 'a.VendorID', '=', 'b.id')
                ->where('kode_pemesanan', $kode_pemesanan);
            Log::debug($master_pemesanan->toRawSql());
            Log::debug($data_pemesanan->toRawSql());
            $data['detail'] = $data_pemesanan->get()->toArray();
            $data['master'] = $master_pemesanan->first();
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