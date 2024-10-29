<?php

namespace Modules\SmartForm\App\Http\Controllers\SmartPica;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;

class DashboarController extends Controller
{
    //

    function IndexSmartPicaDashboard()
    {
        // dd(session('user_id'));
        $dataCharts = [
            'Not Yet ACC' => ['count' => 0, 'percentage' => 0],
            'On Progress' => ['count' => 0, 'percentage' => 0],
            'Reject By PIC' => ['count' => 0, 'percentage' => 0],
            'Closed' => ['count' => 0, 'percentage' => 0],
        ];

        $dataPicas = DB::table('new_pica_step')->selectRaw('COUNT(id) AS count_pica, acceptance status')
            ->groupBy('acceptance')->get();

        foreach ($dataPicas as $pica) {
            $status = strtr($pica->status, [
                '0' => 'Not Yet ACC',
                '1' => 'On Progress',
                '2' => 'Reject By PIC',
                '9' => 'Closed',
            ]);

            $countAll = $dataPicas->pluck('count_pica')->sum();
            $dataCharts[$status]['count'] = $pica->count_pica;
            $dataCharts[$status]['percentage'] = round(($pica->count_pica / $countAll) * 100, 2);
        }

        return view("SmartForm::smartpica/dashboard-smart-pica", [
            'dataCharts' => $dataCharts
        ]);
    }

    function IndexFormAdd()
    {
        $dataKategory = DB::select("select * from kategori_problem order by kp_id desc");

        $dataJs = [];
        foreach ($dataKategory as $a) {
            $dataBaru = [
                'text' => $a->kp_name,
                'id' => $a->kp_id
            ];
            $dataJs[] = $dataBaru;
        }
        $final = [
            'dataKategory' => $dataJs,
        ];
        return view("SmartForm::smartpica/add-form-pica", $final);
    }

