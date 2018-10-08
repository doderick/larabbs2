<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SeedCategoriesData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 填充 categories
        $categories = [
            [
                'name'        => '分享',
                'description' => '分享创造，分享发现',
            ],
            [
                'name'        => '问答',
                'description' => '互帮互助，共同进步',
            ],
            [
                'name'        => '教程',
                'description' => '开发技巧，推荐拓展包等',
            ],
            [
                'name'        => '闲聊',
                'description' => '喝喝茶，聊聊天',
            ],
            [
                'name'        => '公告',
                'description' => '社区公告',
            ],
        ];

        DB::table('categories')->insert($categories);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('categories')->truncate();
    }
}