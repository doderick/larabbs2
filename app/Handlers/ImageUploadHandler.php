<?php

namespace App\Handlers;

use Image;

class ImageUploadHandler
{
    // 限制上传文件的后缀名
    protected $allowed_ext = [
        'jpg', 'jpeg', 'png', 'gif',
    ];

    /**
     * 保存上传图片的方法
     *
     * @param string $file                  上传的图片文件
     * @param string $folder                定义的存储目录
     * @param string $file_prefix           定义的图片文件前缀
     * @param boolean|integer $max_width    图片的最大宽度
     * @return 图片的存储绝对路径
     */
    public function save($file, $folder, $file_prefix, $max_width = false)
    {
        // 获取上传文件的后缀名，因图片从剪贴板里黏贴时后缀名为空，所以此处确保后缀一直存在
        $extension = strtolower($file->getClientOriginalExtension()) ?: 'png';

        // 判断上传的文件是否为图片，如果不是，终止执行
        if (! in_array($extension, $this->allowed_ext)) {
            return false;
        }

        // 构建存储的目录
        $folder_name = "uploads/image/{$folder}/" . date('Ym/d', time());

        // 构建文件存储的物理路径
        $upload_path = public_path() . '/' . $folder_name;

        // 拼接文件名，由前缀+时间戳+随机字串+后缀名组成
        $filename = $file_prefix . '_' . time() . '_' . str_random(10) . '.' . $extension;

        // 将图片移动到目标存储路径中
        $file->move($upload_path, $filename);

        // 如果图片的宽度超过最大宽度的限制，则对图片进行裁剪
        if ($max_width && $extension != 'gif') {
            $this->reduceSize($upload_path . '/' . $filename, $max_width);
        }

        return [
            'path' => config('app.url') . "/{$folder_name}/{$filename}"
        ];
    }

    /**
     * 对图片进行裁剪的方法
     *
     * @param string $file_path  进行裁剪的图片的物理路径
     * @param integer $max_width 图片的最大宽度
     * @return void
     */
    public function reduceSize($file_path, $max_width)
    {
        // 实例化一个 Image 类
        $image = Image::make($file_path);

        // 进行大小调整的操作
        $image->resize($max_width, null, function ($constraint) {

            // 设定宽度是 $max_width，高度等比例双向缩放
            $constraint->aspectRatio();

            // 防止截图是图片尺寸变大
            $constraint->upsize();
        });

        // 对图片的修改进行保存
        $image->save();
    }
}