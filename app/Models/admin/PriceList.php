<?php
namespace App\Models\admin;
use Spatie\Activitylog\Traits\LogsActivity;


use Illuminate\Database\Eloquent\Model;

class PriceList extends Model
{
    use LogsActivity;

    protected $table='price_lists';
    protected $fillable=["name", "kilo_price", "minute_price", "start_price"];

    protected static $logAttributes = ['name', 'kilo_price', 'minute_price', 'start_price'];
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
