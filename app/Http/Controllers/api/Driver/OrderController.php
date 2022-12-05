<?php

namespace App\Http\Controllers\api\Driver;

use App\Events\OrderAcceptedEvent;
use App\Http\Controllers\Controller;
use App\Models\admin\DriverModel;
use App\Models\shop\Order;
use App\traits\FCMTrait;
use App\traits\ResonseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\OrderProduct;
use Carbon\Carbon;
use App\Http\Resources\OrderResource;
use Throwable;

class OrderController extends Controller
{
    use ResonseTrait;
    use FCMTrait;
    public  function acceptOrder(Request $request){
        try {
            
            $orderId=$request->order_id;
            $token=$request->header('Authorization');
     
            if(Str::startsWith($token,"Bearer")){
                $token=Str::substr($token,7);
            }
 
              $driver=DriverModel::where("api_token",$token)->get()->first();



              $order=Order::where("id",$orderId)->where("driver",null)->get()->first();
            if($order){
                $order->update([
                    "driver"=>$driver->id,
                    "status"=>2
                ]);

            $driver->active_order=$order->id;

            $driver->save();
                $this->sendToUser($order->customerRel->fcm_token,"طلبك الان قيد التجهيز من المحل 🥳🥳","  تم قبول طلبك  ". "");
             broadcast(new OrderAcceptedEvent([
                 "orderId"=>$order->id,
                 "driverId"=>$request->user_id
             ]));
             return  $this->returnSuccesswithComma("تم قبول الطلب بنجاح");
            }else{
             return  $this->returnError("فى مندوب تانى قبل الطلب ده");
            }
        }
        catch (\Throwable $e){
            return $e;
            return $this->returnException();
        }
    }
    
    public function ready_to_deliver(Request $request){
     try{
          $orderId=$request->order_id;
          
            
            $token=$request->header('Authorization');
     
            if(Str::startsWith($token,"Bearer")){
                $token=Str::substr($token,7);
            }
 
              $driver=DriverModel::where("api_token",$token)->get()->first();
          
          
          
          if($orderId){
               $order=Order::where("id",$orderId)->get()->first();
               $order->update([
                   "status"=>3
               ]);


               $driver->update([
                   "order_count"=>$driver->order_count+1,
                   "total_earnings"=>$driver->total_earnings+5,
                   "active_order"=>null
               ]);
            $body = $this->sendToUser($order->customerRel->fcm_token,"تم تجهيز الطلب","طلبك جاهز للتوصيل 🎁🎁" );
            return $this->returnSuccess("تم تجهيز الطلب");
        }
          else{
              return $this->returnError("الطلب غير موجود");
          }
     }
     catch (\Throwable $e){
         return $this->returnError($e->getMessage());
     }
    }
    
    public function on_way(Request $request){
     try{
          $orderId=$request->order_id;
          
            
            $token=$request->header('Authorization');
     
            if(Str::startsWith($token,"Bearer")){
                $token=Str::substr($token,7);
            }
 
              $driver=DriverModel::where("api_token",$token)->get()->first();
          
          
          
          if($orderId){
               $order=Order::where("id",$orderId)->get()->first();
               $order->update([
                   "status"=>4
               ]);


               $driver->update([
                   "order_count"=>$driver->order_count+1,
                   "total_earnings"=>$driver->total_earnings+5,
                   "active_order"=>null
               ]);
            $body = $this->sendToUser($order->customerRel->fcm_token,"فى الطريق"," طلبك فى الطريق اليك  🛵 " );
                return $this->returnSuccess(" طلبك فى الطريق إليك ");
        }
          else{
              return $this->returnError("الطلب غير موجود");
          }
     }
     catch (\Throwable $e){
         return $this->returnError($e->getMessage());
     }
    }
    
