<nav class="nav navbar-default navbar-static-top">
    <div class="container">

        <div class="navbar-header">

            {{-- Collapsed Hamburger --}}
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            {{-- logo --}}
            <a href="{{ route('root') }}" class="navbar-brand">
                LaraBBS 2
            </a>

        </div>
        <div id="app-navbar-collapse" class="collapse navbar-collapse">

            {{-- 导航栏左侧 --}}
            <ul class="nav navbar-nav"></ul>
            {{-- 导航栏右侧 --}}
            <ul class="nav navbar-nav navbar-right">
                {{-- 认证链接 --}}
                {{-- 游客显示登录和注册按钮 --}}
                @guest
                    <li><a href="{{ route('login') }}">登录</a></li>
                    <li><a href="{{ route('register') }}">注册</a></li>
                {{-- 登录用户显示退出登录 --}}
                @else
                    <li class“dropdown”>
                        <a href="#" role="button" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            <span class="user-avatar pull-left" style="margin-right: 8px; margin-top: -5px;">
                                <img src="https://fsdhubcdn.phphub.org/uploads/images/201709/20/1/PtDKbASVcz.png?imageView2/1/w/60/h/60" alt=""
                                        class="img-responsive img-circle" width="30px" height="30px">
                            </span>
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <ul role="menu" class="dropdown-menu">
                            <li>
                                <a href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                                    <span class="glyphicon glyphicon-logout" aria-hidden="true"></span>
                                    退出登录
                                </a>
                                <form action="{{ route('logout') }}" method="post" id="logout-form" style="display: none;">
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