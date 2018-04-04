@extends('pages.layouts.app')

@section('header_title')
    Chi tiết món ăn 
@endsection

@section('define-css')
    <link rel="stylesheet" href="{{ asset('/css/pages/food-detail.css') }}">
    <link rel="stylesheet" href="{{ asset('/ui-handler/modal-list-comment/modal-list-comment.css') }}">
    <link rel="stylesheet" href="{{ asset('/ui-handler/modal-comment/modal-comment.css') }}">
    <link rel="stylesheet" href="{{ asset('/ui-handler/modal-login/modal-login.css') }}">
@endsection

@section('main-content')
    <!-- Product detail page -->
    <div class="product-detail-page">
        <!-- Banner -->
        <section class="section-store-banner">
            <div class="container">
                <div class="row store">
                    <div class="col-md-9 store-info">
                        <div class="row">
                            <div class="col-md-3 store-logo">
                                @if ($store->logo == '')
                                    <img src="{{ asset('/img/website/avatar3.jpg') }}" alt="" class="img-responsive">
                                @else
                                    <img src="{{ asset($ImageHelper::get_image_by_size($store->logo, '150x150')) }}" alt="" class="img-responsive">
                                @endif
                            </div>
                            <div class="col-md-9">
                                <a href="{{ url('/store/view/' . $store->slug . '/' . $store->id) }}">
                                    <h4 class="store-name">{{ $store->name }}</h4>
                                </a>
                                <p class="store-intro">
                                    {{ $store->introduction }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 store-rating">
                        <div class="row points">
                            <div class="col-md-4">
                                <span class="number">{{ number_format($store->_rate, 1, ',', '') }}</span>
                            </div>
                            <div class="col-md-8">
                                <div class="row vote-from">
                                    <p>
                                        <span class="title-rating">Bình chọn từ</span>&nbsp;
                                        <span class="users-number">{{ $store->_comment }}</span>&nbsp;
                                        <i class="fa fa-user icon-user" aria-hidden="true"></i></i>
                                    </p>
                                    <p>
                                        <i class="fa {{ ($store->_rate > 0) ? (($store->_rate > 0.5) ? 'fa-star': 'fa-star-half-o') : 'fa-star-o' }} fa-lg star" aria-hidden="true"></i>
                                        <i class="fa {{ ($store->_rate > 1) ? (($store->_rate > 1.5) ? 'fa-star': 'fa-star-half-o') : 'fa-star-o' }} fa-lg star" aria-hidden="true"></i>
                                        <i class="fa {{ ($store->_rate > 2) ? (($store->_rate > 2.5) ? 'fa-star': 'fa-star-half-o') : 'fa-star-o' }} fa-lg star" aria-hidden="true"></i>
                                        <i class="fa {{ ($store->_rate > 3) ? (($store->_rate > 3.5) ? 'fa-star': 'fa-star-half-o') : 'fa-star-o' }} fa-lg star" aria-hidden="true"></i>
                                        <i class="fa {{ ($store->_rate > 4) ? (($store->_rate > 4.5) ? 'fa-star': 'fa-star-half-o') : 'fa-star-o' }} fa-lg star" aria-hidden="true"></i>
                                        <i class="fa fa-angle-right angle fa-lg" aria-hidden="true"></i>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="reviews">
                            <ul class="list-inline">
                                <li>
                                    <span class="icon icon-followers"></span>
                                </li>
                                <li><span>{{ $store->_follow }}</span></li>
                                <li>
                                    <span class="icon icon-favorites"></span>
                                </li>
                                <li><span>{{ $store->_like }}</span></li>
                                <li>
                                    <span class="icon fa fa-comments"></span>
                                </li>
                                <li><span>13</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End Banner -->
        <!-- Main Content -->
        <section class="section-main-content">
            <div class="container">
                <div class="row">
                    <section class="col-md-9 section-left-content">
                        <!-- Tags -->
                        <div class="row tags">
                            <ul class="list-inline">
                                @foreach ($tags as $key=>$item)
                                    @if ($key < 3)
                                    <li class="tag">
                                        <a href="{{ route('website_food_list') }}/?tag={{ $item->slug }}">{{ $item->name }}</a>
                                    </li>
                                    @else
                                        @break
                                    @endif
                                @endforeach
                                @if (count($tags) > 3)
                                <li class="tag btn-more-tag drop_down">
                                    <a href="javascript:void(0)">
                                        <i class="fa fa-ellipsis-h" aria-hidden="true"></i>
                                    </a>
                                </li>
                                @endif
                                <!-- dropdown tags -->
                                <div class="dropdown-wp" style="display: none;">
                                    <div class="dropdown-content">
                                        <h3>Tags</h3>
                                        <hr>
                                        <ul class="list-unstyled list-category">
                                        @foreach ($tags as $key=>$item)
                                            <li><a href="{{ route('website_food_list') }}/?tag={{ $item->slug }}">{{ $item->name }}</a></li>
                                        @endforeach
                                        </ul>
                                    </div>
                                </div>
                                <!-- end dropdown tags -->
                            </ul>
                        </div>
                        <!-- End Tags -->
                        <!-- Product Detail -->
                        <div class="row product-detail">
                            <div class="col-md-6 col-sm-6 text-center product-info-left">
                                <h4 class="product-name">{{ $food->name }}</h4>
                                <div class="rating-stars">
                                    <i class="fa {{ ($food->_rate > 0) ? (($food->_rate > 0.5) ? 'fa-star': 'fa-star-half-o') : 'fa-star-o' }} star" aria-hidden="true"></i>
                                    <i class="fa {{ ($food->_rate > 1) ? (($food->_rate > 1.5) ? 'fa-star': 'fa-star-half-o') : 'fa-star-o' }} star" aria-hidden="true"></i>
                                    <i class="fa {{ ($food->_rate > 2) ? (($food->_rate > 2.5) ? 'fa-star': 'fa-star-half-o') : 'fa-star-o' }} star" aria-hidden="true"></i>
                                    <i class="fa {{ ($food->_rate > 3) ? (($food->_rate > 3.5) ? 'fa-star': 'fa-star-half-o') : 'fa-star-o' }} star" aria-hidden="true"></i>
                                    <i class="fa {{ ($food->_rate > 4) ? (($food->_rate > 4.5) ? 'fa-star': 'fa-star-half-o') : 'fa-star-o' }} star" aria-hidden="true"></i>
                                </div>
                                <div class="product-reviews">
                                    <span class="orders-number">2 đơn hàng</span> | <span class="ratings-number">83 cảm nhận</span>
                                </div>
                                <p class="product-intro">{{ str_limit($food->detail, 300, '...') }}</p>
                                
                                <div class="address">
                                    <div class="row">
                                        <div class="col-md-1 col-sm-1 col-xs-2 address-icon">
                                            <img src="{{ asset('/img/website/icon-location-large.png') }}" alt="" class="img-responsive">
                                        </div>
                                        <div class="col-md-11 col-sm-11 col-xs-10 address-info">
                                            <span>{{ $store->address }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-sm-6 col-xs-6 open-time">
                                        <img src="{{ asset('/img/website/icon-clock.png') }}" alt="" class="img-responsive">
                                        <span>{{ str_limit($store->open_time, 5, '') }} - {{ str_limit($store->close_time, 5, '') }}</span>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-6 status">
                                        <img src="{{ asset('/img/website/icon-open.png') }}" alt="" class="img-responsive">
                                        <span> 
                                        @if ($TimeHelper::check_time_open($store->open_time, $store->close_time, $store->open_day, $store->close_day)==1)
                                            Đang mở cửa
                                        @else
                                            Đóng cửa
                                        @endif
                                        </span> 
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 product-info-right">
                                <div class="product-image">
                                    <img src="{{ ($food->images) ? asset($ImageHelper::get_image_by_size($food->images, '600x400')) : asset('/img/website/food_default.jpg') }}" alt="" class="img-responsive">
                                    @if (Auth::id() != null)
                                        <?php $check = true; ?>
                                        @foreach ($foods_like as $food_like)
                                            @if ($food->id == $food_like->id)
                                                <a href="javascript:void(0)" class="icon-like icon-liked" data-id="{{ $food->id }}"></a>
                                                <?php $check = false; ?>
                                                @break
                                            @endif
                                        @endforeach
                                        @if ($check)
                                            <a href="javascript:void(0)" class="icon-like icon-not-like" data-id="{{ $food->id }}"></a>
                                        @endif
                                    @else
                                        <a href="javascript:void(0)" class="icon-like icon-not-like" data-id="{{ $food->id }}"></a>
                                    @endif
                                </div>
                                @if($food->price != $food->price_max)
                                <div class="product-price">
                                    <sup>Từ </sup> <span class="number-price">{{ number_format($food->price)}}</span><sup>đ</sup><span class="hyphen">-</span>
                                    <span class="number-price">{{ number_format($food->price_max, 0)}}</span><sup>đ</sup>
                                </div>
                                @else
                                <div class="product-price text-center">
                                    <span class="number-price">{{ number_format($food->price)}}</span><sup>đ</sup>
                                </div>
                                @endif
                            </div>
                        </div>
                        <!-- End Product Detail -->
                        <!-- Links Bar -->
                        <div class="links-bar">
                            <span class="effect-background"></span>
                            <ul class="list-inline">
                                <li class="booking active">
                                    <a href="">Đặt hàng</a>
                                </li>
                                <li class="bookmark">
                                    <a href="">Lưu lại</a>
                                </li>
                                <li class="comment">
                                    <a href="">Bình luận</a>
                                </li>
                                <li class="rating">
                                    <a href="">Cảm nhận</a>
                                </li>
                                <li class="share">
                                    <a href="">Chia sẻ</a>
                                </li>
                            </ul>
                        </div>
                        <!-- End Links Bar -->
                        <!-- Introduction -->
                        <div class="introduction">
                            <div class="guide-box">
                                <div class="box-heading">
                                    <p>Hướng dẫn</p>
                                </div>
                                <ul class="list-inline tools">
                                    <li class="tool note">
                                        <a href="">
                                            <span>Ghi chú lại</span>
                                            <i class="fa fa-pencil" aria-hidden="true"></i>
                                        </a>
                                    </li>
                                    <li class="tool print">
                                        <a href="">
                                            <span>In ra</span>
                                            <i class="fa fa-print" aria-hidden="true"></i>
                                        </a>
                                    </li>
                                </ul>
                                <div class="clearfix"></div>
                            </div>
                            <div class="row main-introduction">
                                <div class="col-md-8">
                                    <div class="main-guide">
                                        <ul class="list-inline guide-parts">
                                            <li>
                                                <img class="img-responsive" src="{{ asset('/img/website/icon_clock.png') }}">
                                            </li>
                                            @foreach ($guides as $item)
                                            <li>
                                                <p>{{ $item->title }}</p>
                                                <span>{{ $item->time }} phút</span>
                                            </li>
                                            @endforeach
                                        </ul>
                                        <ul class="list-unstyled guide-steps">
                                            @foreach ($steps as $key => $item)
                                            <li class="step">
                                                <span class="step-number">{{ $key+1 }}</span>
                                                <span class="step-content">{{ str_limit($item, 150) }} <span>
                                                <div class="clearfix"></div>
                                            </li>
                                            @endforeach
                                            
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="suggested-guides">
                                        <h5 class="suggested-guides-title">Bạn cần biết</h5>
                                        <ul class="list-unstyled list-video">
                                        </ul>
                                        
                                        <!-- Modal -->
                                        <div class="modal" id="Modal" role="dialog">
                                            <div class="modal-dialog">
                                        
                                            <!-- Modal content-->
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    <h4 class="modal-title">Video Hướng Dẫn</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <iframe width="560" height="315" src="" frameborder="0" allowfullscreen></iframe>
                                                </div>
                                            </div>
                                          
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Introduction -->
                        <!-- Other Products -->
                        <div class="other-products">
                            <span class="other-products-title">Sản phẩm khác</span>
                            <!--slider-->
                            <div class="slider-product-detail">
                                @foreach($foods_slider as $item)
                                <div class="slider-item">
                                    @if (Auth::id() != null)
                                        <?php $check = true; ?>
                                        @foreach ($foods_like as $food_like)
                                            @if ($item->id == $food_like->id)
                                                <a href="javascript:void(0)" class="icon-like icon-liked" data-id="{{ $item->id }}"></a>
                                                <?php $check = false; ?>
                                                @break
                                            @endif
                                        @endforeach
                                        @if ($check)
                                            <a href="javascript:void(0)" class="icon-like icon-not-like" data-id="{{ $item->id }}"></a>
                                        @endif
                                    @else
                                        <a href="javascript:void(0)" class="icon-like icon-not-like" data-id="{{ $item->id }}"></a>
                                    @endif
                                    <a href="{{ url('/food/view/' . $item->slug . '/' . $item->id) }}">
                                        @if ($item->images == '')
                                            <img src="{{ url('/') }}/img/website/food_default.jpg" alt="" class="img-responsive ">
                                        @else
                                            <img src="{{ asset($ImageHelper::get_image_by_size($item->images, '150x150')) }}" alt="" class="img-responsive">
                                        @endif
                                        <p>{{ $item->name }}</p>
                                    </a>
                                    <div class="rating-stars">
                                        <i class="fa {{ ($item->_rate > 0) ? (($item->_rate > 0.5) ? 'fa-star': 'fa-star-half-o') : 'fa-star-o' }} star" aria-hidden="true"></i>
                                        <i class="fa {{ ($item->_rate > 1) ? (($item->_rate > 1.5) ? 'fa-star': 'fa-star-half-o') : 'fa-star-o' }} star" aria-hidden="true"></i>
                                        <i class="fa {{ ($item->_rate > 2) ? (($item->_rate > 2.5) ? 'fa-star': 'fa-star-half-o') : 'fa-star-o' }} star" aria-hidden="true"></i>
                                        <i class="fa {{ ($item->_rate > 3) ? (($item->_rate > 3.5) ? 'fa-star': 'fa-star-half-o') : 'fa-star-o' }} star" aria-hidden="true"></i>
                                        <i class="fa {{ ($item->_rate > 4) ? (($item->_rate > 4.5) ? 'fa-star': 'fa-star-half-o') : 'fa-star-o' }} star" aria-hidden="true"></i>
                                        <span class="number-rated"> {{ $item->_comment }}</span>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <!-- Feeling -->
                        <section class="feeling ">
                           
                                <div class="row">
                                    <h2 class="feedback-title ">Cảm nhận <small>{{ $food->_comment }}</small></h2>
                                    <div class="social-icon ">
                                        <span class="share-icon "></span>Chia Sẻ &nbsp;
                                        <a href=" " title=" "><img src="{{ url('/') }}/img/website/icon-social1.png "></a>
                                        <a href=" " title=" "><img src="{{ url('/') }}/img/website/icon-social2.png "></a>
                                        <a href=" " title=" "><img src="{{ url('/') }}/img/website/icon-social3.png "></a>
                                        <a href=" " title=" "><img src="{{ url('/') }}/img/website/icon-social4.png "></a>
                                    </div>
                                </div>
                                <div class="border "></div>
                                <div class="row vote-feeling">
                                    <div class="col-md-4 col-sm-12 col-xs-12 ">
                                        <div class="left ">
                                            <img class="avatar2 " src="{{ url('/') }}/img/website/icon-avatar.png ">
                                            <div class="vote plus "><a href="" title="">Bình chọn và Cảm nhận</a>
                                                <a href="#myModal " title=" " data-toggle="modal ">
                                                    <img src="{{ url('/') }}/img/website/icon-plus.png " class="plus ">
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-sm-12 col-xs-12 ">
                                        <div class="row link-most ">
                                            <div class="col-md-4 col-sm-4 item ">
                                                <a href=" ">Hữu ích nhất&nbsp;<i class="fa fa-angle-down "></i>
                                                </a>
                                            </div>
                                            <div class="col-md-4 col-sm-4 item ">
                                                <a href=" ">Mới nhất  &nbsp;<i class="fa fa-angle-down "></i>
                                                </a>
                                            </div>
                                            <div class="col-md-4 col-sm-4 item ">
                                                <a href=" ">Xem nhiều nhất&nbsp; <i class="fa fa-angle-down "></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="border "></div>
                                <div class="row feedback">
                                    <div class="col-md-8 ">
                                        <div class="row ">
                                            <?php $i = 0; ?>
                                            @foreach ($comments as $comment)
                                            <div class="col-md-6 col-sm-6 ">
                                                <div class="feedback-wp ">
                                                    <div class="feedback-header clearfix">
                                                        <div class="avatar-user ">
                                                            <img src="{{ ($comment->user_image == '') ? url('/').'/img/website/avatar_user_default.png' :  asset($ImageHelper::get_image_by_size($comment->user_image, '150x150')) }}">
                                                        </div>
                                                        <div class="feedback-point ">
                                                            <div class="user-name ">{{ $comment->user_name }}</div>
                                                            <ul class="list-unstyled list-point ">
                                                                <li>
                                                                    <img src="{{ url('/') }}/img/website/icon-follow.png " alt=" ">
                                                                    <span class="point ">{{ $comment->user_follow }}</span>
                                                                </li>
                                                                <li>
                                                                    <img src="{{ url('/') }}/img/website/icon-heart.png " alt=" ">
                                                                    <span class="point ">25</span>
                                                                </li>
                                                                <li>
                                                                    <img src="{{ url('/') }}/img/website/icon-review.png " alt=" ">
                                                                    <span class="point ">13</span>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="feedback-content ">
                                                        <div class="feedback-star ">
                                                            <i class="fa fa-star fa-lg star " aria-hidden="true "></i>
                                                            <i class="fa fa-star fa-lg star " aria-hidden="true "></i>
                                                            <i class="fa fa-star fa-lg star " aria-hidden="true "></i>
                                                            <i class="fa fa-star fa-lg star " aria-hidden="true "></i>
                                                            <i class="fa fa-star fa-lg star " aria-hidden="true "></i>
                                                        </div>
                                                        <div class="feedback-time "><i>{{ date('d/m/Y', $comment->created_at) }}</i></div>
                                                        <p>{{ $comment->content }}</p>
                                                    </div>
                                                    <div class="feedback-footer ">
                                                        <img src="{{ url('/') }}/img/website/icon-read-more.png ">
                                                        <a href="javascript:void(0)" title="" class="more-link" data-toggle="modal" data-target="#list-comment-modal" data-id="{{ $i }}">Xem chi tiết</a>
                                                    </div>
                                                    <div class="space "></div>
                                                </div>
                                            </div>
                                            <?php $i++; ?>
                                            @endforeach
                                        </div>
                                        @include('pages.partials.shared.modal_detail_comment', ['comments' => $comments])
                                    </div>
                                    <!-- end feedback content-->
                                    <div class="col-md-4 ">
                                        <div class="vote-table ">
                                            <div class="rank ">
                                                <div class="feedback-rank ">Khá tốt</div>
                                                <div class="feedback-4star ">
                                                    <i class="fa {{ ($food->_rate > 0) ? (($food->_rate > 0.5) ? 'fa-star': 'fa-star-half-o') : 'fa-star-o' }} fa-lg star " aria-hidden="true "></i>
                                                    <i class="fa {{ ($food->_rate > 1) ? (($food->_rate > 1.5) ? 'fa-star': 'fa-star-half-o') : 'fa-star-o' }} fa-lg star " aria-hidden="true "></i>
                                                    <i class="fa {{ ($food->_rate > 2) ? (($food->_rate > 2.5) ? 'fa-star': 'fa-star-half-o') : 'fa-star-o' }} fa-lg star " aria-hidden="true "></i>
                                                    <i class="fa {{ ($food->_rate > 3) ? (($food->_rate > 3.5) ? 'fa-star': 'fa-star-half-o') : 'fa-star-o' }} fa-lg star " aria-hidden="true "></i>
                                                    <i class="fa {{ ($food->_rate > 4) ? (($food->_rate > 4.5) ? 'fa-star': 'fa-star-half-o') : 'fa-star-o' }} fa-lg star" aria-hidden="true"></i>
                                                </div>
                                            </div>
                                            <div class="feedback-rank-point ">{{ number_format($food->_rate, 1, ',', '') }}</div>
                                            <div class="feedback-content clearfix">
                                                <ul class="feedback-list">
                                                    <li>
                                                        <div class="left">
                                                            <div class="feedback-list-title">Chất lượng</div>
                                                            <div class=" right progessbar ">
                                                                <div id="quality"  style="width: {{ ($food->_rate / 5)*100 }}%"></div>
                                                            </div>
                                                        </div>
                                                        <div class="right star-point">
                                                            <span class="feedback-point">{{ number_format($food->_rate, 1, ',', '') }}</span>
                                                            <i class="fa fa-star fa-lg star " aria-hidden="true "></i>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="left">
                                                            <div class=" feedback-list-title">Giá cả</div>
                                                            <div class=" right progessbar ">
                                                                <div id="cost"></div>
                                                            </div>
                                                        </div>
                                                        <div class="right star-point">
                                                            <span class="feedback-point">4.5</span>
                                                            <i class="fa fa-star fa-lg star " aria-hidden="true "></i>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="left">
                                                            <div class=" feedback-list-title">Thái độ</div>
                                                            <div class=" right progessbar ">
                                                                <div id="attitude"></div>
                                                            </div>
                                                        </div>
                                                        <div class="right star-point">
                                                            <span class="feedback-point">4.5</span>
                                                            <i class="fa fa-star fa-lg star " aria-hidden="true "></i>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="left">
                                                            <div class=" feedback-list-title">Giao hàng</div>
                                                            <div class="right progessbar ">
                                                                <div id="deliver"></div>
                                                            </div>
                                                        </div>
                                                        <div class="right star-point">
                                                            <span class="feedback-point">4.5</span>
                                                            <i class="fa fa-star fa-lg star " aria-hidden="true "></i>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="left">
                                                            <div class="feedback-list-title">Khác</div>
                                                            <div class=" right progessbar ">
                                                                <div id="more"></div>
                                                            </div>
                                                        </div>
                                                        <div class="right star-point">
                                                            <span class="feedback-point">4.5</span>
                                                            <i class="fa fa-star fa-lg star " aria-hidden="true "></i>
                                                        </div>
                                                    </li>
                                                </ul>
                                                <!-- end  feedback-list-->
                                                <div class="footer-vote-table ">
                                                    <a href="" title=""><span>285 &nbsp;</span></a>Bình chọn
                                                </div>
                                            </div>
                                        </div>
                                        <div class="space"></div>
                                        <div class="vote-table2 ">
                                            <div class="feedback-header ">
                                                <div class="rank ">
                                                    <div class="feedback-rank ">Mức độ</div>
                                                </div>
                                            </div>
                                            <ul class="feedback-content ">
                                                <ul class="list-unstyled feedback-rating clearfix">
                                                    <li>
                                                        <div class="left rank-name-level-chart ">
                                                            <i class="fa fa-star fa-lg star " aria-hidden="true "></i>
                                                            <i class="fa fa-star fa-lg star " aria-hidden="true "></i>
                                                            <i class="fa fa-star fa-lg star " aria-hidden="true "></i>
                                                            <i class="fa fa-star fa-lg star " aria-hidden="true "></i>
                                                            <i class="fa fa-star fa-lg star " aria-hidden="true "></i>
                                                        </div>
                                                        <div class="left rank-name-level ">
                                                            Cực kì yêu thích
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="left rank-name-level-chart ">
                                                            <i class="fa fa-star fa-lg star " aria-hidden="true "></i>
                                                            <i class="fa fa-star fa-lg star " aria-hidden="true "></i>
                                                            <i class="fa fa-star fa-lg star " aria-hidden="true "></i>
                                                            <i class="fa fa-star fa-lg star " aria-hidden="true "></i>
                                                            <i class="fa fa-star fa-lg star-grey " aria-hidden="true "></i>
                                                        </div>
                                                        <div class="left rank-name-level ">
                                                            Khá thích
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="left rank-name-level-chart ">
                                                            <i class="fa fa-star fa-lg star " aria-hidden="true "></i>
                                                            <i class="fa fa-star fa-lg star " aria-hidden="true "></i>
                                                            <i class="fa fa-star fa-lg star " aria-hidden="true "></i>
                                                            <i class="fa fa-star fa-lg star-grey " aria-hidden="true "></i>
                                                            <i class="fa fa-star fa-lg star-grey " aria-hidden="true "></i>
                                                        </div>
                                                        <div class="left rank-name-level ">
                                                            Cũng được
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="left rank-name-level-chart ">
                                                            <i class="fa fa-star fa-lg star " aria-hidden="true "></i>
                                                            <i class="fa fa-star fa-lg star " aria-hidden="true "></i>
                                                            <i class="fa fa-star fa-lg star-grey " aria-hidden="true "></i>
                                                            <i class="fa fa-star fa-lg star-grey " aria-hidden="true "></i>
                                                            <i class="fa fa-star fa-lg star-grey " aria-hidden="true "></i>
                                                        </div>
                                                        <div class="left rank-name-level ">
                                                            Không thích lắm
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="left rank-name-level-chart ">
                                                            <i class="fa fa-star fa-lg star " aria-hidden="true "></i>
                                                            <i class="fa fa-star fa-lg star-grey " aria-hidden="true "></i>
                                                            <i class="fa fa-star fa-lg star-grey " aria-hidden="true "></i>
                                                            <i class="fa fa-star fa-lg star-grey " aria-hidden="true "></i>
                                                            <i class="fa fa-star fa-lg star-grey " aria-hidden="true "></i>
                                                        </div>
                                                        <div class="left rank-name-level ">
                                                            Không được
                                                        </div>
                                                    </li>
                                                    <li></li>
                                                </ul>
                                                <div class="vote-button" data-toggle="modal" data-target="#comment-modal">
                                                    <a href="javascript:void(0)" title=" ">
                                                        <img src="{{ url('/') }}/img/website/icon-vote.png ">
                                                        <span><a href="javascript:void(0)" title="">Bình chọn ngay</a></span>
                                                    </a>
                                                </div>
                                                @include('pages.partials.shared.modal_comment', ['item' => $food])
                                        </div>
                                    </div>
                                </div>
                                <!-- end vote-table -->
                            
                        </section>
                        <!-- End Other Products -->
                    </section>
                    <section class="col-md-3 section-right-content">
                        <div class="row top-topics">
                            <div class="slider-widget">
                            @foreach ($foods_slider as $item)
                                <div class="slider-item">
                                    <a href="{{ url('/food/view/' . $item->slug . '/' . $item->id) }}">
                                        <div class="col-md-4 col-sm-2 col-xs-2">
                                            @if ($item->images == '')
                                                <img src="{{ url('/') }}/img/website/food_default.jpg" alt="" class="img-responsive ">
                                            @else
                                                <img src="{{ asset($ImageHelper::get_image_by_size($item->images, '150x150')) }}" alt="" class="img-responsive">
                                            @endif
                                        </div>
                                        <div class="col-md-8 col-sm-10 col-xs-10">
                                            <div class="row">
                                                <p>{{ $item->name }}</p>
                                                <div class="rating-stars">
                                                    <i class="fa {{ ($item->_rate > 0) ? (($item->_rate > 0.5) ? 'fa-star': 'fa-star-half-o') : 'fa-star-o' }} star" aria-hidden="true"></i>
                                                    <i class="fa {{ ($item->_rate > 1) ? (($item->_rate > 1.5) ? 'fa-star': 'fa-star-half-o') : 'fa-star-o' }} star" aria-hidden="true"></i>
                                                    <i class="fa {{ ($item->_rate > 2) ? (($item->_rate > 2.5) ? 'fa-star': 'fa-star-half-o') : 'fa-star-o' }} star" aria-hidden="true"></i>
                                                    <i class="fa {{ ($item->_rate > 3) ? (($item->_rate > 3.5) ? 'fa-star': 'fa-star-half-o') : 'fa-star-o' }} star" aria-hidden="true"></i>
                                                    <i class="fa {{ ($item->_rate > 4) ? (($item->_rate > 4.5) ? 'fa-star': 'fa-star-half-o') : 'fa-star-o' }} star" aria-hidden="true"></i>
                                                    <span class="number-rated"> {{ $item->_comment }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <span class="clearfix"></span>
                                    </a>
                                </div>
                            @endforeach
                            </div>
                        </div>
                        <div class="content-item adv">
                            <a href="">
                                <img src="{{ asset('/img/website/adsLDG.png') }}" alt="" class="img-responsive">
                            </a>
                        </div>
                        <div class="content-item adv">
                            <a href="">
                                <img src="{{ asset('/img/website/adsFreevideo.png') }}" alt="" class="img-responsive">
                            </a>
                        </div>
                        <div class="row relative-foods">
                            <h4 class="relative-foods-title">Món cùng khẩu vị <i class="fa fa-cog btn-config" aria-hidden="true"></i></h4>
                            @foreach ($foods_like_tag as $item)
                            <div class="col-md-6 col-sm-2 col-xs-6 food-item">
                                <a href="{{ route('website_food_detail', ['food_slug' => $item->slug, 'food_id' => $item->id]) }}">
                                    @if ($item->images == '')
                                        <img src="{{ url('/') }}/img/website/food_default.jpg" alt="" class="img-responsive ">
                                    @else
                                        <img src="{{ asset($ImageHelper::get_image_by_size($item->images, '150x150')) }}" alt="" class="img-responsive">
                                    @endif
                                    <p>{{ $item->name }}</p>
                                </a>
                                <div class="rating-stars">
                                    <i class="fa {{ ($item->_rate > 0) ? (($item->_rate > 0.5) ? 'fa-star': 'fa-star-half-o') : 'fa-star-o' }} star" aria-hidden="true"></i>
                                    <i class="fa {{ ($item->_rate > 0) ? (($item->_rate > 0.5) ? 'fa-star': 'fa-star-half-o') : 'fa-star-o' }} star" aria-hidden="true"></i>
                                    <i class="fa {{ ($item->_rate > 0) ? (($item->_rate > 0.5) ? 'fa-star': 'fa-star-half-o') : 'fa-star-o' }} star" aria-hidden="true"></i>
                                    <i class="fa {{ ($item->_rate > 0) ? (($item->_rate > 0.5) ? 'fa-star': 'fa-star-half-o') : 'fa-star-o' }} star" aria-hidden="true"></i>
                                    <i class="fa {{ ($item->_rate > 0) ? (($item->_rate > 0.5) ? 'fa-star': 'fa-star-half-o') : 'fa-star-o' }} star" aria-hidden="true"></i>
                                    <span class="number-rated"> {{ $item->_comment }}</span>
                                </div>
                                <div class="author">
                                    <a href="">
                                        <ul class="list-inline">
                                            <li class="image">
                                                @if ($item->img_user == '')
                                                    <img src="{{ url('/') }}/img/website/avatar_user_default.png" alt="" class="img-responsive">
                                                @else
                                                    <img src="{{ asset($ImageHelper::get_image_by_size($item->img_user, '150x150')) }}" alt="" class="img-responsive">
                                                @endif
                                            </li>
                                            <li class="name">
                                                <span>{{ str_limit($item->username,10) }}</span>
                                            </li>
                                        </ul>
                                    </a>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div class="btn-view-commnent">
                            <a href="#"  data-toggle="modal" data-target="#list-comment-modal">Xem bình luận</a>
                        </div>
                        <div class="content-item adv">
                            <a href="">
                                <img src="{{ asset('/img/website/adsFreevideo.png') }}" alt="" class="img-responsive">
                            </a>
                        </div>
                        <div class="content-item adv">
                            <a href="">
                                <img src="{{ asset('/img/website/adsLDG.png') }}" alt="" class="img-responsive">
                            </a>
                        </div>
                    </section>
                </div>
            </div>
        </section>
        <!-- End Main Content -->
        
    </div>
    <!-- End product detail page -->
    @include('pages.partials.shared.modal_login')
@endsection

@section('define-js')
<script>
    var FOOD = <?= json_encode((array)$food); ?>;
    var PAGE = 'food';
</script>
<script type="text/javascript" src="{{ asset('/js/pages/food-detail.js') }}"></script>
<script type="text/javascript" src="{{ asset('/ui-handler/modal-list-comment/modal-list-comment.js') }}"></script>
<script type="text/javascript" src="{{ asset('/ui-handler/modal-comment/modal-comment.js') }}"></script>
@endsection