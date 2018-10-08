<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Topic::class, function (Faker $faker) {
    $sentence = $faker->sentence();
    $text     = $faker->text();

    // 随机获取一个月以内的时间，用于填充 created_at 和 updated_at
    // created_at 不晚于 updated_at
    $updated_at = $faker->dateTimeThisMonth();
    $created_at = $faker->dateTimeThisMonth($updated_at);

    return [
        'title'      => $sentence,
        'body'       => $text,
        'excerpt'    => $sentence,
        'created_at' => $created_at,
        'updated_at' => $updated_at,
    ];
});
