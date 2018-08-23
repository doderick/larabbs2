<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Topic::class, function (Faker $faker) {

    // 生成随机小段落，用来充当标题和摘要
    $sentence = $faker->sentence();

    // 随机获取一个月内的时间作为更改时间，创建时间不晚于更改时间
    $updated_at = $faker->dateTimeThisMonth();
    $created_at = $faker->dateTimeThisMonth($updated_at);

    return [
        'title'      => $sentence,
        'body'       => $faker->text(),
        'excerpt'    => $sentence,
        'created_at' => $created_at,
        'updated_at' => $updated_at,
    ];
});
