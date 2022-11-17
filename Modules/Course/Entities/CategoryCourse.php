<?php

namespace Modules\Course\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Kalnoy\Nestedset\NodeTrait;
use Modules\Course\Entities\RelationshipTraits\CategoryCourseTrait;

class CategoryCourse extends Model
{
    use HasFactory, NodeTrait, CategoryCourseTrait;

    protected $guarded = ['id'];
}
