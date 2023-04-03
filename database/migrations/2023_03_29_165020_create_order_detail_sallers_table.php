<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderDetailSallersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_detail_sallers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('saller_id')->unsigned();
            $table->foreign('saller_id')->references('id')->on('sallers');

            $table->integer('order_id')->unsigned();
            $table->foreign('order_id')->references('id')->on('order');

            $table->bigInteger('order_detail_id')->unsigned();
            $table->foreign('order_detail_id')->references('id')->on('order_details');

            $table->integer('product_id')->unsigned();
            $table->foreign('product_id')->references('id')->on('products');

            $table->decimal('price_buy');
            $table->tinyInteger('in_stock')->default(1);
            $table->smallInteger('qte');
            $table->smallInteger('method_qte');
            $table->decimal('price_total');
            $table->tinyInteger('is_edite')->default(0);
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
        Schema::dropIfExists('order_detail_sallers');
    }
}
