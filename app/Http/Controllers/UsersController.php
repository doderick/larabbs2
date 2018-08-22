<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\UserRequest;
use App\Handlers\ImageUploadHandler;

class UsersController extends Controller
{
    /**
     * 展示用户主页的方法
     *
     * @param User $user
     * @return void
     */
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    /**
     * 展示编辑资料表单的方法
     *
     * @param User $user
     * @return void
     */
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    /**
     * 更新用户个人资料的方法
     *
     * @param UserRequest $request          更新资料的表单请求
     * @param ImageUploadHandler $uploader  图片上传处理器
     * @param User $user                    进行资料更新的用户实例
     * @return void
     */
    public function update(UserRequest $request, ImageUploadHandler $uploader, User $user)
    {
        $data = $request->all();

        if ($request->avatar) {
            $result = $uploader->save($request->avatar, 'avatars', $user->id, 362);
            if ($request) {
                $data['avatar'] = $result['path'];
            }
        }
        $user->update($data);
        return redirect()->route('users.show', $user->id)->with('success', '个人资料更新成功！');
    }
}
