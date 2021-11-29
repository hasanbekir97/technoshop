
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
                <h3 class="text-left txt-primary">@lang('message.signup')</h3>
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

        <form class="formArea" method="POST" action="{{ route('register') }}">
            @csrf

            <div class="input-group">
                <label for="name">@lang('message.name')</label>
                <input id="name" class="form-control" type="text" name="name" value="{{old('name')}}" autofocus autocomplete="name" />
            </div>
            <div class="input-group">
                <label for="email" >@lang('message.email')</label>
                <input id="email" class="form-control" type="text" name="email" value="{{old('email')}}" />
            </div>
            <div class="input-group">
                <label for="password" >@lang('message.password')</label>
                <input id="password" class="form-control" type="password" name="password" autocomplete="new-password" />
                <a id="showPassword">
                    <i class="far fa-eye-slash"></i>
                </a>
            </div>
            <div class="input-group">
                <label for="password_confirmation" >@lang('message.confirmPassword')</label>
                <input id="password_confirmation" class="form-control" type="password" name="password_confirmation" autocomplete="new-password" />
                <a id="showPasswordConfirm">
                    <i class="far fa-eye-slash"></i>
                </a>
            </div>
            <div class="input-group consentDeclarationArea">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input checkbox" name="agree2" id="agree2">
                    <label class="form-check-label" for="agree2">@lang('message.checkboxText')</label>
                </div>
            </div>

            <div class="row m-t-30">
                <div class="col-md-12">
                    <button type="submit" name="submitSignin" id="m_login_signin_submit" class="loginSubmitButton">@lang('message.signup')</button>
                </div>
            </div>
            <div class="input-group forgetPassArea">
                <div class="forgetPasswordText2"><p>@lang('message.areYouMember')</p><a href="{{ route('login') }}">@lang('message.login')</a></div>
            </div>
        </form>
    </div>
</div>

@include('blocks.footer')

@endsection


@section('scripts')
    <script type="text/javascript" href="{{asset('assets/js/ready.js')}}"></script>
@endsection



