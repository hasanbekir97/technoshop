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
                                                                <div class="sub-title">User Profile Details</div>
                                                                <input type="text" id="userId" value="{{$user['id']}}" style="visibility: hidden; display:none;">
                                                                <!-- Tab panes -->
                                                                <div class="userInformationArea">
                                                                    <div class="form-group">
                                                                        <div class="row">
                                                                            <div class="col-lg-6">
                                                                                <label>Name</label>
                                                                                <input type="text" class="form-control" value="{{$user['name']}}" disabled>
                                                                            </div>
                                                                            <div class="col-lg-6">
                                                                                <label>E-Mail</label>
                                                                                <input type="text" class="form-control" value="{{$user['email']}}" disabled>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    @if(count($userInformation) === 1)
                                                                        <div class="form-group">
                                                                            <div class="row">
                                                                                <div class="col-lg-6">
                                                                                    <label>Phone</label>
                                                                                    <input type="text" class="form-control" value="{{$userInformation[0]['phone']}}" disabled>
                                                                                </div>
                                                                                <div class="col-lg-6">
                                                                                    <label>Country</label>
                                                                                    <input type="text" class="form-control" value="{{$userInformation[0]['country']}}" disabled>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <div class="row">
                                                                                <div class="col-lg-6">
                                                                                    <label>City</label>
                                                                                    <input type="text" class="form-control" value="{{$userInformation[0]['city']}}" disabled>
                                                                                </div>
                                                                                <div class="col-lg-6">
                                                                                    <label>County</label>
                                                                                    <input type="text" class="form-control" value="{{$userInformation[0]['county']}}" disabled>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <div class="row">
                                                                                <div class="col-lg-12">
                                                                                    <label>Explicit Address</label>
                                                                                    <textarea type="text" class="form-control" disabled>{{$userInformation[0]['address']}}</textarea>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @else
                                                                        <div class="form-group">
                                                                            <div class="row">
                                                                                <div class="col-lg-6">
                                                                                    <label>Phone</label>
                                                                                    <input type="text" class="form-control nullInformationArea" value="User phone information has not filled yet." disabled>
                                                                                </div>
                                                                                <div class="col-lg-6">
                                                                                    <label>Country</label>
                                                                                    <input type="text" class="form-control nullInformationArea" value="User Country information has not filled yet." disabled>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <div class="row">
                                                                                <div class="col-lg-6">
                                                                                    <label>City</label>
                                                                                    <input type="text" class="form-control nullInformationArea" value="User City information has not filled yet." disabled>
                                                                                </div>
                                                                                <div class="col-lg-6">
                                                                                    <label>County</label>
                                                                                    <input type="text" class="form-control nullInformationArea" value="User County information has not filled yet." disabled>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <div class="row">
                                                                                <div class="col-lg-12">
                                                                                    <label>Explicit Address</label>
                                                                                    <textarea type="text" class="form-control nullInformationArea" disabled>User explicit information has not filled yet.</textarea>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @endif
                                                                    <div class="deleteProcessInform">
                                                                        Once the user account is deleted, all of its resources and data
                                                                        will be permanently deleted.
                                                                    </div>
                                                                    <div class="buttonArea userDetailsButtonArea">
                                                                        <button id="deleteUserAccount" type="button" class="generalButton deleteAccountButton">DELETE USER</button>
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
    <script type="text/javascript" src="{{asset('assets-admin/js/privateJs/userDetail.js')}}"></script>
@endsection

