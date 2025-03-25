<?php

namespace Modules\SmartForm\App\Http\Controllers\LOG;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Barryvdh\DomPDF\Facade\Pdf;
use Modules\SmartForm\helpers\HrdHelper;

class Pengajuan003SapController extends Controller {

    public function dashboard(Request $request) {
        try {
            $query = DB::table('pengajuan_pr_003sap')
                ->select('*')
                ->orderBy('created_at', 'desc');

            $records = $query->paginate(10);

            return view('SmartForm::LOG/003-sap/dashboard', [
                'records' => $records
            ]);

        } catch (\Exception $e) {
            Log::error('Error in Dashboard: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to load dashboard data: ' . $e->getMessage());
        }
    }

    public function createForm() {
        return view('SmartForm::LOG/003-sap/create-form',
    [
        'approvalList' => HrdHelper::getApprovalList()
    ]);
    }

    public function storeForm(Request $request) {
        try {
            $request->validate([
                // 'job_site' => 'required',
                // 'date' => 'required|date',
                // 'dibuat_oleh' => 'required',
                // 'validated' => 'required',
                // 'item_of_requisition_*' => 'required|numeric',
                // 'qty_requested_*' => 'required|numeric',
            ]);

            $headerData = [
                'job_site' => $request->input('job_site'),
                'tanggal' => $request->input('date'),
                'dibuat_oleh' => $request->input('dibuat_oleh'),
                'diperiksa_oleh' => $request->input('validated'),
                'doc_num' => $this->generateDocNumber(),
                'created_at' => now(),
                'updated_at' => now(),
            ];

            $pengajuanPrHeaderId = DB::table('pengajuan_pr_003sap')->insertGetId($headerData);

            $itemOfRequisitions = [];
            foreach ($request->input('item_of_requisition_') as $index => $item) {
                $itemOfRequisitions[] = [
                    'pengajuan_pr_003sap_id' => $pengajuanPrHeaderId,
                    'item_of_requisition' => $item,
                    'part_number' => $request->input('part_number_')[$index] ?? null,
                    'material_code' => $request->input('material_code_')[$index] ?? null,
                    'short_text' => $request->input('short_text_')[$index] ?? null,
                    'qty_requested' => $request->input('qty_requested_')[$index] ?? null,
                    'uom' => $request->input('uom_')[$index] ?? null,
                    'delivery_date' => $request->input('delivery_date_')[$index] ?? null,
                    'plant' => $request->input('plant_')[$index] ?? null,
                    'storage' => $request->input('storage_')[$index] ?? null,
                    'requisitioner' => $request->input('requisitioner_')[$index] ?? null,
                    'req_tracking_number' => $request->input('req_tracking_number_')[$index] ?? null,
                    'purchasing_group' => $request->input('purchasing_group_')[$index] ?? null,
                    'valuation_price' => $request->input('valuation_price_')[$index] ?? null,
                    'release_date' => $request->input('release_date_')[$index] ?? null,
                    'cost_center' => $request->input('cost_center_')[$index] ?? null,
                    'gl_account' => $request->input('gl_account_')[$index] ?? null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            DB::table('pengajuan_pr_003sap_detail')->insert($itemOfRequisitions);

            return redirect()->route('dashboard-003-sap')->with('success', 'Pengajuan PR berhasil disimpan.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            \Log::error('Error saving pengajuan PR (without model): ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan pengajuan PR.');
        }
    }

    private function generateDocNumber() {
        $today = Carbon::now();

        $count = DB::table( 'pengajuan_pr_003sap' )
        ->whereYear( 'created_at', $today->year )
        ->whereMonth( 'created_at', $today->month )
        ->count();

        $docNumber = '';

        do {
            $count++;

            $docNumber = sprintf(
                'BSS-FRM-PENGAJUAN-PR-003-SAP-%s%s-%03d',
                $today->format( 'y' ),
                $today->format( 'm' ),
                $count
            );

            $exists = DB::table( 'pengajuan_pr_003sap' )
            ->where( 'doc_num', $docNumber )
            ->exists();

        }
        while ( $exists );
        return $docNumber;
    }

    public function exportPDF($id) {
        $dataHeader = DB::table('pengajuan_pr_003sap')
        ->where('id', $id)
        ->first();

        if (!$dataHeader) {
            return abort(404, "Data inspeksi tidak ditemukan");
        }

        $detailItems = DB::table('pengajuan_pr_003sap_detail')
        ->where('pengajuan_pr_003sap_id', $id)
        ->get();

        $pdf = PDF::loadView('SmartForm::LOG/003-sap/pdf', compact('dataHeader', 'detailItems'));
        $pdf->setPaper( 'A4', 'landscape' );

        return $pdf->stream('PENGAJUAN-PR-003-SAP.pdf');
    }
}
