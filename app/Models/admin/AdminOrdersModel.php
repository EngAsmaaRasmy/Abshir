<?php

namespace App\Models\admin;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Model;
use App\Models\admin\DriverModel;
use App\Models\shop\Product;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
class AdminOrdersModel extends Model
{
    protected $table = "admin_orders";
    protected $fillable = [
        "details",
        "delivery_cost",
        "shop",
        "driver_id",
        "category_id",
        "must_paid",
        "customer_phone",
        "customer_name",
        "customer_address",
        "image",
        "customer_id",
        "status",
        "total_price",
        
    ];

  
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
    public function statusRel()
    {
        return $this->hasOne(OrderStatus::class, "id", 'status');
    }

    public function driver()
    {
        return $this->hasOne(DriverModel::class, "id", "driver_id");
    }

    public function adminShop()
    {
        return $this->hasOne(ShopModel::class, "id", 'shop');
    }
    public function customer()
    {
        return $this->hasOne(Customer::class, "id", "customer_id");
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, "order_products", "order", "product")->withPivot(['amount', 'size_id', 'shop', 'type']);;
    }
    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
