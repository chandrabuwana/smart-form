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

class PpuXE1250Controller extends Controller {

    public function dashboard( Request $request ) {
        try {
            $query = DB::table( 'ppu_xe1250' )
            ->select( '*' )
            ->orderBy( 'created_at', 'desc' );

            if ( $request->has( 'search' ) ) {
                $searchTerm = $request->search;
                $query->where( function( $q ) use ( $searchTerm ) {
                    $q->where( 'doc_number', 'like', '%' . $searchTerm . '%' )
                    ->orWhere( 'sn_unit', 'like', '%' . $searchTerm . '%' )
                    ->orWhere( 'smr_hm', 'like', '%' . $searchTerm . '%' )
                    ->orWhere( 'work_operation', 'like', '%' . $searchTerm . '%' )
                    ->orWhere( 'inspection_date', 'like', '%' . $searchTerm . '%' );
                }
            );
        }
        if ( $request->has( 'sn_unit' ) && $request->sn_unit ) {
            $query->where( 'sn_unit', $request->sn_unit );
        }

        $statistics = ( object )[
            'total_records' => DB::table( 'ppu_xe1250' )->count(),
            'total_this_month' => DB::table( 'ppu_xe1250' )
            ->whereMonth( 'created_at', now()->month )
            ->whereYear( 'created_at', now()->year )
            ->count(),
        ];

        $records = $query->paginate( 5 );
        return view( 'smartform::plant.ppu_xe1250.dashboard-ppu1250', [ 'record' => $records, 'statistics'=>$statistics, 'filters' => [
            'search' => $request->search,
            'sn_unit' => $request->sn_unit,
        ] ] );
    } catch( \Exception $e ) {
        Log::error( 'Error in Dashboard: ' . $e->getMessage() );
        return redirect()->back()->with( 'error', 'Failed to load dashboard data: ' . $e->getMessage() );
    }

    }

    public function Add() {

        return view( 'smartform::plant.ppu_xe1250.form-ppu1250', [ 'approvalList' => HrdHelper::getApprovalList() ] );
    }

    public function Store( Request $request ) {

        $data = [
            'doc_number' => $this->generateDocNumber(),
            'unit_model' => 'XCMG XE1250',
            'inspection_date' =>$request->ins_date,
            'sn_unit' => $request->unit_sn,
            'smr_hm' => $request->smr ,
            'work_operation' => $request->work_op,
            'ground_condition' => $request->ground_condition,
            'condition_area' => $request->condition_area,
            'content_summary' => $request->summary,
            'checked_1' => $request->checked1,
            'checked_2' => $request->validated,
            'validated' => $request->checked2,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()

        ];

        $detail = [
            'doc_number_id' => $this->generateDocNumber(),
            'link_pitch' =>json_encode( array_values( $request->link_pitch ) ),
            'link_height' =>json_encode( array_values( $request->link_Height ) ),
            'link_bushing' =>json_encode( array_values( $request->link_bushing ) ),
            'grouser_height' =>json_encode( array_values( $request->grouser_height ) ),
            'idler' => json_encode( array_values( $request->idler ) ),
            'sprocket' =>json_encode( array_values( $request->sprocket ) ),
            'carrier_roller1' =>json_encode( array_values( $request->carrier_roller1 ) ),
            'carrier_roller2' =>json_encode( array_values( $request->carrier_roller2 ) ),
            'carrier_roller3' =>json_encode( array_values( $request->carrier_roller3 ) ),
            'track_roller' => json_encode( array_values( $request->track_roller ) ),
            'tem_link_pitch' =>json_encode( array_values( $request->tem_link_pitch ) ),
            'tem_link_height' =>json_encode( array_values( $request->tem_link_height ) ),
            'tem_link_bushing' =>json_encode( array_values( $request->tem_link_bushing ) ),
            'tem_grouser_height' =>json_encode( array_values( $request->tem_grouser_height ) ),
            'tem_idler' =>json_encode( array_values( $request->tem_idler ) ),
            'tem_sprocket' =>json_encode( array_values( $request->tem_sprocket ) ),
            'tem_carrier_roller' =>json_encode( array_values( $request->tem_carrier_roller ) ),
            'tem_track_roller' =>json_encode( array_values( $request->tem_track_roller ) ),
        ];

        DB::table( 'ppu_xe1250' )->insert( $data );
        DB::table( 'detail_ppu_xe1250' )->insert( $detail );
        return response()->json( [
            'success' => true,
            'message' => 'Data berhasil disimpan'
        ] );

    }

