<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Profile;
use Faker\Generator as Faker;
use Webpatser\Uuid\Uuid;

$factory->define(Profile::class, function (Faker $faker) {
    return [
        'id' => Uuid::generate()->string,
        'user_id' => Uuid::generate()->string,
        'nrk' => getNumerify(6, $faker),
        'noktp' => getNumerify(16, $faker),
        'nama' => $faker->name,
        'email' => $faker->safeEmail,
        'nohp' => $faker->phoneNumber,
        'alamat' => $faker->address,
        'nip' => getNumerify(9, $faker),
        'nip18' => getNumerify(18, $faker),
        'kolok' => getNumerify(9, $faker),
        'nalokl' => 'DINAS KOMUNIKASI, INFORMATIKA DAN STATISTIK',
        'wilayah' => 'dinas',
        'klogad' => getNumerify(9, $faker),
        'kojab' => getNumerify(6, $faker),
        'najabl' => 'STAF TEKNIS TINGKAT AHLI',
        'kd' => 'S',
        'spmu' => 'C181',
        'kopang' => getNumerify(3, $faker),
        'napang' => 'PENATA MUDA TK.I',
        'gol' => 'III/B',
        'eselon' => '00',
        'neselon' => 'NON ESELON',
        'tmtesl' => null,
        'tmtpangkat' => null,
        'talhir' => $faker->date(),
        'pathir' => $faker->city,
        'kodeunit_sipkd' => getNumerify(8, $faker),
    ];
});
