<?php

namespace Modules\Course\Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Course\Entities\MentorCourse;

class CourseDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call([
            CategoryCourseTableSeeder::class,
            CourseTableSeeder::class,
            PermissionCourseTableSeeder::class,
        ]);

        MentorCourse::factory()->count(User::role('mentor')->count())->create();
    }
}
