<?php

namespace App\Http\Controllers\admin;

use App\Events\ReceiveMessageEvent;
use App\Events\ReceiveOrderEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\admin\ShopNotificationRequest;
use App\Models\admin\Admin_notificationModel;
use App\Models\admin\ShopModel;
use App\Models\Shop;
use App\Models\shop\Order;
use App\Models\shop\ShopNotificationModel;
use Illuminate\Support\Facades\Auth;


class NotificationController extends Controller
{
//    public  function index(){
//        try {
//          $notifications=  Admin_notificationModel::orderBy('created_at','desc')->get();
//          return  response(["data"=>$notifications]);
//        }
//        catch (\Throwable $e){
//            return response(["error"=>"حدث خطأ ما برجاء المحاولة مره اخرى"]);
//        }
//        }


 public function getSendShopForm(){
     $shops=ShopModel::where('active',1)->get();
    return view("admin.fcm.sendShops",compact("shops"));
 }

   public function send(ShopNotificationRequest $request){

      try {
          $notification = ShopNotificationModel::create($request->all());
          broadcast(new ReceiveMessageEvent($notification));
          return redirect()->back()->with(['success'=>"تم ارسال الاشعار بنجاح"]);
      }
      catch (\Throwable $e){
          return redirect()->back()->with(['error'=>$e->getMessage()]);
      }
   }

   public function index(){
       try {
           $notifications=Admin_notificationModel::query()->with("customer")->orderByDesc("created_at")->get()->values();
          return  response(["status"=>true,"data"=>$notifications,"error"=>""]);
       }catch (\Throwable $e){
           return response(['status'=>false,"data"=>[],"error"=>$e->getMessage()]);
       }
   }

        public function read($id){
          $notification=Admin_notificationModel::find($id);
          if($notification){
              $notification->read=1;
              $notification->save();
          }
        }

    public function readAll(){
        try {
            Admin_notificationModel::where("read",0)->update(array("read"=>1));
        }
        catch (\Throwable $e){
            return redirect()->back()->with(['error'=>"حدث خطأ ما برجاء المحاولة مرة اخرى"]);
        }

    }
}