    public function active_delivery_orders(Request $request)
    {
        try {
            
            $token=$request->header('Authorization');
     
            if(Str::startsWith($token,"Bearer")){
                $token=Str::substr($token,7);
            }
 
              $driver=DriverModel::where("api_token",$token)->get()->first();

             $query=Order::query();

            $orders = $query->where([['status',"=", 2],['driver',$driver->id]])->orWhere([["status","=",3],['driver',$driver->id]])
                ->orWhere([['status',"=",4],['driver',$driver->id]])
                ->with('customerRel',"shop")->get()->sortByDesc('created_at');
            foreach ($orders as $order) {
                $products = OrderProduct::query()->where('order', $order->id)->with('size')->with(['product' => function ($query) {
                    $query->with('category');
                }])->get();
                $order['products'] = $products;
            }
              return $this->returnData(OrderResource::collection($orders), "");

            return $this->returnData(['orders' => $orders->values()]);
        } catch (Throwable $e) {
            return $this->returnError($e->getMessage());
        }
    }

    public function old_delivery_orders(Request $request)
    {
        try {
            
            $token=$request->header('Authorization');
     
            if(Str::startsWith($token,"Bearer")){
                $token=Str::substr($token,7);
            }
 
              $driver=DriverModel::where("api_token",$token)->get()->first();

             $query=Order::query();

            $orders = $query->where([['status',"=", 5],['driver',$driver->id]])
                ->with('customerRel',"shop")->get()->sortByDesc('created_at');
            foreach ($orders as $order) {
                $products = OrderProduct::query()->where('order', $order->id)->with('size')->with(['product' => function ($query) {
                    $query->with('category');
                }])->get();
                $order['products'] = $products;
            }
              return $this->returnData(OrderResource::collection($orders), "");

            return $this->returnData(['orders' => $orders->values()]);
        } catch (Throwable $e) {
            return $this->returnError($e->getMessage());
        }
    }
 

    public function avalible_delivery_orders(Request $request)
    {
        try {
            
            $token=$request->header('Authorization');
     
            if(Str::startsWith($token,"Bearer")){
                $token=Str::substr($token,7);
            }
 
                $driver=DriverModel::where("api_token",$token)->get()->first();

             $query=Order::query();

            $orders = $query->where('status',"=", 1)
                ->with('customerRel',"shop")->get()->sortByDesc('created_at');
            foreach ($orders as $order) {
                $products = OrderProduct::query()->where('order', $order->id)->with('size')->with(['product' => function ($query) {
                    $query->with('category');
                }])->get();
                $order['products'] = $products;
            }

               return $this->returnData(OrderResource::collection($orders), "");

            return $this->returnData(['orders' => $orders->values()]);
        } catch (Throwable $e) {
            return $this->returnError($e->getMessage());
        }
    }

