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

class PpmXcmgXE1250Controller extends Controller {

    public function dashboard(Request $request) {
        try {
            $nik_session = $request->session()->get( 'username', '' );
            $query = DB::table( 'ppm_xcmg_xe1250' )
            ->select( '*' )
            ->orderBy( 'created_at', 'desc' );

            if ( $request->has( 'search' ) ) {
                $searchTerm = $request->search;
                $query->where( function( $q ) use ( $searchTerm ) {
                    $q->where( 'doc_num', 'like', '%' . $searchTerm . '%' )
                    ->orWhere( 'unit_model', 'like', '%' . $searchTerm . '%' )
                    ->orWhere( 'unit_cn', 'like', '%' . $searchTerm . '%' )
                    ->orWhere( 'job_site', 'like', '%' . $searchTerm . '%' );
                }
            );
        }
        if ( $request->has( 'unit_cn' ) && $request->unit_cn ) {
            $query->where( 'unit_cn', $request->unit_cn );
        }

        if ( $request->has( 'job_site' ) && $request->job_site ) {
            $query->where( 'job_site',  $request->job_site );
        }
        if ( $request->has( 'approval' ) && $request->approval ) {
            $query->where( 'checked_by', $request->approval )->orwhere( 'validated_by', $request->approval );
            ;
        }

        $statistics = ( object )[
            'total_records' => DB::table( 'ppm_xcmg_xe1250' )->where('delete_status', '!=', 1)->count(),
            'total_this_month' => DB::table( 'ppm_xcmg_xe1250' )
            ->where('delete_status', '!=', 1)
            ->whereMonth( 'created_at', now()->month )
            ->whereYear( 'created_at', now()->year )
            ->count(),
            'unit_cn' => DB::table( 'ppm_xcmg_xe1250' )->where('delete_status', '!=', 1)->distinct()->count( 'unit_cn' ),
            'job_site' => DB::table( 'ppm_xcmg_xe1250' )->where('delete_status', '!=', 1)->distinct()->count( 'job_site' ),
        ];

        $approvalList = HrdHelper::getApprovalList();
        $nik = collect($approvalList)->firstWhere('nama', $nik_session)->nik ?? '';

        $cn_data = DB::table( 'alat_angkut_data' )->select('no_lambung','sn_unit','model','model_engine','sn_engine')->get();

        $records = $query->where('delete_status', '!=', 1)->paginate( 5 );

        return view( 'smartform::plant.ppm_xe1250.dashboard-xe1250', [
            'record' => $records, 'session'=>$nik, 'user'=> $approvalList,
            'cn'=>$cn_data,
            'statistics'=>$statistics,
            'filters' => [
            'search' => $request->search,
            'unit_cn' => $request->unit_cn,
            'job_site' => $request->job_site,
            'approval' => $request->approval
        ] ] );
        } catch( \Exception $e ) {
            // dd($e);
            Log::error( 'Error in Dashboard: ' . $e->getMessage() );
            return redirect()->back()->with( 'error', 'Failed to load dashboard data: ' . $e->getMessage() );
        }

    }

    public function Add(Request $request) {

        $nik_session = $request->session()->get( 'username', '' );
        $approvalList = HrdHelper::getApprovalList();
        $nik = collect($approvalList)->firstWhere('nama', $nik_session)->nik ?? '';
        $json = file_get_contents( resource_path( 'data/ppm-xe1250/ppm-xe1250.json' ) );
        $list = json_decode( $json, true );
        $cn_data = DB::table( 'alat_angkut_data' )->select('no_lambung','sn_unit','model','model_engine','sn_engine')->get();

        return view( 'smartform::plant.ppm_xe1250.form-xe1250',
        compact('approvalList'),
        [
            'list' => $list,
            'cn'=>$cn_data,
            'nik'=>$nik
        ]);
    }

    public function detail($id, Request $request){

        $nik_session = $request->session()->get( 'username', '' );

        $cn_data = DB::table( 'alat_angkut_data' )->select('no_lambung','sn_unit','model','model_engine','sn_engine')->get();

        $data = DB::table( 'ppm_xcmg_xe1250' )
        ->where( 'id', $id )
        ->first();

        $detail = DB::table( 'report_ppm_xcmg_xe1250' )
        ->where( 'doc_num_id', $data->doc_num )
        ->first();
        $json = file_get_contents( resource_path( 'data/ppm-xe1250/ppm-xe1250.json' ) );
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

        $approvalList = HrdHelper::getApprovalList();
        $nik = collect($approvalList)->firstWhere('nama', $nik_session)->nik ?? '';

        return view( 'smartform::plant.ppm_xe1250.show-xe1250', [
            'data' => $data, 'list' => $list,
            'approvalList' => $approvalList,
            'nik'=>$nik,
            'cn'=>$cn_data
        ]);
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
            'status' => json_encode( array_values( [ null, null] ) ),
            'creator' => $request->checked1,
            'checked_by' => $request->checked2,
            'validated_by' =>$request->validated,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'delete_status' => 0,
            'note' => $request->note

        ];
        for ( $i = 0; $i <= 3; $i++ ) {
            $final_actual[] = $request->input( "final_actual$i" ) ?? '';
            $final_correct[] = $request->input( "final_correct$i" ) ?? '';
            $final_result[] = $request->input( "final_result$i" ) ?? '';
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


        DB::table( 'ppm_xcmg_xe1250' )->insert( $data );
        DB::table( 'report_ppm_xcmg_xe1250' )->insert( $dataDetail );
        return response()->json( [
            'success' => true,
            'message' => 'Data berhasil disimpan'
        ] );

    }

