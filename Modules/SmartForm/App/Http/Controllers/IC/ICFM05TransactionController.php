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

            // $dataMaster = DB::table('FM_IC_005_BSS_MASTER')
            //     ->where("NIK", $d->master['nik'])
            //     ->where("created_at", $d->master['date'])
            //     ->get()
            //     ->first();
            DB::table('FM_IC_005_BSS_DETAIL_INDUKSI')
                ->where('group_code', $d->code)
                // ->where('Created', $d->master['date'])
                ->delete();
            DB::table('FM_IC_005_BSS_DETAIL_PERTANYAAN_EXT')
                ->where('group_code', $d->code)
                ->delete();

            $dataTypes = ['dataICGS', 'dataOD', 'dataSHE', 'dataDEPT'];
            foreach ($dataTypes as $dataType) {
                if (!empty($d->$dataType)) {
                    foreach ($d->$dataType as $value) {
                        $induksiAtDate = Carbon::createFromFormat('d - M - Y', $value['tanggal'])->format('Y-m-d');
                        DB::table('FM_IC_005_BSS_DETAIL_INDUKSI')->insert([
                            'group_code' => $d->code,
                            'index_pertanyaan' => $value['id'],
                            'mentor' => session("user_id"),
                            'created_at' => $induksiAtDate,
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


            // foreach ($d->data as $key => $value) {
            //     $induksiAtDate = Carbon::createFromFormat('d - M - Y', $value['tanggal'])->format('Y-m-d');
            //     DB::table('FM_IC_005_BSS_DETAIL')->insert([
            //         'NIK' => $dataMaster->NIK,
            //         'Created' => $dataMaster->created_at,
            //         'Group' => $dataMaster->Group,
            //         'IndexPertanyaan' => $value['id'],
            //         'Mentor' => $value['mentor'],
            //         'Induksi_at' => $induksiAtDate,
            //         'created_at' => now(),
            //         'created_by' => session("user_id"),
            //         'updated_by' => session("user_id"), // Nilai ini mungkin bisa dikosongkan jika belum diperbarui
            //         'updated_at' => now()// Nilai ini mungkin bisa dikosongkan jika belum diperbarui
            //     ]);
            // }

            // foreach ($d->pertanyaanTambahan as $key => $value) {
            //     DB::table('FM_IC_005_BSS_DETAIL_TAMBAHAN_PERTANYAAN')->insert([
            //         'NIK' => $dataMaster->NIK,
            //         'Created' => $dataMaster->created_at,
            //         'Group' => $dataMaster->Group,
            //         'pertanyaan' => $value['description'],
            //         'Mentor' => $value['nikMateriTambahan'],
            //         'created_at' => now(),
            //         'created_by' => session("user_id"),
            //         'updated_by' => session("user_id"), // Nilai ini mungkin bisa dikosongkan jika belum diperbarui
            //         'updated_at' => now()// Nilai ini mungkin bisa dikosongkan jika belum diperbarui
            //     ]);
            // }


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

    public function GetQueryListHasilInduksi(string $query, Request $req)
    {

        if (isset($req->search['FILTERNIK']) && $req->search['FILTERNIK'] != null) {
            $query = $query . " AND grp.code = (select code from FM_IC_005_BSS_LST_KRYWN k where k.nik like '%" . $req->search['FILTERNIK'] . "%' ) ";
        }
        if (isset($req->search['FILTERNAMA']) && $req->search['FILTERNAMA'] != null) {
            $query = $query . " AND grp.code = (select code from FM_IC_005_BSS_LST_KRYWN k where UPPER(k.Nama) LIKE UPPER('%" . $req->search['FILTERNAMA'] . "%') ) ";
        }
        // if (isset($req->search['FILTERTANGGAL']) && $req->search['FILTERTANGGAL'] != null) {
        //     $query = $query . " AND ms.created_at = '" . $req->search['FILTERTANGGAL'] . "' ";
        // }

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

    function helperDataListInduksiKaryawan(Request $table)
    {
        $query = "SELECT * , (Select count (*) from FM_IC_005_BSS_LST_KRYWN k where k.code = grp.code) jml_karyawan,
                    (SELECT STUFF((
                        SELECT DISTINCT ',' + LEFT(index_pertanyaan, CHARINDEX('_', index_pertanyaan) - 1)
                        FROM FM_IC_005_BSS_DETAIL_INDUKSI d where d.group_code = grp.code
                        FOR XML PATH('')
                    ), 1, 1, '') AS group_names) pertanyaan  FROM FM_IC_005_BSS_LST_GRP grp 
                    where 1 = 1 ";
        $countDataUser = DB::select('select count(*) jumlah FROM FM_IC_005_BSS_LST_GRP');
        $newQuery = $this->GetQueryListHasilInduksi($query, $table);

        $dataUser = DB::select($newQuery);

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
}
