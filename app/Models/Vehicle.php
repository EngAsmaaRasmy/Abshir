<?php

namespace App\Models;

use App\Governorate;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $fillable = ['vehicle_name','driver_id','vehicle_type','vehicle_model','vehicle_year','plate_number','motion_vector','horse_power','vehicle_color','kilometer_count','vehicle_license_image','vehicle_license_image_back','marker_id','vehicle_image','model_id', 'governorate_id'];
    
    public function marker()
    {
        return $this->belongsTo(VehiclesMarker::class,  "marker_id");
    }

    public function governorate()
    {
        return $this->belongsTo(Governorate::class,  "governorate_id");
    }

    public function model()
    {
        return $this->belongsTo(VehiclesModel::class,  "model_id");
    }
    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
