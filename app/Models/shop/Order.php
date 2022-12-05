<?php

namespace App\Models\shop;

use App\Models\admin\DriverModel;
use App\Models\admin\ShopModel;
use App\Models\Customer;
use App\Models\OrderProduct;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Order extends Model
{
    protected $table = "orders";
    protected $fillable = ["shop", "customer","delivery_cost", "driver","order_description", "total_price", "status", "user_address", "price_after_discount", "must_paid_price","shipping_method"];
    protected $appends = ['has_driver'];

    public function order_product()
    {
        return $this->belongsTo(OrderProduct::class);
    }


    public function scopeNew($query)
    {
        return $query->where('status', 1);
    }

    public function scopeActive($query)
    {
        return $query->where("status", 2);
    }

    public function scopeCurrent($query){
        return $query->where("status","<",5);
    }
    public function scopeRefused($query){
        return $query->where("status",6);
    }
    public function scopeFailed($query){
        return $query->where("status",7);
    }
    public function scopeDelivered($query){
        return $query->where("status",8);
    }

    public function scopeThisShop($query)
    {
        return $query->where("shop", Auth::id());
    }

    /**
     * Determine if the user is an administrator.   
     *
     * @return bool
     */
    public function getHasDriverAttribute()
    {
        return $this->driverRel ? true : false;
    }

    public function statusRel()
    {
        return $this->hasOne(OrderStatus::class, "id", 'status');
    }

    public function driverRel()
    {
        return $this->hasOne(DriverModel::class, "id", "driver");
    }

    public function customerRel(){
        return $this->hasOne(Customer::class,"id",'customer');
    }

    public function shop(){
        return $this->hasOne(ShopModel::class,"id",'shop');
    }
    public function products(){
        return $this->belongsToMany(Product::class,"order_products","order","product");
    }

    public function info(){
        return $this->belongsTo(OrderProduct::class,"id","order");
    }
    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }


}
