<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta http-equiv="refresh" content="{{ config('session.lifetime') * 60 }}">

  <title>@yield('title')</title>

  <!-- Styles -->
  <link href="{{ mix('css/theme~auth.css') }}" rel="stylesheet">
  <style>
    body {
      font-family: Poppins,sans-serif !important;
    }
  </style>
</head>

<body>
  <div id="loginapp">
    <login-app></login-app>
  </div>
  @routes
  <script src="{{ mix('js/manifest.js') }}" defer></script>
  <script src="{{ mix('js/vendor~bs.js') }}" defer></script>
  <script src="{{ mix('js/vendor~fc.js') }}" defer></script>
  <script src="{{ mix('js/vendor~sync.js') }}" defer></script>
  <script src="{{ mix('js/vendor~vue.js') }}" defer></script>
  <script src="{{ mix('js/auth.js') }}" defer></script>
</script>  @include('helpers.settings-json')
</body>

</html>
