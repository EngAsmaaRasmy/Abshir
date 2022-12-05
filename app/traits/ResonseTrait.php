<?php


namespace App\traits;


use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;


trait ResonseTrait
{
   public function returnError($message){
       return response([
           "status"=>false,
           "error"=>$message,
           "message"=>"",
           'data'=>[]

       ]);
   }


   public function returnSuccess($message='تم بنجاح'){
       return response([
           "status"=>true,
           "error"=>"",
           "message"=>$message,
           'data'=>null
       ]);
   }
   public function returnSuccesswithComma($message='تم بنجاح'){
       return response([
           "status"=>true,
           "error"=>"",
           "message"=>$message,
           'data'=>""
       ]);
   }
    public function returnData($data,$message=""){
        return response([
            "status"=>true,
            "error"=>"",
            "message"=>$message,
            'data'=>$data
        ]);
    }

    public function returnException(){
       return response([
           "status"=>false,
           "error"=>"حصل مشكله لو سمحت حاول مره كمان ولو استمرت المشكله تواصل معانا",
           "message"=>"",
           "data"=>[]
       ]);
    }
}
