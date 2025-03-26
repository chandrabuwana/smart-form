<?php

namespace Modules\SmartForm\App\Http\Controllers\LOG;

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

class OgcComplianceController extends Controller {
    public function dashboard( Request $request ) {
            try {
                $nik_session = $request->session()->get( 'user_id', '' );
                // $query = DB::table('log_ogc_compliance as log')
                // ->join('detail_log_ogc_compliance as detail', function ($join) {
                //     $join->on('log.doc_num', '=', 'detail.doc_num_id')
                //          ->whereRaw('detail.created_at = (
                //              SELECT MAX(d.created_at) 
                //              FROM detail_log_ogc_compliance d 
                //              WHERE d.doc_num_id = log.doc_num
                //          )');
                // })
                // ->select('log.id', 'log.doc_num',  'log.created_at','log.creator', 'detail.status') 
                // ->orderBy('log.created_at', 'desc');
     
                $query = DB::table('log_ogc_compliance as log')
                ->join(
                    DB::raw("(SELECT doc_num_id, 
                                     (SELECT status 
                                      FROM detail_log_ogc_compliance 
                                      WHERE doc_num_id = d.doc_num_id 
                                      FOR JSON PATH) AS combined_status 
                              FROM detail_log_ogc_compliance d 
                              GROUP BY doc_num_id) AS detail"), 
                    'log.doc_num', '=', 'detail.doc_num_id'
                )
                ->select(
                    'log.id', 
                    'log.doc_num',  
                    'log.created_at', 
                    'log.creator', 
                    'detail.combined_status'
                )
                ->groupBy('log.id', 'log.doc_num', 'log.created_at', 'log.creator', 'detail.combined_status')
                ->orderBy('log.created_at', 'desc');        
              
                if ( $request->has( 'search' ) ) {
                    $searchTerm = $request->search;
                    $query->where( function( $q ) use ( $searchTerm ) {
                        $q->where( 'doc_num', 'like', '%' . $searchTerm . '%' )
                        ->orWhere( 'creator', 'like', '%' . $searchTerm . '%' )
                        ->orWhere( 'status', 'like', '%' . $searchTerm . '%' );
                    }
                );
            }
            if ( $request->has( 'creator' ) && $request->creator ) {
                $query->where( 'creator', $request->creator );
            }

            $statistics = ( object )[
                'total_records' => DB::table( 'log_ogc_compliance' )->count(),
                'total_this_month' => DB::table( 'log_ogc_compliance' )
                ->whereMonth( 'created_at', now()->month )
                ->whereYear( 'created_at', now()->year )
                ->count(),
            ];

            $records = $query->paginate( 5 );
            return view( 'smartform::LOG.ogc-compliance.dashboard-ogc', [ 'record' => $records, 'session'=>$nik_session, 'user'=> HrdHelper::getApprovalList(), 'statistics'=>$statistics, 'filters' => [
                'search' => $request->search,
                'creator' => $request->creator
            ] ] );
        } catch( \Exception $e ) {
            Log::error( 'Error in Dashboard: ' . $e->getMessage() );
            return redirect()->back()->with( 'error', 'Failed to load dashboard data: ' . $e->getMessage() );
        }

    }

    public function Add( Request $request ) {
        if ( $request->has( 'id' ) ) {
            $record = DB::table('detail_log_ogc_compliance')
            ->where('doc_num_id', $request->id)
            ->get();
            $json = file_get_contents( resource_path( 'data/ogc-compliance/ogc-com.json' ) );
            $list = json_decode( $json, true );
            return view( 'smartform::LOG.ogc-compliance.form-ogc', [ 'list' => $list, 'data'=>$record, 'week' => true, 'approvalList' => HrdHelper::getApprovalList() ] );

        }else{
            $json = file_get_contents( resource_path( 'data/ogc-compliance/ogc-com.json' ) );
            $list = json_decode( $json, true );
            return view( 'smartform::LOG.ogc-compliance.form-ogc', [ 'list' => $list, 'week' => false, 'approvalList' => HrdHelper::getApprovalList() ] );

        }

    }

