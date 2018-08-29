@if ($user->id !== Auth::id())
    <div class="follow_form">
        @if (! Auth::user()->isFollowing($user->id))
            <form action="{{ route('followers.store', $user->id) }}" method="post">
                {{ csrf_field() }}
                <button type="submit" class="btn btn-primary btn-block" style="cursor: printer;">
                    <span class="glyphicon glyphicon-plus"></span> 关注
                </button>
            </form>
        @else
            <form action="{{ route('followers.destroy', $user->id) }}" method="post">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}
                <button type="submit" class="btn btn-primary btn-block" style="cursor: printer;">
                    <span class="glyphicon glyphicon-minus"></span> 不再关注
                </button>
            </form>
        @endif
    </div>
@endif