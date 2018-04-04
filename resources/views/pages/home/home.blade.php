@extends('pages.layouts.app')

@section('header_title')
Page Home
@endsection

@section('define-css')
    <link rel="stylesheet" href="{{ asset('/css/pages/home.css') }}">
    <link rel="stylesheet" href="{{ asset('/ui-handler/main-list/main-list.css') }}">
    <link rel="stylesheet" href="{{ asset('/ui-handler/modal-login/modal-login.css') }}">
@endsection

@section('main-content')
<div class="home-page">
    <!-- Slider -->
    <section class="section-slider">
        <div class="container wrap-slider">
            <div class="slider">
                @foreach ($foods_slider as $food)
                <div class="slider-item">
                    <a href="{{ route('website_food_detail', ['food_slug' => $food->slug, 'food_id' => $food->id]) }}">
                        @if ($food->images == '')
                            <img src="{{ url('/') }}/img/website/food_default.jpg" alt="" class="img-responsive">
                        @else
                            <img src="{{ asset($ImageHelper::get_image_by_size($food->images, '300x300')) }}" alt="" class="img-responsive">
                        @endif
                        <div class="item-content">
                            @if (!empty($food->tags[0]))
                                <span class="item-category">{{ $food->tags[0]->name }}</span>
                            @endif
                            <h3 class="item-title">{{ $food->food_name }}</h3>
                            <p class="item-intro">{{ $food->detail }}</p>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- End Slider -->
    <!-- Quick Links -->
    <section class="section-quick-links">
        <div class="container">
            <div class="row quick-links">
                <div class="col-md-3 item">
                    <a href="{{ url('/category/view/dac-san-hom-nay') }}">Đặc sản Hôm nay&nbsp;<i class="fa fa-angle-right" aria-hidden="true"></i></a>
                </div>
                <div class="col-md-3 item">
                    <a href="{{ url('/category/view/trong-thuy-canh') }}">Trồng thủy canh&nbsp;<i class="fa fa-angle-right" aria-hidden="true"></i></a>
                </div>
                <div class="col-md-3 item">
                    <a href="{{ url('/category/view/mon-de-lam') }}">Món dễ làm&nbsp;<i class="fa fa-angle-right" aria-hidden="true"></i></a>
                </div>
                <div class="col-md-3 item">
                    <a href="{{ url('/category/view/vung-mien') }}">Vùng miền&nbsp;<i class="fa fa-angle-right" aria-hidden="true"></i></a>
                </div>
            </div>
        </div>
    </section>
    <!-- End Quick Links -->
    <!-- Main Content -->
    <section class="section-nav-main-content">
        <div class="container">
            <div class="row nav-main-content">
                <div class="col-md-9">
                    <ul class="list-inline">
                        <li><span class="caption">tag</span></li>
                        <?php $count_tag = count($foods_tag) > 4 ? 4 : count($foods_tag); ?>
                        @for ($i = 0; $i < $count_tag; $i++)
                        <li class="tag">
                            <a href="{{ route('website_food_list') }}/?tag={{ $foods_tag[$i]->slug }}">{{ $foods_tag[$i]->name }}</a>
                        </li>
                        @endfor
                        <li class="btn-more-tag drop_down">
                            <a href="javascript:void(0)"><i class="fa fa-plus" aria-hidden="true"></i></a><span>Thêm lựa chọn</span>
                        </li>
                        <!-- dropdown tags -->
                        <div class="dropdown-wp">
                            <div class="dropdown-content">
                                <h3>Tags</h3>
                                <hr>
                                <ul class="list-unstyled list-category list-inline">
                                    @foreach ( $foods_tag as $item )
                                    <li class="tag"><a data-slug='{{ $item->slug }}' href="{{ route('website_food_list') }}/?tag={{ $item->slug }}"  title="">{{ $item->name }}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <!-- end dropdown tags -->
                    </ul>
                </div>
                <div class="col-md-3 most-view" style="display: none;">
                    <a href="">Xem nhiều nhất&nbsp;<i class="fa fa-angle-down" aria-hidden="true"></i></a>
                </div>
            </div>
            <hr/> 
        </div>
    </section>
    <section class="section-main-content">
        <div class="container">
            <div id="grid" class="main-content grid">
                @include('pages.partials.shared.main_list', [
                    'items_main_content' => $items_main_content,
                    'foods_like_id' => empty($foods_like_id) ? [] : $foods_like_id,
                    'stores_like_id' => empty($stores_like_id) ? [] : $stores_like_id,
                ])
            </div>
        </div>
    </section>
    <!-- End Main Content -->
    @include('pages.partials.shared.modal_login')
</div>
@endsection

@section('define-js')
<script>
    var FOOD_START_ID = {{ $load_more['food_start_id'] }};
    var STORE_START_ID = {{ $load_more['store_start_id'] }};
    var USER_START_ID = {{ $load_more['user_start_id'] }};
</script>
<script type="text/javascript" src="{{ asset('/js/pages/home.js') }}"></script>
<script type="text/javascript" src="{{ asset('/js/pages/home-loadmore.js') }}"></script>
<script type="text/javascript" src="{{ asset('/ui-handler/main-list/main-list.js') }}"></script>
@endsection
