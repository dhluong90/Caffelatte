@extends('adminlte::layouts.app')

@section('htmlheader_title')
    Cập nhật món ăn
@endsection

@section('contentheader_title')
    Quản lý món ăn
@endsection
@section('contentheader_description')
@endsection

@section('contentheader_levels')
    <li><a href="{{ url('/admincp') }}"><i class="fa fa-dashboard"></i>Trang chủ</a></li>
    @if ($data['store']->status == $data['constants']::STORE_APPROVE)
        <li><a href="{{ url('/admincp/store') }}">Danh sách cửa hàng</a></li>
        <li><a href="{{ url('/admincp/food') }}">Chi tiết cửa hàng</a></li>
    @endif
    @if ($data['store']->status == $data['constants']::STORE_PENDING)
        <li><a href="{{ url('/admincp/store/pending') }}">Danh sách cửa hàng chờ duyệt</a></li>
        <li><a href="{{ url('/admincp/store/'.$data['store']->slug.'/'.$data['store']->id) }}">Chi tiết cửa hàng</a></li>
    @endif
    <li class="active">Cập nhật món ăn</li>
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
                    <h3 class="box-title">Cập nhật món ăn</h3>
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
                    <form role="form" method="POST" action="{{ url('/admincp/food/update/'.$data['food']->id) }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <!-- text input -->
                        <div class="form-group">
                            <label>Tên món ăn<span class="red">*</span></label>
                            <input type="text" class="form-control"  name="food-name" value="{{ $data['food']->name }}">
                        </div>
                        <div class="form-group">
                            <label>Đường dẫn tĩnh</label>
                            <input type="text" class="form-control"  name="food-slug" value="{{ $data['food']->slug }}">
                        </div>
                        <div class="form-group">
                            <label>Giá<span class="red">*</span></label>
                            <input type="text" class="form-control" name="food-price" value="{{ $data['food']->price }}">
                        </div>
                        <div class="form-group">
                            <label>Giá cao nhất<span class="red">*</span></label>
                            <input type="text" class="form-control" name="food-price-max" value="{{ $data['food']->price_max }}">
                        </div>
                        <div class="form-group">
                            <label>Hình ảnh đại diện<span class="red">*</span></label><br />
                            <label id="upload" exist-img="{{ $data['food']->images }}">
                                <input type="file" name="food-images">
                            </label>
                        </div>
                        <div class="form-group">
                            <label>Chi tiết món ăn</label>
                            <textarea class="ckeditor" name="food-detail" cols="80" rows="10">{{$data['food']->detail}}</textarea>
                        </div>
                        <div class="box-footer">
                            <div class="col-md-9">
                                <span class="red">Note: Bắt buộc bạn phải nhập vào các trường có dấu (*)</span>
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-primary pull-right">Lưu</button>
                            </div>
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
