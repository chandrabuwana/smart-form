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
            $nik_session = $request->session()->get( 'user_id', '' );

            $query = DB::table('pengajuan_pr_003sap')
                ->select('*')
                ->orderBy('created_at', 'desc');

            if ( $request->has( 'search' ) ) {
                    $searchTerm = $request->search;
                    $query->where( function( $q ) use ( $searchTerm ) {
                        $q->where( 'doc_num', 'like', '%' . $searchTerm . '%' )
                        ->orWhere( 'plant', 'like', '%' . $searchTerm . '%' );
                    }
                );
            }

            if ( $request->has( 'plant' ) && $request->plant ) {
                $query->where( 'plant', $request->plant );
            }

            if ( $request->has( 'approval' ) && $request->approval ) {
                $query->where( 'checked_by', $request->approval )->orwhere( 'validated_by', $request->approval );
                ;
            }

            $statistics = ( object )[
                'total_records' => DB::table( 'pengajuan_pr_003sap' )->where('delete_status', '!=', 1)->count(),
                'total_this_month' => DB::table( 'pengajuan_pr_003sap' )
                ->where('delete_status', '!=', 1)
                ->whereMonth( 'created_at', now()->month )
                ->whereYear( 'created_at', now()->year )
                ->count(),
                'plant' => DB::table( 'pengajuan_pr_003sap' )->where('delete_status', '!=', 1)->distinct()->count( 'plant' )
            ];

            $records = $query->where('delete_status', '!=', 1)->paginate(10);

            return view('SmartForm::LOG/003-sap/dashboard',
            [ 'records' => $records, 'session'=>$nik_session, 'user'=> HrdHelper::getApprovalList(), 'statistics'=>$statistics, 'filters' => [
                'search' => $request->search,
                'nama_site' => $request->nama_site,
                'dept' => $request->dept,
                'approval' => $request->approval
            ]]);

        } catch (\Exception $e) {
            Log::error('Error in Dashboard: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to load dashboard data: ' . $e->getMessage());
        }
    }

    public function createForm(Request $request) {
        $nik_session = $request->session()->get( 'user_id', '' );

        return view('SmartForm::LOG/003-sap/create-form', [

            'session'=>$nik_session,
            'approvalList' => HrdHelper::getApprovalList()
        ]);
    }

    public function storeForm(Request $request) {
        // dd($request);
        try {
            $request->validate([
                // 'plant' => 'required',
                // 'date' => 'required|date',
                // 'dibuat_oleh' => 'required',
                // 'validated' => 'required',
                // 'item_of_requisition_*' => 'required|numeric',
                // 'qty_requested_*' => 'required|numeric',
            ]);

            // dd($request);

            $headerData = [
                'plant' => $request->input('job_site'),
                'tanggal' => $request->input('date'),
                'dibuat_oleh' => $request->checked,
                // 'diperiksa_oleh' => $request->input('validated'),
                'checked_by' => $request->validated,
                'doc_num' => $this->generateDocNumber(),
                'created_at' => now(),
                'updated_at' => now(),
                'delete_status' => 0,
                'creator' => $request->session()->get( 'user_id', '' ),
                'status' => json_encode( array_values( [ null, null] ) )
            ];

            // dd($headerData);


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

    public function Delete( $id ) {
        try {
            DB::table('pengajuan_pr_003sap')
            ->where('id', $id)
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

    public function detail($id){
        $data = DB::table('pengajuan_pr_003sap')
            ->where('id', $id)
            ->first();

        if (!$data) {
            return abort(404, "Data tidak ditemukan");
        }

        $detail = DB::table( 'pengajuan_pr_003sap_detail' )
        ->where( 'pengajuan_pr_003sap_id', $id )
        ->get();

        if ($data->tanggal) {
            $tanggalString = $data->tanggal;
            $tanggalString = str_replace(':AM', ' AM', $tanggalString);
            $tanggalString = str_replace(':PM', ' PM', $tanggalString);

            try {
                $data->tanggal = Carbon::parse($tanggalString)->format('Y-m-d');
            } catch (\Exception $e) {
                dd($e);
                $data->tanggal = 'Format tanggal salah';
            }
        }

        return view('SmartForm::LOG/003-sap/detail-003sap', [
            'data' => $data,
            'detail' => $detail,
            'approvalList' => HrdHelper::getApprovalList()
        ]);
    }

    public function Update($id, Request $request) {
        try {
            $request->validate([
                // 'plant' => 'required',
                // 'date' => 'required|date',
                // 'dibuat_oleh' => 'required',
                // 'validated' => 'required',
                // 'item_of_requisition_*' => 'required|numeric',
                // 'qty_requested_*' => 'required|numeric',
            ]);

            $headerData = [
                'plant' => $request->input('job_site'),
                'tanggal' => $request->input('date'),
                'dibuat_oleh' => $request->input('dibuat_oleh'),
                // 'diperiksa_oleh' => $request->input('validated'),
                'checked_by' => $request->checked_by,
                'doc_num' => $this->generateDocNumber(),
                'created_at' => now(),
                'updated_at' => now(),
                'delete_status' => 0,
                'creator' => $request->session()->get( 'user_id', '' ),
                'status' => json_encode( array_values( [ null, null] ) )
            ];

            DB::table('pengajuan_pr_003sap')->where('id', $id)->update($headerData);

            DB::table('pengajuan_pr_003sap_detail')->where('pengajuan_pr_003sap_id', $id)->delete();

            $itemOfRequisitions = [];
            foreach ($request->input('item_of_requisition_') as $index => $item) {
                $itemOfRequisitions[] = [
                    'pengajuan_pr_003sap_id' => $id,
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

    public function show($id, Request $request){
        $nik_session = $request->session()->get( 'user_id', '' );

        $data = DB::table('pengajuan_pr_003sap')
            ->where('id', $id)
            ->first();

        if (!$data) {
            return abort(404, "Data tidak ditemukan");
        }

        $detail = DB::table( 'pengajuan_pr_003sap_detail' )
        ->where( 'pengajuan_pr_003sap_id', $id )
        ->get();

        if ($data->tanggal) {
            $tanggalString = $data->tanggal;
            $tanggalString = str_replace(':AM', ' AM', $tanggalString);
            $tanggalString = str_replace(':PM', ' PM', $tanggalString);

            try {
                $data->tanggal = Carbon::parse($tanggalString)->format('Y-m-d');
            } catch (\Exception $e) {
                dd($e);
                $data->tanggal = 'Format tanggal salah';
            }
        }

        return view('SmartForm::LOG/003-sap/show-003sap', [
            'data' => $data,
            'nik' =>$nik_session,
            'detail' => $detail,
            'approvalList' => HrdHelper::getApprovalList()
        ]);
    }

    public function Approve( Request $request ) {

        $data = [
            'status' => json_encode( array_values( [
                $request->dibuat_oleh,
                $request->checked_by,
            ] ) ),
            'updated_at' => Carbon::now()
        ];

        DB::table( 'pengajuan_pr_003sap' )
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

        DB::table( 'pengajuan_pr_003sap' )
        ->where( 'doc_num', $id )
        ->update( $data );

        return response()->json( [
            'success' => true,
            'message' => 'Data berhasil di Reset'
        ] );

    }

    public function Reject( Request $request ) {
        // dd($request);
        $data = [
            'status' => json_encode( array_values( [
                $request->dibuat_oleh,
                $request->checked_by,

            ] ) ),
            'updated_at' => Carbon::now()
        ];
        ;

        DB::table( 'pengajuan_pr_003sap' )
        ->where( 'doc_num', $request->doc_num )
        ->update( $data );

        return response()->json( [
            'success' => true,
            'message' => 'Data berhasil di Reject'
        ] );
    }

    public function getApprovalList(Request $request)
    {
        $search = $request->input('search', '');
        $list = HrdHelper::getApprovalList($search);

        return response()->json($list);
    }
}
