<?php

use App\Models\Topic;

return [
    'title'       => '帖子',
    'single'      => '帖子',
    'model'       => Topic::class,
    'columns'     => [
        'id'          => [
            'title' => 'ID',
        ],
        'category'    => [
            'title'    => '分类',
            'sortable' => false,
            'output'   => function($value, $model)
            {
                return model_admin_link($model->category->name, $model->category);
            },
        ],
        'title'       => [
            'title'    => '帖子',
            'sortable' => false,
            'output'   => function($value, $model)
            {
                return '<div style="max-width:400px;text-align:left;">' . model_link($value, $model) . '</div>';
            },
        ],
        'user'        => [
            'title'    => '作者',
            'sortable' => false,
            'output'   => function($value, $model)
            {
                $avatar = $model->user->avatar;
                $value  = empty($avatar) ? 'N/A' : '<div style="text-align:left"><img src="' . $avatar . '" style="width:22px">' . $model->user->name . '</div>';
                return model_link($value, $model->user);
            },
        ],
        'view_count'  => [
            'title' => '浏览数',
            'output' => function($value, $model) {
                return $model->visits()->count();
            }
        ],
        'reply_count' => [
            'title' => '回帖数',
        ],
        'vote_count'  => [
            'title' => '点赞数',
        ],
        'operation'   => [
            'title'    => '管理',
            'sortable' => false,
        ],
    ],
    'edit_fields' => [
        'title'       => [
            'title' => '帖子标题',
        ],
        'user'        => [
            'title'              => '作者',
            'type'               => 'relationship',
            'name_field'         => 'name',
            'autocomplete'       => true,
            'search_fields'      => ["concat(id, ' ', name)"],
            'options_sort_field' => 'id',
        ],
        'category'    => [
            'title'              => '分类',
            'type'               => 'relationship',
            'name_field'         => 'name',
            'autocomplete'       => true,
            'search_fields'      => ["concat(id, ' ', name)"],
            'options_sort_field' => 'id',
        ],
        'view_count'  => [
            'title' => '浏览数',
        ],
        'reply_count' => [
            'title' => '回帖数',
        ],
        'vote_count'  => [
            'title' => '点赞数',
        ],
    ],
    'filters'     => [
        'id'          => [
            'title' => '帖子 ID'
        ],
        'user'        => [
            'title'              => '用户',
            'type'               => 'relationship',
            'name_field'         => 'name',
            'autocomplete'       => true,
            'search_fields'      => ["concat(id, ' ', name)"],
            'options_sort_field' => 'id',
        ],
        'category'    => [
            'title'              => '分类',
            'type'               => 'relationship',
            'name_field'         => 'name',
            'autocomplete'       => true,
            'search_fields'      => ["concat(id, ' ', name)"],
            'options_sort_field' => 'id',
        ],
    ],
    'rules'   => [
        'title'        => 'required',
    ],
    'message' => [
        'title.required' => '请填写标题。',
    ],
];