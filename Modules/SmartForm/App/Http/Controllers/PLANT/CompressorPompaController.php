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

class CompressorPompaController extends Controller {

    public function dashboard( Request $request ) {
        try {
            $query = DB::table( 'plant_pompa_compressor' )
            ->select( '*' )
            ->orderBy( 'created_at', 'desc' );

            if ( $request->has( 'search' ) ) {
                $searchTerm = $request->search;
                $query->where( function( $q ) use ( $searchTerm ) {
                    $q->where( 'doc_number', 'like', '%' . $searchTerm . '%' )
                    ->orWhere( 'unit_name', 'like', '%' . $searchTerm . '%' )
                    ->orWhere( 'location', 'like', '%' . $searchTerm . '%' )
                    ->orWhere( 'engine_model', 'like', '%' . $searchTerm . '%' )
                    ->orWhere( 'site', 'like', '%' . $searchTerm . '%' )
                    ->orWhere( 'generator_model', 'like', '%' . $searchTerm . '%' );
                }
            );
        }
        if ( $request->has( 'location' ) && $request->location ) {
            $query->where( 'location', $request->location );
        }
        if ( $request->has( 'site' ) && $request->site ) {
            $query->where( 'site', $request->site );
        }

        // Date range filter
        if ( $request->has( 'unit_name' ) && $request->unit ) {
            $query->where( 'unit_name', $request->unit );
        }
        if ( $request->has( 'date' ) && $request->date ) {
            $query->whereDate( 'created_at',  $request->date );
        }

        $statistics = ( object )[
            'total_records' => DB::table( 'plant_pompa_compressor' )->count(),
            'total_this_month' => DB::table( 'plant_pompa_compressor' )
            ->whereMonth( 'created_at', now()->month )
            ->whereYear( 'created_at', now()->year )
            ->count(),
            'location' => DB::table( 'plant_pompa_compressor' )->distinct()->count( 'location' ),
            'site' => DB::table( 'plant_pompa_compressor' )->distinct()->count( 'site' ),
        ];
        $records = $query->paginate( 10 );
        return view( 'smartform::PLANT.compressor_pompa.dashboard-compressor-pompa', [ 'records' => $records, 'statistics'=>$statistics, 'filters' => [
            'search' => $request->search,
            'location' => $request->location,
            'unit_name' => $request->unit,
            'date' => $request->date,
            'site' => $request->site
        ] ] );
    } catch( \Exception $e ) {
        Log::error( 'Error in Dashboard: ' . $e->getMessage() );
        return redirect()->back()->with( 'error', 'Failed to load dashboard data: ' . $e->getMessage() );
    }

}

public function AddFormCompressor( Request $request ) {
    try {

        if ( $request->has( 'id' ) ) {
            $record = DB::table( 'plant_pompa_compressor' )
            ->where( 'id', $request->id )
            ->first();

            if ( !$record ) {
                Log::error( 'Compressor Pompa record not found for ID: ' . $request->id );
                return redirect()->route( 'plant.compressor.dashboard' )
                ->with( 'error', 'Record not found' );
            }

            // Parse JSON arrays
            $record->paraf_item = json_decode( $record->paraf_item );
            $record->question1 = json_decode( $record->question1 );
            $record->question2 = json_decode( $record->question2 );
            $record->question3 = json_decode( $record->question3 );
            $record->question4 = json_decode( $record->question4 );
            $record->question5 = json_decode( $record->question5 );
            $record->question6 = json_decode( $record->question6 );
            $record->question7 = json_decode( $record->question7 );
            $record->question8 = json_decode( $record->question8 );
            $record->question9 = json_decode( $record->question9 );
            $record->question10 = json_decode( $record->question10 );
            $record->question11 = json_decode( $record->question11 );
            $record->question12 = json_decode( $record->question12 );
            $record->question13 = json_decode( $record->question13 );
            $record->question14 = json_decode( $record->question14 );
            $record->question15 = json_decode( $record->question15 );
            $record->question16 = json_decode( $record->question16 );
            $record->question17 = json_decode( $record->question17 );
            $record->question18 = json_decode( $record->question18 );
            $record->question19 = json_decode( $record->question19 );
            $record->question20 = json_decode( $record->question20 );
            $record->question21 = json_decode( $record->question21 );
            $record->question22 = json_decode( $record->question22 );

            Log::info( 'Compressor Pompa record loaded for ID: ' . $request->id );

            return view( 'smartform::plant.compressor_pompa.form-compressor-pompa', [
                'record' => $record,
                'isShowDetail' => true,

            ] );
        }

        return view( 'smartform::plant.compressor_pompa.form-compressor-pompa', [
            'isShowDetail' => false, ] );

        } catch ( \Exception $e ) {
            Log::error( 'Error in AddForm: ' . $e->getMessage() );
            return redirect()->route( 'plant.compressor.dashboard' )
            ->with( 'error', 'Failed to load form: ' . $e->getMessage() );
        }

    }

