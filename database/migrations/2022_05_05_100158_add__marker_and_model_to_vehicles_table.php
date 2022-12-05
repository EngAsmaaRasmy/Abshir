<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMarkerAndModelToVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vehicles', function (Blueprint $table) {
            $table->unsignedBigInteger('marker_id')->nullable()->after('vehicle_license_image');
            $table->foreign('marker_id')->references('id')->on('vehicles_markers')->onDelete('SET NULL'); 
            $table->unsignedBigInteger('model_id')->nullable()->after('vehicle_image');
            $table->foreign('model_id')->references('id')->on('vehicles_models')->onDelete('SET NULL'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vehicles', function (Blueprint $table) {
            //
        });
    }
}
