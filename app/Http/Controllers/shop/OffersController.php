<?php

namespace App\Http\Controllers\shop;

use App\Http\Controllers\Controller;
use App\Http\Requests\shop\OfferRequest;
use App\Models\shop\Offer_type;
use App\Models\shop\Product;
use App\Models\shop\ProductOffer;
use App\Models\shop\SizePrice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OffersController extends Controller
{

    protected $error_response="برجاء اكمال المعلومات المطلوبة";
    public function index(){
        $products=Product::givenShop(Auth::id())->active()->paginate(PAGINATION);

        return view("shop.offers.allOffers",compact("products"));

    }

    public function edit($id){
        try {
            $offer = ProductOffer::find($id);

            if ($offer) {
                $offersType=Offer_type::all();
                return view("shop.offers.edit",compact("offer","offersType"));
            } else {
                return redirect()->back()->with(["error" => "غير موجود"]);
            }
        }catch (\Throwable $e){
            return redirect()->back()->with(['error'=>"حدث خطأ ما برجاء المحاولة مرة اخرى"]);
        }

    }

    public function add($id){

        try {
             $size = SizePrice::find($id);
            if ($size) {
                $types=Offer_type::all();
                return view("shop.offers.add", compact('size',"types"));
            } else {

                return redirect()->back()->with(['error'=>"غير موجود"]);
            }

        }catch (\Throwable $e){
               return  redirect()->back()->with(["error"=>"حدث خطأ ما برجاء المحاولة مره اخرى"]);
        }

        }


        public function update(Request $request,$id)
        {

            $validator=$this->validateErrors($request);
            if($validator->fails()){
             return  redirect()->back()->with(['error'=>$validator->errors()->first()]);
            }
            $offer = ProductOffer::find($id);
            if ($offer) {
                switch ($request->type) {
                    case 1 :
                           $valid= $this->validateEmpty([$request->percentage]);
                           if($valid)
                            $offer->percentage = $request->percentage;

                           else
                            return redirect()->back()->with(['error'=>$this->error_response]);
                           break;
                        case
                            2:
                      $valid= $this->validateEmpty([$request->amount,$request->gift_amount]);
                       if($valid) {
                           $offer->amount = $request->amount;
                           $offer->gift_amount = $request->gift_amount;
                       }else
                       return  redirect()->back()->with(['error'=>$this->error_response]);
                       break;

                    case 3:

                       $valid= $this->validateEmpty([$request->value]);
                       if($valid)
                        $offer->value=$request->value;
                       else
                           return redirect()->back()->with(["error"=>$this->error_response]);
                       break;
                }
                $offer->name=$request->name;
                $offer->type=$request->type;
                $offer->expire_date=$request->expire_date;
                $offer->save();
                return redirect()->route("display.all.offers")->with(['success'=>"تم تعديل العرض بنجاح"]);
            }else{
                return redirect()->back()->with(['error'=>"غير موجود"]);
            }
        }


        public function save(Request $request,$id){
        try {

            $validator=$this->validateErrors($request);
            if($validator->fails()){
                return  redirect()->back()->with(['error'=>$validator->errors()->first()]);
            }

           $offer_id= ProductOffer::create(array_merge($request->all(),["shop"=>Auth::id(),"product"=>$id,"size_id"=>$id]))->id;
        
            $size=SizePrice::find($id);
            $size->offer_id=$offer_id;
            $size->save();
            return redirect()->route("display.all.offers")->with(['success'=>"تم اضافة العرض بنجاح"]);
        }
        catch (\Throwable $e){
            return redirect()->back()->with(["error"=>$e->getMessage()]);
            }
        }


        public function delete($sizeId,$offerId){

           try{
               $offer=ProductOffer::find($offerId);
               $product=SizePrice::find($sizeId);
               if($offer&&$product){
                   $offer->delete();
                   $product->offer_id=null;


                   $product->save();
                   return redirect()->route("display.all.offers")->with(['success'=>"تم حذف العرض بنجاح"]);
               }else{
                   return  redirect()->back()->with(['error'=>"غير موجود"]);
               }
           }
           catch (\Throwable $e){

               return redirect()->back()->with(['error'=>$e->getMessage()]);
           }

        }


        public function validateEmpty($variable){
           foreach ($variable as $value){

                if(!$value){

                    return false;
                }else{
                    return  true;
                }
            }
        }


        public function validateErrors($request){
           return validator()->make($request->all(),
           [
               "name"=>"required",
               "type"=>"required|exists:offer_types,id|numeric",
               "expire_date"=>"required"
           ],
           [
               "name.required"=>"برجاء ادخال اسم العرض",
               "type.required"=>"برجاء اختيار نوع العرض",
               "expire_date.required"=>"برجاء اختيار يوم انتهاء العرض",
               "exists"=>"نوع العرض غير موجود",
           ]
           );


        }
}
