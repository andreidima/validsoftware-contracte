<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clienti', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nume');
            $table->string('nr_ord_reg_com')->nullable();
            $table->string('cui')->nullable();
            $table->string('adresa')->nullable();
            $table->string('iban')->nullable();
            $table->string('banca')->nullable();
            $table->unsignedInteger('contract_nr')->nullable();
            $table->date('contract_data')->nullable();
            $table->date('data_incepere')->nullable();
            $table->string('reprezentant')->nullable();
            $table->string('reprezentant_functie')->nullable();
            $table->string('email')->nullable();
            $table->string('telefon')->nullable();
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
        Schema::dropIfExists('clienti');
    }
}
