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

            @if (Session::has('message'))
                <div class="alert alert-success" role="alert">
                    {{ Session::get('message') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('reset-password.post') }}">
                @csrf

                <input type="hidden" name="token" value="{{ $token }}">

                <div class="input-group">
                    <label for="email">@lang('message.email')</label>
                    <input id="email" class="form-control" type="text" name="email" value="{{ $email }}" />
                </div>

                <div class="input-group">
                    <label for="password">@lang('message.newPassword')</label>
                    <input id="password" class="form-control" type="password" name="password" autocomplete="new-password" />
                    <a id="showPassword">
                        <i class="far fa-eye-slash"></i>
                    </a>
                </div>

                <div class="input-group">
                    <label for="password_confirmation">@lang('message.confirmNewPassword')</label>
                    <input id="password_confirmation" class="form-control" type="password" name="password_confirmation" autocomplete="new-password" />
                    <a id="showPasswordConfirm">
                        <i class="far fa-eye-slash"></i>
                    </a>
                </div>

                <div class="submitButtonArea">
                    <button type="submit">
                        @lang('message.resetPassword')
                    </button>
                </div>

            </form>
        </div>
    </div>

    @include('blocks.footer')

@endsection
