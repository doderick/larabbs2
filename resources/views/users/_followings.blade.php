@if (count($followings) > 0)
    <ul class="list-group">
        @foreach ($followings as $following)
            <li class="list-group-item">
                <a href="{{ route('users.show', $following->id) }}">
                    <img src="{{ $following->avatar }}" class="img-thumbnail img-responsive">
                    <span>{{ $following->name }}</span>
                </a>
            </li>
        @endforeach
    </ul>
@else
    <div class="empty-block">
        暂无数据 o(╯□╰)o
    </div>
@endif