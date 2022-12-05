<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admin_messages')->insert([
            'content' => "hi hi hi hi hi hihi hi hihi hi hihi hi hihi hi hihi hi hihi hi hihi hi hihi hi hihi hi hihi hi hi",
            'name' => 'هادى محمد',
            'read' => 0,

             "created_at"=>now(),
            "phone"=>"01212609680",

        ]);
    }
}
