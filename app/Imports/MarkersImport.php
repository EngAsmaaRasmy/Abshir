<?php

namespace App\Imports;

use App\Models\VehiclesMarker;
use Carbon\Carbon;
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\SkipsErrors;

class MarkersImport implements ToModel, SkipsOnError
{
    use SkipsErrors;
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // dd($row[1]);
        return new VehiclesMarker([
            "marker" => $row[1],
            "created_at" => Carbon::now()->timestamp,
            "updated_at" => Carbon::now()->timestamp,
        ]);
    }
    public function onFailure(Failure ...$failures)
    {
        // Handle the failures how you'd like.
    }
}
