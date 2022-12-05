<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->String("name")->unique();
            $table->integer('type');
            $table->double('value',20,2)->nullable();
            $table->double("percentage",20,2)->nullable();
            $table->double("minimum_order",20,1)->default(0);
            $table->integer('shop')->nullable();
            $table->date("expire_date");
            $table->integer("current_count")->default(0);
            $table->integer("max_count")->nullable();
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
        Schema::dropIfExists('coupons');
    }
}
