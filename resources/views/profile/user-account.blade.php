@extends('layouts.general')

@section('metaSeo')
    <title>technoshop | laravel </title>
    <meta name="description" content="technoshop |  laravel">
    <meta name="keywords" content='technoshop | laravel'>
@endsection

@section('styles')
    <link rel="stylesheet" href="{{asset('assets/css/foundation.css')}}">
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    @livewireStyles
@endsection

@section('content')

    @include('blocks.sessionControl')
    @include('blocks.scrollToTop')
    @include('blocks.header')

    <div class="myAccountPage">
        <div class="tabArea">
            <div class="tabTitleArea">
                <div class="title">@lang('message.myAccount')</div>
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a id="ordersLink" class="nav-link" data-toggle="tab" href="#orders" role="tab">
                            <span>
                                <i class="far fa-dolly-flatbed-alt"></i> @lang('message.myOrders')
                            </span>
                            <i class="far fa-chevron-right"></i>
                        </a>
                    </li>
                    <li class="borderArea"></li>
                    <li class="nav-item">
                        <a id="favoritesLink" class="nav-link" data-toggle="tab" href="#favorites" role="tab">
                            <span>
                                <i class="far fa-heart"></i> @lang('message.myFavorites')
                            </span>
                            <i class="far fa-chevron-right"></i>
                        </a>
                    </li>
                    <li class="borderArea"></li>
                    <li class="nav-item">
                        <a id="commentsLink" class="nav-link" data-toggle="tab" href="#comments" role="tab">
                            <span>
                                <i class="far fa-comment-alt-dots"></i> @lang('message.myReviews')
                            </span>
                            <i class="far fa-chevron-right"></i>
                        </a>
                    </li>
                    <li class="borderArea"></li>
                    <li class="nav-item">
                        <a id="userAddressLink" class="nav-link" data-toggle="tab" href="#userAddress" role="tab">
                            <span>
                                <i class="far fa-map-marker-alt"></i> @lang('message.myAddress')
                            </span>
                            <i class="far fa-chevron-right"></i>
                        </a>
                    </li>
                    <li class="borderArea"></li>
                    <li class="nav-item">
                        <a id="userInformationsLink" class="nav-link active" data-toggle="tab" href="#userInformations" role="tab">
                            <span>
                                <i class="far fa-user"></i> @lang('message.myUserInformation')
                            </span>
                            <i class="far fa-chevron-right"></i>
                        </a>
                    </li>
                    <li class="borderArea"></li>
                    <li class="nav-item">
                        <a id="updatePasswordLink" class="nav-link" data-toggle="tab" href="#updatePassword" role="tab">
                            <span>
                                <i class="far fa-user-edit"></i> @lang('message.updatePassword')
                            </span>
                            <i class="far fa-chevron-right"></i>
                        </a>
                    </li>
                    <li class="borderArea"></li>
                    <li class="nav-item">
                        <a id="ApiLink" class="nav-link" data-toggle="tab" href="#Api" role="tab">
                            <span>
                                <i class="far fa-key"></i> API
                            </span>
                            <i class="far fa-chevron-right"></i>
                        </a>
                    </li>
                    <li class="borderArea"></li>
                    <li class="nav-item">
                        <a id="deleteAccountLink" class="nav-link" data-toggle="tab" href="#deleteAccount" role="tab">
                            <span>
                                <i class="far fa-user-times"></i> @lang('message.deleteAccount')
                            </span>
                            <i class="far fa-chevron-right"></i>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="tabContentArea">
                <div class="tab-content">
                    <div class="tab-pane" id="orders" role="tabpanel">
                        <div id="ordersTitle" class="gridTitle">
                            @lang('message.myOrders')
                        </div>
                        <div class="gridBody">
                            <div id="userOrders" role="tablist" aria-multiselectable="true">

                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="favorites" role="tabpanel">
                        <div class="gridBody">
                            <div id="favoritePage" class="favouriteHeadArea">

                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="comments" role="tabpanel">
                        <div id="commentsTitle" class="gridTitle">
                            @lang('message.myReviews')
                        </div>
                        <div class="gridBody">
                            <div class="commentsHeadArea">
                                <ul id="userComments" class="theAllComments">

                                </ul>
                                <div id="paginationMoreReview" class="paginationArea">

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="userAddress" role="tabpanel">
                        <div class="gridTitle">
                            @lang('message.myAddress')
                        </div>
                        <div class="gridBody">
                            <div class="userInformationArea">
                                <div class="mt-10 sm:mt-0">
                                    <form id="addressForm">

                                        <div class="inputsArea">
                                            <div class="inputArea">
                                                <label for="country" class="block font-medium text-sm text-gray-700">@lang('message.country')</label>
                                                <input id="country" type="text" class="mt-1 block w-full" value="@php if(isset($addressInformation[0])) { echo $addressInformation[0]['country']; } @endphp"/>
                                                <div class="errorMessageArea">
                                                    <span class="text-danger" id="countryErrorMsg"></span>
                                                </div>
                                            </div>

                                            <div class="inputArea">
                                                <label for="city" class="block font-medium text-sm text-gray-700">@lang('message.city')</label>
                                                <input id="city" type="text" class="mt-1 block w-full" value="@php if(isset($addressInformation[0])) { echo $addressInformation[0]['city']; } @endphp"/>
                                                <div class="errorMessageArea">
                                                    <span class="text-danger" id="cityErrorMsg"></span>
                                                </div>
                                            </div>

                                            <div class="inputArea">
                                                <label for="county" class="block font-medium text-sm text-gray-700">@lang('message.county')</label>
                                                <input id="county" type="text" class="mt-1 block w-full" value="@php if(isset($addressInformation[0])) { echo $addressInformation[0]['county']; } @endphp"/>
                                                <div class="errorMessageArea">
                                                    <span class="text-danger" id="countyErrorMsg"></span>
                                                </div>
                                            </div>

                                            <div class="inputArea">
                                                <label for="address" class="block font-medium text-sm text-gray-700">@lang('message.address')</label>
                                                <textarea id="address" class="mt-1 block w-full">@php if(isset($addressInformation[0])) { echo $addressInformation[0]['address']; } @endphp</textarea>
                                                <div class="errorMessageArea">
                                                    <span class="text-danger" id="addressErrorMsg"></span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="addressButtonArea">
                                            <div class="headMessageArea">
                                                <section class="mr-3 alertMessageArea">
                                                    @lang('message.informationSaved')
                                                </section>
                                            </div>
                                            <div class="subButtonArea">
                                                <button type="submit" class="generalButton">
                                                    @lang('message.save')
                                                </button>
                                            </div>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane active" id="userInformations" role="tabpanel">
                        <div class="gridTitle">
                            @lang('message.myUserInformation')
                        </div>
                        <div class="gridBody">
                            <x-app-layout>
                                <div class="userInformationArea">
                                    @if (Laravel\Fortify\Features::canUpdateProfileInformation())
                                        <div class="mt-10 sm:mt-0">
                                            @livewire('profile.update-profile-information-form')
                                        </div>
                                    @endif
                                </div>
                            </x-app-layout>
                        </div>
                    </div>
                    <div class="tab-pane" id="updatePassword" role="tabpanel">
                        <div class="gridTitle">
                            @lang('message.updatePassword')
                        </div>
                        <div class="gridBody">
                            <x-app-layout>
                                <div class="updatePasswordArea">
                                    @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
                                        <div class="mt-10 sm:mt-0">
                                            @livewire('profile.update-password-form')
                                        </div>
                                    @endif
                                </div>
                            </x-app-layout>
                        </div>
                    </div>
                    <div class="tab-pane" id="Api" role="tabpanel">
                        <div class="gridTitle">
                            API
                        </div>
                        <div class="gridBody">
                            <div class="infoStructure">
                                <h1>Documentation</h1>
                                <hr>
                                <p>You can look for <a href="#">documentation</a> for our API structure.</p>
                            </div>
                            <div id="apiKeyArea" class="infoStructure">
                                <h1>Request an API Key</h1>
                                <hr>
                                <p>To generate a new API key, <a id="requestApiKey" href="javascript:void(0)" onclick="generateApiKey()">click here</a>.</p>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="deleteAccount" role="tabpanel">
                        <div class="gridTitle">
                            @lang('message.deleteAccount')
                        </div>
                        <div class="gridBody">
                            <x-app-layout>
                                @if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures())
                                    <div class="mt-10 sm:mt-0">
                                        @livewire('profile.delete-user-form')
                                    </div>
                                @endif
                            </x-app-layout>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Delivery Address Modal -->
    <div class="modal fade bd-example-modal-lg" id="deliveryAddress" tabindex="-1" role="dialog" aria-labelledby="deliveryAddressTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deliveryAddressTitle">Delivery Address</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div id="userDeliveryAddressModal" class="deliveryAddressFormArea">

                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Ok</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Review Modal -->
    <div class="modal fade bd-example-modal-lg" id="review" tabindex="-1" role="dialog" aria-labelledby="reviewTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div id="reviewModal" class="modal-content">
                <form id="reviewFormArea" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="reviewTitle">How did you find the product?</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div id="reviewModalAjaxLoader" class="reviewFormArea">

                        </div>

                    </div>
                    <div class="modal-footer reviewFormModalFooter">
                        <button type="submit" id="reviewSaveButton" class="btn btn-secondary saveButton" disabled>SAVE</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    @include('blocks.footer')

