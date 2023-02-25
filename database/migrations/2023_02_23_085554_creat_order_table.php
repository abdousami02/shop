<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatOrderTable extends Migration
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
        $table->integer('store_id')->unsigned();
        $table->foreign('store_id')->references('id')->on('users');
        $table->decimal('montant');
        $table->integer('num_product');
        $table->decimal('poide')->nullable();
        $table->integer('status')->default(0);
        $table->timestamp('create_at')->useCurrent();
        $table->timestamp('update_at')->nullable();
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
