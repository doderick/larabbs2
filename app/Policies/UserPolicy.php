<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

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
     * 用户授权策略的 update 方法
     * 当前登录用户的id与要进行授权的用户的id相同时，授权通过
     *
     * @param User $currentUser 当前登录用户实例
     * @param User $user        要进行授权的用户实例
     * @return void
     */
    public function update(User $currentUser, User $user)
    {
        return $currentUser->id === $user->id;
    }
}
