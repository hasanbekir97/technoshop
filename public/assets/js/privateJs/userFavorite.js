
var counter = 0;

userFavorite();

function userFavorite(){
    let _token   = $('meta[name="csrf-token"]').attr('content');
    var lang = $('html').attr('lang');

    var favorite = $('#favoritePage').html();


    $.ajax({
        url: "/ajax/showFavorite",
        type:"POST",
        data:{
            lang: lang,
            _token: _token
        },
        dataType:"json"
    }).done(function (response) {

        $products = response.favAllProducts;
        favorite = '';

        function getFavoriteProductsHtml(){
            var favoriteProductsHtml = '';

            for(i in $products) {

                var url_slug = '';

                if(lang === 'en')
                    url_slug = '/product/'+$products[i]['slug'];
                else if(lang === 'tr')
                    url_slug = 'tr/urun/'+$products[i]['slug'];

                favoriteProductsHtml += ' <li class="product">\n' +
                    '                        <a href="'+url_slug+'">\n' +
                    '                            <div class="topArea">\n' +
                    '                                <img src="/uploads/'+$products[i]['image_path']+'">\n' +
                    '                            </div>\n' +
                    '                            <div class="bottomArea">\n' +
                    '                                <span class="productNameArea">'+$products[i]['name']+'</span>\n' +
                    '                                <div class="productPriceArea">\n' +
                    '                                    <div class="productDiscountArea">\n' +
                    '                                        <section><span>%</span>'+$products[i]['discount_rate']+'</section>\n' +
                    '                                    </div>\n' +
                    '                                    <div class="priceAreaDetails">\n' +
                    '                                        <div class="oldPrice">\n' +
                    '                                            <section class="dolarIconArea">$</section>\n' +
                    '                                            ' + number_format($products[i]['old_price'], 2, ',', '.') + ' \n' +
                    '                                        </div>\n' +
                    '                                        <div class="newPrice">\n' +
                    '                                            <section class="dolarIconArea">$</section>\n' +
                    '                                            ' + number_format($products[i]['price'], 2, ',', '.') + ' \n' +
                    '                                        </div>\n' +
                    '                                    </div>\n' +
                    '                                </div>\n' +
                    '                            </div>\n' +
                    '                        </a>\n' +
                    '                        <button class="deleteButtonFavourite" onclick="deleteFavorite('+$products[i]['product_id']+')"> \n'+
                    '                            <i class="fal fa-times"></i>\n' +
                    '                        </button>\n' +
                    '                    </li> \n';
            }

            return favoriteProductsHtml;
        }

        var favText = '';
        var emptyFavText = '';

        if(lang === 'en') {
            favText = 'My Favourite List';
            emptyFavText = 'Empty Favourite List';
        }
        else {
            favText = 'Favori Listem';
            emptyFavText = 'Favori Listesini Temizle';
        }

        favorite += ' <div class="bodyArea favouritePage">\n' +
            '           <div class="title">\n' +
            '               <section>'+favText+'</section>\n' +
            '               <section>\n' +
            '                   <button onclick="deleteAllFavorite()">'+emptyFavText+'</button>\n' +
            '               </section>\n' +
            '           </div>\n' +
            '           <div class="productArea"> \n'+
            '               <ul> \n'
            +                   getFavoriteProductsHtml() +
            '               </ul> \n'+
            '           </div>\n' +
            '       </div>\n';

        // if the cart is empty
        if($products.length === 0){

            var yourFavEmptyTitle = '';
            var yourFavEmptyText = '';
            var startShoppingText = '';
            var url = '';

            if(lang === 'en') {
                yourFavEmptyTitle = 'Your favorite list is empty.';
                yourFavEmptyText = 'You can start shopping to add the products that interest you to your favorites.';
                startShoppingText = 'Start Shopping';
                url = '/';
            }
            else {
                yourFavEmptyTitle = 'Favori listeniz boş.';
                yourFavEmptyText = 'İlginizi çeken ürünleri sepete ekleyerek alışverişe yapmaya başlayabilirsiniz.';
                startShoppingText = 'Alışverişe Başla';
                url = '/tr';
            }

            favorite = ' <div class="emptyFavoritesArea">\n' +
                '            <div class="iconArea">\n' +
                '               <i class="fas fa-heart"></i>\n' +
                '            </div>\n' +
                '            <div class="title">'+yourFavEmptyTitle+'</div>\n' +
                '            <div class="text">'+yourFavEmptyText+'</div>\n' +
                '            <a href="'+url+'">\n' +
                '               '+startShoppingText+'\n' +
                '            </a>\n' +
                '        </div> \n';
        }

        $('#favoritePage').html(favorite);

    }).fail(function (response) {

        counter ++;

        if(counter <= 3){
            userFavorite();
        }
        else{
            $('#favoritePage').html(favorite);

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

function deleteFavorite(productId){
    let _token   = $('meta[name="csrf-token"]').attr('content');
    var lang = $('html').attr('lang');

    $message = '';
    $confirmButton = '';
    $cancelButton = '';

    if(lang === 'en') {
        $message = 'Do you want to remove the product from your favorite list?';
        $confirmButton = 'Yes';
        $cancelButton = 'No';
    }
    else {
        $message = 'Favori listenizden ürünü çıkarmak istiyor musunuz?';
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
                url: "/ajax/deleteFavorite",
                type:"POST",
                data:{
                    productId: productId,
                    lang: lang,
                    _token: _token
                },
                dataType:"json"
            }).done(function (response) {
                userFavorite();
                showCartNumber();

                $('.ajaxLoaderAllScreen').fadeOut(300);

                setTimeout(function() {
                    $('.ajaxLoaderAllScreen').remove();
                }, 300);

                if(lang === 'en')
                    toastr.success('The product that is in your favorite list has been successfully removed.');
                else
                    toastr.success('Favori listenizdeki ürün başarılı olarak çıkarıldı.');

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

function deleteAllFavorite(){
    let _token   = $('meta[name="csrf-token"]').attr('content');
    var lang = $('html').attr('lang');

    $message = '';
    $confirmButton = '';
    $cancelButton = '';

    if(lang === 'en') {
        $message = 'Do you want to remove the all products from your favorite list?';
        $confirmButton = 'Yes';
        $cancelButton = 'No';
    }
    else {
        $message = 'Favori listenizdeki tüm ürünleri çıkarmak istiyor musunuz?';
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
                url: "/ajax/deleteAllFavorite",
                type:"POST",
                data:{
                    lang: lang,
                    _token: _token
                },
                dataType:"json"
            }).done(function (response) {
                userFavorite();

                $('.ajaxLoaderAllScreen').fadeOut(300);

                setTimeout(function() {
                    $('.ajaxLoaderAllScreen').remove();
                }, 300);

                if(lang === 'en')
                    toastr.success('All product that are in your favorite list has been successfully removed.');
                else
                    toastr.success('Favori listenizdeki tüm ürünler başarılı olarak çıkarıldı.');
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
