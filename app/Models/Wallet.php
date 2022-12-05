<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Wallet extends Model
{
    use LogsActivity; 

    protected $fillable = ['customer_id','wallet_balance'];

    protected static $logAttributes = ['wallet_balance'];

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
