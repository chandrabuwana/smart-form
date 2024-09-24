<?php

namespace Modules\SmartForm\App\Http\Controllers\PDF;

use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HelperPdfMobilisasiFormController extends Controller
{
    //

    function DownloadPDFHelperPdf(string $docno)
    {

        $nodoc = $docno;



        $master = DB::connection('sqlsrv3')->select("select * from master_form_mobilisasi");

        $data['master'] = DB::connection('sqlsrv3')->select("select * from master_form_mobilisasi where nodocfm = '$nodoc'")[0];

        $data['pra'] = DB::connection('sqlsrv3')->select("select * from fm_mb_pramb where nodocfm = '$nodoc'")[0];
        $data['unit'] = DB::connection('sqlsrv3')->select("select * from FM_MB_KSU where nodocfm = '$nodoc'")[0];
        $data['transport'] = DB::connection('sqlsrv3')->select("select * from FM_MB_KTM where nodocfm = '$nodoc'")[0];
        $data['keselamatan'] = DB::connection('sqlsrv3')->select("select * from FM_MB_PKS where nodocfm = '$nodoc'")[0];
        $data['post'] = DB::connection('sqlsrv3')->select("select * from FM_MB_POSTM where nodocfm = '$nodoc'")[0];

        // return view("pdf/form_mobilisasi_export", $data);

        $pdf = Pdf::loadview("pdf/form_mobilisasi_export", $data)->setOptions(['defaultFont' => 'sans-serif'])->setPaper('a4', 'potrait');
        return $pdf->stream();


    }
}
