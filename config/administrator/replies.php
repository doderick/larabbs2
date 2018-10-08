<?php

use App\Models\Reply;

return [
    'title'       => '回帖',
    'single'      => '回帖',
    'model'       => Reply::class,
    'columns'     => [
        'id'         => [
            'title' => 'ID',
        ],
        'content'    => [
            'title'    => '内容',
            'sortable' => false,
            'output'    => function($value, $model)
            {
                return '<div style="text-align:left;">' . $value . '</div>';
            },
        ],
        'user'       => [
            'title'    => '作者',
            'sortable' => false,
            'output'   => function($value, $model)
            {
                $avatar = $model->user->avatar;
                $value  = empty($avatar) ? 'N/A' : '<div style="text-align:left;"><img src="' . $avatar . '" style="width:22px">' . $model->user->name . '</div>';
                return model_link($value, $model->user);
            },
        ],
        'topic'      => [
            'title'    => '帖子',
            'sortable' => false,
            'output'   => function($value, $model)
            {
                return '<div style="max-width:250px;text-align:left;">' . model_admin_link(e($model->topic->title), $model->topic) . '</div>';
            },
        ],
        'vote_count' => [
            'title' => '点赞数',
        ],
        'operation'  => [
            'title'    => '管理',
            'sortable' => false,
        ],
    ],
    'edit_fields' => [
        'user'        => [
            'title'              => '作者',
            'type'               => 'relationship',
            'name_field'         => 'name',
            'autocomplete'       => true,
            'search_fields'      => ["concat(id, ' ', name)"],
            'options_sort_field' => 'id',
        ],
        'topic'      => [
            'title'              => '帖子标题',
            'type'               => 'relationship',
            'name_field'         => 'title',
            'autocomplete'       => true,
            'search_fields'      => ["concat(id, ' ', title)"],
            'options_sort_field' => 'id',
        ],
        'content'    => [
            'title' => '回帖内容',
            'type'  => 'textarea',
        ],
        'vote_count' => [
            'title' => '点赞数',
        ],
    ],
    'filters'     => [
        'id'      => [
            'title' => '回帖 ID'
        ],
        'user'    => [
            'title'              => '用户',
            'type'               => 'relationship',
            'name_field'         => 'name',
            'autocomplete'       => true,
            'search_fields'      => ["concat(id, ' ', name)"],
            'options_sort_field' => 'id',
        ],
        'topic'   => [
            'title'              => '帖子',
            'type'               => 'relationship',
            'name_field'         => 'title',
            'autocomplete'       => true,
            'search_fields'      => ["concat(id, ' ', title)"],
            'options_sort_field' => 'id',
        ],
        'content' => [
            'title' => '回帖内容',
        ],
    ],
    'rules'   => [
        'content' => 'required',
    ],
    'message' => [
        'content.required' => '请填写回帖内容。',
    ],
];