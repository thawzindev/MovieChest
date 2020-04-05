<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCastsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('casts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('cast_id');
            $table->string('character');
            $table->string('credit_id');
            $table->unsignedInteger('gender');
            $table->unsignedInteger('caster_id');
            $table->string('name');
            $table->unsignedInteger('order');
            $table->string('profile_path');
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
        Schema::dropIfExists('casts');
    }
}