    public function analtycs(Request $request){

          $orderId = $request->order_id;
          
            
            $token=$request->header('Authorization');
     
            if(Str::startsWith($token,"Bearer")){
                $token=Str::substr($token,7);
            }
 
            $driver=DriverModel::where("api_token",$token)->first();
          
          
            //**************** Orders Count ************************* 
            $orders_count =  Order::where("driver",$driver->id)->count();
            

            //**************** Mony From Customers ************************* 

            $mony_from_customers =  Order::where([["driver",$driver->id],['payment_method', 'cod'],['delivery_payment_status','waiting']])->pluck('price_after_discount')->toArray();
            
            $mony_from_customers =  array_sum($mony_from_customers);
           
           
           //**************** Required To Pay the Company ************************* 

            $company_pay_the_delivery = Order::where([["driver",$driver->id],['payment_method', 'cod'],['delivery_payment_status','waiting']])->count() * 5;
           
            $required_to_pay_the_company =  $mony_from_customers - $company_pay_the_delivery ;
            
            
           //**************** Required To Pay the Delivery ************************* 


            $mony_from_payments =  Order::where([["driver",$driver->id],['payment_method', 'cod'],['delivery_payment_status','waiting']])->pluck('price_after_discount')->toArray();
            $mony_from_payments =  array_sum($mony_from_payments);

            $company_pay_the_delivery = Order::where([["driver",$driver->id],['payment_method', 'stc'],['delivery_payment_status','waiting']])->count() * 5;
           
            $required_to_pay_the_delivery =  $mony_from_payments - $company_pay_the_delivery ;


           //******************************************************************* 
            
            return $this->returnData([
                'orders_count' => $orders_count ,
                'mony_from_customers' => $mony_from_customers ,
                'required_to_pay_the_company' => $required_to_pay_the_company,
                'required_to_pay_the_delivery' => $required_to_pay_the_delivery,
                ]);

 
    }
    public function analtycs_week_ago(Request $request){

          $orderId = $request->order_id;
          
            
            $token=$request->header('Authorization');
     
            if(Str::startsWith($token,"Bearer")){
                $token=Str::substr($token,7);
            }
 
            $driver=DriverModel::where("api_token",$token)->first();
          
          
            //**************** Orders Count ************************* 
            $orders_count =  Order::where("driver",$driver->id)->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
            

            //**************** Mony From Customers ************************* 

            $mony_from_customers =  Order::where([["driver",$driver->id],['payment_method', 'cod'],['delivery_payment_status','waiting']])
            ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->pluck('price_after_discount')->toArray();
            
            $mony_from_customers =  array_sum($mony_from_customers);
           
           
           //**************** Required To Pay the Company ************************* 

            $company_pay_the_delivery = Order::where([["driver",$driver->id],['payment_method', 'cod'],['delivery_payment_status','waiting']])->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count() * 5;
           
            $required_to_pay_the_company =  $mony_from_customers - $company_pay_the_delivery ;
            
            
           //**************** Required To Pay the Delivery ************************* 


            $mony_from_payments =  Order::where([["driver",$driver->id],['payment_method', 'stc'],['delivery_payment_status','waiting']])->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->pluck('price_after_discount')->toArray();
            $mony_from_payments =  array_sum($mony_from_payments);

            $company_pay_the_delivery = Order::where([["driver",$driver->id],['payment_method', 'stc'],['delivery_payment_status','waiting']])->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count() * 5;
           
            // $required_to_pay_the_delivery =  $mony_from_payments - $company_pay_the_delivery ;


           //******************************************************************* 
            
            return $this->returnData([
                'orders_count' => $orders_count ,
                'mony_from_customers' => $mony_from_customers ,
                'required_to_pay_the_company' => $required_to_pay_the_company,
                'required_to_pay_the_delivery' => (int)$company_pay_the_delivery,
                ]);

 
    }
    
    
    public function analtycs_1_months_ago(Request $request){

          $orderId = $request->order_id;
          
            
            $token=$request->header('Authorization');
     
            if(Str::startsWith($token,"Bearer")){
                $token=Str::substr($token,7);
            }
 
            $driver=DriverModel::where("api_token",$token)->first();
          
            $dateS = Carbon::now()->startOfMonth()->subMonth(1);
            $dateE = Carbon::now()->startOfMonth(); 

          
            //**************** Orders Count ************************* 
            $orders_count =  Order::where("driver",$driver->id)->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
            

            //**************** Mony From Customers ************************* 

            $mony_from_customers =  Order::where([["driver",$driver->id],['payment_method', 'cod'],['delivery_payment_status','waiting']])
            ->whereBetween('created_at', [$dateS, $dateE])->pluck('price_after_discount')->toArray();
            
            $mony_from_customers =  array_sum($mony_from_customers);
           
           
           //**************** Required To Pay the Company ************************* 

            $company_pay_the_delivery = Order::where([["driver",$driver->id],['payment_method', 'cod'],['delivery_payment_status','waiting']])->whereBetween('created_at', [$dateS, $dateE])->count() * 5;
           
            $required_to_pay_the_company =  $mony_from_customers - $company_pay_the_delivery ;
            
            
           //**************** Required To Pay the Delivery ************************* 


            $mony_from_payments =  Order::where([["driver",$driver->id],['payment_method', 'stc'],['delivery_payment_status','waiting']])->whereBetween('created_at', [$dateS, $dateE])->pluck('price_after_discount')->toArray();
            $mony_from_payments =  array_sum($mony_from_payments);

            $company_pay_the_delivery = Order::where([["driver",$driver->id],['payment_method', 'stc'],['delivery_payment_status','waiting']])->whereBetween('created_at', [$dateS, $dateE])->count() * 5;
           
            // $required_to_pay_the_delivery =  $mony_from_payments - $company_pay_the_delivery ;


           //******************************************************************* 
            
            return $this->returnData([
                'orders_count' => $orders_count ,
                'mony_from_customers' => $mony_from_customers ,
                'required_to_pay_the_company' => $required_to_pay_the_company,
                'required_to_pay_the_delivery' => (int)$company_pay_the_delivery,
                ]);

 
    }
    
