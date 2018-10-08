@extends('layouts.app')
@section('title', '我的通知')

@section('content')
<div class="container">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
            <div class="panel-body">
                <h3 class="text-center">
                    <span class="glyphicon glyphicon-bell" aria-hidden="true"></span> 我的通知
                </h3>
                <hr>
                @if ($notifications->count() > 0 )
                    <div class="notification-list">
                        @foreach ($notifications as $notification)
                            @include('notifications.types._' . snake_case(class_basename($notification->type)))
                        @endforeach
                        {!! $notifications->appends(Request::except('page'))->render()!!}
                    </div>
                @else
                    <div class="empty">没有新的消息通知！</div>
                @endif
            </div>
        </div>
    </div>
</div>
@stop