<?php

namespace App\Models;

class Reply extends Model
{
    // 限制填充字段：content
    protected $fillable = [
        'content',
    ];

    /**
     * 处理回复和话题之间的关联，一条回复属于一个话题
     *
     * @return void
     */
    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }

    /**
     * 处理回复和用户之间的关联，一条回复属于一个用户
     *
     * @return void
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
