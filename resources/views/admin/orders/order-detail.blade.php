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
                                    <div class="page-body orderDetailPage">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <input type="number" id="orderDetailOrderId" value="{{$order_id}}" style="display:none; visibility:hidden;">

                                                <div class="page-header card">

                                                    <div class="page-header-title">
                                                        <i class="far fa-dolly-flatbed-alt"></i>
                                                        <div class="d-inline">
                                                            <h4>Order Detail</h4>
                                                            <span>You can see order details in this section</span>
                                                        </div>
                                                    </div>

                                                    <div class="pageHeaderInfoHeadBlock">
                                                        <div class="pageHeaderInfoBlock">
                                                            <div class="textArea">
                                                                <section class="title">Order Date</section>
                                                                <section class="text">{{$order_date}}</section>
                                                            </div>
                                                            <div class="icon">
                                                                <i class="fal fa-calendar-week"></i>
                                                            </div>
                                                        </div>

                                                        <div class="pageHeaderInfoBlock">
                                                            <div class="textArea">
                                                                <section class="title">Order Code</section>
                                                                <section class="text">{{$order_code}}</section>
                                                            </div>
                                                            <div class="icon">
                                                                <i class="fal fa-barcode-alt"></i>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>

                                                <!-- Bootstrap tab card start -->
                                                <div class="card">
                                                    <div class="card-block">
                                                        <!-- Row start -->
                                                        <div class="row">
                                                            <div class="col-lg-12 col-xl-12">
                                                                <div class="sub-title">Order Items</div>
                                                                <!-- Hover table card start -->
                                                                <div class="card productTable">
                                                                    <div class="adminTables">
                                                                        <div class="card-block table-border-style productTableDetailArea">
                                                                            <div class="table-responsive">

                                                                                <table id="orderItemTable" class="table table-hover orderDetailTable">
                                                                                    <thead>
                                                                                        <tr>
                                                                                            <th>Product</th>
                                                                                            <th>Price</th>
                                                                                            <th>Quantity</th>
                                                                                            <th>Sub Total</th>
                                                                                        </tr>
                                                                                    </thead>
                                                                                    <tbody id="orderDetailItems">

                                                                                    </tbody>
                                                                                    <tfoot id="orderDetailTotalPrices">

                                                                                    </tfoot>
                                                                                </table>

                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- Hover table card end -->
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- Row end -->
                                                    </div>
                                                </div>
                                                <!-- Bootstrap tab card end -->

                                                <!-- Bootstrap tab card start -->
                                                <div class="card">
                                                    <div class="card-block">
                                                        <!-- Row start -->
                                                        <div class="row">
                                                            <div class="col-lg-12 col-xl-12">
                                                                <div class="sub-title">Customer Information</div>
                                                                <!-- Hover table card start -->
                                                                <div class="card productTable">
                                                                    <div class="userInformationArea">
                                                                        <div class="form-group">
                                                                            <div class="row">
                                                                                <div class="col-lg-6">
                                                                                    <label>Name</label>
                                                                                    <input type="text" class="form-control" value="{{$userInformation['name']}}" disabled>
                                                                                </div>
                                                                                <div class="col-lg-6">
                                                                                    <label>E-Mail</label>
                                                                                    <input type="text" class="form-control" value="{{$userInformation['email']}}" disabled>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <div class="row">
                                                                                <div class="col-lg-6">
                                                                                    <label>Phone</label>
                                                                                    <input type="text" class="form-control" value="{{$userInformation['phone']}}" disabled>
                                                                                </div>
                                                                                <div class="col-lg-6">
                                                                                    <label>Country</label>
                                                                                    <input type="text" class="form-control" value="{{$userInformation['country']}}" disabled>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <div class="row">
                                                                                <div class="col-lg-6">
                                                                                    <label>City</label>
                                                                                    <input type="text" class="form-control" value="{{$userInformation['city']}}" disabled>
                                                                                </div>
                                                                                <div class="col-lg-6">
                                                                                    <label>County</label>
                                                                                    <input type="text" class="form-control" value="{{$userInformation['county']}}" disabled>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <div class="row">
                                                                                <div class="col-lg-12">
                                                                                    <label>Explicit Address</label>
                                                                                    <textarea type="text" class="form-control" disabled>{{$userInformation['address']}}</textarea>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- Hover table card end -->
                                                            </div>
                                                        </div>
                                                        <!-- Row end -->
                                                    </div>
                                                </div>
                                                <!-- Bootstrap tab card end -->

                                                <!-- Bootstrap tab card start -->
                                                <div class="card">
                                                    <div class="card-block">
                                                        <!-- Row start -->
                                                        <div class="row">
                                                            <div class="col-lg-12 col-xl-12">
                                                                <div class="sub-title">Order Status</div>
                                                                <div class="orderStatusArea">
                                                                    <form id="orderStatusForm">
                                                                        <div class="alert alert-success" role="alert" id="successMsg" style="display: none">
                                                                            Your order status has been updated successfully!
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <div class="col-lg-1">
                                                                                <label for="orderStatus">Status</label>
                                                                            </div>
                                                                            <div class="col-lg-11">
                                                                                <select id="orderStatus" class="form-control">
                                                                                    <option @php if($order_status === 0) echo "selected";@endphp value="0">On Hold</option>
                                                                                    <option @php if($order_status === 1) echo "selected";@endphp value="1">Preparing</option>
                                                                                    <option @php if($order_status === 2) echo "selected";@endphp value="2">In Cargo</option>
                                                                                    <option @php if($order_status === 3) echo "selected";@endphp value="3">Completed</option>
                                                                                    <option @php if($order_status === 4) echo "selected";@endphp value="4">Cancelled</option>
                                                                                </select>
                                                                                <div class="errorMessageArea">
                                                                                    <span class="text-danger" id="orderStatusErrorMsg"></span>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="buttonArea row">
                                                                            <div class="col-lg-1"></div>
                                                                            <div class="col-lg-11">
                                                                                <button type="submit" class="orderStatusSaveButton">
                                                                                    <i class="far fa-save"></i>Save
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- Row end -->
                                                    </div>
                                                </div>
                                                <!-- Bootstrap tab card end -->

                                                <!-- Bootstrap tab card start -->
                                                <div class="card">
                                                    <div class="card-block">
                                                        <!-- Row start -->
                                                        <div class="row">
                                                            <div class="col-lg-12 col-xl-12">
                                                                <div class="sub-title">Delivery Address</div>
                                                                <!-- Hover table card start -->
                                                                <div class="card productTable">
                                                                    <div class="userInformationArea">
                                                                        <div class="form-group">
                                                                            <div class="row">
                                                                                <div class="col-lg-6">
                                                                                    <label>Name</label>
                                                                                    <input type="text" class="form-control" value="{{$orderInformation['name']}}" disabled>
                                                                                </div>
                                                                                <div class="col-lg-6">
                                                                                    <label>E-Mail</label>
                                                                                    <input type="text" class="form-control" value="{{$orderInformation['email']}}" disabled>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <div class="row">
                                                                                <div class="col-lg-6">
                                                                                    <label>Phone</label>
                                                                                    <input type="text" class="form-control" value="{{$orderInformation['phone']}}" disabled>
                                                                                </div>
                                                                                <div class="col-lg-6">
                                                                                    <label>Country</label>
                                                                                    <input type="text" class="form-control" value="{{$orderInformation['country']}}" disabled>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <div class="row">
                                                                                <div class="col-lg-6">
                                                                                    <label>City</label>
                                                                                    <input type="text" class="form-control" value="{{$orderInformation['city']}}" disabled>
                                                                                </div>
                                                                                <div class="col-lg-6">
                                                                                    <label>County</label>
                                                                                    <input type="text" class="form-control" value="{{$orderInformation['county']}}" disabled>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <div class="row">
                                                                                <div class="col-lg-12">
                                                                                    <label>Explicit Address</label>
                                                                                    <textarea type="text" class="form-control" disabled>{{$orderInformation['address']}}</textarea>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- Hover table card end -->
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
    <script type="text/javascript" src="{{asset('assets-admin/js/privateJs/orderDetail.js')}}"></script>
@endsection

