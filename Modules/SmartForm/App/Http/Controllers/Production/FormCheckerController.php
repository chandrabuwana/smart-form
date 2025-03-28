<?php

namespace Modules\SmartForm\App\Http\Controllers\Production;

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

class FormCheckerController extends Controller {
    public function dashboard(Request $request) {
        $nik_session = $request->session()->get( 'user_id', '' );
        try {
            $query = DB::table( 'prod_checker_form' )
            ->select( '*' )
            ->orderBy( 'created_at', 'desc' );

            if ( $request->has( 'search' ) ) {
                $searchTerm = $request->search;
                $query->where( function( $q ) use ( $searchTerm ) {
                    $q->where( 'doc_num', 'like', '%' . $searchTerm . '%' )
                    ->orWhere( 'shift', 'like', '%' . $searchTerm . '%' )
                    ->orWhere( 'alat_muat', 'like', '%' . $searchTerm . '%' );
                }
            );
        }
        if ( $request->has( 'shift' ) && $request->shift ) {
            $query->where( 'shift', $request->shift );
        }

        if ( $request->has( 'date' ) && $request->date ) {
            $query->whereDate( 'created_at',  $request->date );
        }

        $statistics = ( object )[
            'total_records' => DB::table( 'prod_checker_form' )->count(),
            'total_this_month' => DB::table( 'prod_checker_form' )
            ->whereMonth( 'created_at', now()->month )
            ->whereYear( 'created_at', now()->year )
            ->count(),
            'alat_angkut' => DB::table( 'prod_checker_form' )->distinct()->count( 'alat_angkut' ),
        ];

            $records = $query->paginate( 5 );
            return view( 'smartform::production.form_checker.dashboard-form-checker', [ 'record' => $records, 'session'=>$nik_session, 'user'=> HrdHelper::getApprovalList(), 'statistics'=>$statistics, 'filters' => [
            'search' => $request->search,
            'shift' => $request->shift,
            'date' => $request->date,
        ] ] );
        } catch( \Exception $e ) {
            Log::error( 'Error in Dashboard: ' . $e->getMessage() );
            return redirect()->back()->with( 'error', 'Failed to load dashboard data: ' . $e->getMessage() );
        }

    }

