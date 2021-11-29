

$('#addFavButton').click(function(){
    $productId = $(this).attr("data-id");
    addRemoveFavorite($productId);
});

function addRemoveFavorite(productId){
    let _token   = $('meta[name="csrf-token"]').attr('content');
    var lang = $('html').attr('lang');

    $.ajax({
        url: "/ajax/addRemoveFavorite",
        type:"POST",
        data:{
            productId: productId,
            lang: lang,
            _token: _token
        },
        dataType:"json"
    }).done(function (response) {
        $favStatus = response.favStatus;
        $authStatus = response.authStatus;

        if($authStatus === 'logged out'){
            if(lang === 'en')
                window.location.href = '/login';
            else
                window.location.href = '/tr/giris';
        }
        else if($authStatus === 'logged in' && $favStatus === 'added'){
            $('#addFavButton .fa-heart').removeClass('far');
            $('#addFavButton .fa-heart').addClass('fas');

            if(lang === 'en')
                toastr.success('The product has been successfully added to favorite list.');
            else
                toastr.success('Ürün başarılı olarak favori listesine eklendi.');
        }
        else if($authStatus === 'logged in' && $favStatus === 'removed'){
            $('#addFavButton .fa-heart').removeClass('fas');
            $('#addFavButton .fa-heart').addClass('far');

            if(lang === 'en')
                toastr.success('The product has been successfully removed from favorite list.');
            else
                toastr.success('Ürün başarılı olarak favori listesinden çıkarıldı.');
        }

    }).fail(function (response) {

        if(lang === 'en')
            toastr.error('Something went wrong.');
        else
            toastr.success('Bir hata oluştu.');
    });
}
