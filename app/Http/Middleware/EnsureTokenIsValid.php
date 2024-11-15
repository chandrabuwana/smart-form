<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Illuminate\Http\Request;

class EnsureTokenIsValid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // dd(Auth::check());
        if (!Auth::check()) {
            // kembali ke login
            $currentRoute = $request->route();
            if($currentRoute) {
                $middlewares = $currentRoute->getAction('middleware');
                $authMiddleware = 'check.auth';

                if(in_array($authMiddleware, $middlewares)) {
                    setcookie('prev_auth_route', $currentRoute->getName(), time() + ( 365 * 24 * 60 * 60), '/');
                }
            }

            return redirect('/login');
        }

        return $next($request);
    }
}
