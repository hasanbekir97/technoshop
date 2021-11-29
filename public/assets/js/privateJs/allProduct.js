
var counter = 0;

allProduct(0);

function loadMoreProduct(pagenum) {
    allProduct(pagenum);
}

function allProduct (pageNum){
    let _token   = $('meta[name="csrf-token"]').attr('content');
    var lang = $('html').attr('lang');
    var productsHtml = $('#productsAll').html();
    var moreProductHtml = $('#paginationMoreProduct').html();

    var ajaxLoaderHtml = ajaxLoader();
    $('#paginationMoreProduct').html(ajaxLoaderHtml);


    $filter = filterValues();

    $.ajax({
        url: "/ajax/products",
        type:"POST",
        data:{
            pageNum: pageNum,
            filter: $filter,
            lang: lang,
            _token: _token
        },
        dataType:"json"
    }).done(function (response) {
        $products = response.products;
        productsHtml = '';
        moreProductHtml = '';

        for(i in $products) {

            var url_slug = '';

            if(lang === 'en')
                url_slug = '/product/'+$products[i]['slug'];
            else if(lang === 'tr')
                url_slug = 'tr/urun/'+$products[i]['slug'];

            productsHtml += ' <li class="product"> \n' +
                '               <a href="'+ url_slug + '"> \n' +
                '                   <div class="topArea"> \n' +
                '                       <img src="/uploads/' + $products[i]['image_path'] + '"> \n' +
                '                   </div> \n' +
                '                   <div class="bottomArea"> \n' +
                '                       <span class="productNameArea">' + $products[i]['name'] + '</span> \n' ;

            productsHtml += calculateStarAVg ($products[i]['product_id'], $products[i]['star_avg'], $products[i]['star_number']);

            productsHtml += '           <div class="productPriceArea"> \n' +
                '                           <div class="productDiscountArea"> \n' +
                '                               <section><span>%</span>' + $products[i]['discount_rate'] + '</section> \n' +
                '                           </div> \n' +
                '                           <div class="priceAreaDetails"> \n' +
                '                               <div class="oldPrice"> \n' +
                '                                   <section class="dolarIconArea">$</section> \n' +
                '                                   ' + number_format($products[i]['old_price'], 2, ',', '.') + ' \n' +
                '                               </div> \n' +
                '                               <div class="newPrice"> \n' +
                '                                   <section class="dolarIconArea">$</section> \n' +
                '                                   ' + number_format($products[i]['price'], 2, ',', '.') + ' \n' +
                '                               </div> \n' +
                '                           </div> \n' +
                '                       </div> \n' +
                '                   </div> \n' +
                '                </a> \n' +
                '            </li> \n';
        }

        pageNum = parseInt(pageNum) + 1;

        var moreProductText = '';

        if(lang === 'en')
            moreProductText = 'More Product';
        else
            moreProductText = 'Daha Fazla Ürün';

        moreProductHtml += ' <a type=button id="moreProductButton" onclick="loadMoreProduct('+pageNum+')">\n' +
            '                       moreProductText\n' +
            '                   </a> \n';

        setTimeout(function() {
            $('#paginationMoreProduct').html(moreProductHtml);
        }, 300);


        $uploadedProductNumber = response.uploadedProductNumber;
        $uploadLimitNumber = response.uploadLimitNumber;



        if($uploadedProductNumber === $uploadLimitNumber){
            $('#paginationMoreProduct').remove();
        }

        $($.parseHTML(productsHtml)).appendTo('#productsAll');

        $('#uploadedProductNumber').html($uploadedProductNumber);
    }).fail(function (response) {

        counter ++;

        if(counter <= 3){
            $('#productsAll').html(productsHtml);
            allProduct(pageNum);
        }
        else{
            $('#productsAll').html(productsHtml);

            setTimeout(function() {
                $('#paginationMoreProduct').html(moreProductHtml);
            }, 300);

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

function calculateStarAVg (productId, starAvg, starNumber){
    var starAvgHtml = '';

    $starAvg = parseFloat(starAvg);
    $totalStarNumber = parseInt(starNumber);

    starAvgHtml +=' <div class="starAvgShowHeadArea">\n' +
        '               <ul class="starAvgShow">\n' ;

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


    starAvgHtml +='     </ul> ' +
        '                <div class="commentCountArea">\n' +
        '                    ('+$totalStarNumber+')\n' +
        '                </div>\n' +
        '            </div>\n' ;


    return starAvgHtml;
}

function filterValues(){
    $filter = {};

    document.location.search.replace(/\??(?:([^=]+)=([^&]*)&?)/g, function () {
        function decode(s) {
            return decodeURIComponent(s.split("+").join(" "));
        }
        $filter[decode(arguments[1])] = decode(arguments[2]);
    });

    return $filter;
}
