<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDriverWalletHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('driver_wallet_histories', function (Blueprint $table) {
            $table->id();
            $table->string('value')->nullable();
            $table->enum('user_type',['Admin','Driver'])->default('Admin');
            $table->enum('type',['Add','Minus'])->default('Minus');
            $table->unsignedBigInteger('added_by')->nullable();
            $table->unsignedBigInteger('wallet_id')->nullable();
            $table->foreign('wallet_id')->references('id')->on('driver_wallets')->onDelete('SET NULL');
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
        Schema::dropIfExists('driver_wallet_histories');
    }
}
