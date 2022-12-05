<?php

namespace App\Http\Controllers\shop;

use App\Exports\ProductsExport;
use App\Exports\CategoryExport;
use App\Exports\ShopExport;
use App\Http\Controllers\Controller;
use App\Imports\ProductsImport;
use App\Models\shop\ShopCategory;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExcelController extends Controller
{
    public function getImportView(){
        return view(
            "shop.products.addMulti"
        );
    }


    public function export(Request $request){
        $category=$request->input("category");
        return Excel::download(new ProductsExport($category), 'products.xlsx');
    }




    public function export_shops(Request $request){

        return Excel::download(new ShopExport(), 'shops.xlsx');
    }

    public function export_categories(Request $request){

        return Excel::download(new CategoryExport(), 'categories.xlsx');
    }



    public function import(Request $request)
    {


        $valid = $this->validateImportRequest($request);
        if ($valid->fails()) {

            return redirect()->back()->withErrors($valid->errors());
        } else {
            try {
                \Maatwebsite\Excel\Facades\Excel::import(new ProductsImport, $request->file("file"));
                $categories=ShopCategory::active()->shop()->get();
                return redirect()->route("display.products",compact('categories'))->with(['success' => "تم اضافه المنتجات بنجاح"]);
            } catch (\Throwable $e) {

                return redirect()->back()->with(["error" => $e->getMessage()]);

            }
        }
    }


    public function validateImportRequest($request)
    {
        return validator()->make($request->all(), [
            "file" => "required",
        ], [
            "required" => "برجاء اختيار ملف منتجات صالح"
        ]);
    }
}
