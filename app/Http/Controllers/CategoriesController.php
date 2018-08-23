<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Topic;

class CategoriesController extends Controller
{
    /**
     * 根据分类显示话题的方法
     *
     * @param Category $category 分类的一个实例
     * @return void
     */
    public function show(Category $category, Topic $topic, Request $request)
    {
        // 读取分类 ID 关联话题， 并分页
        $topics = $topic->withOrder($request->order)
                        ->where('category_id', $category->id)

                        ->paginate(20);

        return view('topics.index', compact('topics', 'category'));
    }
}
