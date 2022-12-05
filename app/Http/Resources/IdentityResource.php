<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class IdentityResource extends JsonResource
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
            'name' => $this->name,
            'identity_number' => $this->identity_number,
            'expiry_date' => $this->expiry_date,
            'nationality' => $this->nationality,
            'birthday' => $this->birthday,
            'religion' => $this->religion,
            'identity_image' => url($this->identity_image),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            
        ];
    }
}
