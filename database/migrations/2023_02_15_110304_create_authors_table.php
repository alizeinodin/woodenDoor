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
        Schema::create('authors', function (Blueprint $table) {
            $table->comment('');
            $table->integer('id', true);
            $table->string('nick_name', 20)->nullable()->unique('nick_name');
            $table->integer('score')->default(0);
            $table->text('about')->nullable();
            $table->integer('user_id')->index('FK_AEmployeeId');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('authors');
    }
};
