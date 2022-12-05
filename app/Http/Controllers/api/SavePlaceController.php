<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\SavePlaceRequest;
use App\traits\ResonseTrait;
use Illuminate\Http\Request;
use App\Helpers\GeneralHelper;
use App\Http\Resources\Customer\SavePlaces;
use App\Models\SavePlace;

class SavePlaceController extends Controller
{
    use ResonseTrait;
    public function getSavePlaces(Request $request)
    {
        $customer = GeneralHelper::currentCustomer($request->header('Authorization'));

        $savePlaces = SavePlace::where('customer_id',$customer->id)->get();
        return $this->returnData(SavePlaces::collection( $savePlaces),'تم الحصول على الاماكن المحفوظه');
    }
    public function savePlace(SavePlaceRequest $request)
    {
        try {
            
            $customer = GeneralHelper::currentCustomer($request->header('Authorization'));
            $savePlace = SavePlace::create($request->only('name','lat','lng')+['customer_id'=>$customer->id]);
            
            return $this->returnData($savePlace,"تم حفظ المكان بنجاح");
        } catch (\Throwable $e) {
            return $this->returnError($e->getMessage());
        }
       
    }
    public function unSavePlace(Request $request)
    {
        try {
            
           
            $savePlace = SavePlace::where('id',$request->id)->first();
            if($savePlace)
            {
                $savePlace->delete();
                return $this->returnSuccess('تم الغاء حفظ المكان');
            }else{
                return $this->returnError('لم يتم حفظ هذا المكان منن قبل!');
            }
            
        } catch (\Throwable $e) {
            return $this->returnError($e->getMessage());
        }
    }

}
