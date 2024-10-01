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
        $data_notification = DB::table('pica_notification')
            ->select('id as nomor', 'nik', 'message', 'created_at', 'category')
            ->orderBy('id', 'desc')
            ->where('nik', $request->session()->get('user_id'))
            ->get();
        $data = DB::table('MasterMenu')
            ->select('id', 'nama', 'link', 'parent', 'urutan as order', 'role as roles', 'type', 'permission_module_id')
            ->where('status', 1)
            ->orderBy('parent')
            ->orderBy('urutan')
            ->get();

        // check permission first
        $rolePermissionUser = DB::table('MS_ROLE_PERMISSION')->select('master_menu_id')
            ->join('MS_ROLE', 'MS_ROLE.id', '=', 'MS_ROLE_PERMISSION.role_id')
            ->join('users', 'users.role', '=', 'MS_ROLE.role_code')
            ->where('users.username', session('user_id'))
            ->get()->pluck('master_menu_id')->all();

        $allowedMenus = [];
        foreach($data as $item) {
            if(!is_null($item->parent) || !in_array($item->id, $rolePermissionUser)) continue;
            $allowedMenus[] = $item->id;
        }

        $data_menu = [];
        foreach($data as $item) {
            if((!is_null($item->parent) && !in_array($item->parent, $allowedMenus)) || (is_null($item->parent) && !in_array($item->id, $allowedMenus))) {
                continue;
            }

            if($item->parent == null) {
                $data_menu[$item->id] = array(
                    'nama' => $item->nama,
                    'order' => $item->order,
                    'child' => []
                );
            } else {
                $data_menu[$item->parent]['child'][] = array(
                    'id' => $item->id,
                    'nama' => $item->nama,
                    'link' => $item->link,
                    'parent' => $item->parent,
                    'order' => $item->order,
                    'type' => $item->type
                );
            }
        }

        View::share('menu', $data_menu);
        View::share('pica_notification', $data_notification);
        View::share('userIdToken', User::getUserIdToken());

        return $next($request);
    }
}
