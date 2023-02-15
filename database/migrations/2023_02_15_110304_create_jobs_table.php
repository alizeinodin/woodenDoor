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
        Schema::create('jobs', function (Blueprint $table) {
            $table->comment('');
            $table->integer('id', true);
            $table->integer('job_offers_id');
            $table->integer('job_offers_job_ad_id');
            $table->integer('job_offers_employee_id');
            $table->string('job_position', 50)->nullable();
            $table->smallInteger('satisfaction_score')->nullable();
            $table->integer('salary')->nullable();
            $table->boolean('status')->nullable()->default(true)->comment('#true: active | #false: fired');
            $table->timestamp('start_time')->useCurrent();
            $table->timestamp('end_time')->nullable();

            $table->index(['job_offers_id', 'job_offers_job_ad_id', 'job_offers_employee_id'], 'FK_JobOffersId');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jobs');
    }
};