    public function StoreCompressor( Request $request ) {
        try {

            $data = [
                'doc_number' => $this->generateDocNumber(),
                'unit_name' => $request->unit,
                'name' => $request->nama,
                'site' => $request->site,
                'location' => $request->lokasi,
                'month' => $request->month,
                'engine_model' => $request->engine,
                'generator_model' => $request->generator,
                'catatan' => $request->catatan ?? '',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ];

            $item = [];

            for ( $i = 1; $i <= 31; $i++ ) {
                $item[] = [
                    $question1[] = $request->input( "before-1-$i" ) ?? 0,
                    $question2[] = $request->input( "before-2-$i" ) ?? 0,
                    $question3[] = $request->input( "before-3-$i" ) ?? 0,
                    $question4[] = $request->input( "before-4-$i" ) ?? 0,
                    $question5[] = $request->input( "before-5-$i" ) ?? 0,
                    $question6[] = $request->input( "before-6-$i" ) ?? 0,
                    $question7[] = $request->input( "before-7-$i" ) ?? 0,
                    $question8[] = $request->input( "before-8-$i" ) ?? 0,
                    $question9[] = $request->input( "before-9-$i" ) ?? 0,
                    $question10[] = $request->input( "before-10-$i" ) ?? 0,
                    $question11[] = $request->input( "before-11-$i" ) ?? 0,
                    $question12[] = $request->input( "before-12-$i" ) ?? 0,
                    $question13[] = $request->input( "before-13-$i" ) ?? 0,
                    $question14[] = $request->input( "before-14-$i" ) ?? 0,
                    $question15[] = $request->input( "before-15-$i" ) ?? 0,
                    $question16[] = $request->input( "before-16-$i" ) ?? 0,
                    $question17[] = $request->input( "after-1-$i" ) ?? 0,
                    $question18[] = $request->input( "after-2-$i" ) ?? 0,
                    $question19[] = $request->input( "after-3-$i" ) ?? 0,
                    $question20[] = $request->input( "after-4-$i" ) ?? 0,
                    $question21[] = $request->input( "after-5-$i" ) ?? 0,
                    $question22[] = $request->input( "after-6-$i" ) ?? 0,

                ];
                $paraf[] = $request->input( "paraf-$i" )??0;
            }

            $data[ 'paraf_item' ] = json_encode( array_values( $paraf ) );
            $data[ 'question1' ] = json_encode( array_values( $question1 ) );
            $data[ 'question2' ] = json_encode( array_values( $question2 ) );
            $data[ 'question3' ] = json_encode( array_values( $question3 ) );
            $data[ 'question4' ] = json_encode( array_values( $question4 ) );
            $data[ 'question5' ] = json_encode( array_values( $question5 ) );
            $data[ 'question6' ] = json_encode( array_values( $question6 ) );
            $data[ 'question7' ] = json_encode( array_values( $question7 ) );
            $data[ 'question8' ] = json_encode( array_values( $question8 ) );
            $data[ 'question9' ] = json_encode( array_values( $question9 ) );
            $data[ 'question10' ] = json_encode( array_values( $question10 ) );
            $data[ 'question11' ] = json_encode( array_values( $question11 ) );
            $data[ 'question12' ] = json_encode( array_values( $question12 ) );
            $data[ 'question13' ] = json_encode( array_values( $question13 ) );
            $data[ 'question14' ] = json_encode( array_values( $question14 ) );
            $data[ 'question15' ] = json_encode( array_values( $question15 ) );
            $data[ 'question16' ] = json_encode( array_values( $question16 ) );
            $data[ 'question17' ] = json_encode( array_values( $question17 ) );
            $data[ 'question18' ] = json_encode( array_values( $question18 ) );
            $data[ 'question19' ] = json_encode( array_values( $question19 ) );
            $data[ 'question20' ] = json_encode( array_values( $question20 ) );
            $data[ 'question21' ] = json_encode( array_values( $question21 ) );
            $data[ 'question22' ] = json_encode( array_values( $question22 ) );
            $id = DB::table( 'plant_pompa_compressor' )->insertGetId( $data );

            return response()->json( [
                'success' => true,
                'message' => 'Data berhasil disimpan'
            ] );

        } catch ( QueryException $e ) {
            Log::error( 'Error in Store: ' . $e->getMessage() );
            return response()->json( [
                'success' => false,
                'message' => 'Failed to save record: ' . $e->getMessage()
            ], 500 );

        }
    }

