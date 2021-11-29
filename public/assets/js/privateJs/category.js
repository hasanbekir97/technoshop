
categoryHtml();
category();

function categoryHtml(){

    let _token   = $('meta[name="csrf-token"]').attr('content');
    var lang = $('html').attr('lang');

    $.ajax({
        url: "/ajax/categories",
        type: "POST",
        async: false,
        data:{
            lang: lang,
            _token: _token
        },
        cache: false,
        dataType:"json"
    }).done(function (response) {
        $data = response.data;
        var categoryHtml = '';

        categoryHtml += ' <ul>\n' ;

        for(var k=0; k<$data.length; k++) {
            if(k === ($data.length-1)) {
                categoryHtml += ' <li><a id="cat'+$data[k]['id']+'" href="javascript:void(0)" class="categoryButton" data-id="'+$data[k]['id']+'"><div><section>'+$data[k]['name']+'</section></div></a></li>\n';
            }
            else{
                categoryHtml += ' <li><a id="cat'+$data[k]['id']+'" href="javascript:void(0)" class="categoryButton" data-id="'+$data[k]['id']+'"><div><section>'+$data[k]['name']+'</section></div></a></li>\n' +
                    '             <li class="hrArea"><section></section></li>\n';
            }
        }

        categoryHtml += ' </ul> \n';

        $('#headerCategoryId').html(categoryHtml);

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

function category(){

    $('.categoryButton').click(function () {

        let _token   = $('meta[name="csrf-token"]').attr('content');
        var lang = $('html').attr('lang');
        var categoryId = $(this).attr('data-id');

        $.ajax({
            url: "/ajax/category",
            type:"POST",
            async: false,
            data:{
                categoryId: categoryId,
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

}
