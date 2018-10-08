<?php

use App\Models\User;

return [
    'title'       => '用户',
    'single'      => '用户',
    'model'       => User::class,
    'permission'  => function()
    {
        return Auth::user()->can('manage_users');
    },
    'columns'     => [
        'id' => [
            'title' => 'ID',
        ],
        'avatar' => [
            'title'    => '头像',
            'sortable' => false,
            'output'   => function($avatar, $model)
            {
                return empty($avatar) ? 'N/A' : '<img src="' . $avatar . '" style="width: 40px;">';
            }
        ],
        'name' => [
            'title'  => '用户名',
            'output' => function($name, $model)
            {
                return '<a href="/users/' . $model->id . '" target="_blank">' . $name . '</a>';
            }
        ],
        'email' => [
            'title'    => '邮箱地址',
            'sortable' => false,
            'output'   => function($email, $model)
            {
                return '<a href="mailto:' . $model->email . '">' . $email . '</a>';
            }
        ],
        'operation' => [
            'title'    => '管理',
            'sortable' => false,
        ],
    ],
    'edit_fields' => [
        'name'     => [
            'title' => '用户名',
        ],
        'email'    => [
            'title' => '邮箱地址',
        ],
        'password' => [
            'title' => '密码',
            'type'  => 'password',
        ],
        'avatar'   => [
            'title'    => '用户头像',
            'type'     => 'image',
            'location' => public_path() . '/uploads/images/avatars/',
        ],
        'roles'    => [
            'title'      => '用户角色',
            'type'       => 'relationship',
            'name_field' => 'name',
        ],
    ],
    'filters'     => [
        'id'    => [
            'title' => '用户 ID',
        ],
        'name'  => [
            'title' => '用户名',
        ],
        'email' => [
            'title' => '邮箱地址',
        ],
    ],
];