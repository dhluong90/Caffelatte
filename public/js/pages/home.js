$(document).ready(function() {
    // Dropdown tags
    $('.dropdown-wp').hide();
    $('.drop_down').click(function() {
        $('.dropdown-wp').slideToggle();
    });

    // Slider
    $('.slider').slick({
        dots: false,
        infinite: true,
        speed: 300,
        slidesToShow: 3,
        slidesToScroll: 3,
        variableWidth: false,
        nextArrow: '<div class="slider-control right"><i class="fa fa-chevron-right btn-next" aria-hidden="true"></i></div>',
        prevArrow: '<div class="slider-control left"><i class="fa fa-chevron-left btn-prev" aria-hidden="true"></i></div>',
        responsive: [{
                breakpoint: 1025,
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

    // event click add, remover tag
    $('.list-inline div i.btn-remove-tag').click(function(e){
        var remover_slug = $(this).data("slug");
        var url_current = window.location.href;
        var new_url = url_current.replace(remover_slug, '').replace('++', '+').replace('=+', '=');
        if (new_url.charAt(new_url.length - 1) == '+') {
            new_url = new_url.slice(0, -1);
        }
        window.location.href = new_url;
    });

    $('.dropdown-wp li.tag a').on('click', function(e){
        e.preventDefault();
        var slug_dropdown = $(this).data("slug");
        var url_current = window.location.href;
        console.log(url_current.indexOf('?tag='));
        if (url_current.indexOf('?tag=') == -1) {
            window.location.href = window.location.href + 'food?tag=' +$(this).data("slug");
        } else {
            window.location.href = url_current + '+' + slug_dropdown;
        }
    });

    $('.slug-default').on('click', function(e){
        var url_current = window.location.href;
        var new_url = url_current.replace('?tag=', '');
        new_url =window.location.origin +  '/food?tag=' +$(this).data("slug");
        window.location.href = new_url;
    });
});
