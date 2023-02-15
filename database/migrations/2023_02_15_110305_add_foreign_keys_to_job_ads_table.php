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
        Schema::table('job_ads', function (Blueprint $table) {
            $table->foreign(['job_ad_category'], 'FK_JobCategory')->references(['id'])->on('job_ads_categories')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['company_id'], 'FK_CompanyId')->references(['id'])->on('companies')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('job_ads', function (Blueprint $table) {
            $table->dropForeign('FK_JobCategory');
            $table->dropForeign('FK_CompanyId');
        });
    }
};
