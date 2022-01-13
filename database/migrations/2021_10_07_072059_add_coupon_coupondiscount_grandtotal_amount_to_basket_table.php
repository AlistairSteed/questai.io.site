<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCouponCoupondiscountGrandtotalAmountToBasketTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('basket', function (Blueprint $table) {
            $table->string('total_amount')->nullable();
            $table->string('grand_total_amount')->nullable();
            $table->string('invoice_url')->nullable();
            $table->integer('coupon_id')->nullable(); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('basket', function (Blueprint $table) {
            $table->dropColumn(['total_amount','grand_total_amount','invoice_url','coupon_id']);
        });
    }
}
