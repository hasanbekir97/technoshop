
<header>
    <div class="headerTopArea">
        <ul>
            <li>
                <a href="{{ LaravelLocalization::getURLFromRouteNameTranslated(App::getLocale(), 'routes./') }}" class="headerLogoArea"></a>
            </li>
            <li>
                <div class="headerSearchArea">
                    <form>
                        <input type="text" id="searchInputId" class="searchInput">
                        <a id="searchButtonId" href="javascript:void(0)" class="searchButton"><i class="far fa-search" title="@lang('message.search')"></i></a>
                    </form>
                </div>
            </li>
            <li>
                <ol>
                    <li>
                        <div class="dropdown">
                            @auth
                                <a class="dropdown-toggle headerAccountArea" id="dropdownMenuAccount">
                                    <i class="far fa-user"></i>
                                    <section class="accountButtonMemberName">
                                        <span class="text1">@lang('message.myAccount')</span>
                                        <span class="text2">{{auth()->user()->name}}</span>
                                    </section>
                                </a>
                                <ul class="dropdown-content myAccountDropDown">
                                    <li><a id="headerOrderLink" href="{{route('profile.user-account')}}#my-orders"><section><i class="far fa-dolly-flatbed-alt"></i> @lang('message.myOrders')</section></a></li>
                                    <li class="hrArea"></li>
                                    <li><a id="headerFavoriteLink" href="{{route('profile.user-account')}}#my-favorites"><section><i class="far fa-heart"></i> @lang('message.myFavorites')</section></a></li>
                                    <li class="hrArea"></li>
                                    <li><a id="headerCommentLink" href="{{route('profile.user-account')}}#my-reviews"><section><i class="far fa-comment-alt-dots"></i> @lang('message.myReviews')</section></a></li>
                                    <li class="hrArea"></li>
                                    <li><a href="{{route('profile.user-account')}}"><section><i class="far fa-user"></i> @lang('message.myAccount')</section></a></li>
                                    <li class="hrArea"></li>
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <a id="logoutButton" href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();">
                                                <section><i class="far fa-sign-out-alt"></i> @lang('message.logout')</section>
                                            </a>
                                        </form>
                                    </li>
                                </ul>
                            @endauth
                            @guest
                                <a class="dropdown-toggle headerAccountArea" id="dropdownMenuAccountQuest">
                                    <i class="far fa-user"></i>
                                    <section class="headerQuestAccount">
                                        <span class="text1">@lang('message.login')</span>
                                        <span class="text2">@lang('message.or') @lang('message.signup')</span>
                                    </section>
                                </a>
                                <ul class="dropdown-content myAccountDropDown">
                                    <li><a href="{{ LaravelLocalization::getURLFromRouteNameTranslated(App::getLocale(), 'routes.login') }}"><section class="loginText">@lang('message.login')</section></a></li>
                                    <li class="hrArea"></li>
                                    <li><a href="{{ LaravelLocalization::getURLFromRouteNameTranslated(App::getLocale(), 'routes.register') }}"><section class="signupText">@lang('message.signup')</section></a></li>
                                </ul>
                            @endguest
                        </div>
                    </li>
                    <li>
                        <a href="{{Route('cart')}}">
                            <div class="headerBasketArea">
                                <i class="far fa-shopping-cart">
                                    <div id="basketNumberID" class="basketNumber">
                                        0
                                    </div>
                                </i><section>@lang('message.myCart')</section>
                            </div>
                        </a>
                    </li>
                    <li>
                        <div class="dropdown">
                            <a class="dropdown-toggle headerLanguageArea" data-toggle="dropdown" id="dropdownMenuLang" aria-haspopup="true" aria-expanded="false">
                                <section class="languageBackground"></section>
                                <i class="far fa-globe-europe"></i>
                                <section>
                                    {{App::getlocale()}}
                                </section>
                            </a>
                            <ul class="dropdown-content languageDropDown" aria-labelledby="dropdownMenuLang" x-placement="bottom-start">
                                @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                    <li>
                                        <a rel="alternate" hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                                            <section>
                                                {{ $localeCode }}
                                            </section>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </li>
                </ol>
            </li>
        </ul>
    </div>

    <div id="headerCategoryId" class="headerBottomArea">

    </div>
</header>

