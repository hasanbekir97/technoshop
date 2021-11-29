


$('#addressForm').on('submit', function (e){
    e.preventDefault();

    $('#countryErrorMsg').text('');
    $('#cityErrorMsg').text('');
    $('#countyErrorMsg').text('');
    $('#addressErrorMsg').text('');

    $('.alertMessageArea').hide();

    $('#country').attr('readonly', true);
    $('#city').attr('readonly', true);
    $('#county').attr('readonly', true);
    $('#address').attr('readonly', true);

    let _token = $('meta[name="csrf-token"]').attr('content');
    let lang = $('html').attr('lang');

    let country = $('#country').val();
    let city = $('#city').val();
    let county = $('#county').val();
    let address = $('#address').val();


    $.ajax({
        url: "/ajax/addressFormSubmit",
        type: "POST",
        data: {
            lang: lang,
            country: country,
            city: city,
            county: county,
            address: address,
            _token: _token
        },
        dataType: "json"
    }).done(function (response) {

        $('#country').attr('readonly', false);
        $('#city').attr('readonly', false);
        $('#county').attr('readonly', false);
        $('#address').attr('readonly', false);

        $('.alertMessageArea').show();

        setTimeout(function() {
            $('.alertMessageArea').fadeOut();
        }, 2000);

    }).fail(function (response) {

        $('#country').attr('readonly', false);
        $('#city').attr('readonly', false);
        $('#county').attr('readonly', false);
        $('#address').attr('readonly', false);

        $('#countryErrorMsg').text(response.responseJSON.errors.country);
        $('#cityErrorMsg').text(response.responseJSON.errors.city);
        $('#countyErrorMsg').text(response.responseJSON.errors.county);
        $('#addressErrorMsg').text(response.responseJSON.errors.address);

    });

    e.stopImmediatePropagation();
});

