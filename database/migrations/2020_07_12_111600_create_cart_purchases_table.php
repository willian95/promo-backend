<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartPurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cart_purchases', function (Blueprint $table) {
            $table->id();
            $table->integer("user_id");
            $table->float("price");
            $table->enum("payment_type", ['reservation', 'purchase']);
            $table->float("total");
            $table->integer("post_id");
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
        Schema::dropIfExists('cart_purchases');
    }
}
