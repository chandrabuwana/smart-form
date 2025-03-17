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

class A2bBaruController extends Controller
{

    public function Dashboard(Request $request)
    {
        try {
            $query = DB::table('prod_a2b_baru')
                ->select('*')
                ->orderBy('created_at');

            // Get records with pagination
            $records = $query->paginate(20);

            // Calculate statistics
            $statistics = (object)[
                'total_records' => DB::table('prod_a2b_baru')->count(),
                'total_this_month' => DB::table('prod_a2b_baru')
                    ->whereMonth('created_at', now()->month)
                    ->whereYear('created_at', now()->year)
                    ->count()
            ];

            return view('smartform::production.a2b_baru.dashboard-a2b-baru', [
                'records' => $records,
                'statistics' => $statistics,

            ]);
        } catch (\Exception $e) {
            Log::error('Error in Dashboard: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to load dashboard data: ' . $e->getMessage());
        }
    }

    public function AddFormA2bBaru(Request $request)
    {
        try {
            if ($request->has('id')) {
                $record = DB::table('prod_a2b_baru')
                    ->where('id', $request->id)
                    ->first();

                if (!$record) {
                    Log::error('A2B Baru record not found for ID: ' . $request->id);
                    return redirect()->route('prod.a2b-baru.dashboard')
                        ->with('error', 'Record not found');
                }

                // Parse JSON arrays
                $record->question1 = json_decode($record->question1);
                $record->question2 = json_decode($record->question2);
                $record->question3 = json_decode($record->question3);
                $record->question4 = json_decode($record->question4);
                $record->question5 = json_decode($record->question5);
                $record->question6 = json_decode($record->question6);
                $record->question7 = json_decode($record->question7);
                $record->question8 = json_decode($record->question8);
                $record->question9 = json_decode($record->question9);
                $record->question10 = json_decode($record->question10);
                $record->question11 = json_decode($record->question11);
                $record->question12 = json_decode($record->question12);
                $record->deskripsi  = json_decode($record->deskripsi);


                Log::info('A2B Baru record loaded for ID: ' . $request->id);

                return view('smartform::production.a2b_baru.form-a2b-baru', [
                    'record' => $record,
                    'isShowDetail' => true
                ]);
            }

            return view('smartform::production.a2b_baru.form-a2b-baru', [
                'isShowDetail' => false
            ]);
        } catch (\Exception $e) {
            Log::error('Error in AddForm: ' . $e->getMessage());
            return redirect()->route('prod.a2b-baru.dashboard')
                ->with('error', 'Failed to load form: ' . $e->getMessage());
        }
    }

