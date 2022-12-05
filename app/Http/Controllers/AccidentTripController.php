<?php

namespace App\Http\Controllers;

use App\Models\AccidentTrip;
use App\Models\Trip;
use App\traits\ResonseTrait;
use Illuminate\Http\Request;

class AccidentTripController extends Controller
{
    use ResonseTrait;
    public function makeAccident(Request $request)
    {
        $trip = Trip::where('id', $request->trip_id)->first();
        if ($trip) {
            $accidentTrip = AccidentTrip::where('trip_id', $trip->id)->first();
            if ($accidentTrip) {
                return $this->returnError("تم التبليغ عن الحادثه من قبل");
            } else {

                $accident = AccidentTrip::create([
                    'customer_id' => $trip->client_id,
                    'driver_id' => $trip->driver_id,
                    'trip_id' => $trip->id,
                    'lat' => $request->lat,
                    'long' => $request->long
                ]);
                return $this->returnData('', "تم التبليغ عن الحادثه بنجاح");
            }
        } else {
            return $this->returnError("لا يوجد هذه الرحله");
        }
    }
}
