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
        Schema::table('education_experiences', function (Blueprint $table) {
            $table->foreign(['employee_id'], 'FK_EEEmployee')->references(['user_id'])->on('employees')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('education_experiences', function (Blueprint $table) {
            $table->dropForeign('FK_EEEmployee');
        });
    }
};
