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

class LgmgController extends Controller {

    public function Dashboard(Request $request) {
        try {
            $nik_session = $request->session()->get('user_id', '');
            $query = DB::table( 'lgmg' )
            ->select( '*' )
            ->orderBy( 'created_at', 'desc' );

            if ( $request->has( 'search' ) ) {
                $searchTerm = $request->search;
                $query->where( function( $q ) use ( $searchTerm ) {
                    $q->where( 'doc_num', 'like', '%' . $searchTerm . '%' )
                    ->orWhere( 'no_unit', 'like', '%' . $searchTerm . '%' )
                    ->orWhere( 'nama_operator', 'like', '%' . $searchTerm . '%' );
                }
            );
        }
        if ( $request->has( 'no_unit' ) && $request->no_unit ) {
            $query->where( 'no_unit', $request->no_unit );
        }
        if ( $request->has( 'nama_operator' ) && $request->nama_operator ) {
            $query->where( 'nama_operator', $request->nama_operator );
        }
        if ( $request->has( 'approval' ) && $request->approval ) {
            $query->where( 'checked_by', $request->approval )->orwhere( 'validated_by', $request->approval );
            ;
        }

        $statistics = ( object )[
            'total_records' => DB::table( 'lgmg' )->count(),
            'total_this_month' => DB::table( 'lgmg' )
            ->whereMonth( 'created_at', now()->month )
            ->whereYear( 'created_at', now()->year )
            ->count(),
            'no_unit' => DB::table( 'lgmg' )->distinct()->count( 'no_unit' ),
        ];

            $records = $query->paginate( 5 );

            return view('smartform::production.lgmg.dashboard-lgmg', [ 'record' => $records, 'session'=>$nik_session, 'user'=> HrdHelper::getApprovalList(), 'statistics'=>$statistics, 'filters' => [
            'search' => $request->search,
            'no_unit' => $request->no_unit,
            'nama_operator' => $request->nama_operator,
            'approval' => $request->approval
        ]]);
        } catch( \Exception $e ) {
            // dd($e);
            Log::error( 'Error in Dashboard: ' . $e->getMessage() );
            return redirect()->back()->with( 'error', 'Failed to load dashboard data: ' . $e->getMessage() );
        }
    }

    public function Add() {
        $pertanyaan = DB::table('lgmg_pertanyaan')
        ->select('category', 'pertanyaan', 'id')
        ->get()
        ->groupBy('category');

        return view('smartform::production.lgmg.form-lgmg', [
            'pertanyaan' => $pertanyaan,
            'approvalList' => HrdHelper::getApprovalList()
        ]);
    }

