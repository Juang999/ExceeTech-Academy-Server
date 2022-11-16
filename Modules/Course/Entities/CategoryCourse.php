<?php

namespace Modules\Course\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Kalnoy\Nestedset\NodeTrait;

class CategoryCourse extends Model
{
    use HasFactory, NodeTrait;

    protected $guarded = ['id'];

}
