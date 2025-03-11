<?php

namespace Modules\SmartForm\App\Http\Controllers\Production;

use App\Helper;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;

class KalibrasiCtController extends Controller
{

    public function Dashboard(Request $request)
    {
        try {
            $query = DB::table('prod_kalibrasi_ct')
                ->select('*')
                ->orderBy('created_at');

            // Get records with pagination
            $records = $query->paginate(10);

            // Calculate statistics
            $statistics = (object)[
                'total_records' => DB::table('prod_kalibrasi_ct')->count(),
                'total_this_month' => DB::table('prod_kalibrasi_ct')
                    ->whereMonth('created_at', now()->month)
                    ->whereYear('created_at', now()->year)
                    ->count()
            ];

            return view('smartform::production.kalibrasi_ct.dashboard-kalibrasi-ct', [
                'records' => $records,
                'statistics' => $statistics,
                
            ]);
        } catch (\Exception $e) {
            Log::error('Error in Dashboard: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to load dashboard data: ' . $e->getMessage());
        }
    }

    public function AddFormKalibrasi(Request $request)
    {
        try {
            if ($request->has('id')) {
                $record = DB::table('prod_kalibrasi_ct')
                    ->where('id', $request->id)
                    ->first();

                if (!$record) {
                    Log::error('Kalibrasi CT record not found for ID: ' . $request->id);
                    return redirect()->route('prod.kalibrasi-ct.dashboard')
                        ->with('error', 'Record not found');
                }

                // Parse JSON arrays
                $record->ket_front_hauler = json_decode($record->ket_front_hauler);
                $record->ket_jalan_hauler = json_decode($record->ket_jalan_hauler);
                $record->ket_grade_hauler = json_decode($record->ket_grade_hauler);
                $record->ket_disposal_hauler = json_decode($record->ket_disposal_hauler);
                $record->no_loader_hauler = json_decode($record->no_loader_hauler);
                $record->nomor_dtht_hauler = json_decode($record->nomor_dtht_hauler);
                $record->nama_operator_hauler = json_decode($record->nama_operator_hauler);
                $record->jarak_hauling_hauler = json_decode($record->jarak_hauling_hauler);
                $record->waktu_antri_hauler = json_decode($record->waktu_antri_hauler);
                $record->meninggalkan_front_hauler = json_decode($record->meninggalkan_front_hauler);
                $record->cycle_timer_hauler = json_decode($record->cycle_timer_hauler);
                $record->jumlah_bucket_hauler = json_decode($record->jumlah_bucket_hauler);

                $record->no_loader = json_decode($record->no_loader);
                $record->jenis_material_loader = json_decode($record->jenis_material_loader);
                $record->nomor_cmtdt_loader = json_decode($record->nomor_cmtdt_loader);
                $record->digging_loader = json_decode($record->digging_loader);
                $record->swing_isi_loader = json_decode($record->swing_isi_loader);
                $record->load_loader = json_decode($record->load_loader);
                $record->swing_kosong_loader = json_decode($record->swing_kosong_loader);
                $record->total_pengisian_loader = json_decode($record->total_pengisian_loader);
                $record->durasi_loader = json_decode($record->durasi_loader);
                $record->reason_loader = json_decode($record->reason_loader);

                $record->no_dozer = json_decode($record->no_dozer);
                $record->dozing_dozer = json_decode($record->dozing_dozer);
                $record->reverse_dozer = json_decode($record->reverse_dozer);
                $record->gear_shifting_dozer = json_decode($record->gear_shifting_dozer);
                $record->total_dozer = json_decode($record->total_dozer);
                $record->cm_dozer = json_decode($record->cm_dozer);
                $record->jarak_dozer = json_decode($record->jarak_dozer);
                $record->durasi_dozer = json_decode($record->durasi_dozer);
                $record->reason_dozer = json_decode($record->reason_dozer);
                

                Log::info('Kalibrasi CT record loaded for ID: ' . $request->id);

                return view('smartform::production.kalibrasi_ct.form-kalibrasi-ct', [
                    'record' => $record,
                    'isShowDetail' => true
                ]);
            }

            return view('smartform::production.kalibrasi_ct.form-kalibrasi-ct', [
                'isShowDetail' => false
            ]);
        } catch (\Exception $e) {
            Log::error('Error in AddForm: ' . $e->getMessage());
            return redirect()->route('prod.kalibrasi-ct.dashboard')
                ->with('error', 'Failed to load form: ' . $e->getMessage());
        }
    }

