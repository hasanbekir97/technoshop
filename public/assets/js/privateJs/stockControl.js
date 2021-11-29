var counter = 0;

stockControl();

function stockControl (){
    let _token   = $('meta[name="csrf-token"]').attr('content');
    let lang   = $('html').attr('lang');
    var productId = $('#productId').val();

    $.ajax({
        url: "/ajax/stockControl",
        type:"POST",
        data:{
            productId: productId,
            _token: _token
        },
        dataType:"json"
    }).done(function (response) {
        $stockStatus = response.stockStatus;
        var stockStatusHtml = '';

        var stockExist = '';
        var stockNotExist = '';

        if(lang === 'en') {
            stockExist = 'In Stock';
            stockNotExist = 'Out of Stock';
        }
        else {
            stockExist = 'Stokta Var';
            stockNotExist = 'Stokta Yok';
        }

        if($stockStatus === 1){
            stockStatusHtml = ' <div class="succesfullArea">\n' +
                '                   <i class="fas fa-check-circle"></i>'+stockExist+'\n' +
                '               </div> \n';
        }
        else{
            stockStatusHtml = ' <div class="failedArea">\n' +
                '                   <i class="fas fa-times-circle"></i>'+stockNotExist+'\n' +
                '               </div> \n';

            $('#addCartButton').prop('disabled', true);
            $('#addFavButton').prop('disabled', true);
        }

        $('#stockStatusId').html(stockStatusHtml);


    }).fail(function (response) {

        counter ++;

        if(counter <= 3){
            stockControl();
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


