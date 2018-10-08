@extends('layouts.app')
@section('title', '编辑资料')

@section('content')
<div class="container">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4>
                    <span class="glyphicon glyphicon-edit" aria-hidden="true"></span> 编辑资料
                </h4>
            </div>
            {{-- 引入错误消息视图 --}}
            @include('public.error')
            <div class="panel-body">
                <form action="{{ route('users.update', $user->id) }}" method="post" enctype="multipart/form-data" accept-charset="UTF-8">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}

                    <div class="form-group">
                        <label for="name-field">用户名</label>
                        <input type="text" name="name" id="name-field" class="form-control" value="{{ old('name', $user->name) }}">
                    </div>
                    <div class="form-group">
                        <label for="name-field">邮箱地址</label>
                        <input type="email" name="email" id="email-field" class="form-control" value="{{ $user->email }}" disabled>
                    </div>
                    <div class="form-group">
                        <label for="introduction-field">个人简介</label>
                        <textarea name="introduction" id="introduction-field" rows="3" class="form-control" value="{{ old('introduction', $user->introduction) }}"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="avatar-field">用户头像</label>
                        <input type="file" name="avatar" id="avatar-field">

                        @if ($user->avatar)
                            <img src="{{ $user->avatar }}" class="thumbnail img-responsive">
                        @endif
                    </div>
                    <div class="well well-sm">
                        <button type="submit" class="btn btn-primary">保存</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@stop