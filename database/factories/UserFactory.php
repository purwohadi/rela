<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\User;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/
$factory->define(User::class, function (Faker $faker) {
    return [
        // 'username' => getNumerify(6, $faker),
        // 'email' => $faker->unique()->safeEmail,
        // 'email_verified_at' => now(),
        // 'password' => '$2y$10$ebxWGxrziLqyqP0zzhB72uQwEn9ge2snrUzT3E3N4Q4CZD3Z3Q6rW',
        // 'remember_token' => Str::random(10),

        'v_userid' => 'admin',
        'v_userpass' => '$2y$10$ebxWGxrziLqyqP0zzhB72uQwEn9ge2snrUzT3E3N4Q4CZD3Z3Q6rW',
        'v_username' => 'Super Admin',
        'e_user_enable' => 1,
    ];
});
