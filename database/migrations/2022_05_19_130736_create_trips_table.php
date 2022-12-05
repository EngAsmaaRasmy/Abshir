<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTripsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trips', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('client_id')->nullable();
            $table->foreign('client_id')->references('id')->on('customers')->OnDelete('cascade');
            $table->unsignedBigInteger('driver_id')->nullable();
            $table->foreign('driver_id')->references('id')->on('drivers')->OnDelete('cascade');
            $table->unsignedBigInteger('price_list_id')->nullable();
            $table->foreign('price_list_id')->references('id')->on('price_lists')->OnDelete('cascade');
            $table->timestamp('trip_approve_time')->nullable();
            $table->timestamp('trip_arrive_time')->nullable();
            $table->timestamp('trip_start_time')->nullable();
            $table->timestamp('trip_end_time')->nullable();
            $table->string('start_lat')->nullable();
            $table->string('start_long')->nullable();
            $table->string('end_lat')->nullable();
            $table->string('end_long')->nullable();
            $table->string('trip_time')->nullable();
            $table->string('distance')->nullable();
            $table->string('cost')->nullable();
            $table->enum('status',['created','approved','arrived','started','finished','cancelled','cancelled_from_driver','ended'])->default('created');
            $table->string('cancellation_reason')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trips');
    }
}
