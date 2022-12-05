<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Model;

class CategoryModel extends Model
{
   protected $table = "categories";
   protected $fillable = ["name_ar", "name_en", "icon", "icon_en", "active", "icon_dark", "icon_dark_er"];
   public function offer()
   {
      return $this->belongsTo("App/Models/admin/OfferModel");
   }

   public function scopeLocale($query)
   {
      return $query->select("id", "name_" . app()->getLocale() . " as name", "icon_" . app()->getLocale() . " as icon", "icon_dark_" . app()->getLocale() . " as icon");
   }
   protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
   
}
