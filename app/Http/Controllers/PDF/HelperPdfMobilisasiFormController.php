<?php

namespace App\Http\Controllers\PDF;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use PDF;

class HelperPdfMobilisasiFormController extends Controller
{
    //

    function DownloadPDFHelperPdf(string $docno)
    {
        
        $nodoc = $docno;

        $master = DB::select("select * from master_form_mobilisasi");

        $data['master'] = DB::select("select * from master_form_mobilisasi where nodocfm = '$nodoc'")[0];

        $data['pra'] = DB::select("select * from fm_mb_pramb where nodocfm = '$nodoc'")[0];
        $data['unit'] = DB::select("select * from FM_MB_KSU where nodocfm = '$nodoc'")[0];
        $data['transport'] = DB::select("select * from FM_MB_KTM where nodocfm = '$nodoc'")[0];
        $data['keselamatan'] = DB::select("select * from FM_MB_PKS where nodocfm = '$nodoc'")[0];
        $data['post'] = DB::select("select * from FM_MB_POSTM where nodocfm = '$nodoc'")[0];

        // return view("pdf/form_mobilisasi_export", $data);

        $pdf = PDF::loadview("pdf/form_mobilisasi_export", $data)->setOptions(['defaultFont' => 'sans-serif'])->setPaper('a4', 'potrait');
        return $pdf->stream();


    }
}
