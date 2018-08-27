<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Topic;
use App\Models\User;

class CategoriesController extends Controller
{
    /**
     * 根据分类显示话题的方法
     *
     * @param Category $category 分类的一个实例
     * @param Topic $topic       话题的一个实例
     * @param Request $request   http 请求
     * @param User $user         用户的一个实例
     * @return void
     */
    public function show(Category $category, Topic $topic, User $user, Request $request)
    {
        // 读取分类 ID 关联话题， 并分页
        $topics = $topic->withOrder($request->order)
                        ->where('category_id', $category->id)

                        ->paginate(20);

        // 活跃用户列表
        $active_users = $user->getActiveUsers();

        return view('topics.index', compact('topics', 'category', 'active_users'));
    }
}
