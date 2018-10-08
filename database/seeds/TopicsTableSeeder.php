<?php

use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\Topic;
use App\Models\Category;

class TopicsTableSeeder extends Seeder
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

        // 取出所有分类 id ，放入数组中
        $category_ids = Category::all()->pluck('id')->toArray();

        // 获取 Faker 实例
        $faker = app(Faker\Generator::class);

        $topics = factory(Topic::class)
                        ->times(100)
                        ->make()
                        ->each(function($topic, $index)
                            use($user_ids, $category_ids, $faker)
        {
            // 从用户 id 数组中随机取出一个作为帖子的作者 id
            $topic->user_id = $faker->randomElement($user_ids);

            // 从分类 id 数组中随机取出一个作为帖子的分类 id
            $topic->category_id = $faker->randomElement($category_ids);
        });

        // 将数据集合转换为数组，并插入数据库中
        Topic::insert($topics->toArray());
    }
}
