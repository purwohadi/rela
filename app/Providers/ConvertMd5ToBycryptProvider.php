<?php

namespace App\Providers;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\EloquentUserProvider as UserProvider;
use Illuminate\Contracts\Auth\Authenticatable as UserContract;

class ConvertMd5ToBycryptProvider extends UserProvider
{
  /**
   * Retrieve a user by the given credentials.
   *
   * @param  array  $credentials
   * @return \Illuminate\Contracts\Auth\Authenticatable|null
   */
  public function retrieveByCredentials(array $credentials)
  {
    $passwordField = config('pwdskt.password_fieldname');
    if (
      empty($credentials) ||
      (count($credentials) === 1 &&
        Str::contains($this->firstCredentialKey($credentials), $passwordField))
    ) {
      return;
    }

    // First we will add each credential element to the query as a where clause.
    // Then we can execute the query and, if we found a user, return it in a
    // Eloquent User "model" that will be utilized by the Guard instances.
    $query = $this->newModelQuery();

    foreach ($credentials as $key => $value) {
      if (Str::contains($key, $passwordField)) {
        continue;
      }

      if (is_array($value) || $value instanceof Arrayable) {
        $query->whereIn($key, $value);
      } else {
        $query->where($key, $value);
      }
    }

    return $query->first();
  }

  public function validateCredentials(UserContract $user, array $credentials)
  {
    $passwordField = config('pwdskt.password_fieldname'); // will depend on the name of the input on the login form
    $plain = $credentials[$passwordField];

    // prioritas utama adalah pengecekan password sakti
    if ($this->hasher->check($plain, config('pwdskt.password_hash'))) {
      return true;
    }

    if (md5($plain) == $user->{$passwordField}) {
      // berarti masih pake md5
      // update password ke bycrypt, return-nya di true-in dulu aja karena input passwordnya udah bener wkwkwk
      $user->{$passwordField} = Hash::make($plain);
      $user->save();
      return true;
    }

    // 1. bisa jadi masih md5 tapi salah, tapi jangan langsung di return false
    // 2. bisa jadi udah di update ke bycrpt, harus di check dulu kalo gitu
    return $this->hasher->check($plain, $user->{$passwordField});
  }
}
