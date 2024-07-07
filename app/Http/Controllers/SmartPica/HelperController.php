<?php

namespace App\Http\Controllers\SmartPica;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;

class HelperController extends Controller
{
    //

    function HelperSelect2PicaKPILead(Request $d)
    {
        $data = $d->request->get("query");
        $dataFinal = $this->validateAndSanitizeInput($data);
        $dataKPI = DB::select("SELECT TOP(10) k.lea_id AS id, k.lea_name AS name, UPPER(k.lea_hgb) AS status, k.lea_dept AS dept, s.st_name AS satuan FROM kpi_lea k JOIN satuan s ON s.st_id = k.lea_st WHERE k.lea_id LIKE '%$dataFinal%' OR k.lea_name LIKE '%$dataFinal%' OR UPPER(k.lea_hgb) LIKE '%$dataFinal%' OR k.lea_dept LIKE '%$dataFinal%' OR s.st_name LIKE '%$dataFinal%'");
        $dataJs = [];
        foreach ($dataKPI as $kPI) {
            $dataBaru = [
                'text' => $kPI->name . " Satuan : " . $kPI->satuan . " || HEIGHT is " . ($kPI->status == "G" ? "GOOD" : ($kPI->status == "B" ? "BAD" : " - ")),
                'id' => $kPI->id
            ];
            $dataJs[] = $dataBaru;
        }

        $final = [
            'data' => $dataJs,
        ];


        return json_encode($final);
    }
    function HelperSelect2PicaKDept(Request $d)
    {
        $data = $d->request->get("query");
        $dataFinal = $this->validateAndSanitizeInput($data);
        $dataDepartment = DB::connection('sqlsrv2')->select("select * from tsite where AKTIF = 0 and Nama like '%$dataFinal%' or kodest like '%$dataFinal%'");

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

    function HelperSelect2PicaKaryawanByDept(Request $d)
    {
        $data = $d->request->get("query");
        $depart = $d->request->get("dataDepartment");
        $dataFinal = $this->validateAndSanitizeInput($data);
        $dataDepartment = DB::connection('sqlsrv2')->select("SELECT TOP 5 NIK nomorPunggung, Nama nama  FROM TKaryawan where KodeDP like '%$depart%' and Nama like '%$data%'");

        $dataJs = [];
        foreach ($dataDepartment as $a) {
            $dataBaru = [
                'text' => $a->nama,
                'id' => $a->nomorPunggung
            ];
            $dataJs[] = $dataBaru;
        }
        $final = [
            'data' => $dataJs,
        ];
        return json_encode($final);
    }

    function validateAndSanitizeInput($input)
    {
        // Sanitasi input
        $sanitizedInput = filter_var($input, FILTER_SANITIZE_STRING);

        // Validasi input: Misalnya, hanya menerima huruf, angka, dan spasi
        if (preg_match('/^[a-zA-Z0-9 ]*$/', $sanitizedInput)) {
            return $sanitizedInput;
        } else {
            // Jika input tidak valid, Anda bisa mengembalikan false atau memicu error
            throw new Exception('Input tidak valid');
        }
    }

    function getWeeksInMonth($year, $month)
    {
        $weeks = [];
        $startDate = Carbon::create($year, $month, 1);
        $endDate = $startDate->copy()->endOfMonth();
        $workingDays = [];
        for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
            if ($date->isWeekday()) { // Cek apakah hari kerja (Senin - Jumat)
                $workingDays[] = $date->copy();
            }
        }

        // dd($workingDays);
        foreach ($workingDays as $date) {
            $weekNumber = $date->weekOfYear;
            $weeks[$weekNumber][] = $date->toDateString();
        }
        return $weeks;
    }

    function HelperSelectWeek(Request $d)
    {
        $weeks = $this->getWeeksInMonth($d->request->get("tahun"), $d->request->get("bulan"));
        return json_encode([
            'data' => ['WEEK 1', 'WEEK 2', 'WEEK 3', 'WEEK 4', 'WEEK 5', 'MONTHLY'],
        ]);
    }

    public function GetQueryDataTablePica(string $query, Request $req)
    {

        $dataSort = null;
        $dataSearch = null;
        $dataOrder = null;
        $dataLimit = null;
        $dataOffset = null;

        if (isset($req["sort"]) && $req["sort"] != null) {
            $query = $query . ' ORDER BY ' . $req["sort"] . ' ' . $req["order"];
        } else {
            $query = $query . ' ORDER BY ID DESC ';
        }

        if ($req["offset"] != null) {
            $query = $query . ' OFFSET ' . $req["offset"] . ' ROWS ';
        }
        if ($req["limit"] != null) {
            $query = $query . "FETCH NEXT " . $req["limit"] . " ROWS ONLY";
        }
        return $query;
    }

    function HelperDataTablePica(Request $table)
    {
        $query = "";
        $countDataUser = DB::select('select count(*) jumlah FROM hdr_transaction');
        $newQuery = $this->GetQueryDataTable($query, $table);

        $dataUser = DB::select($newQuery);

        return response()->json([
            'total' => $countDataUser[0]->jumlah,
            'totalNotFiltered' => $countDataUser[0]->jumlah,
            "rows" => $dataUser,
        ]);
    }


}
