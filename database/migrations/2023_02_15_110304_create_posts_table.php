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
        Schema::create('posts', function (Blueprint $table) {
            $table->comment('');
            $table->integer('id', true);
            $table->string('title', 50);
            $table->text('description')->nullable();
            $table->enum('post_status', ['0', '1', '2', '3', '4'])->default('3')->comment('#0 : pending | #1 : ejected | #2 : published | #3 : draft | #4 : deleted');
            $table->boolean('comment_status')->default(true)->comment('#true: open comment | #false: close comment');
            $table->integer('like_number')->default(0);
            $table->integer('dislike_number')->default(0);
            $table->integer('score')->default(0);
            $table->string('uri', 50);
            $table->timestamp('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrent();
            $table->integer('author_id')->index('FK_PAuthorId');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
};