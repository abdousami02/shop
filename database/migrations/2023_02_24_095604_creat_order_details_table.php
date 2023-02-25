<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatOrderDetailsTable extends Migration
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
        $table->integer('order_id')->unsigned();
        $table->integer('product_id')->unsigned();
        $table->integer('product_goute_id')->unsigned();
        $table->integer('discount_id')->unsigned();
        $table->foreign('order_id')->references('id')->on('order');
        $table->foreign('product_id')->references('id')->on('product');
        $table->foreign('product_goute_id')->references('id')->on('product_goute')->nullable();
        $table->foreign('discount_id')->references('id')->on('discount');
        $table->integer('qte');
        $table->decimal('price_sell');
        $table->timestamp('added_at')->useCurrent();
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
