<?php

namespace Modules\SmartForm\App\Http\Controllers\SHE;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class TransactionSHEFRM19BController extends Controller
{
    //

    function addDataPraCheckUp(Request $d)
    {

        $validatedData = $d->validate([
            'no_unit' => 'required|string|max:50',
            'jml_tdr' => 'required|integer',
            'fm_1' => 'required|string|max:50',
            'fm_2' => 'required|string|max:50',
            'fm_3' => 'required|string|max:50',
            'fm_4' => 'required|string|max:50',
            'location' => 'required|string|max:50',
        ], [
            'no_unit.required' => 'Nomor unit harus diisi.',
            'no_unit.integer' => 'Nomor unit harus berupa angka.',
            'jml_tdr.required' => 'Jumlah tdr harus diisi.',
            'jml_tdr.integer' => 'Jumlah tdr harus berupa angka.',
            'fm_1.required' => 'Field Form Mengantuk harus diisi.',
            'fm_1.string' => 'Field Form Mengantuk harus berupa string.',
            'fm_2.string' => 'Field Form Sakit harus berupa string.',
            'fm_3.string' => 'Field Form Minum Obat harus berupa string.',
            'fm_4.string' => 'Field Form Permasalahan harus berupa string.',
            'location.string' => 'Field Form Location harus berupa string.',
        ]);

        // try {
        $currentHour = now()->hour;
        $shift = ($currentHour >= 6 && $currentHour < 18) ? 'DS' : 'NS';
        DB::table('FM_SHE_019B_MASTER')->insert([
            'nik' => session("user_id"), // Adjust as per your application logic
            'no_unit' => $validatedData['no_unit'], // Adjust as per your application logic
            'jml_tdr' => $validatedData['jml_tdr'],
            'fm_1' => $validatedData['fm_1'],
            'fm_2' => $validatedData['fm_2'],
            'fm_3' => $validatedData['fm_3'],
            'fm_4' => $validatedData['fm_4'],
            'lokasi' => $validatedData['location'],
            'shift' => $shift,
            'jam' => now()->format('H:i:s'),
            'created_at' => now(),
            'created_by' => session("user_id"), // Example value, replace with actual value
        ]);
        return [
            'message' => "Done Data Pra Check Fatigue Tersimpan",
            'code' => 200
        ];

        // } catch (\Throwable $th) {
        //     return [
        //         'message' => 'Failed to insert records' . $th->getMessage(),
        //         'code' => 500
        //     ];
        // }

    }
    function addDataCheckUpPetugas(Request $d)
    {

        $validatedData = $d->validate([
            'tensi' => 'required|regex:/^\d{2,3}\/\d{2,3}$/',
            'nadi' => 'required|integer|min:1|max:200',
            'spo2' => 'required|integer|min:1|max:100',
            'tdr' => 'required|integer|min:1|max:24',
            'suhu' => 'required|numeric|min:1|max:45',
            'masalah' => 'required|string|max:10',
            'mengantuk' => 'required|string|max:10',
            'obat' => 'required|string|max:10',
            'sakit' => 'required|string|max:10',
            'statusByPetugas' => 'required|string|max:10',
            'i' => 'required|integer',
            'j' => 'required|string|max:10',
            'k' => 'required|date|date_format:Y-m-d',
        ]);
        try {

            $status = 1;
            if (
                ($validatedData['nadi'] > 60 && $validatedData['nadi'] < 100) &&
                ($validatedData['spo2'] > 95 && $validatedData['spo2'] < 99) &&
                ($validatedData['tdr'] > 6 && $validatedData['tdr'] < 8)
            ) {
                $status = 1;
            } else if (
                ($validatedData['nadi'] > 101 && $validatedData['nadi'] < 119) &&
                ($validatedData['spo2'] > 91 && $validatedData['spo2'] < 94) &&
                ($validatedData['tdr'] > 6 && $validatedData['tdr'] < 8)
            ) {
                $status = 2;
            } else if (
                ($validatedData['nadi'] < 120) &&
                ($validatedData['spo2'] < 90) &&
                ($validatedData['tdr'] < 4) &&
                ($validatedData['masalah'] == "Y") &&
                ($validatedData['mengantuk'] == "Y") &&
                ($validatedData['ngobat'] == "Y") &&
                ($validatedData['sakit'] == "Y")
            ) {
                $status = 3;
            } else {
                $status = 4;
            }


            DB::table('FM_SHE_019B_MASTER')
                ->where([
                    'id' => $validatedData['i'],
                    'nik' => $validatedData['j'],
                    'created_at' => $validatedData['k'],
                ])
                ->update([
                    'tensi' => $validatedData['tensi'],
                    'nadi' => $validatedData['nadi'],
                    'spo2' => $validatedData['spo2'],
                    'suhu' => $validatedData['suhu'],
                    'status_by_petugas' => $validatedData['statusByPetugas'],
                    'status_by_system' => $status,
                    'updated_at' => now(),
                    'updated_by' => session("user_id"), // Example value, replace with actual value
                ]);

            return [
                'message' => "Done Data Pra Check Fatigue Tersimpan",
                'code' => 200
            ];

        } catch (\Throwable $th) {
            return [
                'message' => 'Failed to insert records' . $th->getMessage(),
                'code' => 500
            ];
        }

    }

