<?php

namespace App\Http\Controllers\shop;

use App\Events\SendAdminNotificationEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\shop\sendNotificationToAdminRequest;
use App\Models\admin\Admin_notificationModel;
use App\Models\shop\ShopNotificationModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index(){
      try{
          $notifications=ShopNotificationModel::where("shop",Auth::id())->get();
          return response(['status'=>true,"data"=>$notifications]);
      }
      catch (\Throwable $e){
          return response(["status"=>false,"error"=>$e->getMessage()]);
      }

    }






    public function read($id){
        try {
            $notification = ShopNotificationModel::find($id);
            if ($notification) {
               $notification->read=1;
               $notification->save();
                 return 1;
            }else{
                return redirect()->back()->with(['error'=>"غير موجود"]);
            }
        }
        catch (\Throwable $e){
            return redirect()->back()->with(['error'=>"حدث خطأ ما برجاء المحاولة مرة اخرى"]);
        }

    }
    public function readAll(){
        try {
            ShopNotificationModel::where("shop",Auth::id())->where("read",0)->update(array("read"=>1));
        }
        catch (\Throwable $e){
            return redirect()->back()->with(['error'=>"حدث خطأ ما برجاء المحاولة مرة اخرى"]);
        }

    }


    public function sendToAdmin(sendNotificationToAdminRequest $request){

        try {
            $notification = Admin_notificationModel::create([
                "title" => $request->title,
                "content" => $request->input('content'),
                "name" => Auth::user()->name
            ]);
            broadcast(new SendAdminNotificationEvent($notification));
            return redirect()->back()->with(['success'=>"تم ارسال الرسالة بنجاح"]);
        }
        catch (\Throwable $e){
            return redirect()->back()->with(['error'=>$e->getMessage()]);
        }
        }

        public function getAdminSendForm(){
        return view("shop.notifications.sendAdmin");
        }
}
