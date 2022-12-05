<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\OrderProduct;
use App\Models\shop\Product;
use App\Models\shop\Order;
use App\Models\shop\SizePrice;
use App\Models\admin\ShopModel;

class TripResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        
 

         return [
            'id' => $this->id,
            'start_lat' => $this->start_lat,
            'start_long' => $this->start_long,
            'end_lat' => $this->end_lat,
            'end_long' => $this->end_long,
            'driver' => $this->driverRel,
            'cost' => $this->cost,
            'cancellation_reason' => $this->cancellation_reason,
            'customerRel' => $this->customerRel,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

        ];

    }
}

 
