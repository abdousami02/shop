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
        $table->bigIncrements('id');
        $table->integer('order_id')->unsigned();
        $table->foreign('order_id')->references('id')->on('order');
        $table->integer('product_id')->unsigned();
        $table->foreign('product_id')->references('id')->on('products');
        $table->integer('discount_id')->unsigned()->nullable();
        $table->foreign('discount_id')->references('id')->on('discount');
        $table->decimal('price_sell');
        // $table->decimal('price_buy')->default(0);
        $table->smallInteger('qte');
        $table->smallInteger('method_qte');
        $table->decimal('price_total');
        // $table->decimal('price_buy_total')->default(0);
        $table->decimal('weight')->nullable()->default(0);
        // $table->tinyInteger('in_stock')->default(1);
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
