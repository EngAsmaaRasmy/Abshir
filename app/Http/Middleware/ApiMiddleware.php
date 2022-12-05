<?php

namespace App\Http\Middleware;

use App\Models\Customer;
use Closure;
use Illuminate\Support\Str;

class ApiMiddleware
{

    public function handle($request, Closure $next)
    {


        $token=$request->header('Authorization');
        if(Str::startsWith($token,"Bearer")){
            $token=Str::substr($token,7);
        }
        $customer = Customer::where('api_token',$token)->first();
        
        if($customer){
            return $next($request);

        }else{
            return response(['unautherized'],401);
            
        }
    //     $password=$request->api_password;

    //     $user=Customer::find($request->user_id);
    //     dd($token);

    //     $userFound=false;
    //     if(isset($user)){
    //         $userFound=true;
    //     }
    //     else{
    //         $userFound=false;
    //     }




    //     if(!$userFound||$user->api_token!= $token){
    //         return response(['unautherized'],401);
    //     }
    //     return $next($request);
    }
}
