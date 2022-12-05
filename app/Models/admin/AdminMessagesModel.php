<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Model;

class AdminMessagesModel extends Model
{
    protected $table="admin_messages";
    protected $fillable=["content","name","phone","read"];
    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
