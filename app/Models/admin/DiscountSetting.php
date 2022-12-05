<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class DiscountSetting extends Model
{
    use LogsActivity;

    protected $fillable=["name", "discount_value"];

    protected static $logAttributes = ['name', 'discount_value'];
    protected static $recordEvent = ['created', 'updated', "deleted"]; 
 
    protected static $logOnlyDirty = true;
 
    public function getDescriptionForEvent(string $eventName): string
    {
        return "This model has been {$eventName}";
    }
    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
