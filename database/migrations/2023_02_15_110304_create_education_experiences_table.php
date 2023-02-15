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
        Schema::create('education_experiences', function (Blueprint $table) {
            $table->comment('');
            $table->integer('id', true);
            $table->integer('employee_id')->index('FK_EEEmployee');
            $table->string('field', 50);
            $table->string('uni_name', 50);
            $table->enum('grade', ['0', '1', '2', '3', '4', '5'])->comment('#0: under diploma | #1: diploma | #2: bachelors degree | #3: masters degree | #4: doctorate | #5: postdoctoral');
            $table->dateTime('start_time');
            $table->dateTime('end_time')->nullable();
            $table->boolean('study_status')->comment('#false : Graduated | #true : Studying');
            $table->string('image', 100)->nullable();
            $table->text('description')->nullable();
        });

        /*
         * Blueprint not support two index in
         * primary key, so we define this
         * property, in unprepared DB
         */

        DB::unprepared("ALTER TABLE `wooden_door`.`education_experiences` DROP PRIMARY KEY, ADD PRIMARY KEY (  `id` , `employee_id` )");

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('education_experiences');
    }
};