    function IndexFormStepPica(string $id)
    {

        $dataMaster = DB::select("SELECT * FROM master_pica m join 
                                            SMF_KPI_MASTER kl ON kl.kpi_code = m.id_kpi join kategori_problem k on m.id_kategory = k.kp_id where m.nodocpica = '$id'");

        $dataPicaW1 = DB::select("select * from pica_why1 w join kategori_problem k on w.id_kategory = k.kp_id where nodocpica = '$id'");
        $dataPicaW2 = DB::select("select * from pica_why2 w join kategori_problem k on w.id_kategory = k.kp_id where nodocpica = '$id'");
        $dataPicaW3 = DB::select("select * from pica_why3 w join kategori_problem k on w.id_kategory = k.kp_id where nodocpica = '$id'");
        $dataPicaW4 = DB::select("select * from pica_why4 w join kategori_problem k on w.id_kategory = k.kp_id where nodocpica = '$id'");
        $dataPicaW5 = DB::select("select * from pica_why5 w join kategori_problem k on w.id_kategory = k.kp_id where nodocpica = '$id'");


        $dataterakhir1 = [];
        $dataterakhir2 = [];
        $dataterakhir3 = [];
        $dataterakhir4 = [];
        $dataterakhir5 = [];

        foreach ($dataPicaW1 as $d1) {
            $filteredData2 = $this->filterWhy2($dataPicaW2, $d1->index_w1);
            if (count($filteredData2) > 0) {
                foreach ($filteredData2 as $d2) {
                    $filteredData3 = $this->filterWhy3($dataPicaW3, $d2->index_w1, $d2->index_w2);
                    if (count($filteredData3) > 0) {
                        foreach ($filteredData3 as $d3) {
                            $filteredData4 = $this->filterWhy4($dataPicaW4, $d3->index_w1, $d3->index_w2, $d3->index_w3);
                            if (count($filteredData4) > 0) {
                                foreach ($filteredData4 as $d4) {
                                    $filteredData5 = $this->filterWhy5($dataPicaW5, $d4->index_w1, $d4->index_w2, $d4->index_w3, $d4->index_w4);
                                    if (count($filteredData5) > 0) {
                                        foreach ($filteredData5 as $d5) {
                                            array_push($dataterakhir5, $d5);
                                        }
                                    } else {
                                        array_push($dataterakhir4, $d4);
                                    }
                                }
                            } else {
                                array_push($dataterakhir3, $d3);
                            }
                        }
                    } else {
                        array_push($dataterakhir2, $d2);
                    }
                }
            } else {
                array_push($dataterakhir1, $d1);
            }
        }

        $dataDepartment = DB::connection('sqlsrv2')->select("SELECT * FROM tdepartement");

        $dataMasalahAkhir = [];
        $dataMasalahAkhir = array_merge($dataMasalahAkhir, $dataterakhir1);
        $dataMasalahAkhir = array_merge($dataMasalahAkhir, $dataterakhir2);
        $dataMasalahAkhir = array_merge($dataMasalahAkhir, $dataterakhir3);
        $dataMasalahAkhir = array_merge($dataMasalahAkhir, $dataterakhir4);
        $dataMasalahAkhir = array_merge($dataMasalahAkhir, $dataterakhir5);
        // dd($dataDepartment);
        $dataFinal = [
            'dataDepartment' => $dataDepartment,
            'dataMaster' => $dataMaster,
            'dataMasalahTerakhir' => $dataMasalahAkhir
        ];
        return view("SmartForm::smartpica/add-step-pica", $dataFinal);
    }

    function filterWhy2($array, $index1)
    {
        return array_filter($array, function ($obj) use ($index1) {
            return $obj->index_w1 === $index1;
        });
    }

    function filterWhy3($array, $index1, $index2)
    {
        return array_filter($array, function ($obj) use ($index1, $index2) {
            return $obj->index_w1 === $index1 && $obj->index_w2 === $index2;
        });
    }

    function filterWhy4($array, $index1, $index2, $index3)
    {
        return array_filter($array, function ($obj) use ($index1, $index2, $index3) {
            return $obj->index_w1 === $index1 && $obj->index_w2 === $index2 && $obj->index_w3 === $index3;
        });
    }
    function filterWhy5($array, $index1, $index2, $index3, $index4)
    {
        return array_filter($array, function ($obj) use ($index1, $index2, $index3, $index4) {
            return $obj->index_w1 === $index1 && $obj->index_w2 === $index2 && $obj->index_w3 === $index3 && $obj->index_w4 === $index4;
        });
    }

    function IndexViewDataDetailPica(string $id)
    {

        $dataMaster = DB::select("SELECT 
                                            m.*, 
                                            kl.kpi, 
                                            site.Nama AS nama_site, 
                                            karyawan.nama AS nama_karyawan, 
                                            k.kp_name,
                                            dep.Nama AS nama_department
                                        FROM 
                                            master_pica m 
                                        JOIN 
                                            SMF_KPI_MASTER kl ON m.id_kpi = kl.kpi_code 
                                        JOIN 
                                            HRD.dbo.tsite site ON m.site = site.KodeST
                                        JOIN 
                                        HRD.dbo.tdepartement dep ON m.dept = dep.KodeDP
                                        JOIN 
                                            HRD.dbo.TKaryawan karyawan ON karyawan.NIK = m.nik 
                                        JOIN 
                                            kategori_problem k ON k.kp_id = m.id_kategory 
                                    WHERE m.nodocpica = '$id'");

        $dataPicaW1 = DB::select("select * from pica_why1 w join kategori_problem k on w.id_kategory = k.kp_id where nodocpica = '$id'");
        $dataPicaW2 = DB::select("select * from pica_why2 w join kategori_problem k on w.id_kategory = k.kp_id where nodocpica = '$id'");
        $dataPicaW3 = DB::select("select * from pica_why3 w join kategori_problem k on w.id_kategory = k.kp_id where nodocpica = '$id'");
        $dataPicaW4 = DB::select("select * from pica_why4 w join kategori_problem k on w.id_kategory = k.kp_id where nodocpica = '$id'");
        $dataPicaW5 = DB::select("select * from pica_why5 w join kategori_problem k on w.id_kategory = k.kp_id where nodocpica = '$id'");


        $solution = DB::select("SELECT 
                                        n.nodocpica,
                                        n.id_master,
                                        n.nik_master,
                                        n.id,
                                        CASE
                                            WHEN n.action = 'ca' THEN 'Corrective'
                                            WHEN n.action = 'pa' THEN 'Preventive'
                                            ELSE n.action
                                        END AS action,
                                        n.note_step,
                                        UPPER(n.ap_tod) AS ap_tod,
                                        UPPER(n.dic) AS dic,
                                        n.pic,
                                        COALESCE(
                                            (SELECT TOP 1 s.progress
                                                FROM history_progress_solution s
                                                WHERE n.nodocpica = s.nodocpica
                                                AND s.id_solution = n.id
                                                ORDER BY s.progress DESC),
                                            0
                                        ) AS progress,
                                        -- Menghitung persentase progress berdasarkan target_master
                                        COALESCE(
                                            (SELECT TOP 1 CAST(s.progress AS FLOAT) / mp.target_master * 100
                                                FROM history_progress_solution s
                                                WHERE n.nodocpica = s.nodocpica
                                                AND s.id_solution = n.id
                                                ORDER BY s.progress DESC),
                                            0
                                        ) AS progress_percentage,
                                        FORMAT(n.due_date, 'dd MMMM yyyy', 'en-US') AS due_date,
                                        n.position_why,
                                        n.acceptance,
                                        n.acceptance_reason,
                                        n.status_reject,
                                        n.status_approve,
                                        n.keterangan_reject,
                                        n.identity_why,
                                         CASE
                                        WHEN n.status_reject = 1 THEN 'Close Rejected'
                                        WHEN n.status_approve = 1 THEN 'Close'
                                        WHEN n.acceptance = 0 THEN 'Need Accept by PIC'
                                        WHEN n.acceptance = 1 THEN 'On Progress'
                                        WHEN n.acceptance = 2 THEN 'Reject By PIC'
                                        WHEN n.acceptance = 9 THEN 'Need Validation'
                                        ELSE 'Unknown Status'
                                    END AS status_solution,
                                        k.nama AS nama_pic
                                    FROM 
                                        new_pica_step n
                                    JOIN 
                                        hrd.dbo.TKaryawan k ON n.pic = k.NIK
                                    JOIN 
                                        master_pica mp ON mp.nodocpica = n.nodocpica where n.nodocpica = '$id'");

        $dataKategory = DB::select("select * from kategori_problem order by kp_id desc");

        $dataJs = [];
        foreach ($dataKategory as $a) {
            $dataBaru = [
                'text' => $a->kp_name,
                'id' => $a->kp_id
            ];
            $dataJs[] = $dataBaru;
        }

        $dataFinal = [
            'dataMaster' => $dataMaster[0],
            'dataPicaW1' => $dataPicaW1,
            'dataPicaW2' => $dataPicaW2,
            'dataPicaW3' => $dataPicaW3,
            'dataPicaW4' => $dataPicaW4,
            'dataPicaW5' => $dataPicaW5,
            'solution' => $solution,
            'dataKategory' => $dataJs
        ];

        return view("SmartForm::smartpica/view-data-pica", $dataFinal);
    }

    function IndexUpdateProgress()
    {
        return view("SmartForm::smartpica/update-progress");
    }

    function IndexApprovementProgress()
    {
        return view("SmartForm::smartpica/approvement-pica");
    }

}
