<?php

use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::first();
        factory(Profile::class, 1)->create([
            'user_id' => $user->id,
            'nrk' => $user->username,
            'email' => $user->email
        ]);
        $this->command->info('Profile seeded!');
    }
}
