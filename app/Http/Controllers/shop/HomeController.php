<?php

namespace App\Http\Controllers\shop;

use App\Http\Controllers\Controller;
use App\Models\admin\AdminMessagesModel;
use App\Models\admin\DriverModel;
use App\Models\OrderProduct;
use App\Models\shop\Order;
use App\traits\ResonseTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    use ResonseTrait;
 public  function index(){

     $todayOrders=Order::where("shop",Auth::id())->whereDate("updated_at",Carbon::today())->where("status",">=",4)->get();

     $todayOrdersCount=$todayOrders->count();
     $todayOrdersTotalPrice=0;
     $mostOrdersProducts=DB::table("orders")->
     where("orders.shop",Auth::id())
         ->join("order_products","orders.id","=","order_products.order")
         ->join("products","order_products.product","=","products.id")
         ->groupBy("products.id")->limit(10)
         ->select("*")
         ->selectRaw('COUNT(*) AS count')
         ->get();


     foreach ($todayOrders as $order){
         $todayOrdersTotalPrice+=$order->total_price;
     }
     return view("shop.home",compact(["todayOrdersCount","todayOrdersTotalPrice","mostOrdersProducts"]));
 }


 public function getSelfDeliveryOrders($duration){
     try {

         $orders = null;
         $shopDriver=DriverModel::where("shop",Auth::id())->get()->first();
//         if($shopDriver){

                 $todayOrders = Order::
                     where("shop",Auth::id())->where("driver",$shopDriver->id)->
                 where("status",5)->whereDate("updated_at",Carbon::today())->with(["customerRel"=>function($q){
                         $q->select("id","name","phone");
                 }])->get();


                 $thisWeekOrders = Order::
                 where("shop",Auth::id())->where("driver",$shopDriver->id)->
                 where("status",5)->whereDate("updated_at",">=",Carbon::today()->subWeek())->with(["customerRel"=>function($q){
                     $q->select("id","name","phone");
                 }])->get();


                 $thisMonthOrders = Order::
                 where("shop",Auth::id())->where("driver",$shopDriver->id)->
                 where("status",5)->whereDate("updated_at",">=",Carbon::today()->subMonth())->with(["customerRel"=>function($q){
                     $q->select("id","name","phone");
                 }])->get();

//          }


        return $this->returnData(["todayOrders"=>$todayOrders,"weekOrders"=>$thisWeekOrders,"monthOrders"=>$thisMonthOrders],"");
     }
     catch (\Throwable $e){
         return $this->returnError($e->getMessage());
     }

 }



}
