<?php

namespace Modules\Course\Entities\RelationshipTraits;

/**
 *
 */
trait DetailPriceCourseTrait
{
    public function Course()
    {
        return $this->belongsTo(Course::class);
    }
}
