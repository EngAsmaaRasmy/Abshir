<?php

namespace App\Exports;

use App\Models\admin\ShopModel;
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

class ShopExport  implements FromCollection, ShouldAutoSize, WithHeadings, WithMapping
{
      use Exportable;


    public function headings(): array
    {
        return [
            '#',
            ' إسم المحل ',
            'إسم المستخدم',
            'إسم القسم بالكود',
             'وقت التحضير ',
            'رقم  الموبايل',
            'الباسورد',
            'وقت الفتح',
            'وقت الغلق',
   
            'تاريخ الإنشاء',
            'تاريخ أخر تعديل',
        ];
    }

     /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return ShopModel::get();
    }



    /**
     * @var product $shop
     */
    public function map($shop): array
    {
        return [
            $shop->id,
            $shop->name,
            $shop->username,
            $shop->category,
            $shop->prepare_time,
            $shop->phone,
            'password',
            $shop->open_at,
            $shop->close_at,
  
          
            $shop->created_at,
            $shop->updated_at,
        ];
    }
}
