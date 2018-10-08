<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\Models\Reply;
use App\Http\Requests\ReplyRequest;
use App\Http\Controllers\Controller;

class RepliesController extends Controller
{
    /**
     * 构造中间件过滤 http 请求，只有登录用户可以访问控制器内的方法
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * 用户发表回帖的方法
     *
     * @param ReplyRequest $request
     * @param Reply $reply
     * @return void
     */
    public function store(ReplyRequest $request, Reply $reply)
    {
        // 预防 XSS 攻击
        $content = clean($request->content, 'user_topic_body');
        // 如果过滤后的内容为空。不予保存到数据库
        if (empty($content)) {
            return redirect()->back()->with('danger', '回帖内容无法识别！');
        }

        $reply->user_id = Auth::id();
        $reply->topic_id = $request->topic_id;
        $reply->content = $content;
        $reply->save();

        return redirect()->to($reply->topic->link())->with('success', '回帖成功！');
    }

    /**
     * 用户删除回帖的方法
     *
     * @param Reply $reply
     * @return void
     */
    public function destroy(Reply $reply)
    {
        $this->authorize('destroy', $reply);
        $reply->delete();

        return redirect()->to($reply->topic->link())->with('success', '回帖已被成功删除！');
    }
}
