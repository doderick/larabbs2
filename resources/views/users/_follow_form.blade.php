@if ($user->id !== Auth::id())
    <div class="follow_form">
        @if (! Auth::user()->isFollowing($user->id))
            <form action="{{ route('followers.store', $user->id) }}" method="post">
                {{ csrf_field() }}
                <button type="submit" class="btn btn-primary btn-block" style="cursor: printer;">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> 关注 Ta
                </button>
            </form>
        @else
            <form action="{{ route('followers.destroy', $user->id) }}" method="post">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}
                <button type="submit" class="btn btn-default btn-block" style="cursor: printer;" onclick="return function(){return confirm('确认不再关注此用户？')}()">
                    <span class="glyphicon glyphicon-minus" aria-hidden="true"></span> 不再关注
                </button>
            </form>
        @endif
    </div>
    <a href="mailto:{{ $user->email }}" role="btn" class="btn btn-default btn-block" style="margin-top: 5px;">
        <span class="glyphicon glyphicon-envelope" aria-hidden="true"></span> 发送邮件</a>
@endif