<?php

namespace Modules\Course\Entities\RelationshipTraits;

use Modules\Course\Entities\Course;

/**
 *
 */
trait MentorCourseTrait
{
    public function User()
    {
        return $this->belongsTo(User::class);
    }

    public function Course()
    {
        return $this->belongsTo(Course::class);
    }
}
