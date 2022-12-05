<?php

namespace App\Http\Resources\Driver;

use Illuminate\Http\Resources\Json\JsonResource;

class RegisterDriverResource extends JsonResource
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
            'id'        => $this->id,
            'fullname'  => $this->fullname,
            'phone'     => $this->phone,
            'status'    => $this->status,
            'token' => $this->api_token,
            'fcm_token' => $this->fcm_token,
        ];
    }
}
