<?php

namespace App\Http\Middleware;

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
            ->select('id', 'nama', 'link', 'parent', 'urutan as order', 'role as roles')
            ->where('status', 1)
            ->orderBy('parent')
            ->orderBy('urutan')
            ->get();
        $data_menu = [];
        foreach($data as $item) {
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
                    'order' => $item->order
                ));
            }
        }

        View::share('menu', $data_menu);

        return $next($request);
    }
}
