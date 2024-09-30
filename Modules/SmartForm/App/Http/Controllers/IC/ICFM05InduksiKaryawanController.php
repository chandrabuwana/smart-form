<?php

namespace Modules\SmartForm\App\Http\Controllers\IC;

use App\Http\Controllers\Controller;
use Cron\MinutesField;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use DB;

class ICFM05InduksiKaryawanController extends Controller
{
    //

    function indexFormAddInduksiKaryawan()
    {
        $link = DB::table("FM_IC_005_BSS_LST_GRP")->select("link", "code")->where("created_by", session("user_id"))->where("expired", ">", now())->first();
        $dataLink = "";
        $dataCode = "";

        if ($link) {
            $dataLink = $link->link;
            $dataCode = $link->code;
        } else {
            $dataLink = "";
            $dataCode = "";
        }
        $dataPertanyaan = DB::select("select * from REF_IC_05_QUESTIONAIRE");

        $final = [
            'pertanyaan' => $dataPertanyaan,
            'link' => $dataLink,
            'code' => $dataCode,
        ];

        // dd($final);

        return view("SmartForm::ic/induksi-karyawan/add-form-induksi-karyawan", $final);
    }

    function downloadPDF(string $id)
    {

        $dataDetail = DB::select("WITH LatestInduksi AS (
            SELECT DI.index_pertanyaan, 
                RFQ.Questionaire, 
                RFQ.QuestionaireGroup, 
                DI.mentor, 
                TK.Nama, 
                DI.created_at,
                ROW_NUMBER() OVER (PARTITION BY DI.index_pertanyaan ORDER BY DI.created_at ASC) AS RowNum
            FROM [FM_IC_005_BSS_LST_KRYWN] LK  
            JOIN [FM_IC_005_BSS_DETAIL_INDUKSI] DI 
                ON LK.code = DI.group_code 
            JOIN [REF_IC_05_QUESTIONAIRE] RFQ 
                ON DI.index_pertanyaan = RFQ.IdQuestionaire
            JOIN HRD.dbo.TKaryawan TK 
                ON TK.NIK = DI.mentor
            WHERE LK.nik = ?
        )
        SELECT * 
        FROM LatestInduksi
        WHERE RowNum = 1;", [$id]);

        $dataDetailKaryawan = DB::table("FM_IC_005_BSS_LST_KRYWN")
            ->select(
                "*",
                DB::raw("CASE 
                        WHEN jenis = '1' THEN 'Karyawan Baru'
                        WHEN jenis = '2' THEN 'Karyawan'
                        WHEN jenis = '3' THEN 'Siswa Magang'
                        WHEN jenis = '4' THEN 'Subkontraktor'
                        ELSE 'Unknown' 
                    END AS jenis_karyawan"),
                DB::raw("FORMAT(created_at, 'dd - MMM - yyyy') AS created_at")
            )
            ->where("nik", $id)
            ->first();

        // dd($dataDetail);

        $dataFinal = [
            'date_now' => now(),
            'detail' => $dataDetail,
            'karyawan' => $dataDetailKaryawan
        ];

        // return view("SmartForm::ic/induksi-karyawan/pdf-induksi-karyawan", $dataFinal);

        $pdf = Pdf::loadview("SmartForm::ic/induksi-karyawan/pdf-induksi-karyawan", $dataFinal)->setOptions(['defaultFont' => 'sans-serif'])->setPaper('a4', 'potrait');
        return $pdf->stream();
    }

    function checkNIKPDF(Request $d)
    {
        try {
            $data = DB::table("FM_IC_005_BSS_LST_KRYWN")->where("nik", $d->nik)->first();
            if ($data) {
                return response()->json([
                    'message' => 'Cetak Karyawan',
                    'code' => 200,
                    'data' => $data->Nama
                ]);
            } else {
                return response()->json([
                    'message' => 'NIK tidak ditemukan',
                    'code' => 500
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Failed to Get Record ',
                'code' => 500
            ]);
        }

    }

    function indexFormAddKaryawanListing(string $data)
    {
        try {
            $datassss = base64_decode($data);
            $array = explode('_', $datassss);
            $check = DB::table("FM_IC_005_BSS_LST_GRP")->where("code", $array[1])->where("expired", ">", now())->first();
            $dataMaster = [
                'code' => $array[1]
            ];
            if ($check) {
                return view("SmartForm::ic/induksi-karyawan/listing-karyawan", $dataMaster);
            } else {
                abort(404, 'Page not found');
            }
        } catch (\Throwable $th) {
            abort(404, 'Page not found');
        }

    }
    function formAddKaryawanListing(Request $d)
    {
        $validatedData = $d->validate([
            'master.nama' => 'required|string|max:255',
            'master.nik' => 'required|string|max:255',
            'master.jabatan' => 'required|string|max:255',
            'master.department' => 'required|string|max:255',
            'master.instansi' => 'required|string|max:255',
            'master.jenisInduksi' => 'required|integer',
            'master.code' => 'required|string|max:255',
        ]);

        try {

            DB::table('FM_IC_005_BSS_LST_KRYWN')->insert([
                'NIK' => $validatedData['master']['nik'],
                'Nama' => $validatedData['master']['nama'],
                'Jabatan' => $validatedData['master']['jabatan'],
                'Department' => $validatedData['master']['department'],
                'Instansi' => $validatedData['master']['instansi'],
                'Jenis' => $validatedData['master']['jenisInduksi'],
                'code' => $validatedData['master']['code'],
                'created_at' => now(),
                'created_by' => "karyawan",
                'updated_at' => null,
                'updated_by' => null
            ]);
            return response()->json([
                'message' => 'Done Induksi Tersimpan',
                'code' => 200
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Failed to insert records:',
                'code' => 500
            ]);
        }
    }

    function formDeletedKaryawanListing(Request $d)
    {

        try {
            DB::table("FM_IC_005_BSS_LST_KRYWN")->where("code", $d->code)->where("nik", $d->nik)->delete();
            return response()->json([
                'message' => 'Done Induksi Tersimpan',
                'code' => 200
            ]);

        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'message' => 'Failed to insert records: ' . $th->getMessage(),
                'code' => 500
            ]);
        }
    }

