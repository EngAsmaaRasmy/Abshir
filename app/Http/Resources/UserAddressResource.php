<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserAddressResource extends JsonResource
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
            'date' => $this->date,
            'registration_date' => $this->registration_date,
            'description' => $this->description,
            'image' => url($this->image),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            
        ];
    }
}
