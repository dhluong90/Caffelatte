@extends('pages.layouts.app')

@section('header_title')
    Trang thông tin người dùng
@endsection

@section('main-content')
    <link rel="stylesheet" href="{{ asset('/css/pages/profile-user.css') }}">
    <div class="profile">
        <!-- Menu user -->
        @include('pages.profile.partials.menu')
        <!-- End Menu user -->
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
                                <a href="{{ url('/') }}">
                                    <i class="fa fa-angle-left" aria-hidden="true"></i>
                                    <span class="btn-reset">Trở lại trang chủ</span>
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
                    <form  class="row form-profile">
                        <div class="col-md-4 left-form">
                            <div class="form-group">
                                <div class="profile-avatar-container">
                                    <img src="{{ ($user->image) ? asset($ImageHelper::get_image_by_size($user->image, '150x150')) : asset('/img/website/avatar_default.jpg') }}" alt="" class="img-responsive">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8 right-form">
                            <div class="form-group row">
                                <div class="col-md-3 input-heading">
                                    <label>Tài khoản:</label>
                                </div>
                                <div class="col-md-9 profile-text">
                                    <span>{{ $user->name }}</span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 input-heading">
                                    <label>Điện thoại:</label>
                                </div>
                                <div class="col-md-9 profile-text">
                                    <span>{{ $user->phone }}</span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 input-heading">
                                    <label>Email:</label>
                                </div>
                                <div class="col-md-9 profile-text">
                                    <span>{{ $user->email }}</span>
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
                        @if ($can_manage_profile)
                        <div class="form-buttons">
                            <ul class="list-inline buttons-container">
                                <li>
                                    <a href="{{ url('profile/' . $user->id . '/edit') }}">
                                        <span class="btn-reset">Chỉnh sửa</span>
                                        <i class="fa fa-angle-right fa-custom" aria-hidden="true"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        @endif
                    </form>
                </div>
            </div>
        </section>
        <!-- End Main Content -->
    </div>
    <script src="{{ asset('/js/pages/profile-user.js') }}"></script>
@endsection