<?php

namespace Modules\SmartForm\App\Http\Controllers\GS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\SmartForm\helpers\HrdHelper;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;

class InspeksiToiletMessKantorController extends Controller
{
    function Dashboard(Request $request) {
        return view("SmartForm::GS/inspeksi-toilet-mess-kantor/dashboard");
    }

    public function createForm(Request $request) {

        $questions = DB::table('GS_Inspeksi_TMK_pertanyaan')
            ->select('ID', 'category', 'pertanyaan', 'urutan_pertanyaan')
            ->orderByRaw("
            CASE
                WHEN category = 'TOILET' THEN 1
                WHEN category = 'MESS' THEN 2
                WHEN category = 'KANTOR' THEN 3
                ELSE 4
            END")
            ->orderBy('urutan_pertanyaan')
            ->get()
            ->groupBy('category');

        $dropdowns = [
            'Diinspeksi' => 'Diinspeksi Oleh',
            'DiinspeksiUlang' => 'Diinspeksi Ulang Oleh',
            'Mengetahui' => 'Mengetahui'
        ];

        return view("SmartForm::GS/inspeksi-toilet-mess-kantor/form-create", [
            'questions' => $questions,
            'approvalList' => HrdHelper::getApprovalList(),
            'dropdowns' => $dropdowns
        ]);

    }

    public function storeForm(Request $request) {

        $request->validate([
            'nama_site' => 'required|string',
            'dept' => 'required|string',
            'shift' => 'required|string',
            'loker' => 'required|string',
            'jml_ins' => 'required|integer',
            'diinspeksi_oleh' => 'required|string',
            'diinspeksi_ulang_oleh' => 'required|string',
            'mengetahui' => 'required|string',
            'pertanyaan_id.*' => 'required|integer',
            'jawaban.*' => 'required|string|in:Ya,Tidak'
        ]);

        DB::beginTransaction();
        try {
            $inspeksi_id = DB::table('gs_inspeksi_tmk_jawaban')->insertGetId([
                'tgl_doc' => $request->tgl_doc,
                'nama_site' => $request->nama_site,
                'dept' => $request->dept,
                'shift' => $request->shift,
                'loker' => $request->loker,
                'jml_ins' => 5,
                'diinspeksi_oleh' => $request->diinspeksi_oleh,
                'diinspeksi_ulang_oleh' => $request->diinspeksi_ulang_oleh,
                'mengetahui' => $request->mengetahui,
                'created_at' => DB::raw('GETDATE()'),
                'updated_at' => DB::raw('GETDATE()')
            ]);
            // dd($inspeksi_id);

            if (!$inspeksi_id) {
                throw new \Exception('Gagal mendapatkan ID inspeksi.');
            }

            Log::info('Inspeksi ID berhasil dibuat', ['inspeksi_id' => $inspeksi_id]);


            $detailData = [];
            foreach ($request->pertanyaan_id as $index => $pertanyaan_id) {

                $detailData[] = [
                    'inspeksi_id' => $inspeksi_id,
                    'pertanyaan_id' => $pertanyaan_id,
                    'jawaban' => $request->jawaban[$index],
                    'resiko' => $request->resiko[$index],
                    'keterangan' => $request->keterangan[$index] ?? null,
                    'category' => $request->category[$index] ?? null,
                    'created_at' => DB::raw('GETDATE()'),
                    'updated_at' => DB::raw('GETDATE()')
                ];
            }

            Log::info('Detail data yang akan dimasukkan', ['detailData' => $detailData]);

            DB::table('gs_inspeksi_tmk_jawaban_detail')->insert($detailData);
            DB::commit();

            // return redirect()->route('dashboard-inpeksi-toilet-mess-kantor')->with('success', 'Data inspeksi berhasil disimpan.');
            return response()->json(['message' => 'Data inspeksi berhasil disimpan!', 'redirect' => route('dashboard-inpeksi-toilet-mess-kantor')]);
            // return response()->json([
            //     'message' => 'Data inspeksi berhasil disimpan!'
            // ], 200);
        } catch (\Exception $e) {
            // dd($e);
            DB::rollBack();
            return back()->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }

    public function list(Request $request) {

        $TABLE_MASTER = "gs_inspeksi_tmk_jawaban";
        $response = array(
            'message' => '',
            'isSuccess' => false
        );
        $sort = $request->query('sort', 'id');
        $order = $request->query('order', 'desc');
        try {
            $master = DB::table($TABLE_MASTER)
                ->select('id', 'nama_site', 'loker', 'dept');

            $master->orderBy($sort, $order);
            $jml = $master->count();
            $document = $master->get();

            $response['message'] = "Ok";
            $response['isSuccess'] = true;
            $response['data'] = [
                'total' => $jml,
                'totalNotFiltered' => $jml,
                'rows' => $document
            ];
        } catch (Exception $ex) {
            dd($ex);
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());

            $response['message'] = $ex->getMessage();
            $response['isSuccess'] = false;
        }
        return response()->json($response);
    }

    public function exportPDF($id) {
        $data = DB::table('gs_inspeksi_tmk_jawaban')
            ->where('id', $id)
            ->first();

        if (!$data) {
            return abort(404, "Data inspeksi tidak ditemukan");
        }

        $pertanyaan = DB::table('gs_inspeksi_tmk_pertanyaan')
            ->join('gs_inspeksi_tmk_jawaban_detail', 'gs_inspeksi_tmk_pertanyaan.ID', '=', 'gs_inspeksi_tmk_jawaban_detail.pertanyaan_id')
            ->where('gs_inspeksi_tmk_jawaban_detail.inspeksi_id', $id)
            ->orderByRaw("CASE
                WHEN gs_inspeksi_tmk_pertanyaan.category = 'TOILET' THEN 1
                WHEN gs_inspeksi_tmk_pertanyaan.category = 'MESS' THEN 2
                WHEN gs_inspeksi_tmk_pertanyaan.category = 'KANTOR' THEN 3
                ELSE 4 END")
            ->orderBy('gs_inspeksi_tmk_pertanyaan.urutan_pertanyaan')
            ->select(
                'gs_inspeksi_tmk_pertanyaan.category',
                'gs_inspeksi_tmk_pertanyaan.pertanyaan',
                'gs_inspeksi_tmk_jawaban_detail.jawaban',
                'gs_inspeksi_tmk_jawaban_detail.resiko',
                'gs_inspeksi_tmk_jawaban_detail.keterangan'
            )
            ->get()
            ->groupBy('category');

        $pdf = PDF::loadView('SmartForm::GS/inspeksi-toilet-mess-kantor/pdf', compact('data', 'pertanyaan'));

        return $pdf->stream('BSS-FRM-GS-ITM.pdf');
    }

}
