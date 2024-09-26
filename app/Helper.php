<?php

namespace App;

use Illuminate\Support\Facades\DB;

class Helper
{
    public static function isGrantPermission(string $username, string $moduleName)
    {
        // spesific action
        // $username = session('user_id');
        // return DB::table('users')->select('MS_ROLE_PERMISSION.id')
        //     ->join('MS_ROLE', 'MS_ROLE.role_code', '=', 'users.role')
        //     ->join('MS_ROLE_PERMISSION', 'MS_ROLE_PERMISSION.role_id', '=', 'MS_ROLE.id')
        //     ->join('MS_PERMISSION_MODULE', 'MS_PERMISSION_MODULE.id', 'MS_ROLE_PERMISSION.permission_module_id')
        //     ->where('users.username', $username)
        //     ->where( function($q) use($moduleSlug) {
        //         if(is_array($moduleSlug)) {
        //             $q->whereIn('MS_PERMISSION_MODULE.module_slug', $moduleSlug);
        //         } else {
        //             $q->where('MS_PERMISSION_MODULE.module_slug', $moduleSlug);
        //         }

        //     })->count() > 0;

        return DB::table('users')->select('MS_ROLE_PERMISSION.id')
            ->join('MS_ROLE', 'MS_ROLE.role_code', '=', 'users.role')
            ->join('MS_ROLE_PERMISSION', 'MS_ROLE_PERMISSION.role_id', '=', 'MS_ROLE.id')
            ->join('MasterMenu', 'MasterMenu.id', 'MS_ROLE_PERMISSION.master_menu_id')
            ->where('users.username', $username)
            ->where('MasterMenu.nama', $moduleName)->count() > 0;
    }

    public static function numberToRomanRepresentation($number) {
        $map = array('M' => 1000, 'CM' => 900, 'D' => 500, 'CD' => 400, 'C' => 100, 'XC' => 90, 'L' => 50, 'XL' => 40, 'X' => 10, 'IX' => 9, 'V' => 5, 'IV' => 4, 'I' => 1);
        $returnValue = '';
        while ($number > 0) {
            foreach ($map as $roman => $int) {
                if($number >= $int) {
                    $number -= $int;
                    $returnValue .= $roman;
                    break;
                }
            }
        }
        return $returnValue;
    }
}
