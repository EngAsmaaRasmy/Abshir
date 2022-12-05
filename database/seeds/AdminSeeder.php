<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{

    public function run()
    {
        DB::table('admins')->insert([
            'name' => "hady mohamed",
            'email' => 'hadykamel3@gmail.com',
            'password' => Hash::make('123456'),
        ]);
    }
}
