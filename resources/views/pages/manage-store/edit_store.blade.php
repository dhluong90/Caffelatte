@extends('pages.layouts.app')

@section('header_title')
    Trang cập nhật cửa hàng
@endsection

@section('define-css')
    <link rel="stylesheet" type="text/css" href="{{ asset('/modules/LoadImg-master/css/loadimg.min.css') }}" />
    <link href="{{ asset('modules/alertify/alertify.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('modules/alertify/default.min.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ asset('/css/pages/store-edit.css') }}">
@endsection
@section('main-content')
    <div class="create-store-page">
        <!-- Menu Store -->
        @include('pages.manage-store.partials.menu', [
        'store_id' => $store->id
    ])
        <!-- End Menu Store -->
        <!-- Main Content -->
        <section class="section-main-form">
            <div class="container">
                <div class="row form-heading">
                    <div class="col-md-6 form-title">
                        <h4>Cập nhật cửa hàng</h4>
                    </div>
                    <div class="col-md-6 form-buttons">
                        <ul class="list-inline buttons-container">
                            <li>
                                <a href="{{ url('/profile/'.$store->user_id.'/store')}}">
                                    <i class="fa fa-angle-left" aria-hidden="true"></i>
                                    <span>Trở về</span>
                                </a>
                            </li>
                            <li>
                                <span class="btn-submit">Cập nhật</span>
                                <i class="fa fa-angle-down" aria-hidden="true"></i>
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
                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="main-form">
                    <div class="row">
                        <ul id="clientvalidate">
                            <li id="validate" style="display: none;"></li>
                        </ul>
                    </div>
                    <form action="{{ url('/manage/store/'.$store->id.'/post_edit_store') }}" class="row form-create-store" method="POST"  enctype="multipart/form-data">
                    {!! csrf_field() !!}
                        <div class="col-md-4 left-form">
                            <div class="form-group">
                                <label id="upload" class="upload-image-box" exist-img="{{ asset($ImageHelper::get_image_by_size($store->logo, '150x150')) }}">
                                    <input type="file" name="store-logo">
                                </label>
                                <div class="text-center">
                                    <span>Tải ảnh đại diện</span>
                                    <p>(Tải ảnh tối đa 10Mb)</p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6 col-sm-6 col-xs-6 open-time">
                                    <label>Giờ mở cửa&nbsp;&nbsp;<span>*</span></label>
                                    <select class="form-control" name="store-open-time" id="store_open_time">
                                        @for ($i = 0; $i <= 23; $i++)
                                        <option value="{{ ($i < 10) ? '0'.$i : $i }}:00" {{ (old('store-open-time')) ? (old('store-open-time') == $i) ? 'selected' : '' : (date("G", strtotime($store->open_time)) == $i ? 'selected' : '') }}>{{ $i }}:00</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-6 close-time">
                                    <label>Giờ đóng cửa&nbsp;&nbsp;<span>*</span></label>
                                    <select class="form-control" name="store-close-time" id="store_close_time">
                                        @for ($i = 0; $i <= 23; $i++)
                                        <option value="{{ ($i < 10) ? '0'.$i : $i }}:00" {{ (old('store-close-time')) ? (old('store-close-time') == $i) ? 'selected' : '' : (date("G", strtotime($store->close_time)) == $i ? 'selected' : '') }}>{{ $i }}:00</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="form-title">Ngày làm việc trong tuần&nbsp;&nbsp;<span>*</span></div>
                                <div class="col-md-6 col-sm-6 col-xs-6 from-date">
                                    <label>từ ngày</label>
                                    <select class="form-control" name="store-open-day" id="store_open_day">
                                        <?php
                                            $day_of_week = [
                                                '1' => 'Thứ 2',
                                                '2' => 'Thứ 3',
                                                '3' => 'Thứ 4',
                                                '4' => 'Thứ 5',
                                                '5' => 'Thứ 6',
                                                '6' => 'Thứ 7',
                                                '7' => 'Chủ nhật'
                                            ];
                                        ?>
                                        @foreach ($day_of_week as $key => $val)
                                        <option value="{{ $key }}" {{ (old('store-open-day')) ? (old('store-open-day') == $key) ? 'selected' : '' : ($store->open_day == $key) ? 'selected' : '' }}>{{ $val }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-6 to-date">
                                    <label>tới ngày</label>
                                    <select class="form-control" name="store-close-day" id="store_close_day">
                                        @foreach ($day_of_week as $key => $val)
                                        <option value="{{ $key }}" {{ (old('store-close-day')) ? (old('store-close-day') == $key) ? 'selected' : '' : ($store->close_day == $key) ? 'selected' : '' }}>{{ $val }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-buttons">
                                <ul class="list-inline buttons-container">
                                    <li style="display: none">
                                        <a href="">
                                            <span class="btn-reset">Làm lại</span>
                                        </a>
                                    </li>
                                    <li class="delete-background">
                                        <a href="{{ url('/manage/store/'.$store->id.'/delete') }}" class="btn-delete">
                                            <span>Xóa cửa hàng</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-8 right-form">
                            <div class="form-group row">
                                <div class="col-md-3 input-heading">
                                    <label>Tên cửa hàng&nbsp;&nbsp;<span>*</span></label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" name="store-name" value="{{ (old('store-name')) ? old('store-name') : $store->name }}" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 input-heading">
                                    <label>Mô tả chi tiết&nbsp;&nbsp;<span>*</span></label>
                                </div>
                                <div class="col-md-9">
                                    <textarea name="store-introduction" rows="6">{{ (old('store-introduction')) ? old('store-introduction') : $store->introduction }}</textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 input-heading">
                                    <label>Lĩnh vực&nbsp;&nbsp;<span>*</span></label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" id="storeSector" name="store-sector" value="{{ (old('store-sector')) ? old('store-sector') : $store->sector }}" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 input-heading">
                                    <label>Địa chỉ&nbsp;&nbsp;<span>*</span></label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" id="storeAddress" name="store-address" value="{{ (old('store-address')) ? old('store-address') : $store->address }}" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 input-heading">
                                    <label>Điện thoại&nbsp;&nbsp;<span>*</span></label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" id="storePhone" name="store-phone" value="{{ (old('store-phone')) ? old('store-phone') : $store->phone }}" class="form-control" maxlength="12">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 input-heading">
                                    <label>Facebook</label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" name="store-facebook" value="{{ (old('store-facebook')) ? old('store-facebook') : $store->facebook }}" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 input-heading">
                                    <label>Website</label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" name="store-site-url" value="{{ (old('store-site-url')) ? old('store-site-url') : $store->site_url }}" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 input-heading">
                                    <label>Email</label>
                                </div>
                                <div class="col-md-9">
                                    <input type="email" name="store-email" value="{{ (old('store-email')) ? old('store-email') : $store->email }}" class="form-control">
                                </div>
                            </div>
                            <div class="branches">
                                <span class="branch-heading">Chi nhánh</span>
                                <div class="form-group branches-container">
                                @if (!empty($store->branch))
                                <?php $i = 1 ?>
                                @foreach (json_decode($store->branch) as $item_branch)
                                    <div class="row branch">
                                        <div class="col-md-2 input-heading">
                                            <label>Chi nhánh&nbsp;{{ $i }}</label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="text" name="store-branch[]" class="form-control store-branch" value="{{ $item_branch}}" placeholder="Địa chỉ">
                                        </div>
                                        <div class="col-md-1 remove-branch">
                                            <a href="" class="btn-remove-branch">
                                                <i class="fa fa-minus" aria-hidden="true"></i>
                                            </a>
                                        </div>
                                    </div>
                                <?php $i++ ?>
                                @endforeach
                                @endif
                                    <div class="row more-branch">
                                        <a href="" class="btn-more-branch">
                                            <i class="fa fa-plus" aria-hidden="true"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="form-buttons">
                            <ul class="list-inline buttons-container">
                                <li style="display: none;">
                                    <a href="">
                                        <i class="fa fa-angle-left" aria-hidden="true"></i>
                                        <span class="btn-reset">Làm lại</span>
                                    </a>
                                </li>
                                <li>
                                    <span class="btn-submit">Cập nhật</span>
                                    <i class="fa fa-angle-down" aria-hidden="true"></i>
                                </li>
                            </ul>
                        </div>
                    </form>
                </div>
            </div>
        </section>
        <!-- End Main Content -->
    </div>
@endsection
@section('define-js')
    <script src="{{ asset('/modules/LoadImg-master/js/loadimg.min.js') }}"></script>
    <script src="{{ asset('/modules/alertify/alertify.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/js/pages/store-edit.js') }}"></script>
@endsection