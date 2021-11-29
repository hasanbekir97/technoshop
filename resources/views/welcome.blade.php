<!doctype html>
<html class="no-js" lang="en">
<head>

    <meta charset="UTF-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>technoshop - test</title>
    <meta name="lang" content="en" />
    <meta name="author" content="Hasan Bekir DOĞAN" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="robots" content="noindex, follow" />
    <meta name="csrf-token" content="{{ csrf_token() }}">





</head>

<body>


@foreach($data as $dat)
    <li>{{$dat->name}}</li>
@endforeach

<div>
    {{$data->links()}}
</div>


</body>
</html>
