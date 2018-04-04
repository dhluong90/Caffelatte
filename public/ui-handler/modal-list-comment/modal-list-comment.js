$(document).ready(function() {
	//set index item comment
    var index_comment = 0;
    $('.feedback-footer .more-link').click(function() {
        index_comment = $(this).data('id');
        
        $('.list-index .index-comment').text(index_comment + 1);
        owl.trigger("to.owl.carousel", [index_comment, 1, true]);
        checkowl = 0;   //set 0 because change owl call 2 time
    });
    var owl = $('.modal-slider');
    var checkowl = 0;	//event owl change will not run in first
    owl.owlCarousel({
        loop: true,
        nav:true,
        items:1,
        dots: false,
        navText: ['Previous', 'Next'],

    });
    //event click button previous and next
    owl.on('changed.owl.carousel', function(event) {
        if (checkowl != 0) {
            var currentItem = event.item.index;
            var count = event.item.count;
            if (currentItem == 1) {
                currentItem = count + 1;
            }
            $('.list-index .index-comment').text(currentItem - 1);
        } else {
            checkowl = 1;
        }
    });
});