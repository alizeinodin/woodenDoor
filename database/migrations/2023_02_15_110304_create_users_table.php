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
        Schema::create('users', function (Blueprint $table) {
            $table->comment('');
            $table->integer('id', true);
            $table->string('username', 50)->unique('username');
            $table->string('email', 50)->unique('email');
            $table->string('password', 100);
            $table->string('phone', 20)->nullable()->unique('phone');
            $table->string('first_name', 50)->nullable();
            $table->string('last_name', 50)->nullable();
            $table->boolean('sex')->comment('#true: male | #false: female');
            $table->boolean('married')->nullable()->default(false)->comment('#true: is married | #false: not married');
            $table->date('birth_year')->nullable();
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
        Schema::dropIfExists('users');
    }
};
