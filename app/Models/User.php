<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

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
}
