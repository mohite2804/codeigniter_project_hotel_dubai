$(document).ready(function() {



    $('.suc_msg_hide').delay(5000).fadeOut('slow');

    $('#ad_minus').click(function() {
        console.log('minusCount');
        var $input = $(this).parent().find('input');
        var $adultcount = $('#adlt_count');



        var count = parseInt($input.val()) - 1;
        count = count < 1 ? 1 : count;
        $input.val(count);
        $input.change();
        $adultcount.text(count);
        $adultcount.change();

        return false;
    });

    $('#ad_minus_2').click(function() {
        console.log('minusCount2');
        var $input = $(this).parent().find('input');
        var $adultcount = $('#ad_minus_2');



        var count = parseInt($input.val()) - 1;
        count = count < 1 ? 1 : count;
        $input.val(count);
        $input.change();
        $adultcount.text(count);
        $adultcount.change();

        return false;
    });

    $('#ad_plus').click(function() {
        console.log('addcount');
        var $input = $(this).parent().find('input');
        var $adultcount = $('#adlt_count');

        $input.val(parseInt($input.val()) + 1);
        $input.change();
        $adultcount.text(parseInt($input.val()));
        $adultcount.change();


        return false;
    });


    $('#ad_plus_2').click(function() {
        console.log('addcount');
        var $input = $(this).parent().find('input');
        var $adultcount = $('#adlt_count_2');

        $input.val(parseInt($input.val()) + 1);
        $input.change();
        $adultcount.text(parseInt($input.val()));
        $adultcount.change();


        return false;
    });


    $('#ch_minus').click(function() {
        console.log('minusCount');
        var $input = $(this).parent().find('input');

        var $chldcount = $('#chld_count');


        var count = parseInt($input.val()) - 1;
        count = count < 1 ? 1 : count;
        $input.val(count);
        $input.change();

        $chldcount.text(count);
        $chldcount.change();
        return false;
    });

    $('#ch_minus_2').click(function() {
        console.log('minusCount');
        var $input = $(this).parent().find('input');

        var $chldcount = $('#chld_count_2');


        var count = parseInt($input.val()) - 1;
        count = count < 1 ? 1 : count;
        $input.val(count);
        $input.change();

        $chldcount.text(count);
        $chldcount.change();
        return false;
    });

    $('#ch_plus').click(function() {
        console.log('addcount');
        var $input = $(this).parent().find('input');

        var $chldcount = $('#chld_count');
        $input.val(parseInt($input.val()) + 1);
        $input.change();


        $chldcount.text(parseInt($input.val()));
        $chldcount.change();
        return false;
    });

    $('#ch_plus_2').click(function() {
        console.log('addcount');
        var $input = $(this).parent().find('input');

        var $chldcount = $('#chld_count_2');
        $input.val(parseInt($input.val()) + 1);
        $input.change();


        $chldcount.text(parseInt($input.val()));
        $chldcount.change();
        return false;
    });



    $('.myGroup').click(function() {
        $('.myGroup').find('.collapse.show').collapse('hide');
    });

    $('.carousel').carousel({
        pause: "false"
    });

    var counterLength = $('.bxslider .bx_content').length;

    if (counterLength == 2) {

        console.log('hrerererer');
        $('.bx_content').addClass('active-slide');
    }
    if (counterLength == 3) {

        $('.bx_content').addClass('active-slide');

    }

    /*  var vid = document.getElementById("myVideo");
       vid.autoplay = true;
    vid.load();*/
    var loginHeight = $('.loginBox').height() + 140;
    $('.bg_cls').css('height', loginHeight);

    $('[data-toggle="popover"]').popover({
        placement: 'top',
        trigger: 'hover'
    });

    $('#rate_one').click(function() {

    });
    $('.Rateinput').click(function() {
        $('.Rateinput:not(:checked)').parent().parent().removeClass("price_content_active");
        $('.Rateinput:checked').parent().parent().addClass("price_content_active");
    });

});


$('.back_top').fadeOut();

function googleTranslateElementInit() {
    new google.translate.TranslateElement({ pageLanguage: "en,ar" }, 'google_translate_element');
}
$('.areb_lang').css('color', '#ccc')

setTimeout(function() {
    $('.goog-te-banner-frame').hide();
    $('.goog-te-banner-frame').css('height', '0px');
    $('body').css('top', '0px');
}, 1000);


