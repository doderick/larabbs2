@extends('layouts.app')
@section('title', $user->name . '的主页')

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
        <div class="panel panel-default">
            <div class="panel-heading text-center">
                <h5>用户最近发表过的帖子</h5>
            </div>
            <div class="panel-body">
                @include('users._topics')
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading text-center">
                <h5>用户最近发表过的回复</h5>
            </div>
            <div class="panel-body">
                @include('users._replies')
            </div>
        </div>
    </div>
</div>
@stop