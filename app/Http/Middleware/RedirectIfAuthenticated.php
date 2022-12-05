<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {

        if (Auth::guard($guard)->check()) {
            if($guard=="admin"){
            
                return redirect(RouteServiceProvider::ADMIN);
            }else if($guard=="shop"){ 
                return redirect(RouteServiceProvider::SHOP);
            }else if($guard=="drivers-on-map"){
                return redirect(RouteServiceProvider::DRIVERSonMap);
            }else
                return $next($request);
        }

        return $next($request);
    }
}
