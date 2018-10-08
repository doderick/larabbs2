<?php

use Spatie\Permission\Models\Permission;

return [
    'title'       => '权限',
    'single'      => '权限',
    'model'       => Permission::class,
    'permission'  => function()
    {
        return Auth::user()->can('manage_users');
    },
    // 对 CRUD 动作的单独权限控制，通过返回布尔值来控制权限
    'action_permissions' => [
        'create' => function($model)
        {
            // 控制『新建按钮』的显示
            return true;
        },
        'view'   => function($model)
        {
            // 允许查看
            return true;
        },
        'update' => function($model)
        {
            // 允许更新
            return true;
        },
        'delete' => function($model)
        {
            // 不允许删除
            return false;
        },
    ],
    'columns'     => [
        'id'         => [
            'title' => 'ID',
        ],
        'name'       => [
            'title'    => '标识',
            'sortable' => false,
        ],
        'operation'  => [
            'title'    => '管理',
            'sortable' => false,
        ],
    ],
    'edit_fields' => [
        'name'  => [
            'title' => '标识（请慎重修改）',
            // 表单条目标题旁的『提示信息』
            'hint' => '修改权限标识会影响代码的调用，请不要轻易更改。',
        ],
        'roles' => [
            'title'      => '角色',
            'type'       => 'relationship',
            'name_field' => 'name',
        ],
    ],
    'filters'     => [
        'name' => [
            'title' => '标识',
        ],
    ],
];