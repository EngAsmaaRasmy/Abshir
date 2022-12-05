<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CouponType extends Model
{
    protected $fillable=['name'];
    public function coupon(){
        return $this->belongsTo(Coupon::class);
    }
    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
