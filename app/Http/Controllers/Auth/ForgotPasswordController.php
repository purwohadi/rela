<?php

namespace App\Http\Controllers\Auth;

use Carbon\Carbon;
use App\Models\User;
use App\Mail\ResetPassword;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class ForgotPasswordController extends Controller
{
  /*
  |--------------------------------------------------------------------------
  | Password Reset Controller
  |--------------------------------------------------------------------------
  |
  | This controller is responsible for handling password reset emails and
  | includes a trait which assists in sending these notifications from
  | your application to your users. Feel free to explore this trait.
  |
  */

  use SendsPasswordResetEmails;

  public function resetPassword(Request $request)
  {
    $params = json_decode(decrypt_params($request->id));
    $getUser = User::find($params->nrk);
    if($getUser) {
      if ($getUser->is_common_user) {
        $token = Str::random(64);
        DB::table('password_resets')->updateOrInsert(
          ['email' => $params->email],
          [
            'token' => $token,
            'created_at' => Carbon::now()
          ]
        );

        if($params->email == $getUser->email) {
          $user = $getUser->v_username;
          Mail::to($params->email)->send(new ResetPassword(['user' => $user, 'token' => $token]));

          // check for failures
          if (Mail::failures()) {
            return [
              'status' => 'error',
              'message' => 'Reset password gagal dikirim!'
            ];
          }
          else {
            $message = [
              'status' => 'success',
              'message' => 'Email reset password berhasil dikirim'
            ];
          }
        }
        else {
          $message = [
            'status' => 'error',
            'message' => 'Email dan NRK tidak sesuai!'
          ];
        }
      } else {
        $message = [
          'status' => 'error',
          'message' => 'User tersebut merupakan user Admin PD/SKPD, silakan hubungi <strong>Helpdesk BKD/Suban</strong>'
        ];
      }
    }
    else {
      $message = [
        'status' => 'error',
        'message' => 'User tidak ditemukan!'
      ];
    }
    return $message;
  }
}
