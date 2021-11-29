
var counter = 0;

$(window).on('load', function(){
    showEmailVerificationResult();
});

function showEmailVerificationResult(){
    let _token   = $('meta[name="csrf-token"]').attr('content');
    var lang = $('html').attr('lang');
    var verifedResultHtml = '';

    $.ajax({
        url: "/ajax/showEmailVerificationResult",
        type:"POST",
        async: false,
        data:{
            lang: lang,
            _token: _token
        },
        cache: false,
        dataType:"json"
    }).done(function (response) {
        $result = response.result;
        verifedResultHtml = '';

        if($result === 1){
            var result = '';

            if(lang === 'en')
                result = 'Verified';
            else
                result = 'Tanımlanmış';

            verifedResultHtml = ' <i class="far fa-check"></i>'+result+' \n';
            $('#emailVerificationResult').addClass('success');
        }
        else if($result === 0){
            var url = '';

            if(lang === 'en')
                url = '/email/verify';
            else
                url = '/tr/email/dogrulama';

            var result_not = '';

            if(lang === 'en')
                result_not = 'Not Verified';
            else
                result_not = 'Tanımlanmamış';

            verifedResultHtml = ' <a href="'+url+'"><i class="far fa-times"></i>'+result_not+'</a> \n';
            $('#emailVerificationResult').addClass('failed');
        }

        $('#emailVerificationResult').html(verifedResultHtml);

    }).fail(function (response) {

        counter ++;

        if(counter <= 3){
            showEmailVerificationResult();
        }
        else{
            $('#emailVerificationResult').html(verifedResultHtml);

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
