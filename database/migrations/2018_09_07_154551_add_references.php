<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddReferences extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 对 topics表 添加外键，user_id => users.id
        Schema::table('topics', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
        // 对 replies表 添加外键，user_id => users.id & topic_id => topics.id
        Schema::table('replies', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('topic_id')->references('id')->on('topics')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // 移除 topics表 的外键
        Schema::table('topics', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });
        // 移除 replies表 的外键
        Schema::table('replies', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['topic_id']);
        });
    }
}
