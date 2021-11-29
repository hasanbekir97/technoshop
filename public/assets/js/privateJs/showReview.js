var counter = 0;

allComment(0);

function loadMoreComment(pagenum) {
    allComment(pagenum);
}

function allComment (pageNum){
    let _token   = $('meta[name="csrf-token"]').attr('content');
    var lang = $('html').attr('lang');
    var productId = $('#productId').val();
    var commentsHtml = $('#productDetailComments').html();
    var moreCommentHtml = $('#paginationMoreComment').html();

    var ajaxLoaderHtml = ajaxLoader();
    $('#paginationMoreComment').html(ajaxLoaderHtml);


    $.ajax({
        url: "/ajax/comments",
        type:"POST",
        data:{
            productId: productId,
            pageNum: pageNum,
            lang: lang,
            _token: _token
        },
        dataType:"json"
    }).done(function (response) {
        $comments = response.comments;
        $commentImages = response.commentImages;
        commentsHtml = '';
        moreCommentHtml = '';

        for(i in $comments) {

            let date = new Date($comments[i]['created_at']);
            let formattedDate = moment(date).format('DD MMMM YYYY');

            commentsHtml += ' <li class="eachComment">\n' +
                '                 <div class="commentTop">\n' +
                '                     <ol class="commentHeadTitleArea">\n' +
                '                         <li class="productCommentArea">\n' +
                '                             <ul>\n';

                            for($j=0; $j<$comments[i]['star']; $j ++){
                                commentsHtml += ' <li class="starFull"><i class="fas fa-star"></i></li>\n' ;
                            }
                            for($j=0; $j<(5-$comments[i]['star']); $j ++){
                                commentsHtml += ' <li class="starEmpty"><i class="fas fa-star"></i></li>\n' ;
                            }

            commentsHtml += '                     <li class="customerName">'+$comments[i]['user_name']+'</li>\n' +
                '                             </ul>\n' +
                '                         </li>\n' +
                '                         <li class="commentDate">\n' +
                '                             '+formattedDate+'\n' +
                '                         </li>\n' +
                '                     </ol>\n' +
                '                 </div>\n' +
                '                 <div class="commentBottom">\n' +
                '                     <div class="commentDetail">\n' +
                '                         '+$comments[i]['comment']+'\n' +
                '                     </div>\n' +
                '                 </div>\n' +
                '             </li> \n';
        }

        pageNum = parseInt(pageNum) + 1;

        var moreReviewsText = '';

        if(lang === 'en')
            moreReviewsText = 'More Review';
        else
            moreReviewsText = 'Daha Fazla Değerlendirme';

        moreCommentHtml += ' <a type=button onclick="loadMoreComment('+pageNum+')">\n' +
            '                       '+moreReviewsText+'\n' +
            '                   </a> \n';

        setTimeout(function() {
            $('#paginationMoreComment').html(moreCommentHtml);
        }, 300);


        $uploadedCommentNumber = response.uploadedCommentNumber;
        $uploadLimitNumber = response.uploadLimitNumber;

        if($uploadedCommentNumber <= $uploadLimitNumber){
            $('#paginationMoreComment').remove();
        }

        $($.parseHTML(commentsHtml)).appendTo('#productDetailComments');

        // if the comment is empty
        if($comments.length === 0){
            var noCommentText = '';

            if(lang === 'en')
                noCommentText = 'There aren\'t comments yet.';
            else
                noCommentText = 'Henüz yorum yok.';

            commentsHtml = ' <div class="emptyCommentArea">\n' +
                '                <div class="iconArea">\n' +
                '                   <i class="fas fa-heart"></i>\n' +
                '                </div>\n' +
                '                <div class="title">'+noCommentText+'</div>\n' +
                '            </div> \n';

            $('#productDetailComments').html(commentsHtml);
        }

    }).fail(function (response) {

        counter ++;

        if(counter <= 3){
            $('#productDetailComments').html(commentsHtml);
            allComment(pageNum);
        }
        else{
            $('#productDetailComments').html(commentsHtml);

            setTimeout(function() {
                $('#paginationMoreComment').html(moreCommentHtml);
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

