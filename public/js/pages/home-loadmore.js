$(document).ready(function() {
    console.log($(window).scrollTop());
   // Scroll to view more
    function element_in_scroll(elem) {
        var docViewTop = $(window).scrollTop();
        var docViewBottom = docViewTop + $(window).height();

        var elemTop = $(elem).offset().top;
        var elemBottom = elemTop - $(elem).height() - 100;

        return ((elemBottom <= docViewBottom) && (elemTop >= docViewTop));
    }
     // Biến lưu trữ trang hiện tại
    var page = 0;
    // Biến check ajax có đang chạy?!
    var ajaxRunning = false;
    var hasMoreFeed = true;
    $(document).scroll(function(e){
        if (element_in_scroll(".wrap-footer") && !ajaxRunning && hasMoreFeed) {
            ajaxRunning = true;
            page++;
            $.ajax({
                type:'GET',
                url:'/partial/home/load_more',
                data: {
                    food_start_id: FOOD_START_ID,
                    store_start_id: STORE_START_ID,
                    user_start_id: USER_START_ID,
                    page: page
                },
                success:function(data) {
                    if (data != '') {
                        var $container = $('.grid');
                        $container.append(data);
                        $container.imagesLoaded(function(){
                            $container.masonry({
                                itemSelector: '.grid-col-item',
                                fitWidth: true,
                                horizontalOrder: false
                            });
                        });
                        $container.masonry('layout');
                        $container.masonry('reloadItems');
                    } else {
                        hasMoreFeed = false;
                    }
                },
                error: function(err) {
                    hasMoreFeed = false;
                },
                complete: function(date) {
                    ajaxRunning = false;
                }
            });
        };
    });
});