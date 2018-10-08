<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\Models\User;

class FollowersController extends Controller
{
    /**
     * 构建中间件过滤 http 请求，只允许登录用户访问控制器
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * 用户关注其他用户的动作
     *
     * @param User $user 将被关注的用户
     * @return 被关注用户的主页
     */
    public function store(User $user)
    {
        if (Auth::id() === $user->id) {
            return;
        }
        if (! Auth::user()->isFollowing($user->id)) {
            Auth::user()->follow($user->id);
        }
        return redirect()->back();
    }

    /**
     * 用户取消对其他用户的关注的动作
     *
     * @param User $user 将被取消关注的用户
     * @return 被取消关注的用户的主页
     */
    public function destroy(User $user)
    {
        if (Auth::id() === $user->id) {
            return;
        }
        if (Auth::user()->isFollowing($user->id)) {
            Auth::user()->unfollow($user->id);
        }
        return redirect()->back();
    }
}
