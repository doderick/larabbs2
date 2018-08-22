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
}
