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
        Schema::table('companies', function (Blueprint $table) {
            $table->foreign(['employer_id'], 'FK_EmployerID')->references(['user_id'])->on('employers')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['job_category_id'], 'FK_JobCategoryCompany')->references(['id'])->on('job_categories')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropForeign('FK_EmployerID');
        });
    }
};
