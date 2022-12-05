<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDriversTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drivers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('fullname');
            $table->string('phone')->unique();
            $table->string('email')->nullable();
            $table->integer("shop")->nullable();
            $table->string('transportation_id')->nullable();
            $table->string('password');
            $table->string('address');
            $table->boolean('active');
            $table->string('documents')->nullable();
            $table->string('driving_license')->nullable();
            $table->string('license_number')->nullable();
            $table->string('city_name')->nullable();
            $table->integer('order_count')->default(0);
            $table->integer('active_order')->default(0);
            $table->double('total_earnings',65,2)->default(0);
            $table->string("api_token",65)->nullable();
            $table->string("fcm_token")->nullable();
            $table->string("image")->nullable();
            $table->tinyInteger('delivery_status')->nullable();
            $table->tinyInteger('lemozen_status')->nullable();
            $table->enum('status',['0','1','2','3','4','5','6','7'])->default('0');
            $table->date('date_of_birth')->nullable();
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
        Schema::dropIfExists('drivers');
    }
}
