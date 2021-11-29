


$('#order').on('click', function (e){
    e.preventDefault();

    $('#countryErrorMsg').text('');
    $('#cityErrorMsg').text('');
    $('#countyErrorMsg').text('');
    $('#phoneErrorMsg').text('');
    $('#addressErrorMsg').text('');

    $('.alertMessageArea').hide();

    openAjaxLoader();

    $('#country').attr('readonly', true);
    $('#city').attr('readonly', true);
    $('#county').attr('readonly', true);
    $('#phone').attr('readonly', true);
    $('#address').attr('readonly', true);

    let _token = $('meta[name="csrf-token"]').attr('content');
    var lang = $('html').attr('lang');

    let country = $('#country').val();
    let city = $('#city').val();
    let county = $('#county').val();
    let phone = $('#phone').val();
    let address = $('#address').val();


    $.ajax({
        url: "/ajax/paymentAddressFormSubmit",
        type: "POST",
        data: {
            country: country,
            lang: lang,
            city: city,
            county: county,
            phone: phone,
            address: address,
            _token: _token
        },
        dataType: "json"
    }).done(function (response) {

        $('#country').attr('readonly', false);
        $('#city').attr('readonly', false);
        $('#county').attr('readonly', false);
        $('#phone').attr('readonly', false);
        $('#address').attr('readonly', false);


        if(response.result === 'successful') {
            $('.alertMessageArea').show();

            $('.alertMessageArea').fadeOut();
            $('.ajaxLoaderAllScreen').remove();

            if(lang === 'en')
                window.location.href = '/order-result';
            else
                window.location.href = '/tr/siparis-sonuc';
        }
        else {
            $('.ajaxLoaderAllScreen').remove();

            if(lang === 'en')
                window.location.href = '/';
            else
                window.location.href = '/tr';
        }

    }).fail(function (response) {

        $('#country').attr('readonly', false);
        $('#city').attr('readonly', false);
        $('#county').attr('readonly', false);
        $('#phone').attr('readonly', false);
        $('#address').attr('readonly', false);

        $('#countryErrorMsg').text(response.responseJSON.errors.country);
        $('#cityErrorMsg').text(response.responseJSON.errors.city);
        $('#countyErrorMsg').text(response.responseJSON.errors.county);
        $('#phoneErrorMsg').text(response.responseJSON.errors.phone);
        $('#addressErrorMsg').text(response.responseJSON.errors.address);

        closeAjaxLoader();
    });

    e.stopImmediatePropagation();
});

function openAjaxLoader(){
    $ajaxLoaderAllScreen = ajaxLoaderAllScreen();
    $($.parseHTML($ajaxLoaderAllScreen)).insertBefore($('header'));

    $('.ajaxLoaderAllScreen').fadeIn(300);
}
function closeAjaxLoader(){
    $('.ajaxLoaderAllScreen').fadeOut(300);

    setTimeout(function() {
        $('.ajaxLoaderAllScreen').remove();
    }, 300);
}
