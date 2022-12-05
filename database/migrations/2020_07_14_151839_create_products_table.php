<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->integer("category");
            $table->integer("shop");
            $table->String("image")->nullable();
            $table->string('name_ar')->unique();
            $table->String("name_en")->nullable();
            $table->string("description_ar");
            $table->string("description_en")->nullable();
            $table->double("price",2);
            $table->integer("offer_id")->nullable();
            $table->boolean("active")->default(true);
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
        Schema::dropIfExists('products');
    }
}
