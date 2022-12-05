<?php

namespace App\Http\Controllers\api;

use App\Events\SendAdminNotificationEvent;
use App\Http\Controllers\Controller;
use App\Models\admin\Admin_notificationModel;
use App\Models\Customer;
use App\traits\ResonseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProblemsController extends Controller
{
    use ResonseTrait;
    public  function reportProblem(Request $request){
        try {
            $customer=Customer::find($request->user_id);
            $notification = Admin_notificationModel::create([
                "title" => $request->title,
                "content" => $request->input('content'),
                "customer_id" => $customer->id
            ]);
            broadcast(new SendAdminNotificationEvent($notification));
            return $this->returnSuccess("تم ارسال الرساله بنجاح");
        }
        catch (\Throwable $e){
            return $this->returnError($e->getMessage());
        }
    }
}
