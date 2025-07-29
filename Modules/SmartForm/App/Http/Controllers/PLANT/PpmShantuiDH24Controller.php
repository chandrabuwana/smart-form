<?php

namespace Modules\SmartForm\App\Http\Controllers\PLANT;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Modules\SmartForm\helpers\HrdHelper;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class PpmShantuiDH24Controller extends Controller {

    private function generateDocNumber() {
        $today = Carbon::now();

        $count = DB::table('ppm_dh24')
        ->whereYear('created_at', $today->year)
        ->whereMonth('created_at', $today->month)
        ->count();

        $docNumber = '';

        do {
            $count++;

            $docNumber = sprintf(
                'BSS-FRM-PLA-075-%s%s-%03d',
                $today->format('y'),
                $today->format('m'),
                $count
            );

            $exists = DB::table('ppm_dh24')
            ->where('doc_num', $docNumber)
            ->exists();

        }
        while ($exists);
        return $docNumber;
    }

    public function dashboard(Request $request) {
        try {
            $nik_session = $request->session()->get( 'user_id', '' );
            $query = DB::table('ppm_dh24')
                ->select('*')
                ->orderBy('created_at', 'desc');

            if ($request->has('search')) {
                $searchTerm = $request->search;
                $query->where(function($q) use ($searchTerm) {
                    $q->where('doc_num', 'like', '%'.$searchTerm.'%')
                      ->orWhere('unit_model', 'like', '%'.$searchTerm.'%')
                      ->orWhere('unit_cn', 'like', '%'.$searchTerm.'%')
                      ->orWhere('job_site', 'like', '%'.$searchTerm.'%');
                });
            }

            if ($request->has('unit_cn') && $request->unit_cn) {
                $query->where('unit_cn', $request->unit_cn);
            }

            if ($request->has('job_site') && $request->job_site) {
                $query->where('job_site', $request->job_site);
            }

            if ( $request->has( 'approval' ) && $request->approval ) {
                $query->where( 'checked_by', $request->approval )->orwhere( 'validated_by', $request->approval );
                ;
            }

            $statistics = (object)[
                'total_records' => DB::table('ppm_dh24')->count(),
                'total_this_month' => DB::table('ppm_dh24')
                    ->whereMonth('created_at', now()->month)
                    ->whereYear('created_at', now()->year)
                    ->count(),
                'unit_cn' => DB::table('ppm_dh24')->distinct()->count('unit_cn'),
                'job_site' => DB::table('ppm_dh24')->distinct()->count('job_site'),
            ];

            $cn_data = DB::table( 'alat_angkut_data' )->select('no_lambung','sn_unit','model','model_engine','sn_engine')->get();
            $records = $query->where('delete_status', '!=', 1)->paginate(5);

            return view('SmartForm::plant.ppm_dh24.dashboard', [
                'cn'=>$cn_data,
                'record' => $records,
                'statistics' => $statistics,
                'session'=>$nik_session,
                'user'=> HrdHelper::getApprovalList(), 'statistics'=>$statistics, 'filters' => [
                'search' => $request->search,
                'unit_cn' => $request->unit_cn,
                'job_site' => $request->job_site,
                'approval' => $request->approval,

            ]
            ]);
        } catch(\Exception $e) {
            Log::error('Error in Dashboard: '.$e->getMessage());
            return redirect()->back()->with('error', 'Failed to load dashboard data: '.$e->getMessage());
        }
    }


    public function Add(Request $request) {

        $nik_session = $request->session()->get( 'user_id', '' );
        $json = file_get_contents( resource_path( 'data/ppm-dh24/ppm-dh24.json' ) );
        $list = json_decode( $json, true );
        $cn_data = DB::table( 'alat_angkut_data' )->select('no_lambung','sn_unit','model','model_engine','sn_engine')->get();
        return view( 'SmartForm::plant.ppm_dh24.form-create', [
            'list' => $list,  'cn'=>$cn_data, 'approvalList' => HrdHelper::getApprovalList(),
            'nik'=>$nik_session
        ]);
    }

    public function Store(Request $request) {

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
            'checked_by' => $request->checked2,
            'validated_by' =>$request->validated,
            'note' => $request->note,
            'created_at' => DB::raw('GETDATE()'),
            'updated_at' => DB::raw('GETDATE()'),
            'delete_status' => 0,
            'status' => json_encode( array_values( [ null, null] ) )
        ];

