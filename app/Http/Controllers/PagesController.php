<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    /**
     * 访问首页的方法
     *
     * @return void
     */
    public function root()
    {
        return view('pages.root');
    }

    /**
     * 当前用户访问后台被拒绝之后，跳转的方法
     *
     * @return void
     */
    public function permissionDenied()
    {
        // 如果当前用户有权限访问后台，直接跳转访问
        if (config('administrator.permission')()) {
            return redirect(url(config('administrator.uri')), 302);
        }

        // 如果没有权限，返回拒绝访问的视图
        return view('pages.permission_denied');
    }
}
