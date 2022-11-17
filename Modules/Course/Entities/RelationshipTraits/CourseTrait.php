<?php

namespace Modules\Course\Entities\RelationshipTraits;

use Modules\Course\Entities\MentorCourse;
use Modules\Course\Entities\RequirementCourse;

/**
 *
 */
trait CourseTrait
{
    public function CategoryCourse()
    {
        return $this->belongsTo(CategoryCourse::class);
    }

    public function DetailPriceCourse()
    {
        return $this->hasMany(DetailPriceCourse::class);
    }

    public function MentorCourse()
    {
        return $this->hasMany(MentorCourse::class);
    }

    public function RequirementCourse()
    {
        return $this->hasMany(RequirementCourse::class);
    }
}

