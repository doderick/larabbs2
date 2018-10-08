@extends('layouts.app')
@section('title', $title)

@section('content')
<div class="row">
    <div class="col-lg-3 col-md-3 hidden-sm hidden-xs user-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="media text-center">
                    <h4>{{ $user->name }}</h4>
                </div>
            </div>
            <div class="panel-body">
                <div class="media">
                    <div align="center">
                        <img src="{{ $user->avatar }}" class="thumbnail img-responsive">
                    </div>
                    @include('users._user_info')
                    @if (Auth::check())
                        <hr>
                        @include('users._follow_form')
                    @endif
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="media text-center">
                    @include('users._user_link')
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
        <div class="breadcrumb">
            <a href="{{ route('users.show', $user->id) }}">
                个人中心
            </a>
            @switch($title)
                @case('帖子列表')
                     / Ta 发布的帖子（{{ $user->topic_count }}）
                    @break
                @case('回帖列表')
                     / Ta 发布的回帖（{{ $user->reply_count }}）
                    @break
                @case('关注者列表')
                     / Ta 的关注者（{{ $user->followers()->count() }}）
                    @break
                @case('关注列表')
                     / Ta 关注的用户（{{ $user->followings()->count() }}）
                    @break
                @default
                    @break
            @endswitch
        </div>
        <div class="panel panel-default">
            <div class="panel-body">
                @if ($title == '帖子列表')
                    @include('users._topics')
                @elseif ($title == '回帖列表')
                    @include('users._replies')
                @elseif ($title == '关注者列表')
                    @include('users._followers')
                @elseif ($title == '关注列表')
                    @include('users._followings')
                @endif
            </div>
        </div>
    </div>
</div>
@stop