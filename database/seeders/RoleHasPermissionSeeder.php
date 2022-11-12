<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleHasPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arr = [
            'super-admin',
            'mentor',
            'client'
        ];

        for ($i=0; $i < count($arr); $i++) {
            $role = Role::findByName($arr[$i], 'api');

            $role->givePermissionTo(Permission::all());
        }

    }
}
