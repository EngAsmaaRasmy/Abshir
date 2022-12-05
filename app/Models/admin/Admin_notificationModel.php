<?php

namespace App\Models\admin;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Model;

class Admin_notificationModel extends Model
{
    protected $table="admin_notifications";
    protected $fillable=["title","content","customer_id","read"];
    public function customer(){
        return $this->hasOne(Customer::class,"id","customer_id");
    }
    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
