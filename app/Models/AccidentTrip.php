<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccidentTrip extends Model
{
    protected $fillable = [
        'customer_id', 'trip_id', 'driver_id',
    ];
    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

}
