<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TopicRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
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
            }
        }
    }

    /**
     * 自定义错误消息提示
     *
     * @return void
     */
    public function messages()
    {
        return [
            'title.min'            => '标题至少需要两个字符',
            'title.required'       => '标题不能为空',
            'body.min'             => '帖子内容至少需要三个字符',
            'body.required'        => '帖子内容不能为空',
            'category_id.required' => '必须选择一个分类',
        ];
    }
}
