<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Model;
use App\Models\admin\CategoryModel;
class OfferModel extends Model
{


    protected $table='offers';
    protected $fillable=["expireDate",'category_id','active',"image", "type", "created_at","updated_at"];
    public function category(){

       return $this->hasOne(CategoryModel::class,'id',"category_id");
    }
    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