        for ( $i = 0; $i <= 7; $i++ ) {
            $final_actual[] = $request->input( "final_actual$i" ) ?? 0;
            $final_correct[] = $request->input( "final_correct$i" ) ?? 0;
            $final_result[] = $request->input( "final_result$i" ) ?? 0;
        }

        $dataDetail = [
            'doc_num_id' => $data['doc_num'],
            'eng_actual' => json_encode(array_values($request->eng_actual ?? [])),
            'eng_correction_made' => json_encode(array_values($request->eng_correct ?? [])),
            'eng_result' => json_encode(array_values($request->eng_result ?? [])),
            'eng_pr' => json_encode(array_values($request->eng_pr_no ?? [])),
            'eng_taggal' => json_encode(array_values($request->eng_tanggal ?? [])),
            'eng_remark' => $request->eng_remarks ?? '',
            'hyd_actual' => json_encode(array_values($request->hyd_actual ?? [])),
            'hyd_correction_made' => json_encode(array_values($request->hyd_correct ?? [])),
            'hyd_result' => json_encode(array_values($request->hyd_result ?? [])),
            'hyd_pr' => json_encode(array_values($request->hyd_pr_no ?? [])),
            'hyd_taggal' => json_encode(array_values($request->hyd_tanggal ?? [])),
            'hyd_remark' => $request->hyd_remarks ?? '',
            'wo_actual' => json_encode(array_values($request->wo_actual ?? [])),
            'wo_correction_made' => json_encode(array_values($request->wo_correct ?? [])),
            'wo_result' => json_encode(array_values($request->wo_result ?? [])),
            'wo_pr' => json_encode(array_values($request->wo_pr_no ?? [])),
            'wo_taggal' => json_encode(array_values($request->wo_tanggal ?? [])),
            'wo_remark' => $request->wo_remarks ?? '',
            'fin_actual' => json_encode(array_values($final_actual ?? [])),
            'fin_correction_made' => json_encode(array_values($final_correct ?? [])),
            'fin_result' => json_encode(array_values($final_result ?? [])),
            'fin_pr' => json_encode(array_values($request->final_pr_no ?? [])),
            'fin_taggal' => json_encode(array_values($request->final_tanggal ?? [])),
            'fin_remark' => json_encode(array_values($request->final_remarks ?? [])),
            'created_at' => DB::raw('GETDATE()'),
            'updated_at' => DB::raw('GETDATE()')
        ];

        DB::table('ppm_dh24')->insert($data);
        DB::table('ppm_dh24_detail')->insert($dataDetail);

