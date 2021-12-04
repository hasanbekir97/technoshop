
var counter = 0;

userOrder();

function userOrder(){
    let _token   = $('meta[name="csrf-token"]').attr('content');
    var lang = $('html').attr('lang');

    var orders = $('#userOrders').html();
    var tempOrders = '';


    $.ajax({
        url: "/ajax/showOrder",
        type:"POST",
        data:{
            lang: lang,
            _token: _token
        },
        dataType:"json"
    }).done(function (response) {

        $ordersData = response.ordersData;
        $orderProductsData = response.orderProductsData;
        orders = '';

        $a = 1;
        $b = 1;

        var productStatus = '';

        for(i in $ordersData) {

            tempOrders = '';

            for(j in $orderProductsData) {
                if($ordersData[i]['order_id'] === $orderProductsData[j]['order_id']) {

                    var url_slug = '';
                    var reviewText = '';
                    var deliveryAddressText = '';
                    var cargoPrice = '';

                    if(lang === 'en') {
                        url_slug = '/product/' + $orderProductsData[j]['slug'];
                        reviewText = 'Review';
                        deliveryAddressText = 'Delivery Address';
                        cargoPrice = 'Cargo Price';
                    }
                    else if(lang === 'tr') {
                        url_slug = 'tr/urun/' + $orderProductsData[j]['slug'];
                        reviewText = 'Değerlendir';
                        deliveryAddressText = 'Teslimat Adresi';
                        cargoPrice = 'Kargo Fiyatı';
                    }

                    tempOrders += '     <div class="orderContentArea">\n' +
                        '               <div class="productArea">\n' +
                        '                   <div class="imgArea">\n' +
                        '                       <a href="'+url_slug+'">\n'+
                        '                           <img src="/uploads/' + $orderProductsData[j]['image_path'] + '" alt="">\n' +
                        '                       </a>\n' +
                        '                       <span class="itemArea"><i class="far fa-times"></i>' + $orderProductsData[j]['quantity'] + '</span>\n' +
                        '                   </div>\n' +
                        '                   <div class="textArea">\n' +
                        '                       <div class="brand">\n' +
                        '                          <a href="#">\n' +
                        '                          ' + $orderProductsData[j]['brand'] + '\n' +
                        '                          </a>\n' +
                        '                       </div>\n' +
                        '                       <div class="name">\n' +
                        '                          <a href="#">\n' +
                        '                          ' + $orderProductsData[j]['name'] + '\n' +
                        '                          </a>\n' +
                        '                       </div>\n' +
                        '                       <div class="price">$ ' + number_format($orderProductsData[j]['price'], 2, ',', '.') + '</div>\n' +
                        '                   </div>\n' +
                        '               </div>\n' +
                        '               <div class="cargoPrice">\n' +
                        '                   <div class="title"> \n' +
                        '                       '+cargoPrice+' \n' +
                        '                   </div> \n' +
                        '                   <div class="content"> \n' +
                        '                       $ '+number_format($orderProductsData[j]['cargo_price'], 2, ',', '.')+' \n' +
                        '                   </div> \n' +
                        '               </div>\n' +
                        '               <div class="deliveryAddress">\n' +
                        '                   <a href="javascript:void(0)" data-toggle="modal" onclick="userDeliveryAddressModal('+$ordersData[i]['order_id']+')" data-target="#deliveryAddress">\n' +
                        '                       '+deliveryAddressText+'\n' +
                        '                   </a>\n' +
                        '               </div>\n' +
                        '               <div class="commentButtonArea">\n' +
                        '                   <a href="javascript:void(0)" id="reviews'+$b+'" data-id="'+$b+'" class="reviewsButtonClass" data-toggle="modal" onclick="reviewModal('+$orderProductsData[j]['product_id']+')" data-target="#review">\n' +
                        '                       <i class="far fa-comment-alt-dots"></i> '+reviewText+'\n' +
                        '                   </a>\n' +
                        '               </div>\n' +
                        '           </div>\n';
                }

                $b ++;
            }


            var orderDateText = '';
            var orderNoText = '';
            var orderSummaryText = '';

            if(lang === 'en') {
                orderDateText = 'Order Date';
                orderNoText = 'Order No';
                orderSummaryText = 'Order Summary';
            }
            else if(lang === 'tr') {
                orderDateText = 'Sipariş Tarihi';
                orderNoText = 'Sipariş No';
                orderSummaryText = 'Sipariş Sonuç';
            }


            let date = new Date($ordersData[i]['created_at']);
            let formattedDate = moment(date).format('DD MMMM YYYY, HH:mm');

            var orderStatus = '';

            if($ordersData[i]['status'] === 0) {
                if(lang === 'en')
                    orderStatus = 'On Hold';
                else
                    orderStatus = 'Beklemede';
            }
            else if($ordersData[i]['status'] === 1) {
                if(lang === 'en')
                    orderStatus = 'Preparing';
                else
                    orderStatus = 'Hazırlanıyor';
            }
            else if($ordersData[i]['status'] === 2) {
                if(lang === 'en')
                    orderStatus = 'In Cargo';
                else
                    orderStatus = 'Kargoda';
            }
            else if($ordersData[i]['status'] === 3) {
                if(lang === 'en')
                    orderStatus = 'Completed';
                else
                    orderStatus = 'Tamamlandı';
            }
            else if($ordersData[i]['status'] === 4) {
                if(lang === 'en')
                    orderStatus = 'Cancelled';
                else
                    orderStatus = 'İptal Edildi';
            }

            orders += ' <div id="order'+$a+'" class="accordion-panel">\n' +
                '           <div class="accordion-heading accordionHeadArea" role="tab" id="heading'+$a+'">\n' +
                '               <a class="orderGeneralInformationLink scale_active collapsed" data-toggle="collapse" data-parent="#userOrders" href="#collapse'+$a+'" aria-expanded="true" aria-controls="collapse'+$a+'" data-id="'+$a+'">\n' +
                '                   <div class="orderGeneralInformation">\n' +
                '                       <div class="orderNoArea">\n' +
                '                           <div class="title">'+orderNoText+'</div>\n' +
                '                           <div class="content">'+$ordersData[i]['order_code']+'</div>\n' +
                '                       </div>\n' +
                '                       <div class="orderDateArea">\n' +
                '                           <div class="title">'+orderDateText+'</div>\n' +
                '                           <div class="content">'+formattedDate+'</div>\n' +
                '                       </div>\n' +
                '                       <div class="orderSummaryArea">\n' +
                '                           <div class="title">'+orderSummaryText+'</div>\n' +
                '                           <div class="contents">\n' +
                '                           '+orderStatus+'\n' +
                '                           </div>\n' +
                '                       </div>\n' +
                '                       <div class="orderTotalMoneyArea">\n' +
                '                           <div class="money">$ '+number_format($ordersData[i]['total_price'], 2, ',', '.')+'</div>\n' +
                '                       </div>\n' +
                '                       <div class="iconArea">\n' +
                '                           <i class="fas"></i>\n' +
                '                       </div>\n' +
                '                   </div>\n' +
                '               </a>\n' +
                '           </div>\n' +

                '           <div id="collapse'+$a+'" class="panel-collapse in collapse accordionContentArea" role="tabpanel" aria-labelledby="heading'+$a+'">\n';

                orders += tempOrders;

            orders += '     </div>\n' +
                '       </div> \n';

            $a ++;
        }


        // if the order is empty
        if($ordersData.length === 0){

            var emptyOrderTitle = '';
            var emptyOrderText = '';
            var startShoppingText = '';
            var url = '';

            if(lang === 'en') {
                emptyOrderTitle = 'You haven\'t order yet.';
                emptyOrderText = 'You can buy to add the products to your basket.';
                startShoppingText = 'Start Shopping';
                url = '/';
            }
            else if(lang === 'tr') {
                emptyOrderTitle = 'Henüz siparişiniz yok';
                emptyOrderText = 'Ürünleri sepete ekleyerek satın alabilirsiniz.';
                startShoppingText = 'Alışverişe Başla';
                url = '/tr';
            }

            orders = ' <div class="emptyOrdersArea">\n' +
                '            <div class="iconArea">\n' +
                '               <i class="fas fa-dolly-flatbed-alt"></i>\n' +
                '            </div>\n' +
                '            <div class="title">'+emptyOrderTitle+'</div>\n' +
                '            <div class="text">'+emptyOrderText+'</div>\n' +
                '            <a href="'+url+'">\n' +
                '               '+startShoppingText+'\n' +
                '            </a>\n' +
                '        </div> \n';

            $('#ordersTitle').remove();
        }

        $('#userOrders').html(orders);

        eachOrderBoxShadow();

    }).fail(function (response) {

        counter ++;

        if(counter <= 3){
            userOrder();
        }
        else{
            $('#userOrders').html(orders);

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

// this function the money convert to european currency unit
function number_format (number, decimals, dec_point, thousands_sep) {
    // Strip all characters but numerical ones.
    number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
    var n = !isFinite(+number) ? 0 : +number,
        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
        sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
        dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
        s = '',
        toFixedFix = function (n, prec) {
            var k = Math.pow(10, prec);
            return '' + Math.round(n * k) / k;
        };
    // Fix for IE parseFloat(0.55).toFixed(0) = 0;
    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
    if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || '').length < prec) {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1).join('0');
    }
    return s.join(dec);
}

function eachOrderBoxShadow() {
    $('.orderGeneralInformationLink').on('click', function () {
        var dataId = $(this).attr('data-id');

        if ($(this).hasClass('collapsed') === true) {
            $('#order' + dataId).css('box-shadow', '0px 5px 20px rgb(72 72 72 / 13%)');
        } else {
            $('#order' + dataId).css('box-shadow', 'unset');
        }
    });
}

function userDeliveryAddressModal(orderId){
    let _token   = $('meta[name="csrf-token"]').attr('content');
    var lang = $('html').attr('lang');
    let modalHtml = $('#userDeliveryAddressModal').html();

    var ajaxLoaderHtml = spinAjaxLoader();
    $('#userDeliveryAddressModal').html(ajaxLoaderHtml);


    $.ajax({
        url: "/ajax/userOrderInformation",
        type:"POST",
        data:{
            orderId: orderId,
            lang: lang,
            _token: _token
        },
        dataType:"json"
    }).done(function (response) {
        $orderInformation = response.orderInformation;
        modalHtml = '';

        var countryText = '';
        var cityText = '';
        var countyText = '';
        var phoneText = '';
        var addressText = '';

        if(lang === 'en') {
            countryText = 'Country';
            cityText = 'City';
            countyText = 'County';
            phoneText = 'Phone';
            addressText = 'Address';
        }
        else {
            countryText = 'Ülke';
            cityText = 'Şehir';
            countyText = 'İlçe';
            phoneText = 'Telefon';
            addressText = 'Adres';
        }

        modalHtml = ' <div class="row inputsArea"> \n' +
            '                 <div class="col-lg-6 inputArea">\n' +
            '                     <label for="country" class="block font-medium text-sm text-gray-700">'+countryText+'</label>\n' +
            '                     <input id="country" type="text" class="mt-1 block w-full" value="'+$orderInformation[0]['country']+'" readonly>\n' +
            '                 </div>\n' +
            '                 <div class="col-lg-6 inputArea">\n' +
            '                     <label for="city" class="block font-medium text-sm text-gray-700">'+cityText+'</label>\n' +
            '                     <input id="city" type="text" class="mt-1 block w-full" value="'+$orderInformation[0]['city']+'" readonly>\n' +
            '                 </div>\n' +
            '                 <div class="col-lg-6 inputArea">\n' +
            '                     <label for="county" class="block font-medium text-sm text-gray-700">'+countyText+'</label>\n' +
            '                     <input id="county" type="text" class="mt-1 block w-full" value="'+$orderInformation[0]['county']+'" readonly>\n' +
            '                 </div>\n' +
            '                 <div class="col-lg-6 inputArea">\n' +
            '                     <label for="phone" class="block font-medium text-sm text-gray-700">'+phoneText+'</label>\n' +
            '                     <input id="phone" type="number" class="mt-1 block w-full" value="'+$orderInformation[0]['phone']+'" readonly>\n' +
            '                 </div>\n' +
            '                 <div class="col-lg-12 inputArea">\n' +
            '                     <label for="address" class="block font-medium text-sm text-gray-700">'+addressText+'</label>\n' +
            '                     <textarea id="address" class="mt-1 block w-full" readonly>'+$orderInformation[0]['address']+'</textarea>\n' +
            '                 </div>\n' +
            '             </div> \n';

        setTimeout(function() {
            $('#userDeliveryAddressModal').html(modalHtml);
        }, 300);

    }).fail(function (response) {

        counter ++;

        if(counter <= 3){
            $('#userDeliveryAddressModal').html(modalHtml);
            userDeliveryAddressModal(orderId);
        }
        else{
            $('#userDeliveryAddressModal').html(modalHtml);

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

function reviewModal(productId){
    let _token   = $('meta[name="csrf-token"]').attr('content');
    var lang = $('html').attr('lang');
    let modalHtml = '';

    var ajaxLoaderHtml = spinAjaxLoader();
    $('#reviewModalAjaxLoader').html(ajaxLoaderHtml);
    $('#reviewSaveButton').attr('disabled', true);


    $.ajax({
        url: "/ajax/userReview",
        type:"POST",
        data:{
            productId: productId,
            lang: lang,
            _token: _token
        },
        dataType:"json"
    }).done(function (response) {
        $data = response.data;
        $ratingScore = parseInt(response.star);
        $comment = response.comment;
        modalHtml = '';


        var questionText = '';
        var rateText = '';
        var commentText = '';
        var commentPlaceholderText = '';
        var saveButtonText = '';

        if(lang === 'en'){
            questionText = 'How did you find the product?';
            rateText = 'Please rate the product';
            commentText = 'Comment';
            commentPlaceholderText = 'The product is both affordable and a quality product as it appears.';
            saveButtonText = 'SAVE';
        }
        else{
            questionText = 'Ürünü nasıl buldunuz?';
            rateText = 'Lütfen ürünü oylayınız';
            commentText = 'Yorum';
            commentPlaceholderText = 'Ürün göründüğü gibi kaliteli ve rahat.';
            saveButtonText = 'KAYDET';
        }

        modalHtml = '        <form id="reviewFormArea" method="POST">\n' +
            '                    <div class="modal-header">\n' +
            '                        <h5 class="modal-title" id="reviewTitle">'+questionText+'</h5>\n' +
            '                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">\n' +
            '                            <span aria-hidden="true">&times;</span>\n' +
            '                        </button>\n' +
            '                    </div>\n' +
            '                    <div class="modal-body">\n' +
            '                        <div id="reviewModalAjaxLoader" class="reviewFormArea"> \n' +
            '                            <div class="row inputsArea">\n' +
            '                                <div class="col-lg-12 inputArea">\n' +
            '                                    <div class="productArea">\n' +
            '                                        <div class="imgArea">\n' +
            '                                            <img src="/uploads/'+$data[0]['image_path']+'" alt="">\n' +
            '                                        </div>\n' +
            '                                        <div class="textArea">\n' +
            '                                            <div class="brand">\n' +
            '                                                '+$data[0]['brand']+'\n' +
            '                                            </div>\n' +
            '                                            <div class="name">\n' +
            '                                                '+$data[0]['name']+'\n' +
            '                                            </div>\n' ;

        if($ratingScore > 0){
            modalHtml += '                               <div class="rating-group">\n' +
                '                                            <input disabled class="rating__input rating__input--none" name="rating3" id="rating3-none" value="0" type="radio">\n' ;

            var checkedControl = '';

            for(var x=1; x<=5; x++){

                if(x === $ratingScore)
                    checkedControl = 'checked';
                else
                    checkedControl = '';

                if(x === 1){
                    modalHtml += '                           <label aria-label="' + x + ' star" class="rating__label" for="rating3-' + x + '"><i class="rating__icon rating__icon--star fa fa-star"></i></label>\n' +
                        '                                    <input ' + checkedControl + ' class="rating__input" name="rating3" id="rating3-' + x + '" value="' + x + '" type="radio">\n';
                }
                else {
                    modalHtml += '                           <label aria-label="' + x + ' stars" class="rating__label" for="rating3-' + x + '"><i class="rating__icon rating__icon--star fa fa-star"></i></label>\n' +
                        '                                    <input ' + checkedControl + ' class="rating__input" name="rating3" id="rating3-' + x + '" value="' + x + '" type="radio">\n';
                }
            }

            modalHtml += '                               </div>\n';
        }
        else {
            modalHtml += '                               <div class="rating-group">\n' +
                '                                            <input disabled checked class="rating__input rating__input--none" name="rating3" id="rating3-none" value="0" type="radio">\n' +
                '                                            <label aria-label="1 star" class="rating__label" for="rating3-1"><i class="rating__icon rating__icon--star fa fa-star"></i></label>\n' +
                '                                            <input class="rating__input" name="rating3" id="rating3-1" value="1" type="radio">\n' +
                '                                            <label aria-label="2 stars" class="rating__label" for="rating3-2"><i class="rating__icon rating__icon--star fa fa-star"></i></label>\n' +
                '                                            <input class="rating__input" name="rating3" id="rating3-2" value="2" type="radio">\n' +
                '                                            <label aria-label="3 stars" class="rating__label" for="rating3-3"><i class="rating__icon rating__icon--star fa fa-star"></i></label>\n' +
                '                                            <input class="rating__input" name="rating3" id="rating3-3" value="3" type="radio">\n' +
                '                                            <label aria-label="4 stars" class="rating__label" for="rating3-4"><i class="rating__icon rating__icon--star fa fa-star"></i></label>\n' +
                '                                            <input class="rating__input" name="rating3" id="rating3-4" value="4" type="radio">\n' +
                '                                            <label aria-label="5 stars" class="rating__label" for="rating3-5"><i class="rating__icon rating__icon--star fa fa-star"></i></label>\n' +
                '                                            <input class="rating__input" name="rating3" id="rating3-5" value="5" type="radio">\n' +
                '                                        </div>\n';
        }

        modalHtml += '                                   <div class="subText">\n' +
            '                                                 '+rateText+'\n' +
            '                                            </div>\n' +
            '                                        </div>\n' +
            '                                    </div>\n' +
            '                                </div>\n' +
            '                                <div class="col-lg-12 inputArea">\n' +
            '                                    <label for="commentForm" class="block font-medium text-sm text-gray-700">'+commentText+'</label>\n' +
            '                                    <textarea id="commentForm" class="mt-1 block w-full" placeholder="'+commentPlaceholderText+'">'+$comment+'</textarea>\n' +
            '                                    <div class="errorMessageArea">\n' +
            '                                        <span class="text-danger" id="commentFormErrorMsg"></span>\n' +
            '                                    </div>\n' +
            '                                </div>\n' +
            '                            </div> \n' +
            '                        </div>\n' +
            '                    </div>\n' +
            '                    <div class="modal-footer reviewFormModalFooter">\n' +
            '                        <button type="submit" id="reviewSaveButton" class="btn btn-secondary saveButton" disabled>'+saveButtonText+'</button>\n' +
            '                    </div>\n' +
            '                </form> \n' ;

        setTimeout(function() {
            $('#reviewModal').html(modalHtml);
            if($ratingScore > 0) {
                var ratingNo = $ratingScore;
                $('.modal .modal-body .reviewFormArea .inputsArea .inputArea .productArea .textArea .subText').remove();
                $('#reviewSaveButton').attr('disabled', false);
                reviewSubmitForm(ratingNo, productId, true);
            }
            else {
                $('.rating__input').click(function () {
                    var ratingNo = $(this).val();
                    $('.modal .modal-body .reviewFormArea .inputsArea .inputArea .productArea .textArea .subText').remove();
                    $('#reviewSaveButton').attr('disabled', false);
                    reviewSubmitForm(ratingNo, productId, false);
                });
            }
        }, 300);


    }).fail(function (response) {

        counter ++;

        if(counter <= 3){
            $('#reviewModal').html(modalHtml);
            reviewModal(productId);
        }
        else{
            $('#reviewModal').html(modalHtml);

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

function reviewSubmitForm(ratingScore, productId, updateControl) {
    if(updateControl === true) {
        $('.rating__input').click(function () {
            ratingScore = $(this).val();
        });
    }
    $('#reviewFormArea').on('submit', function (e) {
        e.preventDefault();

        let _token = $('meta[name="csrf-token"]').attr('content');
        var lang = $('html').attr('lang');

        let commentForm = $('#commentForm').val();


        $.ajax({
            url: "/ajax/reviewFormSubmit",
            type: "POST",
            data: {
                commentForm: commentForm,
                ratingScore: ratingScore,
                productId: productId,
                _token: _token
            },
            dataType: "json"
        }).done(function (response) {

            $('#review').modal('hide');

            var title = '';
            var text = '';

            if(lang === 'en'){
                title = 'Thank you for your reviewing';
                text = 'Your comment will be published as soon as it controlled';
            }
            else{
                title = 'Değerlendirmeniz için teşekkür ederiz';
                text = 'Yorumunuz kontrol edildikten sonra yayınlanacak';
            }

            Swal.fire({
                position: 'center',
                icon: 'success',
                title: title,
                text: text,
                showConfirmButton: true
            })

        }).fail(function (response) {

            $('#review').modal('hide');

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

        });

        e.stopImmediatePropagation();
    });
}

function openAjaxLoader(){
    $ajaxLoaderAllScreen = ajaxLoaderAllScreen();
    $($.parseHTML($ajaxLoaderAllScreen)).insertBefore($('header'));

    $('.ajaxLoaderAllScreen').fadeIn(300);
}
function closeAjaxLoader(){
    $('.ajaxLoaderAllScreen').fadeOut(300);

    setTimeout(function() {
        $('.ajaxLoaderAllScreen').remove();
    }, 300);
}
