<div class="media-body">
    <hr>
    <p class="user-introduction">
        @if ($user->introduction)
            {{ $user->introduction }}
        @else
            这个家伙很懒，什么也没留下......
        @endif
    </p>
    <hr>
    <div class="user-rank text-center">
        <p>本站第 {{ $user->id }} 位会员</p>
        <p>注册于 {{ $user->created_at->diffForHumans() }}</p>
        <p>活跃于 {{ $user->last_actived_at->diffForHumans() }}</p>
    </div>
    <hr>
    <div class="user-stat">
        <div class="col-xs-4 text-center">
            <a href="{{ route('show.followers', $user->id) }}" class="counter">{{ $user->followers()->count() }}</a>
            <a href="{{ route('show.followers', $user->id) }}" class="text">关注者</a>
        </div>
        <div class="col-xs-4 text-center">
            <a href="{{ route('show.topics', $user->id) }}" class="counter">{{ $user->topic_count }}</a>
            <a href="{{ route('show.topics', $user->id) }}" class="text">帖子</a>
        </div>
        <div class="col-xs-4 text-center">
            <a href="{{ route('show.replies', $user->id) }}" class="counter">{{ $user->reply_count }}</a>
            <a href="{{ route('show.replies', $user->id) }}" class="text">回帖</a>
        </div>
    </div>
</div>