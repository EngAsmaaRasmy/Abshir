<?php

namespace App\Models;

use App\Models\shop\SizePrice;
use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    protected $table="order_products";
    protected $fillable=["order","size_id","product","amount","shop"];


    public function orderRel(){
        return $this->hasOne("App\Models\shop\Order","id",'order');
    }
    public function adminOrderRel(){
        return $this->hasOne("App\Models\admin\AdminOrdersModel","id",'order');
    }


    public function productRel(){
        return $this->hasOne("App\Models\shop\Product","id",'product');
    }

    public function size(){
        return $this->hasOne(SizePrice::class,"id","size_id");
    }

    public function category(){
        return $this->product()->with('category');
    }
    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

}
