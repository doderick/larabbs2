<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Reply::class, function (Faker $faker) {
    // 随机获取一个月内的时间
    $time = $faker->dateTimeThisMonth();
    // 随机生成小段文字
    $content = $faker->sentence();

    return [
        'content'    => $content,
        'created_at' => $time,
        'updated_at' => $time,
    ];
});
