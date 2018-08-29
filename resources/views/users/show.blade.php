@extends('layouts.app')
@section('title', $user->name . ' 的个人中心')

@section('content')
<div class="row">

    <div class="col-lg-3 col-md-3 hidden-sm hidden-xs user-info">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="media">
                    <div align="center">
                        <img src="{{ $user->avatar }}" class="thumbnail img-responsive" width="300px" height="300px">
                    </div>
                    <div class="media-body">
                        <hr>
                        <div class="col-xs-4 text-center">
                            <a href="{{ route('users.show', [$user->id, 'tab' => 'followers']) }}" class="counter">{{ $user->followers()->count() }}</a>
                            <a href="{{ route('users.show', [$user->id, 'tab' => 'followers']) }}" class="text">关注者</a>
                        </div>
                        <div class="col-xs-4 text-center">
                            <a href="{{ route('users.show', $user->id) }}" class="counter">{{ $user->topic_count }}</a>
                            <a href="{{ route('users.show', $user->id) }}" class="text">话题</a>
                        </div>
                        <div class="col-xs-4 text-center">
                            <a href="{{ route('users.show', [$user->id, 'tab' => 'replies']) }}" class="counter">{{ $user->reply_count }}</a>
                            <a href="{{ route('users.show', [$user->id, 'tab' => 'replies']) }}" class="text">回复</a>
                        </div>
                        <hr class="col-xs-12">

                        <div class="col-xs-12">
                            @if (Auth::check())

                                @include('users._follow_form')
                            @endif
                        </div>
                        <hr>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="media">
                    <h1 class="panel-title pull-left" style="font-size: 30px;">
                        {{ $user->name }}
                    </h1>
                </div>
                <hr style="margin-top: 5px; margin-bottom: 5px;">
                <p style="font-size: 20px;">{{ $user->introduction }}</p>
                <span class="basic_info">本站第 {{ $user->id }} 位会员，注册于 {{ $user->created_at->diffForHumans() }}，最后活跃于{{ $user->last_actived_at->diffForHumans() }}</span>
            </div>
        </div>
        <hr>

        {{-- 用户发布的内容 --}}
        <div class="panel panel-default">
            <div class="panel-body">
                <ul class="nav nav-tabs">
                    <li class="{{ active_class(if_query('tab', null)) }}">
                        <a href="{{ route('users.show', $user->id) }}">
                            <strong>{{ ! Auth::check() || Auth::user()->id !== $user->id ? 'Ta ' : '我 ' }}</strong>的话题
                        </a>
                    </li>
                    <li class="{{ active_class(if_query('tab', 'replies')) }}">
                        <a href="{{ route('users.show', [$user->id, 'tab' => 'replies']) }}">
                            <strong>{{ ! Auth::check() || Auth::user()->id !== $user->id ? 'Ta ' : '我 ' }}</strong>的回复
                        </a>
                    </li>
                    <li class="{{ active_class(if_query('tab', 'followers')) }}">
                        <a href="{{ route('users.show', [$user->id, 'tab' => 'followers']) }}">
                            <strong>{{ ! Auth::check() || Auth::user()->id !== $user->id ? 'Ta ' : '我 ' }}</strong>的关注者
                        </a>
                    </li>

                </ul>
                @if (if_query('tab', 'replies'))
                    @include('users._replies', ['replies' => $user->replies()->with('topic')->recent()->paginate(10)])
                @elseif (if_query('tab', 'followers'))
                    @include('users._followers', ['users' => $user->followers()->paginate(10)])
                @else
                    @include('users._topics', ['topics' => $user->topics()->recent()->paginate(10)])
                @endif
            </div>
        </div>
    </div>

</div>
@stop