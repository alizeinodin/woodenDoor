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
        Schema::create('companies', function (Blueprint $table) {
            $table->comment('');
            $table->integer('id', true);
            $table->string('persian_name', 50);
            $table->string('english_name', 50);
            $table->string('logo_path', 100)->nullable();
            $table->string('tel', 12)->nullable();
            $table->text('address')->nullable();
            $table->string('website', 50)->nullable();
            $table->enum('number_of_staff', ['0', '1', '2', '3', '4', '5'])->nullable()->comment('#0: under 10 employer | #1: 10 to 20 employer | #2: 20 to 50 employer | #3: 50 to 100 employer | #4: 4: 100 to 500 employer | #5: more than 500');
            $table->text('about_company')->nullable();
            $table->string('nick_name', 50)->unique('nick_name');
            $table->boolean('isValid')->default(false);
            $table->integer('score')->default(0);
            $table->integer('employer_id')->index('FK_EmployerID');
            $table->integer('job_category_id')->index('FK_JobCategoryCompany')->default(1);
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
        Schema::dropIfExists('companies');
    }
};
