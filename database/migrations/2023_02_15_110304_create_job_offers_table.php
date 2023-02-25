<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_offers', function (Blueprint $table) {
            $table->comment('');
            $table->integer('id', true);
            $table->integer('job_ad_id')->index('FK_JOJobAdId');
            $table->integer('employee_id')->index('FK_JOEmployeeId');
            $table->string('phone', 12);
            $table->text('description')->nullable();
            $table->string('resume', 100);
            $table->enum('status', ['0', '1', '2'])->default('0')->comment('#0 : pending | #1 : rejected, | #2 : accepted');

        });

        /*
       * Blueprint not support two index in
       * primary key, so we define this
       * property, in unprepared DB
       */

        DB::unprepared("ALTER TABLE `wooden_door`.`job_offers` DROP PRIMARY KEY, ADD PRIMARY KEY (  `id` , `job_ad_id`, `employee_id` )");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('job_offers');
    }
};
