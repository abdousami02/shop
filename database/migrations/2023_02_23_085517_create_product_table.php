<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('products', function (Blueprint $table) {
        $table->increments('id');
        $table->smallInteger('categorie_id')->unsigned();
        $table->smallInteger('famille_id')->unsigned()->nullable();
        $table->foreign('categorie_id')->references('id')->on('categories');
        $table->foreign('famille_id')->references('id')->on('familles');
        $table->string('name');
        $table->string('name_ar')->nullable();
        $table->bigInteger('code_bare')->nullable();
        $table->string('description')->nullable();
        $table->string('image')->nullable();
        $table->string('method_price');
        $table->smallInteger('method_qte');
        $table->decimal('price_buy');
        $table->integer('qte_uc')->nullable();
        $table->decimal('price_sell1');
        $table->decimal('price_sell2')->nullable();
        $table->decimal('price_sell3')->nullable();
        $table->integer('qte_sell2')->nullable();
        $table->integer('qte_sell3')->nullable();
        $table->mediumInteger('qte_stock')->default(0);
        $table->decimal('weight')->nullable()->default(0);
        $table->tinyInteger('in_stock')->default(0);
        $table->tinyInteger('status')->default(0);
        $table->smallInteger('rank')->default(0);
        $table->tinyInteger('has_goute')->default(0);
        $table->tinyInteger('has_discount')->default(0);
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
