
var counter = 0;

showfilterHtml();

function showfilterHtml(){
    let _token   = $('meta[name="csrf-token"]').attr('content');
    var lang = $('html').attr('lang');
    var brandsHtml = $('#brandsSection').html();

    var ajaxLoaderHtml = ajaxLoader();
    $('#brandsSection').html(ajaxLoaderHtml);


    $.ajax({
        url: "/ajax/brands",
        type:"POST",
        data:{
            lang: lang,
            _token: _token
        },
        dataType:"json"
    }).done(function (response) {
        $lang = response.lang;
        $brands = response.filter;
        brandsHtml = '';

        brandsHtml += '<ul>\n';

        for(i in $brands) {
            $filter = filterValues();

            var tempBrandId = -1;
            if($filter['brand']) {
                $brandsUrl = $filter['brand'].split(",");

                for (var j = 0; j < $brandsUrl.length; j++) {
                    if ($brands[i]['id'] === parseInt($brandsUrl[j])) {
                        tempBrandId = $brands[i]['id'];
                    }
                }
            }

            var checkedControl = '';
            if(tempBrandId !== -1){
                checkedControl = 'checked';
            }

            brandsHtml += '<li> \n'+
                '               <div class="form-check contactConsent brandSection"> \n'+
                '                   <input type="checkbox" class="form-check-input checkbox brandOption" id="brandInput'+$brands[i]['id']+'" data-id="'+$brands[i]['id']+'" '+checkedControl+'> \n'+
                '                   <label class="form-check-label" id="brandLabel'+$brands[i]['id']+'" for="brandInput'+$brands[i]['id']+'">'+$brands[i]['name']+'</label> \n'+
                '               </div> \n'+
                '          </li> \n';


        }

        brandsHtml += ' </ul> \n';

        setTimeout(function() {
            $('#brandsSection').html(brandsHtml);
            filter();
            writeDefaultPostValues();
        }, 300);

    }).fail(function (response) {

        counter ++;

        if(counter <= 3){
            showfilterHtml();
        }
        else{
            setTimeout(function() {
                $('#brandsSection').html(brandsHtml);
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

function filter() {
    $('.brandOption').click(function () {

        let _token   = $('meta[name="csrf-token"]').attr('content');
        var lang = $('html').attr('lang');
        var brandStatus = true;
        var brandId = $(this).attr('data-id');
        if($(this).prop('checked') === true) {
            brandStatus = true;
        }
        else if($(this).prop('checked') === false) {
            brandStatus = false;
        }

        $filterData = filterValues();

        $.ajax({
            url: "/ajax/brand",
            type:"POST",
            async: false,
            data:{
                brandId: brandId,
                brandStatus: brandStatus,
                filter: $filterData,
                lang: lang,
                _token: _token
            },
            cache: false,
            dataType:"json"
        }).done(function (response) {
            $url = response.url;

            location.replace($url);
        }).fail(function (response) {

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

    });

    $('#searchPriceButton').click(function (){
        let _token   = $('meta[name="csrf-token"]').attr('content');
        var lang = $('html').attr('lang');

        var minPrice = $('#priceMin').val();
        var maxPrice = $('#priceMax').val();

        if(minPrice === '')
            minPrice = 0;
        if(maxPrice === '')
            maxPrice = '*';

        if(parseInt(minPrice) >= 0 || parseInt(maxPrice) >= 0) {

            if(parseInt(minPrice) > parseInt(maxPrice)){
                var temp = minPrice;
                minPrice = maxPrice;
                maxPrice = temp;
            }

            $filterData = filterValues();

            $.ajax({
                url: "/ajax/price",
                type: "POST",
                async: false,
                data: {
                    minPrice: minPrice,
                    maxPrice: maxPrice,
                    filter: $filterData,
                    lang: lang,
                    _token: _token
                },
                cache: false,
                dataType: "json"
            }).done(function (response) {
                $url = response.url;

                location.replace($url);
            }).fail(function (response) {

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

        }

    });

    $('#sortBox').on('change', function (){
        let _token   = $('meta[name="csrf-token"]').attr('content');
        var lang = $('html').attr('lang');

        var sortOption = $('#sortBox').val();

        $filterData = filterValues();

        $.ajax({
            url: "/ajax/sort",
            type: "POST",
            async: false,
            data: {
                sortOption: sortOption,
                filter: $filterData,
                lang: lang,
                _token: _token
            },
            cache: false,
            dataType: "json"
        }).done(function (response) {
            $url = response.url;

            location.replace($url);
        }).fail(function (response) {

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

    });

}

function writeDefaultPostValues(){

    $(document).ready(function(){
        $filter = filterValues();
        var filtersHtml = ' <ul id="showFiltersArea" class="filterSubProcessBottom"> \n';
        $filterControl = 0;

        var lang = $('html').attr('lang');

        if($filter['search']){
            var searchResultHtml = '';

            if(lang === 'en'){
                searchResultHtml = ' <li>for searching "'+$filter['search']+'"</li> \n';

                $($.parseHTML(searchResultHtml)).appendTo('#searchResultTextId');
            }
            else{
                searchResultHtml = ' <li>"'+$filter['search']+'" araması için</li> \n';

                var currentSearchResultHtml = $('#searchResultTextId').html();

                searchResultHtml += currentSearchResultHtml;

                $('#searchResultTextId').html(searchResultHtml);
            }

            $('#searchInputId').val($filter['search']);
        }
        if($filter['brand']){
            $brandArray = $filter['brand'].split(',');

            for (var k=0; k<$brandArray.length; k++){
                var label = 'brandLabel'+$brandArray[k];
                var brandName = $('#'+label).html();

                filtersHtml += ' <li id="brandFilterBlock'+$brandArray[k]+'">\n' +
                    '                <span>\n' +
                    '                    '+brandName+'\n' +
                    '                </span>\n' +
                    '                <button class="brandFilterButton" data-id="'+$brandArray[k]+'">\n' +
                    '                    <i class="far fa-times"></i>\n' +
                    '                </button>\n' +
                    '            </li> \n';
            }

            $filterControl++;
        }
        if($filter['price']){
            $priceArray = $filter['price'].split('-');
            var priceName = '';

            $minPrice = $priceArray[0];
            $maxPrice = $priceArray[1];

            if($maxPrice === '*'){
                var tempText = '';

                if(lang === 'en')
                    tempText = ' and above';
                else
                    tempText = ' ve üzeri';

                priceName = $minPrice+tempText;
            }
            else{
                priceName = '$'+$minPrice+' - '+'$'+$maxPrice;
            }

            filtersHtml += ' <li id="priceFilterBlock">\n' +
                '                <span>\n' +
                '                    '+priceName+'\n' +
                '                </span>\n' +
                '                <button id="clearPriceFilter">\n' +
                '                    <i class="far fa-times"></i>\n' +
                '                </button>\n' +
                '            </li> \n';

            $filterControl++;
        }
        if($filter['cat']){
            $catId = $filter['cat'];
            $('#cat'+$catId).addClass('active');
        }

        if($filterControl > 0) {
            var lang = $('html').attr('lang');

            var text = '';

            if(lang === 'en')
                text = 'Clear Filters';
            else
                text = 'Filtreleri Temizle';

            filtersHtml += ' <li class="clearFiltersArea">\n' +
                '                <button id="clearAllFilter">\n' +
                '                    '+text+'\n' +
                '                </button>\n' +
                '            </li>' +
                '        </ul> \n';

            $($.parseHTML(filtersHtml)).insertAfter($('#filterTopAreaId'));
        }

        clearFilterFunctions();
    });
}

function clearBrandFilter(brandId){
    $filter = filterValues();

    var lang = $('html').attr('lang');

    var url = '';

    if(lang === 'en')
        url = '/';
    else
        url = '/tr';

    if($filter['search']) {
        url += '?search='+$filter['search'];
    }
    else if($filter['cat']) {
        url += '?cat='+$filter['cat'];
    }

    if($filter['brand']){
        var brandArr = $filter['brand'].split(',');
        var newBrandText = '';

        var firstControl = 0;
        for(var t=0; t<brandArr.length; t++){
            if(parseInt(brandArr[t]) !== parseInt(brandId)) {
                if (firstControl === 0)
                    newBrandText += brandArr[t];
                else
                    newBrandText += ',' + brandArr[t];
                firstControl++;
            }
        }

        if(newBrandText !== '') {
            if ($filter['search'] || $filter['cat'])
                url += '&brand=' + newBrandText;
            else
                url += '?brand=' + newBrandText;
        }
        else{
            url += newBrandText;
        }
    }
    if($filter['sort']) {
        if($filter['search'] !== undefined || $filter['cat'] !== undefined || $filter['brand'] !== undefined)
            url += '&sort='+$filter['sort'];
        else
            url += '?sort='+$filter['sort'];
    }
    if($filter['price']) {
        if($filter['search'] !== undefined || $filter['cat'] !== undefined  || $filter['brand'] !== undefined || $filter['sort'] !== undefined)
            url += '&price='+$filter['price'];
        else
            url += '?price='+$filter['price'];
    }

    location.replace(url);
}

function clearPriceFilter(){
    $filter = filterValues();

    var lang = $('html').attr('lang');

    var url = '';

    if(lang === 'en')
        url = '/';
    else
        url = '/tr';

    if($filter['search']) {
        url += '?search='+$filter['search'];
    }
    else if($filter['cat']) {
        url += '?cat='+$filter['cat'];
    }

    if($filter['brand']){
        if($filter['search'] || $filter['cat'])
            url += '&brand=' + $filter['brand'];
        else
            url += '?brand='+$filter['brand'];
    }
    if($filter['sort']) {
        if($filter['search'] !== undefined || $filter['cat'] !== undefined || $filter['brand'] !== undefined)
            url += '&sort='+$filter['sort'];
        else
            url += '?sort='+$filter['sort'];
    }

    location.replace(url);
}

function clearAllFilters(){
    $filter = filterValues();

    var lang = $('html').attr('lang');

    var url = '';

    if(lang === 'en')
        url = '/';
    else
        url = '/tr';

    if($filter['search']) {
        url += '?search='+$filter['search'];
    }
    else if($filter['cat']) {
        url += '?cat='+$filter['cat'];
    }

    if($filter['sort']) {
        if($filter['search'] || $filter['cat'])
            url += '&sort='+$filter['sort'];
        else
            url += '?sort='+$filter['sort'];
    }

    location.replace(url);
}

function clearFilterFunctions(){
    $('#clearAllFilter').click(function(){
        clearAllFilters();
    });
    $('#clearPriceFilter').click(function(){
        clearPriceFilter();
    });
    $('.brandFilterButton').click(function(){
        var brandId = $(this).attr('data-id');
        clearBrandFilter(brandId);
    });
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

