<?php

namespace Modules\Course\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Course\Entities\CategoryCourse;

class CategoryCourseTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $categories = [
            [
                'name' => 'Programmer',
                'children' => [
                    ['name' => 'Backend Developer'],
                    ['name' => 'Frontend Developer'],
                    ['name' => 'Mobile Developer'],
                ]
            ],[
                'name' => 'Cyber Security',
                'children' => [
                    ['name' => 'Offensive Security'],
                    ['name' => 'Deffensive Security'],
                    ['name' => 'Forensic']
                ]
            ]
        ];

        foreach ($categories as $category) {
            CategoryCourse::create($category);
        }
    }
}
