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
        Schema::create('store_posts', function (Blueprint $table) {
            $table->comment('');
            $table->integer('user_id');
            $table->integer('post_id')->index('FK_SPost');
            $table->timestamp('time')->useCurrent();
            $table->boolean('status')->default(true)->comment('#false : deleted | #true : available');

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
        Schema::dropIfExists('store_posts');
    }
};
