<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 获取 Faker 实例
        $faker = app(Faker\Generator::class);

        // 头像假数据
        // 头像假数据
        $avatars = [
            'https://fsdhubcdn.phphub.org/uploads/images/201710/14/1/s5ehp11z6s.png?imageView2/1/w/200/h/200',
            'https://fsdhubcdn.phphub.org/uploads/images/201710/14/1/Lhd1SHqu86.png?imageView2/1/w/200/h/200',
            'https://fsdhubcdn.phphub.org/uploads/images/201710/14/1/LOnMrqbHJn.png?imageView2/1/w/200/h/200',
            'https://fsdhubcdn.phphub.org/uploads/images/201710/14/1/xAuDMxteQy.png?imageView2/1/w/200/h/200',
            'https://fsdhubcdn.phphub.org/uploads/images/201710/14/1/ZqM7iaP4CR.png?imageView2/1/w/200/h/200',
            'https://fsdhubcdn.phphub.org/uploads/images/201710/14/1/NDnzMutoxX.png?imageView2/1/w/200/h/200',
        ];

        // 生成数据集合
        $users = factory(User::class)->times(10)->make()->each(function ($user, $index) use ($faker, $avatars) {
                // 从头像数组中随机取出一个并赋值
                $user->avatar = $faker->randomElement($avatars);
        });

        // 隐藏域可见，并将数据集合转换为数组
        $user_array = $users->makeVisible(['password', 'remember_token'])->toArray();

        // 插入到数据库中
        User::insert($user_array);

        // 单独处理 id = 1 和 id = 2 的两个用户
        $user = User::find(1);
        $user->name     = 'doderick';
        $user->email    = 'doderick@outlook.com';
        $user->password = bcrypt('111111');
        $user->avatar   = "http://larabbs2.test/uploads/image/avatars/201808/23/1_1534954556_s5D9KI0vZj.png";
        $user->save();

        $user = User::find(2);
        $user->name     = 'JJ-711';
        $user->email    = 'jiajun5427@163.com';
        $user->password = bcrypt('222222');
        $user->avatar   = "http://larabbs2.test/uploads/image/avatars/201808/23/2_1534992175_QL9rySjAdi.png";
        $user->save();
    }
}
