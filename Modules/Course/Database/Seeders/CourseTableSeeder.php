<?php

namespace Modules\Course\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Course\Entities\Course;
use Modules\Course\Entities\DetailPriceCourse;

class CourseTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $courses = [
            [
                'title' => 'Basic Laravel Developer',
                'category_course_id' => 2,
                'description' => 'basic laravel developer',
                'meet' => 20,
                'price' => 100000
            ],[
                'title' => 'Basic Reactjs Developer',
                'category_course_id' => 3,
                'description' => 'basic reactjs developer',
                'meet' => 20,
                'price' => 100000
            ],[
                'title' => 'Basic React Native Developer',
                'category_course_id' => 4,
                'description' => 'basic react native developer',
                'meet' => 20,
                'price' => 100000
            ],[
                'title' => 'Basic Offensive Security Developer',
                'category_course_id' => 6,
                'description' => 'basic offensive security developer',
                'meet' => 20,
                'price' => 100000
            ],[
                'title' => 'Basic Deffensive Security Developer',
                'category_course_id' => 7,
                'description' => 'basic deffensive security developer',
                'meet' => 20,
                'price' => 100000
            ],[
                'title' => 'Basic Forensic Developer',
                'category_course_id' => 8,
                'description' => 'basic forensic developer',
                'meet' => 20,
                'price' => 100000
            ]
        ];

        foreach ($courses as $course) {
            $course = Course::create($course);

            DetailPriceCourse::create([
                'course_id' => $course->id,
                'sequence' => 1,
                'price' => $course->price
            ]);
        }
    }
}
