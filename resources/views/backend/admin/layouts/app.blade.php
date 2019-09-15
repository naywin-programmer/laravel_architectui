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

    <title>@yield('meta_title') | {{ config('app.name') }}</title>
    <meta name="description" content="@yield('meta_desc')">

    <link href="{{ asset('vendor/assets/css/main.css') }}" rel="stylesheet">
    @yield('style')
</head>

<body>
    <div class="app-container app-theme-white body-tabs-shadow fixed-sidebar fixed-header">
        @include('backend.admin.layouts.header')

        <div class="app-main">
            @include('backend.admin.layouts.sidebar')
            <div class="app-main__outer">
                <div class="app-main__inner">
                    @include('backend.admin.layouts.components.page_title')
                    @yield('content')
                </div>
                @include('backend.admin.layouts.footer')
            </div>
        </div>
    </div>
    <script src="{{ asset('vendor/assets/scripts/main.js') }}"></script>
    <script src="http://maps.google.com/maps/api/js?sensor=true"></script>
    @yield('script')
</body>

</html>