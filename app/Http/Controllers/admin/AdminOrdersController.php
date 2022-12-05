<?php

namespace App\Http\Controllers\admin;

use App\Events\SpecialOrderEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\admin\AdminOrdersRequest;
use App\Http\Requests\admin\CategoryRequest;
use App\Models\Admin;
use App\Models\admin\AdminOrdersModel;
use App\Models\admin\CategoryModel;
use App\Models\admin\DriverModel;
use App\Models\admin\ShopModel;
use App\Models\AppConfiguration;
use App\Models\Coupon;
use App\Models\CouponUser;
use App\Models\OrderProduct;
use App\Models\shop\Order;
use App\Models\shop\Product;
use App\Models\shop\SizePrice;
use App\traits\ImageTrait;
use App\traits\FCMTrait;
use App\traits\ResonseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\Array_;

class AdminOrdersController extends Controller
{
    use FCMTrait;
    use ResonseTrait;


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:عرض الطلبات|إضافة طلب|عرض طلبات التطبيق', ['only' => ['index', 'show']]);
        $this->middleware('permission:إضافة طلب', ['only' => ['showAddForm', 'save']]);
        $this->middleware('permission:عرض طلبات التطبيق', ['only' => ['shopOrders']]);
    }

    public function showAddForm()
    {
        return view("admin.adminOrders.add");
    }

    //---------- store order data ---------
    public function save(AdminOrdersRequest $request)
    {
        // dd($request->all());
        try {
            $order = AdminOrdersModel::query()->create($request->all());
            $order->type = 'adminOrder';
            $order->save();
            broadcast(new SpecialOrderEvent($order->load('customer')));
            $this->sendFcmToTopic("admin",
                "لديك طلب للادمن","راجع لوحة تحكم الادمن باقصى سرعة");
            return redirect()->route("order.get")->with(["success" => "تم اضافه الطلب بنجاح"]);
        } catch(\Throwable  $e) {
            return $this->returnError($e->getMessage());
        }
        // try {
        //     $order = AdminOrdersModel::create([
        //         "details" => $request->input("details"),
        //         "delivery_cost" => $request->input("delivery_cost"),
        //         "driver_id" => $request->input("driver_id"),
        //         "customer_phone" => $request->input("customer_phone"),
        //         "must_paid" => $request->input("must_paid"),
        //         "category_id" => $request->input("category_id"),
        //         "customer_name" => $request->input("customer_name"),
        //         "customer_address" => $request->input("customer_address"),
        //         "shop" => $request->input("shop_id"),
        //         "total_price" => $request->input("total"),
        //         "status" => 1

        //     ]);
        //     $products = $request->input('product', []);
        //     $amounts = $request->input('amount', []);
        //     $sizes = $request->input('size', []);
        //     for ($product = 0; $product < count($products); $product++) {
        //         if ($products[$product] != '') {
        //             $order->products()->attach($products[$product], ['amount' => $amounts[$product], 'size_id' => $sizes[$product], 'shop' => $request->input("shop_id"), 'type' => 'admin']);
        //         }
        //         $shop = ShopModel::find(Product::find($products[$product])->shop);
        //         if ($shop) {
        //             $this->sendToUser($shop->fcm_token, "لديك طلب جديد", 'لديك طلب جديد برجاء مراجعته فى اسرع وقت');
        //         }
        //         foreach (Admin::whereNotNull('fcm_token')->get() as $admin) {
        //             $this->sendToUser($admin->fcm_token, "لديك طلب جديد", 'لديك طلب جديد برجاء مراجعته فى اسرع وقت');
        //         }
        //     }
        //     $order->load("customer");
        //     $order->load("adminShop");
        //     return redirect()->route("order.get")->with(["success" => "تم اضافه الطلب بنجاح"]);
        // } catch (\Throwable $e) {
        //     return redirect()->route("show.orders")->with(["error" => "حدث خطأ ما برجاء المحاوله مره اخرى"]);
        // }
    }

    //---------------- edit order data -------
    public function edit($id)
    {
        $order = AdminOrdersModel::query()->find($id);
        return view("admin.adminOrders.edit", compact('order'));
    }

    //---------- update order data ---------
    public function update(Request $request, $id)
    {
        // try {
        //     $order = AdminOrdersModel::find($id);
        //     if ($order) {
        //         $order->update([
        //             "details" => $request->input("details"),
        //             "delivery_cost" => $request->input("delivery_cost"),
        //             "driver_id" => $request->input("driver_id"),
        //             "customer_phone" => $request->input("customer_phone"),
        //             "must_paid" => $request->input("must_paid"),
        //             "category_id" => $request->input("category_id"),
        //             "customer_name" => $request->input("customer_name"),
        //             "customer_address" => $request->input("customer_address"),
        //             "shop" => $request->input("shop_id"),
        //             "total_price" => $request->input("total"),
        //             "status" => 1

        //         ]);
        //         $products = $request->input('product', []);
        //         $amounts = $request->input('amount', []);
        //         $sizes = $request->input('size', []);
        //         for ($product = 0; $product < count($products); $product++) {
        //             if ($products[$product] != '') {
        //                 $order->products()->attach($products[$product], ['amount' => $amounts[$product], 'size_id' => $sizes[$product], 'shop' => $request->input("shop_id"), 'type' => 'admin']);
        //             }
        //             $shop = ShopModel::find(Product::find($products[$product])->shop);
        //             if ($shop) {
        //                 $this->sendToUser($shop->fcm_token, "لديك طلب جديد", 'لديك طلب جديد برجاء مراجعته فى اسرع وقت');
        //             }
        //             foreach (Admin::whereNotNull('fcm_token')->get() as $admin) {
        //                 $this->sendToUser($admin->fcm_token, "لديك طلب جديد", 'لديك طلب جديد برجاء مراجعته فى اسرع وقت');
        //             }
        //         }
        //         $order->load("customer");
        //         $order->load("adminShop");
        //         return redirect()->back()->with(["success" => "تم تعديل الطلب بنجاح"]);
        //     }
        // } catch (\Throwable $e) {
        //     return redirect()->route("show.orders")->with(["error" => "حدث خطأ ما برجاء المحاوله مره اخرى"]);
        // }
    }

    //---------------- edit product data in order -------
    // public function editOrderProduct($orderId, $id)
    // {
    //     $order = AdminOrdersModel::query()->find($orderId);
    //     $orderProduct = OrderProduct::where('id', $id)->first();
    //     return view("admin.adminOrders.orderProduct", compact('orderProduct', 'order'));
    // }


    //---------------- update product data in order -------
    // public function updateOrderProduct(Request $request, $id)
    // {
    //     try {
    //         $valid = validator()->make($request->all(), [
    //             "product" => "required",
    //             "size_id" => "required",
    //             "amount" => "required"
    //         ], [
    //             "required" => "هذا العنصر مطلوب"
    //         ]);
    //         if ($valid->fails()) {
    //             return redirect()->back()->with(['error' => $valid->errors()->first()]);
    //         } else {
    //             $orderProduct = OrderProduct::find($id);
    //             if ($orderProduct) {
    //                 $orderProduct->update([
    //                     "product" => $request->product,
    //                     "size_id" => $request->size_id,
    //                     "amount" => $request->amount,
    //                 ]);
    //                 return redirect()->back()->with(['success' => "تم تعديل المٌنتج بنجاح"]);
    //             } else {
    //                 return redirect()->back()->with(['error' => "المٌنتج غير موجود"]);
    //             }
    //         }
    //     } catch (\Throwable $e) {
    //         return redirect()->back()->with(['error' => $e->getMessage()]);
    //     }
    // }

    //---------- delete product in order ---------
    // public function deleteOrderProduct($id)
    // {
    //     try {
    //         $orderProduct = OrderProduct::find($id);
    //         if ($orderProduct) {
    //             $orderProduct->delete();
    //             return redirect()->back()->with(['success' => "تم حذف هذا المنتج بنجاح"]);
    //         } else {
    //             return redirect()->back()->with(['error' => "المٌنتج غير موجود"]);
    //         }
    //     } catch (\Throwable $e) {
    //         return redirect()->back()->with(['error' => "حدث خطأ ما برجاء المحاولة مرة اخرى"]);
    //     }
    // }


    public function getDetails($id)
    {
        $order = AdminOrdersModel::query()->find($id);
        $order->with('customer');
        $order->update(['status' => 2]);
        return view('admin.adminOrders.details', compact('order'));
    }

    // public function fetchShops($id)
    // {
    //     $data['shops']    = ShopModel::where('category', $id)->get();
    //     return response()->json($data);
    // }

    // public function fetchProducts($id)
    // {
    //     $data['products']    = Product::where('shop', $id)->get();
    //     return response()->json($data);
    // }

    // public function fetchSizes($id)
    // {
    //     $data['sizes']    = SizePrice::where('product_id', $id)->get();
    //     return response()->json($data);
    // }

    // public function fetchPrice($id)
    // {
    //     $size   = SizePrice::where('id', $id)->first();
    //     $data['price'] = $size->price;
    //     return response()->json($data);
    // }



    public function getOrderDetails($id, $type)
    {
        $orderProducts = OrderProduct::where('order', $id)->where('type', $type)->get();
        return view("admin.adminOrders.shop-details", compact('orderProducts'));
    }

    public function show()
    {
        $orders = AdminOrdersModel::paginate(10);
        return view("admin.adminOrders.show", compact("orders"));
    }

    public function getShopOrders()
    {
        try {
            $appOrders = Order::with(array("customerRel" => function ($query) {
                $query->select(["id", "name"]);
            }))->new()->orderBy('updated_at', 'desc')->get();
            // $adminOrders = AdminOrdersModel::new()->where('type', '!=', 'specialOrder')->orderBy('updated_at', 'desc')->get();
            // $data = $adminOrders->concat($appOrders);
            return response(["data" => $appOrders]);
        } catch (\Throwable $e) {
            return $this->returnError($e->getMessage());
        }
    }

    public function shopOrders()
    {
        $orders = Order::query()->orderByDesc("created_at")->paginate(100);
        return view("admin.adminOrders.customer-orders", compact("orders"));
    }
}
