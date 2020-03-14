<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNowShowingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('now_showings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('movie_id')->nullable();
            $table->unsignedInteger('cinema_id')->nullable();
            $table->string('start_showing_date')->nullable();
            $table->string('end_showing_date')->nullable();
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
        Schema::dropIfExists('now_showings');
    }
}
