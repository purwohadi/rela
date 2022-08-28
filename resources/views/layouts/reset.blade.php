<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta http-equiv="refresh" content="{{ config('session.lifetime') * 60 }}">

  <title>{{ 'Reset Password | '.config('app.name') ?? config('app.name') }}</title>
  <!-- Styles -->
  <link href="{{ mix('css/theme~auth.css') }}" rel="stylesheet">
  <style>
    html,
    body {
      height: 100%;
    }

    body {
      font-family: Poppins, sans-serif !important;
      display: -ms-flexbox;
      display: flex;
      -ms-flex-align: center;
      align-items: center;
      padding-top: 40px;
      padding-bottom: 40px;
      background-color: #f5f5f5;
    }

    .centering-form {
      width: 100%;
      max-width: 600px;
      padding: 15px;
      margin: auto;
    }
    #error-page .card {
      padding: .8rem;
      box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.06);
      border-radius: .7rem;
      border: none;
    }
    #error-page .content-error {
      padding: .8rem;
    }
    #error-page .content-error .icon {
      color: #979bac;
    }
  </style>
</head>

<body class="text-center">
  <div id="loginapp" class="centering-form">
    @if (!$expired)
      <form-reset></form-reset>
    @elseif ($expired === 'invalid')
      <div id="error-page">
        <div class="card text-center my-5">
          <div class="content-error">
            <div class="icon mb-3">
              <i class="fas fa-telescope fa-4x"></i>
            </div>
            <h4 class="mb-0 font-weight-bold">Link URL Tidak Valid</h4>
            <small class="text-muted">
              Silakan cek kembali Link URL anda
            </small>
          </div>
        </div>
      </div>
      <div class="text-center mt-2">
        <a href="{{ config('app.url') }}" style="text-decoration: none;">
          <i class="fal fa-chevron-left mr-1"></i> Kembali ke Halaman Login
        </a>
      </div>
    @else
      <div id="error-page">
        <div class="card text-center my-5">
          <div class="content-error">
            <div class="icon mb-3">
              <i class="fas fa-history fa-4x"></i>
            </div>
            <h4 class="mb-0 font-weight-bold">Link URL Kadaluwarsa</h4>
            <small class="text-muted">
              Link yang anda gunakan telah kadaluwarsa
            </small>
          </div>
        </div>
      </div>
      <div class="text-center mt-2">
        <a href="{{ config('app.url') }}" style="text-decoration: none;">
          <i class="fal fa-chevron-left mr-1"></i> Kembali ke Halaman Login
        </a>
      </div>
    @endif
  </div>
  @routes
  <script src="{{ mix('js/manifest.js') }}" defer></script>
  <script src="{{ mix('js/vendor~bs.js') }}" defer></script>
  <script src="{{ mix('js/vendor~fc.js') }}" defer></script>
  <script src="{{ mix('js/vendor~sync.js') }}" defer></script>
  <script src="{{ mix('js/vendor~vue.js') }}" defer></script>
  <script src="{{ mix('js/auth.js') }}" defer></script>
  @include('helpers.settings-json')
</body>

</html>
