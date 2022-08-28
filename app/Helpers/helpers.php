<?php

use Carbon\Carbon;
use App\Models\AuditTrails;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

if (! function_exists('encrypt_hashid')) {
  /**
   * Return the route to the "home" page depending on authentication/authorization status.
   *
   * @return string
   */
  function encrypt_hashid($id)
  {
		$length = config('hashslug.minSlugLength', 5);

    $alphabet = config('hashslug.alphabet', 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890');
    $salt = config('hashslug.appsalt', config('app.key'));
    $salt = hash('sha256', $salt);

    $hashIds = new \Hashids\Hashids($salt, $length, $alphabet);
    $temp = bin2hex($id);
    return $hashIds->encodeHex($temp);
  }
}

if (! function_exists('decrypt_hashid')) {
  /**
   * Return the route to the "home" page depending on authentication/authorization status.
   *
   * @return string
   */
  function decrypt_hashid($slug)
  {
		$length = config('hashslug.minSlugLength', 5);

    $alphabet = config('hashslug.alphabet', 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890');
    $salt = config('hashslug.appsalt', config('app.key'));
    $salt = hash('sha256', $salt);

    $hashIds = new \Hashids\Hashids($salt, $length, $alphabet);
		$decoded = $hashIds->decodeHex($slug);


		if(! isset($decoded)){
			return null;
		}

		return hex2bin($decoded);
  }
}

if (! function_exists('include_route_files')) {

  /**
   * Loops through a folder and requires all PHP files
   * Searches sub-directories as well.
   *
   * @param $folder
   */
  function include_route_files($folder)
  {
      try {
          $rdi = new recursiveDirectoryIterator($folder);
          $it = new recursiveIteratorIterator($rdi);

          while ($it->valid()) {
              if (! $it->isDot() && $it->isFile() && $it->isReadable() && $it->current()->getExtension() === 'php') {
                  require $it->key();
              }

              $it->next();
          }
      } catch (Exception $e) {
          echo $e->getMessage();
      }
  }
}

if (! function_exists('home_route')) {
    /**
     * Return the route to the "home" page depending on authentication/authorization status.
     *
     * @return string
     */
    function home_route()
    {
        // if (Gate::allows('access backend')) {
        if (Auth::check()) {
            return route('admin.home');
        }

        return route('home');
    }
}

if (! function_exists('image_template_url')) {
    /**
     * @param $template
     * @param $imagePath
     *
     * @return string
     */
    function image_template_url($template, $imagePath)
    {
        $imagePath = str_replace('/storage', '', $imagePath);

        return url(config('imagecache.route')."/{$template}{$imagePath}");
    }
}

if (! function_exists('localize_url')) {
    function localize_url($locale = null, $attributes = [], Model $translatable = null)
    {
        $url = null;

        if ($translatable && method_exists($translatable, 'getTranslation')) {
            /** @var \Spatie\Translatable\HasTranslations $translatable */
            if ($slug = $translatable->getTranslation('slug', $locale)) {
                $url = route(Route::current()->getName(), ['post' => $slug]);
            } else {
                $url = route('home');
            }
        }

        return LaravelLocalization::getLocalizedURL($locale, $url, $attributes, true);
    }
}

if (!function_exists("jsend_error")) {
  /**
   * @param string $message Error message
   * @param string $code Optional custom error code
   * @param string | array $data Optional data
   * @param int $status HTTP status code
   * @param array $extraHeaders
   * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
   */
  function jsend_error($message, $code = null, $data = null, $status = 500, $extraHeaders = [])
  {
      $response = [
          "status" => "error",
          "message" => $message
      ];
      !is_null($code) && $response['code'] = $code;
      !is_null($data) && $response['data'] = $data;
      return response()->json($response, $status, $extraHeaders);
  }
}

if (!function_exists("jsend_fail")) {
  /**
   * @param array $data
   * @param int $status HTTP status code
   * @param array $extraHeaders
   * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
   */
  function jsend_fail($data, $message=null, $status = 400, $extraHeaders = [])
  {
      $response = [
          "status" => "fail",
          "data" => $data
      ];
      !is_null($message) && $response['message'] = $message;

      return response()->json($response, $status, $extraHeaders);
  }
}

if (!function_exists("jsend_success")) {
  /**
   * @param array | Illuminate\Database\Eloquent\Model $data
   * @param int $status HTTP status code
   * @param array $extraHeaders
   * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
   */
  function jsend_success($data, $message=null, $status = 200, $extraHeaders = [])
  {
      $response = [
          "status" => "success",
          "data" => $data
      ];
      !is_null($message) && $response['message'] = $message;
      return response()->json($response, $status, $extraHeaders);
  }
}

if (!function_exists("getNumerify")) {
  /**
   * @param integer $length
   * @param \Faker\Generator $faker
   * @return serial_number
   */
  function getNumerify($length, $faker)
  {
    $numerify = $faker->numerify(str_pad('#', $length, '#', STR_PAD_LEFT));
    return str_pad($numerify, $length, '0', STR_PAD_LEFT);
  }
}

if (!function_exists("getIp")) {
  /**
   * Get IP address.
   *
   */
  function getIp() {
    foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key) {
      if (array_key_exists($key, $_SERVER) === true) {
        foreach (explode(',', $_SERVER[$key]) as $ip) {
          $ip = trim($ip); // just to be safe
          if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false) {
            return $ip;
          }
        }
      }
    }
    return request()->ip(); // it will return server ip when no client ip found
  }
}

