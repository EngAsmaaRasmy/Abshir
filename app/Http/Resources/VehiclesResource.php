<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VehiclesResource extends JsonResource
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
            'vehicle_model' => $this->vehicle_model,
            'vehicle_year' => $this->vehicle_year,
            'plate_number' => $this->plate_number,
            'motion_vector' => $this->motion_vector,
            'horse_power' => $this->horse_power,
            'vehicle_color' => $this->vehicle_color,
            'kilometer_count' => $this->kilometer_count,
            'vehicle_license_image' => url($this->vehicle_license_image),
            'vehicle_image' => url($this->vehicle_image),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            
        ];
    }
}
