<?php

namespace App\traits;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

trait IDs
{
   public function getNextId($table){
    $statement=DB::select("show table status like '{$table}' ");
    return $statement[0]->Auto_increment;

   }


}
