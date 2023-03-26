<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderDetailGoutesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_detail_goutes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_detail_id')->unsigned();
            $table->foreign('order_detail_id')->references('id')->on('order_details');
            $table->integer('order_id')->unsigned();
            $table->foreign('order_id')->references('id')->on('order');
            $table->integer('product_goute_id')->unsigned();
            $table->foreign('product_goute_id')->references('id')->on('product_goute');
            $table->integer('qte')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_product_goutes');
    }
}
