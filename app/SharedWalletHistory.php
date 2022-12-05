<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SharedWalletHistory extends Model
{
    protected $fillable = [
        "customer_contact_id",
        "trip_id",
        'type'
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
