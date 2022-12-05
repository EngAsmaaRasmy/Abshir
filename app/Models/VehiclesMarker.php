<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VehiclesMarker extends Model
{
    protected $fillable = ['marker','image'];
    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