    public function UpdateCompressor( Request $request, $id ) {
        try {

            $data = [
                'doc_number' => $this->generateDocNumber(),
                'unit_name' => $request->unit,
                'name' => $request->nama,
                'location' => $request->lokasi,
                'month' => $request->month,
                'site' => $request->site,
                'engine_model' => $request->engine,
                'generator_model' => $request->generator,
                'catatan' => $request->catatan ?? '',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ];

            $item = [];

            for ( $i = 1; $i <= 31; $i++ ) {
                $item[] = [
                    $question1[] = $request->input( "before-1-$i" ) ?? 0,
                    $question2[] = $request->input( "before-2-$i" ) ?? 0,
                    $question3[] = $request->input( "before-3-$i" ) ?? 0,
                    $question4[] = $request->input( "before-4-$i" ) ?? 0,
                    $question5[] = $request->input( "before-5-$i" ) ?? 0,
                    $question6[] = $request->input( "before-6-$i" ) ?? 0,
                    $question7[] = $request->input( "before-7-$i" ) ?? 0,
                    $question8[] = $request->input( "before-8-$i" ) ?? 0,
                    $question9[] = $request->input( "before-9-$i" ) ?? 0,
                    $question10[] = $request->input( "before-10-$i" ) ?? 0,
                    $question11[] = $request->input( "before-11-$i" ) ?? 0,
                    $question12[] = $request->input( "before-12-$i" ) ?? 0,
                    $question13[] = $request->input( "before-13-$i" ) ?? 0,
                    $question14[] = $request->input( "before-14-$i" ) ?? 0,
                    $question15[] = $request->input( "before-15-$i" ) ?? 0,
                    $question16[] = $request->input( "before-16-$i" ) ?? 0,
                    $question17[] = $request->input( "after-1-$i" ) ?? 0,
                    $question18[] = $request->input( "after-2-$i" ) ?? 0,
                    $question19[] = $request->input( "after-3-$i" ) ?? 0,
                    $question20[] = $request->input( "after-4-$i" ) ?? 0,
                    $question21[] = $request->input( "after-5-$i" ) ?? 0,
                    $question22[] = $request->input( "after-6-$i" ) ?? 0,

                ];
                $paraf[] = $request->input( "paraf_$i" )??0;
            }

            $data[ 'paraf_item' ] = json_encode( array_values( $paraf ) );
            $data[ 'question1' ] = json_encode( array_values( $question1 ) );
            $data[ 'question2' ] = json_encode( array_values( $question2 ) );
            $data[ 'question3' ] = json_encode( array_values( $question3 ) );
            $data[ 'question4' ] = json_encode( array_values( $question4 ) );
            $data[ 'question5' ] = json_encode( array_values( $question5 ) );
            $data[ 'question6' ] = json_encode( array_values( $question6 ) );
            $data[ 'question7' ] = json_encode( array_values( $question7 ) );
            $data[ 'question8' ] = json_encode( array_values( $question8 ) );
            $data[ 'question9' ] = json_encode( array_values( $question9 ) );
            $data[ 'question10' ] = json_encode( array_values( $question10 ) );
            $data[ 'question11' ] = json_encode( array_values( $question11 ) );
            $data[ 'question12' ] = json_encode( array_values( $question12 ) );
            $data[ 'question13' ] = json_encode( array_values( $question13 ) );
            $data[ 'question14' ] = json_encode( array_values( $question14 ) );
            $data[ 'question15' ] = json_encode( array_values( $question15 ) );
            $data[ 'question16' ] = json_encode( array_values( $question16 ) );
            $data[ 'question17' ] = json_encode( array_values( $question17 ) );
            $data[ 'question18' ] = json_encode( array_values( $question18 ) );
            $data[ 'question19' ] = json_encode( array_values( $question19 ) );
            $data[ 'question20' ] = json_encode( array_values( $question20 ) );
            $data[ 'question21' ] = json_encode( array_values( $question21 ) );
            $data[ 'question22' ] = json_encode( array_values( $question22 ) );

            DB::table( 'prod_anak_asuh_monitoring' )
            ->where( 'id', $id )
            ->update( $data );

            return response()->json( [
                'success' => true,
                'message' => 'Data berhasil diperbarui'
            ] );

        } catch ( QueryException $e ) {
            Log::error( 'Error in Store: ' . $e->getMessage() );
            return response()->json( [
                'success' => false,
                'message' => 'Failed to save record: ' . $e->getMessage()
            ], 500 );

        }
    }

