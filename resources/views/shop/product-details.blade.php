@extends('layouts.general')

@section('metaSeo')
    <title>technoshop | laravel </title>
    <meta name="description" content="technoshop |  laravel">
    <meta name="keywords" content='technoshop | laravel'>
@endsection

@section('styles')
    <link type="text/css" rel="stylesheet" href="{{asset('assets/css/foundation.css')}}">
    <link type="text/css" rel="stylesheet" href="{{asset('assets/css/slick.css')}}">
    <link type="text/css" rel="stylesheet" href="{{asset('assets/css/slick-theme.css')}}">
@endsection

@section('content')

    @include('blocks.sessionControl')
    @include('blocks.scrollToTop')
    @include('blocks.header')

    <input id="productId" value="{{$product[0]['product_id']}}" style="display:none; visibility: hidden;">

    <div class="productBody">
        <div class="leftArea">
            <div class="row">
                <div class="column small-11 small-centered">
                    <div class="cSlider cSlider--single">
                        @foreach($product as $row)
                            <div class="cSlider__item"><section class="sliderSection"><img src="/uploads/{{$row['image_path']}}"></section></div>
                        @endforeach
                    </div>
                    <div class="cSlider cSlider--nav">
                        @foreach($product as $row)
                            <div class="cSlider__item"><section class="sliderSection"><span class="sliderSpan"><img src="/uploads/{{$row['image_path']}}"></span></section></div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="rightArea">
            <ul class="rightSubArea">
                <li>
                    <ol>
                        <li class="threeAreaSection">
                            <div class="brandIconArea">
                                {{$product[0]['brand']}}
                            </div>
                            <div id="stockStatusId" class="stockStatus">

                            </div>

                            <div class="productCommentArea">
                                <ul class="starAvgShow">

                                </ul>
                                <div class="commentCountArea">
                                    ({{$reviewNumber}})
                                </div>
                            </div>

                        </li>
                        <li class="productNameSection">
                            {{$product[0]['name']}}
                        </li>
                        <li id="productPriceId" class="productPriceArea">
                            <div class="productDiscountArea">
                                <div>
                                    <section>
                                        <span>%</span>{{$product[0]['discount_rate']}}
                                    </section>
                                    <span>@lang('message.discount')</span>
                                </div>
                            </div>
                            <div class="priceAreaDetails">
                                <div class="oldPrice">
                                    <section class="dolarIconArea">$</section>
                                    {{number_format($product[0]['old_price'], 2, ',', '.')}}
                                </div>
                                <div class="newPrice">
                                    <section class="dolarIconArea">$</section>
                                    {{number_format($product[0]['price'], 2, ',', '.')}}
                                </div>
                            </div>
                        </li>
                    </ol>
                </li>
                <li class="descriptionArea">
                    <div class="descriptionSubArea">
                        {!! $product[0]['description'] !!}
                    </div>
                </li>
                <li class="productAddBasket">
                    <div class="productCountSection">
                        <div class="number-input">
                            <button class="decreaseButton counterControl" onclick="this.parentNode.querySelector('input[type=number]').stepDown()"></button>
                            <div class="itemArea">
                                <input id="productCount" class="quantity productQuantity" min="1" oninput="validity.valid||(value='1');" name="quantity" value="1" type="number">
                                <span class="itemText">@lang('message.items')</span>
                            </div>
                            <button onclick="this.parentNode.querySelector('input[type=number]').stepUp()" class="plus increaseButton counterControl"></button>
                        </div>
                    </div>
                    <div class="productBasketSection">
                        <button id="addCartButton" class="addBasketButton" title="@lang('message.addToCart')" data-id="{{$product[0]['product_id']}}">
                            <i class="fas fa-shopping-cart"></i>@lang('message.addToCart')
                        </button>
                        <button id="addFavButton" class="addFavoriteButton" title="@lang('message.addToFavorite')" data-id="{{$product[0]['product_id']}}">
                            <i class="far fa-heart"></i>
                        </button>
                    </div>
                </li>
            </ul>
        </div>
    </div>

    <div class="productProperties">
        <div class="card">
            <div class="card-block">
                <ul class="nav nav-tabs  tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" id="technicalSpecificationsTitle" href="#technicalSpecifications" role="tab">@lang('message.productDetails')</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" id="commentsTitle" href="#comments" role="tab">@lang('message.reviews') ({{$reviewNumber}})</a>
                    </li>
                </ul>
                <div class="tab-content tabs card-block">
                    <div class="tab-pane active" id="technicalSpecifications" role="tabpanel">
                        <div class="productDetailPageDetails">
                            {!! $product[0]['detail'] !!}
                        </div>
                    </div>
                    <div class="tab-pane" id="comments" role="tabpanel">
                        <div class="productCommentAreaHead">
                            @if($reviewNumber != 0)
                                <ul class="commentSummary">
                                    <li class="productCommentEachNumber">
                                        <ol>
                                            <li>
                                                <div class="productCommentArea">
                                                    <ul>
                                                        <li class="starFull"><i class="fas fa-star"></i></li>
                                                        <li class="starFull"><i class="fas fa-star"></i></li>
                                                        <li class="starFull"><i class="fas fa-star"></i></li>
                                                        <li class="starFull"><i class="fas fa-star"></i></li>
                                                        <li class="starFull"><i class="fas fa-star"></i></li>
                                                        <li class="commentCountArea">({{$star_5_Number}})</li>
                                                    </ul>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="productCommentArea">
                                                    <ul>
                                                        <li class="starFull"><i class="fas fa-star"></i></li>
                                                        <li class="starFull"><i class="fas fa-star"></i></li>
                                                        <li class="starFull"><i class="fas fa-star"></i></li>
                                                        <li class="starFull"><i class="fas fa-star"></i></li>
                                                        <li class="starEmpty"><i class="fas fa-star"></i></li>
                                                        <li class="commentCountArea">({{$star_4_Number}})</li>
                                                    </ul>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="productCommentArea">
                                                    <ul>
                                                        <li class="starFull"><i class="fas fa-star"></i></li>
                                                        <li class="starFull"><i class="fas fa-star"></i></li>
                                                        <li class="starFull"><i class="fas fa-star"></i></li>
                                                        <li class="starEmpty"><i class="fas fa-star"></i></li>
                                                        <li class="starEmpty"><i class="fas fa-star"></i></li>
                                                        <li class="commentCountArea">({{$star_3_Number}})</li>
                                                    </ul>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="productCommentArea">
                                                    <ul>
                                                        <li class="starFull"><i class="fas fa-star"></i></li>
                                                        <li class="starFull"><i class="fas fa-star"></i></li>
                                                        <li class="starEmpty"><i class="fas fa-star"></i></li>
                                                        <li class="starEmpty"><i class="fas fa-star"></i></li>
                                                        <li class="starEmpty"><i class="fas fa-star"></i></li>
                                                        <li class="commentCountArea">({{$star_2_Number}})</li>
                                                    </ul>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="productCommentArea">
                                                    <ul>
                                                        <li class="starFull"><i class="fas fa-star"></i></li>
                                                        <li class="starEmpty"><i class="fas fa-star"></i></li>
                                                        <li class="starEmpty"><i class="fas fa-star"></i></li>
                                                        <li class="starEmpty"><i class="fas fa-star"></i></li>
                                                        <li class="starEmpty"><i class="fas fa-star"></i></li>
                                                        <li class="commentCountArea">({{$star_1_Number}})</li>
                                                    </ul>
                                                </div>
                                            </li>
                                        </ol>
                                    </li>
                                    <li class="productCommentAverage">
                                        <div class="averageNumber">{{$starAvg}}</div>
                                        <div class="averageStar">
                                            <ul class="starAvgShow">

                                            </ul>
                                        </div>
                                        <div class="reviewsAndCommentsNumber">
                                            <section>
                                                {{$reviewNumber}} Reviews
                                            </section>
                                            <section>
                                                {{$commentNumber}} Comments
                                            </section>
                                        </div>
                                    </li>
                                    <li class="commentsProductImage">
                                        <img src="/uploads/{{$product[0]['image_path']}}">
                                    </li>
                                </ul>
                            @endif
                            <ul id="productDetailComments" class="theAllComments">

                            </ul>
                            <div id="paginationMoreComment" class="paginationArea">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('blocks.footer')

@endsection

@section('scripts')
    <script type="text/javascript" src="{{asset('assets/js/modernizr.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/jquery.validationEngine.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/slick.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/slickSlider.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/common-pages.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/privateJs/addCart.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/privateJs/addRemoveFavorite.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/privateJs/showFavoriteStatus.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/moment.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/privateJs/showReview.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/privateJs/showStarAvg.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/privateJs/stockControl.js')}}"></script>
    <script>
        productDetailUploadAjaxLoader();
    </script>
@endsection






















