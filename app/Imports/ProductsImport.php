<?php

namespace App\Imports;

use App\Models\shop\Product;
use Maatwebsite\Excel\Concerns\ToModel;

class ProductsImport implements ToModel
{

    public function model(array $row)
    {
        $product= Product::query()->create([
            "category"=>$row[0],
            "shop"=>$row[1],
            "image"=>$row[2],
            "name_ar"=>$row[3],
            "name_en"=>$row[4],
            "description_ar"=>$row[5],
            "description_en"=>$row[6],
            "active"=>$row[7]

        ]);
        $product->size()->create([
            "price"=>$row[8],
            "product_id"=>$product->getAttributeValue('id'),
            "name"=>"عادى"
        ]);

      return $product;
    }
}
