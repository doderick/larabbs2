<?php

namespace App\Observers;

use App\Models\Link;
use Cache;

class LinkObserver
{
    // 在保存时清空缓存中的数据
    public function saved(Link $link)
    {
        Cache::forget($link->cache_key);
    }
}