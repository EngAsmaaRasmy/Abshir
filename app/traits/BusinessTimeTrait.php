<?php


namespace App\traits;


use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;

trait BusinessTimeTrait
{
   public function getShopStatus($open_at,$close_at){
       $isCloses_am= preg_match("/am$/i",Carbon::parse($close_at)->format("H:i:a"));
       $now=Carbon::now();
       $close_at=Carbon::parse($close_at);
       $open_at=Carbon::parse($open_at);
       $is_open=false;
       if($open_at < $close_at){
           //If so, if the query time is between open and closed, it is open
           if($now > $open_at){
               if($now < $close_at){
                   $is_open = true;
               }
           }
       }
       elseif($open_at > $close_at){
           $is_open = true;
           //If not, if the query time is between close and open, it is closed
           if($now < $open_at){
               if($now > $close_at){
                   $is_open = false;
               }
           }
       }
       return $is_open;
   }
}
