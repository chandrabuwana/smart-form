<?php

namespace Modules\SmartForm\helpers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class HrdHelper
{
    private const DB_HRD = "HRD";
    private const TABLE_KARYAWAN_HRD = self::DB_HRD . ".dbo.TKaryawan";
    private const DB_CONN2_NAME = 'sqlsrv2';

    public static function getApprovalList()
    {
        try {
            // Test the connection first
            try {
                DB::connection(self::DB_CONN2_NAME)->getPdo();
            } catch (\Exception $e) {
                Log::error('Database connection failed', [
                    'error' => $e->getMessage()
                ]);
                return collect([]);
            }
            
            // Build and execute query
            try {
                // $query = DB::connection(self::DB_CONN2_NAME)
                //     ->table(DB::raw(self::TABLE_KARYAWAN_HRD))
                //     ->select([
                //         'NIK as nik',
                //         'Nama as nama',
                //     ])
                //     ->where('AKTIF', 0)
                //     ->limit(50)
                //     ->orderBy('Nama', 'asc');
                
                // return $query->get();
                Log::info($query . ' - '. trim($query) . ' - ' . strlen(trim($query)));
                if(strlen(trim($query))) {
                    $data = DB::connection('sqlsrv2')->table(self::TABLE_KARYAWAN_HRD)->select('NIK as nik', 'Nama as nama')->where('Aktif', 0);
    
                    if($query) $data->where('NIK', 'like', "%$query%")->orWhere('Nama', 'like', "%$query%");
                    Log::info($data->toRawSql());
                    // $data = $data->get();
                    return $data->get();
                }
            } catch (\Exception $e) {
                Log::error('Query execution failed', [
                    'error' => $e->getMessage()
                ]);
                return collect([]);
            }
            
        } catch (\Exception $e) {
            Log::error('Error in getUserList: ' . $e->getMessage());
            return collect([]);
        }
    }
}
