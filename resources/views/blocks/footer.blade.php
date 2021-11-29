<footer>
    <div class="footerHeadArea">
        <ul>
            <li class="title">@lang('message.general')</li>
            <li><a class="linkArea" href="{{ LaravelLocalization::getURLFromRouteNameTranslated(App::getLocale(), 'routes./') }}">@lang('message.home')</a></li>
            <li><a class="linkArea" href="{{ LaravelLocalization::getURLFromRouteNameTranslated(App::getLocale(), 'routes.contact') }}">@lang('message.contact')</a></li>
        </ul>
        <ul>
            <li class="title">@lang('message.categories')</li>
            <li>@lang('message.phone')</li>
            <li>Laptop</li>
            <li>Tablet</li>
            <li>TV</li>
        </ul>
        <ul>
            <li class="title">@lang('message.populerProducts')</li>
            <li>iPhone 11</li>
            <li>Oppo Reno 4</li>
            <li>Samsung Galaxy A52</li>
            <li>Xiaomi Redmi note 10</li>
        </ul>
        <ul>
            <li class="title">@lang('message.paymentOptions')</li>
            <li class="eftIconArea">
                <div class="iconArea">
                    <img src="{{asset('assets/img/payment.png')}}">
                </div>
                <div class="iconTextArea">
                    <p class="bottomText">@lang('message.payAtDoor')</p>
                </div>
            </li>
        </ul>
    </div>
</footer>
