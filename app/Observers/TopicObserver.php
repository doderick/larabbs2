<?php

namespace App\Observers;

use App\Models\Topic;
use App\Jobs\TranslateSlug;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class TopicObserver
{
    public function creating(Topic $topic)
    {
        $this->checkTopicCountInUsersTable($topic);
    }

    public function created(Topic $topic)
    {
        $topic->user->increment('topic_count', 1);
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
    }

    public function saved(Topic $topic)
    {
        // 如果 slug 字段无内容，则使用翻译器对 title 进行翻译
        if (! $topic->slug) {
            // $topic->slug = app(BaiduTranslateHandler::class)->translate($topic->title);
            // 推送至队列
            dispatch(new TranslateSlug($topic));
        }
    }

    public function deleting(Topic $topic)
    {
        $this->checkTopicCountInUsersTable($topic);
    }

    public function deleted(Topic $topic)
    {
        // users 表中用户话题计数 -1
        $topic->user->decrement('topic_count', 1);
    }

    private function checkTopicCountInUsersTable(Topic $topic)
    {
        if (! $topic->user->topic_count > 0) {
            $topic->user->topic_count =  $topic->all()->where('user_id', $topic->user->id)->count();
            $topic->user->save();
        }
    }
}