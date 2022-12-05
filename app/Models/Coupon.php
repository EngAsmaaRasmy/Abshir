<?php

namespace App\Models;

use App\Models\admin\ShopModel;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = ["name", "type", "value","percentage","minimum_order", "shop", "expire_date", "max_count"];

    public function couponUser()
    {
        return $this->belongsTo(CouponUser::class);
    }

    public function type(){
        return $this->hasOne(CouponType::class,"id","type");
    }

    public function shopRelation(){
        return $this->hasOne(ShopModel::class,"id");
    }
    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}