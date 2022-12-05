<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PayForMeHistory extends Model
{
    protected $fillable = [
        "contact_id",
        "trip_id",
        "status",
    ];

    public function customerRel()
    {
        return $this->belongsTo(Customer::class,  "contact_id");
    }

    public function tripRel()
    {
        return $this->belongsTo(Trip::class,  "trip_id");
    }
    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
