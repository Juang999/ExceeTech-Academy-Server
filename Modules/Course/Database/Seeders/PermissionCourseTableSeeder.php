<?php

namespace Modules\Course\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\{Permission, Role};

class PermissionCourseTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $permission = Permission::create([
            'name' => 'course.detail_course',
            'guard_name' => 'api'
        ]);

        Role::findByName('super-admin', 'api')->givePermissionTo($permission->name);
    }
}
