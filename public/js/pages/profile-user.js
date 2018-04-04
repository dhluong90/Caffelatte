$(document).ready(function() {
    $('.btn-submit').click(function(e){
        e.preventDefault();
        $(".form-update-user").submit();
    });
});