function changeLanguageByButtonClick() {
    $('.eng_lang').css('color', '#888888');
    $('.areb_lang').css('color', '#373736');
    $('.side_menu').addClass('side_ar');
    var language = document.getElementById("language").value;
    var selectField = document.querySelector("#google_translate_element select");
    for (var i = 0; i < selectField.children.length; i++) {
        var option = selectField.children[i];
        // find desired langauge and change the former language of the hidden selection-field 
        if (option.value == language) {
            selectField.selectedIndex = i;
            // trigger change event afterwards to make google-lib translate this side
            selectField.dispatchEvent(new Event('change'));
            break;
        }
    }
    $('.goog-te-banner-frame').hide();
    $('.goog-te-banner-frame').css('height', '0px');
    $('body').css('top', '0px');
    $('body').removeClass('ltr');
    $('body').addClass('rtl');
    $('h1').css('text-align', 'right');
    $('body').css('direction', 'rtl');
    $('.lang_bar').removeClass('text-left');
    $('.lang_bar').addClass('text-right');
    $('.login_bar ').removeClass('text-right');
    $('.login_bar ').addClass('text-left');
    $('.Menu_icon').css({ 'border-left': '1px solid #C7C5C5', 'padding-left': '20px', 'border-right': '0px' });
    $('.info_list span').hide();
}


function changeLanguageByButtonClick_en() {
    $('.areb_lang').css('color', '#888888');
    $('.eng_lang').css('color', '#373736');
    $('.side_menu').removeClass('side_ar');
    var language = document.getElementById("language_en").value;
    var selectField = document.querySelector("#google_translate_element select");
    for (var i = 0; i < selectField.children.length; i++) {
        var option = selectField.children[i];
        // find desired langauge and change the former language of the hidden selection-field 
        if (option.value == language) {
            selectField.selectedIndex = i;
            // trigger change event afterwards to make google-lib translate this side
            selectField.dispatchEvent(new Event('change'));
            break;
        }
    }
    $('.goog-te-banner-frame').hide();
    $('.goog-te-banner-frame').css('height', '0px');
    $('body').css('top', '0px');
    $('body').removeClass('rtl');
    $('body').addClass('ltr');
    $('h1').css('text-align', 'center');
    /*$('p').css('text-align','left');*/
    $('body').css('direction', 'ltr');
    $('.info_list span').show();
    $('.lang_bar').addClass('text-left');
    $('.lang_bar').removeClass('text-right');
    $('.login_bar ').removeClass('text-left');
    $('.login_bar ').addClass('text-right');
    $('.Menu_icon').css({ 'border-right': '1px solid #C7C5C5', 'padding-right': '20px', 'border-left': '0px' });
}

setTimeout(function() {
    $('.goog-te-banner-frame').hide();
    $('.goog-te-banner-frame').css('height', '0px');
    $('body').css('top', '0px');
}, 1000);

var windowWidth = $(window).width();
if (windowWidth > 992) {
    /*select for desktop*/
    $('.js-example-basic-single').select2();
    $('.js-example-basic-single_2').select2();
    $('.roomtype_select').select2();
    console.log('currentSlideHtmlObject');
    $('.bxslider').bxSlider({

        onSlideAfter: function(currentSlideNumber, totalSlideQty, currentSlideHtmlObject) {
            console.log(currentSlideHtmlObject);

            $('.bx_content').removeClass('active-slide');
            $('.bxslider .bx_content ').eq(currentSlideHtmlObject + 1).addClass('active-slide')
        },
        onSliderLoad: function() {

            $('.bxslider .bx_content ').eq(1).addClass('active-slide')
        },

        auto: true,
        autoControls: false,
        speed: 500,
        pager: true,
        minSlides: 3,
        maxSlides: 4,
        moveSlides: 1,
        infiniteLoop: false,
        slideWidth: 460,
        slideMargin: 25,
        adaptiveHeight: true,
        touchEnabled: false,


    });
    $('.gallery_content').bxSlider({
        onSlideAfter: function(currentSlideNumber, totalSlideQty, currentSlideHtmlObject) {
            console.log(currentSlideHtmlObject);

            $('.glass_slider').removeClass('active-slide');
            $('.gallery_content .glass_slider ').eq(currentSlideHtmlObject + 3).addClass('active-slide')
        },
        onSliderLoad: function() {

            $('.gallery_content .glass_slider ').eq(3).addClass('active-slide')
        },
        auto: true,
        autoControls: false,
        speed: 500,
        pager: true,
        minSlides: 2,
        maxSlides: 3,
        moveSlides: 1,
        slideWidth: 880,
        slideMargin: 140,
        touchEnabled: false,

    });
} else {
    $('.bxslider').bxSlider({
        auto: true,
        autoControls: false,
        speed: 500,
        pager: false,
        minSlides: 1,
        maxSlides: 1,
        moveSlides: 1,

        slideMargin: 30,
        adaptiveHeight: true,
        adaptiveHeightSpeed: 600,

    });
    $('.gallery_content').bxSlider({

        auto: true,
        autoControls: false,
        speed: 500,
        pager: false,
        minSlides: 1,
        maxSlides: 1,
        moveSlides: 1,
        touchEnabled: false

    });
}


