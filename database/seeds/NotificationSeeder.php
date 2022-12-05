<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admin_notifications')->insert([
            "title"=>"طلب انضمام",
            'content' => "برجاء قبول طلب الانضمام",
            'name' => 'هادى محمد',
            'read' => 0,

            "created_at"=>now(),


        ]);
    }
}
