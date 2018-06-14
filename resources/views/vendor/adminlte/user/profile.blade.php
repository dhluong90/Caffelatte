@extends('adminlte::layouts.app')

@section('htmlheader_title')
    Thông tin người dùng
@endsection

@section('contentheader_title')
    Quản lý thông tin người dùng
@endsection
@section('contentheader_description')
@endsection

@section('contentheader_levels')
    <li><a href="{{ url('/admincp') }}"><i class="fa fa-dashboard"></i>Trang chủ</a></li>
    <li class="active">Thông tin người dùng</li>
@endsection

@section('main-content')
<div class="container-fluid spark-screen">

    <div class="flash-message">
        @foreach (['danger', 'warning', 'success', 'info'] as $msg) @if(Session::has('alert-' . $msg))
        <?php //var_dump(session()->all()); ?>
        <h4 class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }}  <button class="close" data-dismiss="alert" aria-label="close">&times;</button></h4> @endif @endforeach
    </div>

    <div class="row">
        <div class="col-md-12">
            <!-- Default box -->
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">Thông tin người dùng</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div id="example2_wrapper" class="dataTables_wrapper dt-bootstrap">
                        <div class="row">
                            <div class="main-form col-md-12">
                                @if (count($errors) > 0)
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <form action="{{ url('admincp/user/profile/' . $user_profile->id . '/update') }}" class="form-profile" method="POST"  enctype="multipart/form-data">
                                {!! csrf_field() !!}
                                    <div class="row form-group">
                                        <div class="col-md-3 input-heading">
                                            <label>Tên</label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="text" name="profile-name" value="{{ (old('profile-name')) ? old('profile-name') : $user_profile->name }}" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-md-3 input-heading">
                                            <label>Mật khẩu cũ</label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="password" name="profile-old-password" value="" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-md-3 input-heading">
                                            <label>Mật khẩu mới</label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="password" name="profile-new-password" value="" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-md-3 input-heading">
                                            <label>Nhập lại mật khẩu mới</label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="password" name="profile-re-new-password" value="" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-md-3"></div>
                                        <div class="col-md-9">
                                            <button type="submit" class="btn btn-primary">Cập nhật</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </div>
</div>
@endsection
