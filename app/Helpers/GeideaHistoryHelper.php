<?php

namespace App\Helpers;

use App\Models\GeideaHistory;

class GeideaHistoryHelper
{

    public static function addGeideaHistoryApp($geidea_account_id = 1, $trip_id = null, $value = 0, $type = 'Add', $user_type = 'APP', $customer_id = null)
    {
        $geideaHistory = new GeideaHistory();
        $geideaHistory->geidea_account_id = $geidea_account_id;
        $geideaHistory->trip_id = $trip_id;
        $geideaHistory->value = $value;
        $geideaHistory->type = $type;
        $geideaHistory->user_type = $user_type;
        $geideaHistory->customer_id = $customer_id;
        $geideaHistory->save();
    }
    public static function addGeideaHistoryAdmin($geidea_account_id = 1, $trip_id = null, $value = 0, $type = 'Minus', $user_type = 'Admin', $customer_id = null)
    {
        $geideaHistory = new GeideaHistory();
        $geideaHistory->geidea_account_id = $geidea_account_id;
        $geideaHistory->trip_id = $trip_id;
        $geideaHistory->value = $value;
        $geideaHistory->type = $type;
        $geideaHistory->user_type = $user_type;
        $geideaHistory->customer_id = $customer_id;
        $geideaHistory->save();
    }
}