    public function ShowFormChecker($id, Request $request) {
        $nik_session = $request->session()->get( 'user_id', '' );
        $dataDS = [
            '06-00 sd 07.00',
            '07-00 sd 08.00',
            '08-00 sd 09.00',
            '09-00 sd 10.00',
            '10-00 sd 11.00',
            '11-00 sd 12.00',
            '12-00 sd 13.00',
            '13-00 sd 14.00',
            '14-00 sd 15.00',
            '15-00 sd 16.00',
            '16-00 sd 17.00',
            '17-00 sd 18.00',
        ];
        $dataNS = [
            '18-00 sd 19.00',
            '19-00 sd 20.00',
            '20-00 sd 21.00',
            '21-00 sd 22.00',
            '22-00 sd 23.00',
            '23-00 sd 00.00',
            '00-00 sd 01.00',
            '01-00 sd 02.00',
            '02-00 sd 03.00',
            '03-00 sd 04.00',
            '04-00 sd 05.00',
            '05-00 sd 06.00',
        ];
        $record = DB::table( 'prod_checker_form' )
        ->where( 'id', $request->id )
        ->first();
        // Parse JSON arrays
        $record->alat_muat = json_decode( $record->alat_muat );
        $record->alat_angkut = json_decode( $record->alat_angkut );
        $record->nama_operator = json_decode( $record->nama_operator );
        $record->time_detail1 = json_decode( $record->time_detail1 );
        $record->time_detail2 = json_decode( $record->time_detail2 );
        $record->time_detail3 = json_decode( $record->time_detail3 );
        $record->time_detail4 = json_decode( $record->time_detail4 );
        $record->time_detail5 = json_decode( $record->time_detail5 );
        $record->time_detail6 = json_decode( $record->time_detail6 );
        $record->time_detail7 = json_decode( $record->time_detail7 );
        $record->time_detail8 = json_decode( $record->time_detail8 );
        $record->time_detail9 = json_decode( $record->time_detail9 );
        $record->time_detail10 = json_decode( $record->time_detail10 );
        $record->time_detail11 = json_decode( $record->time_detail11 );
        $record->time_detail12 = json_decode( $record->time_detail12 );
        $record->material = json_decode( $record->material );
        $record->waktu_mulai = json_decode( $record->waktu_mulai );
        $record->waktu_selesai = json_decode( $record->waktu_selesai );
        $record->keterangan = json_decode( $record->keterangan );
        $record->kendala = json_decode( $record->kendala );

        $time_details = [];


        for ($i = 1; $i <= 12; $i++) {

            $time_detail_key = "time_detail" . $i;


            if (isset($record->$time_detail_key)) {

                $time_details[$i] = $record->$time_detail_key;
            }
        }

        $nonNullCounts = [];

        foreach ($time_details as $key => $timeDetail) {
            $nonNullCounts[$key] = [];


            foreach ($timeDetail as $index => $times) {
                $nonNullCount = 0;


                foreach ($times as $time) {
                    if ($time !== null) {
                        $nonNullCount++;
                    }
                }
                $nonNullCounts[$key][$index] = $nonNullCount;
            }
        }


        return view( 'smartform::production.form_checker.detail-form-checker', [
            'record' => $record, 'dataDS' => $dataDS, 'dataNS' => $dataNS, 'nik'=>$nik_session, 'time_details' => $time_details, 'nonNullCounts' => $nonNullCounts,  'approvalList' => HrdHelper::getApprovalList()

        ] );
    }
    public function AddFormChecker( Request $request ) {
        $nik_session = $request->session()->get( 'user_id', '' );
        $dataDS = [
            '06-00 sd 07.00',
            '07-00 sd 08.00',
            '08-00 sd 09.00',
            '09-00 sd 10.00',
            '10-00 sd 11.00',
            '11-00 sd 12.00',
            '12-00 sd 13.00',
            '13-00 sd 14.00',
            '14-00 sd 15.00',
            '15-00 sd 16.00',
            '16-00 sd 17.00',
            '17-00 sd 18.00',
        ];
        $dataNS = [
            '18-00 sd 19.00',
            '19-00 sd 20.00',
            '20-00 sd 21.00',
            '21-00 sd 22.00',
            '22-00 sd 23.00',
            '23-00 sd 00.00',
            '00-00 sd 01.00',
            '01-00 sd 02.00',
            '02-00 sd 03.00',
            '03-00 sd 04.00',
            '04-00 sd 05.00',
            '05-00 sd 06.00',
        ];
        if ( $request->has( 'id' ) ) {

        }
        return view( 'smartform::production.form_checker.form-checker', ['dataDS' => $dataDS, 'nik'=>$nik_session, 'dataNS'=> $dataNS,  'approvalList' => HrdHelper::getApprovalList()] );
    }

