<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VehiclesModel extends Model
{
    protected $fillable = ['model','marker_id','image'];
    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
