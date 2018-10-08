<?php

namespace App\Observers;

use Cache;
use App\Models\Link;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class LinkObserver
{
    /**
     * Link模型 保存时触发的动作
     *
     * @param Link $link
     * @return void
     */
    public function saved(Link $link)
    {
        Cache::forget($link->cache_key);
    }
}