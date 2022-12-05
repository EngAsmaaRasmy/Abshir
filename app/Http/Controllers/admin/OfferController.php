<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\OfferRequest;

use App\Models\admin\OfferModel;

use App\traits\ImageTrait;

use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;


class OfferController extends Controller
{

    use ImageTrait;

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:عروض الصفحة الرئيسية', ['only' => ['getHomeOffers']]);
         $this->middleware('permission:إضافة عرض للصفحة الرئيسية', ['only' => ['getHomeOfferForm', 'addHomeOffer']]);
         $this->middleware('permission:عروض الشركات', ['only' => ['getCompanyOffers']]);
         $this->middleware('permission:إضافة عرض شركة', ['only' => ['getCompanyOfferForm', 'addCompanyOffer']]);
         $this->middleware('permission:عروض المحلات', ['only' => ['getShopOffers']]);
         $this->middleware('permission:إضافة عرض محل', ['only' => ['getShopOfferForm', 'addShopOffer']]);

    }

    public function getCompanyOfferForm()
    {
        return view("admin.offers.addCompanyOffer");
    }
    public function getShopOfferForm()
    {
        return view("admin.offers.addShopOffer");
    }
    public function getHomeOfferForm()
    {
        return view("admin.offers.addHomeOffer");
    }
    public function getCompanyOffers(){
        $offers= OfferModel::where("category_id",null)->where("type", null)->paginate(PAGINATION);
        return view("admin.offers.showCompanyOffers")->with(compact('offers'));
    }
    public function getHomeOffers(){
        $offers= OfferModel::where("type", "main")->paginate(PAGINATION);
        return view("admin.offers.showHomeOffers")->with(compact('offers'));
    }
    public function getShopOffers(){
        $offers= OfferModel::where("category_id","!=",null)->paginate(PAGINATION);
        return view("admin.offers.showShopOffers")->with(compact('offers'));
    }
    public function addCompanyOffer(OfferRequest $request){
      try{

          $expireDate=new Carbon();
           $expireDate->addDays($request->input('duration'));
          $imagePath= $this->saveImage($request->image,"offers/company",null);
          OfferModel::create(
              [
                  'expireDate'=>$expireDate,
                  "image"=>$imagePath
              ]
          );
         return redirect()->route('get.company.offers')->with(["success"=>"تم اضافه العرض بنجاح"]);
        } catch (Exception $e){
            return  redirect()->back()->with(["error"=>"حدث خطأ ما برجاء المحاولة مره اخرى"]);
          }

      }
      public function addHomeOffer(OfferRequest $request){
        try{
            $expireDate=new Carbon();
            $expireDate->addDays($request->input('duration'));
            $imagePath= $this->saveImage($request->image,"offers/home",null);
            OfferModel::create(
                [
                    'expireDate'=>$expireDate,
                    "image"=>$imagePath,
                    "type" => "main"
                ]
            );
           return redirect()->route('get.home.offers')->with(["success"=>"تم اضافه العرض بنجاح"]);
  
        }
      catch (Exception $e){
        return  redirect()->back()->with(["error"=>"حدث خطأ ما برجاء المحاولة مره اخرى"]);
      }
    }
    public function addShopOffer(Request $request){
        try{
           $valid= $this->validateRequest($request);
           if($valid->fails()){
               return redirect()->back()->with(["error"=>$valid->errors()->first()]);
           }
           else {
               $expireDate = new Carbon();
               $expireDate->addDays($request->input('duration'));
               $imagePath = $this->saveImage($request->image, "offers/shops", null);
               OfferModel::create(
                   [
                       'expireDate' => $expireDate,
                       "image" => $imagePath,
                       "category_id"=>$request->input("category")
                   ]
               );
               return redirect()->route('get.shop.offers')->with(["success" => "تم اضافه العرض بنجاح"]);
           }
        }
        catch (Exception $e){
            return  redirect()->back()->with(["error"=>"حدث خطأ ما برجاء المحاولة مره اخرى"]);
        }
    }
    public function delete($id){
        $offer=OfferModel::find($id);
        if($offer){
            $offer->delete();
            return redirect()->back()->with(['success'=>"تم حذف العرض بنجاح"]);
        }
        else{
            return  redirect()->back()->with(["error"=>"غير موجود"]);
        }
    }

    public function validateRequest(Request $request){
       return validator()->make($request->all(),[
            "category"=>"required",
            "duration"=>"required",
            "image"=>"required"
        ],[
            "required"=>"هذا الحقل مطلوب"
        ]);
    }


}
