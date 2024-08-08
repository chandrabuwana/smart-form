<?php

namespace App\Http\Controllers\IC;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class ICFM05InduksiKaryawanController extends Controller
{
    //

    function IndexDashboard()
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
            //throw $th;
            return response()->json([
                "code" => 500,
                "message" => "Error"
            ]);
        }
    }

}
