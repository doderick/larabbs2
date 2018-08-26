<?php

use App\Models\User;

return [
    // 页面标题
    'title' => '用户',

    // 模型单数，用作页面『新建 $single』
    'single' => '用户',

    // 数据模型，用作数据的 CRUD
    'model' => User::class,

    // 设置访问权限，返回布尔值， true 权限验证通过， false 权限验证不通过，并隐藏入口
    'permission' => function() {
        return Auth::user()->can('manage_users');
    },

    // 字段负责渲染『数据表格』，由无数的『列』组成
    'columns' => [
        // 列标识，读取模型里对应的属性的值
        'id',

        'avatar' => [
            // 数据表里的名称，默认会使用『列标识』
            'title' => '头像',

            // 默认情况下会直接输出数据， 也可以使用 output 选项来定制输出的内容
            'output' => function ($avatar, $model) {
                return empty($avatar) ? 'N/A' : '<img src="' . $avatar . '" width="40">';
            },

            // 是否允许排序
            'sortable' => false,
        ],

        'name' => [
            'title' => '用户名',
            'output' => function ($name, $model) {
                return '<a href="/users/' . $model->id . '" target="_blank">' . $name . '</a>';
            },
            'sortable' => false,
        ],

        'email' => [
            'title' => '邮箱',
        ],

        'operation' => [
            'title' => '管理',
            'sortable' => false,
        ],
    ],

    // 『模型表单』设置项
    'edit_fields' => [
        'name' => [
            'title' => '用户名',
        ],
        'email' => [
            'title' => '邮箱',
        ],
        'password' => [
            'title' => '密码',

            // <input type="password">
            'type' => 'password',
        ],
        'avatar' => [
            'title' => '用户头像',

            // <input type="image"
            'type' => 'image',

            // 图片上传必须设置图片存放路径
            'location' => public_path() . '/uploads/images/avatars/',
        ],
        'roles' => [
            'title' => '用户角色',

            // 制定数据的类型为关联数据
            'type' => 'relationship',

            // 关联模型的字段，用来做关联显示
            'name_field' => 'name',
        ],
    ],

    // 『数据过滤』设置
    'filters' => [
        'id' => [
            // 过滤表单条目显示名称
            'title' => '用户 ID',
        ],
        'name' => [
            'title' => '用户名',
        ],
        'email' => [
            'title' => '邮箱',
        ],
    ],

];