    public function StoreA2bBaru(Request $request)
    {


        try {
            $data = [
                'doc_number' => $this->generateDocNumber(),
                'nama_operator' => $request->nama_operator,
                'nrp' => $request->nrp,
                'tanggal' => $request->tanggal,
                'shift' => $request->shift,
                'lokasi' => $request->lokasi,
                'type_nounit' => $request->type_nounit,
                'hmawal1' => $request->hmawal1,
                'hmawal2' => $request->hmawal2,
                'hmakhir1' => $request->hmakhir1,
                'hmakhir2' => $request->hmakhir2,
                'catatan_unit' => $request->catatan_unit,
                'catatan_pengawas' => $request->catatan_pengawas,
                'kondisi_tubuh' => $request->kondisi_tubuh,
                'kondisi1' => $request->kondisi1,
                'kondisi2' => $request->kondisi2,
                'kondisi3' => $request->kondisi3,
                'kondisi4' => $request->kondisi4,
                'kondisi_unit' => $request->kondisi_unit,
            ];

            // Initialize arrays for multiple entries
            $question1 = [];
            $question2 = [];
            $question3 = [];
            $question4 = [];
            $question5 = [];
            $question6 = [];
            $question7 = [];
            $question8 = [];
            $question9 = [];
            $question10 = [];
            $question11 = [];
            $question12 = [];
            $deskripsi = [];


            // Collect only filled data for each row
            for ($i = 1; $i <= 15; $i++) {
                $question1t = $request->input("question1_$i") ?? 0;
                $question2t = $request->input("question2_$i") ?? 0;
                $question3t = $request->input("question3_$i") ?? 0;
                $question4t = $request->input("question4_$i") ?? 0;
                $question5t = $request->input("question5_$i") ?? 0;
                $question6t = $request->input("question6_$i") ?? 0;
                $question7t = $request->input("question7_$i") ?? 0;
                $question8t = $request->input("question8_$i") ?? 0;
                $question9t = $request->input("question9_$i") ?? 0;
                $question10t = $request->input("question10_$i") ?? 0;
                $question11t = $request->input("question11_$i") ?? 0;
                $question12t = $request->input("question12_$i") ?? 0;
                $deskripsit = $request->input("deskripsi_$i") ?? '';

                if (
                    $question1t !== null && $question1t !== '' ||
                    $question2t !== null && $question2t !== '' ||
                    $question3t !== null && $question3t !== '' ||
                    $question4t !== null && $question4t !== '' ||
                    $question5t !== null && $question5t !== '' ||
                    $question6t !== null && $question6t !== '' ||
                    $question7t !== null && $question7t !== '' ||
                    $question8t !== null && $question8t !== '' ||
                    $question9t !== null && $question9t !== '' ||
                    $question10t !== null && $question10t !== '' ||
                    $question11t !== null && $question11t !== '' ||
                    $question12t !== null && $question12t !== '' ||
                    $deskripsit !== null && $deskripsit !== '' 

                ) 

                {
                    $question1[] = $question1t;
                    $question2[] = $question2t;
                    $question3[] = $question3t;
                    $question4[] = $question4t;
                    $question5[] = $question5t;
                    $question6[] = $question6t;
                    $question7[] = $question7t;
                    $question8[] = $question8t;
                    $question9[] = $question9t;
                    $question10[] = $question10t;
                    $question11[] = $question11t;
                    $question12[] = $question12t;
                    $deskripsi[] = $deskripsit;
                } else {
                    $question1[] = 0;
                    $question2[] = 0;
                    $question3[] = 0;
                    $question4[] = 0;
                    $question5[] = 0;
                    $question6[] = 0;
                    $question7[] = 0;
                    $question8[] = 0;
                    $question9[] = 0;
                    $question10[] = 0;
                    $question11[] = 0;
                    $question12[] = 0;
                    $deskripsi[] = '';
                }
            }

            // Add arrays to data
            $data['question1'] = json_encode(array_values($question1));
            $data['question2'] = json_encode(array_values($question2));
            $data['question3'] = json_encode(array_values($question3));
            $data['question4'] = json_encode(array_values($question4));
            $data['question5'] = json_encode(array_values($question5));
            $data['question6'] = json_encode(array_values($question6));
            $data['question7'] = json_encode(array_values($question7));
            $data['question8'] = json_encode(array_values($question8));
            $data['question9'] = json_encode(array_values($question9));
            $data['question10'] = json_encode(array_values($question10));
            $data['question11'] = json_encode(array_values($question11));
            $data['question12'] = json_encode(array_values($question12));
            $data['deskripsi'] = json_encode(array_values($deskripsi));

            $id = DB::table('prod_a2b_baru')->insertGetId($data);

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
                'nama_operator' => $request->nama_operator,
                'nrp' => $request->nrp,
                'tanggal' => $request->tanggal,
                'shift' => $request->shift,
                'lokasi' => $request->lokasi,
                'type_nounit' => $request->type_nounit,
                'hmawal1' => $request->hmawal1,
                'hmawal2' => $request->hmawal2,
                'hmakhir1' => $request->hmakhir1,
                'hmakhir2' => $request->hmakhir2,
                'catatan_unit' => $request->catatan_unit,
                'catatan_pengawas' => $request->catatan_pengawas,
                'kondisi_tubuh' => $request->kondisi_tubuh,
                'kondisi1' => $request->kondisi1,
                'kondisi2' => $request->kondisi2,
                'kondisi3' => $request->kondisi3,
                'kondisi4' => $request->kondisi4,
                'kondisi_unit' => $request->kondisi_unit,
            ];

            // Initialize arrays for multiple entries
            $question1 = [];
            $question2 = [];
            $question3 = [];
            $question4 = [];
            $question5 = [];
            $question6 = [];
            $question7 = [];
            $question8 = [];
            $question9 = [];
            $question10 = [];
            $question11 = [];
            $question12 = [];
            $deskripsi = [];

            // Collect data for each row (10 rows)
            for ($i = 1; $i <= 15; $i++) {
                $question1t = $request->input("question1_$i") ?? 0;
                $question2t = $request->input("question2_$i") ?? 0;
                $question3t = $request->input("question3_$i") ?? 0;
                $question4t = $request->input("question4_$i") ?? 0;
                $question5t = $request->input("question5_$i") ?? 0;
                $question6t = $request->input("question6_$i") ?? 0;
                $question7t = $request->input("question7_$i") ?? 0;
                $question8t = $request->input("question8_$i") ?? 0;
                $question9t = $request->input("question9_$i") ?? 0;
                $question10t = $request->input("question10_$i") ?? 0;
                $question11t = $request->input("question11_$i") ?? 0;
                $question12t = $request->input("question12_$i") ?? 0;
                $deskripsit = $request->input("deskripsi_$i") ?? '';

                if (
                    $question1t !== null && $question1t !== '' ||
                    $question2t !== null && $question2t !== '' ||
                    $question3t !== null && $question3t !== '' ||
                    $question4t !== null && $question4t !== '' ||
                    $question5t !== null && $question5t !== '' ||
                    $question6t !== null && $question6t !== '' ||
                    $question7t !== null && $question7t !== '' ||
                    $question8t !== null && $question8t !== '' ||
                    $question9t !== null && $question9t !== '' ||
                    $question10t !== null && $question10t !== '' ||
                    $question11t !== null && $question11t !== '' ||
                    $question12t !== null && $question12t !== '' ||
                    $deskripsit !== null && $deskripsit !== ''

                ) {
                    $question1[] = $question1t;
                    $question2[] = $question2t;
                    $question3[] = $question3t;
                    $question4[] = $question4t;
                    $question5[] = $question5t;
                    $question6[] = $question6t;
                    $question7[] = $question7t;
                    $question8[] = $question8t;
                    $question9[] = $question9t;
                    $question10[] = $question10t;
                    $question11[] = $question11t;
                    $question12[] = $question12t;
                    $deskripsi[] = $deskripsit;
                } else {
                    $question1[] = 0;
                    $question2[] = 0;
                    $question3[] = 0;
                    $question4[] = 0;
                    $question5[] = 0;
                    $question6[] = 0;
                    $question7[] = 0;
                    $question8[] = 0;
                    $question9[] = 0;
                    $question10[] = 0;
                    $question11[] = 0;
                    $question12[] = 0;
                    $deskripsi[] = '';
                }
            }
            // Add arrays to data
            $data['question1'] = json_encode(array_values($question1));
            $data['question2'] = json_encode(array_values($question2));
            $data['question3'] = json_encode(array_values($question3));
            $data['question4'] = json_encode(array_values($question4));
            $data['question5'] = json_encode(array_values($question5));
            $data['question6'] = json_encode(array_values($question6));
            $data['question7'] = json_encode(array_values($question7));
            $data['question8'] = json_encode(array_values($question8));
            $data['question9'] = json_encode(array_values($question9));
            $data['question10'] = json_encode(array_values($question10));
            $data['question11'] = json_encode(array_values($question11));
            $data['question12'] = json_encode(array_values($question12));
            $data['deskripsi'] = json_encode(array_values($deskripsi));

            DB::table('prod_a2b_baru')
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

    public function destroy($id)
    {
        try {
            // Cari data berdasarkan ID
            $record = DB::table('prod_a2b_baru')->where('id', $id)->first();

            if (!$record) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data tidak ditemukan'
                ], 404);
            }

