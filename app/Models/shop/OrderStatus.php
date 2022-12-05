<?php

namespace App\Models\shop;

use App\Models\admin\AdminOrdersModel;
use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{
    protected $table="order_statuses";
    protected $fillable=["name_ar","name_en","description_ar","description_en"];

    public  function order(){
        return $this->belongsTo(Order::class);
    }
    public  function adminOrder(){
        return $this->belongsTo(AdminOrdersModel::class);
    }
    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
