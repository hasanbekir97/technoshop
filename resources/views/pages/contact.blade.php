@extends('layouts.general')

@section('metaSeo')
    <title>technoshop | contact </title>
    <meta name="description" content="technoshop |  laravel">
    <meta name="keywords" content='technoshop | laravel'>
@endsection


@section('content')

    @include('blocks.sessionControl')
    @include('blocks.scrollToTop')
    @include('blocks.header')

    <div class="contactArea">
        <div class="contactNameArea">
            @lang('message.contactUs')
        </div>

        <form id="contactForm" autocomplete="off">

            @csrf

            <div class="alert alert-success" role="alert" id="successMsg" style="display: none" >
                @lang('message.sentMessageSuccess')
            </div>

            <div class="input-group">
                <label for="name">@lang('message.nameSurname')</label>
                <input type="text" id="name" class="form-control"/>
                <div class="errorMessageArea">
                    <span class="text-danger" id="nameErrorMsg"></span>
                </div>
            </div>
            <div class="input-group">
                <label for="email">@lang('message.email')</label>
                <input type="text" id="email" class="form-control"/>
                <div class="errorMessageArea">
                    <span class="text-danger" id="emailErrorMsg"></span>
                </div>
            </div>
            <div class="input-group">
                <label for="phone">@lang('message.phone')</label>
                <input type="number" id="phone" class="form-control"/>
            </div>
            <div class="input-group">
                <label for="message">@lang('message.message')</label>
                <textarea type="text" id="message" class="form-control" rows="4"></textarea>
                <div class="errorMessageArea">
                    <span class="text-danger" id="messageErrorMsg"></span>
                </div>
            </div>
            <div class="input-group consentDeclarationArea">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input checkbox" name="agree" id="agree">
                    <label class="form-check-label" for="agree">@lang('message.checkboxText')</label>
                    <div class="errorMessageArea">
                        <span class="text-danger" id="agreeErrorMsg"></span>
                    </div>
                </div>
            </div>

            <div class="buttonArea">
                <button type="submit" class="generalButton">
                    @lang('message.send')
                </button>
            </div>

        </form>
    </div>

    @include('blocks.footer')

@endsection

@section('scripts')

    <script type="text/javascript" src="{{asset('assets/js/privateJs/contact.js')}}"></script>
@endsection


