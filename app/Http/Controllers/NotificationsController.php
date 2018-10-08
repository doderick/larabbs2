<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;

class NotificationsController extends Controller
{
    /**
     * 改造中间件过滤 http 请求，只允许登录用户访问控制器中的方法
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * 显示通知列表的方法
     *
     * @return void
     */
    public function index()
    {
        // 取出登录用户的所有通知消息
        $notifications = Auth::user()->notifications()->paginate(20);
        // 将未读消息标记为已读，并清空未读消息计数
        Auth::user()->markAsRead();
        return view('notifications.index', compact('notifications'));
    }
}
