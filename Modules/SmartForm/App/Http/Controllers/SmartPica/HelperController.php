<?php

namespace Modules\SmartForm\App\Http\Controllers\SmartPica;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use Hash;

class HelperController extends Controller
{
    //

    function HelperSelect2PicaKPILead(Request $d)
    {
        $data = $d->request->get("query");
        // dd($d->dept);

        $dataDepartment = "";

        $dataFinal = $this->validateAndSanitizeInput($data);


        $query = "SELECT kpi_code id, kpi name, dept, keterangan FROM [SMF_KPI_MASTER] where 
        (kpi_code LIKE '%$dataFinal%' 
        OR kpi LIKE '%$dataFinal%' 
        OR keterangan LIKE '%$dataFinal%') ";

        if ($d->dept == "HRD") {
            $query .= " AND dept in ('IC','GS','CVL')";
        } else {
            $query .= " AND dept = '$d->dept' ";
        }

        // $dataKPI = DB::select("SELECT TOP(10) k.lea_id AS id, k.lea_name AS name, UPPER(k.lea_hgb) AS status, k.lea_dept AS dept, s.st_name AS satuan FROM kpi_lea k JOIN satuan s ON s.st_id = k.lea_st WHERE k.lea_id LIKE '%$dataFinal%' OR k.lea_name LIKE '%$dataFinal%' OR UPPER(k.lea_hgb) LIKE '%$dataFinal%' OR k.lea_dept LIKE '%$dataFinal%' OR s.st_name LIKE '%$dataFinal%'");
        $dataKPI = DB::select($query);


        $dataJs = [];
        foreach ($dataKPI as $kPI) {
            $dataBaru = [
                'text' => $kPI->id . " || " . $kPI->name,
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
        $dataDepartment = DB::connection('sqlsrv2')->select("select TOP 10 KodeDP, Nama  from tdepartement where Nama like '%$dataFinal%' or KodeDP like '%$dataFinal%'");

        $dataJs = [];
        foreach ($dataDepartment as $a) {
            $dataBaru = [
                'text' => $a->Nama . " (" . $a->KodeDP . ")",
                'id' => $a->KodeDP
            ];
            $dataJs[] = $dataBaru;
        }
        $final = [
            'data' => $dataJs,
        ];
        return json_encode($final);

    }

    function HelperSelect2PicaKSite(Request $d)
    {
        $data = $d->request->get("query");
        $dataFinal = $this->validateAndSanitizeInput($data);
        $dataDepartment = DB::connection('sqlsrv2')->select("select TOP 10 * from tsite where AKTIF = 0 and Nama like '%$dataFinal%' or kodest like '%$dataFinal%'");

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
        $dataDepartment = DB::connection('sqlsrv2')->select("SELECT TOP 5 NIK nomorPunggung, Nama nama  FROM TKaryawan where KodeDP like '%$depart%' and ( Nama like '%$data%' OR NIK like '%$data%') and AKTIF = 0 ");

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
        if (isset($req->search['FILTERNIK']) && $req->search['FILTERNIK'] != null) {
            $query = $query . " AND '" . $req->search['FILTERNIK'] . "'  IN (Select PIC from new_pica_step where nodocpica = m.nodocpica) ";
        }
        if (isset($req->search['FILTERDEPARTMENT']) && $req->search['FILTERDEPARTMENT'] != null) {
            $query = $query . " AND m.dept = '" . $req->search['FILTERDEPARTMENT'] . "' ";
        }
        if (isset($req->search['FILTERSITE']) && $req->search['FILTERSITE'] != null) {
            $query = $query . " AND m.site = '" . $req->search['FILTERSITE'] . "' ";
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
        $query = "SELECT 
                    m.nik, 
                    m.nodocpica, 
                    CONCAT(FORMAT(DATEFROMPARTS(m.tahun, m.bulan, 1), 'MMMM'), ' - ', m.tahun) AS tahun_bulan,
                    m.week, 
                    m.site, 
                    m.approval,
                    m.id_kpi,
                     
                    -- Status berdasarkan kondisi acceptance dan status_approve
                    UPPER(
                        CASE

                            WHEN m.approval = 'pending' THEN 'NEED APPROVE BY OD'
                            -- WHEN m.approval = 'approved' THEN 'NOT ANY PROGRESS'
                            WHEN m.approval = 'rejected' THEN 'NEED REVISION'

                            WHEN (
                                SELECT COUNT(*) FROM new_pica_step nps WHERE nps.nodocpica = m.nodocpica
                            ) = 0 THEN 'STEP NOT SET'  -- Check for no steps
                                            
                            WHEN (
                                SELECT COUNT(*) FROM new_pica_step nps WHERE nps.nodocpica = m.nodocpica
                            ) = (
                                SELECT COUNT(*) FROM new_pica_step nps WHERE nps.nodocpica = m.nodocpica AND nps.acceptance = 0
                            ) THEN 'NOT ANY PROGRESS'
                                            
                            WHEN (
                                SELECT COUNT(*) FROM new_pica_step nps WHERE nps.nodocpica = m.nodocpica
                            ) = (
                                SELECT COUNT(*) FROM new_pica_step nps WHERE nps.nodocpica = m.nodocpica AND nps.acceptance = 2
                            ) THEN 'ALL TASK REJECTED BY PIC'
                                            
                            WHEN (
                                SELECT COUNT(*) FROM new_pica_step nps WHERE nps.nodocpica = m.nodocpica AND nps.acceptance != 2
                            ) = (
                                SELECT COUNT(*) FROM new_pica_step nps WHERE nps.nodocpica = m.nodocpica AND nps.acceptance != 2 AND nps.status_approve = 2
                            ) THEN 'ALL REJECT BY APPROVER'
                                            
                            WHEN (
                                SELECT COUNT(*) FROM new_pica_step nps WHERE nps.nodocpica = m.nodocpica AND nps.acceptance != 2
                            ) = (
                                SELECT COUNT(*) FROM new_pica_step nps WHERE nps.nodocpica = m.nodocpica AND nps.acceptance != 2 AND nps.status_approve = 1
                            ) THEN 'PICA CLOSED'
                                            
                            ELSE 'ON PROGRESS'
                        END
                    ) AS status,
                                    
                    (SELECT COUNT(*) FROM new_pica_step nps WHERE nps.nodocpica = m.nodocpica) AS total_steps,

                    (SELECT COUNT(*) FROM new_pica_step nps WHERE nps.nodocpica = m.nodocpica AND nps.acceptance = 0) AS acceptance_0_not_yet_accepted,

                    (SELECT COUNT(*) FROM new_pica_step nps WHERE nps.nodocpica = m.nodocpica AND nps.acceptance = 1) AS acceptance_1_accepted,

                    (SELECT COUNT(*) FROM new_pica_step nps WHERE nps.nodocpica = m.nodocpica AND nps.acceptance = 2) AS acceptance_2_rejected_by_pic,

                    (SELECT COUNT(*) FROM new_pica_step nps WHERE nps.nodocpica = m.nodocpica AND nps.acceptance = 9) AS acceptance_9_pending_approval,

                    (SELECT COUNT(*) FROM new_pica_step nps WHERE nps.nodocpica = m.nodocpica AND nps.status_approve = 1) AS status_approve_1_approved,

                    (SELECT COUNT(*) FROM new_pica_step nps WHERE nps.nodocpica = m.nodocpica AND nps.status_approve = 2) AS status_approve_2_rejected_by_approver,

                    m.problem, 
                    k.kp_name, 
                    kl.KPI  
                FROM 
                    master_pica m
                JOIN 
                    kategori_problem k ON k.kp_id = m.id_kategory 
                JOIN 
                    SMF_KPI_MASTER kl ON kl.kpi_code = m.id_kpi where 1 = 1 ";
        $countDataUser = DB::select('select count(*) jumlah FROM master_pica');
        $newQuery = $this->GetQueryDataTablePica($query, $table);

        // dd($newQuery);

        $dataUser = DB::select($newQuery);

        return response()->json([
            'total' => $countDataUser[0]->jumlah,
            'totalNotFiltered' => $countDataUser[0]->jumlah,
            "rows" => $dataUser,
        ]);
    }


    public function GetQueryDataTableSolutionPica(string $query, Request $req)
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

    function HelperDataTableStepSolutionPica(Request $table)
    {
        $nik = session("user_id");
        $query = " WITH dataProgress AS (
                        SELECT
                            id_solution,
                            nodocpica,
                            TRY_CAST(progress AS INT) AS progress,
                            status_reject,
                            keterangan_reject,
                            ROW_NUMBER() OVER (PARTITION BY id_solution, nodocpica ORDER BY TRY_CAST(progress AS INT) DESC) AS rn
                        FROM
                            history_progress_solution
                    )
                    SELECT
                        step_pica.nodocpica,
                        step_pica.id_master,
                        ISNULL(dp.progress, 0) AS progress,
                        UPPER(CASE
                            WHEN ISNULL(step_pica.acceptance, 0) = 2 THEN 'REJECT BY PIC'
                            WHEN ISNULL(step_pica.acceptance, 0) = 9 AND ISNULL(step_pica.status_approve, 0) = 0 AND ISNULL(step_pica.status_reject, 0) = 0  THEN 'NEED APPROVE'
                            WHEN ISNULL(dp.progress, 0) = 0 THEN 'NOT YET'
                            WHEN ISNULL(dp.progress, 0) > 0 AND ISNULL(dp.progress, 0) < 100 THEN 'ON PROGRESS'  -- ISNULL(mp.target_master, 0) THEN 'ON PROGRESS'
                            WHEN ISNULL(step_pica.acceptance, 0) = 9 AND ISNULL(step_pica.status_approve, 0) = 1 THEN 'CLOSE'
                            WHEN ISNULL(dp.status_reject,0) = 1 THEN 'REVISION'
                            ELSE 'NOT YET'
                        END) AS status,
                        step_pica.nik_master,
                        step_pica.id,
                        dp.keterangan_reject,
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
                    JOIN master_pica mp ON mp.nodocpica = step_pica.nodocpica and mp.approval = 'approved' where step_pica.pic = '$nik' ";
        $countDataUser = DB::select("select count(*) jumlah FROM new_pica_step where pic = '$nik' ");
        $newQuery = $this->GetQueryDataTableSolutionPica($query, req: $table);

        $dataUser = DB::select($newQuery);

        return response()->json([
            'total' => $countDataUser[0]->jumlah,
            'totalNotFiltered' => $countDataUser[0]->jumlah,
            "rows" => $dataUser,
        ]);
    }

    public function GetQueryDataTableHistoryTable(string $query, Request $req)
    {

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

    function HelperDataTableHistoryProgressPica(Request $table)
    {
        $nik = session("user_id");
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
                    ,status_reject
                FROM [history_progress_solution] where id_solution = '" . $table->search['IDSOLUTION'] . "' and nodocpica = '" . $table->search['NODOCPICA'] . "' ";
        $countDataUser = DB::select("select count(*) jumlah FROM history_progress_solution where id_solution = '" . $table->search['IDSOLUTION'] . "' and nodocpica = '" . $table->search['NODOCPICA'] . "' ");
        $newQuery = $this->GetQueryDataTableHistoryTable($query, req: $table);

        $dataUser = DB::select($newQuery);

        return response()->json([
            'total' => $countDataUser[0]->jumlah,
            'totalNotFiltered' => $countDataUser[0]->jumlah,
            "rows" => $dataUser,
        ]);
    }

    public function GetQueryDataTableDashboardHistoryTable(string $query, Request $req)
    {
        if (isset($req->search['FILTERNIKSOLUTION']) && $req->search['FILTERNIKSOLUTION'] != null) {
            $query = $query . " AND step_pica.pic = '" . $req->search['FILTERNIKSOLUTION'] . "' ";
        }
        if (isset($req->search['FILTERDEPARTMENTSOLUTION']) && $req->search['FILTERDEPARTMENTSOLUTION'] != null) {
            $query = $query . " AND step_pica.dic = '" . $req->search['FILTERDEPARTMENTSOLUTION'] . "' ";
        }
        if (isset($req->search['FILTERSITESOLUTION']) && $req->search['FILTERSITESOLUTION'] != null) {
            $query = $query . " AND mp.site = '" . $req->search['FILTERSITESOLUTION'] . "' ";
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




    function HelperDataTableDashboardHistoryProgressPica(Request $table)
    {
        $query = " WITH dataProgress AS (
            SELECT
                id_solution,
                nodocpica,
                TRY_CAST(progress AS INT) AS progress,
                status_reject,
                keterangan_reject,
                ROW_NUMBER() OVER (PARTITION BY id_solution, nodocpica ORDER BY TRY_CAST(progress AS INT) DESC) AS rn
            FROM
                history_progress_solution
        )
        SELECT
            step_pica.nodocpica,
            step_pica.id_master,
            ISNULL(dp.progress, 0) AS progress,
            UPPER(CASE
                WHEN ISNULL(step_pica.acceptance, 0) = 2 THEN 'REJECT BY PIC'
                WHEN ISNULL(step_pica.acceptance, 0) = 9 AND ISNULL(step_pica.status_approve, 0) = 0 AND ISNULL(step_pica.status_reject, 0) = 0  THEN 'NEED APPROVE'
                WHEN ISNULL(dp.progress, 0) = 0 THEN 'NOT YET'
                WHEN ISNULL(dp.progress, 0) > 0 AND ISNULL(dp.progress, 0) < ISNULL(mp.target_master, 0) THEN 'ON PROGRESS'
                WHEN ISNULL(step_pica.acceptance, 0) = 9 AND ISNULL(step_pica.status_approve, 0) = 1 THEN 'CLOSE'
                WHEN ISNULL(dp.status_reject,0) = 1 THEN 'REVISION'
                ELSE 'NOT YET'
            END) AS status,
            step_pica.nik_master,
            step_pica.id,
            dp.keterangan_reject,
            CASE
                WHEN step_pica.action = 'ca' THEN 'Corrective'
                WHEN step_pica.action = 'pa' THEN 'Preventive'
                ELSE step_pica.action
            END AS action,
            step_pica.note_step,
            step_pica.ap_tod AS ap_tod,
            step_pica.pic,
            step_pica.due_date,
            step_pica.position_why,
            step_pica.identity_why,
            acceptance,
            acceptance_reason,
            mp.target_master,
            step_pica.action,
            step_pica.dic,
            step_pica.approver
        FROM
            new_pica_step step_pica
        LEFT JOIN
            dataProgress dp ON dp.id_solution = step_pica.id
                AND dp.nodocpica = step_pica.nodocpica
                AND dp.rn = 1
        JOIN master_pica mp ON mp.nodocpica = step_pica.nodocpica where 1 = 1 ";
        $countDataUser = DB::select("select count(*) jumlah FROM new_pica_step where 1 = 1 ");
        $newQuery = $this->GetQueryDataTableDashboardHistoryTable($query, req: $table);

        $dataUser = DB::select($newQuery);

        return response()->json([
            'total' => $countDataUser[0]->jumlah,
            'totalNotFiltered' => $countDataUser[0]->jumlah,
            "rows" => $dataUser,
        ]);
    }

    public function GetQueryDataTableApprovementStepPica(string $query, Request $req)
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
                        approver
                    FROM
                        new_pica_step step_pica
                )
                SELECT * 
                FROM CTE where  acceptance = 9  AND approver = '$userID'  ";

        $countDataUser = DB::select("select count(*) jumlah FROM new_pica_step where dic = '$dept'");
        $newQuery = $this->GetQueryDataTableApprovementStepPica($query, $table);
        $dataUser = DB::select($newQuery);

        return response()->json([
            'total' => $countDataUser[0]->jumlah,
            'totalNotFiltered' => $countDataUser[0]->jumlah,
            "rows" => $dataUser,
        ]);


    }

    public function GetQueryDataTableApprovementPica(string $query, Request $req)
    {
        if (isset($req->search['FILTERNIK']) && $req->search['FILTERNIK'] != null) {
            $query = $query . "where ms.nik = '" . $req->search['FILTERNIK'] . "' ";
        }
        if (isset($req->search['FILTERDEPARTMENT']) && $req->search['FILTERDEPARTMENT'] != null) {
            $query = $query . " AND ms.dept = '" . $req->search['FILTERDEPARTMENT'] . "' ";
        }
        if (isset($req->search['FILTERSITE']) && $req->search['FILTERSITE'] != null) {
            $query = $query . " AND ms.site = '" . $req->search['FILTERSITE'] . "' ";
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

    function HelperDataTableApprovementMasterPica(Request $table)
    {
        $userID = session("user_id");
        $dept = session("kode_department");
        $query = "SELECT ms.*, kpi.kpi FROM master_pica ms join SMF_KPI_MASTER kpi on ms.id_kpi = kpi.kpi_code where 1 = 1 ";

        $countDataUser = DB::select("select count(*) jumlah FROM master_pica where 1 = 1 ");
        $newQuery = $this->GetQueryDataTableApprovementPica($query, $table);
        $dataUser = DB::select($newQuery);
        // dd($dataUser);
        return response()->json([
            'total' => $countDataUser[0]->jumlah,
            'totalNotFiltered' => $countDataUser[0]->jumlah,
            "rows" => $dataUser,
        ]);
    }


    function ChangepasswordPegawaiPost(Request $d)
    {

        $dataPasswordnew = Hash::make($d->p2); // Hash password baru

        $user = DB::table("users")
            ->where("username", session("user_id"))
            ->first();

        if (!$user || !Hash::check($d->p1, $user->password)) {
            return response()->json([
                'message' => 'Password yang lama salah',
                'code' => 500
            ]);
        }

        DB::beginTransaction();

        try {
            DB::table("users")
                ->where("username", session("user_id"))
                ->update([
                    "password" => $dataPasswordnew,
                    "updated_at" => now(),
                    "updated_by" => session("user_id")
                ]);

            DB::commit();
            return response()->json([
                'message' => 'Password Telah selesai diubah',
                'code' => 200
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'message' => 'Failed to Deleted records: ',
                'code' => 500
            ]);
        }

    }


}
