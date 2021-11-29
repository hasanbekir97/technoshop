@extends('layouts.general')

@section('metaSeo')
    <title>technoshop | laravel </title>
    <meta name="description" content="technoshop |  laravel">
    <meta name="keywords" content='technoshop | laravel'>
@endsection

@section('content')

    @include('blocks.sessionControl')
    @include('blocks.scrollToTop')
    @include('blocks.header')

    <div class="orderResultPage">
        <div class="successfulOrder">
            <i class="fas fa-check-circle"></i>
            <h1>@lang('message.orderConfirmedTitle')</h1>
            <h4>@lang('message.orderConfirmedText')</h4>
            <div class="buttonsArea">
                <a class="shopping" href="{{ LaravelLocalization::getURLFromRouteNameTranslated(App::getLocale(), 'routes./') }}">
                    @lang('message.continueShopping')
                </a>
                <a class="order" href="{{route('profile.user-account')}}#my-orders">
                    @lang('message.viewOrder')
                </a>
            </div>
        </div>
    </div>

    @include('blocks.footer')

@endsection

@section('scripts')
    <script type="text/javascript" src="{{asset('assets/js/privateJs/showCart.js')}}"></script>
@endsection


