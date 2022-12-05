<?php

use Illuminate\Support\Facades\Route;


Route::group(["middleware"=>"guest:shop",],function(){
    Route::post("/","ShopLoginController@ShopLogin")->name("shop.login");
    Route::get("/","ShopLoginController@showLoginForm")->name("get.shop.login");
    Route::post("/forget-password","ShopLoginController@forgetPassword")->name("forgetPassword");
    Route::post("/check-phone","ShopLoginController@checkPhone")->name("checkPhone");


});

Route::group(["middleware"=>"auth:shop"],function (){


    Route::get("/edit-profile","ShopLoginController@getEditForm")->name("get.shop.edit.profile");
    Route::post("/logout","ShopLoginController@logout")->name("shop.logout");
    Route::post("/edit-profile","ShopLoginController@update")->name("shop.profile.edit");



    Route::get("/home","HomeController@index")->name("shop.home");
    Route::get("/orders/selfDelivered/{duration}","HomeController@getSelfDeliveryOrders");
    Route::group(["prefix"=>"/products"],function (){
    Route::get("/","ProductsController@index")->name('display.products');

    });
    Route::group(["prefix"=>"/categories"],function (){
        Route::get("/index","CategoriesController@index")->name('display.categories');
        Route::get("/add","CategoriesController@showAddForm")->name('display.categories.add.form');
        Route::post("/add","CategoriesController@save")->name("shop.category.save");
        Route::get("/edit/{id}","CategoriesController@getEditForm")->name("display.categories.edit.form");
        Route::post("/edit/{id}","CategoriesController@update")->name("shop.category.update");
        Route::get("/delete/{id}","CategoriesController@delete")->name("shop.category.delete");
    });


    Route::group(["prefix"=>"products"],function (){

        Route::get("/index","ProductsController@index")->name("display.products");
        Route::get("/addSingle","ProductsController@getAddSingleForm")->name("display.product.add.single.form");
        Route::get("/addMulti","ProductsController@getAddMultiForm")->name("display.product.add.multi.form");
        Route::get("/getExportView","ProductsController@getExportView")->name("product.export.view");
        Route::post("/addSingle","ProductsController@addSingleProduct")->name("add.single.product");
        Route::get("/delete/{id}","ProductsController@delete")->name("delete.product");
        Route::get("/edit/{id}","ProductsController@edit")->name("edit.product");
        Route::get("/editSize/{id}","ProductsController@getEditSize")->name("edit.size");
        Route::get("/deleteSize/{id}","ProductsController@deleteSize")->name("delete.size");
        Route::post("/edit/{id}","ProductsController@update")->name('update.product');
        Route::post("/editSize/{id}","ProductsController@updateSize")->name('update.size');
        Route::post("/addMulti","ExcelController@import")->name("import.excel");
        Route::post("/export","ExcelController@export")->name("export.products");
    });
    Route::group(["prefix"=>"orders"],function (){
        Route::get("/active","OrdersController@active")->name("get.active.orders");
        Route::get("/read/{id}","OrdersController@markOrderAsReady")->name("mark.order.asReady");
        Route::get("/sendToDrivers/{id}","OrdersController@sendOrderToDrivers")->name("send.order.ToDriver");
        Route::get("/all","OrdersController@getAllOrders")->name("get.all.orders");
        Route::get("/selfDelivery/{id}","OrdersController@selfDelivery")->name("self.delivery");

    });

    Route::group(["prefix"=>"offers"],function (){
      Route::get("/index","OffersController@index")->name("display.all.offers");
        Route::get("/edit/{id}","OffersController@edit")->name("edit.shop.offer");
        Route::get("/add/{id}","OffersController@add")->name("add.shop.offer");
        Route::post("/update/{id}","OffersController@update")->name("update.shop.offer");
        Route::post("/save/{id}","OffersController@save")->name("save.shop.offer");
        Route::get("/{productId}/{offerId}","OffersController@delete")->name("delete.shop.offer");


    });


    Route::group(['prefix'=>"orders"],function (){

        Route::get("/index","ShopOrdersController@index")->name("get.shop.orders");
        Route::get("/details/{id}/{type}","ShopOrdersController@details")->name('get.order.details');
        Route::get("/accept/{id}/{type}","ShopOrdersController@accept")->name('accept.order');
        Route::get("/reject/{id}/{type}","ShopOrdersController@reject")->name('reject.order');


    });

    Route::group(['prefix'=>"notifications"],function (){
        Route::get("/index","NotificationController@index");
        Route::get("/read/{id}","NotificationController@read");
        Route::get("/readAll","NotificationController@readAll");
        Route::get("/sendToAdmin","NotificationController@getAdminSendForm")->name("get.send.admin.form");
        Route::post("/adminSend","NotificationController@sendToAdmin")->name('send.admin.notification');
    });

});

