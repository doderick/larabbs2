<?php

namespace App\Observers;

use App\Models\Reply;
use App\Notifications\TopicReplied;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class ReplyObserver
{
    /**
     * Reply模型 创建时触发的动作
     *
     * @param Reply $reply
     * @return void
     */
    public function creating(Reply $reply)
    {
        $this->checkReplyCountInTopicsTable($reply);
        $this->checkReplyCountInUsersTable($reply);
    }

    /**
     * Reply模型 创建之后触发的动作
     *
     * @param Reply $reply
     * @return void
     */
    public function created(Reply $reply)
    {
        // topics 表中回复数 +1
        $reply->topic->increment('reply_count', 1);

        // users 表中用户回复数 +1
        $reply->user->increment('reply_count', 1);

        // 通知作者帖子被回复
        $reply->topic->user->notify(new TopicReplied($reply));
    }

    /**
     * Reply模型 保存时触发的动作
     *
     * @param Reply $reply
     * @return void
     */
    public function saving(Reply $reply)
    {
        // XSS 过滤
        $reply->content = clean($reply->content, 'user_topic_body');
    }

    /**
     * Reply模型 删除时触发的动作
     *
     * @param Reply $reply
     * @return void
     */
    public function deleting(Reply $reply)
    {
        $this->checkReplyCountInTopicsTable($reply);
        $this->checkReplyCountInUsersTable($reply);
    }

    /**
     * Reply模型 删除后触发的动作
     *
     * @param Reply $reply
     * @return void
     */
    public function deleted(Reply $reply)
    {
         // users 表中用户帖子数 +1
         $reply->user->decrement('reply_count', 1);

         // topics 表中用户帖子数 +1
         $reply->topic->decrement('reply_count', 1);
    }

    /**
     * 查询 Topics表 中回帖计数并进行更新的方法
     * 此方法仅限填充伪数据后测试用，不能使用在生产环境中
     *
     * @param Reply $reply
     * @return void
     */
    private function checkReplyCountInTopicsTable(Reply $reply)
    {
        if (! $reply->topic->reply_count > 0) {
            $reply->topic->reply_count = $reply->all()->where('topic_id', $reply->topic->id)->count();
            $reply->topic->save();
        }
    }

    /**
     * 查询 Users表 中回帖计数并进行更新的方法
     * 此方法仅限填充伪数据后测试用，不能使用在生产环境中
     *
     * @param Reply $reply
     * @return void
     */
    private function checkReplyCountInUsersTable(Reply $reply)
    {
        if (! $reply->user->reply_count > 0) {
            $reply->user->reply_count = $reply->all()->where('user_id', $reply->user->id)->count();
            $reply->user->save();
        }
    }
}