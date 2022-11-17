<?php

namespace Modules\Course\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Course\Entities\RelationshipTraits\CourseTrait;

class Course extends Model
{
    use HasFactory, CourseTrait;

    protected $fillable = [];
}
