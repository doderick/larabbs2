<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="descript" content="@yield('description', setting('seo_description', 'Laravel 爱好者社区'))">
    <meta name="keyword" content="@yield('keyword', setting('seo_keyword', 'laravel,社区,论坛,开发者'))">
    <title>@yield('title', "{{ config('app.name') }}") - {{ setting('site_name', 'Laravel 进阶教程') }}</title>

    {{-- CSS --}}
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @yield('styles')
</head>
<body>
    <div id="app" class="{{ routeToClass() }}-page">

        @include('layouts._header')

        <div class="container">

            {{-- 消息提醒视图 --}}
            @include('layouts._message')
            @yield('content')
        </div>

        @include('layouts._footer')
    </div>
    {{-- sudo-su --}}
    @if (config('app.debug'))
        @include('sudosu::user-selector')
    @endif
    {{-- JS --}}
    <script src="{{ asset('js/app.js') }}"></script>
    @yield('scripts')
</body>
</html>