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
        $table->decimal('montant')->nullable();
        $table->integer('num_product')->nullable();
        $table->decimal('poide')->nullable();
        $table->integer('status')->default(0);
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
