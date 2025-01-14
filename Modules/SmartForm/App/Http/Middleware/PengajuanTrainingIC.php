<?php

namespace Modules\SmartForm\App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PengajuanTrainingIC
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $nik_session = $request->session()->get('user_id', '');
        $isUserIC = false;
        try {
            $listUserIC = Cache::remember('listUserIC', 21600, function () {
                return DB::connection('sqlsrv_training')->table('authorized_user')->select('nik')->get();
            });
            $isUserIC = $listUserIC->firstWhere('nik', $nik_session) ? true : false;
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
        }

        if(!$isUserIC) abort(404);
        
        return $next($request);
    }
}
