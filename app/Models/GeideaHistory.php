<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GeideaHistory extends Model
{
    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}