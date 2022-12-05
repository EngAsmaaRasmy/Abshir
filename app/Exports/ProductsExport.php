<?php

namespace App\Exports;

use App\Models\shop\Product;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;

class ProductsExport implements FromQuery
{
    public $category_id;
    public function __construct(int $category_id)
    {
       $this->category_id=$category_id;
    }

    public function query()
    {
        return Product::query()->where("shop",Auth::id())
            ->where("category",$this->category_id)->select("category","shop","image","name_ar","name_en","description_ar","description_en","active");
    }
}
