<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Auth;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable {
        notify as protected laravelNotify;
    }

    use HasRoles;
    use Traits\ActiveUserHelper;
    use Traits\LastActivedAtHelper;

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
     * 处理用户和帖子之间的关联，一个用户可以拥有多条帖子
     *
     * @return void
     */
    public function topics()
    {
        return $this->hasMany(Topic::class);
    }

    /**
     * 处理用户和帖子之间的关联，一个用户可以拥有多条回帖
     *
     * @return void
     */
    public function Replies()
    {
        return $this->hasMany(Reply::class);
    }

    /**
     * 用户权限认证的方法
     *
     * @param [type] $model 需要进行权限验证的模型
     * @return boolean
     */
    public function isAuthorOf($model)
    {
        return $this->id === $model->user_id;
    }

    /**
     * 进行消息通知的方法
     *
     * @param [type] $instance
     * @return void
     */
    public function notify($instance)
    {
        // 区分通知对象，如果是当前用户，则不进行通知
        if ($this->id === Auth::id()) {
            return;
        }
        $this->increment('notification_count');
        $this->laravelNotify($instance);
    }

    /**
     * 将通知消息标记为已读，同时进行清空操作的方法
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
     * 对数据的 password字段 修改时进行加密
     *
     * @param [type] $value 传递过来的密码值
     * @return void
     */
    public function setPasswordAttribute($value)
    {
        // 判断传递过来的密码值的长度，如果等于 60 ，则认为已做加密处理
        // 不等于 60，进行加密
        if (strlen($value) !== 60) {
            $value = bcrypt($value);
        }
        $this->attributes['password'] = $value;
    }

    /**
     * 对数据的 avatar字段 修改时进行完整地址拼接
     *
     * @param [type] $path
     * @return void
     */
    public function setAvatarAttribute($path)
    {
        // 如果图片地址以 http 或 https 开头，则图片地址为完整地址，无需拼接
        // 如果并非以 http 或 https 开头，则需进行拼接
        if (! starts_with($path, ['http', 'https'])) {
            $path = config('app.url') . '/uploads/images/avatars/' . $path;
        }
        $this->attributes['avatar'] = $path;
    }

    /**
     * 处理粉丝和用户之间的关联
     *
     * @return void
     */
    public function followers()
    {
        return $this->belongsToMany(User::class, 'followers', 'user_id', 'follower_id');
    }

    /**
     * 处理关注的人和用户之间的关联
     *
     * @return void
     */
    public function followings()
    {
        return $this->belongsToMany(User::class, 'followers', 'follower_id', 'user_id')
                        ->withTimestamps();
    }

    /**
     * 用户进行关注的方法
     *
     * @param array|integer $user_ids 需要关注的用户的id
     * @return void
     */
    public function follow($user_ids)
    {
        if (! is_array($user_ids)) {
            $user_ids = compact('user_ids');
        }
        $this->followings()->sync($user_ids, false);
    }

    /**
     * 用户取消关注的方法
     *
     * @param array|integer $user_ids 需要取消关注的用户的id
     * @return void
     */
    public function unfollow($user_ids)
    {
        if (! is_array($user_ids)) {
            $user_ids = compact('user_ids');
        }
        $this->followings()->detach($user_ids);
    }

    /**
     * 判断某个用户是否被当前用户所关注
     *
     * @param integer $user_id 需要进行判断的用户的id
     * @return boolean
     */
    public function isFollowing($user_id)
    {
        return $this->followings->contains($user_id);
    }
}