@endsection


@section('scripts')
    <script type="text/javascript" src="{{asset('assets/js/privateJs/userFavorite.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/privateJs/userAddress.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/moment.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/privateJs/userOrder.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/privateJs/userReview.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/privateJs/emailVerifyControl.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/privateJs/api.js')}}"></script>
    <script src="{{ mix('js/app.js') }}" defer></script>
    @livewireScripts
    <script>
        $(document).ready(function(){
            $url = window.location.href;
            $newUrl = $url.split("#");
            $targetTabPane = String($newUrl[1]);
            if($targetTabPane === 'my-favorites'){
                $('#userInformationsLink').removeClass('active');
                $('#favoritesLink').addClass('active');

                $('#userInformations').removeClass('active');
                $('#favorites').addClass('active');
            }
            else if($targetTabPane === 'my-reviews'){
                $('#userInformationsLink').removeClass('active');
                $('#commentsLink').addClass('active');

                $('#userInformations').removeClass('active');
                $('#comments').addClass('active');
            }
            else if($targetTabPane === 'my-orders'){
                $('#userInformationsLink').removeClass('active');
                $('#ordersLink').addClass('active');

                $('#userInformations').removeClass('active');
                $('#orders').addClass('active');
            }
        });
        $('#headerOrderLink').click(function(){
            $('#favoritesLink').removeClass('active');
            $('#commentsLink').removeClass('active');
            $('#userInformationsLink').removeClass('active');
            $('#updatePasswordLink').removeClass('active');
            $('#deleteAccountLink').removeClass('active');
            $('#ordersLink').addClass('active');

            $('#favorites').removeClass('active');
            $('#comments').removeClass('active');
            $('#userInformations').removeClass('active');
            $('#updatePassword').removeClass('active');
            $('#deleteAccount').removeClass('active');
            $('#orders').addClass('active');
        });
        $('#headerFavoriteLink').click(function(){
            $('#ordersLink').removeClass('active');
            $('#commentsLink').removeClass('active');
            $('#userInformationsLink').removeClass('active');
            $('#updatePasswordLink').removeClass('active');
            $('#deleteAccountLink').removeClass('active');
            $('#favoritesLink').addClass('active');

            $('#orders').removeClass('active');
            $('#comments').removeClass('active');
            $('#userInformations').removeClass('active');
            $('#updatePassword').removeClass('active');
            $('#deleteAccount').removeClass('active');
            $('#favorites').addClass('active');
        });
        $('#headerCommentLink').click(function(){
            $('#ordersLink').removeClass('active');
            $('#favoritesLink').removeClass('active');
            $('#userInformationsLink').removeClass('active');
            $('#updatePasswordLink').removeClass('active');
            $('#deleteAccountLink').removeClass('active');
            $('#commentsLink').addClass('active');

            $('#orders').removeClass('active');
            $('#favorites').removeClass('active');
            $('#userInformations').removeClass('active');
            $('#updatePassword').removeClass('active');
            $('#deleteAccount').removeClass('active');
            $('#comments').addClass('active');
        });
    </script>
@endsection
