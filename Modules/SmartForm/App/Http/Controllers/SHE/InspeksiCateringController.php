<?php

namespace Modules\SmartForm\App\Http\Controllers\SHE;

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

class InspeksiCateringController extends Controller {

    public function download() {
        $pdf = Pdf::loadView('pdf');
 
        return $pdf->download();
    }

    public function InspeksiCateringDashboard()
    {
        return view('SmartForm::she/inspeksi-catering/inspeksi-catering');
    }

    function GetListInspeksiCatering(Request $request) {
        $TABLE_MASTER = "FM_SHE_048_INSPEKSI_CATERING";
        $response = array(
            'message' => '',
            'isSuccess' => false
        );
        $filterTanggal = $request->query('tanggal', null);
        $filterSite = $request->query('site', null);
        $filterNik = $request->query('nama', null);
        $filterStatus = $request->query('status', null);
        $search = $request->query('search', '');
        $sort = $request->query('sort', 'id'); // Default sort by id
        $order = $request->query('order', 'desc');
        $offset = $request->query('offset', 0); // Default offset
        $limit = $request->query('limit', null); // Default limit
        $filter = $request->query('filter', null); // Default limit
        try {
            $master = DB::table($TABLE_MASTER)
                ->select('id', 'lokasi_kerja as loker');
            
            if($filterTanggal == null || $filterTanggal == 'null') {
            } else {
                $tgl = Carbon::createFromFormat('Y-m-d', $filterTanggal);
                $master->whereDate('tanggal', $tgl);
            }
            if($filterSite == null || $filterSite == 'null') {
            } else {
                $master->where('site', $filterSite);
            }
            if($filterNik == null || $filterNik == 'null') {
            } else {
                $master->where('nik', $filterNik);
            }
            if($filterStatus == null || $filterStatus == 'null') {
            } else {
                $master->where('status', $filterStatus);
            }
            $master->orderBy($sort, $order);
            // Log::debug("SQL : ".$master->toRawSql());
            $jml = $master->count();
            if($limit == null || $limit == 'null' || $limit == '') {
                $master->skip($offset);
            } else {
                $master->skip($offset)->limit($limit);
            }
            $document = $master->get();

            $response['message'] = "Ok";
            $response['isSuccess'] = true;
            $response['data'] = [
                'total' => $jml,
                'totalNotFiltered' => $jml,
                'rows' => $document
            ];

        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            
            $response['message'] = $ex->getMessage();
            $response['isSuccess'] = false;
        }

        return response()->json($response);
    }

    function FormInspeksiCatering() {
        return view('SmartForm::she/inspeksi-catering/form-inspeksi-catering', [
                    'isShowDetail' => true,
                    'approvalList' => HrdHelper::getApprovalList()
                ]);
    }
    
