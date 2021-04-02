function addDyn(t) {
    var a = $("#" + t).attr("data-counter");
    a = parseInt(a) + 1, $("#" + t).attr("data-counter", a);
    var e = $("#" + t).find(".dynform-item:first").clone().appendTo("#" + t).hide().fadeIn(500);
    $(e).find("input, textarea, select").each(function() {
        var t = $(this).attr("id");
        off = t.split("-"), $(this).attr("id", off[0] + "-" + a);
        if($(this).is('select')){   
            $(this).next('.select2').remove();       
        	$(this).prop("selectedIndex", 0);
        }
        else{
        	$(this).val("");
        }
        $(this).attr('data-toggle', 'tooltip');
        $("[data-toggle='tooltip']").tooltip();
    }), $(e).append('<button type="button" class="dynform-btn" onclick="deleteDyn(this)"><i class="fa fa-times"></i></button>'), $("#" + t).find(".app_datetimepicker").each(function() {
        $(this).datetimepicker({
            format: "d-m-Y H:i:s"
        })
    }), $("#" + t).find(".app_datepicker").each(function() {
        $(this).datetimepicker({
            timepicker: !1,
            format: "d-m-Y"
        })
    }), $("#" + t).find(".app_select").each(function() {
        $(this).select2()
    })
}

function deleteDyn(t) {
    $(t).parent().remove()
}

function dyn_validate(t) {
    return dyn_status = !0, $("#" + t).find("input, textarea, select").each(function() {
        var t = $(this).attr("data-dyn-valid");
        validation = t.split("|");
        for (var a = 0; a < validation.length; a++) "required" == validation[a] && dyn_req_validation(this), "number" == validation[a] && dyn_number_validation(this), "email" == validation[a] && dyn_email_validation(this)
    }), dyn_status
}

function dyn_req_validation(t) {
    var a = $(t).val(),
        e = $(t).attr("id"),
        i = $(t).attr("data-original-title");
    $('label[for="' + e + '-required"]').remove(), "" == a && ($(t).after('<label for="' + e + '-required" class="dyn-error">' + i + " is required</label>").hide().slideDown(300), dyn_status = !1)
}

function dyn_number_validation(t) {
    var a = $(t).val(),
        e = $(t).attr("id"),
        i = $(t).attr("data-original-title");
    $('label[for="' + e + '-number"]').remove(), isNaN(a) && ($(t).after('<label for="' + e + '-number" class="dyn-error">' + i + " must be a number</label>").hide().slideDown(300), dyn_status = !1)
}

function dyn_email_validation(t) {
    var a = $(t).val(),
        e = $(t).attr("id"),
        i = $(t).attr("data-original-title");
    $('label[for="' + e + '-number"]').remove();
    var n = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(a);
    n || ($(t).after('<label for="' + e + '-number" class="dyn-error">' + i + " must be a email</label>").hide().slideDown(300), dyn_status = !1)
}

function getDynFields(t) {
    var a = new Array;
    return $('input[name="' + t + '"], select[name="' + t + '"], textarea[name="' + t + '"]').each(function() {
        a.push($(this).val())
    }), a
}