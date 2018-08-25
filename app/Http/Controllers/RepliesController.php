<?php

namespace App\Http\Controllers;

use App\Models\Reply;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ReplyRequest;
use Auth;

class RepliesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

	public function index()
	{
		$replies = Reply::paginate();
		return view('replies.index', compact('replies'));
	}

    public function show(Reply $reply)
    {
        return view('replies.show', compact('reply'));
    }

	public function create(Reply $reply)
	{
		return view('replies.create_and_edit', compact('reply'));
	}

    /**
     * 用户进行回复的方法
     *
     * @param ReplyRequest $request 回复请求
     * @param Reply $reply          回复的一个实例
     * @return void
     */
    public function store(ReplyRequest $request, Reply $reply)
	{
        if (empty($content)) {
            return redirect()->back()->with('danger', '回复内容无法识别！');
        }

        $reply->content  = $request->content;
        $reply->topic_id = $request->topic_id;
        $reply->user_id  = AUth::id();
        $reply->save();

		return redirect()->to($reply->topic->link())->with('success', '回复成功！');
	}

	public function edit(Reply $reply)
	{
        $this->authorize('update', $reply);
		return view('replies.create_and_edit', compact('reply'));
	}

	public function update(ReplyRequest $request, Reply $reply)
	{
		$this->authorize('update', $reply);
		$reply->update($request->all());

		return redirect()->route('replies.show', $reply->id)->with('message', 'Updated successfully.');
	}

	public function destroy(Reply $reply)
	{
		$this->authorize('destroy', $reply);
		$reply->delete();

		return redirect()->route('replies.index')->with('success', '删除回复成功！');
	}
}