            // Hapus data
            DB::table('prod_a2b_baru')->where('id', $id)->delete();

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            Log::error('Error in Delete: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus data: ' . $e->getMessage()
            ], 500);
        }
    }

    public function ExportForm($id)
    {
        try {
            $record = DB::table('prod_a2b_baru')
                ->where('id', $id)
                ->first();

            if (!$record) {
                return redirect()
                    ->route('prod.a2b-baru.dashboard')
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
            $record->question1 = $safeJsonDecode($record->question1);
            $record->question2 = $safeJsonDecode($record->question2);
            $record->question3 = $safeJsonDecode($record->question3);
            $record->question4 = $safeJsonDecode($record->question4);
            $record->question5 = $safeJsonDecode($record->question5);
            $record->question6 = $safeJsonDecode($record->question6);
            $record->question7 = $safeJsonDecode($record->question7);
            $record->question8 = $safeJsonDecode($record->question8);
            $record->question9 = $safeJsonDecode($record->question9);
            $record->question10 = $safeJsonDecode($record->question10);
            $record->question11 = $safeJsonDecode($record->question11);
            $record->question12 = $safeJsonDecode($record->question12);
            $record->deskripsi = $safeJsonDecode($record->deskripsi);

            $pdf = PDF::loadView('smartform::production.a2b_baru.export-pdf', compact('record'));
            $pdf->setPaper('a4', 'landscape');

            return $pdf->download('FORM A2B BARU_' . $record->doc_number . '.pdf');
        } catch (\Exception $e) {
            Log::error('Error in ExportForm: ' . $e->getMessage());
            return redirect()
                ->route('prod.a2b-baru.dashboard')
                ->with('error', 'Failed to generate PDF: ' . $e->getMessage());
        }
    }

    private function generateDocNumber()
    {
        $today = Carbon::now();

        // Initialize count
        $count = DB::table('prod_a2b_baru')
            ->whereYear('created_at', $today->year)
            ->whereMonth('created_at', $today->month)
            ->count();

        $docNumber = '';

        do {
            $count++;

            $docNumber = sprintf(
                'BSS-FRM-A2B-%s%s-%03d',
                $today->format('y'),
                $today->format('m'),
                $count
            );

            $exists = DB::table('prod_a2b_baru')
                ->where('doc_number', $docNumber)
                ->exists();
        } while ($exists);
        return $docNumber;
    }

    public function showPDF() {}
}
