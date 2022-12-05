<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Kreait\Laravel\Firebase\Facades\Firebase;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use Kreait\Firebase\Database;


class FirebaseController extends Controller
{
    public static function connectionToFirebase()
    {
        
        // $factory = (new Factory)->withServiceAccount(__DIR__.'/laravel-firebase-fec.json');
        // $firestore = $factory->createFirestore();
        // $database = $firestore->database();
        // return $database;
        // $testRef = $database->collection('TestUser')->document(1);
        // $testRef->set([
        //     'FName' =>'alloooooo',
        //     'phone'=>'01222s2222'
        // ]);
        // dd($testRef);

    }
  
}
