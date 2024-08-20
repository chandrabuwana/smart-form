<?php

namespace App;

use Illuminate\Support\Facades\DB;

class Helper
{
    public static function isGrantPermission(string | array $moduleSlug)
    {
        $username = session('user_id');
        return DB::table('users')->select('MS_ROLE_PERMISSION.id')
            ->join('MS_ROLE', 'MS_ROLE.role_code', '=', 'users.role')
            ->join('MS_ROLE_PERMISSION', 'MS_ROLE_PERMISSION.role_id', '=', 'MS_ROLE.id')
            ->join('MS_PERMISSION_MODULE', 'MS_PERMISSION_MODULE.id', 'MS_ROLE_PERMISSION.permission_module_id')
            ->where('users.username', $username)
            ->where( function($q) use($moduleSlug) {
                if(is_array($moduleSlug)) {
                    $q->whereIn('MS_PERMISSION_MODULE.module_slug', $moduleSlug);
                } else {
                    $q->where('MS_PERMISSION_MODULE.module_slug', $moduleSlug);
                }

            })->count() > 0;
    }
}
