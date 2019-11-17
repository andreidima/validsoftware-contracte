<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTarifeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tarife', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('traseu_id');
            $table->boolean('tur_retur');
            $table->string('adult');
            $table->string('copil');
            $table->string('animal_mic');
            $table->string('animal_mare');
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
        Schema::dropIfExists('tarife');
    }
}
