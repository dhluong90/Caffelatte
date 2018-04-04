@extends('pages.layouts.app')

@section('header_title')
Danh sách cửa hàng của người dùng
@endsection

@section('define-css')
<link rel="stylesheet" href="{{ asset('/css/pages/home.css') }}">
<link rel="stylesheet" href="{{ asset('/css/pages/list-store.css') }}">
<link rel="stylesheet" href="{{ asset('/ui-handler/main-list/main-list.css') }}">
@endsection

@section('main-content')

<!-- Menu user -->
@include('pages.profile.partials.menu')
<!-- End Menu user -->
<section class="section-main-form">
    <div class="container">
        <div class="row">
            <div class="col-md-6 form-title">
                <h4>Danh sách cửa hàng</h4>
            </div>
            <div class="col-md-6 form-buttons">
                <div class="add-more-branches">
                    <a href="{{ url('profile/' . $user->id . '/create_store') }}" class="btn-add-more">
                        <span>Tạo cửa hàng</span>
                        <i class="fa fa-plus" aria-hidden="true"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="main-list">
            <div class="flash-message">
                @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                    @if(Session::has('alert-' . $msg))
                        <h4 class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }}  <button class="close" data-dismiss="alert" aria-label="close">&times;</button></h4>
                    @endif
                @endforeach
            </div> <!-- end .flash-message -->
            <div class="row">
                <div id="grid" class="grid">
                @foreach($stores as $item)
                    <div class="grid-col-item">
                        <div class="item-container store">
                            <div class="store-info">
                                <div class="left-info">
                                    <a href="{{ url('/store/view/' . $item->slug . '/' . $item->id) }}">
                                        @if ($item->logo == '')
                                        <img src="{{ url('/') }}/img/website/store_default.jpg" alt="" class="img-responsive">
                                        @else
                                            <img src="{{ asset($ImageHelper::get_image_by_size($item->logo, '150x150')) }}" alt="" class="img-responsive">
                                        @endif
                                    </a>
                                    @if ($can_manage_store)
                                        <a href="{{ url('/manage/store/' . $item->id . '/food') }}" class="follow count-food">
                                            <span class="">{{ $item->count_food }}</span>
                                            <span>Sản phẩm</span>
                                        </a>
                                    @else
                                        <span href="" class="follow count-food">
                                            <span class="">{{ $item->count_food }}</span>
                                            <span>Sản phẩm</span>
                                        </span>
                                    @endif
                                </div>
                                <div class="right-info">
                                    <span class="item-category">Cửa hàng</span>
                                    <h4><a href="{{ url('/store/view/' . $item->slug . '/' . $item->id) }}">{{ $item->name }}</a></h4>
                                    <p>
                                        <span class="icon-location"></span>
                                        <span class="store-address">{{ $item->address }}</span>
                                    </p>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <a href="{{ url('/store/view/' . $item->slug . '/' . $item->id) }}">
                                <div class="item-review">
                                    <div class="intro-store">{{ $item->introduction }}</div>
                                </div>
                            </a>
                            <div class="item-profile">
                                <ul class="list-inline item-details">
                                    <li>
                                        <ul class="item-details--followers followers-count">
                                            <li>
                                                <span class="icon icon-followers"></span>
                                            </li>
                                            <li>
                                                <span>24</span>
                                            </li>
                                        </ul>
                                        <ul class="item-details--favorites favorites-count">
                                            <li>
                                                <span class="icon icon-favorites"></span>
                                            </li>
                                            <li>
                                                <span>317</span>
                                            </li>
                                        </ul>
                                        <ul class="item-details--rating rating-count">
                                            <li>
                                                <a href="">
                                                    <div class="rating-stars">
                                                        <i class="fa {{ ($item->_rate > 0) ? (($item->_rate > 0.5) ? 'fa-star': 'fa-star-half-o') : 'fa-star-o' }} star" aria-hidden="true"></i>
                                                        <i class="fa {{ ($item->_rate > 1) ? (($item->_rate > 1.5) ? 'fa-star': 'fa-star-half-o') : 'fa-star-o' }} star" aria-hidden="true"></i>
                                                        <i class="fa {{ ($item->_rate > 2) ? (($item->_rate > 2.5) ? 'fa-star': 'fa-star-half-o') : 'fa-star-o' }} star" aria-hidden="true"></i>
                                                        <i class="fa {{ ($item->_rate > 3) ? (($item->_rate > 3.5) ? 'fa-star': 'fa-star-half-o') : 'fa-star-o' }} star" aria-hidden="true"></i>
                                                        <i class="fa {{ ($item->_rate > 4) ? (($item->_rate > 4.5) ? 'fa-star': 'fa-star-half-o') : 'fa-star-o' }} star" aria-hidden="true"></i>
                                                    </div>
                                                    <span class="number-rating">57</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                            <div class="text-right ">
                                @if ($can_manage_store)
                                <a href="{{ url('/manage/store/' . $item->id . '/edit_store') }}" class="follow count-food btn-manage">
                                    <span class="">Quản lý</span>
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('define-js')
    <script src="{{ asset('/js/pages/store-list.js') }}"></script>
@endsection