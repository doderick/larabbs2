<?php

use App\Models\Category;

return [
    'title'       => '分类',
    'single'      => '分类',
    'model'       => Category::class,
    // 对 CRUD 动作的单独权限控制，其它动作不指定，默认为通过
    'action_permissions' => [
        'delete' => function()
        {
            // 删除权限控制，只有站长可以删除分类
            return Auth::user()->hasRole('Founder');
        }
    ],
    'columns'     => [
        'id'          => [
            'title' => 'ID',
        ],
        'name'        => [
            'title'    => '分类名称',
            'sortable' => false,
        ],
        'description' => [
            'title'    => '分类描述',
            'sortable' => false,
        ],
        'topic_count' => [
            'title'    => '帖子数',
        ],
        'operation'   => [
            'title'    => '管理',
            'sortable' => false,
        ],
    ],
    'edit_fields' => [
        'name'        => [
            'title' => '分类名称',
        ],
        'description' => [
            'title' => '分类描述',
            'type'  => 'textarea',
        ],
    ],
    'filters'     => [
        'id'          => [
            'title' => '分类 ID'
        ],
        'name'        => [
            'title' => '分类名称'
        ],
        'description' => [
            'title' => '分类描述'
        ],
    ],
    'rules'   => [
        'name'        => 'required|max:10|unique:categories',
        'description' => 'required',
    ],
    'message' => [
        'name.unique'          => '分类名称在数据库里有重复，请选用其他名称。',
        'name.required'        => '分类名称至少需要一个字符。',
        'description.required' => '描述至少需要一个字符。',
    ],
];