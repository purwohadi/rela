<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserSeeder::class);
        // $this->call(ProfileSeeder::class);

        // $this->call(PermissionsTableSeeder::class);
        $this->call(ReferenceTableSeeder::class);
        $this->call(MenuTableSeeder::class);
        // $this->call(RolesTableSeeder::class);
    }
}
