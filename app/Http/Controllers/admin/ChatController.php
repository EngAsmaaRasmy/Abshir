<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\admin\DriverModel;
use App\Models\Customer;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function chat () {
        $id = NUll;
        return view('admin.chat.chat', compact('id'));

    } 
    public function chatRoom ($id) {
        return view('admin.chat.chat', compact('id'));
    } 
    //
    // public function driver() {
    //     return view('admin.chat.driver');

    // }

    
    // public function chat(Request $request)
    // {
    //     try {
    //         $clint = Customer::where('phone', $request->phone)->first();
    //         $driver = DriverModel::where('phone', $request->phone)->first();
    //         $user = [];
    //         if($request->type == 'user' && $clint) {
    //             $user = $clint;
    //             $user->phone = $clint->phone;
    //             $user->type = 'customer';
    //             return view('admin.chat.chat', compact('user'));

    //         } else if($request->type == 'driver' && $driver) {
    //             $user = $driver;
    //             $user->phone = $driver->phone;
    //             $user->type = 'customer';
    //             return view('admin.chat.chat', compact('user'));
    //         } else {
    //             return redirect()->back()->with(["error" => "لا يوجد مٌستخدم بهذا الرقم حاول مرة أخري"]);
    //         }

    //     } catch (\Throwable $e) {

    //         return redirect()->back()->with(["error" => "حدث خطأ ما برجاء المحاوله مره اخرى"]);
    //     }
     
    // }
}
