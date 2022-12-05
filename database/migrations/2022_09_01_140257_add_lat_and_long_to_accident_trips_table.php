<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLatAndLongToAccidentTripsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('accident_trips', function (Blueprint $table) {
            $table->string("lat")->nullable()->after('trip_id');
            $table->string("long")->nullable()->after('lat');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('accident_trips', function (Blueprint $table) {
            //
        });
    }
}
