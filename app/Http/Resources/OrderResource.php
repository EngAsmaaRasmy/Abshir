<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\OrderProduct;
use App\Models\shop\Product;
use App\Models\shop\Order;
use App\Models\shop\SizePrice;
use App\Models\admin\ShopModel;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $OrderProducts = OrderProduct::where('order', $this->id)
            ->get();
        // $shops_ids = Product::whereIn('id',$products_ids)->get()->pluck('shop') ;
        // $Shops = ShopModel::whereIn('id',$shops_ids)->get() ;
        

        $product_item_model = [];

        $index = 0;
                    $products_index = 0;

        foreach ($OrderProducts->groupBy('shop') as $shop_id => $OrderProducts)
        {
            $shop = ShopModel::find($shop_id);
            $product_item_model['shops'][$index]['id'] = $shop->id;
            $product_item_model['shops'][$index]['name'] = $shop->name;
            $product_item_model['shops'][$index]['username'] = $shop->username;
            $product_item_model['shops'][$index]['category'] = $shop->category;
            $product_item_model['shops'][$index]['logo'] = $shop->logo;
            $product_item_model['shops'][$index]['prepare_time'] = $shop->prepare_time;
            $product_item_model['shops'][$index]['phone'] = $shop->phone;
            $product_item_model['shops'][$index]['order_count'] = $shop->order_count;
            $product_item_model['shops'][$index]['total_earnings'] = $shop->total_earnings;
            $product_item_model['shops'][$index]['address'] = $shop->address;
            $product_item_model['shops'][$index]['open_at'] = $shop->open_at;
            $product_item_model['shops'][$index]['close_at'] = $shop->close_at;
            $product_item_model['shops'][$index]['rating'] = $shop->rating;
            $product_item_model['shops'][$index]['active'] = $shop->active;
            $product_item_model['shops'][$index]['created_at'] = $shop->created_at;
     

            $products_index = 0;

            foreach ($OrderProducts as $OrderProduct)
            {
                $product = Product::find($OrderProduct->product);
                $size = SizePrice::where('id',$OrderProduct->size_id)->first();

                $product_item_model['shops'][$index]['products'][$products_index] = $product;
                $product_item_model['shops'][$index]['products'][$products_index]['size'] = $size;
                $product_item_model['shops'][$index]['products'][$products_index]['amount'] = $OrderProduct->amount;
                
                $products_index++;
            }
            
            $index++;
        }

         return [
            'id' => $this->id,
            'has_driver' => $this->has_driver,
            'driverRel' => $this->driverRel,
            'delivery_cost' => $this->delivery_cost,
            'order_description' => $this->order_description,
            'status' => $this->status, 'must_paid_price' => $this->must_paid_price,
            'total_price' => $this->total_price,
            'price_after_discount' => $this->price_after_discount,
            'driver' => $this->driver,
            'customerRel' => $this->customerRel,
            'user_address' => json_decode($this->user_address) ,
            'products_items' => $product_item_model,

        'created_at' => $this->created_at, 'updated_at' => $this->updated_at,

        ];

    }
}

// foreach($OrderProducts as $OrderProduct ){
//  $product_item_model['shops']['products'] = Product::find($OrderProduct->product);
// }
//  $product_item_model['shop'][$index]['id'] = $shop->id;
//  $product_item_model['shop'][$index]['name'] = $shop->name;
// $product_item_model['shop'][$index]['username'] = $shop->username;
// $product_item_model['shop'][$index]['category'] = $shop->category;
// $product_item_model['shop'][$index]['logo'] = $shop->logo;
// $product_item_model['shop'][$index]['prepare_time'] = $shop->prepare_time;
// $product_item_model['shop'][$index]['phone'] = $shop->phone;
// $product_item_model['shop'][$index]['order_count'] = $shop->order_count;
// $product_item_model['shop'][$index]['total_earnings'] = $shop->total_earnings;
// $product_item_model['shop'][$index]['address'] = $shop->address;
// $product_item_model['shop'][$index]['open_at'] = $shop->open_at;
// $product_item_model['shop'][$index]['close_at'] = $shop->close_at;
// $product_item_model['shop'][$index]['rating'] = $shop->rating;
// $product_item_model['shop'][$index]['active'] = $shop->active;
// $product_item_model['shop'][$index]['created_at'] = $shop->created_at;
// $product_item_model['shop'][$index]['updated_at'] = $shop->updated_at;
// $product_item_model['shop'][$index]['products'] = $shop->updated_at;
// // $product_item_model['shops']['product'][] = 'product';

