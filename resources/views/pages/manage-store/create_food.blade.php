@extends('pages.layouts.app')

@section('header_title')
    Tạo món ăn 
@endsection

@section('define-css')
    <link href="{{ asset('modules/LoadImg-master/css/loadimg.min.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ asset('/css/pages/food-create.css') }}">
@endsection 

@section('main-content')
<div class="create-food-page">
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
                    <h4>Tạo sản phẩm mới</h4>
                </div>
                <div class="col-md-6 form-buttons">
                    <ul class="list-inline buttons-container">
                        <li>
                            <a href="{{ url('/manage/store/'.$store->id.'/food')}}">
                                <i class="fa fa-angle-left" aria-hidden="true"></i>
                                <span>Trở về</span>
                            </a>
                        </li>
                        <li>
                            <a href="" class="btn-submit">
                                <span>Hoàn tất</span>
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
            </div>
            <!-- end .flash-message -->
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
                <form action="{{ url('/manage/store/' . $store->id . '/post_create_food') }}" class="row form-create-food" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="col-md-4 left-form">
                        <div class="form-group upload-image-container">
                            <label id="upload" class="upload-image-box">
                                <input type="file" class="food-logo" name="food-logo">
                            </label>
                            <div class="text-center">
                                <span>Tải ảnh sản phẩm</span>
                                <p>(Tải ảnh tối đa 10Mb)</p>
                            </div>
                        </div>
                        <div class="form-group row left-form-item price-range">
                            <div class="price-title">Giá bán&nbsp;&nbsp;<span>*</span></div>
                            <div class="col-md-6 col-sm-3 col-xs-4 radio">
                                <label>
                                    <input type="radio" class="btn-set-price" name="opt_price" checked value="one-price">Một giá</label>
                            </div>
                            <div class="col-md-6 col-sm-9 col-xs-8 reset-padding-right">
                                <input type="text" name="food-price" class="form-control set-price" value="{{ old('food-price') }}" placeholder="Đồng">
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12 radio">
                                <label>
                                    <input type="radio" class="btn-set-price-range" name="opt_price" value="range-price">Khung giá</label>
                            </div>
                            <div class="from-price-container">
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <span>Từ</span>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-6 reset-padding-right">
                                    <input type="text" name="food-price-from" class="form-control set-price-range" disabled="disabled" value="{{ old('food-price-from') }}" placeholder="Đồng">
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="to-price-container">
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <span>đến</span>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-6 reset-padding-right">
                                    <input type="text" name="food-price-to" class="form-control set-price-range" disabled="disabled" value="{{ old('food-price-to') }}" placeholder="Đồng">
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <div class="form-group row left-form-item currency" style="display: none;">
                            <div class="col-md-6 col-sm-6 col-xs-6 reset-padding-left">Đơn vị tính</div>
                            <div class="col-md-6 col-sm-6 col-xs-6 reset-padding-right">
                                <input type="text" name="food-currency" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row left-form-item tags">
                            <div class="pick-category">
                                <label for="sel1">Chọn thể loại:</label>
                                <select class="form-control" id="food-category" name="food-category">
                                    @foreach ($categories as $item_parent)
                                        @if($item_parent->parent_id == 0)
                                            <option disabled="" value="{{ $item_parent->id }}"><b>{{ $item_parent->name }}</b></option>
                                        @foreach($categories as $item_child)
                                            @if($item_parent->id == $item_child->parent_id)
                                                <option {{ (old("food-category") == $item_child->id) ? "selected" : "" }} value="{{ $item_child->id }}">{{ '&nbsp;&nbsp;&nbsp;&nbsp;' . $item_child->name }}</option>
                                            @endif
                                        @endforeach
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row left-form-item tags">
                            <div class="col-md-6 col-sm-6 col-xs-6 reset-padding-left">Tag</div>
                            <div class="col-md-6 col-sm-6 col-xs-6 reset-padding-right">
                                <a href="" class="btn-more-tag"><i class="fa fa-plus" aria-hidden="true"></i></a>
                                <span class="span-more-tag">Thêm lựa chọn</span>
                                <div class="dropdown-wp">
                                    <div class="dropdown-content">
                                        <h3>Tag </h3>
                                        <hr>
                                        <div class="list-all-tags">
                                            @foreach ($tags as $tag)
                                            <div>
                                                <input class="tag" readonly value="{{ $tag->id }}"><span>{{ $tag->name }}</span><i class="fa fa-times btn-remove-tag" aria-hidden="true"></i>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tags-container">
                                <div>
                                    <input type="hidden" class="tag validate-tag" name="tags[]" readonly="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8 right-form">
                        <div class="form-group row">
                            <div class="col-md-3 input-heading">
                                <label>Tên sản phẩm&nbsp;&nbsp;<span>*</span></label>
                            </div>
                            <div class="col-md-9">
                                <input type="text" name="food-name" class="form-control" value="{{ old('food-name') }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 input-heading">
                                <label>Mô tả chi tiết&nbsp;&nbsp;<span>*</span></label>
                            </div>
                            <div class="col-md-9">
                                <textarea name="food-description" id="" rows="6" class="form-control">{{ old('food-description') }}</textarea>
                            </div>
                        </div>
                        <div class="guides">
                            <span class="guide-heading">Hướng dẫn</span>
                            <div class="form-group guide-steps-container">
                                <div class="row guide-step">
                                    <div class="col-md-10 guide-step-number">
                                        <h5>Bước 1</h5>
                                    </div>
                                    <div class="col-md-2 remove-step">
                                        <a href="" class="btn-remove-step">
                                            <i class="fa fa-minus" aria-hidden="true"></i>
                                        </a>
                                    </div>
                                    <div class="col-md-7 guide-step-title">
                                        <input type="text" class="form-control" name="food-step-title[1]" value="{{ old('food-step-title.0') }}" placeholder="Tiêu đề">
                                    </div>
                                    <div class="col-md-5 guide-step-time">
                                        <label>Thời gian</label>
                                        <input type="text" min="0" class="form-control" name="food-step-time[1]" value="{{ old('food-step-time.0') }}" placeholder="Phút">
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="col-md-12 guide-step-description">
                                        <textarea name="food-step-description[1]" id="" cols="30" rows="4" class="form-control" placeholder="Mô tả">{{ old('food-step-description.0') }}</textarea>
                                    </div>
                                </div>
                                <div class="row more-step">
                                    <a href="" class="btn-more-step">
                                        <i class="fa fa-plus" aria-hidden="true"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="form-group guide-links-container">
                                <div class="row link">
                                    <div class="col-md-2 input-heading">
                                        <label>Link 1</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" name="food-link[1]" class="form-control" value="{{ old('food-link.0') }}" placeholder="Link Youtube">
                                    </div>
                                    <div class="col-md-2 remove-link">
                                        <a href="" class="btn-remove-link">
                                            <i class="fa fa-minus" aria-hidden="true"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="row more-link">
                                    <a href="" class="btn-more-link">
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
                                <a href="" class="btn-submit">
                                    <span>Hoàn tất</span>
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
@endsection

@section('define-js')
    <script src="{{ asset('/modules/LoadImg-master/js/loadimg.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript" src="{{ asset('/js/pages/create-food.js') }}"></script>
@endsection 
