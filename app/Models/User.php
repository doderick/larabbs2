<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Auth;

class User extends Authenticatable
{
    use Notifiable {
        notify as protected laravelNotify;
    }
    public function notify($instance)
    {
        // 如果要通知的人是作者本人，则不进行通知
        if ($this->id === Auth::id()) {
            return;
        }
        // 每次调用 $user->notify() 时，notification_count 字段自动 +1
        $this->increment('notification_count');
        $this->laravelNotify($instance);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'avatar', 'introduction',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * 处理用户和话题之间的关联，一个用户可以拥有多个话题
     *
     * @return void
     */
    public function topics()
    {
        return $this->hasMany(Topic::class);
    }

    /**
     * 处理用户和回复之间的关联，一个用户可以拥有多条回复
     *
     * @return void
     */
    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    /**
     * 用户权限认证的方法
     *
     * @param [type] $model 需要进行认证的模型
     * @return boolean
     */
    public function isAuthorOf($model)
    {
        return $this->id === $model->user_id;
    }

    /**
     * 清空未读消息的方法
     *
     * @return void
     */
    public function markAsRead()
    {
        $this->notification_count = 0;
        $this->save();
        $this->unreadNotifications->markAsRead();
    }
}
