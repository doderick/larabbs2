<?php

use App\Models\Topic;
use App\Models\Category;

return [
    'title'  => '话题',
    'single' => '话题',
    'model'  => Topic::class,

    'columns' => [
        'id'          => [
            'title' => 'ID'
        ],
        'category'    => [
            'title'    => '分类',
            'sortable' => false,
            'output'   => function($value, $model)
            {
                return model_admin_link($model->category->name, $model->category);
            }
        ],
        'title'       => [
            'title'    => '话题',
            'sortable' => false,
            'output'   => function($value, $model)
            {
                return '<div style="max-width:400px">' . model_link($value, $model) . '</div>';
            },
        ],
        'user'        => [
            'title'    => '作者',
            'sortable' => false,
            'output'   => function($value, $model)
            {
                $avatar = $model->user->avatar;
                $value  = empty($avatar) ? 'N/A' : '<img src="' . $avatar . '" style="width:22px;height:22px"> ' . $model->user->name;
                return model_link($value, $model->user);
            },
        ],
        'reply_count' => [
            'title' => '回复数',
        ],
        'operation'   => [
            'title'    => '管理',
            'sortable' => false,
        ],
    ],

    'edit_fields' => [
        'title'       => [
            'title' => '标题',
        ],
        'user'        => [
            'title'      => '作者',
            'type'       => 'relationship',
            'name_field' => 'name',

            // 自动补全
            'autocomplete' => true,

            // 自动补全的搜索字段
            'search_fields' => ["CONCAT(id, ' ', name)"],

            // 自动补全排序
            'options_sort_field' => 'id',
        ],
        'category'    => [
            'title'              => '分类',
            'type'               => 'relationship',
            'name_field'         => 'name',
            'search_fields'      => ["CONCAT(id, ' ', name)"],
            'options_sort_field' => 'id',
        ],
        'reply_count' => [
            'title' => '回复数',
        ],
        'view_count'  => [
            'title' => '查看数'
        ],
    ],

    'filters' => [
        'id'       => [
            'title' => '话题 ID',
        ],
        'user'     => [
            'title'                 => '用户',
            'type'                  => 'relationship',
            'name_field'            => 'name',
            'autocomplete'          => true,
            'search_fields'         => ["CONCAT(id, ' ', name)"],
            'operations_sort_field' => 'id',
        ],
        'category' => [
            'title'                 => '分类',
            'type'                  => 'relationship',
            'name_field'            => 'name',
            'search_fields'         => ["CONCAT(id, ' ', name)"],
            'operations_sort_field' => 'id',
        ],
    ],

    'rules' => [
        'title' => 'required',
    ],
    'messages' => [
        'title.required' => '请填写标题',
    ],
];