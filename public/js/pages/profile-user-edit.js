$(document).ready(function() {
    $('#upload').loadImg({
        "text": "Chọn hình đại diện ...",
        "fileExt": ["png", "jpg"],
        "fileSize_min": 0,
        "fileSize_max": 10
    });

    function call_validate_number_only(target_check) {
        target_check.keydown(function(e) {
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
                $(this).parent().append("<div class='alert-error text-danger'>Vui lòng nhập " + field_name + "!</div>");
                $flag = false;
            }
        });
        return $flag;
    }

    //function focus
    var target_focus = null;
    function focus_input_select(target_select) {
        if (target_focus == null) {
            target_focus = target_select;
        }
    }

    $("input").on("change, keypress", function() {
        $(this).closest("div").find(".alert-error").remove();
    });
    $("input[name='profile-new-password'], input[name='profile-re-new-password']").on("change, keypress", function() {
        $("input[name='profile-new-password'], input[name='profile-re-new-password']").closest("div").find(".alert-error").remove();
    });
    var target_check = $("input[name='profile-phone']");
    call_validate_number_only(target_check);

    $('.btn-submit').click(function(e) {
        e.preventDefault();

        var flag = true;

        $("form").find(".alert-error").remove();

        var target_check = $("input[name='profile-name']");
        if (!call_validate_require(target_check, "Tài khoản")) {
            flag = false;
        }
        
        if ($("input[name='profile-new-password']").val() != '' && $("input[name='profile-new-password']").val() != null) {
            var target_check = $("input[name='profile-re-new-password']");
            if (!call_validate_require(target_check, "Nhập lại mật khẩu mới")) {
                flag = false;
            }
        }

        if ($("input[name='profile-re-new-password']").val() != '' && $("input[name='profile-re-new-password']").val() != null) {
            var target_check = $("input[name='profile-new-password']");
            if (!call_validate_require(target_check, "Mật khẩu mới")) {
                flag = false;
            }
        }

        if ($("input[name='profile-old-password']").val() != '' && $("input[name='profile-old-password']").val() != null) {
            if ($("input[name='profile-new-password']").val() == '' || $("input[name='profile-new-password']").val() == null) {
                var target_check = $("input[name='profile-re-new-password']");
                if (!call_validate_require(target_check, "Nhập lại mật khẩu mới")) {
                    flag = false;
                }
            }
            if ($("input[name='profile-re-new-password']").val() == '' || $("input[name='profile-re-new-password']").val() == null) {
                var target_check = $("input[name='profile-new-password']");
                if (!call_validate_require(target_check, "Mật khẩu mới")) {
                    flag = false;
                }
            }
        }

        if (($("input[name='profile-new-password']").val() != '' && $("input[name='profile-new-password']").val() != null) || ($("input[name='profile-re-new-password']").val() != '' && $("input[name='profile-re-new-password']").val() != null)) {
            var target_check = $("input[name='profile-old-password']");
            if (!call_validate_require(target_check, "Mật khẩu cũ")) {
                flag = false;
            }
        }

        var numberReg =  /^[0-9]+$/;
        var numberPhone = $("input[name='profile-phone']");
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

        if (flag) {
            $(".form-profile").submit();
        } else {
            $(target_focus).focus();
            target_focus = null;
        }
    });
});
