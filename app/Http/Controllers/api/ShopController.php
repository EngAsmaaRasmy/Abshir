<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\shop\Product;
use App\Models\shop\ShopCategory;
use App\Models\shop\SizePrice;
use App\traits\ResonseTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShopController extends Controller
{
    use ResonseTrait;

    public function getShopCategories(Request $request)
    {
        try {
            if ($request->has('shop')) {
                $shopCategories = ShopCategory::where("shop", $request->shop)->where('active', 1)->select(['id', 'name_ar', "name_en"])->get();
                return $this->returnData($shopCategories, "");
            } else {
                return $this->returnError("المحل المطلوب مش موجود");
            }
        } catch (\Throwable $e) {
            return $this->returnException();
        }
    }

    public function getProducts(Request $request)
    {
        try {


            if ($request->has('shop')) {
                $query = Product::where("shop", $request->shop)->where("category", $request->category)->where('active', 1)->with(array("shop" => function ($query) {
                        $query->select("id", "delivery_cost");
                    }));
                $products = array();
                $next_page_url = null;

                if ($request->has('version')) {
                    $products = $query->paginate(4);
                    $next_page_url = $products->toArray()['next_page_url'];
                } else {
                    $products = $query->get();
                }
                foreach ($products as $product) {
                    $sizes = SizePrice::where("product_id", $product->id)->with(["offer" => function ($query) {
                        $query->whereDate("expire_date", ">=", Carbon::today());
                    }])->get();
                    $product->sizes = $sizes;
                }
                if ($request->has('version'))
                    return $this->returnData([
                        "products" => $products->toArray()['data'],
                        "next_url" => $next_page_url
                    ], "");
                else
                    return $this->returnData($products);
            } else {
                return $this->returnError("المحل المطلوب مش موجود");
            }
        } catch (\Throwable $e) {
            return response($e->getMessage());
        }
    }





    public function search(Request  $request)
    {
        try {
            $products = Product::where("shop", $request->input('shop_id'))->where('active', 1)
                ->where("name_ar", "LIKE", "%" . $request->input('query') . "%")->orWhere("name_en", "LIKE", "%" . $request->input('query') . "%")->with(array("shop" => function ($query) {
                    $query->select("id", "delivery_cost");
                }))->get();
            foreach ($products as $product) {
                $sizes = SizePrice::where("product_id", $product->id)->with(["offer" => function ($query) {
                    $query->whereDate("expire_date", ">=", Carbon::today());
                }])->get();
                $product->sizes = $sizes;
            }

            return $this->returnData($products, "");
        } catch (\Throwable $e) {
            return response($e->getMessage());
        }
    }
}
