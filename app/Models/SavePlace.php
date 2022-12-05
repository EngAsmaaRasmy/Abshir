<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SavePlace extends Model
{
    protected $fillable = ['name','lat','lng','customer_id'];
    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
