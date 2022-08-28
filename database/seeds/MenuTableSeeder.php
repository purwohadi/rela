<?php

use Carbon\Carbon;

class MenuTableSeeder extends CsvBaseSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tableName = config('tables.master.menu');
        $dataSeeder = $this->seedFromCSV(base_path() . '/database/seeds/data/menu_202006251304.csv');
        foreach ($dataSeeder as $value) {
            DB::table($tableName)->insert([
                'id' => $value['id'],
                'group' => $value['group'],
                'label' => $value['label'],
                'icon' => $value['icon'],
                'tags' => $value['tags'],
                'route' => $value['route'],
                'parent' => $value['parent'] ? $value['parent'] : NULL,
                'order_no' => $value['order_no'],
                'permission_id' => $value['permission_id'],
                'visible' => $value['visible'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }

        $this->command->info('Menu seeded!');
    }
}
