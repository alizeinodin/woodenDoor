<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_properties', function (Blueprint $table) {
            $table->comment('');
            $table->integer('job_ads_id');
            $table->integer('job_ads_property_id')->index('FK_JobPropertyTwo');

            $table->primary(['job_ads_id', 'job_ads_property_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('job_properties');
    }
};
