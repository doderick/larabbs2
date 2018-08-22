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
            <a href="{{ url('/') }}" class="navbar-brand">
                LaraBBS 2
            </a>

        </div>
        <div id="app-navbar-collapse" class="collapse navbar-collapse">

            {{-- 导航栏左侧 --}}
            <ul class="nav navbar-nav"></ul>
            {{-- 导航栏右侧 --}}
            <ul class="nav navbar-nav navbar-right">
                {{-- 认证链接 --}}
                <li><a href="#">登录</a></li>
                <li><a href="#">注册</a></li>
            </ul>

        </div>

    </div>
</nav>