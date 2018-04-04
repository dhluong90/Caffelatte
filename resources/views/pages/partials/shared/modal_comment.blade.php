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
            <form id="rating-comment-form" method="POST" action="" data-id="{{ $item->id }}">
                <div class="header-rating clearfix">
                    <p class="left"><strong>Your rating</strong></p>
                    <p class="right">It was OK</p>
                </div>
                <div class="rating-star">
                    <i class="fa fa-star fa-lg star " aria-hidden="true " data-id="0"></i>
                    <i class="fa fa-star fa-lg star " aria-hidden="true " data-id="1"></i>
                    <i class="fa fa-star fa-lg star " aria-hidden="true " data-id="2"></i>
                    <i class="fa fa-star fa-lg star-grey " aria-hidden="true " data-id="3"></i>
                    <i class="fa fa-star fa-lg star-grey " aria-hidden="true " data-id="4"></i>
                </div>
                <div class="comment">
                    <p><strong>Your review (optional)</strong></p>
                    <textarea name="comment-text" placeholder="Did you make any changes, and will you make it again"></textarea>
                </div>
                <div class="submit">
                    <div class="reset-button"><a href="javascript:void(0)" class="reset">Làm lại</a></div>
                    <div class="submit-button"  data-dismiss="modal"><a href="javascript:void(0)" class="submit">Gửi ngay</a></div>
                </div>
                <meta name="csrf-token" content="{{ csrf_token() }}">
            </form>
        </div>
    </div>
  
    </div>
</div>
<!-- End Modal -->