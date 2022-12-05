<?php

namespace App\Imports;

use App\Models\admin\ShopModel;
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\SkipsErrors;

class ShopsImport implements ToModel, SkipsOnError
{
    use SkipsErrors;

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new ShopModel([
            "id"=>$row[0],
            "fcm_token"=>$row[1],
            "name"=>$row[2],
            "username"=>$row[3],
            "category"=>$row[4],
            "logo"=>$row[5],
            "password"=>\Hash::make($row[6]),
            "delivery_cost"=>$row[7],
            "prepare_time"=>$row[8],
            "phone"=>$row[9],
            "order_count"=>$row[10],
            "address"=>$row[11],
            "open_at"=>$row[12],
            "close_at"=>$row[13],
            "rating"=>$row[14],
            "active"=>$row[15],
            "remember_token"=>$row[16],
            "created_at"=>$row[17],
            "updated_at"=>$row[18],
        ]);
    }

    public function onFailure(Failure ...$failures)
    {
        // Handle the failures how you'd like.
    }
}
