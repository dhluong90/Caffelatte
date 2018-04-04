@extends('pages.layouts.app')

@section('header_title')
    Trang tạo mới cửa hàng
@endsection

@section('main-content')
    <link rel="stylesheet" type="text/css" href="{{ asset('/modules/LoadImg-master/css/loadimg.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('/css/pages/store-create.css') }}">
    <div class="create-store-page">
        <!-- Menu Store -->
        @include('pages.profile.partials.menu')
        <!-- End Menu Store -->
        <!-- Main Content -->
        <section class="section-main-form">
            <div class="container">
                <div class="row form-heading">
                    <div class="col-md-6 form-title">
                        <h4>Tạo cửa hàng</h4>
                    </div>
                    <div class="col-md-6 form-buttons">
                        <ul class="list-inline buttons-container">
                            <li>
                                <a href="{{ url('profile/' . Auth::user()->id . '/store') }}">
                                    <i class="fa fa-angle-left" aria-hidden="true"></i>
                                    <span class="btn-reset">Trở về</span>
                                </a>
                            </li>
                            <li>
                                <span class="btn-submit">Hoàn tất</span>
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
                    <form action="{{ url('profile/' . $user->id . '/post_create_store') }}" class="row form-create-store" method="POST" enctype="multipart/form-data">
                        {!! csrf_field() !!}
                        <div class="col-md-4 left-form">
                            <div class="form-group">
                                <label id="upload" class="upload-image-box">
                                    <input type="file" name="store-logo" id="store-logo">
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
                                        <option value="{{ (old('store-open-time')) ? old('store-open-time') : '' }}">{{ (old('store-open-time')) ? old('store-open-time') : '--' }}</option>
                                        <option value="00:00">0:00</option>
                                        <option value="01:00">1:00</option>
                                        <option value="02:00">2:00</option>
                                        <option value="03:00">3:00</option>
                                        <option value="04:00">4:00</option>
                                        <option value="05:00">5:00</option>
                                        <option value="06:00">6:00</option>
                                        <option value="07:00">7:00</option>
                                        <option value="08:00">8:00</option>
                                        <option value="09:00">9:00</option>
                                        <option value="10:00">10:00</option>
                                        <option value="11:00">11:00</option>
                                        <option value="12:00">12:00</option>
                                        <option value="13:00">13:00</option>
                                        <option value="14:00">14:00</option>
                                        <option value="15:00">15:00</option>
                                        <option value="16:00">16:00</option>
                                        <option value="17:00">17:00</option>
                                        <option value="18:00">18:00</option>
                                        <option value="19:00">19:00</option>
                                        <option value="20:00">20:00</option>
                                        <option value="21:00">21:00</option>
                                        <option value="22:00">22:00</option>
                                        <option value="23:00">23:00</option>
                                    </select>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-6 close-time">
                                    <label>Giờ đóng cửa&nbsp;&nbsp;<span>*</span></label>
                                    <select class="form-control" name="store-close-time" id="store_close_time">
                                        <option value="{{ (old('store-close-time')) ? old('store-close-time') : '' }}">{{ (old('store-close-time')) ? old('store-close-time') : '--' }}</option>
                                        <option value="00:00">0:00</option>
                                        <option value="01:00">1:00</option>
                                        <option value="02:00">2:00</option>
                                        <option value="03:00">3:00</option>
                                        <option value="04:00">4:00</option>
                                        <option value="05:00">5:00</option>
                                        <option value="06:00">6:00</option>
                                        <option value="07:00">7:00</option>
                                        <option value="08:00">8:00</option>
                                        <option value="09:00">9:00</option>
                                        <option value="10:00">10:00</option>
                                        <option value="11:00">11:00</option>
                                        <option value="12:00">12:00</option>
                                        <option value="13:00">13:00</option>
                                        <option value="14:00">14:00</option>
                                        <option value="15:00">15:00</option>
                                        <option value="16:00">16:00</option>
                                        <option value="17:00">17:00</option>
                                        <option value="18:00">18:00</option>
                                        <option value="19:00">19:00</option>
                                        <option value="20:00">20:00</option>
                                        <option value="21:00">21:00</option>
                                        <option value="22:00">22:00</option>
                                        <option value="23:00">23:00</option>
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
                                        <option value="">--</option>
                                        @foreach ($day_of_week as $key => $val)
                                        <option value="{{ $key }}" {{ (old('store-open-day')) ? (old('store-open-day') == $key) ? 'selected' : '' : '' }}>{{ $val }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-6 to-date">
                                    <label>tới ngày</label>
                                    <select class="form-control" name="store-close-day" id="store_close_day">
                                        <option value="">--</option>
                                        @foreach ($day_of_week as $key => $val)
                                        <option value="{{ $key }}" {{ (old('store-close-day')) ? (old('store-close-day') == $key) ? 'selected' : '' : '' }}>{{ $val }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8 right-form">
                            <div class="form-group row">
                                <div class="col-md-3 input-heading">
                                    <label>Tên cửa hàng&nbsp;&nbsp;<span>*</span></label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" id="storeName" name="store-name" value="{{ old('store-name') }}" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 input-heading">
                                    <label>Mô tả chi tiết&nbsp;&nbsp;<span>*</span></label>
                                </div>
                                <div class="col-md-9">
                                    <textarea name="store-introduction" id="storeIntroduction" rows="6" class="form-control">{{ old('store-introduction') }}</textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 input-heading">
                                    <label>Lĩnh vực&nbsp;&nbsp;<span>*</span></label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" id="storeSector" name="store-sector" value="{{ old('store-sector') }}" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 input-heading">
                                    <label>Địa chỉ&nbsp;&nbsp;<span>*</span></label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" id="storeAddress" name="store-address" value="{{ old('store-address') }}" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 input-heading">
                                    <label>Điện thoại&nbsp;&nbsp;<span>*</span></label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" id="storePhone" name="store-phone" value="{{ old('store-phone') }}" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 input-heading">
                                    <label>Facebook</label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" name="store-facebook" value="{{ old('store-facebook') }}" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 input-heading">
                                    <label>Website</label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" name="store-site-url" value="{{ old('store-site-url') }}" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 input-heading">
                                    <label>Email</label>
                                </div>
                                <div class="col-md-9">
                                    <input type="email" name="store-email" value="{{ old('store-email') }}" class="form-control">
                                </div>
                            </div>
                            <div class="branches">
                                <span class="branch-heading">Chi nhánh</span>
                                <div class="form-group branches-container">
                                    <div class="row branch">
                                        <div class="col-md-2 input-heading">
                                            <label>Chi nhánh 1</label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="text" name="store-branch[1]" id="branch1" class="form-control store-branch" value="" placeholder="Địa chỉ">
                                        </div>
                                        <div class="col-md-1 remove-branch">
                                            <a href="" class="btn-remove-branch">
                                                <i class="fa fa-minus" aria-hidden="true"></i>
                                            </a>
                                        </div>
                                    </div>
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
                                <li>
                                    <a href="">
                                        <i class="fa fa-angle-left" aria-hidden="true"></i>
                                        <span class="btn-reset">Làm lại</span>
                                    </a>
                                </li>
                                <li>
                                    <span class="btn-submit">Hoàn tất</span>
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
    <script src="{{ asset('/js/pages/store-create.js') }}"></script>
    <script src="{{ asset('/modules/LoadImg-master/js/loadimg.min.js') }}"></script>
@endsection