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
        Schema::create('employees', function (Blueprint $table) {
            $table->comment('');
            $table->integer('user_id')->primary();
            $table->string('province', 50)->nullable();
            $table->string('address', 200)->nullable();
            $table->string('about_me', 200)->nullable();
            $table->decimal('min_salary', 10, 0)->nullable();
            $table->enum('military_status', ['0', '1', '2', '3', '4'])->nullable()->comment('#0: end of service | #1: permanent exemption | #2: doing | #3: included | #4: educational exemption');
            $table->string('job_position_title', 50)->nullable();
            $table->enum('job_position_status', ['0', '1', '2', '3', '4'])->nullable()->default('0')->comment('#0: job seeker | #1: working | #2: job seeker but not very enthusiastic | #3: studying | #4: learning');
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
        Schema::dropIfExists('employees');
    }
};
