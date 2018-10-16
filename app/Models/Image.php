<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    // 设置可填充字段，图片类型，路径可填充
    protected $fillable = [
        'type', 'path',
    ];

    /**
     * 处理头像图片与用户之间的关联
     * 一张头像图片属于一个用户
     *
     * @return void
     */
    public function user()
    {
        return $this->blongsTo(User::class);
    }
}
