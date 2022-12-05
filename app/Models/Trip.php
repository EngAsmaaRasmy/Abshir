<?php

namespace App\Models;

use App\Models\admin\ShopModel;
use Illuminate\Database\Eloquent\Model;
use App\Models\admin\DriverModel;
use App\Models\admin\PriceList;

class Trip extends Model
{
    protected $fillable = [
        "client_id",
        "driver_id",
        "price_list_id",
        "type_of_payment",
        "trip_approve_time",
        "trip_arrive_time",
        "trip_start_time",
        "trip_end_time",
        "start_lat",
        "start_long",
        "end_lat",
        "end_long",
        "trip_time",
        "distance",
        "cost",
        "cost_after_discount",
        "status",
        "cancellation_reason",
        'coupon_id',

    ];

     public function driverRel()
    {
        return $this->belongsTo(DriverModel::class,  "driver_id");
    }

    public function customerRel(){
        return $this->belongsTo(Customer::class,'client_id');
    }

    public function couponRel(){
        return $this->belongsTo(Coupon::class,'coupon_id');
    }

    public function priceList(){
        return $this->belongsTo(PriceList::class,'price_list_id');
    }

    public function paymentType(){
        return $this->belongsTo(TypeOfPayment::class,'type_of_payment');
    }
    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
