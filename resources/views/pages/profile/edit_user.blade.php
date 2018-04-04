@extends('pages.layouts.app')

@section('header_title')
    Trang cập nhật người dùng
@endsection

@section('main-content')
    <link rel="stylesheet" type="text/css" href="{{ asset('/modules/LoadImg-master/css/loadimg.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('/css/pages/profile-user-edit.css') }}">
    <div class="edit-profile">
        <!-- End Tab Bar -->
        <!-- Tab Bar -->
        @include('pages.profile.partials.menu')
        <!-- End Tab Bar -->
        <!-- Main Content -->
        <section class="section-main-form">
            <div class="container">
                <div class="row form-heading">
                    <div class="col-md-6 form-title">
                        <h4>Thông tin</h4>
                    </div>
                    <div class="col-md-6 form-buttons">
                        <ul class="list-inline buttons-container">
                            <li>
                                <a href="{{ url('profile/' . $user->id) }}">
                                    <i class="fa fa-angle-left" aria-hidden="true"></i>
                                    <span class="btn-back">Trở về</span>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0)">
                                    <span class="btn-submit">Cập nhật</span>
                                    <i class="fa fa-angle-down" aria-hidden="true"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="divider"></div>
                <div class="flash-message">
                    @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                        @if(Session::has('alert-' . $msg))
                            <h4 class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }}  <button class="close" data-dismiss="alert" aria-label="close">&times;</button></h4>
                        @endif
                    @endforeach
                </div> <!-- end .flash-message -->
                <div class="main-form">
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{ url('profile/' . $user->id . '/update') }}" class="row form-profile" method="POST"  enctype="multipart/form-data">
                    {!! csrf_field() !!}
                        <div class="col-md-4 left-form">
                            <div class="form-group">
                                <label id="upload" class="upload-image-box" exist-img="{{ ($user->image) ? asset($ImageHelper::get_image_by_size($user->image, '300x300')) : asset('/img/website/avatar_default.jpg') }} ">
                                    <input type="file" name="profile-image">
                                </label>
                                <div class="text-center">
                                    <span>Tải ảnh đại diện</span>
                                    <p>(Tải ảnh tối đa 10Mb)</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8 right-form">
                            <div class="form-group row">
                                <div class="col-md-4 input-heading">
                                    <label>Tài khoản</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" name="profile-name" value="{{ (old('profile-name')) ? old('profile-name') : $user->name }}" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4 input-heading">
                                    <label>Mật khẩu cũ</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="password" name="profile-old-password" value="" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4 input-heading">
                                    <label>Mật khẩu mới</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="password" name="profile-new-password" value="" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4 input-heading">
                                    <label>Nhập lại mật khẩu mới</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="password" name="profile-re-new-password" value="" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4 input-heading">
                                    <label>Điện thoại</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" name="profile-phone" value="{{ (old('profile-phone')) ? old('profile-phone') : $user->phone }}" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12 manage-heading">
                                    <span>Quản lý</span>
                                </div>
                                <div class="col-md-12 manage">
                                    <div class="col-md-6 manage-store">
                                        <span>{{ $count_stores }}</span></br>
                                        <a href="{{ url('profile/' . $user->id . '/store') }}">Cửa hàng</a>
                                    </div>   
                                    <div class="col-md-6 manage-cook">
                                        <span>0</span></br>
                                        <a href="javascript:void(0)">Cách nấu</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="form-buttons">
                            <ul class="list-inline buttons-container">
                                <li>
                                    <a href="{{ url('profile/' . $user->id) }}">
                                        <i class="fa fa-angle-left" aria-hidden="true"></i>
                                        <span class="btn-delete-account">Trở về</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)">
                                        <span class="btn-submit">Cập nhật</span>
                                        <i class="fa fa-angle-down" aria-hidden="true"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </form>
                </div>
            </div>
        </section>
        <!-- End Main Content -->
    </div>
    <script src="{{ asset('/js/pages/profile-user-edit.js') }}"></script>
    <script src="{{ asset('/modules/LoadImg-master/js/loadimg.min.js') }}"></script>
@endsection