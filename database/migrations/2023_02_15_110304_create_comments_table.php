<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->comment('');
            $table->integer('id', true);
            $table->integer('post_id')->index('FK_CPostId');
            $table->integer('user_id')->index('FK_CUserId');
            $table->enum('status', ['0', '1', '2'])->default('0')->comment('#0 : pending | #1 : ejected | #2 : published');
            $table->text('content');
            $table->integer('comment_id')->nullable();
            $table->integer('comment_post_id')->nullable();
            $table->integer('comment_user_id')->nullable();
            $table->timestamp('time')->useCurrent();

            $table->index(['comment_id', 'comment_post_id', 'comment_user_id'], 'Reply');
        });

        /*
         * Blueprint not support two index in
         * primary key, so we define this
         * property, in unprepared DB
         */

        DB::unprepared("ALTER TABLE `wooden_door`.`comments` DROP PRIMARY KEY, ADD PRIMARY KEY (  `id` , `post_id`, `user_id` )");

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
};
