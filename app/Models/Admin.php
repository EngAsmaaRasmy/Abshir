<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Activitylog\Traits\LogsActivity;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Tymon\JWTAuth\Facades\JWTAuth;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Authenticatable implements JWTSubject
{
    use Notifiable, HasRoles, LogsActivity;

   protected $table="admins";
   protected $fillable=["name","email","active","password", "roles_name"];
   
   protected $hidden=["password","remember_token"];

   protected static $logAttributes = ['name', 'email'];
   protected static $recordEvent = ['created', 'updated', "deleted"]; 

   protected static $logOnlyDirty = true;

   public function getDescriptionForEvent(string $eventName): string
   {
       return "This model has been {$eventName}";
   }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
    public function getTokenAttribute(){
        return JWTAuth::fromUser($this);
    }
    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
