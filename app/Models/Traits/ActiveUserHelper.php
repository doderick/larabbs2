<?php

namespace App\Models\Traits;

use App\Models\Topic;
use App\Models\Reply;
use Carbon\Carbon;
use Cache;
use DB;


trait ActiveUserHelper
{
    // 用于存放临时用户数据
    protected $users = [];

    // 配置信息
    protected $topic_weight = 4; // 话题权重
    protected $reply_weight = 1; // 回复权重
    protected $pass_days    = 7; // 多少天内发表过内容
    protected $user_count   = 6; // 取出多少活跃用户

    // 缓存相关配置
    protected $cache_key = 'larabbs_active_users';
    protected $cache_expire_in_minutes = 65;

    /**
     * 取出活跃用户的方法
     *
     * @return void 活跃用户数据
     */
    public function getActiveUsers()
    {
        // 尝试从缓存中取出活跃用户数据，如果能取出，则直接返回数据
        // 如果未能取出，则调用函数取出活跃用户，同时进行缓存
        return Cache::remember($this->cache_key, $this->cache_expire_in_minutes, function() {
            return $this->calculateActiveUsers();
        });
    }

    /**
     * 取得活跃用户并进行缓存的方法
     *
     * @return void
     */
    public function calculateAndCacheActiveUsers()
    {
        // 取得活跃用户列表
        $active_users = $this->calculateActiveUsers();
        // 加以缓存
        $this->cacheActiveUsers($active_users);
    }

    /**
     * 获得活跃用户的方法
     *
     * @return void
     */
    public function calculateActiveUsers()
    {
        $this->calculateTopicScore();
        $this->CalculateReplyScore();

        // 按照得分进行排列
        $users = array_sort($this->users, function($user) {
            return $user['score'];
        });

        // 倒序排列，且保持数组的 KEY 不变
        $users = array_reverse($users, true);

        // 只取出设定的统计的用户数
        $users = array_slice($users, 0, $this->user_count, true);

        // 新建一个空集合
        $active_users = collect();

        foreach ($users as $user_id => $user) {
            // 查询用户是否存在
            $user = $this->find($user_id);

            // 如果用户存在
            if ($user) {
                // 将此用户放入集合的末尾
                $active_users->push($user);
            }
        }

        // 返回数据
        return $active_users;
    }

    /**
     * 计算话题得分的方法
     *
     * @return void
     */
    public function calculateTopicScore()
    {
        // 取出在限定时间范围内发表过话题的用户，同时取出发表的数量
        $topic_users = Topic::query()->select(DB::raw('user_id, count(*) as topic_count'))
                                        ->where('created_at', '>=', Carbon::now()->subDays($this->pass_days))
                                        ->groupBy('user_id')
                                        ->get();

        // 计算话题得分
        foreach ($topic_users as $value) {
            $this->users[$value->user_id]['score'] = $value->topic_count * $this->topic_weight;
        }
    }

    /**
     * 计算回复得分的方法
     *
     * @return void
     */
    public function calculateReplyScore()
    {
        // 取出在限定时间范围内发表过回复的用户，同时取出回复的数量
        $reply_users = Reply::query()->select(DB::raw('user_id, count(*) as reply_count'))
                                        ->where('created_at', '>=', Carbon::now()->subDays($this->pass_days))
                                        ->groupBy('user_id')
                                        ->get();

        // 计算回复得分
        foreach ($reply_users as $value) {
            $reply_score = $value->reply_count * $this->reply_weight;
            if (isset($this->users[$value->user_id])) {
                $this->users[$value->user_id]['score'] += $reply_score;
            } else {
                $this->users[$value->user_id]['score'] = $reply_score;
            }
        }
    }

    /**
     * 缓存数据的方法
     *
     * @param array $active_users 活跃用户的数据集合
     * @return void
     */
    private function cacheActiveUsers($active_users)
    {
        Cache::put($this->cache_key, $active_users, $this->cache_expire_in_minutes);
    }
}