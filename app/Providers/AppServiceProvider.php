<?php

namespace App\Providers;

use Carbon\Carbon;
use App\Utils\MenuBuilder;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\LengthAwarePaginator;

class AppServiceProvider extends ServiceProvider
{
  public function register()
    {
        /**
         * Paginate a standard Laravel Collection.
         *
         * @param int $perPage
         * @param int $total
         * @param int $page
         * @param string $pageName
         * @return array
         */
        Collection::macro('paginate', function($perPage, $total = null, $page = null, $pageName = 'page') {
            $page = $page ?: LengthAwarePaginator::resolveCurrentPage($pageName);
            return new LengthAwarePaginator(
                $this->forPage($page, $perPage),
                $total ?: $this->count(),
                $perPage,
                $page,
                [
                    'path' => LengthAwarePaginator::resolveCurrentPath(),
                    'pageName' => $pageName,
                ]
            );
        });

        \Illuminate\Database\Query\Builder::macro('toRawSql', function () {
          return array_reduce($this->getBindings(), function ($sql, $binding) {
            return preg_replace('/\?/', is_numeric($binding) ? $binding : "'" . $binding . "'", $sql, 1);
          }, $this->toSql());
        });

        \Illuminate\Database\Eloquent\Builder::macro('toRawSql', function () {
          return ($this->getQuery()->toRawSql());
        });
    }

  /**
   * Bootstrap any application services.
   *
   * @return void
   */
  public function boot()
  {
    if (config('app.force_https')) {
      \URL::forceScheme('https');
    }

    ini_set('oci8.connection_class', env('APP_NAME', 'appname'));

    // default locale and timezone
    Carbon::setLocale(config('app.locale'));
    date_default_timezone_set(config('app.timezone'));

    View::composer('helpers.settings-json', function (\Illuminate\View\View $view) {
      if(!Str::endsWith(url()->current(), 'login') && !Str::endsWith(url()->current(), 'reset-password')) {
        $menu = new MenuBuilder();
        $view->with('flattenMenu', $menu->getMenus(true));
        $view->with('structureMenu', $menu->getMenus());
      }

      $view->with('hashVersion', $this->getHashVersion());
    });
  }

  protected function getHashVersion()
  {
    $commitHash = trim(exec('git log --pretty="%h" -n1 HEAD'));
    $commitDate = new \DateTime(trim(exec('git log -n1 --pretty=%ci HEAD')));
    $commitDate->setTimezone(new \DateTimeZone('UTC'));

    return sprintf('%s (%s)', $commitHash, $commitDate->format('Y-m-d H:i:s'));
  }
}
