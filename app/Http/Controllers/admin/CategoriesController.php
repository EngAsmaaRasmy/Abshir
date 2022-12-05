<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\CategoryRequest;
use App\Models\admin\CategoryModel;
use App\traits\ImageTrait;

use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    use ImageTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:عرض الاقسام', ['only' => ['show']]);
        $this->middleware('permission:إضافة قسم', ['only' => ['showAddForm', 'save']]);
        $this->middleware('permission:تعديل قسم', ['only' => ['edit', 'update']]);
        $this->middleware('permission:حذف قسم', ['only' => ['delete']]);
    }

    public function showAddForm()
    {
        return view("admin.categories.add");
    }

    public function save(CategoryRequest $request)
    {

        try {
            $category = CategoryModel::create([
                "name_ar" => $request->input("name-ar"),
                "name_en" => $request->input("name-en"),
                "icon" => "",
            ]);
            $path = $this->saveImage($request->file, "categories", $category->id);
            $en_path = $this->saveImage($request->file('file_en'), "categories", $category->id . "_en");

            $path_dark = $this->saveImage($request->file('dark'), "categories", $category->id. "dark");
            $en_path_dark = $this->saveImage($request->file('dark_en'), "categories", $category->id . "dark_en");
            $category->update([
                "icon" => $path,
                "icon_en" => $en_path,
                'icon_dark' => $path_dark,
                'icon_dark_en' => $en_path_dark,
            ]);

            return redirect()->route("category.show")->with(["success" => "تم اضافه القسم بنجاح"]);
        } catch (\Throwable $e) {

            return redirect()->route("get.add.category")->with(["error" => "حدث خطأ ما برجاء المحاوله مره اخرى"]);
        }
    }

    public function show()
    {
        $categories = CategoryModel::paginate(PAGINATION);
        return view("admin.categories.allCategories", compact("categories"));
    }


    public function delete($id)
    {
        try {
            $category = CategoryModel::find($id);
            if (!$category) {
                return redirect()->route("category.show")->with(["error" => "غير موجود"]);
            } else {
                $category->delete();
                $this->deleteImage($category->icon);
                return redirect()->route("category.show")->with(["success" => "تم حذف القسم بنجاح"]);
            }
        } catch (\Throwable $e) {
            return redirect()->route("category.show")->with(["error" => "حدث خطأ ما برجاء المحاوله مرة اخرى"]);
        }
    }

    public function edit($id)
    {
        $category = CategoryModel::find($id);
        if (!$category) {
            return redirect()->route("category.show")->with(["error" => "غير موجود"]);
        } else {

            return  view("admin.categories.edit", compact("category"));
        }
    }

    public function update(Request $request, $id)
    {
        try {

            $category = CategoryModel::find($id);
            if (!$category) {
                return redirect()->route("category.show")->with(["error" => "غير موجود"]);
            } else {
                $valid = $this->validateRequest($request, $category->name_ar != $request->input("name-ar"), $category->name_en != $request->input("name-en"));
                if ($valid->fails()) {
                    return  redirect()->route("category.edit", $category->id)->withErrors($valid->errors());
                } else {
                    $category->name_ar = $request->input('name-ar');
                    $category->name_en = $request->input('name-en');
                    $category->active = $request->input('active');
                    if ($request->file) {
                        $url = $this->saveImage($request->file, "categories", $request->id);
                        $category->icon = $url;
                    }
                    if ($request->file('file_en')) {
                        $url = $this->saveImage($request->file('file_en'), "categories", $category->id . "_en");
                        $category->icon_en = $url;
                    }
                    if ($request->file('dark')) {
                        $url = $this->saveImage($request->file('dark'), "categories", $category->id. "dark");
                        $category->icon_dark = $url;
                    }
                    if ($request->file('dark_en')) {
                        $url = $this->saveImage($request->file('dark_en'), "categories", $category->id. "dark_en");
                        $category->icon_dark_en = $url;
                    }
                    $category->save();
                    return redirect()->route("category.show")->with(["success" => "تم تعديل القسم بنجاح"]);
                }
            }
        } catch (\Throwable $e) {
            return redirect()->route("category.show")->with(["error" =>  "حدث خطأ ما برجاء المحاوله مرة اخرى"]);
        }
    }

    public  function validateRequest(Request $request, $name_ar_changed, $name_en_changed)
    {
        //      return [$name_ar_changed,$name_en_changed];
        return   $valid =   validator()->make($request->all(), [
            "name-ar" => $name_ar_changed == true ? "required|unique:categories,name_ar" : "required",
            "name-en" => $name_en_changed == true ? "required|unique:categories,name_en" : "required",
        ], [
            "required" => "هذا العنصر مطلوب"
        ]);
    }
}
