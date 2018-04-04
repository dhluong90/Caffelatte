<?php
    /**
     * list food, store, user main
     * @param array $items_main_content
     * @param array $foods_like_id
     * @param array $stores_like_id 
     */
?>


@foreach ( $items_main_content as $item )                 
@if ( $item->type == "food" )
<?php 
    // setup variable need todo
    $is_liked = isset($foods_like_id) && Auth::id() != null && in_array(
        $item->id, $foods_like_id
    );
?>
<div class="grid-col-item">
    <div class="item-container food">
        <a href="javascript:void(0)" class="icon-like {{ $is_liked ? 'icon-liked' : 'icon-not-like' }}" data-id="{{ $item->id }}"></a>
        <a href="{{ route('website_food_detail', ['food_slug' => $item->slug, 'food_id' => $item->id]) }}">                         
            <img src="{{ empty($item->images) ? url('/') . '/img/website/food_default.jpg' : asset($ImageHelper::get_image_by_size($item->images, '300x300')) }}" alt="" class="img-responsive">
        </a>
        <h3>
            <a href="{{ route('website_food_detail', ['food_slug' => $item->slug, 'food_id' => $item->id]) }}">{{ $item->name }}</a>
        </h3>
        <div class="item-review">
            <a href="">
                <div class="rating-stars">
                    <i class="fa {{ ($item->_rate > 0) ? (($item->_rate > 0.5) ? 'fa-star': 'fa-star-half-o') : 'fa-star-o' }} star" aria-hidden="true"></i>
                    <i class="fa {{ ($item->_rate > 1) ? (($item->_rate > 1.5) ? 'fa-star': 'fa-star-half-o') : 'fa-star-o' }} star" aria-hidden="true"></i>
                    <i class="fa {{ ($item->_rate > 2) ? (($item->_rate > 2.5) ? 'fa-star': 'fa-star-half-o') : 'fa-star-o' }} star" aria-hidden="true"></i>
                    <i class="fa {{ ($item->_rate > 3) ? (($item->_rate > 3.5) ? 'fa-star': 'fa-star-half-o') : 'fa-star-o' }} star" aria-hidden="true"></i>
                    <i class="fa {{ ($item->_rate > 4) ? (($item->_rate > 4.5) ? 'fa-star': 'fa-star-half-o') : 'fa-star-o' }} star" aria-hidden="true"></i>
                </div>
            </a>
            <span class="number-rating">57</span>
            <div class="intro">{{ $item->detail }}</div>
        </div>
        <div class="item-profile">
            <a href="{{ url('/profile/' . $item->user_id) }}">
                <ul class="list-inline item-details">
                    <li>
                        <img src="{{ empty($item->user_image) ? url('/') . '/img/website/avatar_user_default.png' : asset($ImageHelper::get_image_by_size($item->user_image, '150x150')) }}" alt="" class="img-responsive">
                    </li>
                    <li>
                        <h4>{{ $item->user_name }}</h4>
                        <ul class="item-details--followers followers-count">
                            <li>
                                <span class="icon icon-followers"></span>
                            </li>
                            <li>
                                <span class="count">{{ $item->user_follow }}</span>
                            </li>
                        </ul>
                        <ul class="item-details--favorites favorites-count">
                            <li>
                                <span class="icon icon-favorites"></span>
                            </li>
                            <li>
                                <span class="count">{{ $item->_like }}</span>
                            </li>
                        </ul>
                        <ul class="item-details--recipes-made recipes-made-count">
                            <li>
                                <span class="icon fa fa-comments"></span>
                            </li>
                            <li>
                                <span>29</span>
                            </li>
                        </ul>
                    </li>
                </ul>
            </a>
        </div>
    </div>
</div>
@elseif ($item->type == "store")
<?php 
    // setup variable need to do
    //like feature
    $is_liked = isset($stores_like_id) && Auth::id() != null && in_array(
        $item->id, $stores_like_id
    );
    //follow feature
    $is_followed = isset($stores_follow_id) && Auth::id() != null && in_array(
        $item->id, $stores_follow_id
    );
?>
<div class="grid-col-item">
    <div class="item-container store">
        <a href="javascript:void(0)" class="icon-like {{ ($is_liked) ? 'icon-liked' : 'icon-not-like' }}" data-id="{{ $item->id }}"></a>
        <div class="store-info">
            <div class="left-info">
                <a href="{{url('/store/view/'.$item->slug . '/'.$item->id)}}">
                    <img src="{{ empty($item->logo) ? url('/') . '/img/website/store_default.jpg' : asset($ImageHelper::get_image_by_size($item->logo, '150x150')) }}" alt="" class="img-responsive">
                </a>
                <a href="javascript:void(0)" class="follow {{ ($is_followed) ? 'followed' : 'not-follow' }}" data-id="{{ $item->id }}">
                    <span class="icon-followers" style="display: {{ ($is_followed) ? 'none' : 'block' }};"></span>
                    <span class="text-followers">{{ ($is_followed) ? 'Hủy theo dõi' : 'Theo dõi' }}</span>
                </a>
            </div>
            <div class="right-info">
                <span class="item-category">Cửa hàng</span>
                <h4><a href="{{url('/store/view/' . $item->slug.'/'.$item->id)}}">{{ $item->name }}</a></h4>
                <p>
                    <span class="icon-location"></span>
                    <span class="store-address">{{ $item->address }}</span>
                </p>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="item-review">
            <div class="intro">{{ $item->introduction }}</div>
        </div>
        <div class="item-profile">
            <ul class="list-inline item-details">
                <li>
                    <ul class="item-details--followers followers-count">
                        <li>
                            <span class="icon icon-followers"></span>
                        </li>
                        <li>
                            <span class="count">{{ $item->_follow }}</span>
                        </li>
                    </ul>
                    <ul class="item-details--favorites favorites-count">
                        <li>
                            <span class="icon icon-favorites"></span>
                        </li>
                        <li>
                            <span class="count">{{ $item->_like }}</span>
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
    </div>
</div>
@elseif ($item->type == "user" && $item->id !== Auth::id())
<?php 
    // setup variable need to do
    $is_followed = isset($users_follow_id) && Auth::id() != null && in_array(
        $item->id, $users_follow_id
    );
?>
<div class="grid-col-item">
    <div class="item-container review">
        <div class="review-info">
            <div class="left-info">
                <a href="{{ url('profile/' . $item->id) }}">
                    <img src="{{ empty($item->image) ? url('/') . '/img/website/avatar_default.jpg' : asset($ImageHelper::get_image_by_size($item->image, '150x150')) }}" alt="" class="img-responsive">
                </a>
            </div>
            <div class="right-info">
                <a href="{{ url('profile/' . $item->id) }}">
                    <h4>{{ $item->name }}</h4>
                </a>
                <p>
                    Quận 7, Tp.HCM
                </p>
                <a href="javascript:void(0)" class="follow {{ ($is_followed) ? 'followed' : 'not-follow' }}" data-id="{{ $item->id }}">
                    <span class="icon-followers"></span>
                    <span class="text-followers">{{ ($is_followed) ? 'Hủy theo dõi' : 'Theo dõi' }}</span>
                </a>
            </div>
            <div class="clearfix"></div>
        </div>
        <a href="" style="display: none;">
            <div class="item-review">
                <div class="intro">
                    "Những món ăn ngon, trước tiên phải là những món ăn được làm từ nguyên liệu sach..."
                </div>
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
                            <span class="count">{{ $item->_follow }}</span>
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
@endif
@endforeach

