<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;


class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
       
        if (! $request->expectsJson()) {
            if($request->is("admin/*"))
                return route('get-admin-login');
            else if($request->is("shop/*"))
                return route("get.shop.login");
            // else if($request->is("drivers-on-map/*"))
            //     return route("get.driversOnMap.login");
            else
            return route('login');
        }
    }
}
