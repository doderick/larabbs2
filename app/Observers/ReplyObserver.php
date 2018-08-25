<?php

namespace App\Observers;

use App\Models\Reply;

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
        $reply->content = clean($reply->content, 'user->topic->body');
    }

    /**
     * 回复被创建后执行的动作
     *
     * @param Reply $reply 回复的一个实例
     * @return void
     */
    public function created(Reply $reply)
    {
        // 回复数 +1
        $reply->topic->increment('reply_count', 1);
    }

    public function updating(Reply $reply)
    {
        //
    }
}