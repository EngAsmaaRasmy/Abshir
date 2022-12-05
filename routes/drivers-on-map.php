<?php

use Illuminate\Support\Facades\Route;

// Route::group(["middleware" => "guest:drivers-on-map"], function () {
//     Route::post("/", "admin\AdminLoginController@DriversOnMapLogin")->name("driversOnMap.login");
//     Route::get("/", "admin\AdminLoginController@showDriversOnMapLoginForm")->name("get.driversOnMap.login");
// });

// Route::group(["middleware"=>"auth:drivers-on-map"],function (){

//     Route::get("/home","admin\AdminLoginController@DriversOnMap")->name("DriversOnMap.home");
    
// });

// Route::group(["prefix" => "drivers-on-map", "middleware" => "auth:drivers-on-map"], function () {
//     Route::post("/", "admin\AdminLoginController@DriversOnMapLogin")->name("driversOnMap.login");
//     Route::get("/", "admin\AdminLoginController@showDriversOnMapLoginForm")->name("get.driversOnMap.login");
//     Route::get("/home","admin\AdminLoginController@DriversOnMap")->name("DriversOnMap.home");
// });