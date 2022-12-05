<?php

namespace App\Http\Middleware;
use App\Models\admin\DriverModel;
use App\Models\Customer;
use App\traits\ResonseTrait;
use Closure;
use Illuminate\Support\Str;



class DriverApiMiddleware
{

    use ResonseTrait;

    public function handle($request, Closure $next)
    {
        $token=$request->header('Authorization');
        
        if(Str::startsWith($token,"Bearer")){
            $token=Str::substr($token,7);
        }

        $password=$request->api_password;

        $driver=DriverModel::where("api_token",$token)->first();

        $userFound=false;
        if(isset($driver)){
            $userFound=true;
        }
        else{
            $userFound=false;
        }

        if(!$userFound||$driver->api_token!=$token){
            return response(['unautherized'],401);
        }
        return $next($request);
    }
}
