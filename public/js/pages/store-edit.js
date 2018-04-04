$(document).ready(function() {
    /***plugin image***/
    $('#upload').loadImg({
        "text"          : "Chọn hình đại diện ...",
        "fileExt"       : ["png","jpg"],
        "fileSize_min"  : 0,
        "fileSize_max"  : 2
    });

    // /***add input link branch***/
    // var btn_add = $(".btn-add-more");
    // btn_add.click(function(e) {
    //     e.preventDefault();

    //     $(".branch").remove();

    //     var total_branches = $(".branch-total").val();
    //     if (total_branches > 0) {
    //         var branches_container = $(".branches-container");
    //         for (var i = 1; i <= total_branches; i++) {
    //             var template = '<div class="row branch"><div class="col-md-2 input-heading"><label>Chi nhánh ' + i + '</label></div><div class="col-md-10"><input type="text" name="store-branch[]" id="" class="form-control store-branch" placeholder="Địa chỉ"></div></div>';
    //             branches_container.append(template);
    //         }
    //     }
    // }); 

    function call_validate_number_only(target_check) {
        target_check.keydown(function (e) {
            // Allow: backspace, delete, tab, escape, enter and .
            if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
                 // Allow: Ctrl+A, Command+A
                (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) || 
                 // Allow: home, end, left, right, down, up
                (e.keyCode >= 35 && e.keyCode <= 40)) {
                     // let it happen, don't do anything
                     return;
            }
            // Ensure that it is a number and stop the keypress
            if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                e.preventDefault();
            }
        });
    }

    //function focus
    var target_focus = null;
    function focus_input_select(target_select) {
        if (target_focus == null) {
            target_focus = target_select;
        }
    }

    var target_check = $(".set-price, .set-price-range");
    call_validate_number_only(target_check);

    /***create flag for submit form***/
    function call_validate_require(target_check, message = null) {
        var $flag = true;
        target_check.each(function() {
            if (message == null) {
                if ($(this).attr("placeholder") == null) {
                    var field_name = $(this).siblings("label").text();
                } else {
                    var field_name = $(this).attr("placeholder");
                }
            } else {
                var field_name = message;
            }
            
            if ($(this).val() == "" || $(this).val() == null) {
                $(this).parent().append("<div class='alert-error text-danger'>Vui lòng nhập " + field_name + " !</div>");
                focus_input_select(this);
                $flag = false;
            }
        });
        return $flag;
    }
    /***submit form***/
    $(".btn-submit").click(function(e) {
        e.preventDefault();

        var flag = true;

        $("form").find(".alert-error").remove();

        var target_check = $("input[name='store-name']");
        if (!call_validate_require(target_check, "Tên cửa hàng")) {
            flag = false;
        }

        var target_check = $("textarea[name='store-introduction']");
        if (!call_validate_require(target_check, "Mô tả")) {
            flag = false;
        }

        var target_check = $("input[name='store-sector']");
        if (!call_validate_require(target_check, "Lĩnh vực")) {
            flag = false;
        }

        var target_check = $("input[name='store-address']");
        if (!call_validate_require(target_check, "Địa chỉ")) {
            flag = false;
        }

        var target_check = $("input[name='store-phone']");
        if (!call_validate_require(target_check, "Điện thoại")) {
            flag = false;
        }

        var target_check = $(".branches-container input");
        if (!call_validate_require(target_check, "Chi nhánh")) {
            flag = false;
        }

        var target_check = $("select[name=store-open-time] option:selected");
        if (!call_validate_require(target_check, "Thời gian mở cửa")) {
            flag = false;
        }

        var target_check = $("select[name=store-close-time] option:selected");
        if (!call_validate_require(target_check, "Thời gian đóng cửa")) {
            flag = false;
        }

        var target_check = $("select[name=store-open-day] option:selected");
        if (!call_validate_require(target_check, "Thời gian hoạt động")) {
            flag = false;
        }

        var target_check = $("select[name=store-close-day] option:selected");
        if (!call_validate_require(target_check, "Thời gian ngừng hoạt động")) {
            flag = false;
        }

        var numberReg =  /^[0-9]+$/;
        var numberPhone = $("input[name='store-phone']");
        if (!numberReg.test(numberPhone.val()) && numberPhone.val() != '') {
            numberPhone.parent().append("<div class='alert-error text-danger'>Số điện thoại phải là số !</div>");
            focus_input_select(numberPhone);
            flag = false;
        } 
        if (numberPhone.val().length < 10 && numberPhone.val() != '' && numberReg.test(numberPhone.val())) {
            numberPhone.parent().append("<div class='alert-error text-danger'>Số điện thoại phải tối thiểu 10 số !</div>");
            focus_input_select(numberPhone);
            flag = false;
        } 
        if (numberPhone.val().length > 11 && numberPhone.val() != '' && numberReg.test(numberPhone.val())) {
            numberPhone.parent().append("<div class='alert-error text-danger'>Số điện thoại chỉ tối đa 11 số !</div>");
            focus_input_select(numberPhone);
            flag = false;
        }

        //check facebook
        var target_check = $("input[name='store-facebook']");
        var target_value = $(target_check).val();
        if (target_value.search('facebook.com') == -1){
            $(target_check).parent().append("<div class='alert-error text-danger'>Không đúng định dạng. facebook.com/example</div>");
            focus_input_select(target_check);
            flag = false;
        }

        //check email
        var target_check = $("input[name='store-email']");
        var target_value = $(target_check).val();
        var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        if (!filter.test(target_value)) { 
            $(target_check).parent().append("<div class='alert-error text-danger'>Địa chỉ email ko hợp lệ. example@gmail.com</div>");
            focus_input_select(target_check);
            flag = false;
        }

        if (flag) {
            $(".form-create-store").submit();
        } else {
            $(target_focus).focus();
            target_focus = null;
            flag = true;
        }
    });

    $(".btn-reset").click(function(e) {
        e.preventDefault();
        $(this).closest('form').find("input[type=text], textarea, select").val("");
    });

    $(".btn-delete").click(function(e) {
        var currentElement = $(this);
        e.preventDefault();
        alertify.confirm('Xác Nhận Xóa', 'Bạn có chắc muốn xóa cửa hàng này? Khi xóa cửa hàng, tất cả các món ăn thuộc cửa hàng này cũng sẽ bị xóa !', function() {
            // console.log(currentElement.attr('href'));
            url = currentElement.attr('href');
            window.location = url;
            // alertify.success('Ok')
        }, function() {
            // alertify.error('Cancel')
        });
    });
});
/********************Process branch********************/
$(document).ready(function(){
    function check_btn_remove(target_check, btn_container) {
        var total_target_check = target_check.length;
        if (total_target_check === 1) {
            target_check.find(btn_container).fadeOut(0);
        } else {
            target_check.find(btn_container).fadeIn(0);
        }
    }
    function reorder_number(target_order, element_text, label_text) {
        var number = 0;
        target_order.each(function() {
            number++;
            var step_number = $(this).find(element_text).html();
            $(this).find(element_text).html(label_text + number);
        });
    }
    // Add branch
    var btn_add_branch = $(".btn-more-branch");
    btn_add_branch.click(function(e) {
        e.preventDefault();

        var branch_number = $('.branch').length + 1;
        var before_element = $(".more-branch");
        var template = '<div class="row branch"><div class="col-md-2 input-heading"><label>Chi nhánh ' + branch_number + '</label></div><div class="col-md-9"><input type="text" name="store-branch[' + branch_number + ']" id="" class="form-control store-branch" placeholder="Địa chỉ"></div><div class="col-md-1 remove-branch"><a href="" class="btn-remove-branch"><i class="fa fa-minus" aria-hidden="true"></i></a></div></div>';
        before_element.before(template);

        $("input, textarea").on("keypress", function() {
            $(this).closest("div").find(".alert-error").remove();
        });

        var target_check = $('.branch');
        var btn_container = '.remove-branch';
        check_btn_remove(target_check, btn_container);
    });
    // Remove branch
    var target_check = $('.branch');
    var btn_container = '.remove-branch';
    check_btn_remove(target_check, btn_container);

    $(document).on('click', '.btn-remove-branch', function(e) {
        e.preventDefault();

        $(this).parent().parent().remove();

        var target_check = $('.branch');
        var btn_container = '.remove-branch';
        check_btn_remove(target_check, btn_container);

        var target_order = $('.branch');
        var element_text = 'label';
        var label_text = 'Chi nhánh ';
        reorder_number(target_order, element_text, label_text);
    });
});

