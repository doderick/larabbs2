<?php

namespace App\Http\Requests;

class TopicRequest extends Request
{
    public function rules()
    {
        switch($this->method())
        {
            // CREATE
            case 'POST':
            // UPDATE
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'title'       => 'required|min:2',
                    'body'        => 'required|min:3',
                    'category_id' => 'required|numeric',
                ];
            }
            case 'GET':
            case 'DELETE':
            default:
            {
                return [];
            };
        }
    }

    public function messages()
    {
        return [
            'title.min'            => '标题至少两个字符奈～',
            'title.required'       => '标题不能为空哦～',
            'body.min'             => '文章内容至少三个字符的说～',
            'body.required'        => '文章内容不能为空哦～',
            'category_id.required' => '必须选择一个分类哦～',
        ];
    }
}