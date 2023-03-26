<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFamillesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('familles', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('categorie_id')->unsigned();
          $table->foreign('categorie_id')->references('id')->on('categories');
          $table->string('name');
          $table->string('name_ar')->nullable();
          $table->integer('status')->default(0);
          $table->integer('rank')->default(0);
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
        Schema::dropIfExists('familles');
    }
}
