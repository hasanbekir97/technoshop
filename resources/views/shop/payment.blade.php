@extends('layouts.general')

@section('metaSeo')
    <title>technoshop | laravel </title>
    <meta name="description" content="technoshop |  laravel">
    <meta name="keywords" content='technoshop | laravel'>
@endsection

@section('styles')
    <link rel="stylesheet" href="{{asset('assets/css/foundation.css')}}">
@endsection

@section('content')

    @include('blocks.sessionControl')
    @include('blocks.scrollToTop')
    @include('blocks.header')

    <form id="deliveryAddressForm">
        <div class="basketBody paymentPage">
            <div class="leftArea">
                <div class="title">
                    <section><i class="fal fa-map-marker-alt"></i> @lang('message.deliveryAddress')</section>
                </div>
                <div class="deliveryAddressFormArea">

                    <div class="row inputsArea">
                        <div class="col-lg-6 inputArea">
                            <label for="country" class="block font-medium text-sm text-gray-700">@lang('message.country')</label>
                            <input id="country" type="text" class="mt-1 block w-full" value="@php if(isset($userInformation[0])) { echo $userInformation[0]['country']; } @endphp">
                            <div class="errorMessageArea">
                                <span class="text-danger" id="countryErrorMsg"></span>
                            </div>
                        </div>

                        <div class="col-lg-6 inputArea">
                            <label for="city" class="block font-medium text-sm text-gray-700">@lang('message.city')</label>
                            <input id="city" type="text" class="mt-1 block w-full" value="@php if(isset($userInformation[0])) { echo $userInformation[0]['city']; } @endphp">
                            <div class="errorMessageArea">
                                <span class="text-danger" id="cityErrorMsg"></span>
                            </div>
                        </div>

                        <div class="col-lg-6 inputArea">
                            <label for="county" class="block font-medium text-sm text-gray-700">@lang('message.county')</label>
                            <input id="county" type="text" class="mt-1 block w-full" value="@php if(isset($userInformation[0])) { echo $userInformation[0]['county']; } @endphp">
                            <div class="errorMessageArea">
                                <span class="text-danger" id="countyErrorMsg"></span>
                            </div>
                        </div>

                        <div class="col-lg-6 inputArea">
                            <label for="phone" class="block font-medium text-sm text-gray-700">@lang('message.phone')</label>
                            <input id="phone" type="number" class="mt-1 block w-full" value="@php if(isset($userInformation[0])) { echo $userInformation[0]['phone']; } @endphp">
                            <div class="errorMessageArea">
                                <span class="text-danger" id="phoneErrorMsg"></span>
                            </div>
                        </div>

                        <div class="col-lg-12 inputArea">
                            <label for="address" class="block font-medium text-sm text-gray-700">@lang('message.address')</label>
                            <textarea id="address" class="mt-1 block w-full">@php if(isset($userInformation[0])) { echo $userInformation[0]['address']; } @endphp</textarea>
                            <div class="errorMessageArea">
                                <span class="text-danger" id="addressErrorMsg"></span>
                            </div>
                        </div>

                        <div class="col-lg-12 inputArea">
                            <section class="mr-3 alertMessageArea">
                                @lang('message.informationSaved')
                            </section>
                        </div>
                    </div>

                </div>
            </div>
            <div class="rightArea">
                <div class="title">@lang('message.orderSummary')</div>
                <ul class="subArea">
                    @if(App::getLocale() === 'en')
                        <li class="itemTotal">{{$totalItem}} item in total</li>
                    @else
                        <li class="itemTotal">Toplam {{$totalItem}} ürün</li>
                    @endif
                    <li class="productPriceTotal">
                        <span>@lang('message.subTotal')</span>
                        <span>
                        <div class="priceAreaDetails">
                            <div class="newPrice">
                                <section class="dolarIconArea">$</section>
                                @php echo number_format($totalProductPrice, 2, ',', '.'); @endphp
                            </div>
                        </div>
                    </span>
                    </li>
                    <li class="productPriceTotal cargoPriceArea">
                        <span>@lang('message.cargoPrice')</span>
                        <span>
                        <div class="priceAreaDetails">
                            <div class="newPrice">
                                <section class="dolarIconArea">$</section>
                                @php echo number_format($totalCargoPrice, 2, ',', '.'); @endphp
                            </div>
                        </div>
                    </span>
                    </li>
                    <li class="totalPrice">
                        <span>@lang('message.total')</span>
                        <span>
                        <div class="priceAreaDetails">
                            <div class="newPrice">
                                <section class="dolarIconArea">$</section>
                                @php echo number_format($summaryPrice, 2, ',', '.'); @endphp
                            </div>
                        </div>
                    </span>
                    </li>
                    <li class="completeOrderButtonArea">
                        <button id="order" type="submit" class="completeButton">
                            @lang('message.orderNow')
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    </form>

    @include('blocks.footer')

@endsection

@section('scripts')
    <script type="text/javascript" src="{{asset('assets/js/privateJs/payment.js')}}"></script>
@endsection


