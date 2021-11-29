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

    <div id="testResult">

    </div>

    <div id="cartPage" class="basketBody">

    </div>

    @include('blocks.footer')

@endsection

@section('scripts')
    <script type="text/javascript" src="{{asset('assets/js/modernizr.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/jquery.validationEngine.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/privateJs/showCart.js')}}"></script>
@endsection


