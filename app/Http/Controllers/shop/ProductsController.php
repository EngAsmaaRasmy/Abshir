<?php

namespace App\Http\Controllers\shop;

use App\Http\Controllers\Controller;
use App\Http\Requests\shop\SingleProductRequest;
use App\Models\admin\CategoryModel;
use App\Models\shop\Product;
use App\Models\shop\ShopCategory;
use App\Models\shop\Size;
use App\Models\shop\SizePrice;
use App\traits\IDs;
use App\traits\ImageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Imports\ProductsImport;
use Maatwebsite\Excel\Facades\Excel;


class ProductsController extends Controller
{
    use ImageTrait;
    use IDs;

    public function index()
    {
        $products = Product::active()->GivenShop(Auth::id())->paginate(PAGINATION);

        return view("shop.products.allProducts", compact("products"));
    }

    public function getAddSingleForm()
    {
        $categories = ShopCategory::shop()->active()->get();

        return view("shop.products.addSingle", compact("categories"));
    }

    public function getAddMultiForm()
    {
        return view("shop.products.addMulti");
    }

    public function addSingleProduct(SingleProductRequest $request)
    {
        try {

            $nextId = $this->getNextId("products");
            $url = null;
            if ($request->file != null) {
                $url = $this->saveImage($request->file, "shops/products", $nextId);
            }
            $product = Product::create([
                "category" => $request->category,
                "name_ar" => $request->name_ar,
                "name_en" => $request->name_en,
                "description_ar" => $request->description_ar,
                "description_en" => $request->description_en,

                "shop" => Auth::id(),
                "image" => $url
            ]);
            for ($i = 0; $i < (int)$request->input("sizesLength"); $i++) {
                $currentIndex = $i + 1;
                SizePrice::create([
                    "product_id" => $product->id,
                    "name" => $request->input("size" . $currentIndex),
                    "price" => $request->input("price" . $currentIndex),

                ]);
            }

            return redirect()->back()->with(['success' => "تم اضافه المنتج بنجاح"]);
        } catch (\Throwable $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function delete($id)
    {
        $product = Product::find($id);
        if ($product) {
            if ($product->image) {
                $this->deleteImage($product->image);
            }
            $product->delete();
            SizePrice::where("product_id", $product->id)->delete();
            return redirect()->route('display.products')->with(['success' => "تم حذف المنتج بنجاح"]);
        } else {
            return redirect()->back()->with(["error" => "غير موجود"]);
        }
    }

    public function edit($id)
    {
        $product = Product::find($id);
        $categories = ShopCategory::active()->shop()->get();
        $sizes = SizePrice::where("product_id", $product->id)->get();
        if ($product) {
            return view("shop.products.edit", compact(['product', "categories", "sizes"]));
        } else {
            return redirect()->back()->with(['error' => "غير موجود"]);
        }
    }


    public function getEditSize($id)
    {
        $size = SizePrice::find($id);
        if ($size) {
            return view("shop.products.editSize", compact("size"));
        } else {
            return redirect()->back()->with(['error' => "الحجم غير موجود"]);
        }
    }

    public function deleteSize($id)
    {
        try {
            $size = SizePrice::find($id);
            if ($size) {
                $size->delete();
                return redirect()->back()->with(['success' => "تم حذف الحجم بنجاح"]);
            } else {
                return redirect()->back()->with(['error' => "الحجم غير موجود"]);
            }
        } catch (\Throwable $e) {
            return redirect()->back()->with(['error' => "حدث خطأ ما برجاء المحاولة مرة اخرى"]);
        }
    }


    public function updateSize(Request $request, $id)
    {
        try {
            $valid = validator()->make($request->all(), [
                "size_name" => "required",
                "price"
            ], [
                "required" => "هذا العنصر مطلوب"
            ]);
            if ($valid->fails()) {
                return redirect()->back()->with(['error' => $valid->errors()->first()]);
            } else {

                $size = SizePrice::find($id);
                if ($size) {
                    $size->update([
                        "name" => $request->input("size_name"),
                        "price" => $request->input('price')
                    ]);
                    return redirect()->back()->with(['success' => "تم تعديل الحجم بنجاح"]);
                } else {
                    return redirect()->back()->with(['error' => "الحجم غير موجود"]);
                }
            }
        } catch (\Throwable $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $product = Product::find($id);
            if ($product) {
                $validator = $this->validateRequest($request);
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator->errors());
                } else {
                    if ($request->file("file")) {
                        if ($product->image != null) {
                            $this->deleteImage($product->image);
                        }
                        $url = $this->saveImage($request->file('file'), "shops/products", $id);
                        $product->image = $url;
                    }

                    $product->name_ar = $request->name_ar;
                    $product->name_en = $request->name_en;
                    $product->description_ar = $request->description_ar;
                    $product->description_en = $request->description_en;

                    $product->category = $request->category;
                    $product->save();
                    for ($i = 0; $i < (int) $request->input("sizesLength"); $i++) {
                        $currentIndex = $i + 1;
                        if ($request->input("size" . $currentIndex) != null || $request->input("price" . $currentIndex) != null) {
                            SizePrice::create([
                                "product_id" => $product->id,
                                "name" => $request->input('size' . $currentIndex),
                                "price" => $request->input("price" . $currentIndex)
                            ]);
                        }
                    }
                    return redirect()->route("display.products")->with(["success" => "تم تعديل المنتج بنجاح"]);
                }
            } else {
                return redirect()->back()->with(["error" => "غير موجود"]);
            }
        } catch (\Throwable $e) {
            return redirect()->back()->with(["error" => $e->getMessage()]);
        }
    }


    public function validateRequest($request)
    {

        $rules = [
            "name_ar" => "required",
            "description_ar" => "required",
            "category" => "required|exists:shops_categories,id",

        ];

        return validator()->make($request->all(), $rules, [
            "required" => "بعض المعلومات المطلوبة غير مكتملة",
            "unique" => "هذا الاسم موجود بالفعل",
            "exist" => "هذا القسم غير موجود"
        ]);
    }


    public function getExportView()
    {

        $categories = ShopCategory::where("shop", Auth::id())->get();
        return view("shop.products.ExportView", compact("categories"));
    }
}
