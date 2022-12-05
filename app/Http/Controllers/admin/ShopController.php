<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\CategoryRequest;
use App\Http\Requests\admin\ShopRequest;
use App\Imports\ShopsImport;
use App\Models\admin\CategoryModel;
use App\Models\admin\DriverModel;
use App\Models\admin\ShopModel;
use App\Models\Shop;
use App\traits\IDs;
use App\traits\ImageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class ShopController extends Controller
{
    use ImageTrait;
    use IDs;
    function __construct()
    {
         $this->middleware('permission:عرض المحلات|إضافة محل|تعديل محل|حذف محل', ['only' => ['index','show']]);
         $this->middleware('permission:إضافة محل', ['only' => ['showAddForm','save']]);
         $this->middleware('permission:تعديل محل', ['only' => ['edit', 'update']]);
         $this->middleware('permission:حذف محل', ['only' => ['delete']]);
    }
    public function import() 
    {
        try {
            Excel::import(new ShopsImport,request()->file('file'));  
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            foreach ($failures as $failure) {
                $failure->row(); // row that went wrong
                $failure->attribute(); // either heading key (if using heading row concern) or column index
                $failure->errors(); // Actual error messages from Laravel validator
                $failure->values(); // The values of the row that has failed.
            }
        }
        return redirect()->back();
    }
    
    public function showAddForm()
    {
        return view("admin.shops.add");
    }

    public function save(ShopRequest $request)
    {

        try {

            $lastId=$this->getNextId("shops");
            $shop = ShopModel::create([
                "name" => $request->input("name"),
                "username" => $request->input("username"),
                "password" => Hash::make($request->input("password")),
                "category"=>$request->category,
                "phone" => $request->input("phone"),
                "active" => $request->input("active"),
                "address" => $request->input("address"),
                "open_at"=>$request->open_at,
                "close_at"=>$request->close_at,
                
            ]);
            if($request->file('logo')) {
                
                $url =$this->saveImage($request->file('logo'),"shops/".$lastId,"logo");
                $shop->logo = $url;
                $shop->save();
            }
            return redirect()->route("shop.show")->with(["success" => "تم اضافه المحل بنجاح"]);

        } catch (\Throwable $e) {

            return redirect()->back()->with(["error" => $e->getMessage()]);
        }

    }

    public function show()
    {
        $shops = ShopModel::where("type", 'register_page')->orderby('created_at', 'DESC')->paginate(PAGINATION);
        return view("admin.shops.show", compact("shops"));
    }


    public function delete($id)
    {
        try {
            $shop = ShopModel::find($id);
            if (!$shop) {
                return redirect()->route("shop.show")->with(["error" => "غير موجود"]);
            } else {
                $shop->delete();
                return redirect()->route("shop.show")->with(["success" => "تم حذف المحل بنجاح"]);
            }
        } catch (\Throwable $e) {
            return redirect()->route("shop.show")->with(["error" => "حدث خطأ ما برجاء المحاوله مرة اخرى"]);
        }
    }
    public function edit($id)
    {
        $shop = ShopModel::find($id);
        if (!$shop) {
            return redirect()->route("shop.show")->with(["error" => "غير موجود"]);
        } else {

            return view("admin.shops.edit", compact("shop"));
        }
    }

    public function update(Request $request, $id)
    {
        try {

            $shop = ShopModel::find($id);
            if (!$shop) {
                return redirect()->route("shop.show")->with(["error" => "غير موجود"]);
            } else {
                $valid=$this->validateRequest($request,$shop->id, $shop->phone != $request->phone, $shop->username != $request->username);
                if ($valid->fails()) {
                    return redirect()->route("shop.edit", $id)->withErrors($valid->errors());
                }else {
                    $shop->name = $request->name;
                    $shop->username = $request->username;
                    $shop->phone = $request->phone;
                    if($request->password) {
                        $shop->password = Hash::make($request->password);
                    }
                    $shop->address = $request->address;
                    $shop->active = $request->active;
                    $shop->open_at=$request->open_at;
                    $shop->close_at=$request->close_at;
                    $shop->category=$request->category;
                    $shop->save();
                    return redirect()->route("shop.show")->with(["success" => "تم تعديل بيانات المحل بنجاح"]);
                }

            }
        } catch (\Throwable $e) {
            return redirect()->route("shop.show")->with(["error" => "حدث خطأ ما برجاء المحاوله مرة اخرى"]);
        }
    }

    public function validateRequest(Request $request, $id, $phoneChanged, $usernameChanged)
    {


        $phoneRule = $phoneChanged == true ? "required|unique:shops,phone|" : "required";
        $usernameRule = $usernameChanged == true ? "required|unique:shops,username" : "required";

        return  $valid = validator()->make(
            $request->all(), [
            "username" => $usernameRule,
            "name" => "required",

            "phone" => $phoneRule,
            "address" => "required",
            "active" => "required"

        ],
            [

                "required" => "هذا الحقل مطلوب",
                "unique" => "هذه البيانات مسجله بالفعل"
            ]
        );




    }
}
