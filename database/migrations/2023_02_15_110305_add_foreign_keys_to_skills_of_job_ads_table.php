<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('skills_of_job_ads', function (Blueprint $table) {
            $table->foreign(['skill_id'], 'FK_JobPropertyTwo')->references(['id'])->on('skills')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['job_ad_id'], 'FK_JobPropertyOne')->references(['id'])->on('job_ads')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('skills_of_job_ads', function (Blueprint $table) {
            $table->dropForeign('FK_JobPropertyTwo');
            $table->dropForeign('FK_JobPropertyOne');
        });
    }
};
