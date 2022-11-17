<?php

namespace Modules\Course\Entities\RelationshipTraits;

/**
 *
 */
trait CategoryCourseTrait
{
    public function Course()
    {
        return $this->hasMany(Course::class);
    }
}
