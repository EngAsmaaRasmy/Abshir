<?php

namespace App\Http\Resources;

use App\Models\Identity;
use App\Models\License;
use App\Models\Vehicle;
use Illuminate\Http\Resources\Json\JsonResource;

class DriverResource extends JsonResource
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
            'fullname' => $this->fullname,
            'phone' => $this->phone,
            'image' =>  $this->image ? url($this->image) : "https://i.imgur.com/V0Dmtwi.jpg",
            'review' => "4",
            'vehicle' =>  new VehicleResource(Vehicle::where('driver_id',$this->id)->first()),

        ];
    }
}
