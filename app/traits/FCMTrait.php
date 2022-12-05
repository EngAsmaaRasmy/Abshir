<?php


namespace App\traits;


use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use Kreait\Firebase\Messaging\CloudMessage;
use NotificationChannels\Fcm\FcmMessage;
use NotificationChannels\Fcm\Resources\Notification;

trait FCMTrait
{
    public function sendFcmToTopic($topic,$title,$body)
    {

        $url = 'https://fcm.googleapis.com/fcm/send';

        $response = Http::withHeaders([
            "authorization" => "key=" . "AAAAgjFu5dA:APA91bGRt1e2yhDARNgWSHt4cRK1bOhWFZEcCcrbAOMa_vpiafN4kSJACw_Du8Akof-zDuCMgWJFYk-leGyCG5NbGD_Ls-YcogNsvq0ye30xKnH1fc49vrM-isFCGc-GYodNdgJMdFZR",

        ])->withOptions(["verify"=>false])->post($url, [
            "notification" => [
                "title" => $title,
                "body" => $body,
                "sound"=>"default"
            ],
            "priority" => "high",

            "to" => "/topics/".$topic
        ]);

        return $response;
    }

    public function sendToUser($user_token,$title,$body)
    {
        $url = 'https://fcm.googleapis.com/fcm/send';


        $response = Http::withHeaders([
            "authorization" => "key=" . "AAAAgjFu5dA:APA91bGRt1e2yhDARNgWSHt4cRK1bOhWFZEcCcrbAOMa_vpiafN4kSJACw_Du8Akof-zDuCMgWJFYk-leGyCG5NbGD_Ls-YcogNsvq0ye30xKnH1fc49vrM-isFCGc-GYodNdgJMdFZR",
        ])->withOptions(["verify"=>false])->post($url, [
            "data" => [
                "title" => $title,
                "body" => $body,
                "sound"=>"default"
            ],
            "priority" => "high",

            "to" => $user_token
        ]);
        return $response;
    }

    public function sendToDriver($user_token,$title,$body, $tripId)
    {
        $url = 'https://fcm.googleapis.com/fcm/send';


        $response = Http::withHeaders([
            "authorization" => "key=" . "AAAAgjFu5dA:APA91bGRt1e2yhDARNgWSHt4cRK1bOhWFZEcCcrbAOMa_vpiafN4kSJACw_Du8Akof-zDuCMgWJFYk-leGyCG5NbGD_Ls-YcogNsvq0ye30xKnH1fc49vrM-isFCGc-GYodNdgJMdFZR",
        ])->withOptions(["verify"=>false])->post($url, [
            "data" => [
                "title" => $title,
                "body" => $body,
                "tripId" => $tripId,
                "sound"=>"default"
            ],
            "priority" => "high",

            "to" => $user_token
        ]);
        return $response;
    }

}
