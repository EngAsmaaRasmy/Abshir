<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->integer("shop");
            $table->longText('user_address')->nullable();
            $table->integer('customer');
            $table->integer("driver")->nullable();
            $table->double("total_price",65,2);
            $table->double("price_after_discount",65,2);
            $table->double("must_paid_price",65,2);
            $table->longText("order_description")->nullable();
            $table->integer("status")->default(1);
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
        Schema::dropIfExists('orders');
    }
}
