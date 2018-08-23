<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Topic;

class TopicPolicy extends Policy
{
    /**
     * 话题 update 操作的权限认证
     *
     * @param User $user    提出编辑请求的用户实例，当前登录用户
     * @param Topic $topic  要进行编辑操作的话题实例
     * @return void
     */
    public function update(User $user, Topic $topic)
    {
        return $topic->user_id == $user->id;
    }

    public function destroy(User $user, Topic $topic)
    {
        return true;
    }
}
