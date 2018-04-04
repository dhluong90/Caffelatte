/**********Delete***********/
$(document).ready(function() {
    $(".btn-delete").click(function(e) {
        var currentElement = $(this);
        e.preventDefault();
        alertify.confirm('Xác Nhận Xóa', 'Bạn có chắc muốn xóa?', function() {
            // console.log(currentElement.attr('href'));
            url = currentElement.attr('href');
            window.location = url;
            // alertify.success('Ok')
        }, function() {
            // alertify.error('Cancel')
        });
    });
});

/**********Approve**********/
$(document).ready(function() {
    $(".btn-pending").click(function(e) {
        var currentElement = $(this);
        e.preventDefault();
        alertify.confirm('Xác nhận duyệt :', 'Bạn có chắc muốn duyệt ?', function() {
            url = currentElement.attr('href');
            window.location = url;
        }, function() {
        });
    });
});

/**********Check value Open time and Close time***********/
$(document).ready(function(){
    function remove_all_disable_options(target) {
        target.each(function() {
            $(this).removeAttr("disabled");
        });
    }

    $('#store_close_time').change(function(){
        var a = $('#store_open_time');
        var b = $('#store_close_time').val();
        remove_all_disable_options($("#store_open_time option"));
        $("#store_open_time option").each(function() {
            if ($(this).val() == b) {
                $(this).attr("disabled", "disabled");
                console.log($(this).val());
            }

        });
    });

    $('#store_open_time').change(function(){
        var a = $('#store_open_time').val();
        var b = $('#store_close_time');
        remove_all_disable_options($("#store_close_time option"));
        $("#store_close_time option").each(function() {
            if ($(this).val() == a) {
                $(this).attr("disabled", "disabled");
                console.log($(this).val());
            }

        });
    });
});
