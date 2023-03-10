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
        Schema::table('posts', function (Blueprint $table) {
            $table->foreign(['author_id'], 'FK_PAuthorId')->references(['id'])->on('authors')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['category_id'], 'posts_ibfk_1')->references(['id'])->on('post_categories')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropForeign('FK_PAuthorId');
            $table->dropForeign('posts_ibfk_1');
        });
    }
};
