@extends('pages.layouts.app')

@section('header_title')
Chi tiết cửa hàng
@endsection

@section('define-css')
<link rel="stylesheet" href="{{ asset('/css/pages/store-detail.css') }}">
@endsection

@section('main-content')
<!-- start store-detail-page  -->
<div class="store-detail-page">
    <!-- banner -->
    <section class=" banner-img">
        <div class="banner container">
            <div class="row">
                <div class="col-md-9 col-sm-9 col-xs-12 banner-left">
                    <div class="row">
                        <div class="col-md-3 col-sm-3 col-xs-12 ">
                            <div class="avatar">
                                <a href="{{ url('/store/view/'.$store->slug.'/'.$store->id) }}">
                                    @if ($store->logo == '')
                                        <img src="{{ url('/') }}/img/website/store_default.jpg" alt="" class="img-responsive">
                                    @else
                                        <img src="{{ asset($ImageHelper::get_image_by_size($store->logo, '150x150')) }}" alt="" class="img-responsive">
                                    @endif
                                </a>
                            </div>
                            <div class="share-now ">
                                <a href="" title=""><span><i class="fa fa-share-alt" aria-hidden="true"></i></span>chia sẻ ngay</a>
                            </div>
                        </div>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <div class="banner-center">
                                <div class="header-title ">{{ $store->name }}</div>
                                <p class="title">{{ $store->introduction}}</p>
                                <div class="row">
                                    <div class="col-md-6 col-sm-6 col-xs-6 info">
                                      <ul class="list-unstyled store-addresslink">
                                        <li>
                                            <span class="icon-header"><img src="{{ url('/') }}/img/website/icon-banner1.png" alt=""></span>
                                            <span class="address">Lĩnh vực nông nghiệp</span>
                                        </li>
                                        <li>
                                            <span class="icon-header">
                                                <img src="{{ url('/') }}/img/website/icon-location.png" alt="" class="img-responsive">                                
                                            </span>
                                            <span class="address">
                                                {{ $store->address }}
                                            </span>
                                        </li>
                                        <li>
                                            <span class="icon-header">
                                             <img src="{{ url('/') }}/img/website/icon-phone.png" class="img-responsive" alt="">
                                        </span>
                                            <span>
                                                {{ $store->phone}}
                                            </span>
                                        </li>
                                      </ul>    
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-6 info">
                                        <ul class="list-unstyled header-link">
                                            <li>
                                                <i class="fa fa-facebook" aria-hidden="true"></i>
                                                <a href="javascript:void(0)">{{ $store->facebook }}</a>
                                            </li>
                                            <li>
                                                <i class="fa fa-wordpress" aria-hidden="true"></i>
                                                <a href="javascript:void(0)">{{ $store->site_url }}</a>
                                            </li>
                                            <li>
                                                <i class="fa fa-paper-plane-o" aria-hidden="true"></i>
                                                <a href="javascript:void(0)">{{ $store->email }}</a>
                                            </li>
                                        </ul> 
                                    </div>
                                </div>
                            </div>
                            <!-- end banner=-center -->
                        </div>
                    </div>
                </div>
                <div class="col-md-3  col-sm-3 col-xs-12 banner-right br">
                    <div class="banner-vote-point clearfix">
                        <div class="point-42">4.2</div>
                        <div class="vote-from">Bình chọn từ 285
                            <span> <i class="fa fa-user" aria-hidden="true"></i></span>
                            <div>
                                <i class="fa fa-star fa-lg star" aria-hidden="true"></i>
                                <i class="fa fa-star fa-lg star" aria-hidden="true"></i>
                                <i class="fa fa-star fa-lg star" aria-hidden="true"></i>
                                <i class="fa fa-star fa-lg star" aria-hidden="true"></i>
                                <i class="fa fa-star fa-lg star" aria-hidden="true"></i>
                                <i class="fa fa-star-half-o fa-lg star" aria-hidden="true"></i>
                                <a href="javascript:void(0)">
                                    <i class="fa fa-angle-right angle fa-lg" aria-hidden="true"> </i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <ul class="list-vote ">
                        <li>
                            <div class="left">
                                <span class="point">13</span>
                                <span class="icon-vote"><img src="{{ url('/') }}/img/website/icon-recipes.png" class="img"></span>
                            </div>                                
                            <div class=" btn-more">
                              <span class="title-vote">Cảm nhận</span>
                               &nbsp;&nbsp;
                                <a href="" title=""><i class="fa fa-angle-right angle fa-lg" aria-hidden="true"></i></a>
                            </div>
                        </li>
                        <li>
                            <div class="left ">
                                <span class="point">{{ $store->_like }}</span>
                                <span class="icon-vote"><img src="{{ url('/') }}/img/website/icon-favorites.png" class="img"></span>
                            </div>                                    
                            <div class=" btn-more">
                                <span class="title-vote">Yêu thích</span>
                                &nbsp;&nbsp;&nbsp;
                                <a href="" title=""><i class="fa fa-angle-right angle fa-lg" aria-hidden="true"></i></a>
                            </div>
                        </li>
                        <li>
                            <div class="left ">
                                <span class="point">{{ $store->_follow }}</span>
                                <span class="icon-vote"><img src="{{ url('/') }}/img/website/icon-followers.png"></span>
                            </div>                                   
                            <div class=" btn-more">
                                <span class="title-vote">Theo dõi</span>
                                 &nbsp;&nbsp;&nbsp;&nbsp;
                                <a href="" title=""><i class="fa fa-angle-right angle fa-lg" aria-hidden="true"></i></a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!-- /banner -->

    <section class="section-quick-links">
        <div class="container">
            <div class="row quick-links">
                <div class="col-md-3 col-sm-3 item">
                    <a href=""><small>{{ $foods->count() }}</small>&nbsp;Sản phẩm&nbsp;<i class="fa fa-angle-right" aria-hidden="true"></i></a>
                </div>
                <div class="col-md-3 col-sm-3 item">
                    <a href="javascript:void(0)"><small>34</small>&nbsp;Cảm nhận&nbsp;<i class="fa fa-angle-right" aria-hidden="true"></i></a>
                </div>
                <div class="col-md-3 col-sm-3 item">
                    <a href="javascript:void(0)"><small>34</small>&nbsp;Yêu thích&nbsp;<i class="fa fa-angle-right" aria-hidden="true"></i></a>
                </div>
                <div class="col-md-3 col-sm-3 item">
                    <div class="arrow2">
                        <a href="javascript:void(0)"><img src="{{ url('img/website/more-button.png') }}"></a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--end header section-quick-links -->
