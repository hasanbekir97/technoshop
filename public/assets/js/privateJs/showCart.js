
var counter = 0;

showCart();

function showCart(){
    let _token   = $('meta[name="csrf-token"]').attr('content');
    var lang = $('html').attr('lang');

    var cart = $('#cartPage').html();


    $.ajax({
        url: "/ajax/showCart",
        type:"POST",
        data:{
            lang: lang,
            _token: _token
        },
        dataType:"json"
    }).done(function (response) {

        $products = response.cartAllProducts;
        $totalProductNumber = response.totalProductNumber;
        $totalProductPrice = response.totalProductPrice;
        $totalProductCargoPrice = response.totalProductCargoPrice;
        $totalFinalPrice = response.totalFinalPrice;
        cart = '';

        function getCartProductsHtml(){
            cartProductsHtml = '';

            for(i in $products) {
                $itemNumber = $products[i]['quantity'];
                $stock = $products[i]['stock'];

                $stockControlResult = '';

                if($itemNumber >= $stock){
                    $stockControlResult = 'active';
                }

                $smallerThanOneControl = '';

                if($itemNumber <= 1){
                    $smallerThanOneControl = 'active';
                }

                cartProductsHtml += ' <li id="product'+$products[i]['product_id']+'" data-id="'+$products[i]['product_id']+'"> \n'+
                    '        <ol class="basketProductArea"> \n'+
                    '            <li> \n'+
                    '                <div class="imgArea"> \n'+
                    '                    <a href="/product/'+$products[i]['slug']+'"> \n'+
                    '                        <section class="image"> \n'+
                    '                            <img src="/uploads/'+$products[i]['image_path']+'" alt=""> \n'+
                    '                        </section> \n'+
                    '                    </a> \n'+
                    '                    <a href="/product/'+$products[i]['slug']+'"> \n'+
                    '                        <section class="text"> \n'+
                    '                            <span class="productBrand"> \n'+
                    '                                '+$products[i]['brand']+' \n'+
                    '                            </span> \n'+
                    '                            <span class="productName"> \n'+
                    '                                '+$products[i]['name']+' \n'+
                    '                            </span> \n'+
                    '                        </section> \n'+
                    '                    </a> \n'+
                    '                </div> \n'+
                    '            </li> \n'+
                    '            <li> \n'+
                    '                <ul> \n'+
                    '                    <li class="countArea"> \n'+
                    '                        <div class="productCountSection"> \n'+
                    '                            <div class="number-input"> \n'+
                    '                                <button id="decreaseButton'+$products[i]['product_id']+'" class="decreaseButton cartPageDecreaseAndIncrease '+$smallerThanOneControl+'" data-id="'+$products[i]['product_id']+'" onclick="minusCart('+$products[i]['product_id']+')"></button> \n'+
                    '                                <div class="itemArea"> \n'+
                    '                                    <input id="quantity'+$products[i]['product_id']+'" class="quantity productQuantity2" min="1" data-id="'+$products[i]['product_id']+'" oninput="updateCart(validity.valid||(value='+'1'+'), '+$products[i]['product_id']+')" name="quantity" value="'+$products[i]['quantity']+'" type="number"> \n'+
                    '                                </div> \n'+
                    '                                <button id="increaseButton'+$products[i]['product_id']+'" class="plus increaseButton cartPageDecreaseAndIncrease '+$stockControlResult+'" data-id="'+$products[i]['product_id']+'" onclick="plusCart('+$products[i]['product_id']+')"></button> \n'+
                    '                            </div> \n'+
                    '                        </div> \n'+
                    '                    </li> \n'+
                    '                    <li class="priceArea"> \n'+
                    '                        <div class="priceAreaDetails"> \n'+
                    '                            <div class="newPrice"> \n'+
                    '                                <section class="dolarIconArea">$</section> \n'+
                    '                               ' + number_format($products[i]['cart_price'], 2, ',', '.') + ' \n' +
                    '                            </div> \n'+
                    '                        </div> \n'+
                    '                    </li> \n'+
                    '                    <li class="deleteArea"> \n'+
                    '                        <button id="cartDeleteButton'+$products[i]['product_id']+'" class="deleteButton cartDelButton" data-id="'+$products[i]['product_id']+'" onclick="deleteCart('+$products[i]['product_id']+')"> \n'+
                    '                            <i class="far fa-trash-alt"></i> \n'+
                    '                        </button> \n'+
                    '                    </li> \n'+
                    '                </ul> \n'+
                    '            </li> \n'+
                    '        </ol> \n'+
                    '    </li> \n';
            }

            return cartProductsHtml;
        }

        var emptyCartText = '';
        var myCartText = '';
        var orderSummaryText = '';
        var totalProductNumberText = '';
        var subTotalText = '';
        var cargoPriceText = '';
        var totalText = '';
        var continuePaymentText = '';
        var paymentUrl = '';

        if(lang === 'en') {
            emptyCartText = 'Empty Cart';
            myCartText = 'My Cart';
            orderSummaryText = 'Order Summary';
            totalProductNumberText = $totalProductNumber+' item in total';
            subTotalText = 'Sub Total';
            cargoPriceText = 'Cargo Price';
            totalText = 'Total';
            continuePaymentText = 'Continue payment';
            paymentUrl = '/payment';
        }
        else {
            emptyCartText = 'Sepeti Temizle';
            myCartText = 'Sepetim';
            orderSummaryText = 'Sipariş Özeti';
            totalProductNumberText = 'Toplam '+$totalProductNumber+' ürün';
            subTotalText = 'Ara Toplam';
            cargoPriceText = 'Kargo Fiyatı';
            totalText = 'Toplam';
            continuePaymentText = 'Ödemeye geç';
            paymentUrl = '/tr/odeme';
        }

        cart += ' <div class="leftArea">\n' +
            '       <div class="title">\n' +
            '           <section>'+myCartText+'</section>\n' +
            '           <section>\n' +
            '               <button onclick="deleteAllCart()">'+emptyCartText+'</button>\n' +
            '           </section>\n' +
            '       </div>\n' +
            '       <ul> \n'
            +           getCartProductsHtml() +
            '       </ul>\n' +
            '     </div>\n' +
            '     <div class="rightArea"> \n' +
            '     <div class="title">'+orderSummaryText+'</div>\n' +
            '        <ul class="subArea">\n' +
            '            <li class="itemTotal">'+totalProductNumberText+'</li>\n' +
            '            <li class="productPriceTotal">\n' +
            '                <span>'+subTotalText+'</span>\n' +
            '                <span>\n' +
            '                    <div class="priceAreaDetails">\n' +
            '                        <div class="newPrice">\n' +
            '                            <section class="dolarIconArea">$</section>\n' +
            '                            '+number_format ($totalProductPrice, 2, ',', '.')+'\n' +
            '                        </div>\n' +
            '                    </div>\n' +
            '                </span>\n' +
            '            </li>\n' +
            '            <li class="productPriceTotal cargoPriceArea">\n' +
            '                <span>'+cargoPriceText+'</span>\n' +
            '                <span>\n' +
            '                    <div class="priceAreaDetails">\n' +
            '                        <div class="newPrice">\n' +
            '                            <section class="dolarIconArea">$</section>\n' +
            '                            '+number_format ($totalProductCargoPrice, 2, ',', '.')+'\n' +
            '                        </div>\n' +
            '                    </div>\n' +
            '                </span>\n' +
            '            </li>\n' +
            '            <li class="totalPrice">\n' +
            '                <span>'+totalText+'</span>\n' +
            '                <span>\n' +
            '                    <div class="priceAreaDetails">\n' +
            '                        <div class="newPrice">\n' +
            '                            <section class="dolarIconArea">$</section>\n' +
            '                            '+number_format ($totalFinalPrice, 2, ',', '.')+'\n' +
            '                        </div>\n' +
            '                    </div>\n' +
            '                </span>\n' +
            '            </li>\n' +
            '            <li class="completeOrderButtonArea">\n' +
            '                <a href="'+paymentUrl+'" class="completeButton">\n' +
            '                    '+continuePaymentText+'\n' +
            '                </a>\n' +
            '            </li>\n' +
            '        </ul> \n' +
            '     </div>\n';

        // if the cart is empty
        if($products.length === 0){

            var yourCartEmptyTitle = '';
            var yourCartEmptyText = '';
            var startShoppingText = '';
            var url = '';

            if(lang === 'en') {
                yourCartEmptyTitle = 'Your cart is empty.';
                yourCartEmptyText = 'You can start shopping to fill your cart with products full of opportunities.';
                startShoppingText = 'Start Shopping';
                url = '/';
            }
            else {
                yourCartEmptyTitle = 'Sepetiniz boş.';
                yourCartEmptyText = 'Fırsat ürünler ile sepetinizi doldurarak alışveriş yapmaya başlayabilirsiniz.';
                startShoppingText = 'Alışverişe Başla';
                url = '/tr';
            }

            cart = ' <div class="emptyCartArea">\n' +
                '        <img src="/assets/img/cart1.png">\n' +
                '        <div class="title">'+yourCartEmptyTitle+'</div>\n' +
                '        <div class="text">'+yourCartEmptyText+'</div>\n' +
                '        <a href="'+url+'">\n' +
                '            '+startShoppingText+'\n' +
                '        </a>\n' +
                '    </div> \n';
        }

        $('#cartPage').html(cart);

    }).fail(function (response) {

        counter ++;

        if(counter <= 3){
            showCart();
        }
        else{
            $('#cartPage').html(cart);

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

function updateCart(response, productId){
    let _token   = $('meta[name="csrf-token"]').attr('content');
    var lang = $('html').attr('lang');

    var itemNumber = $('#quantity'+productId).val();

    $ajaxLoaderAllScreen = ajaxLoaderAllScreen();
    $($.parseHTML($ajaxLoaderAllScreen)).insertBefore($('header'));

    $('.ajaxLoaderAllScreen').fadeIn(300);

    $.ajax({
        url: "/ajax/updateCart",
        type:"POST",
        data:{
            itemNumber: itemNumber,
            productId: productId,
            lang: lang,
            _token: _token
        },
        dataType:"json"
    }).done(function (response) {
        $itemNumber = response.itemNumber;
        $totalPrice = response.totalPrice;
        $productId = productId;
        $stockControl = response.finalStock;
        $productName = response.productName;

        if($stockControl === true){
            $message = '';

            if(lang === 'en')
                $message = 'You can buy up to '+$itemNumber+' item from the product that called '+$productName+'.';
            else
                $message = $productName+' adlı üründen en fazla '+$itemNumber+' tane satın alabilirsiniz'+'.';

            toastr.error($message);
        }

        showCart();

        $('.ajaxLoaderAllScreen').fadeOut(300);

        setTimeout(function() {
            $('.ajaxLoaderAllScreen').remove();
        }, 300);

        if(lang === 'en')
            toastr.success('Your cart has been successfully updated.');
        else
            toastr.success('Sepetiniz başarılı olarak güncellendi.');
    }).fail(function (response) {
        showCart();
        $('.ajaxLoaderAllScreen').fadeOut(300);

        setTimeout(function() {
            $('.ajaxLoaderAllScreen').remove();
        }, 300);

        if(lang === 'en')
            toastr.error('Something went wrong.');
        else
            toastr.error('Bir hata oluştu.');
    });
}

function plusCart(productId){
    let _token   = $('meta[name="csrf-token"]').attr('content');
    var lang = $('html').attr('lang');

    var itemNumber = $('#quantity'+productId).val();
    itemNumber ++;

    $ajaxLoaderAllScreen = ajaxLoaderAllScreen();
    $($.parseHTML($ajaxLoaderAllScreen)).insertBefore($('header'));

    $('.ajaxLoaderAllScreen').fadeIn(300);

    $.ajax({
        url: "/ajax/updateCart",
        type:"POST",
        data:{
            itemNumber: itemNumber,
            productId: productId,
            lang: lang,
            _token: _token
        },
        dataType:"json"
    }).done(function (response) {
        $itemNumber = response.itemNumber;
        $totalPrice = response.totalPrice;
        $productId = productId;
        $stockControl = response.finalStock;
        $productName = response.productName;

        if($stockControl === true){
            $message = '';

            if(lang === 'en')
                $message = 'You can buy up to '+$itemNumber+' item from the product that called '+$productName+'.';
            else
                $message = $productName+' adlı üründen en fazla '+$itemNumber+' tane satın alabilirsiniz'+'.';

            toastr.error($message);
        }

        showCart();

        $('.ajaxLoaderAllScreen').fadeOut(300);

        setTimeout(function() {
            $('.ajaxLoaderAllScreen').remove();
        }, 300);

        if(lang === 'en')
            toastr.success('Your cart has been successfully updated.');
        else
            toastr.success('Sepetiniz başarılı olarak güncellendi.');
    }).fail(function (response) {
        showCart();
        $('.ajaxLoaderAllScreen').fadeOut(300);

        setTimeout(function() {
            $('.ajaxLoaderAllScreen').remove();
        }, 300);

        if(lang === 'en')
            toastr.error('Something went wrong.');
        else
            toastr.error('Bir hata oluştu.');
    });
}

function minusCart(productId){
    let _token   = $('meta[name="csrf-token"]').attr('content');
    var lang = $('html').attr('lang');

    var itemNumber = $('#quantity'+productId).val();
    itemNumber --;

    $ajaxLoaderAllScreen = ajaxLoaderAllScreen();
    $($.parseHTML($ajaxLoaderAllScreen)).insertBefore($('header'));

    $('.ajaxLoaderAllScreen').fadeIn(300);

    $.ajax({
        url: "/ajax/updateCart",
        type:"POST",
        data:{
            itemNumber: itemNumber,
            productId: productId,
            lang: lang,
            _token: _token
        },
        dataType:"json"
    }).done(function (response) {
        $itemNumber = response.itemNumber;
        $totalPrice = response.totalPrice;
        $productId = productId;

        showCart();

        $('.ajaxLoaderAllScreen').fadeOut(300);

        setTimeout(function() {
            $('.ajaxLoaderAllScreen').remove();
        }, 300);

        if(lang === 'en')
            toastr.success('Your cart has been successfully updated.');
        else
            toastr.success('Sepetiniz başarılı olarak güncellendi.');
    }).fail(function (response) {
        showCart();
        $('.ajaxLoaderAllScreen').fadeOut(300);

        setTimeout(function() {
            $('.ajaxLoaderAllScreen').remove();
        }, 300);

        if(lang === 'en')
            toastr.error('Something went wrong.');
        else
            toastr.error('Bir hata oluştu.');
    });
}

function deleteCart(productId){
    let _token   = $('meta[name="csrf-token"]').attr('content');
    var lang = $('html').attr('lang');

    $message = '';
    $confirmButton = '';
    $cancelButton = '';

    if(lang === 'en') {
        $message = 'Do you want to delete the product in your cart?';
        $confirmButton = 'Yes';
        $cancelButton = 'No';
    }
    else {
        $message = 'Sepetinizdeki ürünü silmek istiyor musunuz?';
        $confirmButton = 'Evet';
        $cancelButton = 'Hayır';
    }

    Swal.fire({
        title: $message,
        showDenyButton: true,
        confirmButtonText: $confirmButton,
        denyButtonText: $cancelButton,
        customClass: {
            confirmButton: 'order-2',
            denyButton: 'order-3',
        }
    }).then((result) => {
        if (result.isConfirmed) {

            $ajaxLoaderAllScreen = ajaxLoaderAllScreen();
            $($.parseHTML($ajaxLoaderAllScreen)).insertBefore($('header'));

            $('.ajaxLoaderAllScreen').fadeIn(300);

            $.ajax({
                url: "/ajax/deleteCart",
                type:"POST",
                data:{
                    productId: productId,
                    lang: lang,
                    _token: _token
                },
                dataType:"json"
            }).done(function (response) {
                showCart();
                showCartNumber();

                $('.ajaxLoaderAllScreen').fadeOut(300);

                setTimeout(function() {
                    $('.ajaxLoaderAllScreen').remove();
                }, 300);

                if(lang === 'en')
                    toastr.success('The product that is in your cart has been successfully deleted.');
                else
                    toastr.success('Sepetinizdeki ürün başarılı olarak silindi.');
            }).fail(function (response) {
                showCart();
                $('.ajaxLoaderAllScreen').fadeOut(300);

                setTimeout(function() {
                    $('.ajaxLoaderAllScreen').remove();
                }, 300);

                if(lang === 'en')
                    toastr.error('Something went wrong.');
                else
                    toastr.error('Bir hata oluştu.');
            });
        } else if (result.isDenied) {

        }
    })
}

function deleteAllCart(){
    let _token   = $('meta[name="csrf-token"]').attr('content');
    var lang = $('html').attr('lang');

    $message = '';
    $confirmButton = '';
    $cancelButton = '';

    if(lang === 'en') {
        $message = 'Do you want to delete all products in your cart?';
        $confirmButton = 'Yes';
        $cancelButton = 'No';
    }
    else {
        $message = 'Sepetinizdeki tüm ürünleri silmek istiyor musunuz?';
        $confirmButton = 'Evet';
        $cancelButton = 'Hayır';
    }

    Swal.fire({
        title: $message,
        showDenyButton: true,
        confirmButtonText: $confirmButton,
        denyButtonText: $cancelButton,
        customClass: {
            confirmButton: 'order-2',
            denyButton: 'order-3',
        }
    }).then((result) => {
        if (result.isConfirmed) {

            $ajaxLoaderAllScreen = ajaxLoaderAllScreen();
            $($.parseHTML($ajaxLoaderAllScreen)).insertBefore($('header'));

            $('.ajaxLoaderAllScreen').fadeIn(300);

            $.ajax({
                url: "/ajax/deleteAllCart",
                type:"POST",
                data:{
                    lang: lang,
                    _token: _token
                },
                dataType:"json"
            }).done(function (response) {
                showCart();
                showCartNumber();

                $('.ajaxLoaderAllScreen').fadeOut(300);

                setTimeout(function() {
                    $('.ajaxLoaderAllScreen').remove();
                }, 300);

                if(lang === 'en')
                    toastr.success('All product that is in your cart has been successfully deleted.');
                else
                    toastr.success('Sepetinizdeki tüm ürünler başarılı olarak silindi.');

            }).fail(function (response) {
                showCart();
                $('.ajaxLoaderAllScreen').fadeOut(300);

                setTimeout(function() {
                    $('.ajaxLoaderAllScreen').remove();
                }, 300);

                if(lang === 'en')
                    toastr.error('Something went wrong.');
                else
                    toastr.error('Bir hata oluştu.');
            });
        } else if (result.isDenied) {

        }
    })
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
