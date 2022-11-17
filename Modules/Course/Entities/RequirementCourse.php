<?php

namespace Modules\Course\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Course\Entities\RelationshipTraits\RequirementCourseTrait;

class RequirementCourse extends Model
{
    use HasFactory, RequirementCourseTrait;

    protected $fillable = [];
}
