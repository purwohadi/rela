<?php

namespace App\Rules;

use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\Validation\Rule;

class CheckUserExist implements Rule
{
    protected $isUsername = false;
    protected $username;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($username = null)
    {
      $this->username = $username;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
      $this->isUsername = $attribute == 'username';
      $passwordField = config('pwdskt.password_fieldname');
      $check = false;
      if($this->isUsername) {
        $check = User::where('v_userid', $value)->where('e_user_enable', 1)->first();
      }
      else {
        $user = User::where('v_userid', $this->username)
        ->where('e_user_enable', 1)
        ->first();

        if($user) {
          $plain = $value;  // will depend on the name of the input on the login form
          //check if password md5
          if(md5($plain) == $user->{$passwordField}) {
            return true;
          }
          $check = Hash::check($plain, config('pwdskt.password_hash')) || Hash::check($plain, $user->v_userpass);
        }
      }
      return $check;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->isUsername ? 'Username tidak ditemukan' : 'Password yang anda masukkan salah';
    }
}
