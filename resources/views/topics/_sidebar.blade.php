<div class="panel panel-default">
    <div class="panel-body">
        <a href="{{ route('topics.create') }}" class="btn btn-success btn-block" aria-label="Left Align">
            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> 新建话题
        </a>
    </div>
</div>

{{-- 活跃用户 --}}
@if ($active_users)
    <div class="panel panle-default">
        <div class="panel-body active_users">
            <div class="text-center">
                活跃用户
            </div>
            <hr>
            @foreach ($active_users as $active_user)
                <a href="{{ route('users.show', $active_user->id) }}" class="media">
                    <div class="media-left media-middle">
                        <img src="{{ $active_user->avatar }}" class="img-circle media-object" style="width:24px;height=24px;">
                    </div>
                    <div class="media-body">
                        <span class="media-heading">{{ $active_user->name }}</span>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
@endif

{{-- 资源推荐 --}}
@if ($links)
    <div class="panel panel-default">
        <div class="panel-body recommend_links">
            <div class="text-center">
                资源推荐
            </div>
            <hr>
            @foreach ($links as $link)
                <a href="{{ $link->link }}" target="_blank" class="media">
                    <div class="media-body">
                        <span class="media-heading">{{ $link->title }}</span>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
@endif