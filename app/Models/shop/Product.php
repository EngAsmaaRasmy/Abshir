<?php

namespace App\Models\shop;

use App\Models\admin\ShopModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class Product extends Model
{
    protected $table = "products";
    protected $fillable = ["category", "shop", "image", "name_ar", "name_en", "description_ar", "description_en", "active"];
    public function size()
    {
        return $this->belongsTo(SizePrice::class);
    }
    protected $appends = [
        "name",
        'description'
    ];

    public function getLogoAttribute($logo)
    {
        if (@getimagesize(url($logo))) {
            return $logo;
        }

        return 'app-assets/images/logo.png';
    }

    public function getNameAttribute()
    {
        if (app()->getLocale() == 'ar') {
            return $this->name_ar;
        }
        return $this->name_en ?? $this->name_ar;
    }
    public function getDescriptionAttribute()
    {
        if (app()->getLocale() == 'ar') {
            return $this->description_ar;
        }
        return $this->description_en ?? $this->description_ar;
    }


    public function shop()
    {
        return $this->hasOne(ShopModel::class, "id", "shop");
    }

    public function sizes()
    {
        return $this->hasMany(SizePrice::class, "product_id", "id");
    }

    public function categoryRel()
    {
        return $this->hasOne(ShopCategory::class, "id", "category");
    }

    public function scopeActive($query)
    {
        return $query->where("active", 1);
    }


    public function orderProduct()
    {
        return $this->belongsTo("App\Models\OrderProduct", "id", "product");
    }

    public function scopeGivenShop($query, $id)
    {

        return $query->where("shop", $id);
    }

    public function scopeSelectId($query)
    {
        return $query->select('id');
    }

    public function offer()
    {
        return $this->belongsTo(ProductOffer::class);
    }

    public function delete()
    {
        ProductOffer::query()->whereHas("size", function ($query) {
            $query->where('product_id', $this->getAttributeValue('id'));
        })->delete();
        $this->sizes()->delete();
        $this->orderProduct()->delete();
        $image_path = $this->getAttributeValue('image');
        if (File::exists($image_path)) {
            File::delete($image_path);
        }
        return parent::delete();
    }
    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
