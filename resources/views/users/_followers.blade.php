@if (count($users))
    <ul class="media-list">
        @foreach ($users as $user)
            <li>
                <div class="media-body">
                <a href="{{ route('users.show', $user->id) }}" class="pull-left">
                    <img src="{{ $user->avatar }}"class="media-object img-thumbnail" style="width: 52px; height: 52px;">
                </a>
                <a href="{{ route('users.show', $user->id) }}" class="pull-left text" style="margin-left: 10px;">{{ $user->name }}</a>
                </div>
            </li>
            @if (! $loop->last)
                <hr>
            @endif
        @endforeach

        {!! $users->appends(Request::except('page'))->render() !!}
    </ul>
@else
    <div class="empty-block">
        还没有关注者 o(╯□╰)o
    </div>
@endif