<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VehicleResource extends JsonResource
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
            'vehicle_name' => $this->vehicle_name,
            'vehicle_type' => $this->vehicle_type,
            'plate_number' => $this->plate_number,
            'vehicle_color' => $this->vehicle_color,
            
        ];
    }
}
