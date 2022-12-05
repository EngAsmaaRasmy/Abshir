<?php

namespace App\Helpers;

use App\Models\admin\DriverModel;
use App\Models\Customer;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Claims\Custom;

class GeneralHelper
{
    protected static $currentDriver;
    protected static $currentCustomer;

    public static function currentDriver($token)
    {
        
        if(Str::startsWith($token,"Bearer")){
            $token=Str::substr($token,7);
        }
        return self::$currentDriver = DriverModel::where("api_token",$token)->first();

    }

    public static function currentCustomer($token)
    {
        
        if(Str::startsWith($token,"Bearer")){
            $token=Str::substr($token,7);
        }
        return self::$currentCustomer = Customer::where("api_token",$token)->first();
        
    }
    
    
  
}