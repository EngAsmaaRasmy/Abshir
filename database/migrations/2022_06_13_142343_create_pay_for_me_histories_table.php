<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayForMeHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pay_for_me_histories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('contact_id');
            $table->integer('trip_id')->nullable();
            $table->enum('status',['Accepted','Rejected','Waiting'])->default('Waiting');
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
        Schema::dropIfExists('pay_for_me_histories');
    }
}
