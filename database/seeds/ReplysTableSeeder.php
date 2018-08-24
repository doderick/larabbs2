<?php

use Illuminate\Database\Seeder;
use App\Models\Reply;
use App\Models\Topic;
use APP\Models\User;

class ReplysTableSeeder extends Seeder
{
    public function run()
    {
        // 获得所有的话题的 ID 数组
        $topic_ids = Topic::all()->pluck('id')->toArray();

        // 获得所有的用户的 ID 数组
        $user_ids = User::all()->pluck('id')->toArray();

        // 获得 Faker 实例
        $faker = app(Faker\Generator::class);

        $replys = factory(Reply::class)->times(1000)->make()->each(function ($reply, $index)
                    use ($topic_ids, $user_ids, $faker)
                    {
                        // 从话题的 ID 数组中随机取出一个
                        $reply->topic_id = $faker->randomElement($topic_ids);

                        // 从用户的 ID 数组中随机取出一个
                        $reply->user_id = $faker->randomElement($user_ids);

                    });

        // 将数据集合转换为数组，并插入到数据库中
        Reply::insert($replys->toArray());
    }

}

