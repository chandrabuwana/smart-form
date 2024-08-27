<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

class FetchMenu {
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $data = DB::table('MasterMenu')
            ->select('id', 'nama', 'link', 'parent', 'urutan as order', 'role as roles', 'type', 'permission_module_id')
            ->where('status', 1)
            ->orderBy('parent')
            ->orderBy('urutan')
            ->get();

        $rolePermissionUser = DB::table('MS_ROLE_PERMISSION')->select('permission_module_id')
            ->join('MS_ROLE', 'MS_ROLE.id', '=', 'MS_ROLE_PERMISSION.role_id')
            ->join('users', 'users.role', '=', 'MS_ROLE.role_code')
            ->where('users.username', session('user_id'))
            ->get()->pluck('permission_module_id')->all();

        $data_menu = [];
        foreach($data as $item) {
            if(!empty($item->permission_module_id) && !in_array($item->permission_module_id, $rolePermissionUser)) {
                continue;
            }

            if($item->parent == null) {
                $data_menu[$item->id] = array(
                    'nama' => $item->nama,
                    'order' => $item->order,
                    'child' => []
                );
            } else {
                array_push($data_menu[$item->parent]['child'], array(
                    'id' => $item->id,
                    'nama' => $item->nama,
                    'link' => $item->link,
                    'parent' => $item->parent,
                    'order' => $item->order,
                    'type' => $item->type
                ));
            }
        }

        View::share('menu', $data_menu);
        View::share('userIdToken', User::getUserIdToken());

        return $next($request);
    }
}
