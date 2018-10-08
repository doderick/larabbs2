<nav class="navbar navbar-default navbar-static-top">
    <div class="container">
        <div class="navbar-header">
            {{-- collapsed for the mobile devices --}}
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ route('home') }}">{{ config('app.name') }}</a>
        </div>

        <div id="app-navbar-collapse" class="collapse navbar-collapse">

            {{-- Left side of navbar --}}
            <ul class="nav navbar-nav">
                <li class="{{ active_class(if_route('topics.index')) }}"><a href="{{ route('topics.index') }}">帖子</a></li>
                <li class="{{ active_class((if_route('categories.show') && if_route_param('category', 1))) }}"><a href="{{ route('categories.show', 1) }}">分享</a></li>
                <li class="{{ active_class((if_route('categories.show') && if_route_param('category', 2))) }}"><a href="{{ route('categories.show', 2) }}">问答</a></li>
                <li class="{{ active_class((if_route('categories.show') && if_route_param('category', 3))) }}"><a href="{{ route('categories.show', 3) }}">教程</a></li>
                <li class="{{ active_class((if_route('categories.show') && if_route_param('category', 4))) }}"><a href="{{ route('categories.show', 4) }}">闲聊</a></li>
                <li class="{{ active_class((if_route('categories.show') && if_route_param('category', 5))) }}"><a href="{{ route('categories.show', 5) }}">公告</a></li>
            </ul>

            {{-- Right side of navbar --}}
            <ul class="nav navbar-nav navbar-right">
                @guest
                    <li>
                        <a href="{{ route('login') }}">
                            登录
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('register') }}">
                            注册
                        </a>
                    </li>
                @else
                    <li>
                        <a href="{{ route('topics.create') }}">
                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                        </a>
                    </li>
                    {{-- Notifications --}}
                    <li>
                        <a href="{{ route('notifications.index') }}" class="notifications-badge">
                            <span title="消息通知" class="badge badge-{{ Auth::user()->notification_count > 0 ? 'hint' : 'fade' }}">
                                {{ Auth::user()->notification_count }}
                            </span>
                        </a>
                    </li>
                    <li class="dropdown">
                        <a href="#" role="button" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="user-avatar pull-left">
                                <img src="{{ Auth::user()->avatar }}" class="img-responsive img-circle">
                            </span>
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>
                        <ul role="menu" class="dropdown-menu">
                            @can ('manage_contents')
                                <li>
                                    <a href="{{ url(config('administrator.uri')) }}">
                                        <span class="glyphicon glyphicon-dashboard" aria-hidden="true"></span> 管理后台
                                    </a>
                                </li>
                            @endcan
                            <li>
                                <a href="{{ route('users.show', Auth::id()) }}">
                                    <span class="glyphicon glyphicon-user" aria-hidden="true"></span> 个人中心
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('users.edit', Auth::id()) }}">
                                    <span class="glyphicon glyphicon-cog" aria-hidden="true"></span> 编辑资料
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                                    <span class="glyphicon glyphicon-log-out" aria-hidden="true"></span> 退出登录
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="post" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                        </ul>
                    </li>
                @endguest
            </ul>

        </div>
    </div>
</nav>