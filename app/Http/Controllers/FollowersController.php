<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;

class FollowersController extends Controller
{
    /**
     * 过滤http请求，仅允许登录用户访问
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
        if (Auth::user()->id === $user->id) {
            return redirect('home');
        }
        if (!Auth::user()->isFollowing($user->id)) {
            Auth::user()->follow($user->id);
        }
        return redirect()->route('users.show', $user->id);
    }

    /**
     * 用户取消对其他用户的关注的动作
     *
     * @param User $user 将被取消关注的用户
     * @return 被取消关注的用户的主页
     */
    public function destroy(User $user)
    {
        if (Auth::user()->id === $user->id) {
            return redirect('home');
        }
        if (Auth::user()->isFollowing($user->id)) {
            Auth::user()->unfollow($user->id);
        }
        return redirect()->route('users.show', $user->id);
    }
}
