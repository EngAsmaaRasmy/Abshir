<?php

namespace App\Models\shop;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ShopCategory extends Model
{
    protected $table="shops_categories";
    protected $fillable=["shop",'name_ar',"name_en","active"];
   protected $appends=[
       "name",

   ];


    public function getNameAttribute(){
        if(app()->getLocale()=='ar'){
            return $this->name_ar;
        }
        return $this->name_en ?? $this->name_ar;
    }

    public  function product()
    {
        return $this->belongsTo("App\Models\shop\Product");

    }
    public  function scopeActive($query){
        return $query->where("active",1);
    }
    public  function scopeShop($query){
        return $query->where("shop",Auth::user()->id);
    }
    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
