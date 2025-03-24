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

class PpmXCMG700DController extends Controller {

    public function dashboard(Request $request) {
        try {
            $nik_session = $request->session()->get( 'user_id', '' );
            $query = DB::table( 'ppm_xcmg_xe700d' )
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
        if ( $request->has( 'approval' ) && $request->approval ) {
            $query->where( 'checked_by', $request->approval )->orwhere( 'validated_by', $request->approval );
            ;
        }
        $statistics = ( object )[
            'total_records' => DB::table( 'ppm_xcmg_xe700d' )->count(),
            'total_this_month' => DB::table( 'ppu_xe1250' )
            ->whereMonth( 'created_at', now()->month )
            ->whereYear( 'created_at', now()->year )
            ->count(),
            'engine_model' => DB::table( 'ppm_xcmg_xe700d' )->distinct()->count( 'engine_model' ),
            'job_site' => DB::table( 'ppm_xcmg_xe700d' )->distinct()->count( 'job_site' ),
        ];

            $records = $query->paginate( 5 );
            return view( 'smartform::plant.ppm_700d.dashboard-700d', [ 'record' => $records,'session'=>$nik_session, 'user'=> HrdHelper::getApprovalList(),  'statistics'=>$statistics, 'filters' => [
            'search' => $request->search,
            'engine_model' => $request->engine_model,
            'job_site' => $request->job_site,
            'approval' => $request->approval
        ] ] );
        } catch( \Exception $e ) {
            Log::error( 'Error in Dashboard: ' . $e->getMessage() );
            return redirect()->back()->with( 'error', 'Failed to load dashboard data: ' . $e->getMessage() );
        }

    }

    public function Add() {
        $json = file_get_contents( resource_path( 'data/xe700d/ppm-700.json' ) );
        $list = json_decode( $json, true );


        return view( 'smartform::plant.ppm_700d.form-700d', [ 'list' => $list,  'approvalList' => HrdHelper::getApprovalList() ] );
    }

