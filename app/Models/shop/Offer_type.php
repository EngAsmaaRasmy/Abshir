<?php

namespace App\Models\shop;

use Illuminate\Database\Eloquent\Model;

class Offer_type extends Model
{
    protected $table="offer_types";
   protected $fillable=["name_ar","name_en"];
   public  function offer(){

       return $this->belongsTo("App\Models\shop\ProductOffer");
   }
   protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
