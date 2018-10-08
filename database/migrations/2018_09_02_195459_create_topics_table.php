<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTopicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('topics', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->index()->comment('帖子标题');
            $table->text('body')->comment('帖子正文');
            $table->integer('user_id')->unsigned()->index()->comment('作者id');
            $table->integer('category_id')->unsigned()->index()->comment('分类id');
            $table->integer('view_count')->unsigned()->default(0)->comment('浏览计数');
            $table->integer('reply_count')->unsigned()->default(0)->comment('回帖计数');
            $table->integer('vote_count')->unsigned()->default(0)->comment('收到的赞数');
            $table->integer('last_reply_user_id')->unsigned()->nullable()->comment('最后回帖用户id');
            $table->integer('order')->unsigned()->default(0)->comment('排序用');
            $table->text('excerpt')->comment('帖子摘录');
            $table->string('slug')->nullable()->comment('SEO友好的URI');
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
        Schema::dropIfExists('topics');
    }
}