    public function detail($id){
        $data = DB::table( 'ppm_xcmg_xe700d' )
        ->where( 'id', $id )
        ->first();

        $detail = DB::table( 'detail_ppm_xcmg_xe700d' )
        ->where( 'doc_num_id', $data->doc_num )
        ->first();
        $json = file_get_contents( resource_path( 'data/xe700d/ppm-700.json' ) );
        $list = json_decode( $json, true );

        $data->eng_actual = json_decode( $detail->eng_actual );
        $data->eng_correction_made = json_decode( $detail->eng_correction_made );
        $data->eng_result = json_decode( $detail->eng_result );
        $data->eng_pr = json_decode( $detail->eng_pr );
        $data->eng_taggal = json_decode( $detail->eng_taggal );
        $data->eng_remark = json_decode( $detail->eng_remark );

        $data->hyd_actual = json_decode( $detail->hyd_actual );
        $data->hyd_correction_made = json_decode( $detail->hyd_correction_made );
        $data->hyd_result = json_decode( $detail->hyd_result );
        $data->hyd_pr = json_decode( $detail->hyd_pr );
        $data->hyd_taggal = json_decode( $detail->hyd_taggal );
        $data->hyd_remark = json_decode( $detail->hyd_remark );

        $data->wo_actual = json_decode( $detail->wo_actual );
        $data->wo_correction_made = json_decode( $detail->wo_correction_made );
        $data->wo_result = json_decode( $detail->wo_result );
        $data->wo_pr = json_decode( $detail->wo_pr );
        $data->wo_taggal = json_decode( $detail->wo_taggal );
        $data->wo_remark = json_decode( $detail->wo_remark );

        $data->fin_actual = json_decode( $detail->fin_actual );
        $data->fin_correction_made = json_decode( $detail->fin_correction_made );
        $data->fin_result = json_decode( $detail->fin_result );
        $data->fin_pr = json_decode( $detail->fin_pr );
        $data->fin_taggal = json_decode( $detail->fin_taggal );
        $data->fin_remark = json_decode( $detail->fin_remark );

        return view( 'smartform::plant.ppm_700d.show-700d', [ 'data' => $data, 'list' => $list, 'approvalList' => HrdHelper::getApprovalList() ] );
    }
    public function show( Request $request,$id){
        $nik_session = $request->session()->get( 'user_id', '' );

        $data = DB::table( 'ppm_xcmg_xe700d' )
        ->where( 'id', $id )
        ->first();

        $detail = DB::table( 'detail_ppm_xcmg_xe700d' )
        ->where( 'doc_num_id', $data->doc_num )
        ->first();
        $json = file_get_contents( resource_path( 'data/xe700d/ppm-700.json' ) );
        $list = json_decode( $json, true );

        $data->status = json_decode( $data->status );
        $data->eng_actual = json_decode( $detail->eng_actual );
        $data->eng_correction_made = json_decode( $detail->eng_correction_made );
        $data->eng_result = json_decode( $detail->eng_result );
        $data->eng_pr = json_decode( $detail->eng_pr );
        $data->eng_taggal = json_decode( $detail->eng_taggal );
        $data->eng_remark = json_decode( $detail->eng_remark );

        $data->hyd_actual = json_decode( $detail->hyd_actual );
        $data->hyd_correction_made = json_decode( $detail->hyd_correction_made );
        $data->hyd_result = json_decode( $detail->hyd_result );
        $data->hyd_pr = json_decode( $detail->hyd_pr );
        $data->hyd_taggal = json_decode( $detail->hyd_taggal );
        $data->hyd_remark = json_decode( $detail->hyd_remark );

        $data->wo_actual = json_decode( $detail->wo_actual );
        $data->wo_correction_made = json_decode( $detail->wo_correction_made );
        $data->wo_result = json_decode( $detail->wo_result );
        $data->wo_pr = json_decode( $detail->wo_pr );
        $data->wo_taggal = json_decode( $detail->wo_taggal );
        $data->wo_remark = json_decode( $detail->wo_remark );

        $data->fin_actual = json_decode( $detail->fin_actual );
        $data->fin_correction_made = json_decode( $detail->fin_correction_made );
        $data->fin_result = json_decode( $detail->fin_result );
        $data->fin_pr = json_decode( $detail->fin_pr );
        $data->fin_taggal = json_decode( $detail->fin_taggal );
        $data->fin_remark = json_decode( $detail->fin_remark );

        return view( 'smartform::plant.ppm_700d.detail-700d', [ 'data' => $data, 'nik' =>$nik_session, 'list' => $list, 'approvalList' => HrdHelper::getApprovalList() ] );
    }

    public function Store( Request $request ) {

        $data = [
            'doc_num' => $this->generateDocNumber(),
            'unit_model' => "XCMG XE700D",
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
            'creator' => $request->session()->get( 'user_id', '' ),
            'status' => json_encode( array_values( [ null, null] ) ),
            'checked_by' => $request->checked,
            'validated_by' =>$request->validated,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()

        ];
        for ( $i = 0; $i <= 3; $i++ ) {
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
            'eng_remark' => json_encode( array_values( $request->eng_remarks ) ),
            'hyd_actual' => json_encode( array_values( $request->hyd_actual ) ),
            'hyd_correction_made' =>json_encode( array_values( $request->hyd_correct ) ),
            'hyd_result' => json_encode( array_values( $request->hyd_result ) ),
            'hyd_pr' => json_encode( array_values( $request->hyd_pr_no ) ) ,
            'hyd_taggal' => json_encode( array_values( $request->hyd_tanggal ) ),
            'hyd_remark' => json_encode( array_values( $request->hyd_remarks ) ),
            'wo_actual' => json_encode( array_values( $request->wo_actual ) ),
            'wo_correction_made' =>json_encode( array_values( $request->wo_correct ) ),
            'wo_result' => json_encode( array_values( $request->wo_result ) ),
            'wo_pr' => json_encode( array_values( $request->wo_pr_no ) ) ,
            'wo_taggal' => json_encode( array_values( $request->wo_tanggal ) ),
            'wo_remark' =>json_encode( array_values( $request->wo_remarks ) ),
            'fin_actual' => json_encode( array_values( $final_actual ) ),
            'fin_correction_made' =>json_encode( array_values( $final_correct ) ),
            'fin_result' => json_encode( array_values($final_result ) ),
            'fin_pr' => json_encode( array_values( $request->final_pr_no ) ) ,
            'fin_taggal' => json_encode( array_values( $request->final_tanggal ) ),
            'fin_remark' => json_encode( array_values( $request->final_remarks ) ),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ];


        DB::table( 'ppm_xcmg_xe700d' )->insert( $data );
        DB::table( 'detail_ppm_xcmg_xe700d' )->insert( $dataDetail );
        return response()->json( [
            'success' => true,
            'message' => 'Data berhasil disimpan'
        ] );

    }

