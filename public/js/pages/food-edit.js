$(document).ready(function() {
    $('#upload').loadImg({
        "text": "Chọn hình đại diện ...",
        "fileExt": ["png", "jpg"],
        "fileSize_min": 0,
        "fileSize_max": 10
    });

    var btn_set_price = $(".btn-set-price");
    var btn_set_price_range = $(".btn-set-price-range");

    btn_set_price.click(function() {
        var input_control_disable = $(".set-price-range");
        var input_control_enable = $(".set-price");

        input_control_disable.prop('disabled', true);
        input_control_enable.prop('disabled', false);
    });

    btn_set_price_range.click(function() {
        var input_control_disable = $(".set-price");
        var input_control_enable = $(".set-price-range");

        input_control_disable.prop('disabled', true);
        input_control_enable.prop('disabled', false);
    });


    $('.tags .btn-more-tag').click(function(e) {
        e.preventDefault();
        $('.dropdown-wp').slideToggle();
    });

    $('.tags .span-more-tag').click(function(e) {
        e.preventDefault();
        $('.dropdown-wp').slideToggle();
    });

    function reorder_number(target_order, element_text, label_text) {
        var number = 0;
        target_order.each(function() {
            number++;
            var step_number = $(this).find(element_text).html();
            $(this).find(element_text).html(label_text + number);
        });
    }

    function sort_alphabetically(container, target, object_sort) {
        var alphabetically_sort = $(target).sort(function(a, b) {
            return $(a).find(object_sort).val().localeCompare($(b).find(object_sort).val());
        });
        $(container).html(alphabetically_sort);
    }

    sort_alphabetically(".list-all-tags", ".list-all-tags div", "input");

    function add_tag(tag) {
        var container = $(".tags-container");
        tag = tag.replace('class="tag"', 'class="tag" name="tags[]"');
        var template = "<div>" + tag + "</div>";

        container.append(template);
    }

    $(document).on('click', '.list-all-tags input, .list-all-tags span', function(e) {
        e.preventDefault();
        if ($('.validate-tag').length > 0) {
            $('.validate-tag').parent().remove();
        }
        
        var tag = $(this).parent().html();

        add_tag(tag);
        $(this).parent().remove();

        if ($('.tags-container .tag').length) {
            $('.tags .btn-more-tag').parent().find('br').remove();
            $('.tags .btn-more-tag').parent().find('.alert-error').remove();
        }

        sort_alphabetically(".list-all-tags", ".list-all-tags div", "input");
        sort_alphabetically(".tags-container", ".tags-container div", "input");
    });

    function remove_tag(tag) {
        var container_2 = $(".list-all-tags");
        tag = tag.replace('name="tags[]"', '');
        var template_2 = "<div>" + tag + "</div>";

        container_2.append(template_2);
    }

    function check_btn_remove(target_check, btn_container) {
        var total_target_check = target_check.length;
        if (total_target_check === 1) {
            target_check.find(btn_container).fadeOut(0);
        } else {
            target_check.find(btn_container).fadeIn(0);
        }
    }

    $(document).on('click', '.btn-remove-tag', function(e) {
        e.preventDefault();
        var tag = $(this).parent().html();

        remove_tag(tag);
        $(this).parent().remove();

        if (!$('.tags-container .tag').length) {
            $('.tags-container').append('<div><input type="hidden" class="tag validate-tag" name="tags[]" readonly=""></div>');
        }

        sort_alphabetically(".list-all-tags", ".list-all-tags div", "input");
        sort_alphabetically(".tags-container", ".tags-container div", "input");
    });


    var btn_add_step = $(".btn-more-step");
    btn_add_step.click(function(e) {
        e.preventDefault();

        var step_number = $('.guide-step').length + 1;
        var before_element = $(".more-step");
        var template = '<div class="row guide-step"><div class="col-md-10 guide-step-number"><h5>Bước ' + step_number + '</h5></div><div class="col-md-2 remove-step"><a href="" class="btn-remove-step"><i class="fa fa-minus" aria-hidden="true"></i></a></div><div class="col-md-7 guide-step-title"><input type="text" class="form-control" name="food-step-title[]" placeholder="Tiêu đề"><div class="text-danger"></div></div><div class="col-md-5 guide-step-time"><label>Thời gian</label><input type="text" class="form-control" name="food-step-time[]"><div class="clearfix"></div><div class="text-danger"></div></div><div class="col-md-12 guide-step-description"><textarea name="food-step-description[]" id="" cols="30" rows="4" class="form-control" placeholder="Mô tả"></textarea><div class="text-danger"></div></div></div>';
        before_element.before(template);

        var target_check = $("input[name='food-step-time[]']");
        $("input, textarea").on("keypress", function() {
            $(this).closest("div").find(".alert-error").remove();
        });

        var target_check = $('.guide-step');
        var btn_container = '.remove-step';
        check_btn_remove(target_check, btn_container);
    });
    var target_check = $('.guide-step');
    var btn_container = '.remove-step';
    check_btn_remove(target_check, btn_container);

    $(document).on('click', '.btn-remove-step', function(e) {
        e.preventDefault();

        $(this).parent().parent().remove();

        var target_check = $('.guide-step');
        var btn_container = '.remove-step';
        check_btn_remove(target_check, btn_container);

        var target_order = $('.guide-step');
        var element_text = 'h5';
        var label_text = 'Bước '
        reorder_number(target_order, element_text, label_text);
    });

    var btn_add_link = $(".btn-more-link");
    btn_add_link.click(function(e) {
        e.preventDefault();

        var link_number = $('.link').length + 1;
        var before_element = $(".more-link");
        var template = '<div class="row link"><div class="col-md-2 input-heading"><label>Link ' + link_number + '</label></div><div class="col-md-8"><input type="text" name="food-link[]" class="form-control"></div><div class="col-md-2 remove-link"><a href="" class="btn-remove-link"><i class="fa fa-minus" aria-hidden="true"></i></a></div></div>';
        before_element.before(template);

        $("input, textarea").on("keypress", function() {
            $(this).closest("div").find(".alert-error").remove();
        });

        var target_check = $('.link');
        var btn_container = '.remove-link';
        check_btn_remove(target_check, btn_container);
    });
    var target_check = $('.link');
    var btn_container = '.remove-link';
    check_btn_remove(target_check, btn_container);

    $(document).on('click', '.btn-remove-link', function(e) {
        e.preventDefault();

        $(this).parent().parent().remove();

        var target_check = $('.link');
        var btn_container = '.remove-link';
        check_btn_remove(target_check, btn_container);

        var target_order = $('.link');
        var element_text = 'label';
        var label_text = 'Link '
        reorder_number(target_order, element_text, label_text);
    });

    function call_validate_compare_number(number_1, number_2) {
        var number_1 = parseInt(number_1);
        var number_2 = parseInt(number_2);

        return number_1 > number_2;
    }

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

    function call_validate_max(number, max) {
        var number = parseInt(number);
        var max = parseInt(max);

        return number <= max;
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
                focus_input_select(this);
                $flag = false;
            }
        });
        return $flag;
    }

    $("input, textarea").on("keypress", function() {
        $(this).closest("div").find(".alert-error").remove();
    });

    $("input[name='step-total']").on("change", function() {
        if ($(this).parent().siblings(".alert-error").length > 0)
            $(this).parent().siblings(".alert-error").remove();
    });


    $(".btn-submit").click(function(e) {
        e.preventDefault();

        var flag = true;

        $("form").find(".alert-error").remove();
        
        if ($("input[name='opt_price']:checked").val() == "one-price") {
            var target_check = $(".set-price");
            if (!call_validate_require(target_check, "giá")) {
                    flag = false;
            } else if (!call_validate_max(target_check.val(), FOOD_PRICE_MAX)) {
                    $(target_check).parent().append("<div class='alert-error text-danger'>Giá không được lớn hơn " + FOOD_PRICE_MAX + "!</div>");
                    focus_input_select(this);
                    flag = false;
            }
        } else {
            var target_check = $(".set-price-range");
            if (!call_validate_require(target_check, "")) {
                    flag = false;
            }
        }
        
        var target_check = $("input[name='food-name']");
        if (!call_validate_require(target_check, "Tên sản phẩm")) {
            flag = false;
        }

        var target_check = $("textarea[name='food-description']");
        if (!call_validate_require(target_check, "Mô tả")) {
            flag = false;
        }

        var target_check = $(".guide-step input, .guide-step textarea");
        if (!call_validate_require(target_check, "")) {
            flag = false;
        }

        var target_check = $(".guide-links-container input");
        if (!call_validate_require(target_check, "Link")) {
            flag = false;
        }

        var number_1 = $("input[name='food-price-to']");
        var number_2 = $("input[name='food-price-from']");
        if (number_1.val() != 0 && number_1.val() != null && number_2 != 0 && number_2 != null) {
            if (call_validate_compare_number(number_1.val(), number_2.val()) === false) {
                number_1.parent().append("<div class='alert-error text-danger'>Trường giá đến phải lớn hơn trường giá từ!</div>");
                focus_input_select(number_1);
                flag = false;
            }
        }

        if ($('.tags-container .tag').val() < 1) {
            flag = false;
            $('.tags .btn-more-tag').parent().find('br').remove();
            $('.tags .btn-more-tag').parent().append("<br /><br /><div class='alert-error text-danger'>Vui lòng chọn Tag!</div>");
            focus_input_select('.tags .btn-more-tag');
        }
        
        if (flag) {
            $(".form-edit-food").submit();
        } else {
            target_focus.focus();
            target_focus = null;
            flag = true;
        }
    });

    $(".btn-reset").click(function(e) {
        e.preventDefault();
        $(this).closest('form').find("input:not([type='radio']), textarea, select").val("");
    });
    $(".btn-delete").click(function(e) {
        var currentElement = $(this);
        e.preventDefault();
        alertify.confirm('Xác Nhận Xóa', 'Bạn có chắc muốn xóa món ăn này?', function() {
            // console.log(currentElement.attr('href'));
            url = currentElement.attr('href');
            window.location = url;
            // alertify.success('Ok')
        }, function() {
            // alertify.error('Cancel')
        });
    });
})
