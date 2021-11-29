
$('#addCartButton').click(function(){
    $itemNumber = $('#productCount').val();
    addCart($itemNumber);
});


function addCart(productNum){
    let _token   = $('meta[name="csrf-token"]').attr('content');
    var lang = $('html').attr('lang');

    var productId = $('#productId').val();

    $.ajax({
        url: "/ajax/addCart",
        type:"POST",
        data:{
            productId: productId,
            productNumber: productNum,
            lang: lang,
            _token: _token
        },
        dataType:"json"
    }).done(function (response) {
        console.log(response);
        showCartNumber();
        if(lang === 'en')
            toastr.success('The product has been successfully added to cart.');
        else
            toastr.success('Ürün başarılı olarak sepete eklendi.');
    }).fail(function (response) {
        console.log(response);
        showCartNumber();
        if(lang === 'en')
            toastr.error('Something went wrong.');
        else
            toastr.error('Bir hata oluştu.');
    });
}


