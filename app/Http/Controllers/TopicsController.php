<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\Models\Link;
use App\Models\User;
use App\Models\Topic;
use App\Models\Category;
use App\Http\Requests\TopicRequest;
use App\Handlers\ImageUploadHandler;

class TopicsController extends Controller
{
    /**
     * 构造中间件过滤http请求
     * 除了 index show 其余方法都只有登录用户才能访问
     */
    public function __construct()
    {
        $this->middleware('auth', [
            'except' => ['index', 'show']
        ]);
    }
    /**
     * 列出所有帖子的方法
     *
     * @param Request $request
     * @param Topic $topic
     * @param User $user
     * @param Link $link
     * @return void
     */
    public function index(Request $request, Topic $topic, User $user, Link $link)
    {
        $topics = $topic->withOrder($request->order)->paginate(20);
        $active_users = $user->getActiveUsers();
        $recommend_links = $link->getRecommendLinks();

        return view('topics.index', compact('topics', 'active_users', 'recommend_links'));
    }

    /**
     * 显示帖子的方法
     *
     * @param Request $request
     * @param Topic $topic
     * @return void
     */
    public function show(Request $request, Topic $topic)
    {
        // URL 矫正
        if (! empty($topic->slug) && $topic->slug !== $request->slug) {
            return redirect($topic->link(), 301);
        }

        $topic->visits()->increment();

        $category = $topic->category;
        $user = $topic->user;

        return view('topics.show', compact('topic', 'category', 'user'));
    }

    /**
     * 发布新帖子的方法
     *
     * @param Topic $topic
     * @return void
     */
    public function create(Topic $topic)
    {
        $categories = Category::all();
        return view('topics.create_and_edit', compact('topic', 'categories'));
    }

    /**
     * 保存新帖子的方法
     *
     * @param TopicRequest $request
     * @param Topic $topic
     * @return void
     */
    public function store(TopicRequest $request, Topic $topic)
    {
        // 预防 XSS 攻击
        $body = clean($request->body, 'user_topic_body');
        // 如果过滤后的内容为空。不予保存到数据库
        if (empty($body)) {
            return redirect()->back()->with('danger', '帖子内容无法识别！');
        }

        $topic->user_id = Auth::id();
        $topic->fill($request->all());
        $topic->save();

        return redirect()->to($topic->link())->with('success', '帖子发布成功！');
    }

    /**
     * 用户编辑帖子的方法
     *
     * @param Topic $topic
     * @return void
     */
    public function edit(Topic $topic)
    {
        $this->authorize('update', $topic);
        $categories = Category::all();

        return view('topics.create_and_edit', compact('topic', 'categories'));
    }

    /**
     * 保存帖子更新的方法
     *
     * @param TopicRequest $request
     * @param Topic $topic
     * @return void
     */
    public function update(TopicRequest $request, Topic $topic)
	{
        $this->authorize('update', $topic);

        // 预防 XSS 攻击
        $body = clean($request->body, 'user_topic_body');
        // 如果过滤后的内容为空。不予保存到数据库
        if (empty($body)) {
            return redirect()->back()->with('danger', '帖子内容无法识别！');
        }

		$topic->update($request->all());

		return redirect()->to($topic->link())->with('success', '帖子已成功编辑！');
    }

    /**
     * 删除帖子的方法
     *
     * @param Topic $topic
     * @return void
     */
    public function destroy(Topic $topic)
	{
		$this->authorize('destroy', $topic);
		$topic->delete();

		return redirect()->route('topics.index')->with('success', '帖子已成功删除！');
	}

    /**
     * 帖子中上传图片的方法
     *
     * @param Request $request
     * @param ImageUploadHandler $uploader
     * @return 上传结果数据
     */
    public function uploadImage(Request $request, ImageUploadHandler $uploader)
    {
        // 初始化返回数据，默认为失败的情况
        $data = [
            'success'   => false,
            'msg'       => '图片上传失败！',
            'file_path' => '',
        ];
        // 判断是否有上传文件，并赋值给 $file
        if ($file = $request->upload_file) {
            // 保存图片到本地，限制最大宽度为 1024
            $result = $uploader->save($request->upload_file, 'topics', \Auth::id(), 1024);
            // 如果图片保存成功
            if ($result) {
                $data['file_path'] = $result['image_path'];
                $data['msg']       = '图片上传成功！';
                $data['success']   = true;
            }
        }
        return $data;
    }
}