    public function detail($id, Request $request) {
        $nik_session = $request->session()->get( 'user_id', '' );
        $dataDS = [
            '06-00 sd 07.00',
            '07-00 sd 08.00',
            '08-00 sd 09.00',
            '09-00 sd 10.00',
            '10-00 sd 11.00',
            '11-00 sd 12.00',
            '12-00 sd 13.00',
            '13-00 sd 14.00',
            '14-00 sd 15.00',
            '15-00 sd 16.00',
            '16-00 sd 17.00',
            '17-00 sd 18.00',
        ];
        $dataNS = [
            '18-00 sd 19.00',
            '19-00 sd 20.00',
            '20-00 sd 21.00',
            '21-00 sd 22.00',
            '22-00 sd 23.00',
            '23-00 sd 00.00',
            '00-00 sd 01.00',
            '01-00 sd 02.00',
            '02-00 sd 03.00',
            '03-00 sd 04.00',
            '04-00 sd 05.00',
            '05-00 sd 06.00',
        ];
        $record = DB::table( 'prod_checker_form' )
        ->where( 'id', $id )
        ->first();


        // Parse JSON arrays
        $record->alat_muat = json_decode( $record->alat_muat );
        $record->alat_angkut = json_decode( $record->alat_angkut );
        $record->nama_operator = json_decode( $record->nama_operator );
        $record->time_detail1 = json_decode( $record->time_detail1 );
        $record->time_detail2 = json_decode( $record->time_detail2 );
        $record->time_detail3 = json_decode( $record->time_detail3 );
        $record->time_detail4 = json_decode( $record->time_detail4 );
        $record->time_detail5 = json_decode( $record->time_detail5 );
        $record->time_detail6 = json_decode( $record->time_detail6 );
        $record->time_detail7 = json_decode( $record->time_detail7 );
        $record->time_detail8 = json_decode( $record->time_detail8 );
        $record->time_detail9 = json_decode( $record->time_detail9 );
        $record->time_detail10 = json_decode( $record->time_detail10 );
        $record->time_detail11 = json_decode( $record->time_detail11 );
        $record->time_detail12 = json_decode( $record->time_detail12 );
        $record->material = json_decode( $record->material );
        $record->waktu_mulai = json_decode( $record->waktu_mulai );
        $record->waktu_selesai = json_decode( $record->waktu_selesai );
        $record->keterangan = json_decode( $record->keterangan );
        $record->kendala = json_decode( $record->kendala );

        $time_details = [];


        for ($i = 1; $i <= 12; $i++) {

            $time_detail_key = "time_detail" . $i;


            if (isset($record->$time_detail_key)) {

                $time_details[$i] = $record->$time_detail_key;
            }
        }

        $nonNullCounts = [];

        foreach ($time_details as $key => $timeDetail) {
            $nonNullCounts[$key] = [];


            foreach ($timeDetail as $index => $times) {
                $nonNullCount = 0;


                foreach ($times as $time) {
                    if ($time !== null) {
                        $nonNullCount++;
                    }
                }
                $nonNullCounts[$key][$index] = $nonNullCount;
            }
        }


        return view( 'smartform::production.form_checker.show-form-checker', [
            'record' => $record, 'dataDS' => $dataDS, 'dataNS' => $dataNS, 'nik'=>$nik_session, 'time_details' => $time_details, 'nonNullCounts' => $nonNullCounts,  'approvalList' => HrdHelper::getApprovalList()

        ] );
    }

