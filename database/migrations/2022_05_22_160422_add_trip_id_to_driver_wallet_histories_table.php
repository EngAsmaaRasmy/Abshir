<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTripIdToDriverWalletHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('driver_wallet_histories', function (Blueprint $table) {
            $table->unsignedBigInteger('trip_id')->nullable()->after('wallet_id');
            $table->foreign('trip_id')->references('id')->on('trips')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('driver_wallet_histories', function (Blueprint $table) {
            //
        });
    }
}
