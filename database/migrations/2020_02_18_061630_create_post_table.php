<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// https://laravel.com/docs/6.x/migrations#introduction
// php artisan migrate
// php artisan migrate:refresh
class CreatePostTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->integer('poster');
            $table->string('tutoring_content');
            $table->dateTime('when');
            $table->integer('course');
            $table->foreign('course')->references('id')->on('course');
            $table->foreign('tutoring_content')->references('id')->on('tutoring_content');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('post');
    }
}
