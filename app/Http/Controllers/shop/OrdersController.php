<?php

namespace App\Http\Controllers\shop;

use App\Events\NewOrderEvent;
use App\Http\Controllers\Controller;
use App\Models\admin\AdminOrdersModel;
use App\Models\admin\DriverModel;
use App\Models\OrderProduct;
use App\Models\shop\Order;
use App\Models\shop\OrderStatus;
use App\traits\FCMTrait;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;

class OrdersController extends Controller
{
    use FCMTrait;
    public function active()
    {
        $activeOrders = Order::active()->ThisShop()->orderBy("updated_at","desc")->paginate(PAGINATION);
        return view("shop.orders.getActive", compact("activeOrders"));
    }

    public function markOrderAsReady($id)
    {
        try {
            $order = Order::find($id);
            if ($order) {
                $order->status = 3;
                $order->save();
                return redirect()->back()->with(["success" => "تم تأكيد تجهيز الطلب"]);
            } else {

                return redirect()->back()->with(["error", "غير موجود"]);
            }
        } catch (\Throwable $e) {
            return redirect()->back()->with(["error" => "حدث خطأ ما برجاء المحاوله مره اخرى"]);
        }
    }


    public function sendOrderToDrivers($id)
    {
        try {
            $order = Order::where("id", $id)->with("shop")->get()->first();
            if ($order) {
                $status=OrderStatus::find(3);
                $order->status = 3;
                $order->save();
                $shop=Auth::user();
                $shop->increment("order_count",1);
                $shop->increment("total_earnings",$order->price_after_discount);

                $shop = $order->getRelationValue('shop');
                $productsList = OrderProduct::where("order", $order->id)->get();
                $products = array();
                foreach ($productsList as $product) {
                    array_push($products, ["amount" => $product->amount, "name" => $product->getRelationValue("productRel")->name_ar]);
                }

                $orderMap = [
                    "orderId"=>$order->id,
                    "customerName" => $order->customerRel->name,
                    "customerAddress" => $order->user_address,
                    "customerPhone"=>$order->customerRel->phone,
                    "shopName" => $shop->name,
                    "shopAddress" => $shop->address,
                    "shopLogo"=>$shop->logo,
                    "customerImage"=>$order->customerRel->image,
                    "totalPrice" => $order->must_paid_price,
                    "products" => $products
                ];




                broadcast(new NewOrderEvent($orderMap));
                $this->sendToUser($order->customerRel->fcm_token,'طلبك جاهز','تم تجهيز طلبيك' . "🎁🎁");
                return redirect()->back()->with(["success" => "تم تأكيد تجهيز الطلب"]);
            } else {

                return redirect()->back()->with(["error", "غير موجود"]);
            }
        } catch (\Throwable $e) {
            return redirect()->back()->with(["error" => $e->getMessage()]);
        }
    }

    public function selfDelivery($id){
        try {
          $order=Order::where('id',$id)->get()->first();
          if($order){
              $shopDriverId=DriverModel::query()->where("shop",Auth::id())->get()->first();
              if($shopDriverId){

                  $order->driver=$shopDriverId;
                  $order->status=5;
                  $order->driver=$shopDriverId->id;
                  $order->save();
                  $shop=Auth::user();
                  $shop->increment("order_count",1);
                  $shop->increment("total_earnings",$order->price_after_discount);
                  $shopDriverId->increment('order_count',1);
                  $shopDriverId->increment("total_earnings",$order->must_paid_price-$order->price_after_discount);
                  $shopDriverId->save();
                  $address=json_decode($order->user_address)->name;
                  $this->sendToUser($order->customerRel->fcm_token,"فى الطريق","طلبك فى الطريق اليك ". "🚀🚀");
                  return redirect()->route("get.order.details",$order->id);
              }
              else{
                  return redirect()->back()->with(['error'=>"محلك مش متاح فيه التوصيل عن طريقك ارجع للاداره "]);

              }
          }else{
              return redirect()->back()->with(['error'=>"الطلب مش موجود "]);

          }
        }
        catch (\Throwable $e){
            return redirect()->back()->with(['error'=>$e->getMessage()]);
        }
    }


    public function getAllOrders()
    {
        $orders = Order::thisShop()->paginate(PAGINATION);
        return view("shop.orders.getAll", compact("orders"));
    }

}
