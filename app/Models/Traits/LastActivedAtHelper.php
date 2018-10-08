<?php

namespace App\Models\Traits;

use Redis;
use Carbon\Carbon;

trait LastActivedAtHelper
{
    // 缓存相关配置
    protected $hash_prefix  = 'larabbs3_last_actived_at_';
    protected $field_prefix = 'user_';

    /**
     * 将用户最后登录时间记录到 Redis 中的方法
     *
     * @return void
     */
    public function recordLastActivedAt()
    {
        // 获取当天 Redis 哈希表的名称
        $hash = $this->getHashFormDataString(Carbon::now()->toDateString());
        // 获取字段名称
        $field = $this->getHashField();
        // 获得当前时间并转换为字符串
        $now = Carbon::now()->toDateTimeString();
        // 数据写入 Redis，如果字段存在，则会被更新
        Redis::hSet($hash, $field, $now);
    }

    /**
     * 取出用户最后登录时间的方法
     *
     * @param [type] $value
     * @return void
     */
    public function getLastActivedAtAttribute($value)
    {
        // 获取当天的 Redis 哈希表的名称
        $hash = $this->getHashFormDataString(Carbon::now()->toDateString());
        // 获取字段名称
        $field = $this->getHashField();
        // 使用 Redis 中的数据，如果数据不存在，则使用数据库中的数据
        $datetime = Redis::hGet($hash, $field) ?: $value;
        // 如果数据存在，返回对应的 Carbon 实例
        // 如果不存在，则使用用户注册时间
        if ($datetime) {
            return new Carbon($datetime);
        } else {
            return $this->created_at;
        }
    }

    /**
     * 将 Redis 哈希表中的数据同步至数据库中
     *
     * @return void
     */
    public function syncUserActivedAt()
    {
        // 获得前一天 Redis 哈希表的名称
        $hash = $this->getHashFormDataString(Carbon::yesterday()->toDateString());
        // 从 Redis 哈希表中取得数据
        $dates = Redis::hGetAll($hash);
        // 遍历数据，同步至数据库中
        foreach ($dates as $user_id => $actived_at) {
            // 将 user_id 转换为对应的纯数字
            $user_id = str_replace($this->field_prefix, '', $user_id);
            // 判断用户是否存在，如果存在，进行数据库更新
            if ($user = $this->find($user_id)) {
                $user->last_actived_at = $actived_at;
                $user->save();
            }
            // 同步完成之后，删除 Redis 哈希表
            Redis::del($hash);
        }
    }

    /**
     * 命名 Redis 哈希表
     *
     * @param string $date
     * @return string Redis 哈希表的名称
     */
    public function getHashFormDataString($date)
    {
        return $this->hash_prefix . $date;
    }

    /**
     * 命名字段
     *
     * @return string 字段的名称
     */
    public function getHashField()
    {
        return $this->field_prefix . $this->id;
    }
}