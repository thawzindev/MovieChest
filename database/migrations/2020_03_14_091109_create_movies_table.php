<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMoviesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('popularity')->nullable();
            $table->string('poster_path')->nullable();
            $table->unsignedInteger('moviedb_id')->nullable();
            $table->string('title')->nullable();
            $table->string('vote_average')->nullable();
            $table->text('overview')->nullable();
            $table->text('release_date')->nullable();
            $table->string('type')->nullable();
            $table->integer('request_count')->default(0);
            $table->unsignedInteger('status')->default(0);
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
        Schema::dropIfExists('movies');
    }
}
