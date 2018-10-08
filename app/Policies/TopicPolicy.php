<?php

namespace App\Policies;

use App\Models\User;
use APp\Models\Topic;

class TopicPolicy extends Policy
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
     * 帖子 update 动作的权限认证
     *
     * @param User $user   提出 edit 或 update 请求的用户
     * @param Topic $topic 需要进行 update 的帖子
     * @return void
     */
    public function update(User $user, Topic $topic)
    {
        return $user->isAuthorOf($topic);
    }

    /**
     * 帖子 destroy 动作的权限认证
     *
     * @param User $user   提出 destroy 请求的用户
     * @param Topic $topic 需要进行 destroy 的帖子
     * @return void
     */
    public function destroy(User $user, Topic $topic)
    {
        return $user->isAuthorOf($topic);
    }
}
