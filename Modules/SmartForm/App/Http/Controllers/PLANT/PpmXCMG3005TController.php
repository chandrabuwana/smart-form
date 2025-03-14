<?php

namespace Modules\SmartForm\App\Http\Controllers\PLANT;

use App\Helper;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;
use Modules\SmartForm\helpers\HrdHelper;

class PpmXCMG3005TController extends Controller {

    public function dashboard( Request $request ) {
        try {
            $query = DB::table( 'ppm_xcmg_3005_t' )
            ->select( '*' )
            ->orderBy( 'created_at', 'desc' );

            if ( $request->has( 'search' ) ) {
                $searchTerm = $request->search;
                $query->where( function( $q ) use ( $searchTerm ) {
                    $q->where( 'doc_num', 'like', '%' . $searchTerm . '%' )
                    ->orWhere( 'unit_model', 'like', '%' . $searchTerm . '%' )
                    ->orWhere( 'engine_model', 'like', '%' . $searchTerm . '%' )
                    ->orWhere( 'job_site', 'like', '%' . $searchTerm . '%' );
                }
            );
        }
        if ( $request->has( 'engine_model' ) && $request->engine_model ) {
            $query->where( 'engine_model', $request->engine_model );
        }

        if ( $request->has( 'job_site' ) && $request->job_site ) {
            $query->where( 'job_site',  $request->job_site );
        }

        $statistics = ( object )[
            'total_records' => DB::table( 'ppm_xcmg_3005_t' )->count(),
            'total_this_month' => DB::table( 'ppm_xcmg_3005_t' )
            ->whereMonth( 'created_at', now()->month )
            ->whereYear( 'created_at', now()->year )
            ->count(),
            'engine_model' => DB::table( 'ppm_xcmg_3005_t' )->distinct()->count( 'engine_model' ),
            'job_site' => DB::table( 'ppm_xcmg_3005_t' )->distinct()->count( 'job_site' ),
        ];

        $records = $query->paginate( 5 );
        return view( 'smartform::plant.ppm_3005T.dashboard-3005T', [ 'record' => $records, 'statistics'=>$statistics, 'filters' => [
            'search' => $request->search,
            'engine_model' => $request->engine_model,
            'job_site' => $request->job_site,
        ] ] );
    } catch( \Exception $e ) {
        Log::error( 'Error in Dashboard: ' . $e->getMessage() );
        return redirect()->back()->with( 'error', 'Failed to load dashboard data: ' . $e->getMessage() );
    }

}

public function Add() {
    $json = file_get_contents( resource_path( 'data/xcmg-3005T/xcmg-3005T.json' ) );
    $list = json_decode( $json, true );
    return view( 'smartform::plant.ppm_3005T.form-3005T', [ 'list' => $list,  'approvalList' => HrdHelper::getApprovalList() ] );
}

public function detail( $id ) {
    $data = DB::table( 'ppm_xcmg_3005_t' )
    ->where( 'id', $id )
    ->first();

    $detail = DB::table( 'detail_ppm_xcmg_3005_t' )
    ->where( 'doc_num_id', $data->doc_num )
    ->first();
    $json = file_get_contents( resource_path( 'data/xcmg-3005T/xcmg-3005T.json' ) );
    $list = json_decode( $json, true );

    $data->eng_actual = json_decode( $detail->eng_actual );
    $data->eng_correction_made = json_decode( $detail->eng_correction_made );
    $data->eng_result = json_decode( $detail->eng_result );
    $data->eng_pr = json_decode( $detail->eng_pr );
    $data->eng_taggal = json_decode( $detail->eng_taggal );
    $data->eng_remark = $detail->eng_remark ;

    $data->hyd_actual = json_decode( $detail->hyd_actual );
    $data->hyd_correction_made = json_decode( $detail->hyd_correction_made );
    $data->hyd_result = json_decode( $detail->hyd_result );
    $data->hyd_pr = json_decode( $detail->hyd_pr );
    $data->hyd_taggal = json_decode( $detail->hyd_taggal );
    $data->hyd_remark =  $detail->hyd_remark ;

    $data->wo_actual = json_decode( $detail->wo_actual );
    $data->wo_correction_made = json_decode( $detail->wo_correction_made );
    $data->wo_result = json_decode( $detail->wo_result );
    $data->wo_pr = json_decode( $detail->wo_pr );
    $data->wo_taggal = json_decode( $detail->wo_taggal );
    $data->wo_remark = $detail->wo_remark ;

    $data->fin_actual = json_decode( $detail->fin_actual );
    $data->fin_correction_made = json_decode( $detail->fin_correction_made );
    $data->fin_result = json_decode( $detail->fin_result );
    $data->fin_pr = json_decode( $detail->fin_pr );
    $data->fin_taggal = json_decode( $detail->fin_taggal );
    $data->fin_remark =  json_decode( $detail->fin_remark ) ;

    return view( 'smartform::plant.ppm_3005T.show-3005T', [ 'data' => $data, 'list' => $list ] );
}

public function Store( Request $request ) {

    $data = [
        'doc_num' => $this->generateDocNumber(),
        'unit_model' => 'GR3005T',
        'unit_sn' =>$request->unit_sn,
        'unit_cn' => $request->unit_cn,
        'engine_model' => $request->engine_model ,
        'engine_sn' => $request->engine_sn,
        'att_front' => $request->att_front,
        'att_rear' => $request->att_rear,
        'job_site' => $request->job_site,
        'job_location' => $request->location,
        'at_inspection' => $request->at_inspec,
        'date' => $request->date,
        'checked_by' => $request->checked,
        'validated_by' =>$request->validated,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()

    ];
    for ( $i = 0; $i <= 7; $i++ ) {
        $final_actual[] = $request->input( "final_actual$i" ) ?? 0;
        $final_correct[] = $request->input( "final_correct$i" ) ?? 0;
        $final_result[] = $request->input( "final_result$i" ) ?? 0;
    }

    $dataDetail = [
        'doc_num_id' => $data[ 'doc_num' ],
        'eng_actual' =>json_encode( array_values( $request->eng_actual ) ),
        'eng_correction_made' =>json_encode( array_values( $request->eng_correct ) ),
        'eng_result' => json_encode( array_values( $request->eng_result ) ),
        'eng_pr' =>json_encode( array_values( $request->eng_pr_no ) ),
        'eng_taggal' =>json_encode( array_values( $request->eng_tanggal ) ),
        'eng_remark' => $request->eng_remarks ?? '',
        'hyd_actual' => json_encode( array_values( $request->hyd_actual ) ),
        'hyd_correction_made' =>json_encode( array_values( $request->hyd_correct ) ),
        'hyd_result' => json_encode( array_values( $request->hyd_result ) ),
        'hyd_pr' => json_encode( array_values( $request->hyd_pr_no ) ) ,
        'hyd_taggal' => json_encode( array_values( $request->hyd_tanggal ) ),
        'hyd_remark' => $request->hyd_remarks ?? '',
        'wo_actual' => json_encode( array_values( $request->wo_actual ) ),
        'wo_correction_made' =>json_encode( array_values( $request->wo_correct ) ),
        'wo_result' => json_encode( array_values( $request->wo_result ) ),
        'wo_pr' => json_encode( array_values( $request->wo_pr_no ) ) ,
        'wo_taggal' => json_encode( array_values( $request->wo_tanggal ) ),
        'wo_remark' => $request->wo_remarks ?? '',
        'fin_actual' => json_encode( array_values( $final_actual ) ),
        'fin_correction_made' =>json_encode( array_values( $final_correct ) ),
        'fin_result' => json_encode( array_values( $final_result ) ),
        'fin_pr' => json_encode( array_values( $request->final_pr_no ) ) ,
        'fin_taggal' => json_encode( array_values( $request->final_tanggal ) ),
        'fin_remark' => json_encode( array_values( $request->final_remarks ) ),
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
    ];

    DB::table( 'ppm_xcmg_3005_t' )->insert( $data );
    DB::table( 'detail_ppm_xcmg_3005_t' )->insert( $dataDetail );
    return response()->json( [
        'success' => true,
        'message' => 'Data berhasil disimpan'
    ] );

}

public function Export( $id ) {

    try {
        $data = DB::table( 'ppm_xcmg_3005_t' )
        ->where( 'id', $id )
        ->first();

        $detail = DB::table( 'detail_ppm_xcmg_3005_t' )
        ->where( 'doc_num_id', $data->doc_num )
        ->first();
        $json = file_get_contents( resource_path( 'data/xcmg-3005T/xcmg-3005T.json' ) );
        $list = json_decode( $json, true );

        $data->eng_actual = json_decode( $detail->eng_actual );
        $data->eng_correction_made = json_decode( $detail->eng_correction_made );
        $data->eng_result = json_decode( $detail->eng_result );
        $data->eng_pr = json_decode( $detail->eng_pr );
        $data->eng_taggal = json_decode( $detail->eng_taggal );
        $data->eng_remark =  $detail->eng_remark ;

        $data->hyd_actual = json_decode( $detail->hyd_actual );
        $data->hyd_correction_made = json_decode( $detail->hyd_correction_made );
        $data->hyd_result = json_decode( $detail->hyd_result );
        $data->hyd_pr = json_decode( $detail->hyd_pr );
        $data->hyd_taggal = json_decode( $detail->hyd_taggal );
        $data->hyd_remark =  $detail->hyd_remark ;

        $data->wo_actual = json_decode( $detail->wo_actual );
        $data->wo_correction_made = json_decode( $detail->wo_correction_made );
        $data->wo_result = json_decode( $detail->wo_result );
        $data->wo_pr = json_decode( $detail->wo_pr );
        $data->wo_taggal = json_decode( $detail->wo_taggal );
        $data->wo_remark =  $detail->wo_remark ;

        $data->fin_actual = json_decode( $detail->fin_actual );
        $data->fin_correction_made = json_decode( $detail->fin_correction_made );
        $data->fin_result = json_decode( $detail->fin_result );
        $data->fin_pr = json_decode( $detail->fin_pr );
        $data->fin_taggal = json_decode( $detail->fin_taggal );
        $data->fin_remark = json_decode( $detail->fin_remark );
        $pdf = PDF::loadView( 'smartform::plant.ppm_3005T.export-pdf', [
            'data' => $data, 'list' => $list,

        ] );
        $pdf->setPaper( 'A4', 'landscape' );

        return $pdf->download( 'PPM XCMG GR3005T' . $data->doc_num .'.pdf' );

    } catch ( \Exception $e ) {
        Log::error( 'Error in ExportForm: ' . $e->getMessage() );
        return redirect()
        ->route( 'prod.form.checker.dashboard' )
        ->with( 'error', 'Failed to generate PDF: ' . $e->getMessage() );
    }
}


    private function generateDocNumber() {
        $today = Carbon::now();

        $count = DB::table( 'ppm_xcmg_3005_t' )
        ->whereYear( 'created_at', $today->year )
        ->whereMonth( 'created_at', $today->month )
        ->count();

        $docNumber = '';

        do {
            $count++;

            $docNumber = sprintf(
                'BSS-FRM-PLA-073-%s%s-%03d',
                $today->format( 'y' ),
                $today->format( 'm' ),
                $count
            );

            $exists = DB::table( 'ppm_xcmg_3005_t' )
            ->where( 'doc_num', $docNumber )
            ->exists();

        }
        while ( $exists );
        return $docNumber;
    }

}