    function GenerateLinkUrl(Request $r)
    {
        $randomeCode = DB::table('VW_GNRT_CODE_IC_005')->first()->generated_code;
        $dataGenerate = base64_encode(session("user_id") . '_' . $randomeCode);
        $timeNow = Carbon::now();
        $timePlus30Minutes = $timeNow->addMinutes(30);
        $link = "/bss-form/induksi-karyawan/listing-karyawan/" . $dataGenerate;

        try {
            DB::table('FM_IC_005_BSS_LST_GRP')->insert([
                'code' => $randomeCode,
                'link' => $link,
                'site' => $r->site,
                'expired' => $timePlus30Minutes,
                'created_at' => $timeNow,
                'created_by' => session("user_id"),
                'updated_by' => null, // Nilai ini mungkin bisa dikosongkan jika belum diperbarui
                'updated_at' => null // Nilai ini mungkin bisa dikosongkan jika belum diperbarui
            ]);
            return response()->json([
                "code" => 200,
                "data" => $link,
                "codeR" => $randomeCode
            ]);
            // code...
        } catch (\Throwable $th) {
            return response()->json([
                "code" => 500,
                "data" => "Error While Generate Data"
            ]);
        }
    }

    function ActivatedLink(Request $d)
    {
        $timeNow = Carbon::now();
        $timePlus30Minutes = $timeNow->addMinutes(30);
        try {
            //code...
            DB::table("FM_IC_005_BSS_LST_GRP")->where("code", $d->code)->update(['expired' => $timePlus30Minutes]);
            return response()->json([
                "code" => 200,
                "data" => "Done"
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                "code" => 500,
                "data" => "Error While Activate Link"
            ]);
        }
    }

    function dataListPertanyaan()
    {
        try {
            $dataPertanyaan = DB::select("select IdQuestionaire iden, QuestionaireGroup, Questionaire from REF_IC_05_QUESTIONAIRE");
            return response()->json([
                "code" => 200,
                "data" => $dataPertanyaan
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                "code" => 500,
                "message" => "Error"
            ]);
        }
    }

    function dataListPertanyaan2()
    {
        try {
            $dataPertanyaan = DB::select("select IdQuestionaire id, QuestionaireGroup, Questionaire from REF_IC_05_QUESTIONAIRE");
            return response()->json([
                "code" => 200,
                "data" => $dataPertanyaan
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                "code" => 500,
                "message" => "Error"
            ]);
        }
    }

    function IndexDashboard()
    {
        // dd(session()->all());
        return view("SmartForm::ic/induksi-karyawan/dashboard-induksi-karyawan");
    }

    function IndexDetailEditViewFormInduksiKaryawan(string $d)
    {
        $params = explode("=", $d);
        $dataMaster = DB::table('FM_IC_005_BSS_LST_GRP')
            ->where('code', $params[0])
            ->where('created_at', $params[1])
            ->first();
        $dataLinkActive = DB::table('FM_IC_005_BSS_LST_GRP')->select("code")
            ->where('code', $params[0])
            ->where('expired', '<', now())
            ->first();



        $dataListInduksi = DB::table("FM_IC_005_BSS_DETAIL_INDUKSI")->where('group_code', $params[0])->get()->toArray();
        $listDataNotExist = DB::select("SELECT group_code,
            STUFF(
                CONCAT(
                    CASE WHEN MAX(CASE WHEN index_pertanyaan LIKE 'ICGS%' THEN 1 ELSE 0 END) = 0 THEN ', ICGS' ELSE '' END,
                    CASE WHEN MAX(CASE WHEN index_pertanyaan LIKE 'OD%' THEN 1 ELSE 0 END) = 0 THEN ', OD' ELSE '' END,
                    CASE WHEN MAX(CASE WHEN index_pertanyaan LIKE 'DEPT%' THEN 1 ELSE '' END) = 0 THEN ', DEPT' ELSE '' END,
                    CASE WHEN MAX(CASE WHEN index_pertanyaan LIKE 'SHE%' THEN 1 ELSE 0 END) = 0 THEN ', SHE' ELSE '' END
                ), 1, 2, ''
            ) AS missing_categories
        FROM FM_IC_005_BSS_DETAIL_INDUKSI where group_code = ?
        GROUP BY group_code ;", [$params[0]]);

        $detailPertanyaanTambahan = DB::select("select pertanyaan description, mentor nikMateriTambahan,( pertanyaan + ' - ' + mentor) as concat from FM_IC_005_BSS_DETAIL_PERTANYAAN_EXT where group_code = ?", [$params[0]]);
        $final = [
            'code' => $params[0],
            'master' => $dataMaster,
            'activated' => $dataLinkActive,
            'notExist' => collect($listDataNotExist)->first(),
            'detail' => $dataListInduksi,
            'tambahanPertanyaan' => $detailPertanyaanTambahan
        ];
        // dd($final);
        return view("SmartForm::ic/induksi-karyawan/detail-edit-form-induksi-karyawan", $final);
    }


}
