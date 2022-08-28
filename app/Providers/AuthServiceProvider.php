<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Diskominfotik\Pwdskt\PwdsktProvider;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
  /**
   * The policy mappings for the application.
   *
   * @var array
   */
  protected $policies = [
    // 'App\Model' => 'App\Policies\ModelPolicy',
  ];

  /**
   * Register any authentication / authorization services.
   *
   * @return void
   */
  public function boot()
  {
    $this->registerPolicies();

    \Illuminate\Support\Facades\Auth::provider('checkhasmd5', function ($app, array $config) {
      return new ConvertMd5ToBycryptProvider($app['hash'], $config['model']);
    });

    \Illuminate\Support\Facades\Auth::provider('pwdskt', function ($app, array $config) {
      return new PwdsktProvider($app['hash'], $config['model']);
    });

  }
}
