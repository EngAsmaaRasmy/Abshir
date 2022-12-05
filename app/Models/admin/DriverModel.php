<?php

namespace App\Models\admin;

use App\Models\Admin;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Laravel\Passport\HasApiTokens;

class DriverModel extends Authenticatable
{

    use Notifiable, HasApiTokens, LogsActivity;

    protected $table = "drivers";
    protected $fillable = [
        "fullname", "phone", 'email', "shop", 'transportation_id', "password", "address", "active",
        'documents', 'driving_license', 'driving_license_back', 'license_number', 'city_name', "order_count", "active_order", "total_earnings", "api_token", "fcm_token",
        "image", "delivery_status", 'lemozen_status', 'status', 'is_delivery', 'is_ride', 'date_of_birth'
    ];
    protected $hidden = ["password",'updated_at'];

    protected $casts = [
        'type_of_use' => 'array',
    ];

    protected static $logAttributes = ['status'];

    protected static $recordEvent = ['created', 'updated', "deleted"];

    protected static $logOnlyDirty = true;

    public function getDescriptionForEvent(string $eventName): string
    {
        return "This model has been {$eventName}";
    }


    public function order()
    {
        return $this->belongsTo("App/Models/admin/AdminOrdersModel");
    }
    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
