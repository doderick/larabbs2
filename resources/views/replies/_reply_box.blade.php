@include('public.error')
<div class="reply-box">
    <form action="{{ route('replies.store') }}" method="post" accept-charset="UTF-8">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="topic_id" value="{{ $topic->id }}">
        <div class="form-group">
            <textarea name="content" id="" rows="3" class="form-control" placeholder="分享你的看法"></textarea>
        </div>
        <button type="submit" class="btn btn-primary btn-sm">回帖</button>
    </form>
</div>
<hr>