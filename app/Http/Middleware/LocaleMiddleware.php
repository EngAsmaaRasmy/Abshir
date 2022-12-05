<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class LocaleMiddleware
{

    public function handle(Request $request, Closure $next)
    {

        app()->setLocale("ar");
        if(isset($request->lang) && $request->lang=="en")
            app()->setLocale("en");
        return $next($request);
    }
}
