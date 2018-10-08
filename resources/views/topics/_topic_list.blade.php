@if ($topics)
    <ul class="media-list">
        @foreach ($topics as $topic)
            <li class="media">
                <div class="media-left">
                    <a href="{{ $topic->link() }}">
                        <img src="{{ $topic->user->avatar }}" title="{{ $topic->user->name }}" class="media-object img-thumbnail">
                    </a>
                </div>
                <div class="media-body">
                    <div class="media-heading">
                        <a href="{{ $topic->link() }}">
                            {{ $topic->title }}
                        </a>
                        <a href="{{ $topic->link() }}" title="回帖数" class="pull-right">
                            <span class="badge"> {{ $topic->reply_count }} </span>
                        </a>
                    </div>
                    <div class="media-body meta">
                        <a href="{{ route('categories.show', $topic->category->id) }}">
                            <span class="glyphicon glyphicon-folder-open" aria-hidden="true"></span>
                             {{ $topic->category->name }}
                        </a>
                        <span> • </span>
                        <a href="{{ route('users.show', $topic->user->id) }}" title="作者：{{ $topic->user->name }}">
                            <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                             {{ $topic->user->name }}
                        </a>
                        <span> • </span>
                        <span class="glyphicon glyphicon-time" aria-hidden="true"></span>
                        <span class="timeago"></span>最后回复于{{ $topic->updated_at->diffForHumans() }}
                    </div>
                </div>
            </li>

            @if (! $loop->last)
                <hr>
            @endif

        @endforeach
    </ul>
@else
    <div class="empty-block">
        暂无数据 o(╯□╰)o
    </div>
@endif