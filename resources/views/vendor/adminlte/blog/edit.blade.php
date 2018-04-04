@extends('adminlte::layouts.app')

@section('htmlheader_title')
    Sửa bài viết
@endsection

@section('contentheader_title')
    Quản lý bài viết
@endsection
@section('contentheader_description')
@endsection

@section('contentheader_levels')
    <li><a href="{{ url('/admincp') }}"><i class="fa fa-dashboard"></i>Trang chủ</a></li>
    <li><a href="{{ url('/admincp/blog') }}">Quản lý bài viết</a></li>
    <li class="active">Sửa bài viết</li>
@endsection

@section('main-content')
<div class="container-fluid spark-screen">

    <div class="flash-message">
        @foreach (['danger', 'warning', 'success', 'info'] as $msg)
            @if(Session::has('alert-' . $msg))
            <h4 class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }}  <button class="close" data-dismiss="alert" aria-label="close">&times;</button></h4>
            @endif
        @endforeach
    </div> <!-- end .flash-message -->

    <div class="row">
        <div class="col-md-12">
            <!-- Default box -->
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">Sửa bài viết</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form role="form" method="POST" enctype="multipart/form-data" action="{{ url('/admincp/blog/update/'. $blog->id) }}">
                        {{ csrf_field() }}
                        <!-- text input -->
                        <div class="form-group">
                            <label>Tên bài viết</label>
                            <input type="text" class="form-control" placeholder="Tên bài viết ..." name="blog-name" value="{{ $blog->name }}">
                        </div>
                        <div class="form-group">
                            <label>Nội dung bài viết</label>
                            <textarea class="ckeditor" name="blog-content" cols="80" rows="10">
                            {{ $blog->content }}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Hình đại diện</label><br />
                            <label id="upload" exist-img="{{ $blog->image }}">
                                <input type="file" name="blog-image">
                            </label>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Lưu</button>
                        </div>
                    </form>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </div>
</div>
@endsection
