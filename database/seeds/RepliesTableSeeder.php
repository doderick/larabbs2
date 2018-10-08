<?php

use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\Topic;
use App\Models\Reply;

class RepliesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 取出所有用户的 id ，放入数组中
        $user_ids = User::all()->pluck('id')->toArray();

        // 取出所有帖子 id ，放入数组中
        $topic_ids = Topic::all()->pluck('id')->toArray();

        // 获取 Faker 实例
        $faker = app(Faker\Generator::class);

        $replies = factory(Reply::class)
                        ->times(1000)
                        ->make()
                        ->each(function($reply, $index)
                            use($user_ids, $topic_ids, $faker)
        {
            // 从用户 id 数组中随机取出一个作为帖子的作者 id
            $reply->user_id = $faker->randomElement($user_ids);

            // 从帖子 id 数组中随机取出一个作为帖子的分类 id
            $reply->topic_id = $faker->randomElement($topic_ids);
        });

        // 将数据集合转换为数组，并插入到数据库中
        Reply::insert($replies->toArray());
    }
}
