<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\License;
use App\Models\DriverAddress;
use App\Models\Identity;
use App\Models\Vehicle;

class UserResource extends JsonResource
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
            'email' => $this->email,
            'active' => $this->active,
            // 'city_id' => (int)$this->city_id,
            'city_name' =>  $this->city_name,
            'transportation_name' => 'name',
            'transportation_id' => (int)$this->transportation_id,
            'total_earnings' => $this->total_earnings,
            'image' =>  $this->image ? url($this->image) : "https://i.imgur.com/V0Dmtwi.jpg",
            // 'documents' => url($this->documents),
            'driving_license' => url($this->driving_license),
            'delivery_status' =>  $this->delivery_status ? true : false,
            'lemozen_status' => $this->lemozen_status ? true : false,

            'address' => new UserAddressResource(DriverAddress::where('driver_id',$this->id)->first()), 
            'identity' => new IdentityResource(Identity::where('driver_id',$this->id)->first()),
            'license' =>  new LicenseResource(License::where('driver_id',$this->id)->first()),
            'vehicle' =>  new VehiclesResource(Vehicle::where('driver_id',$this->id)->first()),
            'wallet_balance' =>$this->wallet_balance,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            
        ];
    }
}
