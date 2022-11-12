<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
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
            Role::create([
                'name' => $arr[$i],
                'guard_name' => 'api'
            ]);
        }
    }
}
