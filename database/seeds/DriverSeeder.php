<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DriverSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('drivers')->insert([
            'fullname' => "hady mohamed",
            'username' => 'hadyk_77',
            'password' => Hash::make('123456'),
            "address"=>"شارع الدلتا",
            "phone"=>"01212609680",
            "active"=>"1"
        ]);
    }
}