var newheight = $('.bx_content').height() + 50;
console.log(newheight);
$('.top_slide .bx-viewport').css('height', newheight);




$('#toggler_menu').click(function() {
    $('.icon-box-toggle').toggleClass('active');
    $('.side_menu').toggleClass('active');
    $('.close_ic').show();
    // $('#toggler_menu').hide();

});

$('.gal_img').click(function() {
    console.log('sssss');
    $('#ImageModal').modal('show');
});
$('.gal_img img').click(function() {
    var galImg = $(this).attr('src');
    console.log(galImg);
    var modalImage = '';
    console.log(modalImage);
    $("#ImageModal img").each(function(index, div) {
        modalImage = $('#ImageModal img').attr('src');
        console.log($(this).attr('src'));
        console.log(div);
        if (galImg == $(this).attr('src')) {
            $('#ImageModal .carousel-item').removeClass('active');
            $(this).parent().addClass('active');
        }

    });

});

$('.Gal_box').click(function() {
    console.log('sssss');
    $('#ImageModal').modal('show');
});
$('.Gal_box img').click(function() {
    var galImg_2 = $(this).attr('src');
    console.log(galImg_2);
    var modalImage_2 = '';
    console.log(modalImage_2);
    $("#ImageModal img").each(function(index, div) {
        modalImage_2 = $('#ImageModal img').attr('src');
        console.log($(this).attr('src'));
        console.log(div);
        if (galImg_2 == $(this).attr('src')) {
            $('#ImageModal .carousel-item').removeClass('active');
            $(this).parent().addClass('active');
        }

    });

});

$("#datepicker").datepicker({
    isRTL: 'true',
    format: "mm-yyyy",
    startView: "months",
    minViewMode: "months"
});



var today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());
$('#startDate').datepicker({

    uiLibrary: 'bootstrap4',
    iconsLibrary: 'fontawesome',
    minDate: today,
    maxDate: function() {
        return $('#endDate').val();
    }
});
$('#endDate').datepicker({
    isRTL: 'true',
    uiLibrary: 'bootstrap4',
    iconsLibrary: 'fontawesome',
    minDate: function() {
        return $('#startDate').val();
    }
});


$("a[href='#top']").click(function() {
    $("html, body").animate({ scrollTop: 0 }, "slow");
    return false;
});
$(window).scroll(function() {

    if ($(this).scrollTop() > 100) {
        $('.back_top').fadeIn();

    } else {
        $('.back_top').fadeOut();
    }
});

//var sidemenuPos = $('.fixed-top').height();
//$('.side_menu ').css('top' , sidemenuPos)


var yourNavigation = $(".fixed-top");
stickyDiv = "shrink_navbar";
yourHeader = $('.Navbar_holder').height();


$(window).scroll(function() {
    if ($(this).scrollTop() > yourHeader) {
        yourNavigation.addClass(stickyDiv);

    } else {
        yourNavigation.removeClass(stickyDiv);


    }
});


$('.feedbackBtn').click(function() {
    $('#feedback_modal').modal('show');
});

document.querySelectorAll('.feedback li').forEach(entry => entry.addEventListener('click', e => {
    if (!entry.classList.contains('active')) {
        document.querySelector('.feedback li.active').classList.remove('active');
        entry.classList.add('active');
    }
    e.preventDefault();
}));


$('.services_list ul li div').click(function() {
    $(this).toggleClass('active_alpha');
    //$(this).siblings().child().removeClass('active_alpha');

});


$('.filters ul li').click(function() {
    $('.filters ul li').removeClass('active');
    $(this).addClass('active');

    var data = $(this).attr('data-filter');
    $grid.isotope({
        filter: data
    })
});


var $grid = $(".grid").isotope({
    itemSelector: ".all",
    percentPosition: true,
    masonry: {
        columnWidth: ".all"
    }
});