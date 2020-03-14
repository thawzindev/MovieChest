<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCinemasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cinemas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('region_id')->nullable();
            $table->unsignedInteger('township_id')->nullable();
            $table->unsignedInteger('company_id')->nullable();
            $table->string('name')->nullable();
            $table->string('phone')->nullable();
            $table->string('lat')->nullable();
            $table->string('long')->nullable();
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
        Schema::dropIfExists('cinemas');
    }
}
