<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\admin\AdminMessagesModel;
use App\Models\admin\AdminOrdersModel;
use App\Models\admin\DriverModel;
use App\Models\admin\ShopModel;
use App\Models\AppConfiguration;
use App\Models\OrderProduct;
use App\Models\shop\Order;
use App\traits\ResonseTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\Models\Activity;

class HomeController extends Controller
{
    use ResonseTrait;
    public  function index()
    {
        //     $todayOrders=Order::whereDate("updated_at",Carbon::today())->where("status","=","5")->get();
        //     $deliveryPrice=AppConfiguration::find(1);
        //     $totalDeliveryPrice=$deliveryPrice->value*$todayOrders->count();
        //     $topShop=DB::table('orders')->
        //     join("shops","orders.shop","=","shops.id")->
        //         select("name")->selectRaw("COUNT(*) AS count")
        //         ->groupBy("shop")->orderBy("count","DESC")->limit(1)->get()->first();
        //     $topDriver=DB::table('orders')->
        //     join("drivers","orders.driver","=","drivers.id")
        //         ->select("fullname")
        //         ->selectRaw("COUNT(*) AS count")
        //         ->groupBy("driver")
        //         ->orderBy("count","DESC")
        //         ->limit(1)->get()->first();
        //      $drivers=DB::table("orders")->whereDate("orders.updated_at","=",Carbon::today())
        //          ->join("drivers","orders.driver","=","drivers.id")
        //          ->select(["drivers.id","fullname","phone"])
        //          ->selectRaw("COUNT(*) AS count")->paginate(PAGINATION);
        $todayAppOrders = Order::whereDate("updated_at", Carbon::today())->where("status", 5)->get();
        $todayAppOrders = Order::whereDate("updated_at", Carbon::today())->where("status", 5)->get();
        $shops = ShopModel::where("type", 'register_page')->get();
        $todayAdminOrders = AdminOrdersModel::whereDate("updated_at", Carbon::today())->get();
        $delivery_cost = AppConfiguration::where("key", "delivery_cost")->get()->first();
        $todayProfit = $todayAppOrders->count() * $delivery_cost->value;
        foreach ($todayAdminOrders as $adminOrder) {
            $todayProfit += $adminOrder->must_paid;
        }

        $phoneRegisterToday = DriverModel::whereDate("created_at", Carbon::today())->where("status", '1')->count();
        $personalRegisterToday = DriverModel::whereDate("created_at", Carbon::today())->where("status", '2')->count();
        $vehicleRegisterToday = DriverModel::whereDate("created_at", Carbon::today())->where("status", '3')->count();
        $pendingToday = DriverModel::whereDate("created_at", Carbon::today())->where("status", '4')->count();

        $phoneRegister = DriverModel::where("status", '1')->count();
        $personalRegister = DriverModel::where("status", '2')->count();
        $vehicleRegister = DriverModel::where("status", '3')->count();
        $pending = DriverModel::where("status", '4')->count();

        return view("admin.home", compact("todayProfit", "todayAppOrders", 'shops',"todayAdminOrders"
        ,'phoneRegister', 'personalRegister', 'vehicleRegister', 'pending',
        'phoneRegisterToday', 'personalRegisterToday', 'vehicleRegisterToday', 'pendingToday'));
    }



    public function getToday($duration)
    {

        $date = Carbon::today();
        if ($duration == 2) {
            $date = $date->subWeek();
        } else if ($duration == 3) {
            $date = $date->subMonth();
        }
        $orders = Order::whereDate("updated_at", ">=", $date)->with(["customerRel" => function ($query) {
                $query->select("id", "name", "phone");
            }, "shop" => function ($query) {
                $query->select("id", "name");
            }, "driverRel" => function ($query) {
                $query->select("id", "fullname");
            },])->with('statusRel')->paginate(5);

        foreach ($orders as $order) {
            $products = OrderProduct::where("order", $order->id)->with(["size" => function ($query) {
                $query->select("id", "name", "price");
            }, "product" => function ($query) {
                $query->select("id", "name_ar");
            }])->get();
            $order['products'] = $products;
        }
        return $this->returnData($orders, "");
    }


    public function getAdminOrders($duration)
    {
        $date = Carbon::today();
        if ($duration == 2) {
            $date = $date->subWeek();
        } elseif ($duration == 3) {
            $date = $date->subMonth();
        }
        $orders = AdminOrdersModel::whereDate("updated_at", ">=", $date)->with(["driver" => function ($query) {
            $query->select("id", "fullname");
        }])->paginate(5);

        return $this->returnData($orders, "");
    }

    public function adminOrdersIndex()
    {
        try {
            $orders = AdminOrdersModel::with('customer')->get()->sortByDesc("created_at");
            return $this->returnData($orders->values());
        } catch (\Throwable $e) {
            return $this->returnError($e->getMessage());
        }
    }




    public function getDriversDetails($duration)
    {

        $date = Carbon::today();
        if ($duration == 2) {
            $date = $date->subWeek();
        } elseif ($duration == 3) {
            $date = $date->subMonth();
        }
        $drivers = DB::table("orders")->whereDate("orders.updated_at", ">=", $date)
            ->join("drivers", "orders.driver", "=", "drivers.id")
            ->select(["drivers.id", "fullname", "phone"])
            ->selectRaw("COUNT(*) AS count")->paginate(PAGINATION);

        return $this->returnData($drivers, "");
    }

    public function activity()
    {
        $date = Carbon::now()->subDays(3);
        $activities = Activity::where('created_at', '>=', $date)->orderBy('created_at')->paginate(PAGINATION);
        foreach($activities as $activity) {
            if ($activity->causer_type  == 'App\Models\Admin'){
                $user = Admin::find($activity->causer_id);
                $activity->name = $user->name;
            }
        }
        return view("admin.activity", compact("activities"));
    }

    public function searchActivities(Request $request)
    {
        $startDate = $request->input("start_date");
        $endDate = $request->input("end_date");
        $activities = Activity::query()
            ->whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            ->paginate(PAGINATION);

        foreach($activities as $activity) {
            if ($activity->causer_type  == 'App\Models\Admin'){
                $user = Admin::find($activity->causer_id);
                $activity->name = $user->name;
            }
        }
        return view("admin.activity", compact("activities"));
    }
}
