<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\admin\CategoryModel;
use App\Models\admin\OfferModel;
use App\traits\ResonseTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Helpers\GeneralHelper;
use App\Models\admin\DriverModel;
use App\Models\DriverReview;
use App\Models\Wallet;
use App\WalletHistory;
use DB;

class HomeController extends Controller
{
    use ResonseTrait;
    public  function getAdminOffers(Request $request)
    {
        try {
            $offers = OfferModel::where("category_id", null)->where("expireDate", ">", Carbon::now())->get();

            return $this->returnData($offers, "");
        } catch (\Throwable $e) {
            return response($e->getMessage());
        }
    }

    public function getCategories(Request $request)
    {
        try {
            $categories = CategoryModel::query()->where('active', 1)->get();
            return $this->returnData($categories, "");
        } catch (\Throwable $e) {
            return $this->returnException();
        }
    }
    public function getHomePageOffers(Request $request)
    {
        try {
            $offers = OfferModel::where('type', 'main')->where("expireDate", ">", Carbon::now())->get();

            return $this->returnData($offers, "");
        } catch (\Throwable $e) {
            return response($e->getMessage());
        }
    }
    public function getDriverById(Request $request)
    {
  
        if ($customer = GeneralHelper::currentCustomer($request->header('Authorization'))) {

            if (DriverModel::find($request->driver_id)) {

                $driver = DriverModel::select(
                    'drivers.fullname',
                    'drivers.phone',
                    'drivers.image',
                    'vehicles.vehicle_color',
                    'vehicles.plate_number',
                    'vehicles_markers.marker',
                    'vehicles_models.model',
                    \DB::raw('FORMAT((SUM(driver_reviews.rate) / COUNT(driver_reviews.rate)),2) AS rate')
                )
                    ->leftjoin('vehicles', 'vehicles.driver_id', 'drivers.id')
                    ->leftjoin('vehicles_markers', 'vehicles_markers.id', 'vehicles.marker_id')
                    ->leftjoin('vehicles_models', 'vehicles_models.id', 'vehicles.model_id')
                    ->leftjoin('driver_reviews', 'driver_reviews.driver_id', 'drivers.id')
                    ->where('drivers.id', $request->driver_id)
                    ->first();
                return $this->returnData($driver, "Fetch Driver Data successfully");
            } else {
                return $this->returnError('لا يوجد سائق بهذا ال ID');
            }
        } else {
            return $this->returnError('unauthorized');
        }
    }
    public function getTransactionHistory(Request $request)
    {
        $customer = GeneralHelper::currentCustomer($request->header('Authorization'));
        if ($customer) {
            $wallet = Wallet::select('id')->where('customer_id',$customer->id)->first();
            $wallet_history = WalletHistory::select('id','value','user_type','type','created_at')->where('wallet_id',$wallet->id);
            
            switch ($request->filter) {
                case 1:
                    //---Today----

                    $wallet_history->whereDate("created_at", Carbon::today());
                    break;
                case 2:
                    //---This Week-----

                    $wallet_history->whereBetween(
                        'created_at',
                        [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]
                    );
                    break;

                case '3':

                    //---This Month-----
                    $wallet_history->whereMonth('created_at', Carbon::now()->month);

                    break;
            }

            $wallet_history = $wallet_history->orderBy('created_at', 'DESC')->get();
            return $this->returnData($wallet_history, 'تم الحصول على الداتا بنجاح ');
        } else {
            return $this->returnError("Unauthoried");
        }
    }
}
