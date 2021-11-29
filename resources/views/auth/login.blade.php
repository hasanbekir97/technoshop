


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
        <div class="row m-b-20">
            <div class="col-md-12">
                <h3 class="text-left txt-primary">@lang('message.login')</h3>
            </div>
        </div>
        <hr/>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <form class="formArea" method="POST" action="{{ route('login') }}">
            @csrf

            <div class="input-group">
                <label for="email" >@lang('message.email')</label>
                <input id="email" class="form-control" type="text" name="email" value="{{old('email')}}" autofocus/>
            </div>
            <div class="input-group">
                <label for="password" >@lang('message.password')</label>
                <input id="password" class="form-control" type="password" name="password" autocomplete="current-password"/>
                <a id="showPassword">
                    <i class="far fa-eye-slash"></i>
                </a>
            </div>
            <div class="input-group">
                <div class="loginAreaTwoText">
                    <a class="forgetPasswordText" href="{{ route('register') }}">@lang('message.signup')</a>
                    <a class="forgetPasswordText" href="{{ route('forgot-password') }}">@lang('message.forgotPasswordQuestion')</a>
                </div>
            </div>
            <div class="row m-t-30">
                <div class="col-md-12">
                    <button type="submit" name="submitLogin" id="m_login_signin_submit" class="loginSubmitButton">
                        @lang('message.login')
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@include('blocks.footer')

@endsection