/**********Check value Open time and Close time***********/
$(document).ready(function(){
    function remove_all_disable_options(target) {
        target.each(function() {
            $(this).removeAttr("disabled");
        });
    }
    //Lock time first
    var value_store_close_time = $('#store_close_time').val();
    remove_all_disable_options($("#store_open_time option"));
    $("#store_open_time option").each(function() {
        if ($(this).val() >= value_store_close_time) {
            $(this).attr("disabled", "disabled");
            console.log($(this).val());
        }

    });
    var value_store_open_time = $('#store_open_time').val();
    remove_all_disable_options($("#store_close_time option"));
    $("#store_close_time option").each(function() {
        if ($(this).val() <= value_store_open_time) {
            $(this).attr("disabled", "disabled");
            console.log($(this).val());
        }

    });

    $('#store_close_time').change(function(){
        var value_store_close_time = $('#store_close_time').val();
        remove_all_disable_options($("#store_open_time option"));
        $("#store_open_time option").each(function() {
            if ($(this).val() >= value_store_close_time) {
                $(this).attr("disabled", "disabled");
                console.log($(this).val());
            }

        });
    });

    $('#store_open_time').change(function(){
        var value_store_open_time = $('#store_open_time').val();
        remove_all_disable_options($("#store_close_time option"));
        $("#store_close_time option").each(function() {
            if ($(this).val() <= value_store_open_time) {
                $(this).attr("disabled", "disabled");
                console.log($(this).val());
            }

        });
    });
});

