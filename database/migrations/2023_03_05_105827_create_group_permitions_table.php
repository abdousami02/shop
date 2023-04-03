<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupPermitionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_permitions', function (Blueprint $table) {
            $table->increments('id');
            $table->smallInteger('group_id')->unsigned();
            $table->foreign('group_id')->references('id')->on('group');
            $table->integer('permition_id')->unsigned();
            $table->foreign('permition_id')->references('id')->on('permitions');
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
        Schema::dropIfExists('group_permitions');
    }
}
