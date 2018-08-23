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

    /**
     * 依据不同的排序方式，选择不同数据读取逻辑的方法
     *
     * @param [type] $query 数据库读取语句
     * @param [type] $order 排序方式
     * @return void
     */
    public function scopeWithOrder($query, $order)
    {
        switch ($order) {
            case 'recent' :
                $query->recent();
                break;

            default :
                $query->recentReplied();
                break;
        }
        // N+1 的解决方案
        return $query->with('user', 'category');
    }

    /**
     * 按创建时间排序
     *
     * @param [type] $query 数据库读取语句
     * @return void
     */
    public function scopeRecent($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    /**
     * 按最新回复时间排序
     *
     * @param [type] $query 数据库读取语句
     * @return void
     */
    public function scopeRecentReplied($query)
    {
        // 当有新回复发生时，该时间戳将会被更新
        return $query->orderBy('updated_at', 'desc');
    }
}