<div class="content">
    <div class="container">
        <div class="row">
            <section class="header-top">
                <div class="container">
                    <div class="row">
                        <div class="col-md-3 col-sm-4 col-xs-12">
                            <h2 class="feedback-title">Sản Phẩm <small>{{ $foods->count() }}</small></h2>
                        </div>
                        <div class="col-md-6 col-sm-8 col-xs-12 category">
                            <ul class="list-inline list-category">
                                @if (isset(Request::all()['tag_slug']))
                                <?php $arr_tag = explode(" ", Request::all()['tag_slug']); ?>
                                @foreach ($arr_tag as $tag)
                                    @foreach ($tags_by_store as $item_tag)
                                        @if ($tag == $item_tag->slug)
                                            <span>{{ $item_tag->name }}
                                                <i class="fa fa-times btn-remove-tag" aria-hidden="true" data-slug="{{$tag}}"></i>
                                            </span>
                                        @endif
                                    @endforeach
                                @endforeach
                                <li class="btn-more-tag-plus drop_down">
                                    <a href="javascript:void(0)"><i class="fa fa-plus" aria-hidden="true"></i></a>
                                </li>
                                <!-- dropdown tags -->
                                <div class="dropdown-wp">
                                    <div class="dropdown-content">
                                        <h3>Tags</h3>
                                        <hr>
                                        <ul class="list-unstyled list-category">
                                        @foreach ($tags_by_store as $item_tag)
                                            @if (!in_array($item_tag->slug, $arr_tag))
                                                <li><a href="{{ url('store/view/' . $store->slug . '/'.$store->id . '/?tag_slug=' . $item_tag->slug) }}" title="" data-slug="{{ $item_tag->slug }}" class="btn-slug">{{ $item_tag->name }}</a></li>
                                            @endif
                                        @endforeach
                                        </ul>
                                  </div>
                              </div>
                              <!-- end dropdown tags -->
                              @else
                              <?php $i = 1; ?>
                              @foreach ($tags_by_store as $item_tag) 
                                  @if ($i <= 3)
                                  <li class="tag"><a href="{{ url('store/view/' . $store->slug . '/' . $store->id.'/?tag_slug=' . $item_tag->slug) }}" title="" data-slug="{{ $item_tag->slug }}" class="btn-slug-default">{{ $item_tag->name }}</a></li>
                                  <?php $i++; ?>
                                  @endif
                              @endforeach
                              <li class="drop_down tag">
                                <a href="javascript:void(0)" class="btn-more-tag three-dots">...</a>
                              </li>
                              <!-- dropdown tags -->
                              <div class="dropdown-wp">
                                <div class="dropdown-content">
                                    <h3>Tags</h3>
                                    <hr>
                                    <ul class="list-unstyled list-category">
                                       @foreach ($tags_by_store as $item_tag)
                                       <li class="tag"><a href="{{ url('store/view/' . $store->slug . '/' . $store->id.'/?tag_slug=' . $item_tag->slug) }}" title="" class="btn-slug">{{ $item_tag->name }}</a></li>
                                       @endforeach
                                   </ul>
                               </div>
                           </div>
                           <!-- end dropdown tags -->
                           @endif

                       </ul>
                   </div>
                   <div class="col-md-3 col-sm-12 col-xs-12 " style="display: none;">
                    <div class="top-view">
                        <div class="top-view-title ">Xem nhiều nhất</div>
                        <div class="top-view-button">
                            <a href="javascript:void(0)" title="">
                                <img src="{{ url('img/website/icon-arrow2.png') }}">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--end header-top -->
    <!--end header-top -->
    <!--end header-top -->
    <section class="content-product ">
        <div class="container ">
        	@foreach ($foods->chunk(4) as $arrfood)
            <div class="row ">
                @foreach ($arrfood as $item_food)
                <div class="col-md-3 col-sm-6 ">
                    <div class="thumbnail ">
                        <a href="{{ url('/food/view/'.$item_food->slug.'/'.$item_food->id) }}" title="">
                            @if ($item_food->images == '')
                              <img src="{{ url('/') }}/img/website/food_default.jpg" alt="" class="img-responsive image-food">
                            @else
                              <img src="{{ asset($ImageHelper::get_image_by_size($item_food->images, '300x300')) }}" alt="" class="img-responsive">
                            @endif
                        </a>
                        @if (Auth::id() != null)
                            <?php $check = true; ?>
                            @foreach ($foods_like as $food_like)
                                @if ($food_like->id == $item_food->id)
                                    <a href="javascript:void(0)" class="icon-like icon-liked" data-id="{{ $item_food->id }}"></a>
                                    <?php $check = false; ?>
                                    @break
                                @endif
                            @endforeach
                            @if ($check)
                                <a href="javascript:void(0)" class="icon-like icon-not-like" data-id="{{ $item_food->id }}"></a>
                            @endif
                        @else
                            <a href="javascript:void(0)" class="icon-like icon-not-like" data-id="{{ $item_food->id }}"></a>
                        @endif
                        <div class="caption ">
                            <a href="{{ url('/food/view/' . $item_food->slug . '/' . $item_food->id) }}" title=""><h4 class="caption-title ">{{ $item_food->name }}</h4></a>
                            <div class="left ">
                                <i class="fa fa-star fa-lg star " aria-hidden="true "></i>
                                <i class="fa fa-star fa-lg star " aria-hidden="true "></i>
                                <i class="fa fa-star fa-lg star " aria-hidden="true "></i>
                                <i class="fa fa-star fa-lg star " aria-hidden="true "></i>
                                <i class="fa fa-star fa-lg star " aria-hidden="true "></i>
                                <span>&nbsp;57</span>
                            </div>
                            <div class="icon-favorite ">
                                <i class="fa fa-heart heart-icon " aria-hidden="true "></i>
                                <span class="point-favorite ">{{ $item_food->_like }}</span>
                            </div>
                            <p class="caption-content ">{{ $item_food->detail }}</p>
                            <hr>
                            <div class="clearfix">
                                <div class="icon-footer-caption">
                                   <ul>
                                      <li>
                                        <a href="" title=""><img src="{{ url('img/website/icon-care.png') }}" alt=" " class="img-responsive "></a>
                                     	</li>
                                     	<li>
                                        <a href="" title=""><img src="{{ url('img/website/icon-cart2.png') }}" alt=" " class="img-responsive "></a>
                                     	</li>
                                     	<li>
                                        <a href="" title=""><img src="{{ url('img/website/icon-cart3.png') }}" alt=" " class="img-responsive icon-view"></a>
                                     	</li>
                                 	</ul>
                             		</div>
                             		<div class="right ">
                               		<span class="price-title ">{{ $item_food->price/1000 }}</span>
                               		<div class="price ">
                                  	<span class="unit-price ">&nbsp;K </span>
                                  	<span class="slash "></span>
                                  	<span class="part ">Phần</span>
                              		</div>
                      					</div>
                  					</div>
              						</div>
          						</div>
          					</div>
          			@endforeach
          </div>
          @endforeach
          <div class="col-sm-12">
            <div class="dataTables_paginate paging_simple_numbers pull-right" id="example2_paginate">
                {{ $foods->links() }}
            </div>
        </div>
    </div>
