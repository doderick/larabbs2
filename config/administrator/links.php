<?php

use App\Models\Link;

return [
    'title'  => '资源推荐',
    'single' => '资源推荐',
    'model'  => Link::class,

    // 限制站长管理资源推荐链接
    'peimission' => function() {
        return Auth::user()->hasRole('Founder');
    },

    'columns' => [
        'id'        => [
            'title' => 'ID',
        ],
        'title'     => [
            'title'    => '资源名称',
            'sortable' => false,
        ],
        'link'      => [
            'title'    => '资源链接',
            'sortable' => false,
        ],
        'operation' => [
            'title'    => '管理',
            'sortable' => 'false',
        ],
    ],

    'edit_fields' => [
        'title' => [
            'title' => '资源名称',
        ],
        'link'  => [
            'title' => '资源链接',
        ],
    ],

    'filters' => [
        'id'    => [
            'title' => '标签 ID',
        ],
        'title' => [
            'title' => '资源名称',
        ],
    ],
];