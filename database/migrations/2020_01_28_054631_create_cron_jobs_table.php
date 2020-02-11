<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCronJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cron_jobs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nume')->nullable();
            $table->unsignedBigInteger('client_id')->nullable();
            // $table->unsignedBigInteger('contract_id')->nullable();
            $table->unsignedTinyInteger('ziua')->nullable();
            $table->time('ora')->nullable();
            $table->string('subiect')->nullable();
            $table->text('email')->nullable();
            $table->boolean('fisier_generat')->nullable();
            $table->boolean('stare')->nullable();
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
        Schema::dropIfExists('cron_jobs');
    }
}
