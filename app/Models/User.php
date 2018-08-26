<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Auth;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasRoles;

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

    /**
     * 对后台上传的用户的密码进行加密的方法
     *
     * @param string $value 后台上传的未加密的用户密码
     * @return void
     */
    public function setPasswordAttribute($value)
    {
        // 如果值的长度等于 60， 认为已经做过加密处理
        if (strlen($value) !== 60) {
            // 对不等于 60 的情况进行加密处理
            $value = bcrypt($value);
        }
        $this->attributes['password'] = $value;
    }

    /**
     * 拼接后台上传的用户头像的 URL 的方法
     *
     * @param string $path 后台上传的头像的 URL 地址
     * @return void
     */
    public function setAvatarAttribute($path)
    {
        // 如果不是 'http' 开头，头像为后台上传，需要补全 URL
        if (! starts_with($path, ['http', 'https'])) {
            // 拼接完整的 URL
            $path = config('app.url') . '/uploads/images/avatars/' . $path;
        }
        $this->attributes['avatar'] = $path;
    }
}
