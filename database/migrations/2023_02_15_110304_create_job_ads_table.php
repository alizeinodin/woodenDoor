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
        Schema::create('job_ads', function (Blueprint $table) {
            $table->comment('');
            $table->integer('id', true);
            $table->integer('company_id')->index('FK_CompanyId');
            $table->integer('job_ad_category')->index('FK_JobCategory');
            $table->string('title', 50);
            $table->string('province', 20);
            $table->enum('type_of_cooperation', ['0', '1', '2', '3'])->comment('#0: part time | #1: full time | #2: telecommuting | #3: project');
            $table->decimal('min_salary', 10, 0)->nullable();
            $table->text('description');
            $table->enum('work_experience', ['0', '1', '2', '3', '4', '5'])->nullable()->comment('#0: less than 6 month | #1: less than 1 year | #2: 1 to 2 year | #3: 2 to 3 years | #4: 3 to 5 years | #5: more than 5 years');
            $table->enum('min_education_degree', ['0', '1', '2', '3', '4', '5'])->nullable()->comment('#0: under diploma | #1: diploma | #2: bachelors degree | #3: masters degree | #4: doctorate | #5: postdoctoral');
            $table->enum('military_status', ['0', '1', '2', '3'])->nullable()->comment('#0: end_of_service | #1: permanent exemption | #2: doing | #3: included');
            $table->boolean('sex')->nullable()->comment('#true: male | #false: female');
            $table->enum('status', ['0', '1', '2', '3'])->default('0')->comment('0: waiting | #1: active | #2: failed | #3: need correction');
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
        Schema::dropIfExists('job_ads');
    }
};
