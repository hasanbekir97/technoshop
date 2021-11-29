


$(window).scroll(function(){
    if ($(this).scrollTop() > 1) {
        $('.dropdown').removeClass('show');
        $('.dropdown-menu').removeClass('show');
        $('.dropdown-toggle').attr('aria-expanded', false);
    }
});

//this is for top space in background of header
$(document).ready(function() {
    var height = $('header').height();
    $('.topSpace').css('height', height+'px');
});
$(window).resize(function () {
    var height = $('header').height();
    $('.topSpace').css('height', height+'px');
});


//this is for number of product (increase or decrease)
$('.productQuantity').on('keyup keypress', function(e) {
    var itemNumber = $('.productQuantity').val();
    if(parseInt(itemNumber) < 1){
        $('.productQuantity').val(1);
        $('.decreaseButton').addClass('active');
    }

    if(itemNumber === ''){
        $('#productCount').val("1");
        $('.decreaseButton').addClass('active');
    }

    /*else if(parseInt(itemNumber) >= 999){
        $('.productQuantity').val(999);
    }*/
});

//this is for number of product in product page (increase or decrease)
$('#productCount').change(function() {
    $productPageProductNumber = $(this).val();

    if($productPageProductNumber === ''){
        $('#productCount').val("1");
        $('.decreaseButton').addClass('active');
    }

    if (parseInt($productPageProductNumber) === 1) {
        $('.decreaseButton').addClass('active');
    } else {
        $('.decreaseButton').removeClass('active');
    }
});

// this control when click decrease and increase buttons
$('.counterControl').click(function(){
    $productPageProductNumber = $('#productCount').val();

    if (parseInt($productPageProductNumber) === 1) {
        $('.decreaseButton').addClass('active');
    } else {
        $('.decreaseButton').removeClass('active');
    }
});

//
$(document).ready(function() {
    $productPageProductNumber = $('#productCount').val();

    if (parseInt($productPageProductNumber) === 1) {
        $('.decreaseButton').addClass('active');
    } else {
        $('.decreaseButton').removeClass('active');
    }
});

//to equalize of height product image and content product detail
$(document).ready(function(){
    var heightLeft = $('.productBody').height();
    $('.rightArea').css('height', heightLeft + 'px');
});
$(window).resize(function(){
    var heightLeft = $('.productBody').height();
    $('.rightArea').css('height', heightLeft + 'px');
});

// to don't send again the form
if ( window.history.replaceState ) {
    window.history.replaceState( null, null, window.location.href );
}

$(document).ready(function(){
    $scrollTop = $(window).scrollTop();
    if($scrollTop >= 500){
        $('.scrollTop').fadeIn(300);
    }
    else{
        $('.scrollTop').fadeOut(300);
    }
});
$(window).scroll(function(){
    $scrollTop = $(window).scrollTop();
    if($scrollTop >= 500){
        $('.scrollTop').fadeIn(300);
    }
    else{
        $('.scrollTop').fadeOut(300);
    }
});


//password is shown or not
$(document).ready(function (){
    $('#showPassword').click(function (){
        if($('#showPassword i').hasClass('fa-eye-slash')){
            $('#password').prop('type', 'text');
            $('#showPassword i').removeClass('fa-eye-slash');
            $('#showPassword i').addClass('fa-eye');
        }
        else if($('#showPassword i').hasClass('fa-eye')){
            $('#password').prop('type', 'password');
            $('#showPassword i').removeClass('fa-eye');
            $('#showPassword i').addClass('fa-eye-slash');
        }
    });
    $('#showPasswordConfirm').click(function (){
        if($('#showPasswordConfirm i').hasClass('fa-eye-slash')){
            $('#password_confirmation').prop('type', 'text');
            $('#showPasswordConfirm i').removeClass('fa-eye-slash');
            $('#showPasswordConfirm i').addClass('fa-eye');
        }
        else if($('#showPassword i').hasClass('fa-eye')){
            $('#password_confirmation').prop('type', 'password');
            $('#showPasswordConfirm i').removeClass('fa-eye');
            $('#showPasswordConfirm i').addClass('fa-eye-slash');
        }
    });
});

function productDetailUploadAjaxLoader() {

    //ajax loader for product detail slider
    let spinAjaxLoaderHtml = spinAjaxLoader();
    $('.productBody .leftArea .row').css('position', 'relative');
    $('.productBody .leftArea .row .column.small-11.small-centered').css('visibility', 'hidden');
    $($.parseHTML(spinAjaxLoaderHtml)).insertAfter('.productBody .leftArea .row .column.small-11.small-centered');
    $('.loadingHeadArea').css('position', 'absolute');

    $(window).on("load", function () {
        $('.loadingHeadArea').remove();
        $('.productBody .leftArea .row').css('position', 'relative');
        $('.productBody .leftArea .row .column.small-11.small-centered').css('visibility', 'visible');
    });


    //load the right section of product details after page loaded
    $('.productBody .rightArea').css('display', 'none');

    $(window).on("load", function () {
        $('.productBody .rightArea').css('display', 'block');
    });
}




