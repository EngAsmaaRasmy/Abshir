<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\admin\AdminMessagesModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use mysql_xdevapi\Exception;

class MessageController extends Controller
{
    public function read( $id){

     $message=AdminMessagesModel::find($id);
     if($message){
         $message->read=1;
         $message->save();

     }
    }
    public function get( Request $request){
        try {
            $messages = AdminMessagesModel::orderBy("updated_at","desc")->get();

            return response(['data' => $messages]);
        }
        catch (Exception $e){
            return  response(["error"=>"حدث خطأ ما برجاء المحاولة مره اخرى"]);
         }
        }




}
