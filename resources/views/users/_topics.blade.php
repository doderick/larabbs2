@if (count($topics) > 0)
    <ul class="list-group">
        @foreach ($topics as $topic)
            <li class="list-group-item">
                <a href="{{ $topic->link() }}" class="topic-title">
                    {{ $topic->title }}
                </a>
                <span class="meta pull-right">
                    {{ $topic->vote_count }} 点赞
                    <span> ⋅ </span>
                    {{ $topic->reply_count }} 回复
                    <span> ⋅ </span>
                    {{ $topic->created_at->diffForHumans() }}
                </span>
            </li>
        @endforeach
        @if (count($topics) > 5)
            {!! $topics->appends(Request::except('page'))->render() !!}
        @endif
    </ul>
@else
    <div class="empty-block">
        暂无数据 o(╯□╰)o
    </div>
@endif