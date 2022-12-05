<?php

namespace App\Http\Controllers\shop;

use App\Http\Controllers\Controller;
use App\Http\Requests\shop\CategoryRequest;

use App\Models\shop\ShopCategory;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoriesController extends Controller
{



    public function showAddForm()
    {
        return view("shop.categories.add");
    }

    public function save(CategoryRequest $request)
    {
        try {
            $id=ShopCategory::all()->count()+1;



            ShopCategory::create([
                "name_ar" => $request->input("name-ar"),
                "name_en" => $request->input("name-en"),
                "shop"=>Auth::id()
            ]);

            return redirect()->route("display.categories")->with(["success" => "تم اضافه القسم بنجاح"]);

        } catch (\Throwable $e) {

            return redirect()->route("display.categories.add.form")->with(["error" => "حدث خطأ ما برجاء المحاوله مره اخرى"]);
        }

    }

    public function index()
    {
        $categories = ShopCategory::where("shop",Auth::id())->paginate(PAGINATION);
        return view("shop.categories.allCategories", compact("categories"));
    }


    public function delete($id)
    {
        try {
            $category = ShopCategory::find($id);
            if (!$category) {
                return redirect()->route("display.categories")->with(["error" => "غير موجود"]);
            } else {
                $category->delete();
                return redirect()->route("display.categories")->with(["success" => "تم حذف القسم بنجاح"]);
            }
        } catch (\Throwable $e) {
            return redirect()->route("display.categories")->with(["error" => "حدث خطأ ما برجاء المحاوله مرة اخرى"]);
        }
    }

    public function getEditForm($id)
    {
        $category = ShopCategory::find($id);
        if (!$category) {
            return redirect()->route("display.categories")->with(["error" => "غير موجود"]);
        } else {

            return  view("shop.categories.edit",compact("category"));
        }
    }

    public function update(Request $request,$id)
    {
        try {

            $category = ShopCategory::find($id);
            if (!$category) {
                return redirect()->route("display.categories")->with(["error" => "غير موجود"]);
            } else {
                $valid=$this->validateRequest($request,$category->name_ar!=$request->input("name-ar"),$category->name_en!=$request->input("name-en"));
//                 return $valid;
                if($valid->fails()){
                    return  redirect()->route("display.categories.edit.form",$category->id)->withErrors($valid->errors());
            }else {
                    $category->name_ar = $request->input('name-ar');
                    $category->name_en = $request->input('name-en');

                    $category->save();
                    return redirect()->route("display.categories")->with(["success" => "تم تعديل القسم بنجاح"]);
                }
                }
        } catch (\Throwable $e) {
            return redirect()->route("display.categories")->with(["error" =>  "حدث خطأ ما برجاء المحاوله مرة اخرى"]);
        }
    }

  public  function validateRequest(Request $request,$name_ar_changed,$name_en_changed){
//      return [$name_ar_changed,$name_en_changed];
     return   $valid=   validator()->make($request->all(),[
            "name-ar"=>$name_ar_changed==true? "required|unique:shops_categories,name_ar":"required",

        ],[
            "required"=>"هذا العنصر مطلوب"
        ]);
  }


}
