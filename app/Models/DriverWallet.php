<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DriverWallet extends Model
{
    protected $fillable = ['driver_id','wallet_balance'];
    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
