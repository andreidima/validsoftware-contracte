<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contracte', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedbigInteger('client_id')->nullable();
            $table->unsignedInteger('contract_nr')->nullable();
            $table->date('contract_data')->nullable();
            $table->date('data_incepere')->nullable();
            $table->unsignedInteger('pret')->nullable();
            $table->text('anexa')->nullable();
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
        Schema::dropIfExists('contracte');
    }
}
