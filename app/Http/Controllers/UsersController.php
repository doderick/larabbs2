<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\UserRequest;

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
     * @param UserRequest $request 表单请求
     * @param User $user
     * @return void
     */
    public function update(UserRequest $request, User $user)
    {
        $user->update($request->all());
        return redirect()->route('users.show', $user->id)->with('success', '个人资料更新成功！');
    }
}
