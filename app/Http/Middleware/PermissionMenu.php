<?php

namespace App\Http\Middleware;

use App\Helper;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

class PermissionMenu
{
    private function _getMenuName(): ?String
    {
        $mappingsPermission = [
            'Master Data' => [
                'master-form-pic',
            ],
            'Admin' => [
                'role-management',
                'user-management',
            ],
            'PLANT' => [
                'bss-form.plant-transmission',
                'bss-form.undercarriage',
            ]
        ];
        $currentRoute = Route::getCurrentRoute()->getName();

        foreach($mappingsPermission as $menu => $routes) {
            foreach($routes as $item) {
                if(preg_match("/^{$item}/i", $currentRoute)) {
                    return $menu;
                }
            }
        }

        return null;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $menuName = $this->_getMenuName();
        $username = session('user_id');

        if(!empty($menuName) && !Helper::isGrantPermission($username, $menuName)) {
            abort(403);
        }

        return $next($request);
    }
}
