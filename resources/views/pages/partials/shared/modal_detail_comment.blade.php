<?php
	/**
	 * @param $comments list comment with user comment
	 */
?>

<!-- modal list comment -->
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
                    <div class="owl-carousel owl-theme modal-slider">
                        <!-- item -->
                        @foreach ($comments as $comment)
                        <div class="item">
                            <div class="user-comment-header clearfix">
                                <div class="avatar-user">
                                    <img src="{{ ($comment->user_image == '') ? url('/').'/img/website/avatar_user_default.png' :  asset($ImageHelper::get_image_by_size($comment->user_image, '150x150')) }}">
                                </div>
                                <div class="user-point">
                                    <div class="user-name">{{ $comment->user_name }}</div>
                                    <ul class="list-point list-unstyled">
                                        <li>
                                            <img src="{{ url('/') }}/img/website/icon-follow.png">
                                            <span>{{ $comment->user_follow }}</span>
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
                                    <i>{{ date('d/m/Y', $comment->created_at) }}</i>
                                </div>
                                <p>{{ $comment->content }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="content-footer">
                        <div class="list-index">
                            <p><span class="index-comment">1</span>/<span class="sum-comment">4</span></p>
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