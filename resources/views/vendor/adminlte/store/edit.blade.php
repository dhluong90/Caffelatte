@extends('adminlte::layouts.app')

@section('htmlheader_title')
    Cập nhật cửa hàng
@endsection

@section('contentheader_title')
    Quản lý cửa hàng
@endsection
@section('contentheader_description')
@endsection
@section('contentheader_levels')
    <li><a href="{{ url('/admincp') }}"><i class="fa fa-dashboard"></i>Trang chủ</a></li>
    @if ($store->status == $Constants::STORE_PENDING)
    <li><a href="{{ url('/admincp/store/pending') }}">Danh sách cửa hàng chờ duyệt</a></li>
    @endif
    @if ($store->status == $Constants::STORE_APPROVE)
    <li><a href="{{ url('/admincp/store') }}">Danh sách cửa hàng</a></li>
    @endif
    <li class="active">Cập nhật cửa hàng</li>
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
                    <h3 class="box-title">Cập nhật cửa hàng</h3>
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
                    <form role="form" method="POST" action="{{ url('/admincp/store/update/'.$store->id) }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <!-- text input -->
                        <div class="form-group col-md-6">
                            <label>Tên cửa hàng <span class="red">*</span></label>
                            <input type="text" class="form-control" name="store-name" value="{{ (old('store-name')) ? old('store-name') : $store->name }}">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Đường dẫn tĩnh</label>
                            <input type="text" class="form-control" placeholder="Tên đường dẫn tĩnh ..." name="store-slug" value="{{ (old('store-slug')) ? old('store-slug') : $store->slug }}">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Địa chỉ <span class="red">*</span></label>
                            <input type="text" class="form-control" placeholder="Địa chỉ cửa hàng ..." name="store-address" value="{{ (old('store-address')) ? old('store-address') : $store->address }}">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Số điện thoại <span class="red">*</span></label>
                            <input type="text" class="form-control" placeholder="Số điện thoại ..." name="store-phone" value="{{ (old('store-phone')) ? old('store-phone') : $store->phone }}">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Lĩnh vực</label>
                            <input type="text" class="form-control" placeholder="Lĩnh vực ..." name="store-sector" value="{{ (old('store-sector')) ? old('store-sector') : $store->sector }}">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Email</label>
                            <input type="email" class="form-control" placeholder="Email ..." name="store-email" value="{{ (old('store-email')) ? old('store-email') : $store->email }}">
                        </div>
                        <div class="form-group col-md-3">
                            <label>Giờ mở cửa <span class="red">*</span></label>
                            <select class="form-control" name="store-open-time" id="store_open_time">
                                <option value="{{$store->open_time}}">{{ date("G:i", strtotime($store->open_time)) }}</option>
                                <option value="0:00">0:00</option>
                                <option value="1:00">1:00</option>
                                <option value="2:00">2:00</option>
                                <option value="3:00">3:00</option>
                                <option value="4:00">4:00</option>
                                <option value="5:00">5:00</option>
                                <option value="6:00">6:00</option>
                                <option value="7:00">7:00</option>
                                <option value="8:00">8:00</option>
                                <option value="9:00">9:00</option>
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
                        <div class="form-group col-md-3">
                            <label>Giờ đóng cửa <span class="red">*</span></label>
                            <select class="form-control" name="store-close-time" id="store_close_time">
                                <option value="{{$store->close_time}}">{{ date("G:i", strtotime($store->close_time)) }}</option>
                                <option value="0:00">0:00</option>
                                <option value="1:00">1:00</option>
                                <option value="2:00">2:00</option>
                                <option value="3:00">3:00</option>
                                <option value="4:00">4:00</option>
                                <option value="5:00">5:00</option>
                                <option value="6:00">6:00</option>
                                <option value="7:00">7:00</option>
                                <option value="8:00">8:00</option>
                                <option value="9:00">9:00</option>
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
                        <div class="form-group col-md-6">
                            <label>Facebook</label>
                            <input type="text" class="form-control" placeholder="Facebook ..." name="store-facebook" value="{{ (old('store-facebook')) ? old('store-facebook') : $store->facebook }}">
                        </div>
                        
                        <div class="form-group col-md-12">
                            <label>Logo <span class="red">*</span></label><br />
                            <label id="upload" exist-img="{{ asset($ImageHelper::get_image_by_size($store->logo, '150x150')) }}">
                                <input type="file" name="store-logo">
                            </label>
                        </div>
                        <div class="form-group col-md-12">
                            <label>Giới thiệu cửa hàng</label>
                            <textarea class="ckeditor" name="store-introdoction" cols="80" rows="10">{{$store->introduction}}</textarea>
                        </div>
                        <div lass="form-group col-md-12">
                            <div class="col-md-9">
                                <span class="red">Note: Bắt buộc bạn phải nhập vào các trường có dấu (*)</span>
                            </div>
                            <div class="box-footer col-md-3">
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