</div>
</section>
<!--end content-product -->
<section class="feeling">
    <div class="">
        <div class="row">
            <h2 class="feedback-title ">Cảm nhận <small>{{ $store->_comment }}</small></h2>
            <div class="social-icon ">
                <span class="share-icon "></span>Chia Sẻ
                <a href=" " title=" "><img src="{{ url('img/website/icon-social1.png') }}"></a>
                <a href=" " title=" "><img src="{{ url('img/website/icon-social2.png') }}"></a>
                <a href=" " title=" "><img src="{{ url('img/website/icon-social3.png') }}"></a>
                <a href=" " title=" "><img src="{{ url('img/website/icon-social4.png') }}"></a>
            </div>
        </div>
        <div class="border "></div>
        <div class="row vote-feeling">
            <div class="col-md-4 col-sm-12 col-xs-12 ">
                <div class="left ">
                    <img class="avatar2 " src="{{ url('img/website/icon-avatar.png') }}">
                    <div class="vote plus "><a href="" title="">Bình chọn và Cảm nhận</a>
                        <a href="#myModal " title=" " data-toggle="modal ">
                            <img src="{{ url('img/website/icon-plus.png') }}" class="plus ">
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
            <div class="col-md-9 ">
                <div class="row ">
                    @foreach ($comments as $comment)
                    <div class="col-md-4 col-sm-4 ">
                        <div class="feedback-wp ">
                            <div class="feedback-header clearfix">
                                <div class="avatar-user ">
                                    <img src="{{ ($comment->user_image == '') ? url('/').'/img/website/avatar_user_default.png' :  asset($ImageHelper::get_image_by_size($comment->user_image, '150x150')) }}">
                                </div>
                                <div class="feedback-point ">
                                    <div class="user-name ">{{ $comment->user_name }}</div>
                                        <ul class="list-unstyled list-point ">
                                            <li>
                                                <img src="{{ url('img/website/icon-follow.png') }} " alt=" ">
                                                <span class="point ">{{ $comment->user_follow }}</span>
                                            </li>
                                            <li>
                                                <img src="{{ url('img/website/icon-heart.png') }} " alt=" ">
                                                <span class="point ">25</span>
                                            </li>
                                            <li>
                                                <img src="{{ url('img/website/icon-review.png') }} " alt=" ">
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
                                <img src="{{ url('img/website/icon-read-more.png') }} ">
                                <a href="#" title="" class="more-link"  data-toggle="modal" data-target="#list-comment-modal">Xem chi tiết</a>
                           </div>
                           <div class="space "></div>
                        </div>
                    </div>
                    @endforeach

                    <!-- Modal show list comment -->
                    <div class="modal-list-comment modal" id="list-comment-modal" role="dialog">
                        <div class="modal-dialog">

                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h3>Cảm nhận cho món: Sin City Cocktail Dip</h3>
                                <div class="row link-most-modal">
                                    <div class="col-md-3 active"><a href="#">Mới nhất</a></div>
                                    <div class="col-md-3"><a href="#">Hữu ích nhất</a></div>
                                    <div class="col-md-3"><a href="#">Ít hữu ích nhất</a></div>
                                    <div class="col-md-3"><a href="#">Xem nhiều nhất</a></div>
                                </div>
                            </div>
                            <div class="modal-body">
                                <div class="row content-comment">
                                    <div class="content-left col-md-7">
                                        <div class="modal-slider"  role="toolbar">
                                            <!-- slider item -->
                                            <div class="modal-slider-item">
                                                <div class="user-comment-header clearfix">
                                                    <div class="avatar-user">
                                                        <img src="{{ url('/') }}/img/website/avatar_user_default.png">
                                                    </div>
                                                    <div class="user-point">
                                                        <div class="user-name">Min Tran</div>
                                                        <ul class="list-point list-unstyled">
                                                            <li>
                                                                <img src="{{ url('/') }}/img/website/icon-follow.png">
                                                                <span>0</span>
                                                            </li>
                                                            <li>
                                                                <img src="{{ url('/') }}/img/website/icon-heart.png">
                                                                <span>0</span>
                                                            </li>
                                                            <li>
                                                                <img src="{{ url('/') }}/img/website/icon-review.png">
                                                                <span>0</span>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="user-comment-content">
                                                    <div class="user-star">
                                                        <i class="fa fa-star fa-lg star " aria-hidden="true "></i>
                                                        <i class="fa fa-star fa-lg star " aria-hidden="true "></i>
                                                        <i class="fa fa-star fa-lg star " aria-hidden="true "></i>
                                                        <i class="fa fa-star fa-lg star " aria-hidden="true "></i>
                                                        <i class="fa fa-star fa-lg star " aria-hidden="true "></i>
                                                    </div>
                                                    <div class="time">
                                                        <i>22/2/2022</i>
                                                    </div>
                                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud</p>
                                                </div>
                                            </div>
                                            <!-- slider item -->
                                            <div class="modal-slider-item">
                                                <div class="user-comment-header clearfix">
                                                    <div class="avatar-user">
                                                        <img src="{{ url('/') }}/img/website/avatar_user_default.png">
                                                    </div>
                                                    <div class="user-point">
                                                        <div class="user-name">Min Tran</div>
                                                        <ul class="list-point list-unstyled">
                                                            <li>
                                                                <img src="{{ url('/') }}/img/website/icon-follow.png">
                                                                <span>0</span>
                                                            </li>
                                                            <li>
                                                                <img src="{{ url('/') }}/img/website/icon-heart.png">
                                                                <span>0</span>
                                                            </li>
                                                            <li>
                                                                <img src="{{ url('/') }}/img/website/icon-review.png">
                                                                <span>0</span>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="user-comment-content">
                                                    <div class="user-star">
                                                        <i class="fa fa-star fa-lg star " aria-hidden="true "></i>
                                                        <i class="fa fa-star fa-lg star " aria-hidden="true "></i>
                                                        <i class="fa fa-star fa-lg star " aria-hidden="true "></i>
                                                        <i class="fa fa-star fa-lg star " aria-hidden="true "></i>
                                                        <i class="fa fa-star fa-lg star " aria-hidden="true "></i>
                                                    </div>
                                                    <div class="time">
                                                        <i>22/2/2022</i>
                                                    </div>
                                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud</p>
                                                </div>
                                            </div>
                                            <!-- slider item -->
                                            <div class="modal-slider-item">
                                                <div class="user-comment-header clearfix">
                                                    <div class="avatar-user">
                                                        <img src="{{ url('/') }}/img/website/avatar_user_default.png">
                                                    </div>
                                                    <div class="user-point">
                                                        <div class="user-name">Min Tran</div>
                                                        <ul class="list-point list-unstyled">
                                                            <li>
                                                                <img src="{{ url('/') }}/img/website/icon-follow.png">
                                                                <span>0</span>
                                                            </li>
                                                            <li>
                                                                <img src="{{ url('/') }}/img/website/icon-heart.png">
                                                                <span>0</span>
                                                            </li>
                                                            <li>
                                                                <img src="{{ url('/') }}/img/website/icon-review.png">
                                                                <span>0</span>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="user-comment-content">
                                                    <div class="user-star">
                                                        <i class="fa fa-star fa-lg star " aria-hidden="true "></i>
                                                        <i class="fa fa-star fa-lg star " aria-hidden="true "></i>
                                                        <i class="fa fa-star fa-lg star " aria-hidden="true "></i>
                                                        <i class="fa fa-star fa-lg star " aria-hidden="true "></i>
                                                        <i class="fa fa-star fa-lg star " aria-hidden="true "></i>
                                                    </div>
                                                    <div class="time">
                                                        <i>22/2/2022</i>
                                                    </div>
                                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="content-footer">
                                            <div class="button">
                                                <button>Previous</button>
                                                <button>Next</button>
                                            </div>
                                            <div class="list-index">
                                                <p>1/9</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="content-right col-md-5">
                                        <div class="advertisement">
                                            <img src="{{ url('/') }}/img/website/adsFreevideo.png">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end feedback content-->
            <div class="col-md-3 ">
                <div class="vote-table ">
                    <div class="rank ">
                        <div class="feedback-rank ">Khá tốt</div>
                        <div class="feedback-4star ">
                            <i class="fa fa-star fa-lg star " aria-hidden="true "></i>
                            <i class="fa fa-star fa-lg star " aria-hidden="true "></i>
                            <i class="fa fa-star fa-lg star " aria-hidden="true "></i>
                            <i class="fa fa-star fa-lg star " aria-hidden="true "></i>
                            <i class="fa fa-lg fa-star-half-o star" aria-hidden="true"></i>
                        </div>
                    </div>
                    <div class="feedback-rank-point ">4,2</div>
                    <div class="feedback-content clearfix">
                      <ul class="feedback-list">
                          <li>
                              <div class="left">
                                  <div class="feedback-list-title">Chất lượng</div>
                                  <div class=" right progessbar ">
                                      <div id="quality"></div>
                                  </div>
                              </div>
                              <div class="right star-point">
                                  <span class="feedback-point">4.5</span>
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
                    <div class="footer-vote-table ">
                        <a href="" title=""><span>285 &nbsp;</span></a>Bình chọn
                    </div>
                </div>                                            
              </div>
              <div class="vote-table2 ">
                  <div class="feedback-header ">
                      <div class="rank ">
                          <div class="feedback-rank ">Mức độ</div>
                      </div>
                  </div>
                  <div class="feedback-content ">
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
                      <div class="vote-button">
                            <a href="javascript:void(0)" title=" ">
                                <img src="{{ url('/') }}/img/website/icon-vote.png ">
                                <span><a href="javascript:void(0)" title="" data-toggle="modal" data-target="#comment-modal">Bình chọn ngay</a></span>
                            </a>
                        </div>
                        <!-- Modal -->
                        <div class="modal-comment modal" id="comment-modal" role="dialog">
                            <div class="modal-dialog">
                        
                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Bình chọn và Cảm nhận</h4>
                                </div>
                                <div class="modal-body">
                                    <form id="rating-comment-form" method="POST" action="" data-id="{{ $store->id }}">
                                        <div class="header-rating clearfix">
                                            <p class="left"><strong>Your rating</strong></p>
                                            <p class="right">It was OK</p>
                                        </div>
                                        <div class="rating-star">
                                            <i class="fa fa-star fa-lg star " aria-hidden="true "></i>
                                            <i class="fa fa-star fa-lg star " aria-hidden="true "></i>
                                            <i class="fa fa-star fa-lg star " aria-hidden="true "></i>
                                            <i class="fa fa-star fa-lg star " aria-hidden="true "></i>
                                            <i class="fa fa-star fa-lg star-grey " aria-hidden="true"></i>
                                        </div>
                                        <div class="comment">
                                            <p><strong>Your review (optional)</strong></p>
                                            <textarea name="comment-text" placeholder="Did you make any changes, and will you make it again"></textarea>
                                        </div>
                                        <div class="submit">
                                            <div class="reset-button"><a href="javascript:void(0)" class="reset">Làm lại</a></div>
                                            <div class="submit-button" data-dismiss="modal"><a href="javascript:void(0)" class="submit">Gửi ngay</a></div>
                                        </div>
                                        <meta name="csrf-token" content="{{ csrf_token() }}">
                                    </form>
                                </div>
                            </div>
                          
                            </div>
                        </div>
                        <!-- End Modal -->
                  </div>
              </div>
            </div>
            <!-- end vote-table -->
        </div>
    </div>
