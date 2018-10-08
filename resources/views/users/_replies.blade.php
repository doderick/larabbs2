@if (count($replies) > 0)
    <ul class="list-group">
        @foreach ($replies as $reply)
            <li class="list-group-item">
                <a href="{{ $reply->topic->link(['#reply' . $reply->id]) }}">
                    {{ $reply->topic->title }}
                </a>
                <span class="meta">
                    回复于 {{ $reply->created_at->diffForHumans() }}
                </span>
                <div class="reply-content">
                    {!! $reply->content !!}
                </div>

            </li>
        @endforeach
        @if (count($replies) > 10)
            {!! $replies->appends(Request::except('page'))->render() !!}
        @endif
    </ul>
@else
    <div class="empty-block">
        暂无数据 o(╯□╰)o
    </div>
@endif