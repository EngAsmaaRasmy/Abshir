<?php

namespace App\Models\shop;

use Illuminate\Database\Eloquent\Model;

class ShopNotificationModel extends Model
{
    protected $table="shop_notifications";
    protected $fillable=["title","content","read","shop"];
    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
