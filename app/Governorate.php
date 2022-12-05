<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Governorate extends Model
{
    
    protected $fillable = [
        "name",
    ];
    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
