<?php

/**
 * 将当前请求的路由名称转换为 CSS 类名的方法
 *
 * @return void
 */
function route_class()
{
    return str_replace('.', '-', Route::currentRouteName());
}