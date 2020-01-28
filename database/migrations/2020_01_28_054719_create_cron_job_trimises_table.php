<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCronJobTrimisesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cron_jobs_trimise', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('cronjob_id')->nullable();
            $table->timestamps();

            $table->foreign('cronjob_id')->references('id')->on('cron_jobs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cron_jobs_trimise');
    }
}
