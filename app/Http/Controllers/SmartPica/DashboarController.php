<?php

namespace App\Http\Controllers\SmartPica;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;

class DashboarController extends Controller
{
    //

    function IndexSmartPicaDashboard()
    {


        return view("smartpica/dashboard-smart-pica");
    }

    function IndexFormAdd()
    {
        $dataDepartment = DB::select("select * from kategori_problem");

        $dataJs = [];
        foreach ($dataDepartment as $a) {
            $dataBaru = [
                'text' => $a->kp_name,
                'id' => $a->kp_id
            ];
            $dataJs[] = $dataBaru;
        }
        $final = [
            'dataKategory' => $dataJs,
        ];
        return view("smartpica/add-form-pica", $final);
    }

    function IndexFormStepPica(string $id)
    {

        $dataMaster = DB::select("SELECT * FROM master_pica where nodocpica = '$id'");

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
        return view("smartpica/add-step-pica", $dataFinal);
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

        // $id = 'PICA-2024-07-04-1';

        $dataMaster = DB::select("select m.* , kl.lea_name, site.Nama nama_site, karyawan.nama nama_karyawan, k.kp_name  from master_pica m join kpi_lea kl on m.id_kpi = kl.lea_id join HRD.dbo.tsite site on m.site = site.KodeST join HRD.dbo.TKaryawan karyawan on karyawan.NIK = m.nik join kategori_problem k on k.kp_id = m.id_kategory where nodocpica = '$id'");

        $dataPicaW1 = DB::select("select * from pica_why1 w join kategori_problem k on w.id_kategory = k.kp_id where nodocpica = '$id'");
        $dataPicaW2 = DB::select("select * from pica_why2 w join kategori_problem k on w.id_kategory = k.kp_id where nodocpica = '$id'");
        $dataPicaW3 = DB::select("select * from pica_why3 w join kategori_problem k on w.id_kategory = k.kp_id where nodocpica = '$id'");
        $dataPicaW4 = DB::select("select * from pica_why4 w join kategori_problem k on w.id_kategory = k.kp_id where nodocpica = '$id'");
        $dataPicaW5 = DB::select("select * from pica_why5 w join kategori_problem k on w.id_kategory = k.kp_id where nodocpica = '$id'");


        $solution = DB::select("SELECT nodocpica,
                        id_master,
                        nik_master,
                        id, 
                        CASE 
                            WHEN action = 'ca' THEN 'Corrective'
                            WHEN action = 'pa' THEN 'Preventive'
                            ELSE action 
                        END AS action, 
                        note_step, 
                        upper(ap_tod) ap_tod, 
                        upper(dic) dic,
                        pic,
                        COALESCE(
                            (SELECT TOP 1 progress 
                                FROM history_progress_solution s 
                                WHERE n.nodocpica = s.nodocpica 
                                AND s.position_why = n.position_why 
                                AND s.identity_why = n.identity_why 
                                ORDER BY progress DESC), 
                            0
                        ) progress, 
                       FORMAT(due_date, 'dd MMMM yyyy', 'en-US') AS due_date, position_why, identity_why, k.nama nama_pic FROM [PICA_BETA].[dbo].[new_pica_step] n join hrd.dbo.TKaryawan k on n.pic = k.NIK where nodocpica = '$id'");

        $dataFinal = [
            'dataMaster' => $dataMaster[0],
            'dataPicaW1' => $dataPicaW1,
            'dataPicaW2' => $dataPicaW2,
            'dataPicaW3' => $dataPicaW3,
            'dataPicaW4' => $dataPicaW4,
            'dataPicaW5' => $dataPicaW5,
            'solution' => $solution,
        ];

        return view("smartpica/view-data-pica", $dataFinal);
    }

    function IndexUpdateProgress()
    {

        return view("smartpica/update-progress");
    }

}
