<div class="reply-list">
    @foreach ($replies as $reply)
        <div name="reply{{ $reply->id }}" id="reply{{ $reply->id }}" class="media">
            <div class="avatar pull-left">
                <a href="{{ route('users.show', $reply->user_id) }}">
                    <img src="{{ $reply->user->avatar }}" alt="{{ $reply->user->name }}" class="media-object img-thumbnail">
                </a>
            </div>
            <div class="infos">
                <div class="media-heading">
                    <a href="{{ route('users.show', $reply->user_id) }}">
                        {{ $reply->user->name }}
                    </a>
                </div>
                <div class="media-body">
                    <div class="reply-content">
                        {!! $reply->content !!}
                    </div>
                    <span class="article-meta text-left">
                        <span class="glyphicon glyphicon-time" aria-hidden="true"></span>
                        回复于
                        {{ $reply->created_at->diffForHumans() }}
                        <span class="glyphicon glyphicon-thumbs-up" aria-hidden="true" style="margin-left: 10px;"></span>
                        {{ $reply->vote_count }} 点赞
                        @can ('destroy', $reply)
                            <span class="meta pull-right">
                                <form action="{{ route('replies.destroy', $reply->id) }}" method="post">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                    <button type="submit" class="btn btn-default btn-xs"  style="border: none;" onclick="return function(){return confirm('你确定要删除吗？')}()">
                                        <span class="glyphicon glyphicon-trash"></span>
                                    </button>
                                </form>
                            </span>
                        @endcan
                    </span>
                </div>
            </div>
        </div>
        <hr>
    @endforeach
    {!! $replies->appends(Request::except('page'))->render() !!}
</div>