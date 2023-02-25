<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductGouteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('product_goute', function (Blueprint $table) {
        $table->increments('id');
        $table->integer('product_id')->unsigned();
        $table->foreign('product_id')->references('id')->on('product');
        $table->string('goute');
        $table->integer('in_stock');
        $table->decimal('discount');
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
        Schema::dropIfExists('product_goute');
    }
}
