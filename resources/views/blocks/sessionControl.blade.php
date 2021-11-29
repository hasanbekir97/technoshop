@php
    session_start();

    if(session()->missing('cart')){
        session([
            'cart' => []
            ]);
    }
@endphp



