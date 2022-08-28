@extends('layouts.auth')
@section('title')
  {{ Str::setPageTitle('Login') }}
@endsection
@section('content')
<div class="page-wrapper">
  <div class="page-inner">
    <div class="page-content-wrapper bg-transparent m-0">
      <div
        class="flex-1"
        style="background: url(img/svg/pattern-3.svg) no-repeat center bottom fixed; background-size: cover;"
      >
        <div class="container login-container py-2">
          <div class="panel m-6 p-0">
            <div class="row no-gutters">
              <div class="col-sm-12 col-md-6 col-lg-4 col-xl-4 ml-auto">
                <div class="pt-lg-3 pb-lg-3 pl-lg-5 pr-lg-5 p-md-4 p-4">
                  <div class="logo text-center mb-3">
                    <div class="text-dark mb-2 font-weight-bold lead">
                      {{ config('app.name') }}
                    </div>
                    <a href="{{ route('home') }}" class="page-logo-link press-scale-down">
                      <img
                        src="img/logo.png"
                        class="img-fluid"
                        alt="{{ config('app.name') }}"
                        aria-roledescription="logo"
                        style="width:3.05rem;height:auto"
                      >
                    </a>
                  </div>
                  <form class="needs-validation" method="POST" action="{{ route('login') }}" novalidate>
                    @csrf
                    <div class="form-group mb-2">
                      <label class="form-label" for="username">@lang('auth.label.username')</label>
                      <div class="input-group flex-nowrap">
                        <div class="input-group-prepend">
                          <span class="input-group-text">
                            <i class="fal fa-user-alt fs-xl"></i>
                          </span>
                        </div>
                        <input id="username" name="username" type="text" class="form-control" value="{{ old('username') }}"
                          placeholder="@lang('auth.label.username_placeholder')" aria-label="@lang('auth.label.username_placeholder')"
                          aria-describedby="@lang('auth.label.username')" required autofocus>
                      </div>
                      <div class="help-block">@lang('auth.label.username_help')</div>
                    </div>
                    <div class="form-group mb-2">
                      <label class="form-label" for="password">@lang('auth.label.password')</label>
                      <div class="input-group flex-nowrap">
                        <div class="input-group-prepend">
                          <span class="input-group-text">
                            <i class="fal fa-lock-alt fs-xl"></i>
                          </span>
                        </div>
                        <input id="password" name="password" type="password" class="form-control"
                          placeholder="@lang('auth.label.password_placeholder')" aria-label="@lang('auth.label.password_placeholder')"
                          aria-describedby="@lang('auth.label.password')" required>
                        <div class="input-group-append">
                          <button id="seek-btn" type="button" class="btn btn-default btn-sm waves-effect waves-themed"
                            data-state="off">
                            <i class="fal fa-eye fs-xl"></i>
                          </button>
                        </div>
                      </div>
                      <div class="help-block">@lang('auth.label.password_help')</div>
                    </div>
                    <div class="form-group mt-0 mb-2">
                        <div class="captcha row no-gutters">
                          <div class="col-lg-5 pr-lg-1 my-2">
                            <div style="display:inline-block;border-radius:.3rem;overflow:hidden;width:130px;height:45px;">
                              <img id="captcha-img" src="" alt="Loading...">
                            </div>
                          </div>
                          <div class="col-lg-7 pr-lg-1 my-2">
                            <div class="row no-gutters">
                              <div class="col-lg-6">
                                <div class="reload-btn pl-2">
                                  <button type="button" class="btn btn-danger btn-xs" class="reload" id="reload-captcha">Reload Captcha</button>
                                </div>
                              </div>
                              <div class="col-lg-6">
                                <div class="klik-btn pl-1">
                                  <button type="button" class="btn btn-outline-light btn-xs read" id="read-captcha">Klik Captcha</button>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="captcha-input mt-1">
                          <input
                            id="captcha"
                            name="captcha"
                            type="text"
                            class="form-control"
                            autocomplete="off"
                            placeholder="@lang('auth.label.captcha_placeholder')"
                            aria-label="@lang('auth.label.captcha_placeholder')"
                            aria-describedby="@lang('auth.label.captcha')"
                            @if (app()->env == 'production')
                              required
                            @endif
                          >
                        </div>
                    </div>
                    @if (count($errors) > 0)
                    <div class="alert bg-danger-600 alert-dismissible fade show mt-3 mb-2">
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true"><i class="fal fa-times"></i></span>
                      </button>
                      <div class="d-flex align-items-center">
                        <div class="alert-icon width-8">
                          <span class="icon-stack icon-stack-xl">
                            <i class="base-7 icon-stack-3x color-danger-400"></i>
                            <i class="base-7 icon-stack-2x color-danger-800"></i>
                            <i class="fal fa-times icon-stack-1x text-white"></i>
                          </span>
                        </div>
                        <div class="flex-1 pl-1">
                          <span class="h4">
                            @lang('auth.label.login_error')
                          </span>
                          <br>
                          {{ implode(', ', Arr::flatten($errors->toArray())) }}
                        </div>
                      </div>
                    </div>
                    @endif
                    <div class="row no-gutters">
                      <div class="col-lg-12 pr-lg-1 my-2">
                        <button id="js-login-btn" type="submit" class="btn btn-info btn-block btn-lg">
                          <i class="fal fa-sign-in mr-1"></i>
                          @lang('auth.label.login_button')
                        </button>
                      </div>
                    </div>
                    @if (env('ETPP_EXISTING', 0))
                      <div class="row no-gutters">
                        <div class="col-lg-12 pr-lg-1 my-2">
                          <a
                            href="{{ env('URL_ETPP_EXISTING', '') }}"
                            target="_blank"
                            id="js-login-exist-btn"
                            type="button"
                            class="btn btn-success btn-block btn-lg text-white"
                          >
                            <i class="fas fa-globe mr-1"></i>
                            @lang('auth.label.login_exist_button')
                          </a>
                          {{-- <button id="js-login-exist-btn" type="button" class="btn btn-success btn-block btn-lg">
                            <i class="fal fa-sign-in mr-1"></i>
                            @lang('auth.label.login_exist_button')
                          </button> --}}
                        </div>
                      </div>
                    @endif
                  </form>
                </div>
              </div>
              <div class="col col-md-6 col-lg-8 hidden-sm-down">
                <div id="panel-information" class="p-lg-3 p-md-3 p-3 zoomed-in" style="width: 781px;">
                  <div class="panel-hdr">
                    <h2 style="font-weight: 600;">
                      <span class="icon-stack fs-xxl mr-2">
                        <i class="fal fa-bullhorn icon-stack-1x opacity-100 color-primary"></i>
                      </span>
                      @lang('auth.label.information.title')
                    </h2>
                    <div class="panel-toolbar">
                      {{ Str::getCurrentDate('l, d F Y') }}
                    </div>
                  </div>

                  <div class="panel-container collapse show bg-transparent">
                    <div id="panel-container-information" class="panel-content bg-transparent">
                      <div id="pengumuman_box">
                        <div class="info-urgent bg-white p-3 rounded mb-3">
                            <div class="pb-3">
                              <a href="javascript:void(0)" class="btn-link text-danger ml-auto blink-me font-weight-bold font-italic lead">
                                  Pengumuman Terbaru
                              </a>
                            </div>
                            <div class="panel-tag pengumman-baru-text text-justify mb-0">
                                Loading....
                            </div>
                        </div>
                        <div>
                          <p class="text-justify pengumuman-box">Loading....</p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="container mx-auto sponsor pt-2" style="display: block;margin-bottom: 3rem !important;">
        <div class="p-4 text-center">
          <img src="img/plusjakarta-logo-black.svg" class="img-fluid" width="125px">
        </div>
      </div>
      <footer>
        <div class="position-absolute pos-bottom pos-left pos-right p-3 mt-3 text-center">
          2021 © {{ config('app.name') }} by&nbsp;
          <a
            href='{{ config('app.owner.web') }}'
            class='text-dark opacity-75 fw-500'
            title='{{ config('app.owner.name') }}'
            target='_blank'
          >
            {{ config('app.owner.name') }}
          </a>
        </div>
      </footer>
    </div>
  </div>
</div>
<div id="pengumuman_banner_box"></div>
<style>
  .pengumuman-box {
    color: #e4e4e4;
    background: #658fd4;
    border-top: 1px solid #8490a2;
    border-radius: 5px;
    padding: 15px;
    margin-bottom: 20px;
  }

  .pengumman-baru-text {
    color: #403f3f;
    background: #daedf7;
    font-size: 13px;
  }
</style>
@push('scripts')
<script>
    var APP_URL = "{{ env('APP_URL') }}" ;
</script>
<script src="{{ config('app.env') === 'production' ? asset('js/parts/auth.js') : mix('js/parts/auth.js') }}" defer></script>
@endpush
@endsection
