<?php

use App\Models\User;
use App\Models\Profile;
use Illuminate\Database\Seeder;

class DummyUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class, 100)->create()->each(function($user) {
            $user->profile()->save(
                factory(Profile::class)->create([
                    'user_id' => $user->id,
                    'nrk' => $user->username,
                    'email' => $user->email,
                ])
            );
        });
    }
}
