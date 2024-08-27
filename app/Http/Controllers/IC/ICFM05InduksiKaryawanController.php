<?php

namespace App\Http\Controllers\IC;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class ICFM05InduksiKaryawanController extends Controller
{
    //

    function indexFormAddInduksiKaryawan()
    {

        $dataPertanyaan = DB::select("select * from REF_IC_05_QUESTIONAIRE");

        $final = [
            'pertanyaan' => $dataPertanyaan,
        ];

        return view("ic/induksi-karyawan/add-form-induksi-karyawan", $final);
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
        return view("ic/induksi-karyawan/dashboard-induksi-karyawan");
    }

    function IndexDetailEditViewFormInduksiKaryawan(string $d)
    {
        $params = explode("=", $d);
        $dataMaster = $result = DB::table('FM_IC_005_BSS_MASTER')
            ->where('nik', $params[0])
            ->where('created_at', $params[1])
            ->first();
        $dataDetail = DB::select("select * from FM_IC_005_BSS_DETAIL where NIK = ? and CREATED = ? and [Group] = ?", [$params[0], $params[1], $dataMaster->Group]);
        $detailPertanyaanTambahan = DB::select("select nik, created, pertanyaan description, mentor nikMateriTambahan,( pertanyaan + ' - ' + mentor) as concat from FM_IC_005_BSS_DETAIL_TAMBAHAN_PERTANYAAN where NIK = ? and CREATED = ? and [Group] = ?", [$params[0], $params[1], $dataMaster->Group]);
        $final = [
            'master' => $dataMaster,
            'detail' => $dataDetail,
            'tambahanPertanyaan' => $detailPertanyaanTambahan
        ];
        return view("ic/induksi-karyawan/detail-edit-form-induksi-karyawan", $final);
    }


}
