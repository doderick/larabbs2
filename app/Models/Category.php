<?php

namespace App\Models;

class Category extends Model
{
    // 设置允许修改的字段
    protected $fillable = [
        'name', 'description',
    ];

    /**
     * 处理分类和帖子之间的关联，一个分类下可以拥有多条帖子
     *
     * @return void
     */
    public function topics()
    {
        return $this->hasMany(Topic::class);
    }

    /**
     * 处理分类和回帖之间的关联，一个分类下可以拥有多条回帖
     *
     * @return void
     */
    public function replies()
    {
        return $this->hasMany(Reply::class);
    }
}
