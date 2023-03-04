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
        Schema::create('reaction_posts', function (Blueprint $table) {
            $table->comment('');
            $table->string('react');
            $table->integer('user_id')->index('FK_RUser');
            $table->integer('post_id')->index('FK_RPost');
            $table->timestamps();

            $table->primary(['user_id', 'post_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('like_posts');
    }
};
