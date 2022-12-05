<?php

namespace App\Models;

use App\Models\admin\ShopModel;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $fillable = ["name"];
    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

 
}
