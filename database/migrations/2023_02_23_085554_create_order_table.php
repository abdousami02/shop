<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('order', function (Blueprint $table) {
        $table->increments('id');
        $table->integer('store_id')->unsigned()->nullable();
        $table->foreign('store_id')->references('id')->on('store_info');

        $table->integer('user_id')->unsigned();
        $table->foreign('user_id')->references('id')->on('users');

        $table->integer('saller_id')->unsigned()->nullable();
        $table->foreign('saller_id')->references('id')->on('sallers');
        $table->decimal('amount')->default(0);
        $table->smallInteger('num_product')->default(0);
        $table->decimal('weight')->nullable()->default(0);
        $table->tinyInteger('status')->default(0);
        $table->tinyInteger('show_admin')->default(0);
        $table->tinyInteger('show_saller')->default(0);
        $table->timestamp('to_saller_at')->nullable();
        $table->decimal('amount_buy')->nullable();
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
