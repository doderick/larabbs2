<?php

namespace App\Handlers;

use Image;
use PhpParser\Node\Expr\AssignOp\Concat;

class ImageUploadHandler
{
    // 限制上传图片文件的后缀名
    protected $allowed_ext = [
        'jpg', 'jpeg', 'png', 'gif',
    ];

    /**
     * 保存上传图片文件的方法
     *
     * @param object $file             上传的图片文件
     * @param string $folder           自定义的图片存储目录
     * @param string $file_prefix      自定义的图片文件名前缀
     * @param integer|false $max_width 图片的最大尺寸
     * @return void
     */
    public function save($file, $folder, $file_prefix, $max_width = false)
    {
        // 获得文件的后缀名，如果没有后缀名，赋值 ’png‘
        $extension = strtolower($file->getClientOriginalExtension()) ?: 'png';

        // 如果上传的文件不是图片，则终止操作
        if (! in_array($extension, $this->allowed_ext)) {
            return false;
        }

        // 构建存储目录规则
        $folder_name = 'uploads/images/' . $folder . '/' .date('Ym/d', time());

        // 获得文件具体的存储路径
        $upload_path = public_path() . '/' . $folder_name;

        // 拼接文件名
        $file_name = $file_prefix . '_' . time() . '_' . str_random(10) . '.' . $extension;

        // 将图片文件移动至目标存储路径
        $file->move($upload_path, $file_name);

        // 如果限制了图片的尺寸，则进行裁剪
        if ($max_width && $extension !== 'gif') {
            $this->resizeImage($upload_path . '/' . $file_name, $max_width);
        }

        // 返回图片的物理存储路径
        return [
            'image_path' => config('app.url') . '/' . $folder_name . '/' . $file_name
        ];
    }

    /**
     * 缩放图片的方法
     *
     * @param string $file_path  需要进行缩放的图片的物理路径
     * @param integer $max_width 设定的图片的最大宽度
     * @return void
     */
    public function resizeImage($file_path, $max_width)
    {
        // 实例化，传入图片文件的物理路径
        $image = Image::make($file_path);

        // 调整图片文件的大小
        $image->resize($max_width, null, function($constraint) {
            // 设定图片的宽度为 $max_width 的值，同时，等比例进行缩放
            $constraint->aspectRatio();

            // 防止图片尺寸变大
            $constraint->upsize();
        });

        // 对缩放后的图片进行保存
        $image->save();
    }
}