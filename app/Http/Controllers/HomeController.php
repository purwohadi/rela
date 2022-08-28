<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('auth');
  }

  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function index()
  {
    return view('modules.landing.index');
  }

  public function clear()
  {
    if (auth()->user()->is_admin) {
      try {
        Artisan::call('cache:clear');
        echo '<pre>';
        print_r(Artisan::output());
        echo '<pre>';

        Artisan::call('config:clear');
        echo '<pre>';
        print_r(Artisan::output());
        echo '<pre>';

        Artisan::call('view:clear');
        echo '<pre>';
        print_r(Artisan::output());
        echo '<pre>';
        Log::info("All Clear, App Optimized");
        return 'All Clear';
      } catch (\Exception $e) {
        echo '<pre>';
        print_r($e->getMessage());
        echo '<pre>';
        return 'Something went wrong';
      }
    }

    return redirect(\App\Providers\RouteServiceProvider::HOME);
  }

  public function createPwdskt($password)
  {
    if (auth()->user()->is_admin) {
      try {
        Artisan::call('pwdskt:generate', ['password' => $password]);
        echo '<pre>';
        print_r(Artisan::output());
        echo '<pre>';
        return 'pwdskt created.';
      } catch (\Exception $e) {
        echo '<pre>';
        print_r($e->getMessage());
        echo '<pre>';
        return 'Something went wrong';
      }
    }

    return redirect(\App\Providers\RouteServiceProvider::HOME);
  }
}