    public function Store( Request $request ) {

        if (!$request->has('doc_num_id')) {


            $data = [
                'doc_num' => $this->generateDocNumber(),
                'creator' => $request->session()->get( 'user_id', '' ),
               
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()

            ];
            $id =$data['doc_num'];
            DB::table( 'log_ogc_compliance' )->insert( $data );
        }else{
            $id =$request->doc_num_id;
        }


        $dataDetail = [

            'doc_num_id' => $id,
            'week' => $request->week,
            'date' => Carbon::now(),
            'lube_station' => json_encode( array_values( $request->lube_station ) ),
            'lube_truck' =>json_encode( array_values( $request->lube_truck ) ),
            'station_comment' =>json_encode( array_values( $request->station_comment ) ),
            'truck_comment' => json_encode( array_values( $request->truck_comment ) ),
            'validator' => $request->validator,
            'status' => json_encode( array_values( [ null, null ] ) ),
            'checker' => $request->known,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ];

        DB::table( 'detail_log_ogc_compliance' )->insert( $dataDetail );
        return response()->json( [
            'success' => true,
            'message' => 'Data berhasil disimpan',
            'id' => $id
        ] );

    }

    public function DeleteWeek( $id ) {
        try {
            $id = request()->id;
            $record = DB::table('detail_log_ogc_compliance')
            ->where('week', $id)
            ->first();

            DB::table( 'detail_log_ogc_compliance' )
            ->where( 'week', $id )
            ->delete();


            return response()->json( [
                'success' => true,
                'message' => 'Data berhasil dihapus',
                'id' => $record->doc_num_id
            ] );

        } catch ( QueryException $e ) {
            Log::error( 'Error in Delete: ' . $e->getMessage() );
            return response()->json( [
                'success' => false,
                'message' => 'Failed to delete record: ' . $e->getMessage()
            ], 500 );

        }
    }

