<?php

namespace Modules\SmartForm\App\Http\Controllers\FAT\PPH;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use DB;
use PhpOffice\PhpSpreadsheet\Calculation\Logical\Boolean;

class HelperPPHController extends Controller
{
    public function GetQueryListHasilUploadDocument(string $query, Request $req, bool $status)
    {

        if (isset($req->search['FILTERNPWPVENDOR']) && $req->search['FILTERNPWPVENDOR'] != null) {
            $query = $query . " AND npwp like '%" . $req->search['FILTERNPWPVENDOR'] . "%' ";
        }
        if ($status) {
            if (isset($req["sort"]) && $req["sort"] != null) {
                $query = $query . ' ORDER BY ' . $req["sort"] . ' ' . $req["order"];
            } else {
                $query = $query . ' ORDER BY created_at DESC ';
            }



            if ($req["offset"] != null) {
                $query = $query . ' OFFSET ' . $req["offset"] . ' ROWS ';
            }
            if ($req["limit"] != null) {
                $query = $query . "FETCH NEXT " . $req["limit"] . " ROWS ONLY";
            }
        }
        return $query;
    }
    function helperDataListHasilUploadDocument(Request $table)
    {

        $query = "SELECT * FROM FM_FAT_PPH_DETAIL_DOCUMENT ms where ms.nodocpph = '" . $table->search['FILTERNODOC'] . "'  and ms.status = 1  ";
        $queryCountDataUser = "select count(*) jumlah FROM FM_FAT_PPH_DETAIL_DOCUMENT ms where ms.nodocpph = '" . $table->search['FILTERNODOC'] . "' and ms.status = 1 ";
        $newQuery = $this->GetQueryListHasilUploadDocument($query, $table, true);
        $newQueryCount = $this->GetQueryListHasilUploadDocument($queryCountDataUser, $table, false);

        $dataUser = DB::select($newQuery);
        $dataCount = DB::select($newQueryCount);

        return response()->json([
            'total' => $dataCount[0]->jumlah,
            'totalNotFiltered' => $dataCount[0]->jumlah,
            "rows" => $dataUser,
        ]);
    }

    public function GetQueryListMasterUploadDocumentPPH(string $query, Request $req)
    {

        if (isset($req->search['FILTERNIK']) && $req->search['FILTERNIK'] != null) {
            $query = $query . " AND code in (select code from FM_IC_005_BSS_LST_KRYWN k where k.nik like '%" . $req->search['FILTERNIK'] . "%' ) ";
        }

        if (isset($req["sort"]) && $req["sort"] != null) {
            $query = $query . ' ORDER BY ' . $req["sort"] . ' ' . $req["order"];
        } else {
            $query = $query . ' ORDER BY created_at DESC ';
        }

        if ($req["offset"] != null) {
            $query = $query . ' OFFSET ' . $req["offset"] . ' ROWS ';
        }
        if ($req["limit"] != null) {
            $query = $query . "FETCH NEXT " . $req["limit"] . " ROWS ONLY";
        }
        return $query;
    }

    function helperDataListMasterUploadDocumentPPH(Request $table)
    {
        $query = "SELECT 
        nodocpph,
        tsite,
        tahun,
        bulan,
        created_at,
        status,
        (select count(1) from FM_FAT_PPH_DETAIL_DOCUMENT d where d.nodocpph = ms.nodocpph) jumlah,
        FORMAT(DATEFROMPARTS(tahun, bulan, 1), 'MMMM yyyy') as concat_bulan FROM FM_FAT_PPH_MASTER ms where 1 = 1  ";

        $countDataUser = DB::select("select count(*) jumlah FROM FM_FAT_PPH_MASTER ms where 1 = 1 ");
        $newQuery = $this->GetQueryListMasterUploadDocumentPPH($query, $table);

        $dataUser = DB::select($newQuery);

        return response()->json([
            'total' => $countDataUser[0]->jumlah,
            'totalNotFiltered' => $countDataUser[0]->jumlah,
            "rows" => $dataUser,
        ]);
    }

    function HapusDocumentPotonganPPH(Request $r)
    {
        DB::beginTransaction();
        try {
            //code...
            DB::table("FM_FAT_PPH_DETAIL_DOCUMENT")
                ->where("id", "=", $r->iden)
                ->where("nodocpph", "=", $r->code)
                ->update([
                    "status" => 0
                ]);
            DB::commit();

            return response()->json([
                'message' => 'Done Data Terhapus',
                'code' => 200
            ]);

        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return response()->json([
                'message' => 'Failed to Deleted records: ',
                'code' => 500
            ]);
        }
    }

    function UpdateDocumentPotonganPPH(Request $r)
    {
        $r->validate([
            'pdf' => 'required|file|mimes:pdf', // max 10MB
            'code' => 'required',
            'iden' => 'required'
        ], [
            'pdf.required' => 'Silakan pilih file untuk diunggah!',
            'pdf.mimes' => 'File harus berformat .pdf!',
            'code.required' => 'Code diperlukan!',
            'iden.required' => 'Iden diperlukan!'
        ]);

        $file = $r->file('pdf');
        $fileName = $file->getClientOriginalName();

        DB::beginTransaction();
        try {
            //code...
            DB::table("FM_FAT_PPH_DETAIL_DOCUMENT")
                ->where("id", "=", $r->iden)
                ->where("nodocpph", "=", $r->code)
                ->update([
                    "nama_file" => $fileName,
                    "updated_at" => now(),
                    "updated_by" => session("user_id")
                ]);
            DB::commit();

            return response()->json([
                'message' => 'Done Data Terhapus',
                'code' => 200
            ]);

        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return response()->json([
                'message' => 'Failed to Deleted records: ',
                'code' => 500
            ]);
        }
    }
}