        return response()->json( [
            'success' => true,
            'message' => 'Data berhasil disimpan'
        ] );
    }

    public function Update(Request $request) {
        $data = [
            'doc_num' => $request->doc_num,
            'unit_model' => $request->unit_model,
            'unit_sn' => $request->unit_sn,
            'unit_cn' => $request->unit_cn,
            'engine_model' => $request->engine_model,
            'engine_sn' => $request->engine_sn,
            'brand' => $request->brand,
            'job_site' => $request->job_site,
            'job_location' => $request->location,
            'at_inspection' => $request->at_inspec,
            'date' => $request->date,
            'creator' => $request->checked1,
            'checked_by' => $request->checked2,
            'validated_by' => $request->validated,
            'note' => $request->note,
            'updated_at' => DB::raw('GETDATE()'),
            'status' => json_encode([null, null])
        ];

        $ppm_dh24_id = DB::table('ppm_dh24')->updateOrInsert(
            ['doc_num' => $request->doc_num],
            $data
        );

        for ($i = 0; $i <= 7; $i++) {
            $final_actual[] = $request->input("final_actual$i") ?? 0;
            $final_correct[] = $request->input("final_correct$i") ?? 0;
            $final_result[] = $request->input("final_result$i") ?? 0;
        }

        $dataDetail = [
            'ppm_dh24_id' => $ppm_dh24_id,
            'doc_num_id' => $data['doc_num'],
            'eng_actual' => json_encode($request->eng_actual ?? []),
            'eng_correction_made' => json_encode($request->eng_correct ?? []),
            'eng_result' => json_encode($request->eng_result ?? []),
            'eng_pr' => json_encode($request->eng_pr_no ?? []),
            'eng_taggal' => json_encode($request->eng_tanggal ?? []),
            'eng_remark' => $request->eng_remarks ?? '',
            'hyd_actual' => json_encode($request->hyd_actual ?? []),
            'hyd_correction_made' => json_encode($request->hyd_correct ?? []),
            'hyd_result' => json_encode($request->hyd_result ?? []),
            'hyd_pr' => json_encode($request->hyd_pr_no ?? []),
            'hyd_taggal' => json_encode($request->hyd_tanggal ?? []),
            'hyd_remark' => $request->hyd_remarks ?? '',
            'wo_actual' => json_encode($request->wo_actual ?? []),
            'wo_correction_made' => json_encode($request->wo_correct ?? []),
            'wo_result' => json_encode($request->wo_result ?? []),
            'wo_pr' => json_encode($request->wo_pr_no ?? []),
            'wo_taggal' => json_encode($request->wo_tanggal ?? []),
            'wo_remark' => $request->wo_remarks ?? '',
            'fin_actual' => json_encode($final_actual),
            'fin_correction_made' => json_encode($final_correct),
            'fin_result' => json_encode($final_result),
            'fin_pr' => json_encode($request->final_pr_no ?? []),
            'fin_taggal' => json_encode($request->final_tanggal ?? []),
            'fin_remark' => json_encode($request->final_remarks ?? []),
            'updated_at' => DB::raw('GETDATE()')
        ];

        DB::table('ppm_dh24_detail')->updateOrInsert(
            ['ppm_dh24_id' => $ppm_dh24_id],
            $dataDetail
        );

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil diupdate',
            'ppm_dh24_id' => $ppm_dh24_id
        ]);
    }


    public function ExportPDF($id) {

        try {
            $data = DB::table('ppm_dh24')
                ->where('id', $id)
                ->first();

            if (!$data) {
                return redirect()->route('dashboard-dh24')->with('error', 'Data not found.');
            }

            $detail = DB::table('ppm_dh24_detail')
                ->where('doc_num_id', $data->doc_num)
                ->first();

            if (!$detail) {
                return redirect()->route('dashboard-dh24')->with('error', 'Detail data not found.');
            }

            $json = file_get_contents(resource_path('data/ppm-dh24/ppm-dh24.json'));
            $list = json_decode($json, true);

            $data->eng_actual = isset($detail->eng_actual) ? json_decode($detail->eng_actual, true) ?? [] : [];
            $data->eng_correction_made = isset($detail->eng_correction_made) ? json_decode($detail->eng_correction_made, true) ?? [] : [];
            $data->eng_result = isset($detail->eng_result) ? json_decode($detail->eng_result, true) ?? [] : [];
            $data->eng_pr = isset($detail->eng_pr) ? json_decode($detail->eng_pr, true) ?? [] : [];
            $data->eng_taggal = isset($detail->eng_taggal) ? json_decode($detail->eng_taggal, true) ?? [] : [];
            $data->eng_remark = $detail->eng_remark ?? '';

            $data->hyd_actual = isset($detail->hyd_actual) ? json_decode($detail->hyd_actual, true) ?? [] : [];
            $data->hyd_correction_made = isset($detail->hyd_correction_made) ? json_decode($detail->hyd_correction_made, true) ?? [] : [];
            $data->hyd_result = isset($detail->hyd_result) ? json_decode($detail->hyd_result, true) ?? [] : [];
            $data->hyd_pr = isset($detail->hyd_pr) ? json_decode($detail->hyd_pr, true) ?? [] : [];
            $data->hyd_taggal = isset($detail->hyd_taggal) ? json_decode($detail->hyd_taggal, true) ?? [] : [];
            $data->hyd_remark = $detail->hyd_remark ?? '';

            $data->wo_actual = isset($detail->wo_actual) ? json_decode($detail->wo_actual, true) ?? [] : [];
            $data->wo_correction_made = isset($detail->wo_correction_made) ? json_decode($detail->wo_correction_made, true) ?? [] : [];
            $data->wo_result = isset($detail->wo_result) ? json_decode($detail->wo_result, true) ?? [] : [];
            $data->wo_pr = isset($detail->wo_pr) ? json_decode($detail->wo_pr, true) ?? [] : [];
            $data->wo_taggal = isset($detail->wo_taggal) ? json_decode($detail->wo_taggal, true) ?? [] : [];
            $data->wo_remark = $detail->wo_remark ?? '';

            $data->fin_actual = isset($detail->fin_actual) ? json_decode($detail->fin_actual, true) ?? [] : [];
            $data->fin_correction_made = isset($detail->fin_correction_made) ? json_decode($detail->fin_correction_made, true) ?? [] : [];
            $data->fin_result = isset($detail->fin_result) ? json_decode($detail->fin_result, true) ?? [] : [];
            $data->fin_pr = isset($detail->fin_pr) ? json_decode($detail->fin_pr, true) ?? [] : [];
            $data->fin_taggal = isset($detail->fin_taggal) ? json_decode($detail->fin_taggal, true) ?? [] : [];
            $data->fin_remark = $detail->fin_remark ?? '';

            $pdf = PDF::loadView('SmartForm::plant.ppm_dh24.pdf', [
                'data' => $data,
                'list' => $list,
                'approvalList' => HrdHelper::getApprovalList(),
            ]);

            $pdf->setPaper('A4', 'landscape');

            return $pdf->stream('PPM SHANTUI DH24' . $data->doc_num . '.pdf');
        } catch (\Exception $e) {
            dd($e);
            Log::error('Error in ExportForm: ' . $e->getMessage());
            return redirect()
                ->route('dashboard-dh24')
                ->with('error', 'Failed to generate PDF: ' . $e->getMessage());
        }
    }

    function detail($id, Request $request) {

        $nik_session = $request->session()->get( 'user_id', '' );

        $data = DB::table( 'ppm_dh24' )
        ->where( 'id', $id )
        ->first();

        $detail = DB::table( 'ppm_dh24_detail' )
        ->where('ppm_dh24_id', $data->id)
        ->first();
        $json = file_get_contents(resource_path('data/ppm-dh24/ppm-dh24.json'));
        $list = json_decode( $json, true );

        $data->eng_actual = isset($detail->eng_actual) ? json_decode($detail->eng_actual, true) ?? [] : [];
            $data->eng_correction_made = isset($detail->eng_correction_made) ? json_decode($detail->eng_correction_made, true) ?? [] : [];
            $data->eng_result = isset($detail->eng_result) ? json_decode($detail->eng_result, true) ?? [] : [];
            $data->eng_pr = isset($detail->eng_pr) ? json_decode($detail->eng_pr, true) ?? [] : [];
            $data->eng_taggal = isset($detail->eng_taggal) ? json_decode($detail->eng_taggal, true) ?? [] : [];
            $data->eng_remark = $detail->eng_remark ?? '';

            $data->hyd_actual = isset($detail->hyd_actual) ? json_decode($detail->hyd_actual, true) ?? [] : [];
            $data->hyd_correction_made = isset($detail->hyd_correction_made) ? json_decode($detail->hyd_correction_made, true) ?? [] : [];
            $data->hyd_result = isset($detail->hyd_result) ? json_decode($detail->hyd_result, true) ?? [] : [];
            $data->hyd_pr = isset($detail->hyd_pr) ? json_decode($detail->hyd_pr, true) ?? [] : [];
            $data->hyd_taggal = isset($detail->hyd_taggal) ? json_decode($detail->hyd_taggal, true) ?? [] : [];
            $data->hyd_remark = $detail->hyd_remark ?? '';

            $data->wo_actual = isset($detail->wo_actual) ? json_decode($detail->wo_actual, true) ?? [] : [];
            $data->wo_correction_made = isset($detail->wo_correction_made) ? json_decode($detail->wo_correction_made, true) ?? [] : [];
            $data->wo_result = isset($detail->wo_result) ? json_decode($detail->wo_result, true) ?? [] : [];
            $data->wo_pr = isset($detail->wo_pr) ? json_decode($detail->wo_pr, true) ?? [] : [];
            $data->wo_taggal = isset($detail->wo_taggal) ? json_decode($detail->wo_taggal, true) ?? [] : [];
            $data->wo_remark = $detail->wo_remark ?? '';

            $data->fin_actual = isset($detail->fin_actual) ? json_decode($detail->fin_actual, true) ?? [] : [];
            $data->fin_correction_made = isset($detail->fin_correction_made) ? json_decode($detail->fin_correction_made, true) ?? [] : [];
            $data->fin_result = isset($detail->fin_result) ? json_decode($detail->fin_result, true) ?? [] : [];
            $data->fin_pr = isset($detail->fin_pr) ? json_decode($detail->fin_pr, true) ?? [] : [];
            $data->fin_taggal = isset($detail->fin_taggal) ? json_decode($detail->fin_taggal, true) ?? [] : [];
            $data->fin_remark = $detail->fin_remark ?? '';

            $cn_data = DB::table( 'alat_angkut_data' )->select('no_lambung','sn_unit','model','model_engine','sn_engine')->get();

        return view('SmartForm::plant.ppm_dh24.show', [
            'data' => $data, 'cn'=>$cn_data, 'list' => $list, 'approvalList' => HrdHelper::getApprovalList(),
            'nik'=>$nik_session
        ]);
    }

    function show(Request $request, $id) {

        $nik_session = $request->session()->get( 'user_id', '' );

        $data = DB::table( 'ppm_dh24' )
        ->where( 'id', $id )
        ->first();

        $detail = DB::table( 'ppm_dh24_detail' )
        ->where('ppm_dh24_id', $data->id)
        ->first();
        $json = file_get_contents(resource_path('data/ppm-dh24/ppm-dh24.json'));
        $list = json_decode( $json, true );

        $data->eng_actual = isset($detail->eng_actual) ? json_decode($detail->eng_actual, true) ?? [] : [];
            $data->eng_correction_made = isset($detail->eng_correction_made) ? json_decode($detail->eng_correction_made, true) ?? [] : [];
            $data->eng_result = isset($detail->eng_result) ? json_decode($detail->eng_result, true) ?? [] : [];
            $data->eng_pr = isset($detail->eng_pr) ? json_decode($detail->eng_pr, true) ?? [] : [];
            $data->eng_taggal = isset($detail->eng_taggal) ? json_decode($detail->eng_taggal, true) ?? [] : [];
            $data->eng_remark = $detail->eng_remark ?? '';

            $data->hyd_actual = isset($detail->hyd_actual) ? json_decode($detail->hyd_actual, true) ?? [] : [];
            $data->hyd_correction_made = isset($detail->hyd_correction_made) ? json_decode($detail->hyd_correction_made, true) ?? [] : [];
            $data->hyd_result = isset($detail->hyd_result) ? json_decode($detail->hyd_result, true) ?? [] : [];
            $data->hyd_pr = isset($detail->hyd_pr) ? json_decode($detail->hyd_pr, true) ?? [] : [];
            $data->hyd_taggal = isset($detail->hyd_taggal) ? json_decode($detail->hyd_taggal, true) ?? [] : [];
            $data->hyd_remark = $detail->hyd_remark ?? '';

            $data->wo_actual = isset($detail->wo_actual) ? json_decode($detail->wo_actual, true) ?? [] : [];
            $data->wo_correction_made = isset($detail->wo_correction_made) ? json_decode($detail->wo_correction_made, true) ?? [] : [];
            $data->wo_result = isset($detail->wo_result) ? json_decode($detail->wo_result, true) ?? [] : [];
            $data->wo_pr = isset($detail->wo_pr) ? json_decode($detail->wo_pr, true) ?? [] : [];
            $data->wo_taggal = isset($detail->wo_taggal) ? json_decode($detail->wo_taggal, true) ?? [] : [];
            $data->wo_remark = $detail->wo_remark ?? '';

            $data->fin_actual = isset($detail->fin_actual) ? json_decode($detail->fin_actual, true) ?? [] : [];
            $data->fin_correction_made = isset($detail->fin_correction_made) ? json_decode($detail->fin_correction_made, true) ?? [] : [];
            $data->fin_result = isset($detail->fin_result) ? json_decode($detail->fin_result, true) ?? [] : [];
            $data->fin_pr = isset($detail->fin_pr) ? json_decode($detail->fin_pr, true) ?? [] : [];
            $data->fin_taggal = isset($detail->fin_taggal) ? json_decode($detail->fin_taggal, true) ?? [] : [];
            $data->fin_remark = $detail->fin_remark ?? '';

            $cn_data = DB::table( 'alat_angkut_data' )->select('no_lambung','sn_unit','model','model_engine','sn_engine')->get();

        return view('SmartForm::plant.ppm_dh24.detail', [ 'data' => $data, 'cn'=>$cn_data, 'nik' =>$nik_session, 'list' => $list, 'approvalList' => HrdHelper::getApprovalList() ] );
    }

    public function Reset( $id ) {

        $data = [
            'status' => json_encode( array_values( [
                null,
                null
            ] ) ),
            'updated_at' => Carbon::now()
        ];

        DB::table( 'ppm_dh24' )
        ->where( 'doc_num', $id )
        ->update( $data );

        return response()->json( [
            'success' => true,
            'message' => 'Data berhasil di Reset'
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

        DB::table( 'ppm_dh24' )
        ->where( 'doc_num', $request->doc_num )
        ->update( $data );

        return response()->json( [
            'success' => true,
            'message' => 'Data berhasil di Approve'
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

        DB::table( 'ppm_dh24' )
        ->where( 'doc_num', $request->doc_num )
        ->update( $data );

        return response()->json( [
            'success' => true,
            'message' => 'Data berhasil di Reject'
        ] );
    }

    public function Delete( $id ) {
        try {
            DB::table('ppm_dh24')
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
}
