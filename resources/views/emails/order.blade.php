<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>technoshop | order</title>
    <meta name="robots" content="noindex, follow" />
    <meta name="description" content="">
    <meta name="lang" content="en" />
    <meta name="author" content="Hasan Bekir DOĞAN" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, follow" />

    <style>

        .table {
            font-family: "Calibri";
        }
        .table .headArea > td {
            padding: 35px 35px 20px 35px;
            border-bottom: 3px solid #e77216;
        }
        .table .headArea > td .headAreaTable {
            width: 100%;
        }
        .table .headArea > td .headAreaTable .companyInfoArea .companyPhone, .table .headArea > td .headAreaTable .companyInfoArea .companyEmail {
            text-align: left;
            font-weight: bold;
            font-size: 16px;
        }
        .table .bodyArea > td {
            padding: 35px;
        }
        .table .bodyArea > td .bodyAreaTable {
            width: 100%;
        }
        .table th, .table tr, .table td{
            text-align: center;
        }
        .table .alignLeft{
            text-align: left;
        }
        .table .alignRight{
            text-align: right;
        }
        .table .bold{
            font-weight: bold;
        }
        .table .avoidSlideText{
            white-space: nowrap;
        }
        .table .pt-50{
            padding-top:50px;
        }
        .table {
            color: #2C343B;
            border-collapse: collapse;
            word-wrap: break-word;
            background-color: white;
        }
        .table thead th {
            vertical-align: bottom;
            border-bottom: 2px solid #e9ecef;
            border-bottom-color: #ccc;
        }

        .orderDetailTable {
            color: #2C343B;
            width: 100% !important;
        }
        .orderDetailTable .adminProductSection {
            display: flex;
            flex-direction: row;
            justify-content: flex-start;
            align-content: center;
            align-items: center;
        }
        .orderDetailTable .adminProductSection .adminProductImgArea {
            height: 50px;
            width: 50px;
        }
        .orderDetailTable .adminProductSection .productInfoArea {
            text-align: left;
            color: #2C343B;
            margin-left: 15px;
            margin-top: 0;
        }
        .orderDetailTable .adminProductSection .productInfoArea li {
            line-height: 1.42;
            font-size: 15px;
        }
        .orderDetailTable .adminProductSection .productInfoArea li:first-child {
            font-weight: bold;
        }
        .orderDetailTable .adminProductSection .productInfoArea li:last-child {
            color: #919191;
            font-size: 12px;
        }
        .orderDetailTable tr, .orderDetailTable th, .orderDetailTable td {
            vertical-align: middle;
            text-align: left;
        }
        .orderDetailTable thead th {
            padding: 10px;
        }
        .orderDetailTable tbody tr {
            border-bottom: 1px solid #e9ecef;
        }
        .orderDetailTable tbody tr td {
            padding: 10px;
        }
        .orderDetailTable tfoot tr td {
            padding: 5px 10px;
            font-weight: bold;
        }
        .orderDetailTable tfoot tr td:first-child {
            border: none;
        }
        .orderDetailTable tfoot tr:first-child td {
            padding-top: 30px;
        }
        .orderDetailTable .titleSection {
            font-weight: bold;
        }
        .orderDetailTable .totalSectionTitle {
            font-weight: bold;
        }
        .orderDetailTable .totalSectionPrice {
            color: #F27A1A;
            font-size: 17px;
            font-weight: bold;
        }

        .adminProductImgArea .adminProductImage {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }

        ul {
            padding-left: 0;
            list-style-type: none;
            margin-bottom: 0;
        }

        .pageHeaderInfoHeadBlock {
            display: flex;
            flex-direction: row;
            justify-content: flex-end;
            align-content: center;
            align-items: center;
        }
        .pageHeaderInfoHeadBlock .pageHeaderInfoBlock {
            display: flex;
            flex-direction: row;
            justify-content: center;
            align-content: center;
            align-items: center;
        }
        .pageHeaderInfoHeadBlock .pageHeaderInfoBlock .textArea {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-content: flex-start;
            align-items: flex-start;
            line-height: 1.4;
        }
        .pageHeaderInfoHeadBlock .pageHeaderInfoBlock .textArea .title {
            color: #ABADB1;
            font-size: 14px;
        }
        .pageHeaderInfoHeadBlock .pageHeaderInfoBlock .textArea .text {
            color: #626372;
            font-size: 17px;
        }
        .pageHeaderInfoHeadBlock .pageHeaderInfoBlock .icon {
            color: #ABADB1;
            font-size: 30px;
            margin-left: 20px;
        }
        .pageHeaderInfoHeadBlock .pageHeaderInfoBlock:last-child {
            margin-left: 30px;
            padding-left: 30px;
            border-left: 1px solid #E9ECEF;
        }

        .deliveryAddress {
            width: 100% !important;
        }
        .deliveryAddress thead th {
            border: none;
            text-align: left;
            padding: 10px;
            font-weight: bold;
        }
        .deliveryAddress tbody tr td {
            border: none;
            text-align: left;
            padding: 2px 10px;
            vertical-align: top;
        }
        .deliveryAddress tbody tr td:first-child {
            font-weight: bold;
        }
        .orderProductImage{
            width:50px;
            height:50px;
            object-fit: contain;
        }
        .productImgArea{
            text-align: center;
            horiz-align: center;
        }
        .productInfoArea tr{
            border:none !important;
        }
        .productInfoArea tr:first-child td{
            line-height: 1.42;
            font-size: 15px;
            font-weight: bold;
            text-align: left;
        }
        .productInfoArea tr:last-child td{
            line-height: 1.42;
            font-weight: bold;
            color: #919191;
            font-size: 12px;
            text-align: left;
        }
        .productInfoArea tr td{
            padding:0 !important;
        }
        .productSection tr{
            border:none !important;
        }
        .productSection tr td{
            padding:0 !important;
        }
        .productSection tr .productImgArea{
            padding-right:10px !important;
        }
        .invoiceOrderTitle{
            border:none;
            padding:10px;
        }

    </style>

