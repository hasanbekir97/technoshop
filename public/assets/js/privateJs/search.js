
search();

function search(){

    $('#searchButtonId').click(function () {

        let _token   = $('meta[name="csrf-token"]').attr('content');
        var lang = $('html').attr('lang');
        var search = $('#searchInputId').val();

        $.ajax({
            url: "/ajax/search",
            type:"POST",
            async: false,
            data:{
                search: search,
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

    $('#searchInputId').keydown(function(event){
        if(event.keyCode == 13) {
            event.preventDefault();

            let _token   = $('meta[name="csrf-token"]').attr('content');
            var lang = $('html').attr('lang');
            var search = $('#searchInputId').val();

            $.ajax({
                url: "/ajax/search",
                type:"POST",
                async: false,
                data:{
                    search: search,
                    lang: lang,
                    _token: _token
                },
                cache: false,
                dataType:"json"
            }).done(function (response) {
                $url = response.url;

                window.location.href = $url;
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

            event.stopImmediatePropagation();
        }
    });
}
