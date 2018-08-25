<div class="reply-list">
    @foreach ($replies as $index => $reply)
        <div name="reply{{ $reply->id }}" id="reply{{ $reply->id }}" class="media">
            <div class="avatar pull-left">
                <a href="{{ route('users.show', $reply->user_id) }}">
                    <img src="{{ $reply->user->avatar }}" alt="{{ $reply->user->name }}"
                            class="media-object img-thumbnail" style="width: 48px; height: 48px;">
                </a>
            </div>
            <div class="infos">
                <div class="media-heading">
                    <a href="{{ route('users.show', $reply->user_id) }}" title="{{ $reply->user->name }}">
                        {{ $reply->user->name }}
                    </a>
                    <span> •  </span>
                    <span title="{{ $reply->created_at }}" class="meta">{{ $reply->created_at->diffForHumans() }}</span>
                    {{-- 回复删除按钮 --}}
                    @can ('destroy', $reply)
                        <span class="meta pull-right">
                            <form action="{{ route('replies.destroy', $reply->id) }}" method="post">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                                <button type="submit" class="btn btn-default btn-xs pull-left" onclick="return function(){return confirm('你确定要删除吗？')}()">
                                    <span class="glyphicon glyphicon-trash"></span>
                                </button>
                            </form>
                        </span>
                    @endcan
                </div>
                <div class="reply-content">
                    {!! $reply->content !!}
                </div>
            </div>
        </div>
        <hr>
    @endforeach

    {!! $replies->appends(Request::except('page'))->render() !!}
</div>