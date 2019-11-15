<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRezervariTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rezervari', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nume');
            $table->string('telefon');
            $table->string('email');
            $table->unsignedBigInteger('oras_id');
            $table->unsignedBigInteger('tur_retur');
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
        Schema::dropIfExists('rezervari');
    }
}
