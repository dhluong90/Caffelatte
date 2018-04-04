$(document).ready(function() {
    $('#rating-comment-form .reset-button').click(function() {
        $('#rating-comment-form textarea[name="comment-text"]').val('');
    });

    $('#rating-comment-form .submit-button').click(function() {
        $('#rating-comment-form').submit();
        $('#rating-comment-form textarea[name="comment-text"]').val('');
    });

    $('#rating-comment-form').submit(function(event) {
        event.preventDefault();
        var item_id = $(this).data('id');
        var content = $(this).find('textarea[name="comment-text"]').val();
        var csrf_token = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            type: 'POST',
            url: 'ajax/' + PAGE + '/comment',
            data: {
                item_id: item_id,
                content: content,
                rate: rate,
                _token: csrf_token,
            },
            success : function(data) {
                $('section.feeling .feedback-title').html('Cảm nhận <small>'+data['data']['comment_count']+'</small>');
                $('.vote-table .feedback-rank-point').text(data['data']['rate']);
            },
            error: function(err) {
                if (err.status == 401) {
                    $('#loginModal').modal('show');
                }
            }
        });
    });

    var rate = 3;
    $('.rating-star .fa').mouseenter(function() {
        var id = $(this).data('id');
        rate = id + 1;
        $(this).parent().find('.fa:lt(' + id + ')').removeClass('star-grey');
        $(this).parent().find('.fa:lt(' + id + ')').addClass('star');

        $(this).removeClass('star-grey');
        $(this).addClass('star');

        $(this).parent().find('.fa:gt(' + id + ')').removeClass('star');
        $(this).parent().find('.fa:gt(' + id + ')').addClass('star-grey');

        switch(id) {
            case 0:
                $(this).parent().parent().find('p.right').text('It was bad');
                break;
            case 1:
                $(this).parent().parent().find('p.right').text('It was normal');
                break;
            case 2:
                $(this).parent().parent().find('p.right').text('It was OK');
                break;
            case 3:
                $(this).parent().parent().find('p.right').text('It was great');
                break;
            case 4:
                $(this).parent().parent().find('p.right').text('It was perfect');
                break;
            default:
                break;
        }
    });
});