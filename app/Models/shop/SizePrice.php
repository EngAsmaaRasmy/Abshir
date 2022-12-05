<?php

namespace App\Models\shop;

use App\Models\OrderProduct;
use Illuminate\Database\Eloquent\Model;

class SizePrice extends Model
{
    protected $fillable=["product_id","name","price","offer_id"];


    public function product(){
        return $this->hasOne(Product::class,"id","product_id");
    }
    public function offer(){
        return $this->hasOne(ProductOffer::class,"id","offer_id");
    }

    public function order(){
        return $this->belongsTo(OrderProduct::class);
    }
    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
