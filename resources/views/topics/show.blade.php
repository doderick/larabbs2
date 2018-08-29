@extends('layouts.app')
@section('title', $topic->title)

@section('content')
<div class="row">

    <div class="col-lg-3 col-md-3 hidden-sm hidden-xs author-info">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="text-center">
                    作者： {{ $topic->user->name }}
                </div>
                <hr>
                <div class="media">
                    <a href="{{ route('users.show', $topic->user->id) }}">
                        <img src="{{ $topic->user->avatar }}" class="thumbnail img-responsive" width="300px" height="300px">
                    </a>
                </div>
                <hr>
                <div class="col-xs-12">
                    @if (Auth::check())

                        @include('users._follow_form')
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 topic-content">
        <div class="panel panel-default">
            <div class="panel-body">
                <h1 class="text-center">
                    {{ $topic->title }}
                </h1>
                <div class="article-meta text-center">
                    {{ $topic->created_at->diffForHumans() }}
                    ⋅
                    <span class="glyphicon glyphicon-comment" aria-hidden="true"></span>
                    {{ $topic->reply_count }}
                </div>
                <div class="topic-body">
                    {!! $topic->body !!}
                </div>
                @can ('update', $topic)
                    <div class="operate">
                        <hr>
                        <a href="{{ route('topics.edit', $topic->id) }}" role="button" class="btn btn-default btn-xs pull-left">
                            <span class="glyphicon glyphicon-edit"></span> 编辑
                        </a>
                        <form action="{{ route('topics.destroy', $topic->id) }}" method="post">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <button type="submit" class="btn btn-default btn-xs pull-left" style="margin-left: 6px;"
                                    onclick="return function(){return confirm('删除后不可恢复，你确认要删除吗？')}()">
                                <span class="glyphicon glyphicon-trash"></span> 删除
                            </button>
                        </form>

                    </div>
                @endcan
            </div>
        </div>

        {{-- 用户回复列表 --}}
        <div class="panel panel-default topic-reply">
            <div class="panel-body">
                @includeWhen(Auth::check(), 'topics._reply_box', ['topic' => $topic])
                @include('topics._reply_list', ['replies' => $topic->replies()->with('user', 'topic')->recent()->paginate(10)])
            </div>
        </div>
    </div>

</div>
@stop