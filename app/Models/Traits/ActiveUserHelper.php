<?php

namespace App\Models\Traits;

use DB;
use Cache;
use Carbon\Carbon;
use App\Models\Topic;
use App\Models\Reply;

trait ActiveUserHelper
{
    // 存放临时用户数据
    protected $users = [];

    // 配置信息
    protected $topic_weight = 4;    // 帖子权重
    protected $reply_weight = 1;    // 回帖权重
    protected $pass_days    = 7;    // 统计的时间段
    protected $user_count   = 6;    // 统计的用户数

    // 缓存相关配置
    protected $cache_key = 'larabbs_active_users';
    protected $cache_expire_in_minutes = 65;

    /**
     * 取出活跃用户的方法
     *
     * @return void
     */
    public function getActiveUsers()
    {
        // 尝试从缓存中取出活跃用户数据，如果能取出，直接返回数据库
        // 如果无法取出，则调用方法取出活跃用户，同时进行缓存
        return Cache::remember($this->cache_key, $this->cache_expire_in_minutes, function() {
            return $this->calculateActiveUsers();
        });
    }

    /**
     * 取出活跃用户并进行缓存的方法
     *
     * @return void
     */
    public function calculateAndCacheActiveUsers()
    {
        // 取出活跃用户列表
        $active_users = $this->calculateActiveUsers();
        // 进行缓存
        $this->cacheActiveUsers($active_users);
    }

    /**
     * 计算用户发帖得分的方法
     * 取出在限定时间内发过帖子的用户，同时取出发表的帖子数
     *
     * @return void
     */
    public function calculateTopicScore()
    {
        $topic_users = Topic::query()->select(DB::raw('user_id, count(*) as topic_count'))
                                        ->where('created_at', '>=', Carbon::now()->subDays($this->pass_days))
                                        ->groupBy('user_id')
                                        ->get();
        // 计算发帖得分
        foreach ($topic_users as $topic_user) {
            $this->users[$topic_user->user_id]['score'] = $topic_user->topic_count * $this->topic_weight;
        }
    }

    /**
     * 计算用户发帖得分的方法
     * 取出在限定时间内发过帖子的用户，同时取出发表的帖子数
     *
     * @return void
     */
    public function calculateReplyScore()
    {
        $reply_users = Reply::query()->select(DB::raw('user_id, count(*) as reply_count'))
                                        ->where('created_at', '>=', Carbon::now()->subDays($this->pass_days))
                                        ->groupBy('user_id')
                                        ->get();
        // 计算回帖得分
        foreach ($reply_users as $reply_user) {
            $reply_score = $reply_user->reply_count * $this->reply_weight;
            if (isset($this->users[$reply_user->user_id])) {
                $this->users[$reply_user->user_id]['score'] += $reply_score;
            } else {
                $this->users[$reply_user->user_id]['score'] = $reply_score;
            }
        }
    }

    /**
     * 计算活跃用户的方法
     *
     * @return void
     */
    public function calculateActiveUsers()
    {
        $this->calculateTopicScore();
        $this->calculateReplyScore();

        // 按照得分进行排序
        $users = array_sort($this->users, function($user) {
            return $user['score'];
        });

        // 倒序排列，高分在前，保持数组的键不变
        $users = array_reverse($users, true);

        // 取出限定的用户数
        $users = array_slice($users, 0, $this->user_count, true);

        // 新建一个空集合
        $active_users = collect();
        foreach ($users as $user_id => $user) {
            // 找寻下是否可以找到用户
            $user = $this->find($user_id);
            // 如果在数据库中存在该用户，则将该用户放入集合的末尾
            if ($user) {
                $active_users->push($user);
            }
        }
        // 返回数据
        return $active_users;
    }

    /**
     * 缓存数据的方法
     *
     * @param array $active_users
     * @return void
     */
    private function cacheActiveUsers($active_users)
    {
        Cache::put($this->cache_key, $active_users, $this->cache_expire_in_minutes);
    }
}