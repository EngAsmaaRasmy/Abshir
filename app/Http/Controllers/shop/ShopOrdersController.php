<?php

namespace App\Http\Controllers\shop;

use App\Http\Controllers\Controller;
use App\Models\admin\AdminOrdersModel;
use App\Models\admin\ShopModel;
use App\Models\OrderProduct;
use App\Models\shop\Order;
use App\traits\FCMTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShopOrdersController extends Controller
{
    use FCMTrait;
    public function index() {
        $appOrders=Order::ThisShop()->with(array("customerRel"=>function ($query){
            $query->select(["id","name"]);
        }))->new()->orderBy('updated_at','desc')->get();
        return response(["data"=>$appOrders]);
    }

    public function details($id, $type) {
        $orderProducts = OrderProduct::where('order',$id)->where('type', $type)->get();
        return view("shop.orders.details",compact("orderProducts"));
    }


    public function accept($id, $type){
     return  $this->take_action($id, $type, 2, "قبول","تم قبول طلبك","طلبك الان قيد التجهيز من المحل 🥳🥳");

    }
    public function reject($id, $type){
      return $this->take_action($id, $type, 6, "رفض","تم رفض طلبك "," تم رفض طلبك من المحل 😐😐");

    }

    public function take_action($id, $type, $status, $message, $title, $body)
    {
        try{
            if ($type == "app") {
                $appOrder= Order::find($id);
                if($appOrder){
                    $appOrder->status=$status;
                    $appOrder->save();
                    $customer_token=$appOrder->customerRel->fcm_token;
    
                    $this->sendToUser($customer_token,$title,$body);
                    return  redirect()->back()->with(['success'=>"تم".' '.$message." الطلب"]);
                } else{
                    return redirect()->back()->with(["error"=>"غير موجود"]);
                }
            } else {
                $adminOrder= AdminOrdersModel::find($id);
                if ($adminOrder) {
                    $adminOrder->status=$status;
    
                    $adminOrder->save();
                    return  redirect()->back()->with(['success'=>"تم".' '.$message." الطلب"]);
    
                } else{
                    return redirect()->back()->with(["error"=>"غير موجود"]);
                }
            }
           
        } catch (\Throwable $e){
            return redirect()->back()->with(["error"=>"حدث خطأ ما برجاء المحاوله مرة اخرى"]);
        }
    }
}
