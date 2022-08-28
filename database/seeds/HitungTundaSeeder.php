<?php

use App\Models\ReferensiUmum;
use Illuminate\Database\Seeder;

class HitungTundaSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $data = [
      [
        'v_key' => 'is_active',
        'v_value' => 'true',
        'v_type' => 'Hitung Tunda',
        'v_created_by' => 'seeder',
        'dt_created_at' => now(),
      ],
      [
        'v_key' => 'unit_ignore',
        'v_value' => '000000104',
        'v_type' => 'Hitung Tunda',
        'v_created_by' => 'seeder',
        'dt_created_at' => now(),
      ]
    ];

    foreach ($data as $value) {
      ReferensiUmum::create($value);
    }
  }
}
