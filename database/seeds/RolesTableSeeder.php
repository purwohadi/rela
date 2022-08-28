<?php

use Carbon\Carbon;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends CsvBaseSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tableNames = config('permission.table_names');
        $dataSeeder = $this->seedFromCSV(base_path() . '/database/seeds/data/roles_202006251301.csv');
        foreach ($dataSeeder as $value) {
            DB::table($tableNames['roles'])->insert([
                'id' => $value['id'],
                'name' => $value['name'],
                'guard_name' => $value['guard_name'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }
        $this->command->info('Roles seeded!');

        $permissions = Permission::all()->pluck('name')->toArray();
        $role = Role::findByName('Super Admin');
        $role->syncPermissions($permissions);
        $this->command->info('Roles has synced permissions!');

        $user = User::first();
        $user->assignRole('Super Admin');
        $this->command->info('User has assign role!');
    }
}
