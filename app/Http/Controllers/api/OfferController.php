<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\shop\ProductOffer;
use App\Models\shop\SizePrice;
use App\traits\ResonseTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OfferController extends Controller
{
    use ResonseTrait;
    public function index(Request $request)
    {
        try {
            $offers = ProductOffer::whereDate("expire_date", ">", Carbon::now())->with(["shop" => function ($query) {
            }, "size" => function ($qu) {

                $qu->with([
                    "product" => function ($query) {
                        $query->with(["shop" => function ($q) {
                            $q->select("id", "name", "logo", "delivery_cost");
                        }]);
                    },

                ]);
            }])->get();

            foreach ($offers as $offer) {
                $product_id = $offer->size->product_id;
                $sizes = SizePrice::where("product_id", $product_id)->with("offer")->get();
                $offer->size->product['sizes'] = $sizes;
            }
            return $this->returnData($offers, "");
        } catch (\Throwable $e) {
            return $this->returnError($e->getMessage());
        }
    }
}
