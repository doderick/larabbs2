
<ul class="user-link">
    <li>
        <a href="{{ route('show.topics', $user->id) }}">
            <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span> Ta 发布的帖子
        </a>
    </li>
    <hr>
    <li>
        <a href="{{ route('show.replies', $user->id) }}">
            <span class="glyphicon glyphicon-comment" aria-hidden="true"></span> Ta 发布的回帖
        </a>
    </li>
    <hr>
    <li>
        <a href="{{ route('show.followings', $user->id) }}">
            <span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> Ta 关注的用户
        </a>
    </li>
<ul>
