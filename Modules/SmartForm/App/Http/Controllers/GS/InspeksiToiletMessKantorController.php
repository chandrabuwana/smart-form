<?php

namespace Modules\SmartForm\App\Http\Controllers\GS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\SmartForm\helpers\HrdHelper;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;

class InspeksiToiletMessKantorController extends Controller
{
    private function generateDocNumber() {
        $today = Carbon::now();


        $count = DB::table( 'gs_inspeksi_tmk_jawaban' )
        ->whereYear( 'created_at', $today->year )
        ->whereMonth( 'created_at', $today->month )
        ->count();

        $docNumber = '';

        do {
            $count++;

            $docNumber = sprintf(
                'BSS-FRM-SHE-048-%s%s-%03d',
                $today->format( 'y' ),
                $today->format( 'm' ),
                $count
            );

            $exists = DB::table( 'gs_inspeksi_tmk_jawaban' )
            ->where( 'doc_num', $docNumber )
            ->exists();

        }
        while ( $exists );
        return $docNumber;
    }

    function Dashboard(Request $request) {

        try {
            $nik_session = $request->session()->get( 'user_id', '' );
            $query = DB::table( 'gs_inspeksi_tmk_jawaban' )
            ->select( '*' )
            ->orderBy( 'created_at', 'desc' );

            if ( $request->has( 'search' ) ) {
                $searchTerm = $request->search;
                $query->where( function( $q ) use ( $searchTerm ) {
                    $q->where( 'doc_num', 'like', '%' . $searchTerm . '%' )
                    ->orWhere( 'nama_site', 'like', '%' . $searchTerm . '%' )
                    ->orWhere( 'dept', 'like', '%' . $searchTerm . '%' );
                }
            );
        }
        if ( $request->has( 'nama_site' ) && $request->nama_site ) {
            $query->where( 'nama_site', $request->nama_site );
        }

        if ( $request->has( 'dept' ) && $request->dept ) {
            $query->where( 'dept',  $request->dept );
        }
        if ( $request->has( 'approval' ) && $request->approval ) {
            $query->where( 'checked_by', $request->approval )->orwhere( 'validated_by', $request->approval );
            ;
        }

        $statistics = ( object )[
            'total_records' => DB::table( 'gs_inspeksi_tmk_jawaban' )->count(),
            'total_this_month' => DB::table( 'gs_inspeksi_tmk_jawaban' )
            ->whereMonth( 'created_at', now()->month )
            ->whereYear( 'created_at', now()->year )
            ->count(),
            'nama_site' => DB::table( 'gs_inspeksi_tmk_jawaban' )->distinct()->count( 'nama_site' ),
            'dept' => DB::table( 'gs_inspeksi_tmk_jawaban' )->distinct()->count( 'dept' ),
        ];

            $records = $query->paginate( 5 );
            return view( 'SmartForm::GS/inspeksi-toilet-mess-kantor/dashboard', [ 'record' => $records, 'session'=>$nik_session, 'user'=> HrdHelper::getApprovalList(), 'statistics'=>$statistics, 'filters' => [
            'search' => $request->search,
            'nama_site' => $request->nama_site,
            'dept' => $request->dept,
            'approval' => $request->approval
        ] ] );
        } catch( \Exception $e ) {
            // dd($e);
            Log::error( 'Error in Dashboard: ' . $e->getMessage() );
            return redirect()->back()->with( 'error', 'Failed to load dashboard data: ' . $e->getMessage() );
        }
    }

