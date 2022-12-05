<?php

namespace App\Exports;

use App\Models\admin\CategoryModel;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use App\Models\Product;
use Illuminate\Support\Facades\Date;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\Exportable;

class CategoryExport  implements FromCollection, ShouldAutoSize, WithHeadings, WithMapping
{
      use Exportable;


    public function headings(): array
    {
        return [
            'الكود',
            ' إسم  القسم عربي ',
            ' إسم  القسم إنجليزى ',
    
            'تاريخ الإنشاء',
            'تاريخ أخر تعديل',
        ];
    }

     /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return CategoryModel::get();
    }



    /**
     * @var product $shop
     */
    public function map($shop): array
    {
        return [
            $shop->id,
            $shop->name_ar,
            $shop->name_en,
   
            $shop->created_at,
            $shop->updated_at,
        ];
    }
}
