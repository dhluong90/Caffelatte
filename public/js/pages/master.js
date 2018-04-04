$(document).ready(function() {
    $(".btn-menu").click(function() {
        var obj = $(this).find("i");
        if (obj.hasClass("fa-bars"))
            obj.removeClass("fa-bars").addClass("fa-times");
        else {
            $(".categories").fadeOut(0);
            obj.removeClass("fa-times").addClass("fa-bars");
        }
        $(".sub-menu").slideToggle(0);
    });

    $(".item-sub-menu").click(function(e) {
        e.preventDefault();
        var target = $(this).attr("popup-control");
        $(".categories").each(function() {
            var curItem = $(this);
            if (curItem.css("display") != "block" && curItem.attr("id") == target) {
                curItem.fadeToggle(300);
            } else curItem.fadeOut(0);
        });
    });

    $('.mobile-menu a.dropdown-toggle').on('click', function(e) {
        var $el = $(this);
        var $parent = $(this).offsetParent(".dropdown-menu");
        $(this).parent("li").toggleClass('open');

        if (!$parent.parent().hasClass('nav')) {
            $el.next().css({ "top": $el[0].offsetTop, "left": $parent.outerWidth() - 4 });
        }

        $('.nav li.open').not($(this).parents("li")).removeClass("open");

        return false;
    });

    /***cron to top***/

    $(window).scroll(function() {

        //check condition croll button visible or hidden when move

        if ($(window).scrollTop() >= 700) {

            $('.croll-to-top').css('visibility', 'visible');

        } else {

            $('.croll-to-top').css('visibility', 'hidden');

        }

    }) 
    // process click event
    $('.croll-to-top').on('click', function (e) {

        e.preventDefault();

        $('html,body').animate({

            scrollTop: 0

        }, 700);
        return false;

    });

});