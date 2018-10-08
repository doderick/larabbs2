<?php

// 自定义辅助函数

/**
 * 将当前路由名转换为类名
 *
 * @return void
 */
function routeToClass()
{
    return str_replace('.', '-', Route::currentRouteName());
}

/**
 * 生成摘录的方法
 *
 * @param string $value   需要生成摘录的内容
 * @param integer $length 摘录的长度
 * @return string         限定长度的摘录
 */
function make_excerpt($value, $length = 200)
{
    $excerpt = trim(preg_replace('/\r\n|\r|\n+/', ' ', strip_tags($value)));
    return str_limit($excerpt, $length);
}

function model_admin_link($title, $model)
{
    return model_link($title, $model, 'admin');
}

function model_link($title, $model, $prefix = '')
{
    // 获得数据模型的复数蛇形命名
    $model_name = model_plural_name($model);

    // 初始化前缀
    $prefix = $prefix ? "/$prefix/" : '/';

    // 使用站点 URL 拼接完整 URL
    $url = config('app.url') . $prefix . $model_name . '/' .$model->id;

    // 拼接 HTML A 标签，并返回
    return '<a href="' . $url . '" target="_blank">' . $title . '</a>';
}

function model_plural_name($model)
{
    // 从实体中获取完整类名
    $full_class_name = get_class($model);

    // 获取基础类名
    $class_name = class_basename($full_class_name);

    // 蛇形命名
    $snake_case_name = snake_case($class_name);

    // 获取字串的复数形式
    return str_plural($snake_case_name);
}