    public function Update( Request $request ) {


        try {
            $data = [
                'doc_num' => $request->doc_num,
                'tanggal' => $request->date,
                'alat_muat' => json_encode( array_values( [ $request->alat_pc, $request->alat_x ] ) ),
                'start_loading' => $request->start_load,
                'stop_loading' => $request->stop_load ,
                'shift' => $request->shift,
                'operator_leader' => $request->operator_load,
                'pic_area' => $request->nama_pic,
                'loading_point' => $request->loading_point,
                'jarak' => $request->jarak,
                'status' => $request->status,
                'disposal' => $request->disposal,
                'checker' => $request->dibuat_oleh,
                'pengawas' => $request->diperiksa_oleh,
                'waktu_mulai' => json_encode( array_values( $request->waktu_mulai ) ),
                'waktu_selesai' =>json_encode( array_values( $request->waktu_selesai ) ),
                'keterangan' =>json_encode( array_values( $request->keterangan ) ),
                'kendala' => json_encode( array_values( $request->kendala ) ),
                'updated_at' => Carbon::now()

            ];


            $alat = [];
            $time = [];
            $operator = [];

            // insert to array alat angkut, nama operator, time detail, material
            foreach ( $request->all() as $key => $value ) {

                if ( stripos( $key, 'alat_angkut' ) !== false ) {
                    $alat[] =  $value ;
                }
                if ( stripos( $key, 'nama_operator' ) !== false ) {
                    $operator[] =  $value;
                }
                if ( stripos( $key, 'time' ) !== false ) {
                    $time[] =  $value ;
                }
                if ( stripos( $key, 'material' ) !== false ) {
                    $data[ 'material' ][] =  $value;
                }
            }

            $data[ 'alat_angkut' ] = json_encode( array_values( $alat ) );
            $data[ 'nama_operator' ] = json_encode( array_values( $operator ) );


                    $filteredTime = [];
                    $filteredMaterial = [];
                    foreach ($time as $array) {
                    $filteredTime[] = array_slice($array, 0, 12);
                    }
                    foreach ($data[ 'material' ] as $mat) {
                        $filteredMaterial[] = array_slice($mat, 0, 12);
                    }


            $time = $filteredTime ;
            $data[ 'material' ] = json_encode( array_values( $filteredMaterial ) );
            for ( $i = 0; $i < count( $time[ 0 ] );
            $i++ ) {
                $time_detail_key = 'time_detail' . ( $i + 1 );
                $time_detail_values = [];

                foreach ( $time as $detail_array ) {
                    $time_detail_values[] = $detail_array[ $i ];
                }

                $data[ $time_detail_key ] = json_encode( array_values( $time_detail_values ) );
            }

            DB::table( 'prod_checker_form' )
            ->where( 'doc_num', $request->doc_num )
            ->update( $data );
            return response()->json( [
                'success' => true,
                'message' => 'Data berhasil diUpdate'
            ] );


        } catch ( QueryException $e ) {
            Log::error( 'Error in Store: ' . $e->getMessage() );

            return response()->json( [
                'success' => false,
                'message' => 'Data gagal disimpan'
            ] );

        }
    }
    public function Approve( Request $request ) {

        $data = [
            'status' => $request->checked,
            'updated_at' => Carbon::now()
        ];

        DB::table( 'prod_checker_form' )
        ->where( 'doc_num', $request->doc_num )
        ->update( $data );

        return response()->json( [
            'success' => true,
            'message' => 'Data berhasil di Approve'
        ] );

    }
    public function Reset( $id ) {

        $data = [
            'status' => 'Draft',
            'updated_at' => Carbon::now()
        ];

        DB::table( 'prod_checker_form' )
        ->where( 'doc_num', $id )
        ->update( $data );

        return response()->json( [
            'success' => true,
            'message' => 'Data berhasil di Reset'
        ] );

    }
    public function Reject( Request $request ) {
        $data = [
            'status' => $request->checked,
            'updated_at' => Carbon::now()
        ];
        ;

        DB::table( 'prod_checker_form' )
        ->where( 'doc_num', $request->doc_num )
        ->update( $data );

        return response()->json( [
            'success' => true,
            'message' => 'Data berhasil di Reject'
        ] );
    }

