<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable=["lat","customer_id","lng","name","full_address","building_info"];
   public function customer(){
       return $this->hasMany("App\Models\Customer","customer_id","id");
   }
   protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

}
