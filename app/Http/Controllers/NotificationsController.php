<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class NotificationsController extends Controller
{
    // 过滤游客用户的 http 请求
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * 访问消息通知列表的方法
     *
     * @return void
     */
    public function index()
    {
        // 获取登录用户的所有通知
        $notifications = Auth::user()->notifications()->paginate(10);

        // 将未读消息标记为已读
        Auth::user()->markAsRead();

        return view('notifications.index', compact('notifications'));
    }
}
