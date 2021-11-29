var counter = 0;

calculateStarAVg();

function calculateStarAVg (){
    let _token   = $('meta[name="csrf-token"]').attr('content');
    let lang   = $('html').attr('lang');
    var productId = $('#productId').val();
    var starAvgHtml = $('.starAvgShow').html();

    $.ajax({
        url: "/ajax/calculateStarAvg",
        type:"POST",
        data:{
            productId: productId,
            _token: _token
        },
        dataType:"json"
    }).done(function (response) {
        $starAvg = response.starAvg;
        starAvgHtml = '';

        if(($starAvg % 1) === 0){
            for($i=0; $i<$starAvg; $i ++) {
                starAvgHtml += ' <li class="starArea"> \n' +
                    '                <div class="starEmpty">\n' +
                    '                    <i class="fas fa-star"></i>\n' +
                    '                </div>\n' +
                    '                <div class="starFull">\n' +
                    '                    <i class="fas fa-star"></i>\n' +
                    '                </div>\n' +
                    '            </li> ';
            }

            for($i=Math.ceil($starAvg); $i<5; $i ++) {
                starAvgHtml += ' <li class="starArea"> \n' +
                    '                <div class="starEmpty">\n' +
                    '                    <i class="fas fa-star"></i>\n' +
                    '                </div>\n' +
                    '                <div class="starFull" style="display:none">\n' +
                    '                    <i class="fas fa-star"></i>\n' +
                    '                </div>\n' +
                    '            </li> ';
            }
        }
        else{
            for($i=0; $i<($starAvg-1); $i ++) {
                starAvgHtml += ' <li class="starArea"> \n' +
                    '                <div class="starEmpty">\n' +
                    '                    <i class="fas fa-star"></i>\n' +
                    '                </div>\n' +
                    '                <div class="starFull">\n' +
                    '                    <i class="fas fa-star"></i>\n' +
                    '                </div>\n' +
                    '            </li> ';
            }
            if($starAvg < 5 && $starAvg > 0){
                $decimalNumber = $starAvg - Math.floor($starAvg);
                $percent = Math.round($decimalNumber * 100);

                starAvgHtml += ' <li class="starArea"> \n' +
                    '                <div class="starEmpty">\n' +
                    '                    <i class="fas fa-star"></i>\n' +
                    '                </div>\n' +
                    '                <div class="starFull" style="width:'+$percent+'%">\n' +
                    '                    <i class="fas fa-star"></i>\n' +
                    '                </div>\n' +
                    '            </li> ';
            }
            for($i=Math.ceil($starAvg); $i<5; $i ++) {
                starAvgHtml += ' <li class="starArea"> \n' +
                    '                <div class="starEmpty">\n' +
                    '                    <i class="fas fa-star"></i>\n' +
                    '                </div>\n' +
                    '                <div class="starFull" style="display:none">\n' +
                    '                    <i class="fas fa-star"></i>\n' +
                    '                </div>\n' +
                    '            </li> ';
            }
        }


        $('.starAvgShow').html(starAvgHtml);

    }).fail(function (response) {

        counter ++;

        if(counter <= 3){
            $('.starAvgShow').html(starAvgHtml);
            calculateStarAVg();
        }
        else{
            $('.starAvgShow').html(starAvgHtml);

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


