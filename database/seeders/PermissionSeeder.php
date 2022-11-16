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
            'user.read',
            'user.create',
            'user.update',
            'user.delete',
            'role.read',
            'role.create',
            'role.update',
            'role.delete',
            'permission.read',
            'permission.create',
            'permission.update',
            'permission.delete',
            'category_course.read',
            'category_course.create',
            'category_course.update',
            'category_course.delete',
        ];

        for ($i=0; $i < count($arr); $i++) {
            Permission::create([
                'name' => $arr[$i],
                'guard_name' => 'api'
            ]);
        }
    }
}
