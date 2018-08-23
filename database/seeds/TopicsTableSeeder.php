<?php

use Illuminate\Database\Seeder;
use App\Models\Topic;
use App\Models\Category;
use App\Models\User;

class TopicsTableSeeder extends Seeder
{
    public function run()
    {
        // 取得所有用户的 id 数组
        $user_ids = User::all()->pluck('id')->toArray();

        // 取得所有分类的 id 数组
        $category_ids = Category::all()->pluck('id')->toArray();

        // 取得 Faker 实例
        $faker = app(Faker\Generator::class);

        $topics = factory(Topic::class)->times(100)->make()->each(function ($topic, $index) use ($user_ids, $category_ids, $faker)
        {
            // 随机取出一个用户 id 并赋值
            $topic->user_id = $faker->randomElement($user_ids);

            // 随机取出一个分类 id 并赋值
            $topic->category_id = $faker->randomElement($category_ids);
        });

        // 将数据集合转换为数组，并写入到数据库中
        Topic::insert($topics->toArray());
    }

}

