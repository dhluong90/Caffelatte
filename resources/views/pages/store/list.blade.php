@extends('pages.layouts.app')

@section('header_title')
Danh sách cửa hàng của người dùng
@endsection

@section('main-content')
<link rel="stylesheet" href="{{ asset('/css/pages/create-store.css') }}">
<link rel="stylesheet" href="{{ asset('/css/pages/home.css') }}">
<link rel="stylesheet" href="{{ asset('/css/pages/list-store.css') }}">

<!-- Menu user -->
@include('pages.store.partials.menu_user')
<!-- End Menu user -->
<section class="section-main-form">
    <div class="container">
        <div class="row">
            <div class="col-md-6 form-title">
                <h4>Về cửa hàng</h4>
            </div>
            <div class="col-md-6 form-buttons">
                <div class="add-more-branches">
                    <a href="{{ url('/store/create') }}" class="btn-add-more">
                        <span>Tạo cửa hàng</span>
                        <i class="fa fa-plus" aria-hidden="true"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="main-list">
            <div class="row">
                @for($i = 0 ; $i < count($store); $i++)
                <div class="col-md-3 col-sm-6 col-xs-12"">
                    <div class="grid-col-item width-auto">
                        <div class="item-container store">
                            <div class="store-info">
                                <div class="left-info">
                                    <a href="{{ route('list_food_store', ['store_id' => $store[$i]['id']]) }}"><img src="/img/website/store-1.jpg" alt="" class="img-responsive"></a>
                                    <a href="{{ route('list_food_store', ['store_id' => $store[$i]['id']]) }}" class="follow count-food">
                                        <span class="">{{ $store[$i]['count_food'] }}</span>
                                        <span>Sản phẩm</span>
                                    </a>
                                </div>
                                <div class="right-info">
                                    <span class="item-category">Cửa hàng</span>
                                    <h4><a href="{{ route('list_food_store', ['store_id' => $store[$i]['id']]) }}">{{ $store[$i]['name'] }}</a></h4>
                                    <p>
                                        <span class="icon-location"></span>
                                        <span class="store-address"></span>
                                    </p>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <a href="{{ route('list_food_store', ['store_id' => $store[$i]['id']]) }}">
                                <div class="item-review">
                                    <div class="intro-store">{{ $store[$i]['introduction'] }}</div>
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
                                                        <i class="fa fa-star star" aria-hidden="true"></i>
                                                        <i class="fa fa-star star" aria-hidden="true"></i>
                                                        <i class="fa fa-star star" aria-hidden="true"></i>
                                                        <i class="fa fa-star star" aria-hidden="true"></i>
                                                        <i class="fa fa-star-half-o star" aria-hidden="true"></i>
                                                    </div>
                                                    <span class="number-rating">57</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                @endfor
            </div>
        </div>
    </div>

</section>
@endsection