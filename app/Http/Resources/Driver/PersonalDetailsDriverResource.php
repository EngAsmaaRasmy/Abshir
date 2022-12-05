<?php

namespace App\Http\Resources\Driver;

use Illuminate\Http\Resources\Json\JsonResource;

class PersonalDetailsDriverResource extends JsonResource
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
            'date_of_birth' =>$this->date_of_birth,
            'identity_number' =>$this->identity()->identity_number,
            'identity_image' =>$this->identity()->identity_image,
            'gender' =>$this->identity()->gender,
            'license_number' =>$this->license_number,
            'expiry_date' =>$this->identity()->expiry_date,
            'driving_license' =>$this->driving_license,
            'image' =>$this->image,
            

        ];
    }
}
