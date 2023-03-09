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
        Schema::table('store_posts', function (Blueprint $table) {
            $table->foreign(['user_id'], 'FK_SUser')->references(['id'])->on('users')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['post_id'], 'FK_SPost')->references(['id'])->on('posts')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('store_posts', function (Blueprint $table) {
            $table->dropForeign('FK_SUser');
            $table->dropForeign('FK_SPost');
        });
    }
};
