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
            $query = DB::table('ppm_dh24')
                ->select('*')
                ->orderBy('created_at', 'desc');

            if ($request->has('search')) {
                $searchTerm = $request->search;
                $query->where(function($q) use ($searchTerm) {
                    $q->where('doc_num', 'like', '%'.$searchTerm.'%')
                      ->orWhere('unit_model', 'like', '%'.$searchTerm.'%')
                      ->orWhere('engine_model', 'like', '%'.$searchTerm.'%')
                      ->orWhere('job_site', 'like', '%'.$searchTerm.'%');
                });
            }

            if ($request->has('engine_model') && $request->engine_model) {
                $query->where('engine_model', $request->engine_model);
            }

            if ($request->has('job_site') && $request->job_site) {
                $query->where('job_site', $request->job_site);
            }

            $statistics = (object)[
                'total_records' => DB::table('ppm_dh24')->count(),
                'total_this_month' => DB::table('ppm_dh24')
                    ->whereMonth('created_at', now()->month)
                    ->whereYear('created_at', now()->year)
                    ->count(),
                'engine_model' => DB::table('ppm_dh24')->distinct()->count('engine_model'),
                'job_site' => DB::table('ppm_dh24')->distinct()->count('job_site'),
            ];

            $records = $query->paginate(5);
            return view('SmartForm::plant.ppm_dh24.dashboard', [
                'record' => $records,
                'statistics' => $statistics,
                'filters' => [
                    'search' => $request->search,
                    'engine_model' => $request->engine_model,
                    'job_site' => $request->job_site,
                ]
            ]);
        } catch(\Exception $e) {
            Log::error('Error in Dashboard: '.$e->getMessage());
            return redirect()->back()->with('error', 'Failed to load dashboard data: '.$e->getMessage());
        }
    }


    public function Add() {

        $json = file_get_contents( resource_path( 'data/ppm-dh24/ppm-dh24.json' ) );
        $list = json_decode( $json, true );
        return view( 'SmartForm::plant.ppm_dh24.form-create', [ 'list' => $list,  'approvalList' => HrdHelper::getApprovalList() ] );
    }

    public function Store(Request $request) {

        $data = [
            'doc_num' => $this->generateDocNumber(),
            'unit_model' => 'DH24',
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
            'created_at' => DB::raw('GETDATE()'),
            'updated_at' => DB::raw('GETDATE()')
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

    public function ExportPDF($id) {
        try {
            $data = DB::table('ppm_dh24')
                ->where('id', $id)
                ->first();

            if (!$data) {
                return redirect()->route('dashboard-dh24')->with('error', 'Data not found.');
            }

            $detail = DB::table('ppm_dh24_detail')
                ->where('ppm_dh24_id', $data->id)
                ->first();

            if (!$detail) {
                return redirect()->route('dashboard-dh24')->with('error', 'Detail data not found.');
            }

            $json = file_get_contents(resource_path('data/ppm-dh24/ppm-dh24.json'));
            $list = json_decode($json, true);

            // Cek apakah field di $detail ada, kalau tidak ada kasih default []
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
                'list' => $list
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
}
