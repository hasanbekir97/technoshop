


$('#contactForm').on('submit', function (e){
    e.preventDefault();

    $('#nameErrorMsg').text('');
    $('#emailErrorMsg').text('');
    $('#messageErrorMsg').text('');
    $('#agreeErrorMsg').text('');

    $('#successMsg').hide();

    $('#name').attr('readonly', true);
    $('#email').attr('readonly', true);
    $('#phone').attr('readonly', true);
    $('#message').attr('readonly', true);

    let _token = $('meta[name="csrf-token"]').attr('content');
    var lang = $('html').attr('lang');

    let name = $('#name').val();
    let email = $('#email').val();
    let phone = $('#phone').val();
    let message = $('#message').val();

    let agree = $('#agree').prop('checked');

    if(agree === false)
        agree = '';

    $.ajax({
        url: "/ajax/contactFormSubmit",
        type: "POST",
        data: {
            name: name,
            email: email,
            phone: phone,
            message: message,
            agree: agree,
            lang: lang,
            _token: _token
        },
        dataType: "json"
    }).done(function (response) {

        $('#nameErrorMsg').text('');
        $('#emailErrorMsg').text('');
        $('#messageErrorMsg').text('');
        $('#agreeErrorMsg').text('');

        $('#name').attr('readonly', false);
        $('#email').attr('readonly', false);
        $('#phone').attr('readonly', false);
        $('#message').attr('readonly', false);

        $('#name').val('');
        $('#email').val('');
        $('#phone').val('');
        $('#message').val('');
        $('#agree').prop('checked', false);

        $('#successMsg').show();

        if(lang === 'en')
            toastr.success('Your message sent successfully!');
        else
            toastr.success('Mesajınız başarılı olarak gönderilmiştir!');

    }).fail(function (response) {

        $('#name').attr('readonly', false);
        $('#email').attr('readonly', false);
        $('#phone').attr('readonly', false);
        $('#message').attr('readonly', false);

        $('#nameErrorMsg').text(response.responseJSON.errors.name);
        $('#emailErrorMsg').text(response.responseJSON.errors.email);
        $('#messageErrorMsg').text(response.responseJSON.errors.message);
        $('#agreeErrorMsg').text(response.responseJSON.errors.agree);

    });

    e.stopImmediatePropagation();
});

