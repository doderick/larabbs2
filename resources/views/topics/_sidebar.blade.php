{{-- 新建帖子 --}}
<div class="panel panel-default">
    <div class="panel-body">
        <a href="{{ route('topics.create') }}" class="btn btn-success btn-block" aria-label="Left Align">
        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> 新建帖子
        </a>
    </div>
</div>
{{-- 活跃用户 --}}
@if ($active_users)
    <div class="panel panel-default">
        <div class="panel-body active-users">
            <div class="text-center">活跃用户</div>
            <hr>
            @foreach ($active_users as $active_user)
                <a href="{{ route('users.show', $active_user->id) }}" class="media">
                    <div class="media-left media-middle">
                        <img src="{{ $active_user->avatar }}" class="img-circle media-object">
                    </div>
                    <div class="media-body">
                        <span class="media-heading">{{ $active_user->name }}</span>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
@endif
{{-- 推荐资源 --}}
@if ($recommend_links)
    <div class="panel panel-default">
        <div class="panel-body recommend-links">
            <div class="text-center">资源推荐</div>
            <hr>
            @foreach ($recommend_links as $recommend_link)
                <a href="{{ $recommend_link->link }}" target="_blank" class="media text-center">
                    <div class="media-body">
                        <span class="media-heading">{{ $recommend_link->title }}</span>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
@endif