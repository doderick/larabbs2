<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy extends Policy
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
     * 用户授权验证的 update 方法，用于验证用户更新个人资料的权限验证
     *
     * @param User $currentUser
     * @param User $user
     * @return void
     */
    public function update(User $currentUser, User $user)
    {
        return $currentUser->id === $user->id;
    }

    /**
     * 用户授权验证的 destroy 方法，用于验证用户更新个人资料的权限验证
     *
     * @param User $currentUser
     * @param User $user
     * @return void
     */
    public function destroy(User $currentUser, User $user)
    {
        return true;
    }
}
