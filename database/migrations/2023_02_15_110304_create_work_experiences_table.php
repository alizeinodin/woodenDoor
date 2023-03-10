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
        Schema::create('work_experiences', function (Blueprint $table) {
            $table->comment('');
            $table->integer('id', true);
            $table->integer('employee_id')->index('FK_WEEmployee');
            $table->string('title', 50);
            $table->dateTime('start_time');
            $table->dateTime('end_time')->nullable();
            $table->boolean('working_status')->comment('#false : unemployed | #true : in work');
            $table->text('description')->nullable();
            $table->string('company_name', 50);
            $table->timestamps();
        });

        /*
         * Blueprint not support two index in
         * primary key, so we define this
         * property, in unprepared DB
         */

        DB::unprepared("ALTER TABLE `wooden_door`.`work_experiences` DROP PRIMARY KEY, ADD PRIMARY KEY (`id`, `employee_id`)");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('work_experiences');
    }
};
