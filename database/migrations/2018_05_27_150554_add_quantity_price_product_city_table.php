<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddQuantityPriceProductCityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_city', function (Blueprint $table) {
            $table->integer("quantity")->unsigned();
            $table->integer("price")->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_city', function (Blueprint $table) {
            //
        });
    }
}
