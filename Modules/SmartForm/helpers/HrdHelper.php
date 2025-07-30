<?php

namespace Modules\SmartForm\helpers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class HrdHelper
{
    private const DB_HRD = "HRD";
    private const TABLE_KARYAWAN_HRD = self::DB_HRD . ".dbo.TKaryawan";
    private const DB_CONN2_NAME = 'sqlsrv2';

    public static function getApprovalList(string $search = null, string $selectedNik = null)
{
    if (!self::isConnectionAvailable()) {
        return collect([]);
    }

    try {
        $query = DB::connection(self::DB_CONN2_NAME)
            ->table(self::TABLE_KARYAWAN_HRD)
            ->select(['NIK as nik', 'Nama as nama'])
            ->where('Aktif', 0);


        if ($selectedNik) {
            $query->where(function ($q) use ($search, $selectedNik) {

                $q->where('Nama', $selectedNik)
                ->orWhere('NIK', $selectedNik);


                if ($search) {
                    $q->orWhere(function ($subQ) use ($search) {
                        $subQ->where('NIK', 'like', "%$search%")
                             ->orWhere('Nama', 'like', "%$search%");
                    });
                }
            });
        } else {

            $query->where(function ($q) use ($search) {
                $q->where('NIK', 'like', "%$search%")
                  ->orWhere('Nama', 'like', "%$search%");
            });
        }
        if (!$selectedNik) {
            $query->limit(50);
        }

        return $query->get();

    } catch (\Exception $e) {
        Log::error('Query execution failed', ['error' => $e->getMessage()]);
        return collect([]);
    }
}

    private static function isConnectionAvailable(): bool
    {
        try {
            DB::connection(self::DB_CONN2_NAME)->getPdo();
            return true;
        } catch (\Exception $e) {
            Log::error('Database connection failed', ['error' => $e->getMessage()]);
            return false;
        }
    }
}
