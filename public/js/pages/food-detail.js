$(document).ready(function() {
    $(".links-bar li").mouseenter(function() {
        var target = 0;
        var flag = 0;
        // var target_temp = 0;
        $(".links-bar li").each(function() {
        	$(this).removeClass("active");
        	$(this).css("background-image", "url(/img/website/icon_" + $(this).attr("class") + ".png)");
            if ($(this).is(':hover')) {
                flag = 1;
                $(this).css("background-image", "url(/img/website/icon_" + $(this).attr("class") + "_active.png)");
                // target_temp = $(this).outerWidth(true);
            }
            if (flag == 0) {
                target += $(this).outerWidth(true);
            }
            
        });
        // $(".effect-background").css("width", target_temp);
        // target += ($(this).outerWidth(true) - $(this).outerWidth()) / 2;
        // console.log(target);
        $(".effect-background").css("left", target);
        $(this).addClass("active");
    });

    $('.links-bar').mouseleave(function() {
        $(".links-bar li").each(function() {
            $(this).removeClass("active");
            $(this).css("background-image", "url(/img/website/icon_" + $(this).attr("class") + ".png)");
            
        });
        $('.effect-background').css('left', 0);
        $('li.booking').css('background-image', 'url(/img/website/icon_' + $('li.booking').attr('class') + '_active.png)');
        $('li.booking').addClass('active');
        
    });

    $('.slider-product-detail').slick({
        slidesToShow: 6,
        slidesToScroll: 6,
        arrows: true,
        infinite: true,
        cssEase: 'linear',
        nextArrow: '<div class="slider-control right"><i class="fa fa-chevron-right btn-next" aria-hidden="true"></i></div>',
        responsive: [{
                breakpoint: 1024,
                settings: {
                    slidesToShow: 5,
                    slidesToScroll: 5,
                    variableWidth: true
                }
            }, {
                breakpoint: 600,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2,
                    variableWidth: true
                }
            }, {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    variableWidth: true
                }
            }
            // You can unslick at a given breakpoint now by adding:
            // settings: "unslick"
            // instead of a settings object
        ]
    });

    $('.slider-widget').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: true,
        infinite: true,
        cssEase: 'linear',
        nextArrow: '<div class="slider-control right"><i class="fa fa-chevron-right btn-next" aria-hidden="true"></i></div>',
        
    });

    $.ajax({
        type: 'GET',
        url: '/partial/food/get_video',
        data: {
            videos: FOOD.videos,
        },
        success:function(data) {
            if (data != '') {
                $('.list-video').append(data);
            }
        },
        error: function(err) {
            hasMoreFeed = false;
        },
        complete: function(date) {
            ajaxRunning = false;
        }
    });

    // Dropdown tags
    $('.dropdown-wp').hide();
    $('.drop_down').click(function() {
        $('.dropdown-wp').slideToggle();
    });

    //event click like food
    //food like
    $(document).on('click', '.icon-not-like', function() {
        var food_id = $(this).data('id');
        var parent = $(this).parent();
        $.ajax({
            type: 'GET',
            url: 'ajax/food/like/' + food_id,
            success : function(data) {
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
    $(document).on('click', '.icon-liked', function() {
        var food_id = $(this).data('id');
        var parent = $(this).parent();
        $.ajax({
            type: 'GET',
            url: 'ajax/food/dislike/' + food_id,
            success : function(data) {
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

    $(document).on('click', '.show-video', function() {
        var id_video = $(this).data('video');
        $('.modal-body iframe').attr('src', 'https://www.youtube.com/embed/' + id_video + '?rel=0');
    });
})
