<?php

namespace Modules\Course\Entities\RelationshipTraits;

/**
 *
 */
trait RequirementCourseTrait
{
    public function Course()
    {
        return $this->belongsTo(Course::class);
    }
}
