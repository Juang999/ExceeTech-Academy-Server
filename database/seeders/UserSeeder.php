<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arr = [
            [
                'name' => 'super-admin',
                'username' => 'super-admin',
                'phone_number' => 628123456743,
                'email' => 'superadmin@exceetech.com',
                'password' => 'adminadmin',
                'role' => 'super-admin'
            ],[
                'name' => 'mentor',
                'username' => 'mentor',
                'phone_number' => 628765434567,
                'email' => 'mentor@exceetech.com',
                'password' => 'mentor',
                'role' => 'mentor'
            ],[
                'name' => 'client',
                'username' => 'client',
                'phone_number' => 628567654312,
                'email' => 'client@exceetech.com',
                'password' => 'clientclient',
                'role' => 'client'
            ]
        ];

        for ($i=0; $i < count($arr); $i++) {
            $user = User::create([
                'name' => $arr[$i]['name'],
                'username' => $arr[$i]['username'],
                'phone_number' => $arr[$i]['phone_number'],
                'email_verified_at' => Carbon::now()->locale('Id'),
                'email' => $arr[$i]['email'],
                'password' => Hash::make($arr[$i]['password'])
            ]);

            $user->assignRole($arr[$i]['role']);
        }
    }
}
