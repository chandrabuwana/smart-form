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
}
