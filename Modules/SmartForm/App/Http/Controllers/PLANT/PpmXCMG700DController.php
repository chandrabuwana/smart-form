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
            $nik_session = $request->session()->get( 'username', '' );
            $query = DB::table( 'ppm_xcmg_xe700d' )
            ->select( '*' )
            ->orderBy( 'created_at', 'desc' );

            if ( $request->has( 'search' ) ) {
                $searchTerm = $request->search;
                $query->where( function( $q ) use ( $searchTerm ) {
                    $q->where( 'doc_num', 'like', '%' . $searchTerm . '%' )
                    ->orWhere( 'unit_cn', 'like', '%' . $searchTerm . '%' )
                    ->orWhere( 'job_site', 'like', '%' . $searchTerm . '%' );
                }
            );
        }
        if ( $request->has( 'unit_cn' ) && $request->unit_cn) {
            $query->where( 'unit_cn', $request->unit_cn );
        }

        if ( $request->has( 'job_site' ) && $request->job_site ) {
            $query->where( 'job_site',  $request->job_site );
        }
        if ( $request->has( 'validated_by' ) && $request->validated_by ) {
            $query->where( 'validated_by', $request->validated_by );
            ;
        }
        $statistics = ( object )[
            'total_records' => DB::table( 'ppm_xcmg_xe700d' )->count(),
            'total_this_month' => DB::table( 'ppm_xcmg_xe700d' )
            ->whereMonth( 'created_at', now()->month )
            ->whereYear( 'created_at', now()->year )
            ->count(),
            'engine_model' => DB::table( 'ppm_xcmg_xe700d' )->distinct()->count( 'engine_model' ),
            'job_site' => DB::table( 'ppm_xcmg_xe700d' )->distinct()->count( 'job_site' ),
        ];