    public function Delete( $id ) {
        try {
            $id = request()->id;
            DB::table( 'log_ogc_compliance' )
            ->where( 'doc_num', $id )
            ->delete();
            DB::table( 'detail_log_ogc_compliance' )
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
    public function detail($id){

        $data = DB::table('log_ogc_compliance')
        ->where('id', $id)
        ->first();


        $detail = DB::table( 'detail_log_ogc_compliance' )
        ->where( 'doc_num_id', $data->doc_num )
        ->get();

        $json = file_get_contents( resource_path( 'data/ogc-compliance/ogc-com.json' ) );
        $list = json_decode( $json, true );

        $details = collect($detail)->map(function ($detail) {
            return (object) [
                'lube_station' => json_decode($detail->lube_station ),
                'lube_truck' => json_decode($detail->lube_truck ),
                'station_comment' => json_decode($detail->station_comment ),
                'truck_comment' => json_decode($detail->truck_comment ),
                'validator' => $detail->validator ,
                'checker' => $detail->checker ,
                'date' => $detail->date ,
                'week' => $detail->week ,
            ];
        });


        return view( 'smartform::LOG.ogc-compliance.show-ogc', [ 'data' => $data, 'week' => true, 'detail' =>$detail, 'list' => $list, 'approvalList' => HrdHelper::getApprovalList() ] );


    }
    public function show(Request $request, $id){
        $nik_session = $request->session()->get( 'user_id', '' );
        $data = DB::table('log_ogc_compliance')
        ->where('id', $id)
        ->first();


        $detail = DB::table( 'detail_log_ogc_compliance' )
        ->where( 'doc_num_id', $data->doc_num )
        ->get();

        $json = file_get_contents( resource_path( 'data/ogc-compliance/ogc-com.json' ) );
        $list = json_decode( $json, true );

        $details = collect($detail)->map(function ($detail) {
            return (object) [
                'lube_station' => json_decode($detail->lube_station ),
                'lube_truck' => json_decode($detail->lube_truck ),
                'station_comment' => json_decode($detail->station_comment ),
                'truck_comment' => json_decode($detail->truck_comment ),
                'status' => json_decode($detail->status ),
                'validator' => $detail->validator ,
                'checker' => $detail->checker ,
                'date' => $detail->date ,
                'week' => $detail->week ,
            ];
        });

       

        return view( 'smartform::LOG.ogc-compliance.detail-ogc', [ 'data' => $data, 'nik'=>$nik_session,  'detail' =>$detail, 'list' => $list, 'approvalList' => HrdHelper::getApprovalList() ] );


    }
    public function Approve( Request $request ) {

        $data = [
            'status' => json_encode( array_values( [
                $request->checked,
                $request->validated,
            ] ) ),
            'updated_at' => Carbon::now()
        ];
     
    
        DB::table( 'detail_log_ogc_compliance' )
        ->where( 'doc_num_id', $request->doc_num )
        ->where( 'week', $request->week )
        ->update( $data );
    
        return response()->json( [
            'success' => true,
            'message' => 'Data berhasil di Approve'
        ] );
    
    }
    public function Reset( $id) {

        $data = [
            'status' => json_encode( array_values( [
                null,
                null
            ] ) ),
            'updated_at' => Carbon::now()
        ];
    
        DB::table( 'detail_log_ogc_compliance' )
        ->where( 'doc_num_id', $id )
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
    
        DB::table( 'detail_log_ogc_compliance' )
        ->where( 'doc_num_id', $request->doc_num )
        ->where( 'week', $request->week )
        ->update( $data );
    
        return response()->json( [
            'success' => true,
            'message' => 'Data berhasil di Reject'
        ] );
    }

    public function modal($id , $doc_num){
        $json = file_get_contents( resource_path( 'data/ogc-compliance/ogc-com.json' ) );
        $list = json_decode( $json, true );
        $data = DB::table('detail_log_ogc_compliance')
        ->where('week', $id)
        ->where('doc_num_id', $doc_num)
        ->first();
        $data->lube_station = json_decode($data->lube_station);
        $data->lube_truck = json_decode($data->lube_truck);
        $data->station_comment = json_decode($data->station_comment);
        $data->truck_comment = json_decode($data->truck_comment);
        return response()->json([
            'record' => $data,
            'list' => $list
        ] );
    }


    public function Export( $id ) {

        try {
            $data = DB::table('log_ogc_compliance')
            ->where('id', $id)
            ->first();
    
    
            $detail = DB::table('detail_log_ogc_compliance')
            ->where('doc_num_id', $data->doc_num)
            ->whereIn('week', ['week 1', 'week 2', 'week 3', 'week 4', 'week 5'])
            ->get()
            ->groupBy('week'); 
    
            $json = file_get_contents( resource_path( 'data/ogc-compliance/ogc-com.json' ) );
            $list = json_decode( $json, true );
    
            $details = $detail->mapWithKeys(fn($items, $week) => [
                $week => $items->map(fn($detail) => (object) [
                    'lube_station' => json_decode($detail->lube_station, true),
                    'lube_truck' => json_decode($detail->lube_truck, true),
                    'station_comment' => json_decode($detail->station_comment, true),
                    'truck_comment' => json_decode($detail->truck_comment, true),
                    'status' => json_decode($detail->status, true),
                    'validator' => $detail->validator,
                    'checker' => $detail->checker,
                    'date' => $detail->date,
                    'week' => $detail->week,
                ])
            ]);
            $pdf = PDF::loadView( 'smartform::LOG.ogc-compliance.export-pdf', [
                'detail' =>$details, 'list' => $list, 'approvalList' => HrdHelper::getApprovalList()
    
            ] );
            $pdf->setPaper( 'A4', 'landscape' );
    
            return $pdf->download( 'CHECKLIST OGC COMPLIANCE' . $data->doc_num .'.pdf' );
           
        } catch ( \Exception $e ) {
            Log::error( 'Error in ExportForm: ' . $e->getMessage() );
            return redirect()
            ->route( 'log.ogc.dashboard' )
            ->with( 'error', 'Failed to generate PDF: ' . $e->getMessage() );
        }
    }
    private function generateDocNumber() {
        $today = Carbon::now();

        $count = DB::table( 'log_ogc_compliance' )
        ->whereYear( 'created_at', $today->year )
        ->whereMonth( 'created_at', $today->month )
        ->count();

        $docNumber = '';

        do {
            $count++;

            $docNumber = sprintf(
                'BSS-FRM-LOG-032-%s%s-%03d',
                $today->format( 'y' ),
                $today->format( 'm' ),
                $count
            );

            $exists = DB::table( 'log_ogc_compliance' )
            ->where( 'doc_num', $docNumber )
            ->exists();

        }
        while ( $exists );
        return $docNumber;
    }
}
