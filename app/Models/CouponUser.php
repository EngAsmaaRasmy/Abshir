<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CouponUser extends Model
{
    protected $table="coupon_users";
    protected $fillable = ["coupon", "user"];


   public function couponRel(){
       return $this->hasMany("App\Models\Coupon","id","coupon");
   }
   protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
