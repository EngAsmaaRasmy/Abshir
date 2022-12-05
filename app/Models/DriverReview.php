<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DriverReview extends Model
{
    protected $fillable = ['rate','comment','driver_id','customer_id'];

    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
