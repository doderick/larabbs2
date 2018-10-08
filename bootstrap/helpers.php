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

function model_admin_link($title, $model)
{
    return model_link($title, $model, 'admin');
}

function model_link($title, $model, $prefix = '')
{
    // 获取数据模型的复数蛇形命名
    $model_name = model_plural_name($model);

    // 初始化前缀
    $prefix = $prefix ? "/$prefix/" : '/';

    // 使用站点 URL 拼接全量 URL
    $url = config('app.url') . $prefix . $model_name . '/' .$model->id;

    // 拼接 HTML A 标签，并返回
    return '<a href="' . $url . '" target="_blank">' . $title . '</a>';
}

function model_plural_name($model)
{
    // 从实例中获取完整类名
    $full_class_name = get_class($model);

    // 获取基础类名
    $class_name = class_basename($full_class_name);

    // 蛇形命名
    $snake_case_name = snake_case($class_name);

    // 获取字串的复数形式
    return str_plural($snake_case_name);
}

/**
 * 选择 Heroku 的数据库为 PostgreSQL
 *
 * @return void
 */
function get_db_config()
{
    if (getenv('IS_IN_HEROKU')) {
        $url = parse_url(getenv('DATABASE_URL'));

        return $db_config = [
            'connection' => 'pgsql',
            'host'       => $url['host'],
            'port'       => $url['port'],
            'database'   => substr($url['path'], 1),
            'username'   => $url['user'],
            'password'   => $url['pass']
        ];
    } else {
        return $db_config = [
            'connection' => env('DB_CONNECTION', 'mysql'),
            'host'       => env('DB_HOST', 'localhost'),
            'port'       => env('DB_PORT', '3306'),
            'database'   => env('DB_DATABASE', 'forge'),
            'username'   => env('DB_USERNAME', 'forge'),
            'password'   => env('DB_PASSWORD', '')
        ];
    }
}