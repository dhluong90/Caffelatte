@extends('pages.layouts.app')

@section('header_title')
Danh sách món ăn
@endsection

@section('define-css')
    <link rel="stylesheet" href="{{ asset('/css/pages/foods-list.css') }}">
@endsection

@section('main-content')
<div class="create-store-page">
    <!-- Menu Store -->
    @include('pages.manage-store.partials.menu', [
        'store_id' => $menu['store_id']
    ])
    <!-- End Menu Store -->
    <!-- Main Content -->
    <section class="section-main-form">
        <div class="container">
            <div class="row">
                <div class="col-md-6 form-title">
                    <h4>Sản phẩm</h4>
                </div>
                <div class="col-md-6 form-buttons">
                    <ul class="list-inline buttons-container">
                        <li style="display: none;">
                            <a href="">
                                <i class="fa fa-angle-left" aria-hidden="true"></i>
                                <span class="btn-reset">Trở về</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('/manage/store/' . $menu['store_id'] . '/create_food') }}">
                                <span class="btn-submit">Tạo sản phẩm</span>
                                <i class="fa fa-plus" aria-hidden="true"></i>
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
            <div class="row">
                <div id="grid" class="grid">
                @foreach($foods as $food)
                    <div class="grid-col-item width-auto">
                        <div class="item-container food">
                            <a href="{{ url('/food/view/' . $food->slug . '/' . $food->id) }}">
                                @if ($food->images == '')
                                    <img src="{{ url('/') }}/img/website/food_default.jpg" alt="" class="img-responsive">
                                @else
                                    <img src="{{ asset($ImageHelper::get_image_by_size($food->images, '300x300')) }}" alt="" class="img-responsive">
                                @endif
                            </a>
                            <h3>
                                <a href="{{ url('/food/view/' . $food->slug . '/' . $food->id) }}">{{ $food->name }}</a>
                            </h3>
                                <div class="item-review">
                                    <div class="rating-stars">
                                        <i class="fa {{ ($food->_rate > 0) ? (($food->_rate > 0.5) ? 'fa-star': 'fa-star-half-o') : 'fa-star-o' }} star" aria-hidden="true"></i>
                                        <i class="fa {{ ($food->_rate > 1) ? (($food->_rate > 1.5) ? 'fa-star': 'fa-star-half-o') : 'fa-star-o' }} star" aria-hidden="true"></i>
                                        <i class="fa {{ ($food->_rate > 2) ? (($food->_rate > 2.5) ? 'fa-star': 'fa-star-half-o') : 'fa-star-o' }} star" aria-hidden="true"></i>
                                        <i class="fa {{ ($food->_rate > 3) ? (($food->_rate > 3.5) ? 'fa-star': 'fa-star-half-o') : 'fa-star-o' }} star" aria-hidden="true"></i>
                                        <i class="fa {{ ($food->_rate > 4) ? (($food->_rate > 4.5) ? 'fa-star': 'fa-star-half-o') : 'fa-star-o' }} star" aria-hidden="true"></i>
                                    </div>
                                    <span class="number-rating">{{ $food->_comment }}</span>
                                    <span class="icon icon-favorites"></span>
                                    <span class="number-favorite">{{ $food->_like }}</span>
                                    <div class="intro-store">{{ $food->detail }}</div>
                                </div>
                            <hr>
                            <div class="clearfix">
                                <div class="pull-left inline-booking">
                                    <div class="icon-booking">
                                        <a href="" title=""><img src="/img/website/icon-care.png" alt=" " class="img-responsive "></a>
                                    </div>
                                    <div class="count-booking"><span>19</span></div>
                                </div>
                                <div class="pull-right">
                                    <span class="price-title">{{ $food->price/1000 }}</span>
                                    <div class="price ">
                                        <span class="unit-price ">K </span>
                                        <span class="slash "></span>
                                        <span class="part ">Phần</span>
                                    </div>
                                </div>
                            </div>
                            <div class="text-right ">
                                <a href="{{ url('/manage/store/' . $food->store_id . '/edit_food/'.$food->id)}}" class="follow count-food btn-manage">
                                    <span class="">Quản lý</span>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
                </div>
            </div>
        </div>
    </section>
    <!-- End Main Content -->
</div>
@endsection
@section('define-js')
    <script src="{{ asset('/js/pages/food-list.js') }}"></script>
@endsection