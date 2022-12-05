<?php

namespace App\Models\shop;

use App\Models\admin\ShopModel;
use App\Models\Shop;
use Illuminate\Database\Eloquent\Model;

class ProductOffer extends Model
{
    protected $table="product_offers";
    protected $fillable=["type","name","shop","size_id","percentage","value","amount","gift_amount","expire_date"];
    public  function type(){
      return $this->hasOne("App\Models\shop\offer_types","id","type");
    }

    public  function size(){
        return $this->belongsTo(SizePrice::class);
    }


    public function shop(){
        return $this->hasOne(ShopModel::class,"id","shop");
    }
    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

}
