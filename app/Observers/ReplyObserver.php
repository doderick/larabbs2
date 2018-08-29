<?php

namespace App\Observers;

use App\Models\Reply;
use App\Notifications\TopicReplied;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class ReplyObserver
{
    /**
     * 回复创建时执行的动作
     *
     * @param Reply $reply 创建的回复实例
     * @return void
     */
    public function creating(Reply $reply)
    {
        // 预防 XSS 攻击
        // $reply->content = clean($reply->content, 'user_topic_body');
        $this->checkReplyCountInTopicsTable($reply);
        $this->checkReplyCountInUsersTable($reply);
    }

    /**
     * 回复被创建后执行的动作
     *
     * @param Reply $reply 回复的一个实例
     * @return void
     */
    public function created(Reply $reply)
    {
        // topics 表中回复数 +1
        $reply->topic->increment('reply_count', 1);

        // users 表中用户回复数 +1
        $reply->user->increment('reply_count', 1);

        // 通知作者，话题被回复
        $reply->topic->user->notify(new TopicReplied($reply));
    }

    public function deleting(Reply $reply)
    {
        $this->checkReplyCountInTopicsTable($reply);
        $this->checkReplyCountInUsersTable($reply);
    }

    public function deleted(Reply $reply)
    {
        // 回复数 -1
        $reply->topic->decrement('reply_count', 1);

        // users 表中用户回复数 -1
        $reply->user->decrement('reply_count', 1);
    }

    private function checkReplyCountInTopicsTable(Reply $reply)
    {
        if (! $reply->topic->reply_count > 0) {
            $reply->topic->reply_count = $reply->all()->where('topic_id', $reply->topic->id)->count();
            $reply->topic->save();
        }
    }

    private function checkReplyCountInUsersTable(Reply $reply)
    {
        if (! $reply->user->reply_count > 0) {
            $reply->user->reply_count = $reply->all()->where('user_id', $reply->user->id)->count();
            $reply->user->save();
        }
    }
}