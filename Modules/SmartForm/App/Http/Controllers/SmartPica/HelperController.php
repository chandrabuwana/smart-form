<?php

namespace Modules\SmartForm\App\Http\Controllers\SmartPica;

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
        $query = "  WITH dataProgress AS (
                        SELECT
                            id_solution,
                            nodocpica,
                            TRY_CAST(progress AS INT) AS progress,
                            ROW_NUMBER() OVER (PARTITION BY id_solution, nodocpica ORDER BY TRY_CAST(progress AS INT) DESC) AS rn
                        FROM
                            history_progress_solution
                    )
                    SELECT
                        step_pica.nodocpica,
                        step_pica.id_master,
                        ISNULL(dp.progress, 0) AS progress,
                        UPPER(CASE
                            WHEN ISNULL(dp.progress, 0) = 0 THEN 'NOT YET'
                            WHEN ISNULL(dp.progress, 0) > 0 AND ISNULL(dp.progress, 0) < ISNULL(mp.target_master, 0) THEN 'ON PROGRESS'
                            WHEN ISNULL(dp.progress, 0) = ISNULL(mp.target_master, 0) THEN 'CLOSE'
                            ELSE 'NOT YET'
                        END) AS status,
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
                        step_pica.identity_why,
                        acceptance,
                        acceptance_reason,
                        mp.target_master
                    FROM
                        new_pica_step step_pica
                    LEFT JOIN
                        dataProgress dp ON dp.id_solution = step_pica.id
                            AND dp.nodocpica = step_pica.nodocpica
                            AND dp.rn = 1
                    JOIN master_pica mp ON mp.nodocpica = step_pica.nodocpica where step_pica.pic = '$nik' ";
        $countDataUser = DB::select("select count(*) jumlah FROM new_pica_step where pic = '$nik' ");
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

    function HelperDataTableApprovementStepPica(Request $table)
    {

        $userID = session("user_id");
        $dept = session("kode_department");
        $query = "WITH CTE AS (
                    SELECT
                        step_pica.nodocpica,
                        step_pica.id_master,
                        step_pica.nik_master,
                        step_pica.id,
                        CASE 
                            WHEN step_pica.identity_why = 1 THEN (SELECT TOP 1 why FROM pica_why1 WHERE id = step_pica.position_why)
                            WHEN step_pica.identity_why = 2 THEN (SELECT TOP 1 why FROM pica_why2 WHERE id = step_pica.position_why)
                            WHEN step_pica.identity_why = 3 THEN (SELECT TOP 1 why FROM pica_why3 WHERE id = step_pica.position_why)
                            WHEN step_pica.identity_why = 4 THEN (SELECT TOP 1 why FROM pica_why4 WHERE id = step_pica.position_why)
                            WHEN step_pica.identity_why = 5 THEN (SELECT TOP 1 why FROM pica_why5 WHERE id = step_pica.position_why)
                            ELSE NULL
                        END AS why,
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
                        step_pica.identity_why,
                        step_pica.acceptance, 
                        step_pica.dic,
                        step_pica.status_approve,
                        level_approval,
                        -- Mencari approver berdasarkan level yang lebih tinggi (angka lebih kecil)
                        CASE 
                            WHEN step_pica.level_approval = 1 THEN NULL -- Level 1 adalah level tertinggi, tidak ada level di atasnya
                            WHEN step_pica.level_approval = 2 THEN COALESCE(
                                (SELECT TOP 1 lvl.Nik 
                                FROM USR_LVL lvl 
                                JOIN HRD.dbo.TKaryawan tk ON lvl.Nik = tk.NIK 
                                WHERE tk.KodeDP = step_pica.dic AND lvl.lvl = 1), NULL)
                            WHEN step_pica.level_approval = 3 THEN COALESCE(
                                (SELECT TOP 1 lvl.Nik 
                                FROM USR_LVL lvl 
                                JOIN HRD.dbo.TKaryawan tk ON lvl.Nik = tk.NIK 
                                WHERE tk.KodeDP = step_pica.dic AND lvl.lvl = 1), 
                                (SELECT TOP 1 lvl.Nik 
                                FROM USR_LVL lvl 
                                JOIN HRD.dbo.TKaryawan tk ON lvl.Nik = tk.NIK 
                                WHERE tk.KodeDP = step_pica.dic AND lvl.lvl = 2), NULL)
                            WHEN step_pica.level_approval = 4 THEN COALESCE(
                                (SELECT TOP 1 lvl.Nik 
                                FROM USR_LVL lvl 
                                JOIN HRD.dbo.TKaryawan tk ON lvl.Nik = tk.NIK 
                                WHERE tk.KodeDP = step_pica.dic AND lvl.lvl = 3), 
                                (SELECT TOP 1 lvl.Nik 
                                FROM USR_LVL lvl 
                                JOIN HRD.dbo.TKaryawan tk ON lvl.Nik = tk.NIK 
                                WHERE tk.KodeDP = step_pica.dic AND lvl.lvl = 2), 
                                (SELECT TOP 1 lvl.Nik 
                                FROM USR_LVL lvl 
                                JOIN HRD.dbo.TKaryawan tk ON lvl.Nik = tk.NIK 
                                WHERE tk.KodeDP = step_pica.dic AND lvl.lvl = 1), NULL)
                            WHEN step_pica.level_approval = 5 THEN COALESCE(
                                (SELECT TOP 1 lvl.Nik 
                                FROM USR_LVL lvl 
                                JOIN HRD.dbo.TKaryawan tk ON lvl.Nik = tk.NIK 
                                WHERE tk.KodeDP = step_pica.dic AND lvl.lvl = 4), 
                                (SELECT TOP 1 lvl.Nik 
                                FROM USR_LVL lvl 
                                JOIN HRD.dbo.TKaryawan tk ON lvl.Nik = tk.NIK 
                                WHERE tk.KodeDP = step_pica.dic AND lvl.lvl = 3), 
                                (SELECT TOP 1 lvl.Nik 
                                FROM USR_LVL lvl 
                                JOIN HRD.dbo.TKaryawan tk ON lvl.Nik = tk.NIK 
                                WHERE tk.KodeDP = step_pica.dic AND lvl.lvl = 2), 
                                (SELECT TOP 1 lvl.Nik 
                                FROM USR_LVL lvl 
                                JOIN HRD.dbo.TKaryawan tk ON lvl.Nik = tk.NIK 
                                WHERE tk.KodeDP = step_pica.dic AND lvl.lvl = 1), NULL)
                            ELSE NULL
                        END AS approver
                    FROM
                        new_pica_step step_pica
                )
                SELECT * 
                FROM CTE where acceptance = 9 and dic = '$dept' and approver = '$userID' ";
        $countDataUser = DB::select("select count(*) jumlah FROM new_pica_step where dic = '$dept'");
        $newQuery = $this->GetQueryDataTablePica($query, $table);
        $dataUser = DB::select($newQuery);

        return response()->json([
            'total' => $countDataUser[0]->jumlah,
            'totalNotFiltered' => $countDataUser[0]->jumlah,
            "rows" => $dataUser,
        ]);


    }



}
