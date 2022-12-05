<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GeideaAccount extends Model
{
    
    protected $fillable = ['balance'];
    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
