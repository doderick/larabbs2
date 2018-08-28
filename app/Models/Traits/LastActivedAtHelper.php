<?php

namespace App\Models\Traits;

use Redis;
use Carbon\Carbon;

trait LastActivedAtHelper
{
    // 缓存相关
    protected $hash_prefix  = 'larabbs2_last_actived_at_';
    protected $field_prefix = 'user_';

    /**
     * 将用户最后登录时间记录到 Redis 中的方法
     *
     * @return void
     */
    public function recordLastActivedAt()
    {
        // 获取今天 Redis 哈希表的名称
        $hash = $this->getHashFormDateString(Carbon::now()->toDateString());

        // 获取字段名称
        $field = $this->getHashField();

        // 获得当前时间
        $now = Carbon::now()->toDateTimeString();

        // 数据写人 Redis ，如果字段存在则会被更新
        Redis::hSet($hash, $field, $now);
    }

    /**
     * 从 Redis 中取出用户最后登录时间的方法
     *
     * @return void
     */
    public function getLastActivedAtAttribute($value)
    {
        // 获取进店的 Redis 哈希表名称
        $hash = $this->getHashFormDateString(Carbon::now()->toDateString());

        // 命名字段
        $field = $this->getHashField();

        // 选择 Redis 中的数据，如果不存在，则使用数据库中的数据
        $datetime = Redis::hGet($hash, $field) ?: $value;

        // 如果存在的话，返回时间对应的 Carbon 实例
        if ($datetime) {
            return new Carbon($datetime);
        } else {
            // 否则使用用户注册时间
            return $this->created_at;
        }
    }

    /**
     * 将 Redis 中记录的用户最后登录时间同步到数据库的方法
     *
     * @return void
     */
    public function syncUserActivedAt()
    {
        // 获取昨天的 Redis 哈希表名称
        $hash = $this->getHashFormDateString(Carbon::yesterday()->toDateString());

        // 从 Redis 中获取所有哈希表里的数据
        $dates = Redis::hGetAll($hash);

        // 遍历，同步到数据库中
        foreach ($dates as $user_id => $actived_at) {
            // 将  user_id 转换为对应的纯数字
            $user_id = str_replace($this->field_prefix, '', $user_id);

            // 只有当用户存在时才更新到数据库中
            if ($user = $this->find($user_id)) {
                $user->last_actived_at = $actived_at;
                $user->save();
            }
        }
        // 如果已经完成同步了，则可以删除 Redis 哈希表
        Redis::del($hash);
    }

    /**
     * Redis 哈希表的命名
     *
     * @param string $date
     * @return string Redis 哈希表的名称
     */
    public function getHashFormDateString($date)
    {
        return $this->hash_prefix . $date;
    }

    /**
     * 命名字段
     *
     * @return string 字段命名
     */
    public function getHashField()
    {
        return $this->field_prefix . $this->id;
    }
}