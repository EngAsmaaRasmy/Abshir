<?php

namespace App\Helpers;

use App\Models\AdminWalletHistory;
use App\Models\DriverWalletHistory;
use App\WalletHistory;

class WalletHistoryGeneralHelper
{
    
    public static function addCustomerWalletHistory($value,$user_type,$type,$added_by,$wallet_id,$trip_id)
    {
        $history = new WalletHistory();
        $history->value = $value;
        $history->user_type = $user_type;
        $history->type = $type;
        $history->added_by = $added_by;
        $history->wallet_id =$wallet_id;
        $history->trip_id =$trip_id;
        $history->save();
    }

    public static function addAdminWalletHistory($value,$user_type,$type,$added_by,$wallet_id)
    {
        $history = new AdminWalletHistory();
        $history->value = $value;
        $history->user_type = $user_type;
        $history->type = $type;
        $history->added_by = $added_by;
        $history->wallet_id =$wallet_id;
        $history->save();
    }

    public static function addDriverWalletHistory($value,$user_type,$type,$added_by,$wallet_id,$trip_id=null)
    {
        
        $history = new DriverWalletHistory();
        $history->value = $value;
        $history->user_type = $user_type;
        $history->type = $type;
        $history->added_by = $added_by;
        $history->wallet_id =$wallet_id;
        $history->trip_id =$trip_id;
        $history->save();
    }
    
  
}