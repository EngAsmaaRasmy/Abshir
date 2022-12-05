<?php

namespace App\Http\Requests\shop;

use Illuminate\Foundation\Http\FormRequest;
use phpDocumentor\Reflection\Types\Integer;

class SingleProductRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules= [
            "name_ar"=>"required",

            "description_ar"=>"required",
             "category"=>"required|exists:shops_categories,id",


        ];

          for ( $i=0;$i<(int)$this->request->get("sizesLength") ;$i++ ){
              $currentIndex=$i+1;
              $rules['size'.$currentIndex]="required";
              $rules['price'.$currentIndex]="required";
          }

        return $rules;
    }


    public function messages()
    {
     return [

         "unique"=>"هذا الاسم موجود بالفعل",
         "exist"=>"هذا القسم غير موجود",

     ];
    }
}
