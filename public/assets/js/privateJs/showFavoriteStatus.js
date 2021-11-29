
var counter = 0;

$(document).ready(function (){
    $productId = $('#productId').val();
    showFavoriteStatus($productId);
});

function showFavoriteStatus(productId){
    let _token   = $('meta[name="csrf-token"]').attr('content');
    var lang = $('html').attr('lang');


    $.ajax({
        url: "/ajax/showFavoriteStatus",
        type:"POST",
        data:{
            productId: productId,
            lang: lang,
            _token: _token
        },
        dataType:"json"
    }).done(function (response) {
        $favStatus = response.favStatus;

        if($favStatus === 'added'){
            $('.addFavoriteButton .fa-heart').removeClass('far');
            $('.addFavoriteButton .fa-heart').addClass('fas');
        }
        else if($favStatus === 'removed'){
            $('.addFavoriteButton .fa-heart').removeClass('fas');
            $('.addFavoriteButton .fa-heart').addClass('far');
        }

    }).fail(function (response) {

        counter ++;

        if(counter <= 3){
            showFavoriteStatus(productId);
        }
        else{
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
