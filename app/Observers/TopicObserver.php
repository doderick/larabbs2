<?php

namespace App\Observers;

use App\Models\Topic;
use App\Handlers\BaiduTranslateHandler;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class TopicObserver
{
    public function creating(Topic $topic)
    {
        //
    }

    public function updating(Topic $topic)
    {
        //
    }

    /**
     * 话题保存时触发事件
     *
     * @param Topic $topic 触发事件的话题的实例
     * @return void
     */
    public function saving(Topic $topic)
    {
        // XSS 过滤
        $topic->body = clean($topic->body, 'user_topic_body');

        // 生成话题摘录
        $topic->excerpt = make_excerpt($topic->body);

        // 如果 slug 字段无内容，则使用翻译器对 title 进行翻译
        if (! $topic->slug) {
            $topic->slug = app(BaiduTranslateHandler::class)->translate($topic->title);
        }
    }
}