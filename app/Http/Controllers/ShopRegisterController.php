<?php

namespace App\Http\Controllers;

use App\Http\Requests\admin\ShopRequest;
use App\Http\Requests\shop\ShopRegisterRequest;
use App\Models\admin\CategoryModel;
use App\Models\admin\ShopModel;
use App\traits\ImageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ShopRegisterController extends Controller
{
    use ImageTrait;
    public function create()
    {
        $categories = CategoryModel::select('id', 'name_ar')->get();
        return view('shopRegisteration', compact('categories'));
    }


    public function store(ShopRegisterRequest $request)
    {
        
        try {
            if($request->area == NULL || $request->lat == NULL || $request->long ==NULL) {
                return redirect()->back()->with(["error" => '   حدد موقعك علي الخريطة اولا']);
            }
            $shop = ShopModel::create([
                "name" => $request->input("name"),
                "password" => Hash::make($request->input("password")),
                "category" => $request->category,
                "phone" => $request->input("phone"),
                "address" => $request->input("address"),
                "latitude" => $request->input('lat'),
                "longitude" => $request->input('long'),
                "open_at" => $request->input('open_at'),
                "close_at" => $request->input('close_at'),
                "area" => $request->input('area'),
                'type' => 'register_page',
                "active" => 1,
            ]);
            if ($request->file('logo')) {
                $url = $this->saveImage($request->file('logo'), "shops/" . $shop->id, "logo");
                $shop->logo = $url;
                $shop->save();
            }
            return redirect()->back()->with(["success" => "تم اضافه المحل بنجاح"]);
        } catch (\Throwable $e) {
            return redirect()->back()->with(["error" => $e->getMessage()]);
        }
    }
}
