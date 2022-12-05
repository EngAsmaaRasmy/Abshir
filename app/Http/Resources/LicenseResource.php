<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LicenseResource extends JsonResource
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
            'license_name' => $this->license_name,
            'license_year' => $this->license_year,
            'license_nationality' => $this->license_nationality,
            'expiry_date' => $this->expiry_date,
            'license_vehicle' => $this->license_vehicle,
            'license_number' => $this->license_number,
            'license_image' => url($this->license_image),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            
        ];
    }
}