    public function CreateInspeksiCatering(Request $request)
    {
        DB::beginTransaction();
        $requestData = $request->all();

        try {
            DB::table('FM_SHE_048_INSPEKSI_CATERING')->insert([
                // 'no' => $number,
                // 'nama' => session("username"),
                'no_dok_form' => "BSS-FRM-SHE-048",
                'revisi_form' => "00",
                'tanggal_form' => "23 November 2021",
                'halaman_form' => "1 dari 3",
                // 'nik' => session("user_id"),
                'nama_site' =>  $requestData['tNamaSite'],
                'department' =>  $requestData['dDept'],
                'shift' =>  $requestData['dShift'],
                'lokasi_kerja' =>  $requestData['tLoker'],
                'jumlah_inspektor' =>  $requestData['tJmlIns'],
                'mengetahui' =>  $requestData['dMengetahui'],

                'q_penerimaan_1' =>  $requestData['tA1'],
                'q_penerimaan_2' =>  $requestData['tA2'],
                'q_penerimaan_3' =>  $requestData['tA3'],
                'q_penerimaan_4' =>  $requestData['tA4'],
                'q_penerimaan_5' =>  $requestData['tA5'],
                'q_penerimaan_6' =>  $requestData['tA6'],
                'q_penerimaan_7' =>  $requestData['tA7'],
                'q_penerimaan_8' =>  $requestData['tA8'],
                'q_penerimaan_9' =>  $requestData['tA9'],
                'q_penerimaan_10' =>  $requestData['tA10'],

                'q_keterangan_penerimaan_1' =>  $requestData['tA1a'],
                'q_keterangan_penerimaan_2' =>  $requestData['tA2b'],
                'q_keterangan_penerimaan_3' =>  $requestData['tA3c'],
                'q_keterangan_penerimaan_4' =>  $requestData['tA4d'],
                'q_keterangan_penerimaan_5' =>  $requestData['tA5e'],
                'q_keterangan_penerimaan_6' =>  $requestData['tA6f'],
                'q_keterangan_penerimaan_7' =>  $requestData['tA7g'],
                'q_keterangan_penerimaan_8' =>  $requestData['tA8h'],
                'q_keterangan_penerimaan_9' =>  $requestData['tA9i'],
                'q_keterangan_penerimaan_10' =>  $requestData['tA10j'],

                'q_penyimpanan_1' =>  $requestData['tB1'],
                'q_penyimpanan_2' =>  $requestData['tB2'],
                'q_penyimpanan_3' =>  $requestData['tB3'],
                'q_penyimpanan_4' =>  $requestData['tB4'],
                'q_penyimpanan_5' =>  $requestData['tB5'],
                'q_penyimpanan_6' =>  $requestData['tB6'],
                'q_penyimpanan_7' =>  $requestData['tB7'],
                'q_penyimpanan_8' =>  $requestData['tB8'],
                'q_penyimpanan_9' =>  $requestData['tB9'],

                'q_keterangan_penyimpanan_1' =>  $requestData['tB1a'],
                'q_keterangan_penyimpanan_2' =>  $requestData['tB2b'],
                'q_keterangan_penyimpanan_3' =>  $requestData['tB3c'],
                'q_keterangan_penyimpanan_4' =>  $requestData['tB4d'],
                'q_keterangan_penyimpanan_5' =>  $requestData['tB5e'],
                'q_keterangan_penyimpanan_6' =>  $requestData['tB6f'],
                'q_keterangan_penyimpanan_7' =>  $requestData['tB7g'],
                'q_keterangan_penyimpanan_8' =>  $requestData['tB8h'],
                'q_keterangan_penyimpanan_9' =>  $requestData['tB9i'],

                'q_persiapan_1' =>  $requestData['tC1'],
                'q_persiapan_2' =>  $requestData['tC2'],
                'q_persiapan_3' =>  $requestData['tC3'],
                'q_persiapan_4' =>  $requestData['tC4'],
                'q_persiapan_5' =>  $requestData['tC5'],
                'q_persiapan_6' =>  $requestData['tC6'],
                'q_persiapan_7' =>  $requestData['tC7'],
                'q_persiapan_8' =>  $requestData['tC8'],
                'q_persiapan_9' =>  $requestData['tC9'],
                'q_persiapan_10' =>  $requestData['tC10'],

                'q_keterangan_persiapan_1' =>  $requestData['tC1a'],
                'q_keterangan_persiapan_2' =>  $requestData['tC2b'],
                'q_keterangan_persiapan_3' =>  $requestData['tC3c'],
                'q_keterangan_persiapan_4' =>  $requestData['tC4d'],
                'q_keterangan_persiapan_5' =>  $requestData['tC5e'],
                'q_keterangan_persiapan_6' =>  $requestData['tC6f'],
                'q_keterangan_persiapan_7' =>  $requestData['tC7g'],
                'q_keterangan_persiapan_8' =>  $requestData['tC8h'],
                'q_keterangan_persiapan_9' =>  $requestData['tC9i'],
                'q_keterangan_persiapan_10' =>  $requestData['tC10j'],

                'q_pengolahan_1' =>  $requestData['tD1'],
                'q_pengolahan_2' =>  $requestData['tD2'],
                'q_pengolahan_3' =>  $requestData['tD3'],
                'q_pengolahan_4' =>  $requestData['tD4'],
                'q_pengolahan_5' =>  $requestData['tD5'],
                'q_pengolahan_6' =>  $requestData['tD6'],
                'q_pengolahan_7' =>  $requestData['tD7'],
                'q_pengolahan_8' =>  $requestData['tD8'],
                'q_pengolahan_9' =>  $requestData['tD9'],
                'q_pengolahan_10' =>  $requestData['tD10'],

                'q_keterangan_pengolahan_1' =>  $requestData['tD1a'],
                'q_keterangan_pengolahan_2' =>  $requestData['tD2b'],
                'q_keterangan_pengolahan_3' =>  $requestData['tD3c'],
                'q_keterangan_pengolahan_4' =>  $requestData['tD4d'],
                'q_keterangan_pengolahan_5' =>  $requestData['tD5e'],
                'q_keterangan_pengolahan_6' =>  $requestData['tD6f'],
                'q_keterangan_pengolahan_7' =>  $requestData['tD7g'],
                'q_keterangan_pengolahan_8' =>  $requestData['tD8h'],
                'q_keterangan_pengolahan_9' =>  $requestData['tD9i'],
                'q_keterangan_pengolahan_10' =>  $requestData['tD10j'],

                'q_penggolongan_sampah_1' =>  $requestData['tE1'],
                'q_penggolongan_sampah_2' =>  $requestData['tE2'],
                'q_penggolongan_sampah_3' =>  $requestData['tE3'],
                'q_penggolongan_sampah_4' =>  $requestData['tE4'],
                'q_penggolongan_sampah_5' =>  $requestData['tE5'],
                'q_penggolongan_sampah_6' =>  $requestData['tE6'],
                'q_penggolongan_sampah_7' =>  $requestData['tE7'],
                'q_penggolongan_sampah_8' =>  $requestData['tE8'],
                'q_penggolongan_sampah_9' =>  $requestData['tE9'],

                'q_keterangan_penggolongan_sampah_1' =>  $requestData['tE1a'],
                'q_keterangan_penggolongan_sampah_2' =>  $requestData['tE2b'],
                'q_keterangan_penggolongan_sampah_3' =>  $requestData['tE3c'],
                'q_keterangan_penggolongan_sampah_4' =>  $requestData['tE4d'],
                'q_keterangan_penggolongan_sampah_5' =>  $requestData['tE5e'],
                'q_keterangan_penggolongan_sampah_6' =>  $requestData['tE6f'],
                'q_keterangan_penggolongan_sampah_7' =>  $requestData['tE7g'],
                'q_keterangan_penggolongan_sampah_8' =>  $requestData['tE8h'],
                'q_keterangan_penggolongan_sampah_9' =>  $requestData['tE9i']

            ]);

            DB::commit();
            return response()->json([
                'message' => 'Berhasil menyimpan data form Inspeksi Catering!',
                'code' => 200
            ]);

        } catch (QueryException $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Something went wrong: ' . $e->getMessage(),
                'code' => 500
            ], 500);
        }
    }

    public function EditReqFuel($id)
    {
        $editReqFuel = DB::table('FM_LOG_022_PERMINTAAN_PENGISIAN_FUEL')->find($id);
        return view('SmartForm::bss-form/log/form-fuel', [
            'formRequestFuel' => $editReqFuel
        ]);
    }

    public function DeleteInspeksiCatering($id)
    {
        DB::table('FM_SHE_048_INSPEKSI_CATERING')->where('id', $id)->delete();
        return view('SmartForm::she/inspeksi-catering/inspeksi-catering');
    }

    public function PdfInspeksiCatering($id)
    {
        $data = DB::table('FM_SHE_048_INSPEKSI_CATERING')->where('id', $id)->first();
        $pdf = PDF::loadView('SmartForm::she/inspeksi-catering/inspeksi-catering-pdf',  compact('data'));

        return $pdf->download('BSS-FRM-SHE-048.pdf');
    }
}