    public function Export( $id ) {

    try{

        $data = DB::table( 'ppm_xcmg_xe1250' )
        ->where( 'id', $id )
        ->first();

        if (!$data) {

            return redirect()->route('plant.ppm.xe1250.dashboard')->with('error', 'Data not found.');
        }

        $detail = DB::table( 'report_ppm_xcmg_xe1250' )
        ->where( 'doc_num_id', $data->doc_num )
        ->first();
        $json = file_get_contents( resource_path( 'data/ppm-xe1250/ppm-xe1250.json' ) );
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

        $pdf = PDF::loadView( 'smartform::plant.ppm_xe1250.export-pdf', [
            'data' => $data,
            'list' => $list,
            'approvalList' => HrdHelper::getApprovalList()

        ] );
        $pdf->setPaper('A4', 'landscape');

        return $pdf->stream( 'PPM XCMG xe1250 - ' . $data->doc_num .'.pdf' );

    } catch ( \Exception $e ) {
        // dd($e);
        Log::error( 'Error in ExportForm: ' . $e->getMessage() );
        return redirect()
        ->route( 'plant.ppm.xe1250.dashboard' )
        ->with( 'error', 'Failed to generate PDF: ' . $e->getMessage() );
    }
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
            'creator' => $request->checked1,
            'checked_by' => $request->checked2,
            'validated_by' =>$request->validated,
            'updated_at' => Carbon::now(),
            'note' => $request->note
        ];



        for ( $i = 0; $i <= 3; $i++ ) {
            $final_actual[] = $request->input( "final_actual$i" ) ?? '';
            $final_correct[] = $request->input( "final_correct$i" ) ?? '';
            $final_result[] = $request->input( "final_result$i" ) ?? '';
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
            'updated_at' => Carbon::now()
        ];


        DB::table( 'ppm_xcmg_xe1250' )
            ->where( 'doc_num', $request->doc_num )
            ->update( $data );

        DB::table( 'report_ppm_xcmg_xe1250' )
            ->where( 'doc_num_id', $request->doc_num )
            ->update( $dataDetail  );
        return response()->json( [
            'success' => true,
            'message' => 'Data berhasil diupdate'
        ] );

    }
    public function Approve( Request $request ) {

        $data = [
            'status' => json_encode( array_values( [
                $request->checked,
                $request->validated,
            ] ) ),
            'updated_at' => Carbon::now()
        ];

        DB::table( 'ppm_xcmg_xe1250' )
        ->where( 'doc_num', $request->doc_num )
        ->update( $data );

        return response()->json( [
            'success' => true,
            'message' => 'Data berhasil di Approve'
        ] );

    }
    public function show( Request $request,$id){

        // $nik_session = $request->session()->get( 'user_id', '' );
        $nik_session = $request->session()->get( 'username', '' );

        $cn_data = DB::table( 'alat_angkut_data' )->select('no_lambung','sn_unit','model','model_engine','sn_engine')->get();

        $data = DB::table( 'ppm_xcmg_xe1250' )
        ->where( 'id', $id )
        ->first();

        $detail = DB::table( 'report_ppm_xcmg_xe1250' )
        ->where( 'doc_num_id', $data->doc_num )
        ->first();
        $json = file_get_contents( resource_path( 'data/ppm-xe1250/ppm-xe1250.json' ) );
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

        $approvalList = HrdHelper::getApprovalList();
        $nik = collect($approvalList)->firstWhere('nama', $nik_session)->nik ?? '';

        return view( 'smartform::plant.ppm_xe1250.detail-xe1250', [
            'data' => $data,
            'nik' =>$nik,
            'list' => $list,
            'approvalList' => $approvalList,
            'cn'=>$cn_data
        ]);
    }

    public function Reset( $id ) {

        $data = [
            'status' => json_encode( array_values( [
                null,
                null
            ] ) ),
            'updated_at' => Carbon::now()
        ];

        DB::table( 'ppm_xcmg_xe1250' )
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

        DB::table( 'ppm_xcmg_xe1250' )
        ->where( 'doc_num', $request->doc_num )
        ->update( $data );

        return response()->json( [
            'success' => true,
            'message' => 'Data berhasil di Reject'
        ] );
    }

    public function Delete( $id ) {
        try {
            DB::table('ppm_xcmg_xe1250')
            ->where('doc_num', $id)
            ->update(['delete_status' => 1]);

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


        $count = DB::table( 'ppm_xcmg_xe1250' )
        ->whereYear( 'created_at', $today->year )
        ->whereMonth( 'created_at', $today->month )
        ->count();

        $docNumber = '';

        do {
            $count++;

            $docNumber = sprintf(
                'BSS-FRM-PLA-070-%s%s-%03d',
                $today->format( 'y' ),
                $today->format( 'm' ),
                $count
            );

            $exists = DB::table( 'ppm_xcmg_xe1250' )
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
