@if (count($followers) > 0)
    <ul class="list-group">
        @foreach ($followers as $follower)
            <li class="list-group-item">
                <a href="{{ route('users.show', $follower->id) }}">
                    <img src="{{ $follower->avatar }}" class="img-thumbnail img-responsive">
                    <span>{{ $follower->name }}</span>
                </a>
            </li>
        @endforeach
    </ul>
@else
    <div class="empty-block">
        暂无数据 o(╯□╰)o
    </div>
@endif