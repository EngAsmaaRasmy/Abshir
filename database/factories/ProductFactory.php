<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\shop\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
       "shop"=>1,
        "category"=>1,
        "name_ar"=>$faker->name,
        "description_ar"=>$faker->text(),
        "active"=>1
    ];
});
