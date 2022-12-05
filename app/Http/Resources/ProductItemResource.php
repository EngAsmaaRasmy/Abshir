<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\OrderProduct;
use App\Models\shop\Product;
use App\Models\shop\Order;
use App\Models\shop\SizePrice;
use App\Models\admin\ShopModel;

class ProductItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
 
        return parent::toArray($request);

        return [
                    "id"=> $this->id,
                    "fcm_token"=> null,
                    "name"=> "Pizza Hut",
                    "category"=> 1,
                    "logo"=> "images/shops/24/logo.jpg",
                    "delivery_cost"=> 5,
                    "prepare_time"=> 45,
                    "order_count"=> 0,
                    "address"=> "شارع الكورنيش - فندق ريم",
                    "open_at"=> "12=>00=>00",
                    "close_at"=> "03=>00=>00",
                    "rating"=> 4.5,
                    "active"=> 1,
                    "created_at"=> "2021-05-20T00=>54=>49.000000Z",
                    "updated_at"=> "2021-06-06T19:59:37.000000Z"
            
        ];
    }
}
