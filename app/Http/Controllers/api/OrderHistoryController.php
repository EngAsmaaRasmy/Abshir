<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\OrderProduct;
use App\Models\shop\Order;
use App\Models\shop\SizePrice;
use App\traits\ResonseTrait;
use Illuminate\Http\Request;
use App\Http\Resources\OrderResource;

class OrderHistoryController extends Controller
{
    use ResonseTrait;

    public function getCurrentOrderList(Request $request)
    {

        try {
            $user_id = request()->user() ? request()->user()->id : $request->user_id;
            $orderList = array();
            if ($request->status < 5) {

                $orders = Order::where("customer", $user_id)->where("status", "<", 5)
                    ->with(["shop" => function ($query) {
                        $query->select("id", "name", "logo");
                    },])->orderBy("updated_at", "desc")->get();
            } elseif ($request->status == 5) {
                $orders = Order::where("customer", $user_id)->where("status", 5)
                    ->with(["shop" => function ($query) {
                        $query->select("id", "name", "logo");
                    }])->orderBy("updated_at","desc")->get();
            } elseif ($request->status == 6) {
                $orders = Order::where("customer", $user_id)->where("status", 6)
                    ->with(["shop" => function ($query) {
                        $query->select("id", "name", "logo");
                    }])->orderBy("updated_at","desc")->get();
            } else if ($request->status == 7) {
                $orders = Order::where("customer", $user_id)->where("status", 7)
                    ->with(["shop" => function ($query) {
                        $query->select("id", "name", "logo");
                    }])->orderBy("updated_at", "desc")->get();
            }
            foreach ($orders as $order) {
                $orderProducts = OrderProduct::where("order", $order->id)->with(["productRel" => function ($query) {
                    $query->with(["shop" => function ($q) {
                        $q->select("id", "delivery_cost");
                    }]);
                },])->get();
                foreach ($orderProducts as $product) {
                    $size = SizePrice::find($product->size_id);
                    $rel = $product->getRelationValue("product");
                    $rel['sizes'] = array($size);
                }

                $order->setAttribute("order", $orderProducts);
            }


            return $this->returnData(OrderResource::collection($orders), "");
        } catch (\Throwable $e) {
            return $e;
            return $this->returnError($e->getMessage());
        }
    }
}
