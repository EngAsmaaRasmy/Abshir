<?php

namespace App\Http\Controllers\api;

use App\Events\SpecialOrderEvent;
use App\Helpers\GeneralHelper;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\admin\AdminOrdersModel;
use App\Models\AppConfiguration;
use App\traits\FCMTrait;
use App\traits\IDs;
use App\traits\ImageTrait;
use App\traits\ResonseTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Throwable;


class SpecialOrderController extends Controller
{
    use ResonseTrait, ImageTrait, IDs,FCMTrait;

    public function makeSpecialOrder(Request $request)
    {
        try {

            $AppConfiguration = AppConfiguration::where('key', 'special_delivery_cost')->first();
            $order = AdminOrdersModel::query()->create($request->all());
            if ($request->file('file')) {
                $next_id = $this->getNextId('admin_orders');
                $url = $this->saveImage($request->file('file'), "orders", $next_id);
                $order->update(["image" => $url]);
            }
            $order->type = 'specialOrder';
            $order->delivery_cost = $AppConfiguration->value;
            $order->save();
            broadcast(new SpecialOrderEvent($order->load('customer')));
            $this->sendFcmToTopic("admin",
                "لديك طلب للادمن","راجع لوحة تحكم الادمن باقصى سرعة");
            return $this->returnData(['order_id' => $order->id], 'طلبك  قيد التنفيذ');
        } catch (Throwable $e) {
            return $this->returnError($e->getMessage());
        }
    }


    //--- get data ----

    public function getSpecialOrders(Request $request)
    {
        $customer = GeneralHelper::currentCustomer($request->header('Authorization'));
        if ($customer) {
            $orders = AdminOrdersModel::select( 
            'admin_orders.id as admin_order_id',
            'admin_orders.details',
            'admin_orders.image as order_image',
            'admin_orders.delivery_cost',
            'admin_orders.status',
            'admin_orders.customer_address',
            'admin_orders.created_at',
            'drivers.id as driver_id',
            'drivers.fullname',
            'drivers.phone',
            'drivers.image as driver_image'
            )
                ->leftjoin('drivers', 'drivers.id', 'admin_orders.driver_id')
                ->whereIn('admin_orders.status', [2,3,4])
                ->where('admin_orders.customer_id', $customer->id)
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
