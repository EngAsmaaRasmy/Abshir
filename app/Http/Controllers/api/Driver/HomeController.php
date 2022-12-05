<?php

namespace App\Http\Controllers\api\Driver;

use App\Http\Controllers\Controller;
use App\Http\Resources\DriverResource;
use App\Http\Resources\UserResource;
use App\Models\admin\AdminOrdersModel;
use App\Models\admin\DriverModel;
use App\Models\AppConfiguration;
use App\Models\shop\Order;
use App\traits\ResonseTrait;
use Carbon\Carbon;
use Carbon\Traits\Date;
use Illuminate\Http\Request;
use App\Helpers\GeneralHelper;

class HomeController extends Controller
{
    use ResonseTrait;
    public  function index(Request $request)
    {

        try {
            $duration = $request->query('duration');
            $date = null;
            switch ($duration) {

                case 2:
                    $date = Carbon::now()->subWeek();
                    break;
                case 3:
                    $date = Carbon::now()->subMonth();
                    break;
            }
            $appOrderCount = 0;
            $adminOrders = 0;
            if ($duration == 1) {
                $appOrderCount = Order::where("driver", $request->user_id)->whereDate("updated_at", ">=", Carbon::today())->get()->count();
                $adminOrders = AdminOrdersModel::where("driver_id", $request->user_id)->whereDate("updated_at", ">=", Carbon::today())->get();
            } else {
                $appOrderCount = Order::where("driver", $request->user_id)->whereDate("updated_at", ">=", Carbon::today())->whereDate("updated_at", ">=", $date)->get()->count();
                $adminOrders = AdminOrdersModel::where("driver_id", $request->user_id)->whereDate("updated_at", ">=", Carbon::today())->whereDate("updated_at", ">=", $date)->get();
            }
            $totalOrderCost = 0;
            $mustPaid = 0;
            foreach ($adminOrders as $adminOrder) {
                $totalOrderCost += $adminOrder->delivery_cost;
                $mustPaid += $adminOrder->must_paid;
            }

            $totalOrderCost += $appOrderCount * 8;
            $totalOrderCount = $appOrderCount + $adminOrders->count();
            $mustPaid += $appOrderCount * 3;
            return  $this->returnData([
                "orderCount" => $totalOrderCount,
                "totalEarning" => $totalOrderCost,
                "mustPaid" => $mustPaid
            ], "");
        } catch (\Throwable $e) {
            return $this->returnError($e->getMessage());
        }
    }

    public function getDriverById(Request $request )
    {
        if (GeneralHelper::currentDriver($request->header('Authorization'))) {
            $driver = DriverModel::select('drivers.fullname','drivers.phone','drivers.image','vehicles.vehicle_color','vehicles.plate_number','vehicles_markers.marker','vehicles_models.model')
            ->leftjoin('vehicles','vehicles.driver_id','drivers.id')
            ->leftjoin('vehicles_markers','vehicles_markers.id','vehicles.marker_id')
            ->leftjoin('vehicles_models','vehicles_models.id','vehicles.model_id')
            ->where('drivers.id',$request->driver_id)
            ->get();
            if($driver->isNotEmpty())
            {
                
                return $this->returnData($driver, "Fetch Driver Data successfully");
            }else{
                return $this->returnError('لا يوجد سائق بهذا ال ID');
            }
        } else {
            return $this->returnError('unauthorized');
        }
    }
}
