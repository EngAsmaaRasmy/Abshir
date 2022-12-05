<?php

namespace App\Http\Controllers\api;

use App\Events\ReceiveOrderEvent;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\admin\ShopModel;
use App\Models\Coupon;
use App\Models\AppConfiguration;
use App\Models\CouponUser;
use App\Models\OrderProduct;
use App\Models\shop\Order;
use App\Models\shop\Product;
use App\Models\shop\SizePrice;
use App\traits\BusinessTimeTrait;
use App\traits\FCMTrait;
use App\traits\ResonseTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Throwable;

class CartController extends Controller
{
    use ResonseTrait, FCMTrait;
    use BusinessTimeTrait;

    protected $orderId = null;

    public function getProducts(Request $request)
    {
        try {
            $products = [];

            for ($i = 0; $i < count($request->input("ids")); $i++) {

                $id = $request->input("ids")[$i];
                $size = $request->input("sizes")[$i];
                $product = Product::where("id", $id)->with(array("shop" => function ($query) {
                    $query->select("id", "delivery_cost");
                }))->get()->first();
                $sizeModel = SizePrice::where("product_id", $product->id)->where("id", $size)->with("offer")->get();
                $product['sizes'] = $sizeModel;

                array_push($products, $product);
            }

            return $this->returnData($products, "");
        } catch (Throwable $e) {
            return $this->returnError($e->getMessage());
        }
    }


    public function verifyCoupon(Request $request)
    {

        try {
            if ($request->coupon) {
                $total_price = $request->input("total_price");
                $shop = $request->input("shop");

                $coupon = Coupon::where("name", $request->coupon)->where(function ($query) {
                        $query->where("max_count", null)->orWhere("max_count", "<", "current_count");
                    })->where(function ($query) {
                        $query->where("expire_date", null)->orWhere("expire_date", ">=", Carbon::today());
                    })->where(function ($query) use ($shop) {
                        $query->where("shop", null)->orWhere("shop", $shop);
                    })
                    ->get()->first();

                if ($coupon) {
                    if ($coupon->minimum_order < $total_price) {
                        $used = CouponUser::where("coupon", $coupon->id)->where("user", $request->user_id)->get()->first();
                        if ($used) {
                            return $this->returnError("استخدمت الكود ده قبل كده");
                        } else {

                            $type = $coupon->type;
                            $value = null;
                            if ($type == 1) {

                                $value = $coupon->value;
                            } else if ($type == 2) {


                                $value = ($coupon->percentage / 100) * $total_price;
                            }
                            return $this->returnData(["value" => $value], "الكوبون صالح");
                        }
                    } else {
                        return $this->returnError("المبلغ اقل من الحد الادنى للكوبون");
                    }
                } else {
                    return $this->returnError("الكوبون مش موجود او انتهت صلاحيته");
                }
            } else {
                return $this->returnError("الكوبون مش موجود");
            }
        } catch (Throwable $e) {
            $this->returnException();
        }
    }


    public function makeOrder(Request $request)
    {


        try {
            $validator = $this->validateOrderRequest($request);
            if ($validator->fails()) {
                return $this->returnError($validator->errors()->first());
            } else {


                $coupon = $request->coupon;
                $order_description = $request->order_description;
                $user_address = $request->user_address;
                $user_id = $request->user_id;
                $shop = $request->shop;
                $total_price = $request->total_price;
                $price_with_discount = $request->price_after_discount;
                $must_paid_price = $request->must_paid_price;
                $orderMap = $request->order;
                $AppConfiguration = AppConfiguration::where('key', 'delivery_cost')->first();

                // $isOpen = $this->getShopStatus($shopModel->open_at, $shopModel->close_at);
                // if ($isOpen) {



                foreach ($orderMap as $orderItem) {
                    $SizePrices[] = SizePrice::find($orderItem['product']['size'])->price;
                    $products_ids[] = Product::find($orderItem['product']['id'])->shop;
                    $product = Product::find($orderItem['product']['id']);
                }


                $additional_shops_count =  count(array_unique($products_ids)) - 1;

                $order = Order::create([
                    "shop" => $product->shop,
                    "customer" => $user_id,
                    "total_price" =>    array_sum($SizePrices) + (($additional_shops_count * $AppConfiguration->value) / 2) + $AppConfiguration->value,
                    "delivery_cost" => (($additional_shops_count * $AppConfiguration->value) / 2) + $AppConfiguration->value,
                    "price_after_discount" =>   array_sum($SizePrices) + (($additional_shops_count * $AppConfiguration->value) / 2) + $AppConfiguration->value,
                    "must_paid_price" => $must_paid_price,
                    "user_address" => json_encode($user_address),
                    "order_description" => $order_description
                ]);



                foreach ($orderMap as $orderItem) {

                    $product = Product::find($orderItem['product']['id']);
                    $shopModel = ShopModel::where("id", $product->shop)->first();
                    $SizePrice = SizePrice::find($orderItem['product']['size']);


                    $this->orderId = $order->id;

                    OrderProduct::create([
                        "order" => $order->id,
                        "product" => $orderItem['product']['id'],
                        "shop" => Product::find($orderItem['product']['id'])->shop,
                        "amount" => $orderItem['amount'],
                        "size_id" => $orderItem['product']['size'],
                        "type" => 'app'
                    ]);

                    $shop = ShopModel::find(Product::find($orderItem['product']['id'])->shop);

                    if ($shop) {
                        $this->sendToUser($shop->fcm_token, "لديك طلب جديد", 'لديك طلب جديد برجاء مراجعته فى اسرع وقت');
                    }


                    foreach (Admin::whereNotNull('fcm_token')->get() as $admin) {

                        $this->sendToUser($admin->fcm_token, "لديك طلب جديد", 'لديك طلب جديد برجاء مراجعته فى اسرع وقت');
                    }
                }



                $couponModel = Coupon::where("name", $coupon)->get()->first();
                if ($couponModel) {
                    $couponModel->increment("current_count");
                    CouponUser::create([
                        "coupon" => $couponModel->id,
                        "user" => $user_id
                    ]);
                }
                $order->load("customerRel");
                $order->load("shop");
                $orderProducts = $products = OrderProduct::query()->where('order', $order->id)->with('size')->with(['productRel' => function ($query) {
                    $query->with('categoryRel');
                }])->get();

                $order['products'] = $orderProducts;

                // broadcast(new ReceiveOrderEvent($order->toArray()));

                // $this->sendToUser($shopModel->fcm_token, "لديك طلب جديد", 'لديك طلب جديد برجاء مراجعته فى اسرع وقت');
                $this->sendFcmToTopic("admin", "لديك طلب جديد", 'لديك طلب جديد برجاء مراجعته فى اسرع وقت');
                return $this->returnData(["order_id" => $order->id], "تم الحقظ بنجاح");


                // } else {
                //     return $this->returnError("المحل مغلق");
                // }
            }
        } catch (Throwable $e) {
            // $order = Order::find($this->orderId);
            // $order->update(["status" => 7]);
            return $e;
            return $this->returnError($e->getMessage());
        }
    }
    protected function validateOrderRequest(Request $request)
    {
        return validator()->make($request->all(), [
            "shop" => "required|",
            "order" => "required",
            "total_price" => "required",
            "must_paid_price" => "required",
            "price_after_discount" => "required",
            "shipping_method" => "required",
            'user_address' => 'required_if:shipping_method,car,motorcycle'

        ], [
            "required" => "فى معلومات ناقصه فى الطلب",
            "exists" => "المحل ده مش موجود"
        ]);
    }
}