    public function ExportForm( $id ) {

        try {
            $record = DB::table( 'plant_pompa_compressor' )
            ->where( 'id', $id )
            ->first();

            if ( !$record ) {
                return redirect()
                ->route( 'plant.compressor.dashboard' )
                ->with( 'error', 'Data tidak ditemukan' );
            }

            // Helper function to safely decode JSON
            $safeJsonDecode = function( $value ) {
                if ( is_string( $value ) ) {
                    return json_decode( $value );
                } elseif ( is_array( $value ) ) {
                    return $value;
                }
                return null;
            }
            ;

            // Decode JSON arrays safely

            $record->paraf_item = $safeJsonDecode( $record->paraf_item );
            $record->question1 = $safeJsonDecode( $record->question1 );
            $record->question2 = $safeJsonDecode( $record->question2 );
            $record->question3 = $safeJsonDecode( $record->question3 );
            $record->question4 = $safeJsonDecode( $record->question4 );
            $record->question5 = $safeJsonDecode( $record->question5 );
            $record->question6 = $safeJsonDecode( $record->question6 );
            $record->question7 = $safeJsonDecode( $record->question7 );
            $record->question8 = $safeJsonDecode( $record->question8 );
            $record->question9 = $safeJsonDecode( $record->question9 );
            $record->question10 = $safeJsonDecode( $record->question10 );
            $record->question11 = $safeJsonDecode( $record->question11 );
            $record->question12 = $safeJsonDecode( $record->question12 );
            $record->question13 = $safeJsonDecode( $record->question13 );
            $record->question14 = $safeJsonDecode( $record->question14 );
            $record->question15 = $safeJsonDecode( $record->question15 );
            $record->question16 = $safeJsonDecode( $record->question16 );
            $record->question17 = $safeJsonDecode( $record->question17 );
            $record->question18 = $safeJsonDecode( $record->question18 );
            $record->question19 = $safeJsonDecode( $record->question19 );
            $record->question20 = $safeJsonDecode( $record->question20 );
            $record->question21 = $safeJsonDecode( $record->question21 );
            $record->question22 = $safeJsonDecode( $record->question22 );

            $pdf = PDF::loadView( 'smartform::plant.compressor_pompa.export-pdf', compact( 'record' ) );
            $pdf->setPaper( 'A4', 'potrait' );

            return $pdf->download( 'Compressor_Pompa_Standard' . $record->doc_number . '.pdf' );

        } catch ( \Exception $e ) {
            Log::error( 'Error in ExportForm: ' . $e->getMessage() );
            return redirect()
            ->route( 'plant.compressor.dashboard' )
            ->with( 'error', 'Failed to generate PDF: ' . $e->getMessage() );
        }
    }

    private function generateDocNumber() {
        $today = Carbon::now();

        // Initialize count
        $count = DB::table( 'plant_pompa_compressor' )
        ->whereYear( 'created_at', $today->year )
        ->whereMonth( 'created_at', $today->month )
        ->count();

        $docNumber = '';

        do {
            $count++;

            $docNumber = sprintf(
                'BSS-FRM-PLA-040-%s%s-%03d',
                $today->format( 'y' ),
                $today->format( 'm' ),
                $count
            );

            $exists = DB::table( 'plant_pompa_compressor' )
            ->where( 'doc_number', $docNumber )
            ->exists();

        }
        while ( $exists );
        return $docNumber;
    }

    public function showPDF() {
        return view( 'smartform::plant.compressor_pompa.export-pdf' );
    }

}