    public function detail( $id ) {
        $data = DB::table( 'ppu_xe1250' )
        ->where( 'id', $id )
        ->first();

        $detail = DB::table( 'detail_ppu_xe1250' )
        ->where( 'doc_number_id', $data->doc_number )
        ->first();

        $data->link_pitch = json_decode( $detail->link_pitch );
        $data->link_height = json_decode( $detail->link_height );
        $data->link_bushing = json_decode( $detail->link_bushing );
        $data->grouser_height = json_decode( $detail->grouser_height );
        $data->idler = json_decode( $detail->idler );
        $data->sprocket = json_decode( $detail->sprocket);

        $data->carrier_roller1 = json_decode( $detail->carrier_roller1 );
        $data->carrier_roller2 = json_decode( $detail->carrier_roller2 );
        $data->carrier_roller3 = json_decode( $detail->carrier_roller3 );
        $data->track_roller = json_decode( $detail->track_roller);
        $data->tem_link_pitch = json_decode( $detail->tem_link_pitch );
        $data->tem_link_height = json_decode( $detail->tem_link_height );

        $data->tem_link_bushing = json_decode( $detail->tem_link_bushing );
        $data->tem_grouser_height = json_decode( $detail->tem_grouser_height );
        $data->tem_idler = json_decode( $detail->tem_idler );
        $data->tem_sprocket = json_decode( $detail->tem_sprocket );
        $data->tem_carrier_roller = json_decode( $detail->tem_carrier_roller );
        $data->tem_track_roller = json_decode( $detail->tem_track_roller );
        return view( 'smartform::plant.ppu_xe1250.show-ppu1250', [ 'data' => $data,  'approvalList' => HrdHelper::getApprovalList() ] );
    }

    public function Export( $id ) {

        try {
            $data = DB::table( 'ppu_xe1250' )
            ->where( 'id', $id )
            ->first();

            $detail = DB::table( 'detail_ppu_xe1250' )
            ->where( 'doc_number_id', $data->doc_number )
            ->first();
           

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
            $pdf = PDF::loadView( 'smartform::plant.ppu_xe1250.export-pdf', [
                'data' => $data, 'list' => $list,

            ] );
            $pdf->setPaper( 'A4', 'landscape' );

            return $pdf->download( 'PPM XCMG XE700D - ' . $data->doc_num .'.pdf' );

        } catch ( \Exception $e ) {
            Log::error( 'Error in ExportForm: ' . $e->getMessage() );
            return redirect()
            ->route( 'prod.form.checker.dashboard' )
            ->with( 'error', 'Failed to generate PDF: ' . $e->getMessage() );
        }
    }

    public function Update ( Request $request ) {
        $data = [
            'doc_number' => $request->doc_number,
            'unit_model' => $request->unit_model,
            'inspection_date' =>$request->ins_date,
            'sn_unit' => $request->unit_sn,
            'smr_hm' => $request->smr ,
            'work_operation' => $request->work_op,
            'ground_condition' => $request->ground_condition,
            'condition_area' => $request->condition_area,
            'content_summary' => $request->summary,
            'checked_1' => $request->checked1,
            'checked_2' => $request->validated,
            'validated' => $request->checked2,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()

        ];

       

        $detail = [
            'doc_number_id' =>$request->doc_number,
            'link_pitch' =>json_encode( array_values( $request->link_pitch ) ),
            'link_height' =>json_encode( array_values( $request->link_Height ) ),
            'link_bushing' =>json_encode( array_values( $request->link_bushing ) ),
            'grouser_height' =>json_encode( array_values( $request->grouser_height ) ),
            'idler' => json_encode( array_values( $request->idler ) ),
            'sprocket' =>json_encode( array_values( $request->sprocket ) ),
            'carrier_roller1' =>json_encode( array_values( $request->carrier_roller1 ) ),
            'carrier_roller2' =>json_encode( array_values( $request->carrier_roller2 ) ),
            'carrier_roller3' =>json_encode( array_values( $request->carrier_roller3 ) ),
            'track_roller' => json_encode( array_values( $request->track_roller ) ),
            'tem_link_pitch' =>json_encode( array_values( $request->tem_link_pitch ) ),
            'tem_link_height' =>json_encode( array_values( $request->tem_link_height ) ),
            'tem_link_bushing' =>json_encode( array_values( $request->tem_link_bushing ) ),
            'tem_grouser_height' =>json_encode( array_values( $request->tem_grouser_height ) ),
            'tem_idler' =>json_encode( array_values( $request->tem_idler ) ),
            'tem_sprocket' =>json_encode( array_values( $request->tem_sprocket ) ),
            'tem_carrier_roller' =>json_encode( array_values( $request->tem_carrier_roller ) ),
            'tem_track_roller' =>json_encode( array_values( $request->tem_track_roller ) ),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ];

        DB::table( 'ppu_xe1250' )
        ->where( 'doc_number', $request->doc_number )
        ->update( $data );

        DB::table( 'detail_ppu_xe1250' )
        ->where( 'doc_number_id', $request->doc_number )
        ->update( $detail );
        return response()->json( [
            'success' => true,
            'message' => 'Data berhasil diupdate'
        ] );

    }

    public function Delete( $id ) {
        try {
            $id = request()->id;
            DB::table( 'ppu_xe1250' )
            ->where( 'doc_number', $id )
            ->delete();
            $id = request()->id;
            DB::table( 'detail_ppu_xe1250' )
            ->where( 'doc_number_id', $id )
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

        $count = DB::table( 'ppu_xe1250' )
        ->whereYear( 'created_at', $today->year )
        ->whereMonth( 'created_at', $today->month )
        ->count();

        $docNumber = '';

        do {
            $count++;

            $docNumber = sprintf(
                'BSS-FRM-PLA-083-%s%s-%03d',
                $today->format( 'y' ),
                $today->format( 'm' ),
                $count
            );

            $exists = DB::table( 'ppu_xe1250' )
            ->where( 'doc_number', $docNumber )
            ->exists();

        }
        while ( $exists );
        return $docNumber;
    }

}
