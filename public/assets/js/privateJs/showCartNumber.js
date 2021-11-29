
showCartNumber();

var counter = 0;

function showCartNumber(){
    let _token   = $('meta[name="csrf-token"]').attr('content');
    var lang = $('html').attr('lang');


    $.ajax({
        url: "/ajax/showCartNumber",
        type:"POST",
        async: false,
        data:{
            lang: lang,
            _token: _token
        },
        cache: false,
        dataType:"json"
    }).done(function (response) {
        $cartNumber = response.cartNumber;
        $('#basketNumberID').html($cartNumber);

        $basketNumber = parseInt($cartNumber);
        if($basketNumber > 0){
            $('.headerBasketArea').addClass('active');
        }
        else{
            $('.headerBasketArea').removeClass('active');
        }
    }).fail(function (response) {

        counter ++;

        if(counter <= 3){
            showCartNumber();
        }
        else{
            $('#basketNumberID').html(0);

            $('.headerBasketArea').removeClass('active');

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