    public function createForm(Request $request) {

        $questions = DB::table('GS_Inspeksi_TMK_pertanyaan')
            ->select('ID', 'category', 'pertanyaan', 'urutan_pertanyaan')
            ->orderByRaw("
            CASE
                WHEN category = 'TOILET' THEN 1
                WHEN category = 'MESS' THEN 2
                WHEN category = 'KANTOR' THEN 3
                ELSE 4
            END")
            ->orderBy('urutan_pertanyaan')
            ->get()
            ->groupBy('category');

        $dropdowns = [
            'Diinspeksi' => 'Diinspeksi Oleh',
            'DiinspeksiUlang' => 'Diinspeksi Ulang Oleh',
            'Mengetahui' => 'Mengetahui'
        ];

        return view("SmartForm::GS/inspeksi-toilet-mess-kantor/form-create", [
            'questions' => $questions,
            'approvalList' => HrdHelper::getApprovalList(),
            'dropdowns' => $dropdowns
        ]);

    }

    public function storeForm(Request $request) {

        $request->validate([
            'nama_site' => 'required|string',
            'dept' => 'required|string',
            'shift' => 'required|string',
            'loker' => 'required|string',
            'jml_ins' => 'required|integer',
            // 'checked_by' => 'required|string',
            // 'validated_by' => 'required|string',
            'mengetahui' => 'required|string'
            // 'pertanyaan_id.*' => 'required|integer',
            // 'jawaban.*' => 'required|string|in:Ya,Tidak'
        ]);

        // dd($request);
        DB::beginTransaction();
        try {
            $inspeksi_id = DB::table('gs_inspeksi_tmk_jawaban')->insertGetId([
                'doc_num' => $this->generateDocNumber(),
                'tgl_doc' => $request->tgl_doc,
                'nama_site' => $request->nama_site,
                'dept' => $request->dept,
                'shift' => $request->shift,
                'loker' => $request->loker,
                'jml_ins' => 5,
                'checked_by' => $request->checked_by,
                'validated_by' => $request->validated_by,
                'mengetahui' => $request->mengetahui,
                'created_at' => DB::raw('GETDATE()'),
                'updated_at' => DB::raw('GETDATE()'),
                'delete_status' => 0,
                'creator' => $request->session()->get( 'user_id', '' ),
                'status' => json_encode( array_values( [ null, null] ) )
            ]);

            if (!$inspeksi_id) {
                throw new \Exception('Gagal mendapatkan ID inspeksi.');
            }

            Log::info('Inspeksi ID berhasil dibuat', ['inspeksi_id' => $inspeksi_id]);


            $detailData = [];
            foreach ($request->pertanyaan_id as $index => $pertanyaan_id) {

                $detailData[] = [
                    'inspeksi_id' => $inspeksi_id,
                    'pertanyaan_id' => $pertanyaan_id,
                    'jawaban' => $request->jawaban[$index],
                    'resiko' => $request->resiko[$index],
                    'keterangan' => $request->keterangan[$index] ?? null,
                    'category' => $request->category[$index] ?? null,
                    'created_at' => DB::raw('GETDATE()'),
                    'updated_at' => DB::raw('GETDATE()')
                ];
            }

            Log::info('Detail data yang akan dimasukkan', ['detailData' => $detailData]);

            DB::table('gs_inspeksi_tmk_jawaban_detail')->insert($detailData);
            DB::commit();

            // return redirect()->route('dashboard-inpeksi-toilet-mess-kantor')->with('success', 'Data inspeksi berhasil disimpan.');
            return response()->json(['message' => 'Data inspeksi berhasil disimpan!', 'redirect' => route('dashboard-wc')]);
        } catch (\Exception $e) {
            // dd($e);
            DB::rollBack();
            return back()->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }

    public function list(Request $request) {

        $TABLE_MASTER = "gs_inspeksi_tmk_jawaban";
        $response = array(
            'message' => '',
            'isSuccess' => false
        );
        $sort = $request->query('sort', 'id');
        $order = $request->query('order', 'desc');
        try {
            $master = DB::table($TABLE_MASTER)
                ->select('id', 'nama_site', 'loker', 'dept');

            $master->orderBy($sort, $order);
            $jml = $master->count();
            $document = $master->get();

            $response['message'] = "Ok";
            $response['isSuccess'] = true;
            $response['data'] = [
                'total' => $jml,
                'totalNotFiltered' => $jml,
                'rows' => $document
            ];
        } catch (Exception $ex) {
            dd($ex);
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());

            $response['message'] = $ex->getMessage();
            $response['isSuccess'] = false;
        }
        return response()->json($response);
    }

    public function exportPDF($id) {
        $data = DB::table('gs_inspeksi_tmk_jawaban')
            ->where('id', $id)
            ->first();

        if (!$data) {
            return abort(404, "Data inspeksi tidak ditemukan");
        }

        $pertanyaan = DB::table('gs_inspeksi_tmk_pertanyaan')
            ->join('gs_inspeksi_tmk_jawaban_detail', 'gs_inspeksi_tmk_pertanyaan.ID', '=', 'gs_inspeksi_tmk_jawaban_detail.pertanyaan_id')
            ->where('gs_inspeksi_tmk_jawaban_detail.inspeksi_id', $id)
            ->orderByRaw("CASE
                WHEN gs_inspeksi_tmk_pertanyaan.category = 'TOILET' THEN 1
                WHEN gs_inspeksi_tmk_pertanyaan.category = 'MESS' THEN 2
                WHEN gs_inspeksi_tmk_pertanyaan.category = 'KANTOR' THEN 3
                ELSE 4 END")
            ->orderBy('gs_inspeksi_tmk_pertanyaan.urutan_pertanyaan')
            ->select(
                'gs_inspeksi_tmk_pertanyaan.category',
                'gs_inspeksi_tmk_pertanyaan.pertanyaan',
                'gs_inspeksi_tmk_jawaban_detail.jawaban',
                'gs_inspeksi_tmk_jawaban_detail.resiko',
                'gs_inspeksi_tmk_jawaban_detail.keterangan'
            )
            ->get()
            ->groupBy('category');

        $pdf = PDF::loadView('SmartForm::GS/inspeksi-toilet-mess-kantor/pdf', compact('data', 'pertanyaan'));

        return $pdf->stream('BSS-FRM-GS-ITM.pdf');
    }

    public function Delete( $id ) {
        try {
            DB::table('gs_inspeksi_tmk_jawaban')
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

    public function Approve( Request $request ) {

        $data = [
            'status' => json_encode( array_values( [
                $request->checked,
                $request->validated,
            ] ) ),
            'updated_at' => Carbon::now()
        ];

        DB::table( 'gs_inspeksi_tmk_jawaban' )
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

        DB::table( 'gs_inspeksi_tmk_jawaban' )
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

        DB::table( 'gs_inspeksi_tmk_jawaban' )
        ->where( 'doc_num', $request->doc_num )
        ->update( $data );

        return response()->json( [
            'success' => true,
            'message' => 'Data berhasil di Reject'
        ] );
    }

    public function detail($id){
        $data = DB::table('gs_inspeksi_tmk_jawaban')
            ->where('id', $id)
            ->first();

        if (!$data) {
            return abort(404, "Data inspeksi tidak ditemukan");
        }

        $pertanyaan = DB::table('gs_inspeksi_tmk_pertanyaan')
            ->leftJoin('gs_inspeksi_tmk_jawaban_detail', function ($join) use ($id) {
                $join->on('gs_inspeksi_tmk_pertanyaan.ID', '=', 'gs_inspeksi_tmk_jawaban_detail.pertanyaan_id')
                    ->where('gs_inspeksi_tmk_jawaban_detail.inspeksi_id', '=', $id);
            })
            ->orderByRaw("CASE
                WHEN gs_inspeksi_tmk_pertanyaan.category = 'TOILET' THEN 1
                WHEN gs_inspeksi_tmk_pertanyaan.category = 'MESS' THEN 2
                WHEN gs_inspeksi_tmk_pertanyaan.category = 'KANTOR' THEN 3
                ELSE 4 END")
            ->orderBy('gs_inspeksi_tmk_pertanyaan.urutan_pertanyaan')
            ->select(
                'gs_inspeksi_tmk_pertanyaan.ID',
                'gs_inspeksi_tmk_pertanyaan.category',
                'gs_inspeksi_tmk_pertanyaan.pertanyaan',
                'gs_inspeksi_tmk_jawaban_detail.jawaban',
                'gs_inspeksi_tmk_jawaban_detail.resiko',
                'gs_inspeksi_tmk_jawaban_detail.keterangan'
            )
            ->get()
            ->groupBy('category');

        $dropdowns = [
            'Diinspeksi' => 'Diinspeksi Oleh',
            'DiinspeksiUlang' => 'Diinspeksi Ulang Oleh',
            'Mengetahui' => 'Mengetahui'
        ];

        return view('SmartForm::GS/inspeksi-toilet-mess-kantor/show-wc', [
            'data' => $data,
            'questions' => $pertanyaan,
            'dropdowns' => $dropdowns,
            'approvalList' => HrdHelper::getApprovalList()
        ]);
    }

    public function Update($id, Request $request) {
        DB::beginTransaction();
        try {
            $inspeksi = DB::table('gs_inspeksi_tmk_jawaban')->where('id', $id)->first();
            if (!$inspeksi) {
                return response()->json(['error' => 'Data inspeksi tidak ditemukan'], 404);
            }

            DB::table('gs_inspeksi_tmk_jawaban')
                ->where('id', $id)
                ->update([
                    'tgl_doc' => $request->tgl_doc,
                    'nama_site' => $request->nama_site,
                    'dept' => $request->dept,
                    'shift' => $request->shift,
                    'loker' => $request->loker,
                    'jml_ins' => $request->jml_ins,
                    'checked_by' => $request->checked_by,
                    'validated_by' => $request->validated_by,
                    'mengetahui' => $request->mengetahui,
                    'updated_at' => DB::raw('GETDATE()')
                ]);

            DB::table('gs_inspeksi_tmk_jawaban_detail')->where('inspeksi_id', $id)->delete();

            $detailData = [];


            $pertanyaan_id = $request->pertanyaan_id;
            if (!empty($pertanyaan_id) && is_array($pertanyaan_id)) {

                foreach ($pertanyaan_id as $index => $pertanyaan_id_value) {
                    $detailData[] = [
                        'inspeksi_id' => $id,
                        'pertanyaan_id' => $pertanyaan_id_value,
                        'jawaban' => $request->jawaban[$index] ?? null,
                        'resiko' => $request->resiko[$index] ?? null,
                        'keterangan' => $request->keterangan[$index] ?? null,
                        'category' => $request->category[$index] ?? null,
                        'updated_at' => DB::raw('GETDATE()')
                    ];
                }
            } else {
                dd('masuk kondisi gagal submit');
            }


            $inserted = DB::table('gs_inspeksi_tmk_jawaban_detail')->insert($detailData);

            DB::commit();

            return response()->json([
                'message' => 'Data inspeksi berhasil diupdate!'

            ]);
        } catch (\Exception $e) {
            // dd($e);
            DB::rollBack();
            return response()->json(['error' => 'Gagal memperbarui data: ' . $e->getMessage()], 500);
        }
    }

    public function show($id, Request $request){
        $nik_session = $request->session()->get( 'user_id', '' );

        $data = DB::table('gs_inspeksi_tmk_jawaban')
            ->where('id', $id)
            ->first();

        if (!$data) {
            return abort(404, "Data inspeksi tidak ditemukan");
        }

        $pertanyaan = DB::table('gs_inspeksi_tmk_pertanyaan')
            ->leftJoin('gs_inspeksi_tmk_jawaban_detail', function ($join) use ($id) {
                $join->on('gs_inspeksi_tmk_pertanyaan.ID', '=', 'gs_inspeksi_tmk_jawaban_detail.pertanyaan_id')
                    ->where('gs_inspeksi_tmk_jawaban_detail.inspeksi_id', '=', $id);
            })
            ->orderByRaw("CASE
                WHEN gs_inspeksi_tmk_pertanyaan.category = 'TOILET' THEN 1
                WHEN gs_inspeksi_tmk_pertanyaan.category = 'MESS' THEN 2
                WHEN gs_inspeksi_tmk_pertanyaan.category = 'KANTOR' THEN 3
                ELSE 4 END")
            ->orderBy('gs_inspeksi_tmk_pertanyaan.urutan_pertanyaan')
            ->select(
                'gs_inspeksi_tmk_pertanyaan.ID',
                'gs_inspeksi_tmk_pertanyaan.category',
                'gs_inspeksi_tmk_pertanyaan.pertanyaan',
                'gs_inspeksi_tmk_jawaban_detail.jawaban',
                'gs_inspeksi_tmk_jawaban_detail.resiko',
                'gs_inspeksi_tmk_jawaban_detail.keterangan'
            )
            ->get()
            ->groupBy('category');

        $dropdowns = [
            'Diinspeksi' => 'Diinspeksi Oleh',
            'DiinspeksiUlang' => 'Diinspeksi Ulang Oleh',
            'Mengetahui' => 'Mengetahui'
        ];

        return view('SmartForm::GS/inspeksi-toilet-mess-kantor/show-wc', [
            'data' => $data,
            'nik' =>$nik_session,
            'questions' => $pertanyaan,
            'dropdowns' => $dropdowns,
            'approvalList' => HrdHelper::getApprovalList()
        ]);
    }

}