</head>
<body>

<table class="table" style="width: 750px;">

    <tr class="headArea">
        <td>
            <table class="headAreaTable">
                <tr>
                    <td><img src="{{$message->embed('assets/img/logo.png')}}" alt=""></td>
                    <td>
                        <table class="companyInfoArea" align="right">
                            <tr>
                                <td class="companyPhone">+90 123 456 78 90</td>
                            </tr>
                            <tr>
                                <td class="companyEmail">hasanbekir1997@hotmail.com</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>

    <tr class="bodyArea">
        <td>
            <table class="bodyAreaTable">

                <tr class="section">
                    <td>
                        <table width="100%">
                            <tr>
                                <td>
                                    <table class="table deliveryAddress">
                                        <thead>
                                            <tr>
                                                <th class="alignLeft invoiceOrderTitle" colspan="2">INVOICE TO:</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="alignLeft">Name: </td>
                                                <td class="alignLeft">{{$orderInformation[0]['name']}}</td>
                                            </tr>
                                            <tr>
                                                <td class="alignLeft">Email: </td>
                                                <td class="alignLeft">{{$orderInformation[0]['email']}}</td>
                                            </tr>
                                            <tr>
                                                <td class="alignLeft">Phone: </td>
                                                <td class="alignLeft">{{$orderInformation[0]['phone']}}</td>
                                            </tr>
                                            <tr>
                                                <td class="alignLeft">Country: </td>
                                                <td class="alignLeft">{{$orderInformation[0]['country']}}</td>
                                            </tr>
                                            <tr>
                                                <td class="alignLeft">City: </td>
                                                <td class="alignLeft">{{$orderInformation[0]['city']}}</td>
                                            </tr>
                                            <tr>
                                                <td class="alignLeft">County: </td>
                                                <td class="alignLeft">{{$orderInformation[0]['county']}}</td>
                                            </tr>
                                            <tr>
                                                <td class="alignLeft">Address: </td>
                                                <td class="alignLeft">{{$orderInformation[0]['address']}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                                <td width="230px" style="vertical-align: top;">
                                    <table class="table deliveryAddress">
                                        <thead>
                                        <tr>
                                            <th colspan="2" class="avoidSlideText alignLeft">ORDER DETAILS:</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td class="avoidSlideText">Order Date: </td>
                                            <td class="avoidSlideText">{{$order_date}}</td>
                                        </tr>
                                        <tr>
                                            <td class="avoidSlideText">Order Code: </td>
                                            <td class="avoidSlideText">{{$order_code}}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" class="textArea">
                                    <table id="orderItemTable" width="100%" class="table orderDetailTable orderProductsArea">
                                        <thead>
                                        <tr>
                                            <th class="alignLeft pt-50">Product</th>
                                            <th class="pt-50">Price</th>
                                            <th class="pt-50">Quantity</th>
                                            <th class="alignRight pt-50">Sub Total</th>
                                        </tr>
                                        </thead>
                                        <tbody id="orderDetailItems">
                                        @foreach($orderProducts as $row)
                                            <tr>
                                                <td class="alignLeft">
                                                    <table class="table productSection">
                                                        <tr>
                                                            <td class="productImgArea"><img src="{{$message->embed('uploads/'.$row->image_path)}}" width="50" height="50" class="orderProductImage" alt=""></td>
                                                            <td>
                                                                <table class="table productInfoArea">
                                                                    <tr>
                                                                        <td class="alignLeft">{{$row->name}}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="alignLeft">SKU: {{$row->sku}}</td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td>$ {{number_format($row->unit_price, 2, ',', '.')}}</td>
                                                <td>{{$row->quantity}}</td>
                                                <td class="alignRight">$ {{number_format($row->price, 2, ',', '.')}}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                        <tfoot id="orderDetailTotalPrices">
                                        <tr>
                                            <td colspan="2"></td>
                                            <td class="titleSection alignLeft">Sub Total:</td>
                                            <td class="alignRight">$ {{$subTotalPrice}}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"></td>
                                            <td class="titleSection alignLeft">Cargo Price:</td>
                                            <td class="alignRight">$ {{$cargoPrice}}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"></td>
                                            <td class="totalSectionTitle alignLeft">Total:</td>
                                            <td class="totalSectionPrice alignRight">$ {{$totalPrice}}</td>
                                        </tr>
                                        </tfoot>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>

</table>

</body>
</html>
