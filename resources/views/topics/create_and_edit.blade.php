@extends('layouts.app')
@section('title', $topic->id ? '编辑帖子' : '发布新帖子')

@section('content')
<div class="container">
    <div class="col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1">
        <div class="panel panel-default">
            <div class="panel-body">
                <h2 class="text-left">
                    <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                    @if ($topic->id)
                        编辑帖子
                    @else
                        新建帖子
                    @endif
                </h2>
                <hr>
                @include('public.error')
                @if ($topic->id)
                    <form action="{{ route('topics.update', $topic->id) }}" method="post" accept-charset="UTF-8">
                        <input type="hidden" name="_method" value="PUT">
                @else
                    <form action="{{ route('topics.store') }}" method="post" accept-charset="UTF-8">
                @endif
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group">
                        <input type="text" name="title" class="form-control" value="{{ old('title', $topic->title) }}"
                            placeholder="请填写标题">
                    </div>
                    <div class="form-group">
                        <select name="category_id" class="form-control">
                            <option value="" hidden disabled {{ $topic->id ?: 'selected' }}>请选择分类</option>
                            @foreach ($categories as $value)
                                <option value="{{ $value->id }}" {{ $value->id === $topic->category_id ? 'selected' : '' }}>{{ $value->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <textarea name="body" id="editor" rows="3" class="form-control" placeholder="请填入至少三个字符的内容~">{{ old('body', $topic->body) }}</textarea>
                    </div>
                    <div class="well well-sm">
                        <button type="submit" class="btn btn-primary">
                            <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                             {{ $topic->id ? ' 保存' : ' 发布' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@stop

@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/simditor.css') }}">
@stop
@section('scripts')
    <script type="text/javascript" src="{{ asset('js/module.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/hotkeys.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/uploader.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/simditor.js') }}"></script>
    <script>
        $(document).ready(function(){
            var editor = new Simditor({
                textarea: $('#editor'),
                upload: {
                    url: '{{ route('topics.upload_image') }}',
                    params: { _token: '{{ csrf_token() }}' },
                    fileKey: 'upload_file',
                    connectionCount: 3,
                    leaveConfirm: '文件上传中，关闭此页面将取消上传。',
                },
                pasteImage: true
            });
        });
    </script>
@stop