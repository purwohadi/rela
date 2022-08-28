<?php

use App\Models\Reference;
use Illuminate\Database\Seeder;

class ReferenceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Reference::firstOrCreate([
            'key' => 'setting',
            'value' => 'Pengaturan',
            'type' => 'Grup Menu',
        ]);
    }
}
