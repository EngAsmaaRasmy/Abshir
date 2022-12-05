<?php

namespace App\Http\Controllers\api\shop;

use App\Events\NewOrderEvent;
use App\Http\Controllers\Controller;
use App\Models\admin\DriverModel;
use App\Models\admin\OfferModel;
use App\Models\admin\ShopModel;
use App\Models\OrderProduct;
use App\Models\shop\Order;
use App\traits\FCMTrait;
use App\traits\ResonseTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Throwable;

class OrderController extends Controller
{
    use ResonseTrait, FCMTrait;

    public function getNew(Request $request)
    {
         try {
            $query = Order::query();
            if ($request->input('id')) {
                $shop = ShopModel::query()->find($request->input('id'));

                $query = $query->where('shop', $shop->id);

            }
            $orders = $query->where('status', 1)
            
                ->with('customerRel',"shop","driverRel")->get()->sortByDesc('created_at');
 
            foreach ($orders as $order) {
                $products = OrderProduct::query()->where('order', $order->id)->with('size')->with(['product' => function ($query) {
                    $query->with('category');
                }])->get();
                $order['products'] = $products;
            }
            $offers = OfferModel::where("category_id", null)->where("expireDate", ">", Carbon::now())
                ->select('image')->get();

            return $this->returnData(['orders' => $orders->values(), 'offers' => $offers]);
        } catch (Throwable $e) {
            return $this->returnError($e->getMessage());
        }
    }


    public function getProcessingOrders(Request $request)
    {
        try {
             $query=Order::query();
            if($request->input('id')) {
                $shop = ShopModel::query()->find($request->input('id'));
               $query= $query->where('shop', $shop->id);
            }
            $orders = $query->where('status',"=", 2)->orWhere("status","=",3)
                ->orWhere('status',"=",4)
                ->with('customerRel',"shop","driverRel")->get()->sortByDesc('created_at');
            foreach ($orders as $order) {
                $products = OrderProduct::query()->where('order', $order->id)->with('size')->with(['product' => function ($query) {
                    $query->with('category');
                }])->get();
                $order['products'] = $products;
            }

            return $this->returnData(['orders' => $orders->values()]);
        } catch (Throwable $e) {
            return $this->returnError($e->getMessage());
        }
    }


    public function takeAction(Request $request)
    {
        try {
            $order = Order::query()->find($request->input('order_id'));
            $order->update([
                'status' => $request->input('action')
            ]);
            if ($request->input('action') == 4 && $request->input('delivery_type') == 1) {
                $driver = DriverModel::query()->where('shop', $order->shop)->first();

                if ($driver) {
                    $order->update([
                        'driver' => $driver->id,
                        "status" => 5
                    ]);
                    $this->updateShop($order->shop, $order->price_after_discount
                        ,$order->must_paid_price-$order->price_after_discount,true);
                } else {
                    return $this->returnError('محلك غير مسجل فى خدمة التوصيل برجاء التواصل مع الادارة');
                }
            } else if ($request->input('action') == 4 && $request->input('delivery_type') == 2) {
                $productsList = OrderProduct::where("order", $order->id)->get();
                $products = array();
                foreach ($productsList as $product) {
                    array_push($products, ["amount" => $product->amount, "name" => $product->getRelationValue("product")->name_ar]);
                }
                $orderMap = [
                    "orderId" => $order->id,
                    "customerName" => $order->customerRel->name,
                    "customerAddress" => $order->user_address,
                    "customerPhone" => $order->customerRel->phone,
                    "shopName" => $order->getRelationValue('shop')->name,
                    "shopAddress" => $order->getRelationValue('shop')->address,
                    "shopLogo" => $order->getRelationValue('shop')->logo,
                    "customerImage" => $order->customerRel->image,
                    "totalPrice" => $order->must_paid_price,
                    "products" => $products
                ];
                broadcast(new NewOrderEvent($orderMap));
                $this->updateShop($order->shop, $order->price_after_discount);
            }

            $order->refresh();
            $this->sendNotification($order->customerRel->fcm_token, $order->status);
            return $this->returnSuccess();
        } catch (Throwable $e) {
            return $this->returnError($e->getMessage() . $e->getLine());
        }
    }

    public function updateShop($id, $price,$delivery=null,$is_self=false)
    {
        $shop = ShopModel::query()->find($id);
        if($delivery&& $is_self) {
            $driver = DriverModel::query()->where('shop', $shop->id);
            $driver->increment("order_count", 1);
            $driver->increment('total_earnings', $delivery);
        }
        $shop->increment('order_count');
        $shop->increment('total_earnings', $price);
    }


    public function sendNotification($token, $status)
    {
        $title = '';
        $body = '';
        switch ($status) {
            case 2:
                $title = "تم قبول طلبك";
                $body = "طلبك الان قيد التجهيز من المحل 🥳🥳";
                break;
            case 3:
                $title = "تم تجهيز الطلب";
                $body = 'طلبك جاهز للتوصيل 🎁🎁';
                break;
            case 5:
                $title = "تم توصيل الطلب";
                $body = 'تم توصيل طلبك شاور دايما فى خدمتك ❤️';
                break;
            case 4 :
                $title = "فى الطريق";
                $body = 'طلبك فى الطريق اليك  🛵';
                break;
            case 6:
                $title = "تم رفض طلبك";
                $body = ' تم رفض طلبك من المحل 😐😐';
                break;
        }

        $this->sendToUser($token, $title, $body);

    }
}
