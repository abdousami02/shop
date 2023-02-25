<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('product', function (Blueprint $table) {
        $table->increments('id');
        $table->integer('categorie_id')->unsigned();
        $table->integer('famille_id')->unsigned();
        $table->foreign('categorie_id')->references('id')->on('categories');
        $table->foreign('famille_id')->references('id')->on('famille');
        $table->string('name');
        $table->string('name_ar')->nullable();
        $table->integer('code_bare');
        $table->longText('description');
        $table->string('image');
        $table->decimal('price_buy');
        $table->integer('qte_u/c');
        $table->decimal('price_unit')->nullable();
        $table->decimal('price_sell1');
        $table->decimal('price_sell2')->nullable();
        $table->decimal('price_sell3')->nullable();
        $table->integer('qte_sell2')->nullable();
        $table->integer('qte-sell3')->nullable();
        $table->integer('in_stock');
        $table->integer('is_active');
        $table->integer('has_goute');
        $table->integer('has_discount');
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