    public function GetQueryListSHE019B(string $query, Request $req)
    {

        if (isset($req->search['FILTERNIK']) && $req->search['FILTERNIK'] != null) {
            $query = $query . " AND ms.nik like '%" . $req->search['FILTERNIK'] . "%' ";
        }
        if (isset($req->search['FILTERLOKASI']) && $req->search['FILTERLOKASI'] != null) {
            $query = $query . " AND UPPER(ms.lokasi) LIKE UPPER('%" . $req->search['FILTERLOKASI'] . "%') ";
        }
        if (isset($req->search['FILTERSHIFT']) && $req->search['FILTERSHIFT'] != null) {
            $query = $query . " AND ms.shift = '" . $req->search['FILTERSHIFT'] . "' ";
        }
        if (isset($req->search['FILTERTANGGAL']) && $req->search['FILTERTANGGAL'] != null) {
            $query = $query . " AND ms.created_at = '" . $req->search['FILTERTANGGAL'] . "' ";
        }

        if (isset($req["sort"]) && $req["sort"] != null) {
            $query = $query . ' ORDER BY ' . $req["sort"] . ' ' . $req["order"];
        } else {
            $query = $query . ' ORDER BY ID DESC ';
        }

        if ($req["offset"] != null) {
            $query = $query . ' OFFSET ' . $req["offset"] . ' ROWS ';
        }
        if ($req["limit"] != null) {
            $query = $query . "FETCH NEXT " . $req["limit"] . " ROWS ONLY";
        }
        return $query;
    }

    function helperDataListSHE019B(Request $table)
    {
        $query = "select ms.*, tk.Nama nama, DATEDIFF(YEAR, tk.Tanggal_Lahir, GETDATE()) -
                    CASE
                        WHEN DATEADD(YEAR, DATEDIFF(YEAR, tk.Tanggal_Lahir, GETDATE()), tk.Tanggal_Lahir) > GETDATE() THEN 1
                        ELSE 0
                    END AS Umur  from [FM_SHE_019B_MASTER] ms join hrd.dbo.TKaryawan tk on tk.NIK = ms.nik where 1=1 ";
        $countDataUser = DB::select('select count(*) jumlah FROM FM_SHE_019B_MASTER');
        $newQuery = $this->GetQueryListSHE019B($query, $table);

        $dataUser = DB::select($newQuery);

        return response()->json([
            'total' => $countDataUser[0]->jumlah,
            'totalNotFiltered' => $countDataUser[0]->jumlah,
            "rows" => $dataUser,
        ]);
    }
}
