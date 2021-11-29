
var counter = 0;

userReview(0);

function loadMoreReview(pagenum) {
    userReview(pagenum);
}

function userReview(pageNum){
    let _token   = $('meta[name="csrf-token"]').attr('content');
    var lang = $('html').attr('lang');

    var reviews = $('#userComments').html();
    var moreReviewHtml = $('#paginationMoreReview').html();

    var ajaxLoaderHtml = ajaxLoader();
    $('#paginationMoreReview').html(ajaxLoaderHtml);

    $.ajax({
        url: "/ajax/showReview",
        type:"POST",
        data:{
            lang: lang,
            pageNum: pageNum,
            _token: _token
        },
        dataType:"json"
    }).done(function (response) {

        $reviews = response.reviews;
        $reviewImages = response.reviewImages;
        reviews = '';
        moreReviewHtml = '';

        for(i in $reviews) {

            let date = new Date($reviews[i]['created_at']);
            let formattedDate = moment(date).format('DD MMMM YYYY');

            let comment = '';

            if($reviews[i]['comment'] !== null){
                comment = $reviews[i]['comment'];
            }

            var url_slug = '';

            if(lang === 'en')
                url_slug = '/product/'+$reviews[i]['slug'];
            else if(lang === 'tr')
                url_slug = 'tr/urun/'+$reviews[i]['slug'];

            reviews += ' <li class="eachComment"> \n' +
                '            <div class="leftArea">\n' +
                '                <a href="'+url_slug+'">\n' +
                '                    <img src="/uploads/'+$reviews[i]['image_path']+'" alt="">\n' +
                '                </a>\n' +
                '            </div>\n' +
                '            <div class="rightArea">\n' +
                '                <div class="commentTop">\n' +
                '                    <ol class="commentHeadTitleArea">\n' +
                '                        <li class="productCommentArea">\n' +
                '                            <ul>\n' ;

                                for($j=0; $j<$reviews[i]['star']; $j ++){
                                    reviews += ' <li class="starFull"><i class="fas fa-star"></i></li>\n' ;
                                }
                                for($j=0; $j<(5-$reviews[i]['star']); $j ++){
                                    reviews += ' <li class="starEmpty"><i class="fas fa-star"></i></li>\n' ;
                                }

            reviews += '                         <li class="customerName">'+$reviews[i]['user_name']+'</li>\n' +
                '                            </ul>\n' +
                '                        </li>\n' +
                '                        <li class="commentDate">\n' +
                '                            '+formattedDate+'\n' +
                '                        </li>\n' +
                '                    </ol>\n' +
                '                </div>\n' +
                '                <div class="commentBottom">\n' +
                '                    <div class="commentDetail">\n' +
                '                        '+comment+'\n' +
                '                    </div>\n' +
                '                </div>\n' +
                '            </div>\n' +
                '        </li> \n' ;

        }


        pageNum = parseInt(pageNum) + 1;

        var moreReviewsText = '';

        if(lang === 'en') {
            moreReviewsText = 'More Reviews';
        }
        else {
            moreReviewsText = 'Daha Fazla Değerlendirme';
        }

        moreReviewHtml += ' <a type=button onclick="loadMoreReview('+pageNum+')">\n' +
            '                       '+moreReviewsText+'\n' +
            '                   </a> \n';

        setTimeout(function() {
            $('#paginationMoreReview').html(moreReviewHtml);
        }, 300);


        $uploadedReviewNumber = response.uploadedReviewNumber;
        $uploadLimitNumber = response.uploadLimitNumber;

        if($uploadedReviewNumber === $uploadLimitNumber){
            $('#paginationMoreReview').remove();
        }


        if(pageNum === 1)
            $('#userComments').html(reviews);
        else
            $($.parseHTML(reviews)).appendTo('#userComments');


        // if the comment is empty
        if($reviews.length === 0){

            var reviewEmptyTitle = '';
            var reviewEmptyText = '';

            if(lang === 'en') {
                reviewEmptyTitle = 'You didn\'t review yet.';
                reviewEmptyText = 'You can review the product if you bought the product.';
            }
            else {
                reviewEmptyTitle = 'Henüz değerlendirme yapmadınız.';
                reviewEmptyText = 'Eğer ürünü satın aldıysanız değerlendirme yapabilirsiniz.';
            }

            reviews = ' <div class="emptyCommentArea">\n' +
                '            <div class="iconArea">\n' +
                '               <i class="fas fa-comment-alt-dots"></i>\n' +
                '            </div>\n' +
                '            <div class="title">'+reviewEmptyTitle+'</div>\n' +
                '            <div class="text">'+reviewEmptyText+'</div>\n' +
                '        </div> \n';

            $('#commentsTitle').remove();
            $('#userComments').html(reviews);
        }

    }).fail(function (response) {

        counter ++;

        if(counter <= 3){
            $('#userComments').html(reviews);
            userReview(pageNum);
        }
        else{
            $('#userComments').html(reviews);

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

$('#commentsLink').click(function (){
    userReview(0);
});
