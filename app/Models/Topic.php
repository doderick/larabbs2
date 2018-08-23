<?php

namespace App\Models;

class Topic extends Model
{
    protected $fillable = ['title', 'body', 'user_id', 'category_id', 'reply_count', 'view_count', 'last_reply_user_id', 'order', 'excerpt', 'slug'];

    /**
     * 处理话题和用户之间的关联，一个话题属于一个用户
     *
     * @return void
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * 处理话题和分类之间的关联，一个话题属于一个分类
     *
     * @return void
     */
    public function Category()
    {
        return $this->belongsTo(Category::class);
    }
}
