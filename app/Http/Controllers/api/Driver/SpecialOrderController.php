<?php

namespace App\Http\Controllers\api\Driver;

use App\Helpers\GeneralHelper;
use App\Http\Controllers\Controller;
use App\Models\admin\AdminOrdersModel;
use App\traits\ResonseTrait;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SpecialOrderController extends Controller
{
    use ResonseTrait;

    public function acceptSpecialOrder(Request $request)
    {
        $driver = GeneralHelper::currentDriver($request->header('Authorization'));
        if ($driver) {
            $order = AdminOrdersModel::where('id', $request->order_id)->where('status', 1)->where('type', 'specialOrder')->first();
            if ($order) {
                $order->status = 2;
                $order->driver_id = $driver->id;
                $order->save();
                return $this->returnSuccess("لقد تم قبول الطلب بنجاح");
            } else {
                return $this->returnError("لا يمكنك قبول هذا الطلب رجاء التأكد مره اخرى");
            }
        } else {
            return $this->returnError("UnAuthorized");
        }
    }
    public function receiveSpecialOrder(Request $request)
    {
        $driver = GeneralHelper::currentDriver($request->header('Authorization'));
        if ($driver) {
            $order = AdminOrdersModel::where('id', $request->order_id)->where('status', 2)->first();
            if ($order) {
                $order->status = 3;
                $order->save();
                return $this->returnSuccess("لقد تم تجهيز الطلب بنجاح");
            } else {
                return $this->returnError("لا يمكنك تجهيز هذا الطلب رجاء التأكد مره اخرى");
            }
        } else {
            return $this->returnError("UnAuthorized");
        }
    }
    public function finishSpecialOrder(Request $request)
    {
        $driver = GeneralHelper::currentDriver($request->header('Authorization'));
        if ($driver) {
            $order = AdminOrdersModel::where('id', $request->order_id)->where('status', 3)->first();
            if ($order) {
                $order->status = 4;
                $order->save();
                return $this->returnSuccess("لقد تم تسليم الطلب بنجاح");
            } else {
                return $this->returnError("لا يمكنك تسليم هذا الطلب رجاء التأكد مره اخرى");
            }
        } else {
            return $this->returnError("UnAuthorized");
        }
    }


    //--- get data ----
    public function getAcceptSpecialOrders(Request $request)
    {
        $driver = GeneralHelper::currentDriver($request->header('Authorization'));
        if ($driver) {
            $orders = AdminOrdersModel::select('admin_orders.id', 'admin_orders.customer_address', 'admin_orders.status', 'admin_orders.type', 'admin_orders.created_at')
                ->where('admin_orders.driver_id', $driver->id)
                ->where('admin_orders.type', 'specialOrder')
                ->whereIn('admin_orders.status', [2, 3])
                ->get();

            return $this->returnData($orders, 'تم الحصول على الطلبات المقبولة بنجاح ');
        } else {
            return $this->returnError("UnAuthorized");
        }
    }

    public function getAcceptOrderSpecialDetails(Request $request)
    {
        $driver = GeneralHelper::currentDriver($request->header('Authorization'));
        if ($driver) {
            $orderDetails = AdminOrdersModel::select(
                'admin_orders.id as admin_order_id',
                'admin_orders.details',
                'admin_orders.image as order_image',
                'admin_orders.delivery_cost',
                'admin_orders.status',
                'admin_orders.customer_address',
                'admin_orders.created_at',
                'customers.id as customer_id',
                'customers.name',
                'customers.phone',
                'customers.image as customer_image'
            )
                ->leftjoin('customers', 'customers.id', 'admin_orders.customer_id')
                ->where('admin_orders.driver_id', $driver->id)
                ->whereIn('admin_orders.status', [2,3])
                ->where('admin_orders.type', 'specialOrder')
                ->where('admin_orders.id', $request->order_id)
                ->first();
            return $this->returnData($orderDetails, 'تم الحصول على تفاصيل الطلب  بنجاح ');
        } else {
            return $this->returnError("UnAuthorized");
        }
    }

    public function getFinishedSpecialOrders(Request $request)
    {
        $driver = GeneralHelper::currentDriver($request->header('Authorization'));
        if ($driver) {
            $orders = AdminOrdersModel::select('admin_orders.id', 'admin_orders.customer_address', 'admin_orders.type', 'admin_orders.created_at')
                ->where('admin_orders.driver_id', $driver->id)
                ->where('admin_orders.status', 4)
                ->where('admin_orders.type', 'specialOrder');
                

            switch ($request->filter) {
                case 1:
                    //---Today----

                    $orders->whereDate("admin_orders.created_at", Carbon::today());
                    break;
                case 2:
                    //---This Week-----

                    $orders->whereBetween('admin_orders.created_at', [Carbon::now()->subDays(7), Carbon::now()]);
                    break;

                case 3:

                    //---This Month-----
                    $orders->whereMonth('admin_orders.created_at', Carbon::now()->month);

                    break;
            }
            $orders =  $orders->get();
            return $this->returnData($orders, 'تم الحصول على الطلبات المنتهية بنجاح ');
        } else {
            return $this->returnError("UnAuthorized");
        }
    }
}
