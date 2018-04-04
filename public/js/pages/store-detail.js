/**********Dropdown tags***********/
$(document).ready(function() {
    $('.dropdown-wp').hide();
    $('.drop_down').click(function() {
        $('.dropdown-wp').slideToggle();
    });
    $('.slider').slick({
        dots: false,
        infinite: true,
        speed: 300,
        slidesToShow: 3,
        slidesToScroll: 3,  
        variableWidth: true,
        nextArrow: '<div class="slider-control right"><i class="fa fa-long-arrow-right btn-next" aria-hidden="true"></i></div>',
        prevArrow: '<div class="slider-control left"><i class="fa fa-long-arrow-left btn-prev" aria-hidden="true"></i></div>',
        responsive: [{
                breakpoint: 1024,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1
                }
            }, {
                breakpoint: 600,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1
                }
            }, {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }
            // You can unslick at a given breakpoint now by adding:
            // settings: "unslick"
            // instead of a settings object
        ]
    });
    
});

$(document).ready(function() {
    /* event click add tag */
    $('.list-unstyled.list-category li a.btn-slug').on('click', function(e){
        var slugs =  $(this).data('slug');
        e.preventDefault();
        var url_current = window.location.href;
        if (url_current.indexOf('&page=') >= 0) {
            var url_paginate = url_current.substring(url_current.indexOf('&page='), url_current.indexOf('&page=') + 7);
            url_current = url_current.substring(0,url_current.indexOf('&page='));
            url_current = url_current + '+' + slugs + url_paginate;
            window.location.href = url_current;
        } else if(url_current.indexOf('?tag_slug=') == -1) {
            window.location.href = window.location.href + '?tag_slug=' +$(this).data("slug");
        } else {
            window.location.href = window.location.href + '+' + slugs;
        }
    });
    /* Remove tag when click button "x" */
    $('.category .list-category span i').on('click', function(e){
        var remover_slug =  $(this).data('slug');
        var url_current = window.location.href;
        var new_url = url_current.replace(remover_slug, '').replace('++', '+').replace('=+', '=').replace('+&', '&');
        if (new_url.charAt(new_url.length - 1) == '+') {
            new_url = new_url.slice(0, -1);
        }
        window.location.href = new_url;
    });
    $('.branch a .branch-title').click(function() {
        $('.branch .list-branch').slideToggle();
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
                parent.find('.point-favorite').html(data);
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
                parent.find('.point-favorite ').html(data);
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
});