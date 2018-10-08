<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRepliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('replies', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('topic_id')->unsigned()->index()->comment('回帖所属帖子id');
            $table->integer('user_id')->unsigned()->index()->comment('回帖所属作者id');
            $table->integer('vote_count')->unsigned()->default(0)->comment('回帖收到的赞数');
            $table->text('content')->comment('回帖内容');
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
        Schema::dropIfExists('replies');
    }
}
