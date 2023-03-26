<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('order_details', function (Blueprint $table) {
        $table->increments('id');
        $table->bigInteger('order_id')->unsigned();
        $table->foreign('order_id')->references('id')->on('order');
        $table->integer('product_id')->unsigned();
        $table->foreign('product_id')->references('id')->on('products');
        // $table->integer('product_goute_id')->unsigned()->nullable();
        // $table->foreign('product_goute_id')->references('id')->on('product_goute');
        $table->integer('discount_id')->unsigned()->nullable();
        $table->foreign('discount_id')->references('id')->on('discount');
        $table->decimal('price_sell');
        $table->integer('qte');
        $table->decimal('price_total');
        $table->decimal('weight')->nullable()->default(0);
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
        //
    }
}