    public function Export( $id ) {

    try{
        $data = DB::table( 'ppm_xcmg_xe700d' )
        ->where( 'id', $id )
        ->first();

        $detail = DB::table( 'detail_ppm_xcmg_xe700d' )
        ->where( 'doc_num_id', $data->doc_num )
        ->first();
        $json = file_get_contents( resource_path( 'data/xe700d/ppm-700.json' ) );
        $list = json_decode( $json, true );

        $data->eng_actual = json_decode( $detail->eng_actual );
        $data->eng_correction_made = json_decode( $detail->eng_correction_made );
        $data->eng_result = json_decode( $detail->eng_result );
        $data->eng_pr = json_decode( $detail->eng_pr );
        $data->eng_taggal = json_decode( $detail->eng_taggal );
        $data->eng_remark = json_decode( $detail->eng_remark );

        $data->hyd_actual = json_decode( $detail->hyd_actual );
        $data->hyd_correction_made = json_decode( $detail->hyd_correction_made );
        $data->hyd_result = json_decode( $detail->hyd_result );
        $data->hyd_pr = json_decode( $detail->hyd_pr );
        $data->hyd_taggal = json_decode( $detail->hyd_taggal );
        $data->hyd_remark = json_decode( $detail->hyd_remark );

        $data->wo_actual = json_decode( $detail->wo_actual );
        $data->wo_correction_made = json_decode( $detail->wo_correction_made );
        $data->wo_result = json_decode( $detail->wo_result );
        $data->wo_pr = json_decode( $detail->wo_pr );
        $data->wo_taggal = json_decode( $detail->wo_taggal );
        $data->wo_remark = json_decode( $detail->wo_remark );

        $data->fin_actual = json_decode( $detail->fin_actual );
        $data->fin_correction_made = json_decode( $detail->fin_correction_made );
        $data->fin_result = json_decode( $detail->fin_result );
        $data->fin_pr = json_decode( $detail->fin_pr );
        $data->fin_taggal = json_decode( $detail->fin_taggal );
        $data->fin_remark = json_decode( $detail->fin_remark );
        $pdf = PDF::loadView( 'smartform::plant.ppm_700d.export-pdf', [
            'data' => $data, 'list' => $list,'approvalList' => HrdHelper::getApprovalList()

        ] );
        $pdf->setPaper('A4', 'landscape');

        return $pdf->download( 'PPM XCMG XE700D - ' . $data->doc_num .'.pdf' );

    } catch ( \Exception $e ) {
        Log::error( 'Error in ExportForm: ' . $e->getMessage() );
        return redirect()
        ->route( 'plant.ppm.700d.dashboard' )
        ->with( 'error', 'Failed to generate PDF: ' . $e->getMessage() );
    }
    }

    public function Approve( Request $request ) {

        $data = [
            'status' => json_encode( array_values( [
                $request->checked,
                $request->validated,
            ] ) ),
            'updated_at' => Carbon::now()
        ];

        DB::table( 'ppm_xcmg_xe700d' )
        ->where( 'doc_num', $request->doc_num )
        ->update( $data );

        return response()->json( [
            'success' => true,
            'message' => 'Data berhasil di Approve'
        ] );

    }

    public function Reset( $id ) {

        $data = [
            'status' => json_encode( array_values( [
                null,
                null
            ] ) ),
            'updated_at' => Carbon::now()
        ];

        DB::table( 'ppm_xcmg_xe700d' )
        ->where( 'doc_num', $id )
        ->update( $data );

        return response()->json( [
            'success' => true,
            'message' => 'Data berhasil di Reset'
        ] );

    }

