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


    @include('blocks.footer')

@endsection

@section('scripts')

    <script type="text/javascript" src="{{asset('assets/js/privateJs/contact.js')}}"></script>
@endsection


