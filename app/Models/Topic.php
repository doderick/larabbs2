<?php

namespace App\Models;

class Topic extends Model
{
    use Traits\ViewCountHelper;

    // 设置允许填写的字段
    protected $fillable = [
        'title', 'body', 'category_id', 'excerpt', 'slug',
    ];

    /**
     * 处理帖子和用户之间的关联，一个帖子属于一个用户
     *
     * @return void
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * 处理帖子和用户之间的关联，一个帖子属于一个用户
     *
     * @return void
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * 处理帖子与回帖之间的关联，一个帖子可以拥有多条回帖
     *
     * @return void
     */
    public function replies()
    {
        return $this->hasMany(Reply::class);
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
        return $query->with('user', 'category');
    }

    /**
     * 按照发帖时间倒序排列
     *
     * @param [type] $query 排序的查询语句
     * @return void
     */
    public function scopeRecent($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    /**
     * 按回帖时间倒序排列
     *
     * @param [type] $query 排序的查询语句
     * @return void
     */
    public function scopeRecentReplied($query)
    {
        return $query->orderBy('updated_at', 'desc');
    }

    /**
     * 向路由传递帖子 id 及 slug 的方法
     *
     * @param array $params 允许附加 URL 参数的设定
     * @return void
     */
    public function link($params = [])
    {
        return route('topics.show', array_merge([$this->id, $this->slug], $params));
    }
}