if (!function_exists("createLog")) {
  /**
   * Store a newly created log.
   *
   */
  function createLog($table, $aksi, $data)
  {
    $user_id = auth()->user()->v_userid;
    AuditTrails::create([
      'v_user_aksi' => $user_id,
      'v_ip_user' => getIp(),
      'e_jenis_aksi' => $aksi,
      'v_nama_tabel' => $table,
      'tx_data' => json_encode($data),
    ]);
  }
}

if (!function_exists('custom_captcha')) {
  /**
   * @param string $config
   * @return array|ImageManager|mixed
   * @throws Exception
   */
  function custom_captcha(string $config = 'default', $api = false)
  {
    return app('captcha')->createCaptcha($config, $api);
  }
}

if (!function_exists('check_captcha')) {
  /**
   * @param string $string
   * @return bool
   */
  function check_captcha(string $string)
  {
    return app('captcha')->checkCaptcha($string);
  }
}

if (!function_exists('str_is')) {
  /**
   * Determine if a given string matches a given pattern.
   *
   * @param  string|array  $pattern
   * @param  string  $value
   * @return bool
   */
  function str_is($pattern, $value)
  {
    return Str::is($pattern, $value);
  }
}

if (!function_exists('get_triwulan')) {
  /**
   * Determine if a given string matches a given pattern.
   *
   * @param  string|array  $pattern
   * @param  string  $value
   * @return bool
   */
  function get_triwulan()
  {
    $triwulan = [
      'tw1' => [1, 3],
      'tw2' => [4, 6],
      'tw3' => [7, 9],
      'tw4' => [10, 12],
    ];
    return $triwulan;
  }
}

if (!function_exists('encrypt_params')) {
  function encrypt_params($id)
  {
    $length = 5;

    $salt = base64_encode(config('app.name'));

    $hashIds = new \Hashids\Hashids($salt, $length);
    $temp = bin2hex($id);
    return $hashIds->encodeHex($temp);
  }
}

if (!function_exists('decrypt_params')) {
  function decrypt_params($id)
  {
    $length = 5;

    $salt = base64_encode(config('app.name'));

    $hashIds = new \Hashids\Hashids($salt, $length);
    $decoded = $hashIds->decodeHex($id);

    if (!isset($decoded)) {
      return null;
    }
    return hex2bin($decoded);
  }
}

if (!function_exists('file_path')) {
  function file_path($date, $id)
  {
    $dateFormat = new Carbon($date);
    $file_path = 'public/';
    return Storage::path($file_path . $dateFormat->format('Y/m/d') . '/' . $id);
  }
}


/**
 * Translate prepared statement to ready execute statement
 */
if (!function_exists('getQueries')) {
  function getQueries($builder)
  {
    $addSlashes = str_replace('?', "'?'", $builder->toSql());
    return vsprintf(str_replace('?', '%s', $addSlashes), $builder->getBindings());
  }
}
