@extends('pages.layouts.app')

@section('header_title')
    Trang cập nhật món ăn
@endsection

@section('define-css')
    <link href="{{ asset('modules/LoadImg-master/css/loadimg.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('modules/alertify/alertify.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('modules/alertify/default.min.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ asset('/css/pages/food-edit.css') }}">
@endsection

@section('main-content')
<div class="edit-food-page">
    <!-- Menu Store -->
    @include('pages.manage-store.partials.menu', [
        'store_id' => $food->store_id
    ])
    <!-- End Menu Store -->
    <!-- Main Content -->
    <section class="section-main-form">
        <div class="container">
            <div class="row form-heading">
                <div class="col-md-6 form-title">
                    <h4>Cập nhật sản phẩm</h4>
                </div>
                <div class="col-md-6 form-buttons">
                    <ul class="list-inline buttons-container">
                        <li>
                            <a href="{{ url('/manage/store/'.$food->store_id.'/food')}}">
                                <i class="fa fa-angle-left" aria-hidden="true"></i>
                                <span>Trở về</span>
                            </a>
                        </li>
                        <li>
                            <a href="" class="btn-submit">
                                <span>Cập nhật</span>
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
                <form action="{{ url('/manage/store/' . $food->store_id . '/post_edit_food/' . $food->id) }}" class="row form-edit-food" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="col-md-4 left-form">
                        <div class="form-group">
                            <label id="upload" class="upload-image-box" exist-img="{{ asset($food->images) }}">
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
                                    <input type="radio" class="btn-set-price" name="opt_price" {{ ($food->price == $food->price_max) ? 'checked' : '' }} value="one-price">Một giá</label>
                            </div>
                            <div class="col-md-6 col-sm-9 col-xs-8 reset-padding-right">
                                <input type="text" name="food-price" class="form-control set-price" {{ ($food->price != $food->price_max) ? 'disabled' : '' }} value="{{ (!old('food-price')) ? ($food->price == $food->price_max) ? $food->price : '' : old('food-price') }}">
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12 radio">
                                <label>
                                    <input type="radio" class="btn-set-price-range" name="opt_price" {{ ($food->price != $food->price_max) ? 'checked' : '' }} value="range-price">Khung giá</label>
                            </div>
                            <div class="from-price-container">
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <span>Từ</span>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-6 reset-padding-right">
                                    <input type="text" name="food-price-from" class="form-control set-price-range" {{ ($food->price == $food->price_max) ? 'disabled' : '' }} value="{{ (!old('food-price-from')) ? ($food->price != $food->price_max) ? $food->price : '' : old('food-price-from') }}">
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="to-price-container">
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <span>đến</span>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-6 reset-padding-right">
                                    <input type="text" name="food-price-to" class="form-control set-price-range" {{ ($food->price == $food->price_max) ? 'disabled' : '' }} value="{{ (!old('food-price-to')) ? ($food->price != $food->price_max) ? $food->price_max : '' : old('food-price-to') }}">
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
                                                @if (!empty($food_category))
                                                <option {{ (old('food-category')) ? (old('food-category') == $item_child->id) ? 'selected' : '' : ($food_category->category_id == $item_child->id) ? "selected" : "" }} value="{{ $item_child->id }}">{{ '&nbsp;&nbsp;&nbsp;&nbsp;' . $item_child->name }}</option>
                                                @else
                                                <option {{ (old('food-category')) ? (old('food-category') == $item_child->id) ? 'selected' : '' : "" }} value="{{ $item_child->id }}">{{ '&nbsp;&nbsp;&nbsp;&nbsp;' . $item_child->name }}</option>
                                                @endif
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
                                            @foreach ($all_tags as $tag)
                                            <div>
                                                <input class="tag" readonly value="{{ $tag->id }}"><span>{{ $tag->name }}</span><i class="fa fa-times btn-remove-tag" aria-hidden="true"></i>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tags-container">
                                @if (!empty($existed_tags))
                                @foreach ($existed_tags as $tag)
                                <div>
                                    <input class="tag" name="tags[]" readonly value="{{ $tag->tag_id }}"><span>{{ $tag->name }}</span><i class="fa fa-times btn-remove-tag" aria-hidden="true"></i>
                                </div>
                                @endforeach
                                @else
                                <div>
                                    <input type="hidden" class="tag validate-tag" name="tags[]" readonly="">
                                </div>
                                @endif
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
                                    <a href="{{ url('/manage/store/' . $food->store_id . '/delete_food/' . $food->id) }}" class="btn-delete">
                                        <span>Xóa sản phẩm</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-8 right-form">
                        <div class="form-group row">
                            <div class="col-md-3 input-heading">
                                <label>Tên sản phẩm&nbsp;&nbsp;<span>*</span></label>
                            </div>
                            <div class="col-md-9">
                                <input type="text" name="food-name" class="form-control" value="{{ (old('food-name')) ? old('food-name') : $food->name }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 input-heading">
                                <label>Mô tả chi tiết&nbsp;&nbsp;<span>*</span></label>
                            </div>
                            <div class="col-md-9">
                                <textarea name="food-description" id="" rows="6" class="form-control">{{ (old('food-description')) ? old('food-description') : $food->detail }}</textarea>
                            </div>
                        </div>
                        <div class="guides">
                            <span class="guide-heading">Hướng dẫn</span>
                            <div class="form-group guide-steps-container">
                                @if (!empty($food->guides))
                                <?php $i = 0; ?> 
                                @foreach (json_decode($food->guides) as $guide)
                                <?php $i++; ?>
                                <div class="row guide-step">
                                    <div class="col-md-10 guide-step-number">
                                        <h5>Bước {{ $i }}</h5>
                                    </div>
                                    <div class="col-md-2 remove-step">
                                        <a href="" class="btn-remove-step">
                                            <i class="fa fa-minus" aria-hidden="true"></i>
                                        </a>
                                    </div>
                                    <div class="col-md-7 guide-step-title">
                                        <input type="text" class="form-control" name="food-step-title[]" placeholder="Tiêu đề" value="{{ $guide->title }}">
                                    </div>
                                    <div class="col-md-5 guide-step-time">
                                        <label>Thời gian</label>
                                        <input type="text" class="form-control" name="food-step-time[]" value="{{ $guide->time }}">
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="col-md-12 guide-step-description">
                                        <textarea name="food-step-description[]" id="" cols="30" rows="4" class="form-control" placeholder="Mô tả">{{ json_decode($food->steps)[$i - 1] }}</textarea>
                                    </div>
                                </div>
                                @endforeach
                                @else
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
                                        <input type="text" class="form-control" name="food-step-title[]" placeholder="Tiêu đề">
                                    </div>
                                    <div class="col-md-5 guide-step-time">
                                        <label>Thời gian</label>
                                        <input type="number" min="0" class="form-control" name="food-step-time[]">
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="col-md-12 guide-step-description">
                                        <textarea name="food-step-description[]" id="" cols="30" rows="4" class="form-control" placeholder="Mô tả"></textarea>
                                    </div>
                                </div>
                                @endif
                                <div class="row more-step">
                                    <a href="" class="btn-more-step">
                                        <i class="fa fa-plus" aria-hidden="true"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="form-group guide-links-container">
                                @if (!empty($food->videos))
                                <?php $i = 0; ?> 
                                @foreach (json_decode($food->videos) as $link)
                                <?php $i++; ?>
                                <div class="row link">
                                    <div class="col-md-2 input-heading">
                                        <label>Link {{ $i }}</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" name="food-link[]" class="form-control" value="{{ $YoutubeHelper::YOUTUBE_LINK . $link }}">
                                    </div>
                                    <div class="col-md-2 remove-link">
                                        <a href="" class="btn-remove-link">
                                            <i class="fa fa-minus" aria-hidden="true"></i>
                                        </a>
                                    </div>
                                </div>
                                @endforeach
                                @else
                                <div class="row link">
                                    <div class="col-md-2 input-heading">
                                        <label>Link 1</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" name="food-link[]" class="form-control">
                                    </div>
                                    <div class="col-md-2 remove-link">
                                        <a href="" class="btn-remove-link">
                                            <i class="fa fa-minus" aria-hidden="true"></i>
                                        </a>
                                    </div>
                                </div>
                                @endif
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
                                    <span>Cập nhật</span>
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
    <script>
    var FOOD_PRICE_MAX = {{ $price_max }};
    </script>
    <script src="{{ asset('/modules/LoadImg-master/js/loadimg.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/modules/alertify/alertify.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/js/pages/food-edit.js') }}" type="text/javascript" ></script>
@endsection
