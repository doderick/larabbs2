@extends('layouts.app')
@section('title', $topic->title)
@section('description', $topic->exceerpt)

@section('content')
<div class="row">
    <div class="col-lg-3 col-md-3 hidden-sm hidden-xs author-info">
        <div class="panel panel-default">
                <div class="panel-heading">
                        <div class="media text-center">
                                作者：{{ $topic->user->name }}
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="media">
                            <div align="center">
                                    <a href="{{ route('users.show', $topic->user_id) }}">
                                            <img src="{{ $topic->user->avatar }}" class="thumbnail img-responsive">
                                        </a>
                            </div>
                            @if (Auth::check())
                                <hr>
                                @include('users._follow_form')
                            @endif
                        </div>
                    </div>





{{--
                                <div class="panel-heading">
                                        <div class="media text-center">
                                                作者：{{ $topic->user->name }}
                                        </div>
                                    </div>
                            <div class="panel-body">
                                <div class="media">
                                    <div align="center">
                                        <a href="{{ route('users.show', $topic->user_id) }}">
                                            <img src="{{ $topic->user->avatar }}" class="thumbnail img-responsive">
                                        </a>
                                    </div>
                                    @if (Auth::check())
                                        <hr>
                                        @include('users._follow_form')
                                    @endif
                                </div>
                            </div> --}}
        </div>
    </div>
    <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 topic-content">
        <div class="panel panel-default">
            <div class="panel-body">
                <h1 class="text-left">
                    {{ $topic->title }}
                </h1>
                <div class="article-meta text-left">
                    <a href="{{ route('categories.show', $topic->category->id) }}">
                        <span class="glyphicon glyphicon-folder-open" aria-hidden="true"></span>
                         {{ $topic->category->name }}
                    </a>
                     •
                    <a href="{{ route('users.show', $topic->user->id) }}" title="作者：{{ $topic->user->name }}">
                         {{ $topic->user->name }}
                    </a>
                     •
                    于{{ $topic->created_at->diffForHumans() }}
                     •
                    最后回复于{{ $topic->updated_at->diffForHumans() }}
                     •
                    {{ $topic->visits()->count() }} 浏览
                     •
                    {{ $topic->reply_count }} 回帖
                    <hr>
                </div>
                <div class="topic-body">
                    {!! $topic->body !!}
                </div>
                @can ('update', $topic)
                    <div class="operate">
                        <hr>
                        <a href="{{ route('topics.edit', $topic->id) }}" role="button" class="btn btn-default btn-xs pull-left">
                            <span class="glyphicon glyphicon-edit" aria-hidden="true"></span> 编辑
                        </a>
                        <form action="{{ route('topics.destroy', $topic->id) }}" method="post">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <button type="submit" class="btn btn-default btn-xs pull-left" style="margin-left: 6px;"
                                    onclick="return function(){return confirm('删除后不可恢复，你确认要删除吗？')}()">
                                <span class="glyphicon glyphicon-trash" aria-hidden="true"></span> 删除
                            </button>
                        </form>
                    </div>
                @endcan
            </div>
        </div>
        {{-- 回帖列表 --}}
        <div class="panel panel-default topic-reply">
            <div class="panel-body">
                @includeWhen(Auth::check(), 'replies._reply_box', ['topic' => $topic])
                @include('replies._reply_list', ['replies' => $topic->replies()->with('user', 'topic')->recent()->paginate(10)])
            </div>
        </div>
    </div>
</div>
@stop