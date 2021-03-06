<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
        \App\Models\User::class => \App\Policies\UserPolicy::class,
        \App\Models\Topic::class => \App\Policies\TopicPolicy::class,
        \App\Models\Reply::class => \App\Policies\ReplyPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // 判断 Horizon工具 的访问权限
        // 仅站长可以访问
            \Horizon::auth(function ($request) {
                return \Auth::user()->hasRole('Founder');
            });
    }
}
