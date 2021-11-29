@extends('layouts.admin-general')

@section('metaSeo')
    <title>technoshop | laravel </title>
    <meta name="description" content="technoshop |  laravel">
    <meta name="keywords" content='technoshop | laravel'>
@endsection

@section('content')

    @include('admin.blocks.loader')

    <div id="pcoded" class="pcoded">
        <div class="pcoded-overlay-box"></div>
        <div class="pcoded-container navbar-wrapper">

            @include('admin.blocks.header')

            <div class="pcoded-main-container">
                <div class="pcoded-wrapper">

                    @include('admin.blocks.left-menu')

                    <div class="pcoded-content">
                        <div class="pcoded-inner-content">
                            <!-- Main-body start -->
                            <div class="main-body">
                                <div class="page-wrapper">

                                    <!-- Page body start -->
                                    <div class="page-body">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <!-- Bootstrap tab card start -->
                                                <div class="card">
                                                    <div class="card-block">
                                                        <!-- Row start -->
                                                        <div class="row">
                                                            <div class="col-lg-12 col-xl-12">
                                                                <div class="sub-title">Contact Details</div>
                                                                <input type="text" id="contactId" value="{{$contact['id']}}" style="visibility: hidden; display:none;">
                                                                <!-- Tab panes -->
                                                                <div class="userInformationArea">
                                                                    <div class="form-group">
                                                                        <div class="row">
                                                                            <div class="col-lg-6">
                                                                                <label>Name</label>
                                                                                <input type="text" class="form-control" value="{{$contact['name']}}" disabled>
                                                                            </div>
                                                                            <div class="col-lg-6">
                                                                                <label>E-Mail</label>
                                                                                <input type="text" class="form-control" value="{{$contact['email']}}" disabled>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <div class="row">
                                                                            <div class="col-lg-12">
                                                                                <label>Phone</label>
                                                                                <input type="text" class="form-control" value="{{$contact['phone']}}" disabled>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <div class="row">
                                                                            <div class="col-lg-12">
                                                                                <label>Message</label>
                                                                                <textarea type="text" class="form-control" disabled>{{$contact['message']}}</textarea>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="buttonArea userDetailsButtonArea">
                                                                        <button id="deleteContact" type="button" class="generalButton deleteAccountButton">DELETE CONTACT</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- Row end -->
                                                    </div>
                                                </div>
                                                <!-- Bootstrap tab card end -->
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Page body end -->
                                </div>
                            </div>
                            <!-- Main-body end -->

                            <div id="styleSelector">

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script type="text/javascript" src="{{asset('assets-admin/js/privateJs/contactDetail.js')}}"></script>
@endsection

