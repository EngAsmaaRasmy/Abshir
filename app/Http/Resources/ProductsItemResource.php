<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\OrderProduct;
use App\Models\shop\Product;
use App\Models\shop\Order;
use App\Models\shop\SizePrice;
use App\Models\admin\ShopModel;

class ProductsItemResource extends JsonResource
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
            'amount' => $this->amount,
            'size' => [ 'name' => SizePrice::find($this->size_id)->name, 'price' => SizePrice::find($this->size_id)->price],
            
            'shop' => ShopModel::find(Product::find($this->product)->shop),
            'product' => Product::find($this->product),
 
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            
        ];
    }
}
