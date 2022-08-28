<?php

use Carbon\Carbon;

class PermissionsTableSeeder extends CsvBaseSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tableName = config('permission.table_names.permissions');
        $dataSeeder = $this->seedFromCSV(base_path() . '/database/seeds/data/permissions_202006251303.csv');
        foreach ($dataSeeder as $value) {
            DB::table($tableName)->insert([
                'id' => $value['id'],
                'name' => $value['name'],
                'guard_name' => $value['guard_name'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }
        $this->command->info('Permissions seeded!');
    }
}
