<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arr = [
            'read-permission',
            'create-permission',
            'update-permission',
            'delete-permission'
        ];

        for ($i=0; $i < count($arr); $i++) {
            Permission::create([
                'name' => $arr[$i],
                'guard_name' => 'api'
            ]);
        }
    }
}
