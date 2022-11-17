<?php

namespace Modules\Course\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Course\Entities\RelationshipTraits\MentorCourseTrait;

class MentorCourse extends Model
{
    use HasFactory, MentorCourseTrait;

    protected $fillable = [];
}
