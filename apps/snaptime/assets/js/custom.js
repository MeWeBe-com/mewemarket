$(document).ready(function () {
    $(document).on('click', '.passport-switch', function () {
        $(this).toggleClass('bootstrap-switch-off bootstrap-switch-on');
        jQuery.validator.unobtrusive.parse(form);
        $(".psp-group-inner").animate({
            width: "toggle"
        }); $('#2FileError').hide();
        $('#1FileError').hide();
    });
});

$(document).ready(function () {
    $(document).on('click', '.lcnc-switch', function () {
        $(this).toggleClass('bootstrap-switch-off bootstrap-switch-on');
        jQuery.validator.unobtrusive.parse(form);
        $(".lcnc-group-inner").animate({
            width: "toggle"
        }); $('#2FileError').hide();
        $('#1FileError').hide();
    });   
});

$(document).ready(function () {
    $(document).on('click', '.aid-switch', function () {
        $(this).toggleClass('bootstrap-switch-off bootstrap-switch-on');
        if ($(this).hasClass("bootstrap-switch-off")) {
            if ($('#ScdFirstAidTranning').length) {
                $('#ScdFirstAidTranning').val(false);
            }
        }
        if ($(this).hasClass("bootstrap-switch-on")) {
            if ($('#ScdFirstAidTranning').length) {
                $('#ScdFirstAidTranning').val(true);
            }

        }
        $(".aid-group-inner").animate({
            width: "toggle"
        });
    });
    $(document).on('click', '.vat-switch', function () {
        $(this).toggleClass('bootstrap-switch-off bootstrap-switch-on');
        if ($(this).hasClass("bootstrap-switch-off")) {
            if ($('#VatNo').length) {
                $('#VatNo').val(false);
            }
        }
        if ($(this).hasClass("bootstrap-switch-on")) {
            if ($('#VatNo').length) {
                $('#VatNo').val(true);
            }

        }
        $(".aid-group-inner").animate({
            width: "toggle"
        });
    });
});

$(document).ready(function () {
    $(document).on('click', '.btn-next', function (e) {
        e.preventDefault();
        $('#qual a[href="#qual"]').tab('show');
    });
});

function changetab(element) {
    $(element)[0].click();
    window.scrollTo(0, -100);
}

$(document).ready(function () {
    $('.btn-next').click(function () {
        $('html, body').animate({
            scrollTop: $('.nav-tabs-navigation').offset().top
        }, 1000);
    });
});

// $(document).ready(function() {
//     $('[data-toggle="tooltip"]').tooltip();
// });

$(document).ready(function () {
    $('#freelanceselector').on('change', function () {
        if (this.value == '1') {
            $(".freelancer-form").show();
            $(".supplier-form").hide();

            $('#sec-tab').removeClass('not-active');
        } else {
            $(".freelancer-form").hide();
            $(".supplier-form").show();

            $('#sec-tab').addClass('not-active');
        }
    });
});

$(document).ready(function () {
    $('#userselector').on('change', function () {
        if (this.value == '1') {
            $(".supplier-form").show();
            $(".contractor-form").hide();
        } else {
            $(".supplier-form").hide();
            $(".contractor-form").show();
        }
    });
});

$(document).on('click', '#addPrimaryContact', function () {
    $('#newPContact').slideDown();
});

$(document).on('click', '#addPrimaryContact2', function () {
    $('#newPContact2').slideDown();
});

$(document).ready(function () {
    $('.no-link').removeClass('active');

});