    public function analtycs_3_months_ago(Request $request){

          $orderId = $request->order_id;
          
            
            $token=$request->header('Authorization');
     
            if(Str::startsWith($token,"Bearer")){
                $token=Str::substr($token,7);
            }
 
            $driver=DriverModel::where("api_token",$token)->first();
          
            $dateS = Carbon::now()->startOfMonth()->subMonth(3);
            $dateE = Carbon::now()->startOfMonth(); 

          
            //**************** Orders Count ************************* 
            $orders_count =  Order::where("driver",$driver->id)->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
            

            //**************** Mony From Customers ************************* 

            $mony_from_customers =  Order::where([["driver",$driver->id],['payment_method', 'cod'],['delivery_payment_status','waiting']])
            ->whereBetween('created_at', [$dateS, $dateE])->pluck('price_after_discount')->toArray();
            
            $mony_from_customers =  array_sum($mony_from_customers);
           
           
           //**************** Required To Pay the Company ************************* 

            $company_pay_the_delivery = Order::where([["driver",$driver->id],['payment_method', 'cod'],['delivery_payment_status','waiting']])->whereBetween('created_at', [$dateS, $dateE])->count() * 5;
           
            $required_to_pay_the_company =  $mony_from_customers - $company_pay_the_delivery ;
            
            
           //**************** Required To Pay the Delivery ************************* 


            $mony_from_payments =  Order::where([["driver",$driver->id],['payment_method', 'stc'],['delivery_payment_status','waiting']])->whereBetween('created_at', [$dateS, $dateE])->pluck('price_after_discount')->toArray();
            $mony_from_payments =  array_sum($mony_from_payments);

            $company_pay_the_delivery = Order::where([["driver",$driver->id],['payment_method', 'stc'],['delivery_payment_status','waiting']])->whereBetween('created_at', [$dateS, $dateE])->count() * 5;
           
            // $required_to_pay_the_delivery =  $mony_from_payments - $company_pay_the_delivery ;


           //******************************************************************* 
            
            return $this->returnData([
                'orders_count' => $orders_count ,
                'mony_from_customers' => $mony_from_customers ,
                'required_to_pay_the_company' => $required_to_pay_the_company,
                'required_to_pay_the_delivery' => (int)$company_pay_the_delivery,
                ]);

 
    }
    
    

    public function orderDelivered(Request $request){
     try{
          $orderId=$request->order_id;
          
            
            $token=$request->header('Authorization');
     
            if(Str::startsWith($token,"Bearer")){
                $token=Str::substr($token,7);
            }
 
              $driver=DriverModel::where("api_token",$token)->get()->first();
          
          
          
          if($orderId){
               $order=Order::where("id",$orderId)->get()->first();
               $order->update([
                   "status"=>5
               ]);


               $driver->update([
                   "order_count"=>$driver->order_count+1,
                   "total_earnings"=>$driver->total_earnings+5,
                   "active_order"=>null
               ]);
              $this->sendToUser($order->customerRel->fcm_token,"تم تسليم الطلب","تم تسليم الطلب بنجاح سعداء دايما بخدمتك". "👍✌");
               return $this->returnSuccess("تم تسليم الطلب");
        }
          else{
              return $this->returnError("الطلب غير موجود");
          }
     }
     catch (\Throwable $e){
         return $this->returnError($e->getMessage());
     }
    }
}
