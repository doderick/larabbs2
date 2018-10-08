<?php

namespace App\Observers;

use App\Models\Topic;
use App\Jobs\TranslateSlug;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class TopicObserver
{
    /**
     * Topic模型 删除时触发的动作
     *
     * @param Topic $topic
     * @return void
     */
    public function creating(Topic $topic)
    {
        $this->checkTopicCountInCategoriesTable($topic);
        $this->checkTopicCountInUsersTable($topic);
    }

    /**
     * Topic模型 创建后触发的动作
     *
     * @param Topic $topic
     * @return void
     */
    public function created(Topic $topic)
    {
        // users 表中用户帖子数 +1
        $topic->user->increment('topic_count', 1);

        // categories 表中用户帖子数 +1
        $topic->category->increment('topic_count', 1);
    }

    /**
     * Topic模型 保存时触发的动作
     *
     * @param Topic $topic
     * @return void
     */
    public function saving(Topic $topic)
    {
        // XSS 过滤
        $topic->body = clean($topic->body, 'user_topic_body');

        // 生成摘录
        $topic->excerpt = make_excerpt($topic->body);
    }

    /**
     * Topic模型 保存后触发的动作
     *
     * @param Topic $topic
     * @return void
     */
    public function saved(Topic $topic)
    {
        // 翻译并保存 slug 字段
        if (! $topic->slug) {
            // $topic->slug = app(BaiduTranslateHandler::class)->translate($topic->title);

            // 推送到队列中
            dispatch(new TranslateSlug($topic));
        }
    }

    /**
     * Topic模型 删除时触发的动作
     *
     * @param Topic $topic
     * @return void
     */
    public function deleting(Topic $topic)
    {
        $this->checkTopicCountInCategoriesTable($topic);
        $this->checkTopicCountInUsersTable($topic);
    }

    /**
     * Topic模型 删除后触发的动作
     *
     * @param Topic $topic
     * @return void
     */
    public function deleted(Topic $topic)
    {
         // users 表中用户帖子数 +1
         $topic->user->decrement('topic_count', 1);

         // categories 表中用户帖子数 +1
         $topic->category->decrement('topic_count', 1);

         // 删除帖子的同时，删除帖子下的所有回帖
         \DB::table('replies')->where('topic_id', $topic->id)->delete();
    }

    /**
     * 查询 Categories表 中帖子计数并进行更新的方法
     * 此方法仅限填充伪数据后测试用，不能使用在生产环境中
     *
     * @param Topic $topic
     * @return void
     */
    private function checkTopicCountInCategoriesTable(Topic $topic)
    {
        if (! $topic->category->topic_count > 0) {
            $topic->category->topic_count =  $topic->all()->where('category_id', $topic->category->id)->count();
            $topic->category->save();
        }
    }

    /**
     * 查询 Users表 中帖子计数并进行更新的方法
     * 此方法仅限填充伪数据后测试用，不能使用在生产环境中
     *
     * @param Topic $topic
     * @return void
     */
    private function checkTopicCountInUsersTable(Topic $topic)
    {
        if (! $topic->user->topic_count > 0) {
            $topic->user->topic_count =  $topic->all()->where('user_id', $topic->user->id)->count();
            $topic->user->save();
        }
    }
}