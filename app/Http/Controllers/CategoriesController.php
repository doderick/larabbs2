<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Link;
use App\Models\User;
use App\Models\Topic;
use App\Models\Category;

class CategoriesController extends Controller
{
    /**
     * 显示帖子分类的方法
     *
     * @param Request $request
     * @param Category $category
     * @param Topic $topic
     * @param User $user
     * @param Link $link
     * @return void
     */
    public function show(Request $request, Category $category, Topic $topic, User $user, Link $link)
    {
        // 读取分类 id 相关的帖子，并进行分页处理
        $topics = $topic->withOrder($request->order)
                        ->where('category_id', $category->id)
                        ->paginate(20);
        $active_users = $user->getActiveUsers();
        $recommend_links = $link->getRecommendLinks();

        return view('topics.index', compact('topics', 'category', 'active_users', 'recommend_links'));
    }
}
