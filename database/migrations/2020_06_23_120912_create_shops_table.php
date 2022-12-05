<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shops', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('username');
            $table->integer("category");
            $table->string("logo");
            $table->string('password');
            $table->double("delivery_cost",65,2)->default(10);
            $table->tinyInteger("prepare_time")->default(45);
            $table->string('phone',11);
            $table->integer('order_count')->default(0);
            $table->double('total_earnings',2)->default(0);
            $table->String('address')->nullable();
            $table->time("open_at");
            $table->time("close_at");
            $table->float("rating",65,2)->default(4.5);
            $table->boolean("active")->default(false);
            $table->rememberToken();
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
        Schema::dropIfExists('shops');
    }
}
