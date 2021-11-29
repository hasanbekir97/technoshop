@extends('layouts.general')

@section('metaSeo')
    <title>technoshop | laravel </title>
    <meta name="description" content="technoshop |  laravel">
    <meta name="keywords" content='technoshop | laravel'>
@endsection

@section('content')

    @include('blocks.sessionControl')
    @include('blocks.header')


    <div class="loginHeadArea">
        <div class="loginSubArea">

            <div class="mb-4 text-sm text-gray-600 infoText">
                @lang('message.verificationEmailText')
            </div>

            @if (Session::has('message'))
                <div class="alert alert-success" role="alert">
                    {{ Session::get('message') }}
                </div>
            @endif

            <x-jet-validation-errors class="mb-4" />

            <div class="mt-4 flex items-center justify-between verifyEmailTwoButtonSection">
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf

                    <div class="verifyEmailSubmitButton">
                        <button type="submit">
                            @lang('message.resendVerificationEmail')
                        </button>
                    </div>
                </form>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900 verifyEmailTextButton">
                        @lang('message.logout')
                    </button>
                </form>
            </div>
        </div>
    </div>


    @include('blocks.footer')

@endsection
