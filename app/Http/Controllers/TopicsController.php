<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\TopicRequest;
use App\Models\Category;
use Auth;
use App\Handlers\ImageUploadHandler;

class TopicsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

    /**
     * 显示话题列表的方法
     *
     * @param Request $request 话题列表的查看请求
     * @param Topic $topic     话题的一个实例
     * @return void
     */
    public function index(Request $request, Topic $topic)
	{
        $topics = $topic->withOrder($request->order)
                        ->paginate(20);

		return view('topics.index', compact('topics'));
	}

    public function show(Request $request, Topic $topic)
    {
        // URL 矫正
        if (! empty($topic->slug) && $topic->slug !== $request->slug) {
            return redirect($topic->link(), 301);
        }

        return view('topics.show', compact('topic'));
    }

	public function create(Topic $topic)
	{
        $categories = Category::all();
		return view('topics.create_and_edit', compact('topic', 'categories'));
	}

	public function store(TopicRequest $request, Topic $topic)
	{
        $topic->fill($request->all());
        $topic->user_id = Auth::user()->id;
        $topic->save();

		return redirect()->to($topic->link())->with('success', '话题发布成功！');
    }

    /**
     * 话题中上传图片的方法
     *
     * @param Request $request             上传图片的请求
     * @param ImageUploadhandler $uploader 上传图片工具
     * @return void
     */
    public function uploadImage(Request $request, ImageUploadhandler $uploader)
    {
        // 初始化返回数据，默认为失败
        $data = [
            'success'   => false,
            'msg'       => '图片上传失败',
            'file_path' => '',
        ];
        // 判断是否有上传文件，并赋值给 $file
        if ($file = $request->upload_file) {
            // 保存图片到本地
            $result = $uploader->save($request->upload_file, 'topics', Auth::id(), 1000);
            // 图片保存成功的情况
            if ($result) {
                $data['file_path'] = $result['path'];
                $data['msg']       = '图片上传成功！';
                $data['success']   = true;
            }
        }
        return $data;
    }

    /**
     * 编辑话题的方法
     *
     * @param Topic $topic 需要进行编辑的话题的实例
     * @return void
     */
    public function edit(Topic $topic)
	{
        $this->authorize('update', $topic);
        $categories = Category::all();
		return view('topics.create_and_edit', compact('topic', 'categories'));
	}

	public function update(TopicRequest $request, Topic $topic)
	{
		$this->authorize('update', $topic);
		$topic->update($request->all());

		return redirect()->to($topic->link())->with('success', '话题已成功编辑！');
	}

	public function destroy(Topic $topic)
	{
		$this->authorize('destroy', $topic);
		$topic->delete();

		return redirect()->route('topics.index')->with('success', '话题已成功删除！');
	}
}