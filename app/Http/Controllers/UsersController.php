<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Topic;
use App\Models\Reply;
use App\Http\Requests\UserRequest;
use App\Handlers\ImageUploadHandler;

class UsersController extends Controller
{
    /**
     * 构造中间件过滤 http 请求
     */
    public function __construct()
    {
        $this->middleware('auth', [
            'except' => [
                'show', 'showTopics', 'showReplies', 'showFollowers', 'showFollowings',
            ]
        ]);
    }

    /**
     * 显示指定用户主页的方法
     * 取出用户最近发布的5个 topics 以及 10个 replies
     *
     * @param User $user
     * @return void
     */
    public function show(User $user)
    {
        $topics = $user->topics()
                        ->withOrder('recent')
                        ->limit(5)
                        ->get();

        $replies = $user->replies()
                        ->withOrder('recent')
                        ->limit(10)
                        ->get();

        return view('users.show', compact('user', 'topics', 'replies'));
    }

    /**
     * 列出用户所有发布的帖子的方法
     *
     * @param User $user
     * @param Topic $topic
     * @return void
     */
    public function showTopics(User $user, Topic $topic)
    {
        $title = '帖子列表';
        $topics = $user->topics()
                        ->withOrder('recent')
                        ->paginate(30);

        return view('users.show_details', compact('user', 'topics', 'title'));
    }

    /**
     * 列出用户所有发布过的回帖的方法
     *
     * @param User $user
     * @param Topic $reply
     * @return void
     */
    public function showReplies(User $user, Reply $reply)
    {
        $title = '回帖列表';
        $replies = $user->replies()
                        ->withOrder('recent')
                        ->paginate(20);

        return view('users.show_details', compact('user', 'replies', 'title'));
    }

    /**
     * 列出用户所关注者的方法
     *
     * @param User $user
     * @return void
     */
    public function showFollowers(User $user)
    {
        $title = '关注者列表';
        $followers = $user->followers()
                        ->orderBy('followers.created_at', 'desc')
                        ->paginate(20);

        return view('users.show_details', compact('user', 'followers', 'title'));
    }

    /**
     * 列出用户关注用户的方法
     *
     * @param User $user
     * @return void
     */
    public function showFollowings(User $user)
    {
        $title = '关注列表';
        $followings = $user->followings()
                        ->orderBy('followers.created_at', 'desc')
                        ->paginate(20);

        return view('users.show_details', compact('user', 'followings', 'title'));
    }

    /**
     * 修改用户资料的方法
     *
     * @param User $user
     * @return void
     */
    public function edit(User $user)
    {
        $this->authorize('update', $user);
        return view('users.edit', compact('user'));
    }

    /**
     * 更新用户个人资料的方法
     *
     * @param UserRequest $request
     * @param User $user
     * @param ImageUploadHandler $uploader
     * @return void
     */
    public function update(UserRequest $request, User $user, ImageUploadHandler $uploader)
    {
        $this->authorize('update', $user);
        // 获取所有的请求
        $data = $request->all();

        // 判断用户是否上传了头像
        if ($request->avatar) {
            $result = $uploader->save($request->avatar, 'avatars', $user->id, 362);
            if ($result) {
                $data['avatar'] = $result['image_path'];
            }
        }

        $user->update($data);
        return redirect()->route('users.show', $user->id)->with('success', '个人资料更新成功！');
    }
}
