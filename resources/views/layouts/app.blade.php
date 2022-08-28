<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="root-text-sm">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no, minimal-ui">
    <!-- Call App Mode on ios devices -->
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <!-- Remove Tap Highlight on Windows Phone IE -->
    <meta name="msapplication-tap-highlight" content="no">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>

    <!-- Styles -->
    <link href="{{ mix('css/theme.css') }}" rel="stylesheet">
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>
<body class="mod-bg-1 header-function-fixed nav-function-fixed mod-skin-light">
    <!-- Inline scripts, please don't add partial script in this sections -->
    @include('helpers.settings')
    <div id="app">
        @yield('content')
    </div>
    @include('layouts.parts.quick-menu')
    @include('helpers.logout')
    @include('helpers.color-profile')
    <!-- Scripts -->
    @routes
    <script src="{{ mix('js/manifest.js') }}" defer></script>
    <script src="{{ mix('js/vendor~bs.js') }}" defer></script>
    <script src="{{ mix('js/vendor~fc.js') }}" defer></script>
    <script src="{{ mix('js/vendor~sync.js') }}" defer></script>
    <script src="{{ mix('js/vendor~vue.js') }}" defer></script>
    <script src="{{ mix('js/theme.vendor.js') }}" defer></script>

    <script src="{{ mix('js/theme.js') }}" defer></script>
    <script src="{{ mix('js/app.js') }}" defer></script>

    @stack('scripts')
    @include('helpers.settings-json')
</body>
</html>