    public function StoreKalibrasi(Request $request)
    {


        try {
            $data = [
                'doc_number' => $this->generateDocNumber(),
                'nama_operator_loader_hauler' => $request->nama_operator_loader_hauler,
                'nomor_exca_hauler' => $request->nomor_exca_hauler,
                'nama_disposal_hauler' => $request->nama_disposal_hauler,
                'jumlah_hauler_digunakan_hauler' => $request->jumlah_hauler_digunakan_hauler,
                'tanggal_hauler' => $request->tanggal_hauler,
                'shift_hauler' => $request->shift_hauler,
                'alat_support_hauler' => $request->alat_support_hauler,
                'material_hauler' => $request->material_hauler,
                'tanggal_loader' => $request->tanggal_loader,
                'shift_loader' => $request->shift_loader,
                'nama_operator_loader' => $request->nama_operator_loader,
                'nomor_exca_loader' => $request->nomor_exca_loader,
                'lokasi_loader' => $request->lokasi_loader,
                'jumlah_hauler_digunakan_loader' => $request->jumlah_hauler_digunakan_loader,
                'jarak_hauling_loader' => $request->jarak_hauling_loader,
                'kondisi_front_loader' => $request->kondisi_front_loader,
                'alat_support_loader' => $request->alat_support_loader,
                'rata_rata_loader' => $request->jumlah_hauler_digunakan_loader,
                'cuaca_loader' => $request->cuaca_loader,
                'tanggal_dozer' => $request->tanggal_dozer,
                'shift_dozer' => $request->shift_dozer,
                'nama_operator_dozer' => $request->nama_operator_dozer,
                'nomor_lambung_dozer' => $request->nomor_lambung_dozer,
                'lokasi_dozing_dozer' => $request->lokasi_dozing_dozer,
                'material_dozer' => $request->material_dozer,
                'jarak_dozing_dozer' => $request->jarak_dozing_dozer,
                'kondisi_area_kerja_dozer' => $request->kondisi_area_kerja_dozer,
                'alat_support_dozer' => $request->alat_support_dozer,
                'cuaca_dozer' => $request->cuaca_dozer,
            ];

            // Initialize arrays for multiple entries
            $ket_front_hauler = [];
            $ket_jalan_hauler = [];
            $ket_grade_hauler = [];
            $ket_disposal_hauler = [];
            $no_loader_hauler = [];
            $nomor_dtht_hauler = [];
            $nama_operator_hauler = [];
            $jarak_hauling_hauler = [];
            $waktu_antri_hauler = [];
            $meninggalkan_front_hauler = [];
            $cycle_timer_hauler = [];
            $jumlah_bucket_hauler = [];

            $no_loader = [];
            $jenis_material_loader = [];
            $nomor_cmtdt_loader = [];
            $digging_loader = [];
            $swing_isi_loader = [];
            $load_loader = [];
            $swing_kosong_loader = [];
            $total_pengisian_loader = [];
            $durasi_loader = [];
            $reason_loader = [];

            $no_dozer = [];
            $dozing_dozer = [];
            $reverse_dozer = [];
            $gear_shifting_dozer = [];
            $total_dozer = [];
            $cm_dozer = [];
            $jarak_dozer = [];
            $durasi_dozer = [];
            $reason_dozer = [];

            // Collect only filled data for each row
            for ($i = 1; $i <= 3; $i++) {
                $ket_front = $request->input("ket_front_hauler_$i");
                $ket_jalan = $request->input("ket_jalan_hauler_$i");
                $ket_grade = $request->input("ket_grade_hauler_$i");
                $ket_disposal = $request->input("ket_disposal_hauler_$i");
                $nomor_loader = $request->input("no_loader_hauler_$i");
                // Only add to arrays if at least one field is filled
                if (
                    $ket_front || $ket_jalan || $ket_grade || $ket_disposal || $nomor_loader
                ) {
                    $ket_front_hauler[] = $ket_front;
                    $ket_jalan_hauler[] = $ket_jalan;
                    $ket_grade_hauler[] = $ket_grade;
                    $ket_disposal_hauler[] = $ket_disposal;
                    $no_loader_hauler[] = $nomor_loader;
                }
            }
            for ($i = 1; $i <= 15; $i++) {
                $nomor_dtht_h = $request->input("nomor_dtht_hauler_$i");
                $nama_operator_h = $request->input("nama_operator_hauler_$i");
                $jarak_hauling_h = $request->input("jarak_hauling_hauler_$i");
                $waktu_antri_h = $request->input("waktu_antri_hauler_$i");
                $meninggalkan_front_h = $request->input("meninggalkan_front_hauler_$i");
                $jumlah_bucket_h = $request->input("jumlah_bucket_hauler_$i");
                $cycle_timer_h = $request->input("cycle_timer_hauler_$i");
                // Only add to arrays if at least one field is filled
                if (
                    $nomor_dtht_h || $nama_operator_h || $jarak_hauling_h || $waktu_antri_h || $meninggalkan_front_h || $jumlah_bucket_h || $cycle_timer_h
                ) {
                    $nomor_dtht_hauler[] = $nomor_dtht_h;
                    $nama_operator_hauler[] = $nama_operator_h;
                    $jarak_hauling_hauler[] = $jarak_hauling_h;
                    $waktu_antri_hauler[] = $waktu_antri_h;
                    $meninggalkan_front_hauler[] = $meninggalkan_front_h;
                    $cycle_timer_hauler[] = $cycle_timer_h;
                    $jumlah_bucket_hauler[] = $jumlah_bucket_h;
                }
            }
            for ($i = 1; $i <= 18; $i++) {
                $no_l = $request->input("no_loader_$i");
                $jenis_material_l = $request->input("jenis_material_loader_$i");
                $nomor_cmtdt_l = $request->input("nomor_cmtdt_loader_$i");
                $digging_l = $request->input("digging_loader_$i");
                $swing_isi_l = $request->input("swing_isi_loader_$i");
                $load_l = $request->input("load_loader_$i");
                $swing_kosong_l = $request->input("swing_kosong_loader_$i");
                $durasi_l = $request->input("durasi_loader_$i");
                $reason_l = $request->input("reason_loader_$i");
                $total_pengisian_l = $request->input("total_pengisian_loader_$i");
                // Only add to arrays if at least one field is filled
                if (
                    $no_l || $jenis_material_l || $nomor_cmtdt_l || $digging_l || $swing_isi_l ||
                    $load_l || $swing_kosong_l || $durasi_l || $reason_l || $total_pengisian_loader
                ) {
                    $no_loader[] = $no_l;
                    $jenis_material_loader[] = $jenis_material_l;
                    $nomor_cmtdt_loader[] = $nomor_cmtdt_l;
                    $digging_loader[] = $digging_l;
                    $swing_isi_loader[] = $swing_isi_l;
                    $load_loader[] = $load_l;
                    $swing_kosong_loader[] = $swing_kosong_l;
                    $total_pengisian_loader[] = $total_pengisian_l;
                    $durasi_loader[] = $durasi_l;
                    $reason_loader[] = $reason_l;
                }
            }
            for ($i = 1; $i <= 22; $i++) {
                $no_d = $request->input("no_dozer_$i");
                $dozing_d = $request->input("dozing_dozer_$i");
                $reverse_d = $request->input("reverse_dozer_$i");
                $gear_shifting_d = $request->input("gear_shifting_dozer_$i");
                $cm_d = $request->input("cm_dozer_$i");
                $jarak_d = $request->input("jarak_dozer_$i");
                $durasi_d = $request->input("durasi_dozer_$i");
                $reason_d  = $request->input("reason_dozer_$i");
                $total_d  = $request->input("total_dozer_$i");
                // Only add to arrays if at least one field is filled
                if (
                    $no_d || $dozing_d || $reverse_d || $gear_shifting_d ||
                    $cm_d || $jarak_d || $durasi_d || $reason_d
                ) {
                    $no_dozer[] = $no_d;
                    $dozing_dozer[] = $dozing_d;
                    $reverse_dozer[] = $reverse_d;
                    $gear_shifting_dozer[] = $gear_shifting_d;
                    $total_dozer[] = $total_d;
                    $cm_dozer[] = $cm_d;
                    $jarak_dozer[] = $jarak_d;
                    $durasi_dozer[] = $durasi_d;
                    $reason_dozer[] = $reason_d;
                }
            }


            // Add arrays to data
            $data['ket_front_hauler'] = json_encode(array_values($ket_front_hauler));
            $data['ket_jalan_hauler'] = json_encode(array_values($ket_jalan_hauler));
            $data['ket_grade_hauler'] = json_encode(array_values($ket_grade_hauler));
            $data['ket_disposal_hauler'] = json_encode(array_values($ket_disposal_hauler));
            $data['no_loader_hauler'] = json_encode(array_values($no_loader_hauler));

            $data['nomor_dtht_hauler'] = json_encode(array_values($nomor_dtht_hauler ));
            $data['nama_operator_hauler'] = json_encode(array_values($nama_operator_hauler));
            $data['jarak_hauling_hauler'] = json_encode(array_values($jarak_hauling_hauler));
            $data['waktu_antri_hauler'] = json_encode(array_values($waktu_antri_hauler));
            $data['meninggalkan_front_hauler'] = json_encode(array_values($meninggalkan_front_hauler));
            $data['cycle_timer_hauler'] = json_encode(array_values($cycle_timer_hauler));
            $data['jumlah_bucket_hauler'] = json_encode(array_values($jumlah_bucket_hauler));

            $data['no_loader'] = json_encode(array_values($no_loader));
            $data['jenis_material_loader'] = json_encode(array_values($jenis_material_loader));
            $data['nomor_cmtdt_loader'] = json_encode(array_values($nomor_cmtdt_loader));
            $data['digging_loader'] = json_encode(array_values($digging_loader));
            $data['swing_isi_loader'] = json_encode(array_values($swing_isi_loader));
            $data['load_loader'] = json_encode(array_values($load_loader));
            $data['swing_kosong_loader'] = json_encode(array_values($swing_kosong_loader));
            $data['total_pengisian_loader'] = json_encode(array_values($total_pengisian_loader));
            $data['durasi_loader'] = json_encode(array_values($durasi_loader));
            $data['reason_loader'] = json_encode(array_values($reason_loader));

            $data['no_dozer'] = json_encode(array_values($no_dozer));
            $data['dozing_dozer'] = json_encode(array_values($dozing_dozer));
            $data['reverse_dozer'] = json_encode(array_values($reverse_dozer));
            $data['gear_shifting_dozer'] = json_encode(array_values($gear_shifting_dozer));
            $data['total_dozer'] = json_encode(array_values($total_dozer));
            $data['cm_dozer'] = json_encode(array_values($cm_dozer));
            $data['jarak_dozer'] = json_encode(array_values($jarak_dozer));
            $data['durasi_dozer'] = json_encode(array_values($durasi_dozer));
            $data['reason_dozer'] = json_encode(array_values($reason_dozer));

            $id = DB::table('prod_kalibrasi_ct')->insertGetId($data);

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil disimpan',
                'id' => $id
            ]);
        } catch (\Exception $e) {
            Log::error('Error in Store: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to save record: ' . $e->getMessage()
            ], 500);
        }
    }

    public function UpdateKalibrasi(Request $request, $id)
    {
        try {
            $data = [
                'doc_number' => $this->generateDocNumber(),
                'nama_operator_loader_hauler' => $request->nama_operator_loader_hauler,
                'nomor_exca_hauler' => $request->nomor_exca_hauler,
                'nama_disposal_hauler' => $request->nama_disposal_hauler,
                'jumlah_hauler_digunakan_hauler' => $request->jumlah_hauler_digunakan_hauler,
                'tanggal_hauler' => $request->tanggal_hauler,
                'shift_hauler' => $request->shift_hauler,
                'alat_support_hauler' => $request->alat_support_hauler,
                'material_hauler' => $request->material_hauler,
                'tanggal_loader' => $request->tanggal_loader,
                'shift_loader' => $request->shift_loader,
                'nama_operator_loader' => $request->nama_operator_loader,
                'nomor_exca_loader' => $request->nomor_exca_loader,
                'lokasi_loader' => $request->lokasi_loader,
                'jumlah_hauler_digunakan_loader' => $request->jumlah_hauler_digunakan_loader,
                'jarak_hauling_loader' => $request->jarak_hauling_loader,
                'kondisi_front_loader' => $request->kondisi_front_loader,
                'alat_support_loader' => $request->alat_support_loader,
                'cuaca_loader' => $request->cuaca_loader,
                'rata_rata_loader' => count($request->durasi_loader) > 0 ? array_sum($request->durasi_loader) / count($request->durasi_loader) : 0,
                'tanggal_dozer' => $request->tanggal_dozer,
                'shift_dozer' => $request->shift_dozer,
                'nama_operator_dozer' => $request->nama_operator_dozer,
                'nomor_lambung_dozer' => $request->nomor_lambung_dozer,
                'lokasi_dozing_dozer' => $request->lokasi_dozing_dozer,
                'material_dozer' => $request->material_dozer,
                'jarak_dozing_dozer' => $request->jarak_dozing_dozer,
                'kondisi_area_kerja_dozer' => $request->kondisi_area_kerja_dozer,
                'alat_support_dozer' => $request->alat_support_dozer,
                'cuaca_dozer' => $request->cuaca_dozer,
            ];

            // Initialize arrays for multiple entries
            $ket_front_hauler = [];
            $ket_jalan_hauler = [];
            $ket_grade_hauler = [];
            $ket_disposal_hauler = [];
            $no_loader_hauler = [];
            $nomor_dtht_hauler = [];
            $nama_operator_hauler = [];
            $jarak_hauling_hauler = [];
            $waktu_antri_hauler = [];
            $meninggalkan_front_hauler = [];
            $cycle_timer_hauler = [];
            $jumlah_bucket_hauler = [];

            $no_loader = [];
            $jenis_material_loader = [];
            $nomor_cmtdt_loader = [];
            $digging_loader = [];
            $swing_isi_loader = [];
            $load_loader = [];
            $swing_kosong_loader = [];
            $total_pengisian_loader = [];
            $durasi_loader = [];
            $reason_loader = [];

            $no_dozer = [];
            $dozing_dozer = [];
            $reverse_dozer = [];
            $gear_shifting_dozer = [];
            $total_dozer = [];
            $cm_dozer = [];
            $jarak_dozer = [];
            $durasi_dozer = [];
            $reason_dozer = [];

            // Collect data for each row (10 rows)
            for ($i = 1; $i <= 3; $i++) {
                $ket_front_hauler = $request->input("ket_front_hauler_$i");
                $ket_jalan_hauler = $request->input("ket_jalan_hauler_$i");
                $ket_grade_hauler = $request->input("ket_grade_hauler_$i");
                $ket_disposal_hauler = $request->input("ket_disposal_hauler_$i");
                $no_loader_hauler = $request->input("no_loader_hauler_$i");
                // Only add to arrays if at least one field is filled
                if (
                    $ket_front_hauler || $ket_jalan_hauler || $ket_grade_hauler || $ket_disposal_hauler
                ) {
                    $ket_front_hauler[] = $ket_front_hauler;
                    $ket_jalan_hauler[] = $ket_jalan_hauler;
                    $ket_grade_hauler[] = $ket_grade_hauler;
                    $ket_disposal_hauler[] = $ket_disposal_hauler;
                    $no_loader_hauler[] = $no_loader_hauler;
                }
            }
            for ($i = 1; $i <= 15; $i++) {
                $nomor_dtht_hauler = $request->input("nomor_dtht_hauler_$i");
                $nama_operator_hauler = $request->input("nama_operator_hauler_$i");
                $jarak_hauling_hauler = $request->input("jarak_hauling_hauler_$i");
                $waktu_antri_hauler = $request->input("waktu_antri_hauler_$i");
                $meninggalkan_front_hauler = $request->input("meninggalkan_front_hauler_$i");
                $jumlah_bucket_hauler = $request->input("jumlah_bucket_hauler_$i");
                $$cycle_timer_hauler = $request->input("cycle_timer_hauler_$i");
                // Only add to arrays if at least one field is filled
                if (
                    $nomor_dtht_hauler || $nama_operator_hauler || $jarak_hauling_hauler || $waktu_antri_hauler || $meninggalkan_front_hauler || $cycle_timer_hauler || $jumlah_bucket_hauler
                ) {
                    $nomor_dtht_hauler[] = $nomor_dtht_hauler;
                    $nama_operator_hauler[] = $nama_operator_hauler;
                    $jarak_hauling_hauler[] = $jarak_hauling_hauler;
                    $waktu_antri_hauler[] = $waktu_antri_hauler;
                    $meninggalkan_front_hauler[] = $meninggalkan_front_hauler;
                    $cycle_timer_hauler[] = $cycle_timer_hauler;
                    $jumlah_bucket_hauler[] = $jumlah_bucket_hauler;
                }
            }
            for ($i = 1; $i <= 18; $i++) {
                $no_loader = $request->input("no_loader_$i");
                $jenis_material_loader = $request->input("jenis_material_loader_$i");
                $nomor_cmtdt_loader = $request->input("nomor_cmtdt_loader_$i");
                $digging_loader = $request->input("digging_loader_$i");
                $swing_isi_loader = $request->input("swing_isi_loader_$i");
                $load_loader = $request->input("load_loader_$i");
                $swing_kosong_loader = $request->input("swing_kosong_loader_$i");
                $durasi_loader = $request->input("durasi_loader_$i");
                $reason_loader = $request->input("reason_loader_$i");
                $total_pengisian_loader = $digging_loader + $swing_isi_loader + $load_loader + $swing_kosong_loader;
                // Only add to arrays if at least one field is filled
                if (
                    $no_loader || $jenis_material_loader || $nomor_cmtdt_loader || $digging_loader || $swing_isi_loader ||
                    $load_loader || $swing_kosong_loader || $total_pengisian_loader || $durasi_loader || $reason_loader
                ) {
                    $no_loader[] = $no_loader;
                    $jenis_material_loader[] = $jenis_material_loader;
                    $nomor_cmtdt_loader[] = $nomor_cmtdt_loader;
                    $digging_loader[] = $digging_loader;
                    $swing_isi_loader[] = $swing_isi_loader;
                    $load_loader[] = $load_loader;
                    $swing_kosong_loader[] = $swing_kosong_loader;
                    $total_pengisian_loader[] = $total_pengisian_loader;
                    $durasi_loader[] = $durasi_loader;
                    $reason_loader[] = $reason_loader;
                }
            }
            for ($i = 1; $i <= 22; $i++) {
                $no_dozer = $request->input("no_dozer_$i");
                $dozing_dozer = $request->input("dozing_dozer_$i");
                $reverse_dozer = $request->input("reverse_dozer_$i");
                $gear_shifting_dozer = $request->input("gear_shifting_dozer_$i");
                $cm_dozer = $request->input("cm_dozer_$i");
                $jarak_dozer = $request->input("jarak_dozer_$i");
                $durasi_dozer = $request->input("durasi_dozer_$i");
                $reason_dozer  = $request->input("reason_dozer _$i");
                $total_dozer = $dozing_dozer + $reverse_dozer + $gear_shifting_dozer;
                // Only add to arrays if at least one field is filled
                if (
                    $no_dozer || $dozing_dozer || $reverse_dozer || $gear_shifting_dozer || $total_dozer ||
                    $cm_dozer || $jarak_dozer || $durasi_dozer || $reason_dozer
                ) {
                    $no_dozer[] = $no_dozer;
                    $dozing_dozer[] = $dozing_dozer;
                    $reverse_dozer[] = $reverse_dozer;
                    $gear_shifting_dozer[] = $gear_shifting_dozer;
                    $total_dozer[] = $total_dozer;
                    $cm_dozer[] = $cm_dozer;
                    $jarak_dozer[] = $jarak_dozer;
                    $durasi_dozer[] = $durasi_dozer;
                    $reason_dozer[] = $reason_dozer;
                }
            }
            // Add arrays to data
            $data['ket_front_hauler'] = json_encode($ket_front_hauler);
            $data['ket_jalan_hauler'] = json_encode($ket_jalan_hauler);
            $data['ket_grade_hauler'] = json_encode($ket_grade_hauler);
            $data['ket_disposal_hauler'] = json_encode($ket_disposal_hauler);
            $data['no_loader_hauler'] = json_encode($no_loader_hauler);
            $data['nomor_dtht_hauler'] = json_encode($nomor_dtht_hauler);
            $data['nama_operator_hauler'] = json_encode($nama_operator_hauler);
            $data['jarak_hauling_hauler'] = json_encode($jarak_hauling_hauler);
            $data['waktu_antri_hauler'] = json_encode($waktu_antri_hauler);
            $data['meninggalkan_front_hauler'] = json_encode($meninggalkan_front_hauler);
            $data['cycle_timer_hauler'] = json_encode($cycle_timer_hauler);
            $data['jumlah_bucket_hauler'] = json_encode($jumlah_bucket_hauler);
            $data['no_loader'] = json_encode($no_loader);
            $data['jenis_material_loader'] = json_encode($jenis_material_loader);
            $data['nomor_cmtdt_loader'] = json_encode($nomor_cmtdt_loader);
            $data['digging_loader'] = json_encode($digging_loader);
            $data['swing_isi_loader'] = json_encode($swing_isi_loader);
            $data['load_loader'] = json_encode($load_loader);
            $data['swing_kosong_loader'] = json_encode($swing_kosong_loader);
            $data['total_pengisian_loader'] = json_encode($total_pengisian_loader);
            $data['durasi_loader'] = json_encode($durasi_loader);
            $data['reason_loader'] = json_encode($reason_loader);
            $data['no_dozer'] = json_encode($no_dozer);
            $data['dozing_dozer'] = json_encode($dozing_dozer);
            $data['reverse_dozer'] = json_encode($reverse_dozer);
            $data['gear_shifting_dozer'] = json_encode($gear_shifting_dozer);
            $data['total_dozer'] = json_encode($total_dozer);
            $data['cm_dozer'] = json_encode($cm_dozer);
            $data['jarak_dozer'] = json_encode($jarak_dozer);
            $data['durasi_dozer'] = json_encode($durasi_dozer);
            $data['reason_dozer'] = json_encode($reason_dozer);

            DB::table('prod_kalibrasi_ct')
                ->where('id', $id)
                ->update($data);

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil diperbarui'
            ]);
        } catch (\Exception $e) {
            Log::error('Error in Update: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to update record: ' . $e->getMessage()
            ], 500);
        }
    }

    public function ExportForm($id)
    {
        try {
            $record = DB::table('prod_kalibrasi_ct')
                ->where('id', $id)
                ->first();

            if (!$record) {
                return redirect()
                    ->route('prod.kalibrasi-ct.dashboard')
                    ->with('error', 'Data tidak ditemukan');
            }

            // Helper function to safely decode JSON
            $safeJsonDecode = function ($value) {
                if (is_string($value)) {
                    return json_decode($value);
                } elseif (is_array($value)) {
                    return $value;
                }
                return null;
            };

            // Decode JSON arrays safely
            $record->ket_front_hauler = $safeJsonDecode($record->ket_front_hauler);
            $record->ket_jalan_hauler = $safeJsonDecode($record->ket_jalan_hauler);
            $record->ket_grade_hauler = $safeJsonDecode($record->ket_grade_hauler);
            $record->ket_disposal_hauler = $safeJsonDecode($record->ket_disposal_hauler);
            $record->no_loader_hauler = $safeJsonDecode($record->no_loader_hauler);
            $record->nomor_dtht_hauler = $safeJsonDecode($record->nomor_dtht_hauler);
            $record->nama_operator_hauler = $safeJsonDecode($record->nama_operator_hauler);
            $record->jarak_hauling_hauler = $safeJsonDecode($record->jarak_hauling_hauler);
            $record->waktu_antri_hauler = $safeJsonDecode($record->waktu_antri_hauler);
            $record->meninggalkan_front_hauler = $safeJsonDecode($record->meninggalkan_front_hauler);
            $record->cycle_timer_hauler = $safeJsonDecode($record->cycle_timer_hauler);
            $record->jumlah_bucket_hauler = $safeJsonDecode($record->jumlah_bucket_hauler);
            $record->no_loader = $safeJsonDecode($record->no_loader);
            $record->jenis_material_loader = $safeJsonDecode($record->jenis_material_loader);
            $record->nomor_cmtdt_loader = $safeJsonDecode($record->nomor_cmtdt_loader);
            $record->digging_loader = $safeJsonDecode($record->digging_loader);
            $record->swing_isi_loader = $safeJsonDecode($record->swing_isi_loader);
            $record->load_loader = $safeJsonDecode($record->load_loader);
            $record->swing_kosong_loader = $safeJsonDecode($record->swing_kosong_loader);
            $record->total_pengisian_loader = $safeJsonDecode($record->total_pengisian_loader);
            $record->durasi_loader = $safeJsonDecode($record->durasi_loader);
            $record->reason_loader = $safeJsonDecode($record->reason_loader);
            $record->no_dozer = $safeJsonDecode($record->no_dozer);
            $record->dozing_dozer = $safeJsonDecode($record->dozing_dozer);
            $record->reverse_dozer = $safeJsonDecode($record->reverse_dozer);
            $record->gear_shifting_dozer = $safeJsonDecode($record->gear_shifting_dozer);
            $record->total_dozer = $safeJsonDecode($record->total_dozer);
            $record->cm_dozer = $safeJsonDecode($record->cm_dozer);
            $record->jarak_dozer = $safeJsonDecode($record->jarak_dozer);
            $record->durasi_dozer = $safeJsonDecode($record->durasi_dozer);
            $record->reason_dozer = $safeJsonDecode($record->reason_dozer);

            $validValues = array_filter($record->total_pengisian_loader, function ($val) {
                return is_numeric($val) && $val > 0; // Hanya angka valid (> 0) yang dihitung
            });

            $total = count($validValues) > 0 ? array_sum($validValues) / count($validValues) : 0;



            $pdf = PDF::loadView('smartform::production.kalibrasi_ct.export-pdf', compact('record','total'));
            $pdf->setPaper('a4', 'landscape');

            return $pdf->download('Kalibrasi CT_' . $record->doc_number . '.pdf');
        } catch (\Exception $e) {
            // Log::error('Error in ExportForm: ' . $e->getMessage());
            // return redirect()
            //     ->route('prod.kalibrasi-ct.dashboard')
            //     ->with('error', 'Failed to generate PDF: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    private function generateDocNumber()
    {
        $today = Carbon::now();

        // Initialize count
        $count = DB::table('prod_kalibrasi_ct')
            ->whereYear('created_at', $today->year)
            ->whereMonth('created_at', $today->month)
            ->count();

        $docNumber = '';

        do {
            $count++;

            $docNumber = sprintf(
                'BSS-FRM-KAL-045-%s%s-%03d',
                $today->format('y'),
                $today->format('m'),
                $count
            );

            $exists = DB::table('prod_kalibrasi_ct')
                ->where('doc_number', $docNumber)
                ->exists();
        } while ($exists);
        return $docNumber;
    }

    public function showPDF()
    {
    }
}
