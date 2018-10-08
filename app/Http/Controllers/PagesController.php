<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    /**
     * 返回主页的方法
     *
     * @return void
     */
    public function home()
    {
        return view('pages.home');
    }

    /**
     * 访问后台时进行跳转的方法
     *
     * @return void
     */
    public function permissionDenied()
    {
        // 如果当前用户具有访问后台的权限，跳转至后台
        if (config('administrator.permission')()) {
            return redirect(url(config('administrator.uri')), 302);
        }

        // 如果没有访问权限，则返回拒绝访问的视图
        return view('pages.permission_denied');
    }
}
