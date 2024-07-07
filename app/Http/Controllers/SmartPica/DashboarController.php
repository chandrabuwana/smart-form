<?php

namespace App\Http\Controllers\SmartPica;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

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

}