</section>
<!-- end feeling -->
<section class="galery">
    <h2 class="feedback-title ">Hình ảnh <small>18</small></h2>
    <hr>
    <div class="img-galery ">
        <img src="{{ url('/') }}/img/website/galery.jpg " class="img-responsive ">
    </div>
</section>
<!-- end Gallery -->
<hr>
<section class="address ">
    <h2 class="feedback-title ">Địa chỉ</h2>
    <div class="container ">
        <div class="row ">
            <div class="col-md-6 col-sm-6 ">
                <div style="height: 313px; width: 100%;">
                @if ($map)
                    {!! Mapper::render() !!}
                @else
                  <h4>Bản đồ chưa cập nhật vị trí này</h4>
                @endif
                </div>
            </div>
            <div class="col-md-6 col-sm-12 ">
                <div class="address-store ">
                    <h2>{{ $store->name }}</h2>
                    <p>{{ $store->address }}</p>
                </div>
                <div class="row ">
                    <div class="col-md-6 col-sm-6 ">
                        <div class="open ">
                            <img src="{{ url('img/website/icon-open.png') }}" class="img-responsive ">
                            <p>Thời gian hoạt động</p>
                            <p class="opening ">
                                @if ($TimeHelper::check_time_open($store->open_time, $store->close_time, $store->open_day, $store->close_day)==1)
                                    Đang mở cửa
                                @else
                                    Đóng cửa
                                @endif
                            </p>
                            <p>{{ date("G:i:A", strtotime($store->open_time)) }} - {{ date("G:i:A", strtotime($store->close_time)) }}</p>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 ">
                        <div class="ready-time ">
                            <img src="{{ url('img/website/icon-time.png') }}" class="img-responsive ">
                            <p>Thời gian chuẩn bị
                               <br> &nbsp; khoảng 1 ngày </p>
                           </div>
                       </div>
                    </div>
                    <div class="branch clearfix ">
                        <a href="javascript:void(0)" title="">
                            <h4 class="branch-title ">Xem Tất cả Chi nhánh &nbsp;
                                <span>
                                   <img src="{{ url('/img/website/icon-arrow2.png') }} " alt=" ">
                               </span>
                            </h4>
                        </a>
                        <div class="list-branch" style="display: none;">
                            <?php $i = 1; ?>
                            @foreach ($store->branch as $branch)
                                <p><span class="icon-header"><img src="{{ url('/') }}/img/website/icon-location-large.png"> </span>Chi nhánh {{ $i }}: {{ $branch }}</p>
                                <?php $i++; ?>
                            @endforeach
                        </div>
                    </div>
               </div>
           </div>
       </div>
   </section>
   <!-- end Address -->
   <section class="feeling-from">
    <div class="container ">
        <h2 class="felling-from-title ">Cảm nhận được gửi từ</h2>
        <hr>
        <!-- slider feeling-user -->
        <div class="row slider-container">
            <div class="slider">                                       
                <div class="list-feeling-user">
                    <div class="circle-border">
                        <a href="" title=""><img src="{{ url('img/website/avatar-user1.png') }}" class="img-responsive"></a>
                    </div>
                    <div class="user-name ">
                        <a href="" title="">J. Kenji Lopez-Alt</a>
                    </div>                  
                    <ul class="list-unstyled list-point">
                        <li>
                            <img src="{{ url('img/website/icon-follow.png') }}" alt=" ">
                            <span class="point ">9</span>
                        </li>
                        <li>
                            <img src="{{ url('img/website/icon-heart.png') }}" alt=" ">
                            <span class="point ">25</span>
                        </li>
                        <li>
                            <img src="{{ url('img/website/icon-review.png') }}" alt=" ">
                            <span class="point ">13</span>
                        </li>
                    </ul>                                            
                </div>                              
                <div class="list-feeling-user">
                    <div class="circle-border">
                        <a href="" title=""><img src="{{ url('img/website/avatar-user2.png') }}" class="img-responsive"></a>
                    </div>
                    <div class="user-name ">
                        <a href="" title="">J. Kenji Lopez-Alt</a>
                    </div>                  
                    <ul class="list-unstyled list-point">
                        <li>
                            <img src="{{ url('img/website/icon-follow.png') }} " alt=" ">
                            <span class="point ">9</span>
                        </li>
                        <li>
                            <img src="{{ url('img/website/icon-heart.png') }} " alt=" ">
                            <span class="point ">25</span>
                        </li>
                        <li>
                            <img src="{{ url('img/website/icon-review.png') }} " alt=" ">
                            <span class="point ">13</span>
                        </li>
                    </ul>                                            
                </div>
                <div class="list-feeling-user">
                    <div class="circle-border">
                        <a href="" title=""><img src="{{ url('img/website/avatar-user3.png') }}" class="img-responsive"></a>
                    </div>
                    <div class="user-name ">
                        <a href="" title="">J. Kenji Lopez-Alt</a>
                    </div>                  
                    <ul class="list-unstyled list-point">
                        <li>
                            <img src="{{ url('img/website/icon-follow.png') }} " alt=" ">
                            <span class="point ">9</span>
                        </li>
                        <li>
                            <img src="{{ url('img/website/icon-heart.png') }} " alt=" ">
                            <span class="point ">25</span>
                        </li>
                        <li>
                            <img src="{{ url('img/website/icon-review.png') }} " alt=" ">
                            <span class="point ">13</span>
                        </li>
                    </ul>                                            
                </div>
                <div class="list-feeling-user">
                    <div class="circle-border">
                        <a href="" title=""><img src="{{ url('img/website/avatar-user4.png') }}" class="img-responsive"></a>
                    </div>
                    <div class="user-name ">
                        <a href="" title="">J. Kenji Lopez-Alt</a>
                    </div>                 
                    <ul class="list-unstyled list-point">
                        <li>
                            <img src="{{ url('img/website/icon-follow.png') }} " alt=" ">
                            <span class="point ">9</span>
                        </li>
                        <li>
                            <img src="{{ url('img/website/icon-heart.png') }} " alt=" ">
                            <span class="point ">25</span>
                        </li>
                        <li>
                            <img src="{{ url('img/website/icon-review.png') }} " alt=" ">
                            <span class="point ">13</span>
                        </li>
                    </ul>                                            
                </div>
                <div class="list-feeling-user">
                    <div class="circle-border">
                        <a href="" title=""><img src="{{ url('img/website/avatar-user5.png') }}" class="img-responsive"></a>
                    </div>
                    <div class="user-name ">
                        <a href="" title="">J. Kenji Lopez-Alt</a>
                    </div>                
                    <ul class="list-unstyled list-point">
                        <li>
                            <img src="{{ url('img/website/icon-follow.png') }} " alt=" ">
                            <span class="point ">9</span>
                        </li>
                        <li>
                            <img src="{{ url('img/website/icon-heart.png') }} " alt=" ">
                            <span class="point ">25</span>
                        </li>
                        <li>
                            <img src="{{ url('img/website/icon-review.png') }} " alt=" ">
                            <span class="point ">13</span>
                        </li>
                    </ul>                                            
                </div>
            </div>
        </div> 
        <!-- end  slider feeling-user -->                             
    </div>
</section>
<!-- end Felling From -->
</div>
<!--end row  -->
</div>
<!--endcontainer  -->
</div>
<!-- end content -->
</div>
<!-- end store-detail-page  -->

@endsection
@section('define-js')
<script type="text/javascript" src="{{ asset('/js/pages/store-detail.js') }}"></script>
@endsection