    public function StoreChecker( Request $request ) {
        try {
            $data = [
                'doc_num' => $this->generateDocNumber(),
                'tanggal' => $request->date,
                'alat_muat' => json_encode( array_values( [ $request->alat_pc, $request->alat_x ] ) ),
                'start_loading' => $request->start_load,
                'stop_loading' => $request->stop_load ,
                'shift' => $request->shift,
                'operator_leader' => $request->operator_load,
                'pic_area' => $request->nama_pic,
                'status' => 'Draft',
                'loading_point' => $request->loading_point,
                'jarak' => $request->jarak,
                'disposal' => $request->disposal,
                'checker' => $request->dibuat_oleh,
                'pengawas' => $request->diperiksa_oleh,
                'waktu_mulai' => json_encode( array_values( $request->waktu_mulai ) ),
                'waktu_selesai' =>json_encode( array_values( $request->waktu_selesai ) ),
                'keterangan' =>json_encode( array_values( $request->keterangan ) ),
                'kendala' => json_encode( array_values( $request->kendala ) ),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()

            ];


            $alat = [];
            $time = [];
            $operator = [];

            // insert to array alat angkut, nama operator, time detail, material
            foreach ( $request->all() as $key => $value ) {

                if ( stripos( $key, 'alat_angkut' ) !== false ) {
                    $alat[] =  $value ;
                }
                if ( stripos( $key, 'nama_operator' ) !== false ) {
                    $operator[] =  $value;
                }
                if ( stripos( $key, 'time' ) !== false ) {
                    $time[] =  $value ;
                }
                if ( stripos( $key, 'material' ) !== false ) {
                    $data[ 'material' ][] =  $value;
                }
            }

            $data[ 'alat_angkut' ] = json_encode( array_values( $alat ) );
            $data[ 'nama_operator' ] = json_encode( array_values( $operator ) );

                if ($request->shift == 'DS') {
                    $filteredTime = [];
                    $filteredMaterial = [];
                    foreach ($time as $array) {
                    $filteredTime[] = array_slice($array, 0, 12);
                    }
                    foreach ($data[ 'material' ] as $mat) {
                        $filteredMaterial[] = array_slice($mat, 0, 12);
                    }
                } elseif ($request->shift == 'NS') {
                    $filteredMaterial = [];
                    $filteredTime = [];
                    foreach ($time as $index => $array) {
                     $filteredTime[] = array_slice($array, 12, 12);
                    }
                    foreach ($data[ 'material' ] as $mat) {
                        $filteredMaterial[] = array_slice($mat, 12, 12);
                    }
                } else {
                    $filteredMaterial = [];
                    $filteredTime = [];
                }

            $time = $filteredTime ;
            $data[ 'material' ] = json_encode( array_values( $filteredMaterial ) );
            for ( $i = 0; $i < count( $time[ 0 ] );
            $i++ ) {
                $time_detail_key = 'time_detail' . ( $i + 1 );
                $time_detail_values = [];

                foreach ( $time as $detail_array ) {
                    $time_detail_values[] = $detail_array[ $i ];
                }

                $data[ $time_detail_key ] = json_encode( array_values( $time_detail_values ) );
            }


            DB::table( 'prod_checker_form' )->insert( $data );
            return response()->json( [
                'success' => true,
                'message' => 'Data berhasil disimpan'
            ] );


        } catch ( QueryException $e ) {
            Log::error( 'Error in Store: ' . $e->getMessage() );

            return response()->json( [
                'success' => false,
                'message' => 'Data gagal disimpan'
            ] );

        }

    }

