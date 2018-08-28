<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cache;

class Link extends Model
{
    // 设置允许填充的字段
    protected $fillable = [
        'title', 'link',
    ];

    public $cache_key = 'larabbs2_links';
    protected $cache_expire_in_minutes = 1440;

    /**
     * 取出缓存中的资源推荐链接的方法
     *
     * @return void 资源推荐链接
     */
    public function getRecommendLinks()
    {
        // 尝试从缓存中取出资源推荐链接，如果未能取出，则调用函数取出数据库中的数据，并进行缓存
        return Cache::remember($this->cache_key, $this->cache_expire_in_minutes, function(){
            return $this->all();
        });
    }
}
