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
        if (isset($req->search['IDSOLUTION']) && $req->search['IDSOLUTION'] != null) {
            $query = $query . "where id_solution = '" . $req->search['IDSOLUTION'] . "' ";
        }
        if (isset($req->search['NODOCPICA']) && $req->search['NODOCPICA'] != null) {
            $query = $query . " AND nodocpica = '" . $req->search['NODOCPICA'] . "' ";
        }

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
        $query = "select nik, nodocpica, CONCAT(FORMAT(DATEFROMPARTS(tahun, bulan, 1), 'MMMM'), ' - ', tahun) AS tahun_bulan, week, site, id_kpi, status, problem, kp_name, lea_name from master_pica m join kategori_problem k
                    on k.kp_id = m.id_kategory join kpi_lea kl on kl.lea_id = m.id_kpi ";
        $countDataUser = DB::select('select count(*) jumlah FROM master_pica');
        $newQuery = $this->GetQueryDataTablePica($query, $table);

        $dataUser = DB::select($newQuery);

        return response()->json([
            'total' => $countDataUser[0]->jumlah,
            'totalNotFiltered' => $countDataUser[0]->jumlah,
            "rows" => $dataUser,
        ]);
    }

    function HelperDataTableStepSolutionPica(Request $table)
    {
        $nik = session("user_id");
        $query = "WITH dataProgress AS (
                    SELECT 
                        id_solution,
                        nodocpica,
                        progress,
                        ROW_NUMBER() OVER (PARTITION BY id_solution, nodocpica ORDER BY progress DESC) AS rn,
                        CASE 
                            WHEN TRY_CAST(
                                    SUBSTRING(progress, 
                                            PATINDEX('%[0-9]%', progress), 
                                            LEN(progress) - PATINDEX('%[0-9]%', progress) + 1
                                    ) AS INT
                                ) = 0 THEN 'not yet'
                            WHEN TRY_CAST(
                                    SUBSTRING(progress, 
                                            PATINDEX('%[0-9]%', progress), 
                                            LEN(progress) - PATINDEX('%[0-9]%', progress) + 1
                                    ) AS INT
                                ) BETWEEN 1 AND 99 THEN 'on progress'
                            WHEN TRY_CAST(
                                    SUBSTRING(progress, 
                                            PATINDEX('%[0-9]%', progress), 
                                            LEN(progress) - PATINDEX('%[0-9]%', progress) + 1
                                    ) AS INT
                                ) = 100 THEN 'close'
                            ELSE 'not yet'
                        END AS status
                    FROM 
                        history_progress_solution
                )
                SELECT 
                    step_pica.nodocpica,
                    step_pica.id_master,
                    ISNULL(dp.progress, '0') AS progress,
                    upper(ISNULL(dp.status, 'not yet')) AS status,
                    step_pica.nik_master,
                    step_pica.id, 
                    CASE 
                        WHEN step_pica.action = 'ca' THEN 'Corrective'
                        WHEN step_pica.action = 'pa' THEN 'Preventive'
                        ELSE step_pica.action 
                    END AS action, 
                    step_pica.note_step, 
                    UPPER(step_pica.ap_tod) AS ap_tod, 
                    step_pica.pic, 
                    step_pica.due_date, 
                    step_pica.position_why, 
                    step_pica.identity_why
                FROM 
                    new_pica_step step_pica
                LEFT JOIN 
                    dataProgress dp ON dp.id_solution = step_pica.id
                        AND dp.nodocpica = step_pica.nodocpica
                        AND dp.rn = 1 where step_pica.pic = '$nik' ";
        $countDataUser = DB::select('select count(*) jumlah FROM new_pica_step');
        $newQuery = $this->GetQueryDataTablePica($query, $table);

        $dataUser = DB::select($newQuery);

        return response()->json([
            'total' => $countDataUser[0]->jumlah,
            'totalNotFiltered' => $countDataUser[0]->jumlah,
            "rows" => $dataUser,
        ]);
    }

    function HelperDataTableHistoryProgressPica(Request $table)
    {
        // dd($table);
        // dd($table->search['IDSOLUTION']);
        $query = " SELECT [id]
                    ,[id_solution]
                    ,[id_master]
                    ,[nik_master]
                    ,[nodocpica]
                    ,[position_why]
                    ,[identity_why]
                    ,[note_progress]
                    ,[ccp]
                    ,[progress]
                    ,[created_at]
                FROM [history_progress_solution] ";
        $countDataUser = DB::select('select count(*) jumlah FROM history_progress_solution');
        $newQuery = $this->GetQueryDataTablePica($query, $table);

        $dataUser = DB::select($newQuery);

        return response()->json([
            'total' => $countDataUser[0]->jumlah,
            'totalNotFiltered' => $countDataUser[0]->jumlah,
            "rows" => $dataUser,
        ]);
    }


}
