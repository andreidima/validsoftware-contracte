<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProduseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produse', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nume');
            $table->decimal('pret')->nullable();
            $table->integer('cantitate')->nullable();
            $table->string('cod_de_bare')->nullable();
            $table->string('descriere')->nullable();
            $table->date('data')->nullable();

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
        Schema::dropIfExists('produse');
    }
}