    public function Store(Request $request) {
        // dd($request);

        DB::beginTransaction();
        try {
            $lgmg_id = DB::table('lgmg')->insertGetId([
                'doc_num' => $this->generateDocNumber(),
                'nama_operator' => $request->nama_operator,
                'shift' => $request->shift,
                'nrp' => $request->nrp,
                'fuel_awal' => $request->fuel_awal !== null ? $request->fuel_awal : null,
                'fuel_akhir' => $request->fuel_akhir !== null ? $request->fuel_akhir : null,
                'tanggal' => $request->tanggal,
                'no_unit' => $request->no_unit,
                'km_star' => $request->km_star !== null ? $request->km_star : null,
                'km_akhir' => $request->km_akhir !== null ? $request->km_akhir : null,
                'hm_star' => $request->hm_star,
                'hm_akhir' => $request->hm_akhir,
                'delete_status' => 0,
                'created_at' => DB::raw('GETDATE()'),
                'updated_at' => DB::raw('GETDATE()'),
                'diisi_oleh' => $request->diisi_oleh,
                'checked_by' => $request->checked_by,
                'catatan_rm' => $request->catatan_rm,
                'creator' => $request->session()->get('user_id', ''),
                'updated_by' => $request->session()->get('user_id', ''),
                'status' => json_encode( array_values( [ null, null] ) )
            ]);


            $detailData = [];
            $keterangan = json_encode($request->keterangan);

            foreach ($request->pertanyaan_id as $index => $pertanyaan_id) {
                $questionId = $request->pertanyaan_id[$index];
                $jawaban = $request->jawaban[$questionId] ?? null;

                $detailData[] = [
                    'lgmg_id' => $lgmg_id,
                    'pertanyaan_id' => $pertanyaan_id,
                    'jawaban' => $request->jawaban[$index],
                    'category' => $request->category[$index] ?? null,
                    'created_at' => DB::raw('GETDATE()'),
                    'updated_at' => DB::raw('GETDATE()'),
                    'keterangan' => $keterangan,
                    'created_by' => $request->session()->get('user_id', ''),
                    'updated_by' => $request->session()->get('user_id', ''),
                ];
            }

            DB::table('lgmg_detail')->insert($detailData);

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Data berhasil disimpan',
                'redirect' => route('lgmg.dashboard')
            ]);
        } catch (\Exception $e) {
            // dd($e);
            DB::rollBack();
            return back()->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }

    private function generateDocNumber() {
        $today = Carbon::now();


        $count = DB::table('lgmg')
        ->whereYear( 'created_at', $today->year )
        ->whereMonth( 'created_at', $today->month )
        ->count();

        $docNumber = '';

        do {
            $count++;

            $docNumber = sprintf(
                'BSS-FRM-P2H-UNIT-CMT-LGMG-%s%s-%03d',
                $today->format( 'y' ),
                $today->format( 'm' ),
                $count
            );

            $exists = DB::table('lgmg')
            ->where( 'doc_num', $docNumber )
            ->exists();

        }
        while ( $exists );
        return $docNumber;
    }

    public function Delete( $id ) {
        try {
            DB::table('lgmg')
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

        $pertanyaan = DB::table('lgmg_pertanyaan')
        ->select('category', 'pertanyaan', 'id')
        ->get()
        ->groupBy('category');

        $lgmg = DB::table('lgmg')->where('id', $id)->first();
        $lgmg_id = $lgmg->id;

        $lgmg_detail = DB::table('lgmg_detail')->where('lgmg_id', $lgmg_id)->get();


        return view('smartform::production.lgmg.detail-lgmg', [
            'pertanyaan' => $pertanyaan,
            'lgmg' => $lgmg,
            'lgmg_detail' => $lgmg_detail,
            'approvalList' => HrdHelper::getApprovalList()
        ]);
    }

    public function update(Request $request) {
        $id = $request->id;
        // dd($request);
        DB::beginTransaction();
        try {
            DB::table('lgmg')->where('id', $id)->update([
                'nama_operator' => $request->nama_operator,
                'shift' => $request->shift,
                'nrp' => $request->nrp,
                'fuel_awal' => $request->fuel_awal !== null ? $request->fuel_awal : null,
                'fuel_akhir' => $request->fuel_akhir !== null ? $request->fuel_akhir : null,
                'tanggal' => $request->tanggal,
                'no_unit' => $request->no_unit,
                'km_star' => $request->km_star !== null ? $request->km_star : null,
                'km_akhir' => $request->km_akhir !== null ? $request->km_akhir : null,
                'hm_star' => $request->hm_star,
                'hm_akhir' => $request->hm_akhir,
                'updated_at' => DB::raw('GETDATE()'),
                'diisi_oleh' => $request->diisi_oleh,
                'checked_by' => $request->checked_by,
                'catatan_rm' => $request->catatan_rm,
                'updated_by' => $request->session()->get('user_id', ''),
                'status' => json_encode(array_values([null, null]))
            ]);

            DB::table('lgmg_detail')->where('lgmg_id', $id)->delete();

            $detailData = [];
            $keterangan = json_encode($request->keterangan);

            foreach ($request->pertanyaan_id as $index => $pertanyaan_id) {
                $detailData[] = [
                    'lgmg_id' => $id,
                    'pertanyaan_id' => $pertanyaan_id,
                    'jawaban' => $request->jawaban[$pertanyaan_id] ?? null,
                    'category' => $request->category[$index] ?? null,
                    'updated_at' => DB::raw('GETDATE()'),
                    'keterangan' => $keterangan,
                    'updated_by' => $request->session()->get('user_id', ''),
                ];
            }

            DB::table('lgmg_detail')->insert($detailData);

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Data berhasil diupdate',
                'redirect' => route('lgmg.dashboard')
            ]);
        } catch (\Exception $e) {
            // dd($e);
            DB::rollBack();
            return back()->with('error', 'Gagal mengupdate data: ' . $e->getMessage());
        }
    }

    public function show($id, Request $request){
        $nik_session = $request->session()->get('user_id', '');

        $pertanyaan = DB::table('lgmg_pertanyaan')
        ->select('category', 'pertanyaan', 'id')
        ->get()
        ->groupBy('category');

        $data = DB::table('lgmg')->where('id', $id)->first();
        $lgmg_id = $data->id;

        $lgmg_detail = DB::table('lgmg_detail')->where('lgmg_id', $lgmg_id)->get();


        return view('smartform::production.lgmg.show-lgmg', [
            'pertanyaan' => $pertanyaan,
            'data' => $data,
            'nik' =>$nik_session,
            'lgmg_detail' => $lgmg_detail,
            'approvalList' => HrdHelper::getApprovalList()
        ]);
    }

    public function Approve(Request $request)
    {
        try {
            $data = [
                'status' => json_encode(array_values([
                    $request->checked,
                    $request->validated,
                ])),
                'updated_at' => Carbon::now(),
            ];

            DB::table('lgmg')
                ->where('doc_num', $request->doc_num)
                ->update($data);

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil di Approve',
            ]);
        } catch (\Exception $e) {
            // dd($e);
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengupdate data: ' . $e->getMessage(),
            ]);
        }
    }

    public function Reset($id)
    {
        try {
            $data = [
                'status' => json_encode(array_values([
                    null,
                    null,
                ])),
                'updated_at' => Carbon::now(),
            ];

            DB::table('lgmg')
                ->where('doc_num', $id)
                ->update($data);

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil di Reset',
            ]);
        } catch (\Exception $e) {
            // dd($e);
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengupdate data: ' . $e->getMessage(),
            ]);
        }
    }

    public function Reject(Request $request)
    {
        try {
            $data = [
                'status' => json_encode(array_values([
                    $request->checked,
                    $request->validated,
                ])),
                'updated_at' => Carbon::now(),
            ];

            DB::table('lgmg')
                ->where('doc_num', $request->doc_num)
                ->update($data);

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil di Reject',
            ]);
        } catch (\Exception $e) {
            // dd($e);
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengupdate data: ' . $e->getMessage(),
            ]);
        }
    }

    public function Export($id) {
        $data = DB::table('lgmg')->where('id', $id)->first();
        $lgmg_id = $data->id;

        $pertanyaan = DB::table('lgmg_pertanyaan')
            ->select('category', 'pertanyaan', 'id')
            ->get()
            ->groupBy('category');

        // dd($pertanyaan['KABIN']);

        $lgmg_detail = DB::table('lgmg_detail')
            ->leftJoin('lgmg_pertanyaan', 'lgmg_detail.pertanyaan_id', '=', 'lgmg_pertanyaan.id')
            ->select('lgmg_detail.pertanyaan_id', 'lgmg_detail.jawaban', 'lgmg_pertanyaan.category', 'lgmg_pertanyaan.pertanyaan')
            ->where('lgmg_detail.lgmg_id', $lgmg_id)
            ->get()
            ->groupBy('category');

        // Gabungkan data pertanyaan dan jawaban
        foreach ($pertanyaan as $category => $items) {
            foreach ($items as $index => $item) {
                $jawaban = $lgmg_detail->get($category)->where('pertanyaan_id', $item->id)->first();
                $item->jawaban = $jawaban ? $jawaban->jawaban : null;
            }
        }

        $keteranganJson = DB::table('lgmg_detail')
            ->where('lgmg_id', $lgmg_id)
            ->value('keterangan');

        $keteranganArray = json_decode($keteranganJson, true);

        if (!is_array($keteranganArray)) {
            $keteranganArray = ['', '', '', ''];
        }

        $checkmark = '✔';

        $pdf = PDF::loadView('smartform::production.lgmg.export-pdf', compact(
            'data', 'pertanyaan', 'lgmg_detail', 'keteranganArray', 'checkmark'
        ));


        $pdf->setPaper('Letter');

        return $pdf->stream('BSS-FRM-P2H-UNIT-CMT-LGMG.pdf');
    }

}
