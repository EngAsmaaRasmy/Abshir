<?php

namespace App\Models\admin;

use App\Models\OrderProduct;
use App\Models\Coupon;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Models\shop\Order;
use App\Models\shop\Product;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Tymon\JWTAuth\Facades\JWTAuth;

class ShopModel extends Authenticatable implements JWTSubject
{
    use LogsActivity;
    
    protected $table="shops";
    protected $fillable=["logo","name","fcm_token","phone","prepare_time","category","username","password","address","active","open_at","close_at","order_count","total_earnings",'area','latitude', 'longitude', 'type'];
    protected $hidden=["password","remember_token","username","phone","total_earnings"];
    
    protected $appends = ['cancelled_orders_count'];

    protected $logAttributes = [
        "logo",
        "name",
        "phone",
        "prepare_time",
        "category",
        "username",
        "address",
        "active",
        "open_at",
        "close_at",
        
    ];
    protected static $recordEvent = ['created', 'updated', "deleted"]; 
 
    protected static $logOnlyDirty = true;
 
    public function getDescriptionForEvent(string $eventName): string
    {
        return "This model has been {$eventName}";
    }

    public function getCancelledOrdersCountAttribute()
    {
        return OrderProduct::where([['shop',$this->id],['status','cancelled']])->count();
    }
        
    
    public function order(){
        return $this->belongsTo(Order::class);
    }

    public function adminOrder(){
        return $this->belongsTo("App/Models/admin/AdminOrdersModel");
    }
    public function product(){
        return $this->belongsTo("App\Models\shop\Product",'id','shop');
    }

    public function coupon(){
        return $this->belongsTo(Coupon::class);
    }

    public function getJWTIdentifier()
    {
       return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [

        ];
    }





    public function getTokenAttribute(){
        return JWTAuth::fromUser($this);
    }
    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
 
}
