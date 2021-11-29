
var counter = 0;

$(window).on('load', function(){
    showApiKey();
});

function generateApiKey(){
    let _token   = $('meta[name="csrf-token"]').attr('content');
    let lang = $('html').attr('lang');
    var apiKeyHtml = $('#apiKeyArea').html();

    $ajaxLoaderAllScreen = ajaxLoaderAllScreen();
    $($.parseHTML($ajaxLoaderAllScreen)).insertBefore($('header'));

    $('.ajaxLoaderAllScreen').fadeIn(300);

    $.ajax({
        url: "/ajax/generateApiKey",
        type: "POST",
        data:{
            lang: lang,
            _token: _token
        },
        dataType: "json"
    }).done(function (response) {
        var api_key = response.api_key;
        apiKeyHtml = '';

        apiKeyHtml = ' <h1>API Key (Auth)</h1>\n' +
            '          <hr>\n' +
            '          <textarea>'+api_key+'</textarea> \n';

        $('#apiKeyArea').html(apiKeyHtml);

        $('.ajaxLoaderAllScreen').fadeOut(300);

        setTimeout(function() {
            $('.ajaxLoaderAllScreen').remove();
        }, 300);

        if(lang === 'en')
            toastr.success('Your api key has been successfully generated.');
        else
            toastr.success('Api anahtarınız başarılı olarak oluşturuldu.');
    }).fail(function (response) {

        counter ++;

        if(counter <= 3){
            $('#apiKeyArea').html(apiKeyHtml);
            generateApiKey();
        }
        else{
            $('#apiKeyArea').html(apiKeyHtml);

            $('.ajaxLoaderAllScreen').fadeOut(300);

            setTimeout(function() {
                $('.ajaxLoaderAllScreen').remove();
            }, 300);

            if(lang === 'en') {
                Swal.fire({
                    icon: 'error',
                    title: 'Something went wrong!',
                    text: 'You must refresh the page!'
                })

                toastr.error('Something went wrong.');
            }
            else {
                Swal.fire({
                    icon: 'error',
                    title: 'Bir hata oluştu!',
                    text: 'Sayfayı yenilemeniz gerekli!'
                })

                toastr.error('Bir hata oluştu.');
            }
        }
    });
}

function showApiKey(){
    let _token   = $('meta[name="csrf-token"]').attr('content');
    let lang = $('html').attr('lang');
    var apiKeyHtml = $('#apiKeyArea').html();

    var ajaxLoaderHtml = spinAjaxLoader();
    $('#apiKeyArea').html(ajaxLoaderHtml);

    $.ajax({
        url: "/ajax/showApiKey",
        type: "POST",
        data:{
            lang: lang,
            _token: _token
        },
        dataType: "json"
    }).done(function (response) {
        var api_key = response.api_key;

        if(api_key !== null && api_key !== 'null' && api_key !== '') {
            apiKeyHtml = '';

            apiKeyHtml = ' <h1>API Key (Auth)</h1>\n' +
                '          <hr>\n' +
                '          <textarea>' + api_key + '</textarea> \n';
        }

        setTimeout(function() {
            $('#apiKeyArea').html(apiKeyHtml);
        }, 300);
    }).fail(function (response) {

        counter ++;

        if(counter <= 3){
            $('#apiKeyArea').html(apiKeyHtml);
            generateApiKey();
        }
        else{
            $('#apiKeyArea').html(apiKeyHtml);

            setTimeout(function() {
                $('#apiKeyArea').html(apiKeyHtml);
            }, 300);

            if(lang === 'en') {
                Swal.fire({
                    icon: 'error',
                    title: 'Something went wrong!',
                    text: 'You must refresh the page!'
                })

                toastr.error('Something went wrong.');
            }
            else {
                Swal.fire({
                    icon: 'error',
                    title: 'Bir hata oluştu!',
                    text: 'Sayfayı yenilemeniz gerekli!'
                })

                toastr.error('Bir hata oluştu.');
            }
        }
    });
}
