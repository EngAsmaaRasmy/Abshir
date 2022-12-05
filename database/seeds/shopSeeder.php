<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ShopSeeder extends Seeder
{

    public function run()
    {
        DB::table('shops')->insert([
            'name' => "بوابه دمشق",
            'username' => '',
            'password' => Hash::make('123456'),
        ]);
    }
}
