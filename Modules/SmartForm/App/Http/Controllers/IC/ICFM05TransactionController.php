<?php

namespace Modules\SmartForm\App\Http\Controllers\IC;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;

class ICFM05TransactionController extends Controller
{
    //
    function SubmitALLData(Request $d)
    {
        // 
        DB::beginTransaction();
        $dataNOW = now();
        try {
            $dataTypes = ['dataICGS', 'dataOD', 'dataSHE', 'dataDEPT'];
            foreach ($dataTypes as $dataType) {
                if (!empty($d->$dataType)) {
                    foreach ($d->$dataType as $value) {
                        DB::table('FM_IC_005_BSS_DETAIL_INDUKSI')->insert([
                            'group_code' => $d->code,
                            'index_pertanyaan' => $value['id'],
                            'mentor' => session("user_id"),
                            'created_at' => $dataNOW,
                            'created_by' => session("user_id"),
                        ]);
                    }
                }
            }
            if (!empty($d->pertanyaanTambahan)) {
                foreach ($d->pertanyaanTambahan as $key => $value) {
                    DB::table('FM_IC_005_BSS_DETAIL_PERTANYAAN_EXT')->insert([
                        'group_code' => $d->code,
                        'pertanyaan' => $value['description'],
                        'mentor' => $value['nikMateriTambahan'],
                        'created_at' => $dataNOW,
                        'created_by' => session("user_id"),
                    ]);
                }
            }

            DB::commit();

            return response()->json([
                'message' => 'Done Induksi Tersimpan',
                'code' => 200
            ]);

        } catch (QueryException $e) {
            // Rollback transaksi jika terjadi error
            DB::rollBack();
            return response()->json([
                'message' => 'Failed to insert records: ' . $e->getMessage(),
                'code' => 500
            ]);
        }
    }

