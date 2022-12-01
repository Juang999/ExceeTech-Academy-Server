<?php

namespace Modules\Course\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MentorCourseFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\Course\Entities\MentorCourse::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => mt_rand(1, 13),
            'course_id' => mt_rand(1, 6),
            'sequence' => 0
        ];
    }
}

