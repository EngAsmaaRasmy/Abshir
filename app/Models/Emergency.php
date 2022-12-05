<?php

namespace App\Models;

use App\Models\admin\DriverModel;
use Illuminate\Database\Eloquent\Model;

class Emergency extends Model
{
    protected $fillable = [
        'user_id', 'trip_id', 'type',
    ];

    public function trip()
    {
        return $this->belongsTo(Trip::class);
    }
    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
