$(document).ready(function() {
    // Mansory genarate content food store user
    function mansory(){
        var $container = $('.grid');
        $container.imagesLoaded(function(){
            $container.masonry({
                itemSelector: '.grid-col-item',
                fitWidth: true,
                horizontalOrder: false
            });
        });
    }

    mansory();

    //food like
    $(document).on('click', '.food .icon-not-like', function() {
        var food_id = $(this).data('id');
        var parent = $(this).parent();
        $.ajax({
            type: 'GET',
            url: 'ajax/food/like/' + food_id,
            success : function(data) {
                parent.find('.favorites-count .count').html(data['data']['like_count']);
                parent.find('.icon-like').addClass('icon-liked');
                parent.find('.icon-like').removeClass('icon-not-like');
            },
            error: function(err) {
                if (err.status == 401) {
                    $('#loginModal').modal('show');
                }
            }
        });
    });

    //store like
    $(document).on('click', '.store .icon-not-like', function() {
        var store_id = $(this).data('id');
        var parent = $(this).parent();
        $.ajax({
            type: 'GET',
            url: 'ajax/store/like/' + store_id,
            success : function(data) {
                parent.find('.favorites-count .count').html(data['data']['like_count']);
                parent.find('.icon-like').addClass('icon-liked');
                parent.find('.icon-like').removeClass('icon-not-like');
            },
            error: function(err) {
                if (err.status == 401) {
                    $('#loginModal').modal('show');
                }
            }
        });
    });

    //food dislike
    $(document).on('click', '.food .icon-liked', function() {
        var food_id = $(this).data('id');
        var parent = $(this).parent();
        $.ajax({
            type: 'GET',
            url: 'ajax/food/dislike/' + food_id,
            success : function(data) {
                parent.find('.favorites-count .count').html(data['data']['like_count']);
                parent.find('.icon-like').addClass('icon-not-like');
                parent.find('.icon-like').removeClass('icon-liked');
            },
            error: function(err) {
                if (err.status == 401) {
                    $('#loginModal').modal('show');
                }
            }
        });
    });

    //store dislike
    $(document).on('click', '.store .icon-liked', function() {
        var store_id = $(this).data('id');
        var parent = $(this).parent();
        $.ajax({
            type: 'GET',
            url: 'ajax/store/dislike/' + store_id,
            success : function(data) {
                parent.find('.favorites-count .count').html(data['data']['like_count']);
                parent.find('.icon-like').addClass('icon-not-like');
                parent.find('.icon-like').removeClass('icon-liked');
            },
            error: function(err) {
                if (err.status == 401) {
                    $('#loginModal').modal('show');
                }
            }
        });
    });

    //user follow
    $(document).on('click', '.review .not-follow', function() {
        var user_id = $(this).data('id');
        var parent = $(this).parent().parent().parent();
        $.ajax({
            type: 'GET',
            url: 'ajax/user/follow/' + user_id,
            success : function(data) {
                parent.find('.followers-count .count').html(data['data']['follow_count']);
                parent.find('.follow .text-followers').html('Hủy theo dõi');
                parent.find('.follow').addClass('followed');
                parent.find('.follow').removeClass('not-follow');
            },
            error: function(err) {
                if (err.status == 401) {
                    $('#loginModal').modal('show');
                }
            }
        });
    });

    //user unfollow
    $(document).on('click', '.review .followed', function() {
        var user_id = $(this).data('id');
        var parent = $(this).parent().parent().parent();
        $.ajax({
            type: 'GET',
            url: 'ajax/user/unfollow/' + user_id,
            success : function(data) {
                parent.find('.followers-count .count').html(data['data']['follow_count']);
                parent.find('.follow .text-followers').html('Theo dõi');
                parent.find('.follow').addClass('not-follow');
                parent.find('.follow').removeClass('followed');
            },
            error: function(err) {
                if (err.status == 401) {
                    $('#loginModal').modal('show');
                }
            }
        });
    });

    //store follow
    $(document).on('click', '.store .not-follow', function() {
        var store_id = $(this).data('id');
        var parent = $(this).parent().parent().parent();
        $.ajax({
            type: 'GET',
            url: 'ajax/store/follow/' + store_id,
            success : function(data) {
                parent.find('.followers-count .count').html(data['data']['follow_count']);
                parent.find('.follow .text-followers').html('Hủy theo dõi');
                parent.find('.follow .icon-followers').css('display','none');
                parent.find('.follow').addClass('followed');
                parent.find('.follow').removeClass('not-follow');
            },
            error: function(err) {
                if (err.status == 401) {
                    $('#loginModal').modal('show');
                }
            }
        });
    });

    //store unfollow
    $(document).on('click', '.store .followed', function() {
        var store_id = $(this).data('id');
        var parent = $(this).parent().parent().parent();
        $.ajax({
            type: 'GET',
            url: 'ajax/store/unfollow/' + store_id,
            success : function(data) {
                parent.find('.followers-count .count').html(data['data']['follow_count']);
                parent.find('.follow .text-followers').html('Theo dõi');
                parent.find('.follow .icon-followers').css('display','block');
                parent.find('.follow').addClass('not-follow');
                parent.find('.follow').removeClass('followed');
            },
            error: function(err) {
                if (err.status == 401) {
                    $('#loginModal').modal('show');
                }
            }
        });
    });
});