/**********Check value Open day and Close day***********/
$(document).ready(function(){
    function remove_all_disable_options(target) {
        target.each(function() {
            $(this).removeAttr("disabled");
        });
    }

    //Lock day first
    var value_store_close_day = $('#store_close_day').val();
    remove_all_disable_options($("#store_open_day option"));
    $("#store_open_day option").each(function() {
        if ($(this).val() >= value_store_close_day) {
            $(this).attr("disabled", "disabled");
            console.log($(this).val());
        }

    });
    var value_store_open_day = $('#store_open_day').val();
    remove_all_disable_options($("#store_close_day option"));
    $("#store_close_day option").each(function() {
        if ($(this).val() <= value_store_open_day) {
            $(this).attr("disabled", "disabled");
            console.log($(this).val());
        }

    });
    $('#store_close_day').change(function(){
        var value_store_close_day = $('#store_close_day').val();
        remove_all_disable_options($("#store_open_day option"));
        $("#store_open_day option").each(function() {
            if ($(this).val() >= value_store_close_day) {
                $(this).attr("disabled", "disabled");
                console.log($(this).val());
            }

        });
    });

    $('#store_open_day').change(function(){
        var value_store_open_day = $('#store_open_day').val();
        remove_all_disable_options($("#store_close_day option"));
        $("#store_close_day option").each(function() {
            if ($(this).val() <= value_store_open_day) {
                $(this).attr("disabled", "disabled");
                console.log($(this).val());
            }

        });
    });
});