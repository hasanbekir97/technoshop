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
            @lang('message.forgotPasswordText')
        </div>

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

        <form class="formArea" method="POST" autocomplete="off" action="{{ route('forgot-password.post') }}">
            @csrf

            <div class="input-group">
                <label for="email" >@lang('message.email')</label>
                <input id="email" class="form-control" type="text" name="email" value="{{old('email')}}" />
            </div>

            <div class="submitButtonArea">
                <button type="submit">
                    @lang('message.emailPasswordResetLink')
                </button>
            </div>
        </form>
    </div>
</div>


@include('blocks.footer')

@endsection
