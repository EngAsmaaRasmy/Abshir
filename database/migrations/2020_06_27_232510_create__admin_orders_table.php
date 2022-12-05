<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_orders', function (Blueprint $table) {
            $table->id();
            $table->String("details");
            $table->double("delivery_cost",65,2);
            $table->double("must_paid",65,2);
            $table->integer("driver_id");
            $table->String("customer_phone",11);
            $table->string("customer_name");
            $table->string("customer_address");

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
        Schema::dropIfExists('admin_orders');
    }
}