$cn_data = DB::table( 'alat_angkut_data' )->select('no_lambung','sn_unit','model','model_engine','sn_engine')->get();
            $records = $query->paginate( 5 );
            return view( 'smartform::plant.ppm_700d.dashboard-700d', ['cn'=>$cn_data, 'record' => $records,'session'=>$nik_session, 'user'=> HrdHelper::getApprovalList(),  'statistics'=>$statistics, 'filters' => [
            'search' => $request->search,
            'unit_cn' => $request->unit_cn,
            'job_site' => $request->job_site,
            'validated_by' => $request->validated_by
        ] ] );
        } catch( \Exception $e ) {
            Log::error( 'Error in Dashboard: ' . $e->getMessage() );
            return redirect()->back()->with( 'error', 'Failed to load dashboard data: ' . $e->getMessage() );
        }

    }

    public function Add(Request $request) {
        $nik_session = $request->session()->get( 'username', '' );
        $json = file_get_contents( resource_path( 'data/xe700d/ppm-700.json' ) );
        $list = json_decode( $json, true );
        $cn_data = DB::table( 'alat_angkut_data' )->select('no_lambung','sn_unit','model','model_engine','sn_engine')->get();
        return view( 'smartform::plant.ppm_700d.form-700d', [ 'list' => $list, 'cn'=>$cn_data, 'nik'=>$nik_session, 'approvalList' => HrdHelper::getApprovalList() ] );
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

        $data->eng_remark = json_decode( $detail->eng_remark );

        $data->hyd_actual = json_decode( $detail->hyd_actual );
        $data->hyd_correction_made = json_decode( $detail->hyd_correction_made );
        $data->hyd_result = json_decode( $detail->hyd_result );

        $data->hyd_remark = json_decode( $detail->hyd_remark );

        $data->wo_actual = json_decode( $detail->wo_actual );
        $data->wo_correction_made = json_decode( $detail->wo_correction_made );
        $data->wo_result = json_decode( $detail->wo_result );
        $data->wo_remark = json_decode( $detail->wo_remark );

        $data->fin_actual = json_decode( $detail->fin_actual );
        $data->fin_correction_made = json_decode( $detail->fin_correction_made );
        $data->fin_result = json_decode( $detail->fin_result );
        $data->fin_remark = json_decode( $detail->fin_remark );
        $cn_data = DB::table( 'alat_angkut_data' )->select('no_lambung','sn_unit','model','model_engine','sn_engine')->get();
        return view( 'smartform::plant.ppm_700d.show-700d', [ 'cn'=>$cn_data, 'data' => $data, 'list' => $list, 'approvalList' => HrdHelper::getApprovalList() ] );
    }
    public function show( Request $request,$id){
        $nik_session = $request->session()->get( 'username', '' );

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

        $data->eng_remark = json_decode( $detail->eng_remark );

        $data->hyd_actual = json_decode( $detail->hyd_actual );
        $data->hyd_correction_made = json_decode( $detail->hyd_correction_made );
        $data->hyd_result = json_decode( $detail->hyd_result );

        $data->hyd_remark = json_decode( $detail->hyd_remark );

        $data->wo_actual = json_decode( $detail->wo_actual );
        $data->wo_correction_made = json_decode( $detail->wo_correction_made );
        $data->wo_result = json_decode( $detail->wo_result );

        $data->wo_remark = json_decode( $detail->wo_remark );

        $data->fin_actual = json_decode( $detail->fin_actual );
        $data->fin_correction_made = json_decode( $detail->fin_correction_made );
        $data->fin_result = json_decode( $detail->fin_result );

        $data->fin_remark = json_decode( $detail->fin_remark );


        return view( 'smartform::plant.ppm_700d.detail-700d', [ 'data' => $data, 'nik' =>$nik_session, 'list' => $list, 'approvalList' => HrdHelper::getApprovalList() ] );
    }

    public function Store( Request $request ) {


        $data = [
            'doc_num' => $this->generateDocNumber(),
            'unit_model' => $request->unit_model,
            'unit_sn' =>$request->unit_sn,
            'unit_cn' => $request->unit_cn,
            'engine_model' => $request->engine_model ,
            'engine_sn' => $request->engine_sn,
            'brand' => $request->brand,
            'job_site' => $request->job_site,
            'job_location' => $request->location,
            'at_inspection' => $request->at_inspec,
            'date' => $request->date,
            'creator' => $request->checked1,
            'status' => 'draft',
            'checked_by' => $request->checked2,
            'validated_by' =>$request->validated,
            'note' => $request->note,
            'date_created' => Carbon::now(),
            'date_validated' => null,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()

        ];

        for ( $i = 0; $i <= 2; $i++ ) {
            $final_actual[] = $request->input( "final_actual$i" ) ?? 0;
            $final_correct[] = $request->input( "final_correct$i" ) ?? 0;
            $final_result[] = $request->input( "final_result$i" ) ?? 0;
        }


        $dataDetail = [
            'doc_num_id' => $data[ 'doc_num' ],
            'eng_actual' =>json_encode( array_values( $request->eng_actual ) ),
            'eng_correction_made' =>json_encode( array_values( $request->eng_correct ) ),
            'eng_result' => json_encode( array_values( $request->eng_result ) ),

            'eng_remark' => json_encode( array_values( $request->eng_remarks ) ),
            'hyd_actual' => json_encode( array_values( $request->hyd_actual ) ),
            'hyd_correction_made' =>json_encode( array_values( $request->hyd_correct ) ),
            'hyd_result' => json_encode( array_values( $request->hyd_result ) ),

            'hyd_remark' => json_encode( array_values( $request->hyd_remarks ) ),
            'wo_actual' => json_encode( array_values( $request->wo_actual ) ),
            'wo_correction_made' =>json_encode( array_values( $request->wo_correct ) ),
            'wo_result' => json_encode( array_values( $request->wo_result ) ),

            'wo_remark' =>json_encode( array_values( $request->wo_remarks ) ),
            'fin_actual' => json_encode( array_values( $final_actual ) ),
            'fin_correction_made' =>json_encode( array_values( $final_correct ) ),
            'fin_result' => json_encode( array_values($final_result ) ),

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

        $data->eng_remark = json_decode( $detail->eng_remark );

        $data->hyd_actual = json_decode( $detail->hyd_actual );
        $data->hyd_correction_made = json_decode( $detail->hyd_correction_made );
        $data->hyd_result = json_decode( $detail->hyd_result );

        $data->hyd_remark = json_decode( $detail->hyd_remark );

        $data->wo_actual = json_decode( $detail->wo_actual );
        $data->wo_correction_made = json_decode( $detail->wo_correction_made );
        $data->wo_result = json_decode( $detail->wo_result );

        $data->wo_remark = json_decode( $detail->wo_remark );

        $data->fin_actual = json_decode( $detail->fin_actual );
        $data->fin_correction_made = json_decode( $detail->fin_correction_made );
        $data->fin_result = json_decode( $detail->fin_result );

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
            'status' => $request->validated,
           'date_validated' => Carbon::now(),
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
            'status' => 'draft',
            'date_validated' => null,
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
           'status' => $request->validated,
           'date_validated' => Carbon::now(),
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
            'brand' => $request->brand,
            'job_site' => $request->job_site,
            'job_location' => $request->location,
            'at_inspection' => $request->at_inspec,
            'date' => $request->date,
            'note' => $request->note,
            'checked_by' => $request->checked,
            'validated_by' =>$request->validated,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()

        ];



        for ( $i = 0; $i <= 2; $i++ ) {
            $final_actual[] = $request->input( "final_actual$i" ) ?? 0;
            $final_correct[] = $request->input( "final_correct$i" ) ?? 0;
            $final_result[] = $request->input( "final_result$i" ) ?? 0;
        }


        $dataDetail = [
            'doc_num_id' => $data[ 'doc_num' ],
            'eng_actual' =>json_encode( array_values( $request->eng_actual ) ),
            'eng_correction_made' =>json_encode( array_values( $request->eng_correct ) ),
            'eng_result' => json_encode( array_values( $request->eng_result ) ),

            'eng_remark' => json_encode( array_values( $request->eng_remarks ) ),
            'hyd_actual' => json_encode( array_values( $request->hyd_actual ) ),
            'hyd_correction_made' =>json_encode( array_values( $request->hyd_correct ) ),
            'hyd_result' => json_encode( array_values( $request->hyd_result ) ),

            'hyd_remark' => json_encode( array_values( $request->hyd_remarks ) ),
            'wo_actual' => json_encode( array_values( $request->wo_actual ) ),
            'wo_correction_made' =>json_encode( array_values( $request->wo_correct ) ),
            'wo_result' => json_encode( array_values( $request->wo_result ) ),

            'wo_remark' =>json_encode( array_values( $request->wo_remarks ) ),
            'fin_actual' => json_encode( array_values( $final_actual ) ),
            'fin_correction_made' =>json_encode( array_values( $final_correct ) ),
            'fin_result' => json_encode( array_values($final_result ) ),

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

 public function getApprovalList(Request $request)
    {
        $search = $request->input('search', '');
        $list = HrdHelper::getApprovalList($search);

        return response()->json($list);
    }
}
