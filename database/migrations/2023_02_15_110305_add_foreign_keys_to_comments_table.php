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
        Schema::table('comments', function (Blueprint $table) {
            $table->foreign(['user_id'], 'FK_CUserId')->references(['id'])->on('users')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['post_id'], 'FK_CPostId')->references(['id'])->on('posts')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['comment_id', 'comment_post_id', 'comment_user_id'], 'Reply')->references(['id', 'post_id', 'user_id'])->on('comments')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('comments', function (Blueprint $table) {
            $table->dropForeign('FK_CUserId');
            $table->dropForeign('FK_CPostId');
            $table->dropForeign('Reply');
        });
    }
};