    function SubmitALLDataEdit(Request $d)
    {


        // dd($d);
        DB::beginTransaction();
        $dataNOW = now();
        try {

            $listDataNotExist = DB::select("
                                    WITH CategoryCheck AS (
                                        SELECT 
                                            group_code,
                                            MAX(CASE WHEN index_pertanyaan LIKE 'ICGS%' THEN 1 ELSE 0 END) AS has_icgs,
                                            MAX(CASE WHEN index_pertanyaan LIKE 'OD%' THEN 1 ELSE 0 END) AS has_od,
                                            MAX(CASE WHEN index_pertanyaan LIKE 'DEPT%' THEN 1 ELSE 0 END) AS has_dept,
                                            MAX(CASE WHEN index_pertanyaan LIKE 'SHE%' THEN 1 ELSE 0 END) AS has_she
                                        FROM FM_IC_005_BSS_DETAIL_INDUKSI
                                        WHERE group_code = ?
                                        GROUP BY group_code
                                    )
                                    SELECT 
                                        group_code,
                                        STUFF(
                                            CONCAT(
                                                CASE WHEN has_icgs = 0 THEN ', ICGS' ELSE '' END,
                                                CASE WHEN has_od = 0 THEN ', OD' ELSE '' END,
                                                CASE WHEN has_dept = 0 THEN ', DEPT' ELSE '' END,
                                                CASE WHEN has_she = 0 THEN ', SHE' ELSE '' END
                                            ), 1, 2, ''
                                        ) AS missing_categories
                                    FROM CategoryCheck
                                    UNION ALL
                                    -- Handle case where no data exists at all
                                    SELECT 
                                        ? AS group_code,
                                        'ICGS, OD, DEPT, SHE' AS missing_categories
                                    WHERE NOT EXISTS (
                                        SELECT 1 
                                        FROM FM_IC_005_BSS_DETAIL_INDUKSI 
                                        WHERE group_code = ?
                                    );
                                ", [$d->code, $d->code, $d->code]);



            $dataNotExist = !empty($listDataNotExist) && collect($listDataNotExist)->first()->missing_categories
                ? explode(", ", collect($listDataNotExist)->first()->missing_categories)
                : [];


            DB::table('FM_IC_005_BSS_DETAIL_PERTANYAAN_EXT')
                ->where('group_code', $d->code)
                ->delete();

            // Iterasi melalui $dataNotExist, hanya lakukan jika array tidak kosong
            foreach ($dataNotExist as $z) {
                if (!empty($d->$z)) {
                    foreach ($d->$z as $value) {
                        DB::table('FM_IC_005_BSS_DETAIL_INDUKSI')->insert([
                            'group_code' => $d->code,
                            'index_pertanyaan' => $value['id'],
                            'mentor' => session("user_id"),
                            'created_at' => $dataNOW,
                            'created_by' => session("user_id"),
                            'updated_by' => session("user_id"),
                            'updated_at' => $dataNOW,
                        ]);
                    }
                }
            }

            if (!empty($d->pertanyaanTambahan)) {
                foreach ($d->pertanyaanTambahan as $key => $value) {
                    // dd($value);
                    DB::table('FM_IC_005_BSS_DETAIL_PERTANYAAN_EXT')->insert([
                        'group_code' => $d->code,
                        'pertanyaan' => $value['description'],
                        'mentor' => $value['nikMateriTambahan'],
                        'created_at' => $dataNOW,
                        'created_by' => session("user_id"),
                    ]);
                }
            }

            // Commit transaksi jika tidak ada error
            DB::commit();

            return response()->json([
                'message' => 'Done Induksi Tersimpan',
                'code' => 200
            ]);

        } catch (QueryException $e) {
            // Rollback transaksi jika terjadi error
            DB::rollBack();
            return response()->json([
                'message' => 'Failed to insert records: ' . $e->getMessage(),
                'code' => 500
            ]);
        }
    }

    public function GetQueryListHasilInduksi(string $query, Request $req, bool $r)
    {

        if (isset($req->search['FILTERNIK']) && $req->search['FILTERNIK'] != null) {
            $query = $query . " AND code in (select code from FM_IC_005_BSS_LST_KRYWN k where k.nik like '%" . $req->search['FILTERNIK'] . "%' ) ";
        }
        if (isset($req->search['FILTERNAMA']) && $req->search['FILTERNAMA'] != null) {
            $query = $query . " AND code in (select code from FM_IC_005_BSS_LST_KRYWN k where UPPER(k.Nama) LIKE UPPER('%" . $req->search['FILTERNAMA'] . "%') ) ";
        }
        if (isset($req->search['FILTERNIKMENTOR']) && $req->search['FILTERNIKMENTOR'] != null) {
            $query = $query . " AND mentor_names like  '%" . $req->search['FILTERNIKMENTOR'] . "%'";
        }
        if (isset($req->search['FILTERSITE']) && $req->search['FILTERSITE'] != null) {
            $query = $query . " AND site like  '%" . $req->search['FILTERSITE'] . "%'";
        }
        // if (isset($req->search['FILTERTANGGAL']) && $req->search['FILTERTANGGAL'] != null) {
        //     $query = $query . " AND ms.created_at = '" . $req->search['FILTERTANGGAL'] . "' ";
        // }
        if ($r) {
            if ($req->has('sort') && $req->sort != null) {
                $query .= ' ORDER BY ' . $req->sort . ' ' . ($req->order ?? 'ASC');
            } else {
                $query .= ' ORDER BY created_at DESC ';
            }

            if ($req->has('offset')) {
                $query .= ' OFFSET ' . intval($req->offset) . ' ROWS ';
            }
            if ($req->has('limit')) {
                $query .= ' FETCH NEXT ' . intval($req->limit) . ' ROWS ONLY';
            }
        }


        // dd($query);
        return $query;
    }

    function helperDataListInduksiKaryawan(Request $table)
    {
        $query = "WITH MentorData AS (
                    SELECT *, 
                        (SELECT COUNT(*) 
                        FROM FM_IC_005_BSS_LST_KRYWN k 
                        WHERE k.code = grp.code) AS jml_karyawan,

                        (SELECT STUFF((
                            SELECT DISTINCT ',' + LEFT(index_pertanyaan, CHARINDEX('_', index_pertanyaan) - 1)
                            FROM FM_IC_005_BSS_DETAIL_INDUKSI d 
                            WHERE d.group_code = grp.code
                            FOR XML PATH('')
                        ), 1, 1, '') AS group_names) AS pertanyaan,

                        (SELECT STUFF((
                            SELECT DISTINCT ',' + mentor 
                            FROM FM_IC_005_BSS_DETAIL_INDUKSI d 
                            WHERE d.group_code = grp.code
                            FOR XML PATH('')
                        ), 1, 1, '') AS mentors) AS mentor_names
                    FROM FM_IC_005_BSS_LST_GRP grp
                )
                SELECT *
                FROM MentorData
                WHERE 1 = 1 ";

        $queryCount = "WITH MentorData AS (
                    SELECT *, 
                        (SELECT COUNT(*) 
                        FROM FM_IC_005_BSS_LST_KRYWN k 
                        WHERE k.code = grp.code) AS jml_karyawan,

                        (SELECT STUFF((
                            SELECT DISTINCT ',' + LEFT(index_pertanyaan, CHARINDEX('_', index_pertanyaan) - 1)
                            FROM FM_IC_005_BSS_DETAIL_INDUKSI d 
                            WHERE d.group_code = grp.code
                            FOR XML PATH('')
                        ), 1, 1, '') AS group_names) AS pertanyaan,

                        (SELECT STUFF((
                            SELECT DISTINCT ',' + mentor 
                            FROM FM_IC_005_BSS_DETAIL_INDUKSI d 
                            WHERE d.group_code = grp.code
                            FOR XML PATH('')
                        ), 1, 1, '') AS mentors) AS mentor_names
                    FROM FM_IC_005_BSS_LST_GRP grp
                )
                SELECT count(*) as jumlah
                FROM MentorData
                WHERE 1 = 1 ";


