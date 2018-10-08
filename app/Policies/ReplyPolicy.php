<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Reply;

class ReplyPolicy extends Policy
{
    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * 回帖 update 动作的权限认证
     *
     * @param User $user   提出 update 请求的用户
     * @param Topic $topic 需要进行 update 的回帖
     * @return void
     */
    public function update(User $user, Reply $reply)
    {
        return true;
    }

    /**
     * 回帖 destroy 动作的权限认证
     *
     * @param User $user   提出 destroy 请求的用户
     * @param Topic $topic 需要进行 destroy 的回帖
     * @return void
     */
    public function destroy(User $user, Reply $reply)
    {
        return $user->isAuthorOf($reply) || $user->isAuthorOf($reply->topic);
    }
}
