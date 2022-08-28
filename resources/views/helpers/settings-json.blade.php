<script type="application/json" data-settings-selector="settings-json">
  @php
    $settings = [
      'locale' => app()->getLocale(),
      'timezone' => config('app.timezone'),
      'appname' => config('app.name'),
      'is_local' => config('app.env') == 'production' ? false : true,
      'current_date' => Str::getCurrentDate('Y-m-d'),
      'owner' => [
        'name' => config('app.owner.name'),
        'web' => config('app.owner.web'),
      ],
      'etpp_existing' => config('app.etpp_existing'),
      'url_etpp_existing' => config('app.url_etpp_existing'),
      'home' => route('home'),
      'hash_version' => $hashVersion,
    ];
    if(strpos(url()->current(), 'login') === false && strpos(url()->current(), 'reset-password') === false) {
      $settings['user'] = auth()->user();
      $settings['structure_menu'] = $structureMenu;
      $settings['flatten_menu'] = $flattenMenu;
      $settings['permissions'] = session()->get('permissions');
    }
  @endphp
  {!! json_encode($settings) !!}
</script>
