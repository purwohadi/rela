<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Response;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Log;

class CaptchaServiceController extends Controller
{
  public function index()
  {
    return view('index');
  }

  public function capthcaFormValidate(Request $request)
  {
    $request->validate([
      'username' => 'required',
      'password' => 'required',
      'captcha' => 'required|captcha'
    ]);
  }

  public function reloadCaptcha()
  {
    $captcha = custom_captcha('flat', true);

    return response()->json(array_intersect_key($captcha, array_flip(['img', 'val'])));
  }

  public function readAudio(Request $request)
  {
    try {
      $audio = Crypt::decryptString($request->audio);
      $audio = base64_encode($audio);
      $angka = base64_decode($audio);
      $arr = str_split($angka);
      $base = '';
      $path = '/media/sound/captcha/';
      foreach ($arr as $snd) {
        $suara = public_path(). $path . $snd . '.mp3';
        $base .= file_get_contents($suara);
      }
      $headers = array('Content-type' => 'audio/mp3');
      return Response::make($base, 200, $headers);
    } catch (DecryptException $e) {
      return response()->json([
        'message' => 'Data tidak valid',
        'status' => 'error'
      ], 400);
    }
  }
}
