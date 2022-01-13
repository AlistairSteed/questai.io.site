<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStripCouponAndCouponPriceToCouponTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('coupon', function (Blueprint $table) {
            $table->string('stripe_coupon_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('coupon', function (Blueprint $table) {
            $table->dropColumn(['stripe_coupon_id']);
        });
    }
}
