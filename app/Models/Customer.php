<?php

namespace App\Models;

use App\Models\shop\Order;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class Customer extends Authenticatable
{
    use Notifiable;



    protected $fillable=["name","phone","uid","fcm_token","api_token","image"];
    
    public function address(){
        return $this->belongsTo("App\Models\Address");
    }

    public function order(){
        return $this->belongsTo(Order::class);
    }
    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

}