    public function Reject( Request $request ) {
        $data = [
            'status' => json_encode( array_values( [
                $request->checked,
                $request->validated,

            ] ) ),
            'updated_at' => Carbon::now()
        ];
        ;

        DB::table( 'ppm_xcmg_xe700d' )
        ->where( 'doc_num', $request->doc_num )
        ->update( $data );

        return response()->json( [
            'success' => true,
            'message' => 'Data berhasil di Reject'
        ] );
    }
    public function Update (Request $request){
        $data = [
            'doc_num' => $request->doc_num,
            'unit_model' =>$request->unit_model,
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



        for ( $i = 0; $i <= 3; $i++ ) {
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
            'eng_remark' => json_encode( array_values( $request->eng_remarks ) ),
            'hyd_actual' => json_encode( array_values( $request->hyd_actual ) ),
            'hyd_correction_made' =>json_encode( array_values( $request->hyd_correct ) ),
            'hyd_result' => json_encode( array_values( $request->hyd_result ) ),
            'hyd_pr' => json_encode( array_values( $request->hyd_pr_no ) ) ,
            'hyd_taggal' => json_encode( array_values( $request->hyd_tanggal ) ),
            'hyd_remark' => json_encode( array_values( $request->hyd_remarks ) ),
            'wo_actual' => json_encode( array_values( $request->wo_actual ) ),
            'wo_correction_made' =>json_encode( array_values( $request->wo_correct ) ),
            'wo_result' => json_encode( array_values( $request->wo_result ) ),
            'wo_pr' => json_encode( array_values( $request->wo_pr_no ) ) ,
            'wo_taggal' => json_encode( array_values( $request->wo_tanggal ) ),
            'wo_remark' =>json_encode( array_values( $request->wo_remarks ) ),
            'fin_actual' => json_encode( array_values( $final_actual ) ),
            'fin_correction_made' =>json_encode( array_values( $final_correct ) ),
            'fin_result' => json_encode( array_values($final_result ) ),
            'fin_pr' => json_encode( array_values( $request->final_pr_no ) ) ,
            'fin_taggal' => json_encode( array_values( $request->final_tanggal ) ),
            'fin_remark' => json_encode( array_values( $request->final_remarks ) ),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ];


        DB::table( 'ppm_xcmg_xe700d' )
            ->where( 'doc_num', $request->doc_num )
            ->update( $data );

        DB::table( 'detail_ppm_xcmg_xe700d' )
            ->where( 'doc_num_id', $request->doc_num )
            ->update( $dataDetail  );
        return response()->json( [
            'success' => true,
            'message' => 'Data berhasil diupdate'
        ] );

    }
    public function Delete( $id ) {
        try {
            $id = request()->id;
            DB::table( 'ppm_xcmg_xe700d' )
            ->where( 'doc_num', $id )
            ->delete();
            $id = request()->id;
            DB::table( 'detail_ppm_xcmg_xe700d' )
            ->where( 'doc_num_id', $id )
            ->delete();


            return response()->json( [
                'success' => true,
                'message' => 'Data berhasil dihapus'
            ] );

        } catch ( QueryException $e ) {
            Log::error( 'Error in Delete: ' . $e->getMessage() );
            return response()->json( [
                'success' => false,
                'message' => 'Failed to delete record: ' . $e->getMessage()
            ], 500 );

        }
    }

    private function generateDocNumber() {
        $today = Carbon::now();


        $count = DB::table( 'ppm_xcmg_xe700d' )
        ->whereYear( 'created_at', $today->year )
        ->whereMonth( 'created_at', $today->month )
        ->count();

        $docNumber = '';

        do {
            $count++;

            $docNumber = sprintf(
                'BSS-FRM-PLA-04-072-%s%s-%03d',
                $today->format( 'y' ),
                $today->format( 'm' ),
                $count
            );

            $exists = DB::table( 'ppm_xcmg_xe700d' )
            ->where( 'doc_num', $docNumber )
            ->exists();

        }
        while ( $exists );
        return $docNumber;
    }


}
