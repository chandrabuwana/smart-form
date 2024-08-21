<?php

namespace App\Http\Controllers\IC;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;

class ICFM05TransactionController extends Controller
{
    //
    function SubmitALLData(Request $d)
    {
        $validatedData = $d->validate([
            'master.nama' => 'required|string|max:255',
            'master.nik' => 'required|string|max:255',
            'master.jabatan' => 'required|string|max:255',
            'master.department' => 'required|string|max:255',
            'master.instansi' => 'required|string|max:255',
            'master.jenisInduksi' => 'required|integer',
            'master.group' => 'required|string|max:255'
        ]);

        DB::beginTransaction();

        try {

            DB::table('FM_IC_005_BSS_MASTER')->insert([
                'NIK' => $validatedData['master']['nik'],
                'Nama' => $validatedData['master']['nama'],
                'Jabatan' => $validatedData['master']['jabatan'],
                'Department' => $validatedData['master']['department'],
                'Instansi' => $validatedData['master']['instansi'],
                'Jenis' => $validatedData['master']['jenisInduksi'],
                'Group' => $validatedData['master']['group'],
                'created_at' => now(),
                'created_by' => session("user_id"),
                'updated_by' => null, // Nilai ini mungkin bisa dikosongkan jika belum diperbarui
                'updated_at' => null // Nilai ini mungkin bisa dikosongkan jika belum diperbarui
            ]);

            foreach ($d->data as $key => $value) {
                $induksiAtDate = Carbon::createFromFormat('d - M - Y', $value['tanggal'])->format('Y-m-d');
                DB::table('FM_IC_005_BSS_DETAIL')->insert([
                    'NIK' => $validatedData['master']['nik'],
                    'Created' => now(),
                    'Group' => $validatedData['master']['group'],
                    'IndexPertanyaan' => $value['id'],
                    'Mentor' => $value['mentor'],
                    'Induksi_at' => $induksiAtDate,
                    'created_at' => now(),
                    'created_by' => session("user_id"),
                    'updated_by' => null, // Nilai ini mungkin bisa dikosongkan jika belum diperbarui
                    'updated_at' => null // Nilai ini mungkin bisa dikosongkan jika belum diperbarui
                ]);
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

    function SubmitALLDataEdit(Request $d)
    {


        DB::beginTransaction();

        try {

            $dataMaster = DB::table('FM_IC_005_BSS_MASTER')
                ->where("NIK", $d->master['nik'])
                ->where("created_at", $d->master['date'])
                ->get()
                ->first();
            DB::table('FM_IC_005_BSS_DETAIL')
                ->where('NIK', $d->master['nik'])
                ->where('Created', $d->master['date'])
                ->delete();


            foreach ($d->data as $key => $value) {
                $induksiAtDate = Carbon::createFromFormat('d - M - Y', $value['tanggal'])->format('Y-m-d');
                DB::table('FM_IC_005_BSS_DETAIL')->insert([
                    'NIK' => $dataMaster->NIK,
                    'Created' => $dataMaster->created_at,
                    'Group' => $dataMaster->Group,
                    'IndexPertanyaan' => $value['id'],
                    'Mentor' => $value['mentor'],
                    'Induksi_at' => $induksiAtDate,
                    'created_at' => now(),
                    'created_by' => session("user_id"),
                    'updated_by' => null, // Nilai ini mungkin bisa dikosongkan jika belum diperbarui
                    'updated_at' => null // Nilai ini mungkin bisa dikosongkan jika belum diperbarui
                ]);
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

    public function GetQueryListInduksiKaryawan(string $query, Request $req)
    {

        if (isset($req->search['FILTERNIK']) && $req->search['FILTERNIK'] != null) {
            $query = $query . " AND ms.NIK like '%" . $req->search['FILTERNIK'] . "%' ";
        }
        if (isset($req->search['FILTERNAMA']) && $req->search['FILTERNAMA'] != null) {
            $query = $query . " AND UPPER(ms.Nama) LIKE UPPER('%" . $req->search['FILTERNAMA'] . "%') ";
        }
        if (isset($req->search['FILTERTANGGAL']) && $req->search['FILTERTANGGAL'] != null) {
            $query = $query . " AND ms.created_at = '" . $req->search['FILTERTANGGAL'] . "' ";
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

    function helperDataListInduksiKaryawan(Request $table)
    {
        $query = "SELECT  * FROM [FM_IC_005_BSS_MASTER] ms where 1 = 1 ";
        $countDataUser = DB::select('select count(*) jumlah FROM FM_IC_005_BSS_MASTER');
        $newQuery = $this->GetQueryListInduksiKaryawan($query, $table);

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
