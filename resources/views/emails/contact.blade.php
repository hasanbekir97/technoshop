<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>technoshop | contact</title>
    <meta name="robots" content="noindex, follow" />
    <meta name="description" content="">
    <meta name="lang" content="en" />
    <meta name="author" content="Hasan Bekir DOĞAN" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, follow" />
    <style>

        .table {
            font-family: "Calibri";
            width: 600px;
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
        .table .bodyArea > td .bodyAreaTable .section > td {
            padding-bottom: 20px;
        }
        .table .bodyArea > td .bodyAreaTable .section > td .title {
            font-size: 21px;
            font-weight: bold;
            padding-bottom: 5px;
            border-bottom: 2px solid #e77216;
        }
        .table .bodyArea > td .bodyAreaTable .section > td .textArea {
            padding-top: 15px;
            font-size: 18px;
        }
        .table .bodyArea > td .bodyAreaTable .section > td .textArea .bold {
            font-weight: bold;
        }

    </style>

</head>
<body>

    <table class="table">

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
                                    <td class="title" colspan="2">
                                        CONTACT INFORMATION
                                    </td>
                                </tr>
                                <tr>
                                    <td class="textArea">
                                        <table width="100%">
                                            <tr>
                                                <td class="bold">Name: </td>
                                                <td class="normal">{{$details['name']}}</td>
                                            </tr>
                                            <tr>
                                                <td class="bold">Email: </td>
                                                <td class="normal">{{$details['email']}}</td>
                                            </tr>
                                            @isset($details['phone'])
                                                <tr>
                                                    <td class="bold">Phone: </td>
                                                    <td class="normal">{{$details['phone']}}</td>
                                                </tr>
                                            @endisset
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr class="section">
                        <td>
                            <table width="100%">
                                <tr>
                                    <td class="title">
                                        MESSAGE
                                    </td>
                                </tr>
                                <tr>
                                    <td class="textArea">
                                        <table width="100%">
                                            <tr>
                                                <td class="normal">{{$details['message']}}</td>
                                            </tr>
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
