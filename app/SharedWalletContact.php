<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SharedWalletContact extends Model
{
    protected $fillable = ['customer_contact_id','limit','limit_value','contact_id'];
    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
