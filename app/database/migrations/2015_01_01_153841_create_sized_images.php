<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSizedImages extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sized_images', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('image_id');
            $table->integer('width');
            $table->integer('height');
            $table->integer('ratio');
            $table->text('path');
            $table->boolean('file_exists')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('sized_images');
    }

}
