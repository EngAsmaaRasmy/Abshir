<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_offers', function (Blueprint $table) {
            $table->id();
            $table->integer("type");
            $table->integer("size_id");
            $table->integer("shop");
            $table->String("name");
            $table->integer('percentage')->nullable();
            $table->double('value',2)->nullable();
            $table->integer("amount")->nullable();
            $table->integer('gift_amount')->nullable();
            $table->date("expire_date");
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
        Schema::dropIfExists('product_offers');
    }
}
