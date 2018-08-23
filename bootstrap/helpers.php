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

/**
 * 生成话题摘录的方法
 *
 * @param string $value   需要生成摘录的内容
 * @param integer $length 摘录的长度
 * @return void
 */
function make_excerpt($value, $length = 200)
{
    $excerpt = trim(preg_replace('/\r|\n|\r\n+/', ' ', strip_tags($value)));
    return str_limit($excerpt, $length);
}