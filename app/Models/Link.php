<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Cache;

class Link extends Model
{
    // 设置可填充字段
    protected $fillable = [
        'title', 'link',
    ];

    public $cache_key = 'larabbs_links';
    protected $cache_expire_in_minutes = 1440;

    /**
     * 取出推荐资源的方法
     *
     * @return void
     */
    public function getRecommendLinks()
    {
        // 尝试从缓存中取出推荐资源数据，如果取到。直接返回数据
        // 如果无法取得数据，则使用 all() 方法取出数据库中的数据，并写入缓存
        return Cache::remember($this->cache_key, $this->cache_expire_in_minutes, function() {
            return $this->where('id', '>', 0)->orderBy('id', 'desc')->limit(6)->get();
        });
    }
}
