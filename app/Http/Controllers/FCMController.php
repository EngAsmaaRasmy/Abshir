<?php

namespace App\Http\Controllers;

use App\traits\FCMTrait;
use Illuminate\Http\Request;


class FCMController extends Controller
{
    use FCMTrait;

    public  function getUsersForm()
    {
        return view('admin.fcm.sendusers');
    }

    public function getdriversForm()
    {
        return view('admin.fcm.senddrivers');
    }

    public function sendToTopic(Request $request)
    {
        try {
            $fcm = $this->sendFcmToTopic($request->input('topic'), $request->input('title'), $request->input('body'));
            if ($fcm->status() == 200) {
                return redirect()->back()->with(["success" => "تم ارسال الاشعار بنجاح"]);
            } else {
                return  redirect()->back()->with(["error" => "حدث خطا ما برجاء المحاوله مره اخرى"]);
            }
        } catch (\Throwable $e) {
            return response("حدث خطأ ما برجاء المحاولة مره اخرى");
        }
    }

    public function sendToSingleUser(Request $request)
    {

        try {
            $fcm = $this->sendToUser($request->input('token'));
            if ($fcm->status() == 200) {
                return redirect()->route("");
            }
        } catch (\Throwable $e) {
            return response("حدث خطأ ما برجاء المحاولة مره اخرى");
        }
    }


    public function index()
    {
        return response(csrf_token());
    }
}