        $newQuery = $this->GetQueryListHasilInduksi($query, $table, true);
        $newQueryCount = $this->GetQueryListHasilInduksi($queryCount, $table, false);
        // dd($newQueryCount);
        $countDataUser = DB::select($newQueryCount);
        $dataUser = DB::select($newQuery);
        // dd($dataUser);
        return response()->json([
            'total' => $countDataUser[0]->jumlah,
            'totalNotFiltered' => $countDataUser[0]->jumlah,
            "rows" => $dataUser,
        ]);
    }

    public function GetQueryListKaryawanInduksi(string $query, Request $req)
    {
        return $query;
    }

    function helperDataListKaryawanInduksi(Request $table)
    {
        $query = "SELECT * FROM [FM_IC_005_BSS_LST_KRYWN] ms where code = '" . $table->search['FILTERCODE'] . "' ";
        $countDataUser = DB::select("select count(*) jumlah FROM [FM_IC_005_BSS_LST_KRYWN]  where code = '" . $table->search['FILTERCODE'] . "' ");
        $newQuery = $this->GetQueryListKaryawanInduksi($query, $table);

        $dataUser = DB::select($newQuery);

        return response()->json([
            'total' => $countDataUser[0]->jumlah,
            'totalNotFiltered' => $countDataUser[0]->jumlah,
            "rows" => $dataUser,
        ]);
    }

    function HelperSelect2InduksiKaryawanByDept(Request $d)
    {
        $data = $d->request->get("query");
        $dataDepartment = DB::connection('sqlsrv2')->select("SELECT TOP 5 NIK nomorPunggung, tk.Nama nama, td.Nama dept FROM TKaryawan tk join tdepartement td on tk.KodeDP = td.KodeDP where Nik like  ?  ", ['%' . $data . '%']);
        // dd($dataDepartment);

        $dataJs = [];
        foreach ($dataDepartment as $a) {
            $dataBaru = [
                'name' => $a->nama,
                'dept' => $a->dept,
                'text' => $a->nomorPunggung,
                'id' => $a->nomorPunggung
            ];
            $dataJs[] = $dataBaru;
        }
        $final = [
            'data' => $dataJs,
        ];
        return json_encode($final);
    }

    function validateAndSanitizeInput($input)
    {
        // Sanitasi input
        $sanitizedInput = filter_var($input, FILTER_SANITIZE_STRING);

        // Validasi input: Misalnya, hanya menerima huruf, angka, dan spasi
        if (preg_match('/^[a-zA-Z0-9 ]*$/', $sanitizedInput)) {
            return $sanitizedInput;
        } else {
            // Jika input tidak valid, Anda bisa mengembalikan false atau memicu error
            throw new Exception('Input tidak valid');
        }
    }


    function DeletedInduksiKaryawan(Request $d)
    {
        DB::beginTransaction();
        try {

            DB::table("FM_IC_005_BSS_LST_KRYWN")->where("code", $d->code)->delete();
            DB::table("FM_IC_005_BSS_DETAIL_PERTANYAAN_EXT")->where("group_code", $d->code)->delete();
            DB::table("FM_IC_005_BSS_DETAIL_INDUKSI")->where("group_code", $d->code)->delete();
            DB::table("FM_IC_005_BSS_LST_GRP")->where("code", $d->code)->delete();

            DB::commit();

            return response()->json([
                'message' => 'Done Data Terhapus',
                'code' => 200
            ]);

        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'message' => 'Failed to Deleted records: ',
                'code' => 500
            ]);
        }
    }
}
