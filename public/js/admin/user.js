/**********Submit filter user***********/
$(document).ready(function(){
    $(".btn-set-admin").click(function(e) {
        var currentElement = $(this);
        e.preventDefault();
        alertify.confirm('Xác nhận :', 'Bạn có muốn cấp quyền admin cho người dùng này ?', function() {
            url = currentElement.attr('href');
            window.location = url;
        }, function() {
        });
    });

    $(".btn-unset-admin").click(function(e) {
        var currentElement = $(this);
        e.preventDefault();
        alertify.confirm('Xác nhận :', 'Bạn có muốn hủy quyền admin của người dùng này ?', function() {
            url = currentElement.attr('href');
            window.location = url;
        }, function() {
        });
    });
});