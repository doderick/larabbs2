<?php

namespace App\Models;

class Reply extends Model
{
    // 限制可填充字段
    protected $fillable = [
        'content',
    ];

    /**
     * 处理回帖与用户之间的关联，一条回帖属于一个用户
     *
     * @return void
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * 处理回帖与帖子之间的关联，一条回帖属于一个帖子
     *
     * @return void
     */
    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }

    /**
     * 处理回帖与分类之间的关联，一条回帖属于一个分类
     *
     * @return void
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function scopeWithOrder($query, $order)
    {
        // 不同的排序规则，使用不同的排序逻辑处理
        switch ($order) {
            case 'recent':
                $query->recent();
                break;
            default:
                $query->recentReplied();
                break;
        }
        // 预防 N+1
        return $query->with('user', 'topic');
    }

    /**
     * 按照回帖时间倒序排列
     *
     * @param [type] $query 排序的查询语句
     * @return void
     */
    public function scopeRecent($query)
    {
        return $query->orderBy('created_at', 'desc');
    }
}
