<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGeideaHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('geidea_histories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('geidea_account_id')->unsigned()->nullable();
            $table->foreign('geidea_account_id')->references('id')->on('geidea_accounts')->onDelete('SET NULL');
            $table->integer('trip_id')->unsigned()->nullable();
            $table->foreign('trip_id')->references('id')->on('trips')->onDelete('SET NULL');
            $table->double('value')->default(0);
            $table->enum('type',['Add','Minus'])->default('Add');
            $table->enum('user_type',['Admin','APP'])->default('APP');
            $table->integer('customer_id')->unsigned()->nullable();
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('SET NULL');
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
        Schema::dropIfExists('geidea_histories');
    }
}