    public function Delete( $id ) {
        try {
            $id = request()->id;
            DB::table( 'prod_checker_form' )
            ->where( 'doc_num', $id )
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

    public function ExportForm( $id ) {
        $dataDS = [
            '06-00 sd 07.00',
            '07-00 sd 08.00',
            '08-00 sd 09.00',
            '09-00 sd 10.00',
            '10-00 sd 11.00',
            '11-00 sd 12.00',
            '12-00 sd 13.00',
            '13-00 sd 14.00',
            '14-00 sd 15.00',
            '15-00 sd 16.00',
            '16-00 sd 17.00',
            '17-00 sd 18.00',
        ];
        $dataNS = [
            '18-00 sd 19.00',
            '19-00 sd 20.00',
            '20-00 sd 21.00',
            '21-00 sd 22.00',
            '22-00 sd 23.00',
            '23-00 sd 00.00',
            '00-00 sd 01.00',
            '01-00 sd 02.00',
            '02-00 sd 03.00',
            '03-00 sd 04.00',
            '04-00 sd 05.00',
            '05-00 sd 06.00',
        ];
        try {
            $record = DB::table( 'prod_checker_form' )
            ->where( 'id', $id )
            ->first();

            if ( !$record ) {
                return redirect()
                ->route( 'prod.form.checker.dashboard' )
                ->with( 'error', 'Data tidak ditemukan' );
            }
            $safeJsonDecode = function( $value ) {
                if ( is_string( $value ) ) {
                    return json_decode( $value );
                } elseif ( is_array( $value ) ) {
                    return $value;
                }
                return null;
            };

             // Parse JSON arrays
             $record->alat_muat = $safeJsonDecode( $record->alat_muat );
             $record->alat_angkut =$safeJsonDecode( $record->alat_angkut );
             $record->nama_operator =$safeJsonDecode( $record->nama_operator );
             $record->time_detail1 =$safeJsonDecode( $record->time_detail1 );
             $record->time_detail2 =$safeJsonDecode( $record->time_detail2 );
             $record->time_detail3 =$safeJsonDecode( $record->time_detail3 );
             $record->time_detail4 =$safeJsonDecode( $record->time_detail4 );
             $record->time_detail5 =$safeJsonDecode( $record->time_detail5 );
             $record->time_detail6 = $safeJsonDecode( $record->time_detail6 );
             $record->time_detail7 = $safeJsonDecode( $record->time_detail7 );
             $record->time_detail8 = $safeJsonDecode( $record->time_detail8 );
             $record->time_detail9 = $safeJsonDecode( $record->time_detail9 );
             $record->time_detail10 = $safeJsonDecode( $record->time_detail10 );
             $record->time_detail11 = $safeJsonDecode( $record->time_detail11 );
             $record->time_detail12 = $safeJsonDecode( $record->time_detail12 );
             $record->material = $safeJsonDecode( $record->material );
             $record->waktu_mulai = $safeJsonDecode( $record->waktu_mulai );
             $record->waktu_selesai = $safeJsonDecode( $record->waktu_selesai );
             $record->keterangan =$safeJsonDecode( $record->keterangan );
             $record->kendala = $safeJsonDecode( $record->kendala );


            $time_details = [];


            for ($i = 1; $i <= 12; $i++) {

                $time_detail_key = "time_detail" . $i;


                if (isset($record->$time_detail_key)) {

                    $time_details[$i] = $record->$time_detail_key;
                }
            }

            $nonNullCounts = [];

            foreach ($time_details as $key => $timeDetail) {
                $nonNullCounts[$key] = [];


                foreach ($timeDetail as $index => $times) {
                    $nonNullCount = 0;


                    foreach ($times as $time) {
                        if ($time !== null) {
                            $nonNullCount++;
                        }
                    }
                    $nonNullCounts[$key][$index] = $nonNullCount;
                }
            }
            $sumRitasi = 0;
            foreach ($nonNullCounts as $key => $item) {
                foreach ($item as $value) {
                    $sumRitasi += $value;
                }
            }

            $pdf = PDF::loadView( 'smartform::production.form_checker.export-pdf', [
                'record' => $record, 'dataDS' => $dataDS, 'dataNS' => $dataNS, 'approvalList' => HrdHelper::getApprovalList(),'time_details' => $time_details, 'nonNullCounts' => $nonNullCounts, 'sumRitasi' => $sumRitasi

            ] );
            $pdf->setPaper('A4', 'landscape');

            return $pdf->download( 'Form_checker' . $record->doc_num .'.pdf' );

        } catch ( \Exception $e ) {
            Log::error( 'Error in ExportForm: ' . $e->getMessage() );
            return redirect()
            ->route( 'prod.form.checker.dashboard' )
            ->with( 'error', 'Failed to generate PDF: ' . $e->getMessage() );
        }
    }

    private function generateDocNumber() {
        $today = Carbon::now();

        // Initialize count
        $count = DB::table( 'prod_checker_form' )
        ->whereYear( 'created_at', $today->year )
        ->whereMonth( 'created_at', $today->month )
        ->count();

        $docNumber = '';

        do {
            $count++;

            $docNumber = sprintf(
                'BSS-FRM-CHECKER-%s%s-%03d',
                $today->format( 'y' ),
                $today->format( 'm' ),
                $count
            );

            $exists = DB::table( 'prod_checker_form' )
            ->where( 'doc_num', $docNumber )
            ->exists();

        }
        while ( $exists );
        return $docNumber;
    }


}
