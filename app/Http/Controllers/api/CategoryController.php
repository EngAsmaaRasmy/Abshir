<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\admin\CategoryModel;
use App\Models\admin\OfferModel;
use App\Models\admin\ShopModel;
use App\traits\BusinessTimeTrait;
use App\traits\ResonseTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Helpers\GeneralHelper;
use App\Http\Requests\shop\GetShopsByCategoriesRequest;
use App\Models\shop\Product;
use Stichoza\GoogleTranslate\GoogleTranslate;

class CategoryController extends Controller
{
    use ResonseTrait;
    use BusinessTimeTrait;
    public function getShops(GetShopsByCategoriesRequest $request)
    {
        try {
            $customer = GeneralHelper::currentCustomer($request->header('Authorization'));
            if ($customer) {
                if ($request->has('category')) {
                    // $area =  GoogleTranslate::trans($request->area, 'ar');

                    // if (mb_substr($area, 0, 1, 'utf8') === 'أ') {
                    //     $area= str_replace("أ", "", $area);
                    // }elseif(mb_substr($area, 0, 1, 'utf8') === 'ا')
                    // {
                    //     $area= str_replace("ا", "", $area);
                    // }
                    // if (mb_substr($area, -1,1, 'utf8')==='ة') {
                    //     $area= str_replace("ة", "", $area);
                    // }elseif(  mb_substr($area, -1,1, 'utf8')==='ي' )
                    // {
                    //     $area= str_replace("ي", "", $area);

                    // }elseif(  mb_substr($area, -1,1, 'utf8')==='ى' )
                    // {
                    //     $area= str_replace("ى", "", $area);
                    // } 

                    // $shops = ShopModel::where("category", $request->category)->where("active", 1)
                    // ->whereRaw('`address` like ?', ['%'.$area.'%'])->orderBy('name', "desc")->get();
                    $shops = ShopModel::where("category", $request->category)
                        ->where("active", 1)
                        ->where('area', $request->area)
                        ->has('product')
                        ->orderBy('name', "desc")
                        ->get();

                    foreach ($shops as $shop) {
                        $shop['status'] = $this->getShopStatus($shop->open_at, $shop->close_at);
                    }

                    return $this->returnData($shops, '');
                } else {
                    return $this->returnError("القسم المطلوب غير موجود");
                }
            } else {
                return $this->returnError("Unauthoried");
            }
        } catch (\Throwable $e) {
            return $this->returnError($e->getMessage());
        }
    }

    public function getOffers(Request $request)
    {
        try {
            if ($request->has('category')) {
                $offers = OfferModel::where("category_id", $request->category)->where("expireDate", ">", Carbon::now())->get();
                return $this->returnData($offers, "");
            } else {
                return $this->returnError("القسم المطلوب غير موجود");
            }
        } catch (\Throwable $e) {
            return $this->returnException();
        }
    }
}
