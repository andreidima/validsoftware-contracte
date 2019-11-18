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
            $table->unsignedSmallInteger('oras_plecare');
            $table->unsignedSmallInteger('oras_sosire');
            $table->boolean('tur_retur');
            $table->date('data_plecare');
            $table->date('data_intoarcere')->nullable();
            $table->smallInteger('nr_adulti');
            $table->smallInteger('nr_copii');
            $table->smallInteger('nr_animale_mici');
            $table->smallInteger('nr_animale_mari');
            $table->string('nume');
            $table->string('telefon');
            $table->string('email');
            $table->string('adresa', 2002);
            $table->string('observatii', 2002);
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
