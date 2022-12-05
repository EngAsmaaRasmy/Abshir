<?php

namespace App\Exports;

use App\Models\admin\DriverModel;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class DriverDayExport implements FromCollection, ShouldAutoSize, WithHeadings, WithMapping
{
    use Exportable;

    public function headings(): array
    {
        return [
            '#',
            'الاسم',
            'رقم الهاتف',
            'الحالة',
            'تاريخ الإنشاء',
            'تاريخ أخر تعديل',
        ];
    }

    public function collection()
    {
        return DriverModel::whereDate("created_at", Carbon::today())->get();
    }

    public function map($driver): array
    {
        $status = "";
        if ($driver->status == 4)
        {
            $status = 'بإنتظار الموافقة';
        } else if ($driver->status == '1' || $driver->status == '2' || $driver->status == '3') {
            $status = ' جاري التسجيل';
        } else if ($driver->status == '5') {
            $status = '  تمت الموافقة علي التسجيل';
        }
        return [
            $driver->id,
            $driver->fullname,
            $driver->phone,
            $status,
            $driver->created_at,
            $driver->updated_at,
        ];
    }
}
