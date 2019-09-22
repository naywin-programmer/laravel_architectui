<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="{{ str_replace('_', '-', app()->getLocale()) }}">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="robots" content="noindex, nofollow">
    <meta name="msapplication-tap-highlight" content="no">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!--
    =========================================================
    * ArchitectUI HTML Theme Dashboard - v1.0.0
    =========================================================
    * Product Page: https://dashboardpack.com
    * Copyright 2019 DashboardPack (https://dashboardpack.com)
    * Licensed under MIT (https://github.com/DashboardPack/architectui-html-theme-free/blob/master/LICENSE)
    =========================================================
    * The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
    -->

    <title>@yield('meta_title') | {{ config('app.name') }}</title>
    <meta name="description" content="@yield('meta_desc')">

    <link href="{{ asset('vendor/assets/css/main.css') }}" rel="stylesheet">
    @yield('style')
</head>

<body>
    <div class="app-container app-theme-white body-tabs-shadow fixed-header">
        <div class="app-main">
            <div class="app-main__outer">
                <div class="app-main__inner">
                    @yield('content')
                </div>

                <div class="app-wrapper-footer">
                    <div class="app-footer">
                        <div class="app-footer__inner justify-content-center">
                            <div class="">
                                <ul class="nav">
                                    <li class="nav-item">
                                        <a href="{{ route('admin.index') }}">
                                            {{config('app.name')}}
                                        </a>
                                        , Copyright &copy; {{date('Y')}}. All right reserved.
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <script src="{{ asset('vendor/assets/scripts/main.js') }}"></script>
    <script src="http://maps.google.com/maps/api/js?sensor=true"></script>
    @yield('script')
</body>

</html>